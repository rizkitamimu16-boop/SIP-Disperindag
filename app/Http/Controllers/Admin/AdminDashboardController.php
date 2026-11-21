<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LaporanKegiatan;
use App\Models\Pegawai;
use App\Models\PengajuanIzin;
use App\Models\PengaturanKantor;
use App\Models\Presensi;
use Carbon\Carbon;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        $today = Carbon::today()->toDateString();
        $user = auth()->user();
        $isKabid = $user ? $user->isKabid() : false;
        $kabidBidang = $isKabid ? $user->bidang : null;

        // Base queries scoped by Bidang jika login sebagai Kabid
        $pegawaiQuery = Pegawai::query();
        $presensiQuery = Presensi::query();
        $izinQuery = PengajuanIzin::query();
        $kegiatanQuery = LaporanKegiatan::query();

        if ($isKabid) {
            $pegawaiQuery->where('bidang', $kabidBidang);
            $presensiQuery->whereHas('pegawai', fn($q) => $q->where('bidang', $kabidBidang));
            $izinQuery->whereHas('pegawai', fn($q) => $q->where('bidang', $kabidBidang));
            $kegiatanQuery->whereHas('pegawai', fn($q) => $q->where('bidang', $kabidBidang));
        }

        $totalPegawai = (clone $pegawaiQuery)->count();
        $hadirHariIni = (clone $presensiQuery)->where('tanggal', $today)->whereIn('status', ['Hadir', 'Terlambat'])->count();
        $izinSakitCuti = (clone $presensiQuery)->where('tanggal', $today)->whereIn('status', ['Izin', 'Cuti', 'Sakit'])->count();
        $dinasLuar = (clone $presensiQuery)->where('tanggal', $today)->where('status', 'Dinas Luar')->count();

        $pendingPengajuanCount = (clone $izinQuery)->where('status', 'Menunggu Review')->count();
        $pendingKegiatanCount = (clone $kegiatanQuery)->where('status_verifikasi', 'Menunggu Review')->count();
        $pendingTugasLapanganCount = (clone $kegiatanQuery)->where('status_verifikasi', 'Menunggu Review')->where('is_tugas_lapangan', true)->count();

        $kehadiranHariIni = (clone $presensiQuery)->with('pegawai')
            ->where('tanggal', $today)
            ->latest()
            ->take(10)
            ->get();

        $pendingPengajuan = (clone $izinQuery)->with('pegawai')
            ->where('status', 'Menunggu Review')
            ->latest()
            ->take(5)
            ->get();

        $officeSettings = PengaturanKantor::getPengaturan();

        return view('admin.dashboard', compact(
            'totalPegawai',
            'hadirHariIni',
            'izinSakitCuti',
            'dinasLuar',
            'pendingPengajuanCount',
            'pendingKegiatanCount',
            'pendingTugasLapanganCount',
            'kehadiranHariIni',
            'pendingPengajuan',
            'officeSettings',
            'isKabid',
            'kabidBidang'
        ));
    }
}
