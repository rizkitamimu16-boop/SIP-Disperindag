<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Models\SkorKinerja;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PegawaiKinerjaController extends Controller
{
    public function index(Request $request): View
    {
        $employee = Auth::user()->pegawai;
        $currentPeriod = $request->get('period', Carbon::now()->format('Y-m'));

        $performance = null;
        if ($employee) {
            $performance = SkorKinerja::calculateLiveScore($employee->id, $currentPeriod);
        }

        $ikpScore = $performance ? round($performance->nilai_akhir, 1) : 0;
        
        $kehadiranScore = $performance ? round($performance->nilai_kehadiran, 1) : 0;
        $produktivitasScore = $performance ? round($performance->nilai_produktivitas, 1) : 0;
        $kualitasScore = $performance ? round($performance->nilai_kualitas, 1) : 0;

        $predikatKinerja = $performance ? 'Disiplin ' . $performance->kategori : 'Disiplin Kurang (D)';

        $pengaturan = \App\Models\PengaturanKantor::getPengaturan();
        $wKehadiran = $pengaturan->bobot_kehadiran / 100;
        $wProduktivitas = $pengaturan->bobot_produktivitas / 100;
        $wKualitas = $pengaturan->bobot_kualitas / 100;

        // Point calculation based on dynamic weights
        $kehadiranPoint = ($kehadiranScore * $wKehadiran);
        $produktivitasPoint = ($produktivitasScore * $wProduktivitas);
        $kualitasPoint = ($kualitasScore * $wKualitas);
        
        $chartRadarData = [
            $kehadiranScore,
            $produktivitasScore,
            $kualitasScore
        ];
        
        $chartRadarLabels = [
            'Kehadiran (' . floatval($pengaturan->bobot_kehadiran) . '%)',
            'Produktivitas (' . floatval($pengaturan->bobot_produktivitas) . '%)',
            'Kualitas (' . floatval($pengaturan->bobot_kualitas) . '%)'
        ];
        
        $chartTrendData = [0, 0, 0, 0, 0, 0];
        $chartTrendLabels = [];
        
        if ($employee) {
            for ($i = 5; $i >= 0; $i--) {
                $month = Carbon::parse($currentPeriod)->subMonths($i);
                $chartTrendLabels[] = $month->isoFormat('MMM Y');
                
                $trendScore = SkorKinerja::calculateLiveScore($employee->id, $month->format('Y-m'));
                    
                $chartTrendData[5 - $i] = $trendScore ? round($trendScore->nilai_akhir, 1) : 0;
            }
        }

        return view('pegawai.kinerja', compact(
            'employee',
            'performance',
            'ikpScore',
            'kehadiranScore',
            'kehadiranPoint',
            'produktivitasScore',
            'produktivitasPoint',
            'kualitasScore',
            'kualitasPoint',
            'kualitasPoint',
            'currentPeriod',
            'predikatKinerja',
            'chartRadarData',
            'chartRadarLabels',
            'chartTrendData',
            'chartTrendLabels',
            'pengaturan'
        ));
    }
}
