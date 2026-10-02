<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Models\LaporanKegiatan;
use App\Models\PengajuanIzin;
use App\Models\PengaturanKantor;
use App\Models\Presensi;
use App\Models\SkorKinerja;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PegawaiDashboardController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();
        $employee = $user->pegawai;
        $today = Carbon::today()->toDateString();
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        $currentPeriod = Carbon::now()->format('Y-m');

        $todayAttendance = null;
        $recentAttendances = collect();
        
        $hasReportedToday = false;
        $laporanTerverifikasiCount = 0;
        
        $attendancePercentage = '0%';
        $attendanceDelta = '0%';
        $totalHadirBulanIni = 0;
        $totalHariKerjaBulanIni = 22; // Asumsi 22 hari kerja
        $terlambatCount = 0;
        $terlambatMenit = 0;
        $izinSakitCount = 0;
        
        $totalLaporanKegiatan = 0;
        $persenLaporan = '0%';
        
        $ikpScore = 0;
        $ikpScoreText = '-';
        
        $chartRadarData = [0, 0, 0];
        $chartTrendData = [0, 0, 0, 0, 0, 0];
        $chartTrendLabels = [];
        $sisaCuti = 12;

        if ($employee) {
            $todayAttendance = Presensi::where('pegawai_id', $employee->id)
                ->where('tanggal', $today)
                ->first();

            $recentAttendances = Presensi::where('pegawai_id', $employee->id)
                ->latest('tanggal')
                ->take(5)
                ->get();

            $hasReportedToday = LaporanKegiatan::where('pegawai_id', $employee->id)
                ->where('tanggal', $today)
                ->exists();
                
            $laporanTerverifikasiCount = LaporanKegiatan::where('pegawai_id', $employee->id)
                ->where('status_verifikasi', 'Disetujui')
                ->count();
                
            $totalHadirBulanIni = Presensi::where('pegawai_id', $employee->id)
                ->whereYear('tanggal', $currentYear)
                ->whereMonth('tanggal', $currentMonth)
                ->whereIn('status', ['Hadir', 'Terlambat'])
                ->count();
                
            $terlambatCount = Presensi::where('pegawai_id', $employee->id)
                ->whereYear('tanggal', $currentYear)
                ->whereMonth('tanggal', $currentMonth)
                ->where('status', 'Terlambat')
                ->count();
                
            $izinSakitCount = PengajuanIzin::where('pegawai_id', $employee->id)
                ->whereYear('tanggal_mulai', $currentYear)
                ->whereMonth('tanggal_mulai', $currentMonth)
                ->whereIn('jenis', ['Izin', 'Sakit'])
                ->where('status', 'Disetujui')
                ->count();
                
            $cutiDiambil = PengajuanIzin::where('pegawai_id', $employee->id)
                ->whereYear('tanggal_mulai', $currentYear)
                ->where('jenis', 'Cuti')
                ->where('status', 'Disetujui')
                ->count();
            $sisaCuti = max(0, 12 - $cutiDiambil);
                
            $totalLaporanKegiatan = LaporanKegiatan::where('pegawai_id', $employee->id)
                ->whereYear('tanggal', $currentYear)
                ->whereMonth('tanggal', $currentMonth)
                ->count();
                
            $attendancePercentage = ($totalHariKerjaBulanIni > 0) ? round(($totalHadirBulanIni / $totalHariKerjaBulanIni) * 100) . '%' : '0%';
            $persenLaporan = ($totalHariKerjaBulanIni > 0) ? round(($totalLaporanKegiatan / $totalHariKerjaBulanIni) * 100) . '%' : '0%';

            $score = SkorKinerja::calculateLiveScore($employee->id, $currentPeriod);

            if ($score) {
                $ikpScore = round($score->nilai_akhir, 1);
                $ikpScoreText = $score->kategori;
                $chartRadarData = [
                    round($score->nilai_kehadiran, 1),
                    round($score->nilai_produktivitas, 1),
                    round($score->nilai_kualitas, 1)
                ];
            }
            
            // Get last 6 months trend
            for ($i = 5; $i >= 0; $i--) {
                $month = Carbon::parse($currentPeriod)->subMonths($i);
                $chartTrendLabels[] = $month->isoFormat('MMM Y');
                
                $trendScore = SkorKinerja::calculateLiveScore($employee->id, $month->format('Y-m'));
                $chartTrendData[5 - $i] = $trendScore ? round($trendScore->nilai_akhir, 1) : 0;
            }
        }

        $officeSettings = PengaturanKantor::getPengaturan();

        return view('pegawai.dashboard', compact(
            'employee',
            'todayAttendance',
            'recentAttendances',
            'hasReportedToday',
            'laporanTerverifikasiCount',
            'attendancePercentage',
            'attendanceDelta',
            'totalHadirBulanIni',
            'totalHariKerjaBulanIni',
            'terlambatCount',
            'terlambatMenit',
            'izinSakitCount',
            'totalLaporanKegiatan',
            'persenLaporan',
            'ikpScore',
            'ikpScoreText',
            'chartRadarData',
            'chartTrendData',
            'chartTrendLabels',
            'sisaCuti',
            'officeSettings'
        ));
    }
}

