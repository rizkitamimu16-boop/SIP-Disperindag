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

        $totalPegawai = Pegawai::count();
        $hadirHariIni = Presensi::where('tanggal', $today)->whereIn('status', ['Hadir', 'Terlambat'])->count();
        $izinSakitCuti = Presensi::where('tanggal', $today)->whereIn('status', ['Izin', 'Cuti', 'Sakit'])->count();
        $dinasLuar = Presensi::where('tanggal', $today)->where('status', 'Dinas Luar')->count();

        $pendingPengajuanCount = PengajuanIzin::where('status', 'Menunggu Review')->count();
        $pendingKegiatanCount = LaporanKegiatan::where('status_verifikasi', 'Menunggu Review')->count();

        $kehadiranHariIni = Presensi::with('pegawai')
            ->where('tanggal', $today)
            ->latest()
            ->take(10)
            ->get();

        $pendingPengajuan = PengajuanIzin::with('pegawai')
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
            'kehadiranHariIni',
            'pendingPengajuan',
            'officeSettings'
        ));
    }
}
