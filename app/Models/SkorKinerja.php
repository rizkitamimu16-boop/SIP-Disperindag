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

        $kegiatan = LaporanKegiatan::where('pegawai_id', $pegawaiId)
            ->whereYear('tanggal', $year)
            ->whereMonth('tanggal', $month)
            ->where('status_verifikasi', 'Disetujui')
            ->get();

        $nilaiProduktivitas = 0;
        $nilaiKualitas = 0;
        if ($kegiatan->count() > 0) {
            $nilaiProduktivitas = $kegiatan->avg('nilai_produktivitas');
            $nilaiKualitas = $kegiatan->avg('nilai_kualitas');
        }

        $pengaturan = \App\Models\PengaturanKantor::getPengaturan();
        $wKehadiran = $pengaturan->bobot_kehadiran / 100;
        $wProduktivitas = $pengaturan->bobot_produktivitas / 100;
        $wKualitas = $pengaturan->bobot_kualitas / 100;

        if ($presensi->count() == 0 && $kegiatan->count() == 0) {
            $nilaiAkhir = 0;
        } else {
            $nilaiAkhir = ($nilaiKehadiran * $wKehadiran) + ($nilaiProduktivitas * $wProduktivitas) + ($nilaiKualitas * $wKualitas);
        }

        if ($nilaiAkhir >= 90) {
            $kategori = 'Sangat Baik';
        } elseif ($nilaiAkhir >= 80) {
            $kategori = 'Baik';
        } elseif ($nilaiAkhir >= 70) {
            $kategori = 'Cukup';
        } else {
            $kategori = 'Kurang';
        }

        $scoreData = new self();
        $scoreData->pegawai_id = $pegawaiId;
        $scoreData->periode = $periode;
        $scoreData->nilai_kehadiran = $nilaiKehadiran;
        $scoreData->nilai_produktivitas = $nilaiProduktivitas;
        $scoreData->nilai_kualitas = $nilaiKualitas;
        $scoreData->nilai_akhir = $nilaiAkhir;
        $scoreData->kategori = $kategori;
        return $scoreData;
    }
}
