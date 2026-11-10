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
        $isDaily = (strlen($periode) === 10);
        $pengaturan = \App\Models\PengaturanKantor::getPengaturan();
        $wKehadiran = ($pengaturan->bobot_kehadiran ?? 60.00) / 100;
        $wProduktivitas = ($pengaturan->bobot_produktivitas ?? 25.00) / 100;
        $wKualitas = ($pengaturan->bobot_kualitas ?? 15.00) / 100;

        if ($isDaily) {
            $targetDate = $periode;
            $presensi = Presensi::where('pegawai_id', $pegawaiId)
                ->where('tanggal', $targetDate)
                ->first();

            // Cek juga pengajuan izin yang disetujui pada hari itu
            $izin = PengajuanIzin::where('pegawai_id', $pegawaiId)
                ->where('status', 'Disetujui')
                ->whereDate('tanggal_mulai', '<=', $targetDate)
                ->whereDate('tanggal_selesai', '>=', $targetDate)
                ->first();

            $nilaiKehadiran = 0;
            if ($izin) {
                $nilaiKehadiran = 100.0; // Dispensasi resmi
            } elseif ($presensi) {
                if ($presensi->status === 'Hadir') {
                    $nilaiKehadiran = 100.0;
                    // Jika tanggal sudah lewat dari hari ini dan tidak ada absen pulang
                    if ($presensi->tanggal < \Carbon\Carbon::today()->toDateString() && empty($presensi->jam_pulang)) {
                        $nilaiKehadiran = 90.0; // Penalti tidak absen pulang
                    }
                } elseif ($presensi->status === 'Terlambat') {
                    $nilaiKehadiran = 85.0; // Penalti terlambat
                    if ($presensi->tanggal < \Carbon\Carbon::today()->toDateString() && empty($presensi->jam_pulang)) {
                        $nilaiKehadiran = 75.0;
                    }
                } elseif (in_array($presensi->status, ['Izin', 'Cuti', 'Sakit', 'Dinas Luar'])) {
                    $nilaiKehadiran = 100.0;
                } else {
                    $nilaiKehadiran = 0.0; // Alpha
                }
            } else {
                $nilaiKehadiran = 0.0; // Belum hadir / Alpha
            }

            // Laporan kegiatan pada hari tersebut
            $kegiatans = LaporanKegiatan::where('pegawai_id', $pegawaiId)
                ->where('tanggal', $targetDate)
                ->get();

            $nilaiProduktivitas = 0;
            $nilaiKualitas = 0;
            if ($kegiatans->count() > 0) {
                $nilaiProduktivitas = min(100.0, (float)($kegiatans->avg('nilai_produktivitas') ?? 0));
                
                $rated = $kegiatans->where('status_verifikasi', 'Disetujui')->where('nilai_kualitas', '>', 0);
                if ($rated->count() > 0) {
                    $nilaiKualitas = (float)$rated->avg('nilai_kualitas');
                } else {
                    $nilaiKualitas = $nilaiProduktivitas;
                }
            }

            $nilaiAkhir = round(($nilaiKehadiran * $wKehadiran) + ($nilaiProduktivitas * $wProduktivitas) + ($nilaiKualitas * $wKualitas), 2);

        } else {
            // Mode Bulanan (YYYY-MM)
            $year = \Carbon\Carbon::parse($periode)->year;
            $month = \Carbon\Carbon::parse($periode)->month;

            // Hitung jumlah hari kerja aktif yang sudah terekam di sistem pada bulan tersebut
            $workDaysInOffice = Presensi::whereYear('tanggal', $year)
                ->whereMonth('tanggal', $month)
                ->distinct('tanggal')
                ->count('tanggal');
            
            $targetHariKerja = max($workDaysInOffice, 1);

            $presensiList = Presensi::where('pegawai_id', $pegawaiId)
                ->whereYear('tanggal', $year)
                ->whereMonth('tanggal', $month)
                ->get();

            $hadirCount = $presensiList->where('status', 'Hadir')->count();
            $terlambatCount = $presensiList->where('status', 'Terlambat')->count();
            $dispensasiCount = $presensiList->whereIn('status', ['Izin', 'Cuti', 'Sakit', 'Dinas Luar'])->count();
            $alphaExplicitCount = $presensiList->where('status', 'Alpha')->count();

            // Cek kehadiran tanpa absen pulang pada hari-hari yang telah lewat
            $tidakPulangCount = $presensiList->whereIn('status', ['Hadir', 'Terlambat'])
                ->whereNull('jam_pulang')
                ->where('tanggal', '<', \Carbon\Carbon::today()->toDateString())
                ->count();

            // Total hari pegawai hadir atau memiliki dispensasi sah
            $totalHariHadir = $hadirCount + $terlambatCount + $dispensasiCount;

            // Base kehadiran berdasarkan rasio hari kerja aktif yang berjalan
            $rasioKehadiran = min(100.0, ($totalHariHadir / $targetHariKerja) * 100);

            // Pengurangan poin: Terlambat (-2), Tidak Absen Pulang (-2), Alpha eksplisit (-5)
            $penalti = ($terlambatCount * 2) + ($tidakPulangCount * 2) + ($alphaExplicitCount * 5);
            $nilaiKehadiran = max(0.0, round($rasioKehadiran - $penalti, 2));

            // Laporan kegiatan bulan tersebut
            $allKegiatan = LaporanKegiatan::where('pegawai_id', $pegawaiId)
                ->whereYear('tanggal', $year)
                ->whereMonth('tanggal', $month)
                ->get();

            $nilaiProduktivitas = 0;
            $nilaiKualitas = 0;
            if ($allKegiatan->count() > 0) {
                $avgProd = $allKegiatan->avg('nilai_produktivitas') ?? 0;
                // Rasio ketercapaian target laporan (dibandingkan hari kerja aktif berjalan)
                $rasioTargetLaporan = min(1.0, $allKegiatan->count() / $targetHariKerja);
                $nilaiProduktivitas = round($avgProd * $rasioTargetLaporan, 2);

                $kegiatanDisetujui = $allKegiatan->where('status_verifikasi', 'Disetujui')->where('nilai_kualitas', '>', 0);
                if ($kegiatanDisetujui->count() > 0) {
                    $nilaiKualitas = round((float)$kegiatanDisetujui->avg('nilai_kualitas'), 2);
                } else {
                    $nilaiKualitas = $nilaiProduktivitas;
                }
            }

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
        $scoreData->status = 'Final';
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
