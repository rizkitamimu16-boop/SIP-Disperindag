<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SkorKinerja extends Model
{
    use HasFactory;

    protected $table = 'skor_kinerja';

    protected $fillable = [
        'pegawai_id',
        'periode',
        'nilai_kehadiran',
        'nilai_produktivitas',
        'nilai_kualitas',
        'bobot_kehadiran',
        'bobot_produktivitas',
        'bobot_kualitas',
        'nilai_akhir',
        'kategori',
        'status',
        'rekomendasi_kontrak',
    ];

    protected function casts(): array
    {
        return [
            'nilai_kehadiran'     => 'float',
            'nilai_produktivitas' => 'float',
            'nilai_kualitas'      => 'float',
            'bobot_kehadiran'     => 'float',
            'bobot_produktivitas' => 'float',
            'bobot_kualitas'      => 'float',
            'nilai_akhir'         => 'float',
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

    public function getPredikatAttribute(): ?string
    {
        return $this->kategori;
    }

    public static function calculateLiveScore($pegawaiId, $periode)
    {
        $year = \Carbon\Carbon::parse($periode)->year;
        $month = \Carbon\Carbon::parse($periode)->month;

        $presensi = Presensi::where('pegawai_id', $pegawaiId)
            ->whereYear('tanggal', $year)
            ->whereMonth('tanggal', $month)
            ->get();
            
        $alphaCount = $presensi->where('status', 'Alpha')->count();
        $terlambatCount = $presensi->where('status', 'Terlambat')->count();
        
        $nilaiKehadiran = 0;
        if ($presensi->count() > 0) {
            $nilaiKehadiran = max(0, 100 - ($alphaCount * 5) - ($terlambatCount * 2));
        }

        $allKegiatan = LaporanKegiatan::where('pegawai_id', $pegawaiId)
            ->whereYear('tanggal', $year)
            ->whereMonth('tanggal', $month)
            ->get();

        $kegiatanDisetujui = $allKegiatan->where('status_verifikasi', 'Disetujui');

        $nilaiProduktivitas = 0;
        $nilaiKualitas = 0;
        $statusKinerja = 'Final';

        if ($allKegiatan->count() > 0) {
            $nilaiProduktivitas = $allKegiatan->avg('nilai_produktivitas') ?? 0;
            
            // Cek laporan yang disetujui
            $ratedKegiatan = $kegiatanDisetujui->where('nilai_kualitas', '>', 0);
            if ($ratedKegiatan->count() > 0) {
                $nilaiKualitas = $ratedKegiatan->avg('nilai_kualitas');
            }

            // Jika ada kegiatan yang belum dinilai kualitasnya atau menunggu review (PRD §28)
            $adaBelumDinilai = $allKegiatan->where('status_verifikasi', 'Menunggu Review')->count() > 0
                || ($kegiatanDisetujui->count() > 0 && $kegiatanDisetujui->where('nilai_kualitas', '<=', 0)->count() > 0);

            if ($adaBelumDinilai) {
                $statusKinerja = 'Belum Lengkap';
            }
        }

        $pengaturan = \App\Models\PengaturanKantor::getPengaturan();
        $wKehadiran = ($pengaturan->bobot_kehadiran ?? 60.00) / 100;
        $wProduktivitas = ($pengaturan->bobot_produktivitas ?? 25.00) / 100;
        $wKualitas = ($pengaturan->bobot_kualitas ?? 15.00) / 100;

        if ($presensi->count() == 0 && $allKegiatan->count() == 0) {
            $nilaiAkhir = 0;
        } else {
            $nilaiAkhir = round(($nilaiKehadiran * $wKehadiran) + ($nilaiProduktivitas * $wProduktivitas) + ($nilaiKualitas * $wKualitas), 2);
        }

        if ($nilaiAkhir >= 90) {
            $kategori = 'Sangat Baik';
            $rekomendasi = 'Diperpanjang';
        } elseif ($nilaiAkhir >= 80) {
            $kategori = 'Baik';
            $rekomendasi = 'Diperpanjang';
        } elseif ($nilaiAkhir >= 70) {
            $kategori = 'Cukup';
            $rekomendasi = 'Dipertimbangkan';
        } else {
            $kategori = 'Kurang';
            $rekomendasi = 'Tidak Diperpanjang';
        }

        $scoreData = new self();
        $scoreData->pegawai_id = $pegawaiId;
        $scoreData->periode = $periode;
        $scoreData->nilai_kehadiran = (float) $nilaiKehadiran;
        $scoreData->nilai_produktivitas = (float) $nilaiProduktivitas;
        $scoreData->nilai_kualitas = (float) $nilaiKualitas;
        $scoreData->nilai_akhir = (float) $nilaiAkhir;
        $scoreData->kategori = $kategori;
        $scoreData->status = $statusKinerja;
        $scoreData->rekomendasi_kontrak = $rekomendasi;
        return $scoreData;
    }

    public static function simpanAtauPerbarui($pegawaiId, $periode): self
    {
        $live = self::calculateLiveScore($pegawaiId, $periode);
        $pengaturan = \App\Models\PengaturanKantor::getPengaturan();

        return self::updateOrCreate(
            [
                'pegawai_id' => $pegawaiId,
                'periode'    => $periode,
            ],
            [
                'nilai_kehadiran'     => $live->nilai_kehadiran,
                'nilai_produktivitas' => $live->nilai_produktivitas,
                'nilai_kualitas'      => $live->nilai_kualitas,
                'bobot_kehadiran'     => $pengaturan->bobot_kehadiran ?? 60.00,
                'bobot_produktivitas' => $pengaturan->bobot_produktivitas ?? 25.00,
                'bobot_kualitas'      => $pengaturan->bobot_kualitas ?? 15.00,
                'nilai_akhir'         => $live->nilai_akhir,
                'kategori'            => $live->kategori,
                'status'              => $live->status === 'Belum Lengkap' ? 'Draft' : 'Final',
                'rekomendasi_kontrak' => $live->rekomendasi_kontrak,
            ]
        );
    }
}
