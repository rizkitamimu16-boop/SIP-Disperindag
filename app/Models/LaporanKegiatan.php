<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LaporanKegiatan extends Model
{
    use HasFactory;

    protected $table = 'laporan_kegiatan';

    protected $fillable = [
        'pegawai_id',
        'tanggal',
        'nama_kegiatan',
        'deskripsi',
        'foto',
        'surat_tugas',
        'waktu_kirim',
        'nilai_produktivitas',
        'kategori_produktivitas',
        'nilai_kualitas',
        'kategori_kualitas',
        'catatan_kualitas',
        'status_verifikasi',
    ];

    protected function casts(): array
    {
        return [
            'tanggal'             => 'date',
            'nilai_produktivitas' => 'float',
            'nilai_kualitas'      => 'float',
        ];
    }

    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }

    public function employee(): BelongsTo
    {
        return $this->pegawai();
    }

    /**
     * Hitung skor produktivitas berdasarkan 4 subindikator PRD (§23):
     * 1. Kelengkapan Laporan (25%)
     * 2. Bukti Kegiatan / Foto (25%)
     * 3. Ketepatan Waktu Pelaporan (20%)
     * 4. Jumlah Kegiatan vs Target (30%)
     *
     * @return array{nilai: float, kategori: string, rincian: array}
     */
    public static function hitungProduktivitas(array $data, int $pegawaiId): array
    {
        // 1. Kelengkapan Laporan (25%)
        $skorKelengkapan = 0;
        if (!empty($data['nama_kegiatan'])) {
            $skorKelengkapan += 5;
        }
        if (!empty($data['tanggal'])) {
            $skorKelengkapan += 5;
        }
        if (!empty($data['deskripsi'])) {
            $deskripsiLen = strlen(trim($data['deskripsi']));
            if ($deskripsiLen >= 20) {
                $skorKelengkapan += 15;
            } elseif ($deskripsiLen > 0) {
                $skorKelengkapan += 10;
            }
        }

        // 2. Bukti Kegiatan (25%)
        $skorBukti = !empty($data['foto']) ? 25 : 0;

        // 3. Ketepatan Waktu Pelaporan (20%)
        $tanggalKegiatan = !empty($data['tanggal']) ? \Carbon\Carbon::parse($data['tanggal'])->toDateString() : \Carbon\Carbon::today()->toDateString();
        $hariIni = \Carbon\Carbon::today()->toDateString();
        
        $selisihHari = abs((int) \Carbon\Carbon::parse($tanggalKegiatan)->diffInDays(\Carbon\Carbon::parse($hariIni)));

        if ($tanggalKegiatan === $hariIni) {
            $skorKetepatan = 20; // Tepat waktu hari H
        } elseif ($selisihHari === 1 && \Carbon\Carbon::parse($tanggalKegiatan)->lt(\Carbon\Carbon::parse($hariIni))) {
            $skorKetepatan = 10; // Terlambat 1 hari (H+1)
        } else {
            $skorKetepatan = 0; // > H+1 atau tanggal mendatang
        }

        // 4. Jumlah Kegiatan terhadap Target (30%)
        // Target harian: minimal 1 kegiatan terlapor
        $existingCount = self::where('pegawai_id', $pegawaiId)
            ->where('tanggal', $tanggalKegiatan)
            ->count();
        $totalKegiatan = $existingCount + 1;
        $targetHarian = 1;
        $skorJumlah = min(30, round(($totalKegiatan / $targetHarian) * 30, 2));

        $nilaiTotal = min(100.00, round($skorKelengkapan + $skorBukti + $skorKetepatan + $skorJumlah, 2));

        // Kategori sesuai PRD §24
        if ($nilaiTotal >= 90) {
            $kategori = 'Sangat Baik';
        } elseif ($nilaiTotal >= 80) {
            $kategori = 'Baik';
        } elseif ($nilaiTotal >= 70) {
            $kategori = 'Cukup';
        } else {
            $kategori = 'Kurang';
        }

        return [
            'nilai'     => (float) $nilaiTotal,
            'kategori'  => $kategori,
            'rincian'   => [
                'kelengkapan'     => $skorKelengkapan,
                'bukti'           => $skorBukti,
                'ketepatan_waktu' => $skorKetepatan,
                'jumlah_kegiatan' => $skorJumlah,
            ]
        ];
    }
}
