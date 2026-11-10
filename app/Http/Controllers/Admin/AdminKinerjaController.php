<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use App\Models\Presensi;
use App\Models\LaporanKegiatan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminKinerjaController extends Controller
{
    public function index(Request $request): View
    {
        $mode = $request->get('mode', 'bulanan'); // 'bulanan' or 'harian'
        $currentPeriod = $request->get('period', Carbon::now()->format('Y-m'));
        $selectedDate = $request->get('date', Carbon::today()->toDateString());

        if ($mode === 'harian') {
            $periodeKey = $selectedDate;
            $periodLabel = Carbon::parse($selectedDate)->locale('id')->isoFormat('D MMMM Y');
        } else {
            $mode = 'bulanan';
            $periodeKey = $currentPeriod;
            $periodLabel = Carbon::parse($currentPeriod)->locale('id')->isoFormat('MMMM Y');
        }

        $query = Pegawai::query();

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhere('nip', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('bidang') && $request->bidang != 'Semua Bidang') {
            $query->where('bidang', $request->bidang);
        }

        $pegawais = $query->get();
        $scores = collect();

        $totalKehadiran = 0;
        $totalProduktivitas = 0;
        $totalKualitas = 0;

        foreach ($pegawais as $pegawai) {
            $scoreData = $this->calculatePegawaiScore($pegawai, $periodeKey);
            $scoreData->pegawai = $pegawai; // Attach relation manually
            $scores->push($scoreData);

            $totalKehadiran += $scoreData->nilai_kehadiran;
            $totalProduktivitas += $scoreData->nilai_produktivitas;
            $totalKualitas += $scoreData->nilai_kualitas;
        }

        // Sort by highest score
        $scores = $scores->sortByDesc('nilai_akhir')->values();

        $count = $scores->count() > 0 ? $scores->count() : 1;
        $avgKehadiran = $totalKehadiran / $count;
        $avgProduktivitas = $totalProduktivitas / $count;
        $avgKualitas = $totalKualitas / $count;
        
        // Data for Line Chart (7 days for daily, 6 months for monthly)
        $trendLabels = [];
        $trendScores = [];

        if ($mode === 'harian') {
            for ($i = 6; $i >= 0; $i--) {
                $tDate = Carbon::parse($selectedDate)->subDays($i);
                $dayLabel = $tDate->locale('id')->isoFormat('D MMM');
                $dKey = $tDate->toDateString();

                $dayTotal = 0;
                foreach ($pegawais as $pegawai) {
                    $mScore = $this->calculatePegawaiScore($pegawai, $dKey);
                    $dayTotal += $mScore->nilai_akhir;
                }

                $trendLabels[] = $dayLabel;
                $trendScores[] = round($dayTotal / $count, 1);
            }
        } else {
            for ($i = 5; $i >= 0; $i--) {
                $tMonth = Carbon::parse($currentPeriod)->subMonths($i);
                $monthName = $tMonth->locale('id')->isoFormat('MMM Y');
                $mKey = $tMonth->format('Y-m');

                $monthTotal = 0;
                foreach ($pegawais as $pegawai) {
                    $mScore = $this->calculatePegawaiScore($pegawai, $mKey);
                    $monthTotal += $mScore->nilai_akhir;
                }

                $trendLabels[] = $monthName;
                $trendScores[] = round($monthTotal / $count, 1);
            }
        }

        $pengaturan = \App\Models\PengaturanKantor::getPengaturan();

        return view('admin.indeks-kinerja', [
            'scores'        => $scores,
            'skorList'      => $scores, // For backwards compatibility with view if needed
            'mode'          => $mode,
            'selectedDate'  => $selectedDate,
            'currentPeriod' => $currentPeriod,
            'periodLabel'   => $periodLabel,
            'pengaturan'    => $pengaturan,
            'chartData'     => json_encode([
                'radar' => [round($avgKehadiran, 1), round($avgProduktivitas, 1), round($avgKualitas, 1)],
                'radar_labels' => [
                    'Kehadiran (' . floatval($pengaturan->bobot_kehadiran ?? 60) . '%)',
                    'Produktivitas (' . floatval($pengaturan->bobot_produktivitas ?? 25) . '%)',
                    'Kualitas (' . floatval($pengaturan->bobot_kualitas ?? 15) . '%)'
                ],
                'trend_labels' => $trendLabels,
                'trend_data' => $trendScores,
            ]),
        ]);
    }

    private function calculatePegawaiScore($pegawai, $periodeKey)
    {
        $scoreData = \App\Models\SkorKinerja::calculateLiveScore($pegawai->id, $periodeKey);

        if ($scoreData->nilai_akhir >= 90) {
            $scoreData->rekomendasi_kontrak = 'Diperpanjang';
        } elseif ($scoreData->nilai_akhir >= 80) {
            $scoreData->rekomendasi_kontrak = 'Diperpanjang';
        } elseif ($scoreData->nilai_akhir >= 70) {
            $scoreData->rekomendasi_kontrak = 'Dipertimbangkan';
        } else {
            $scoreData->rekomendasi_kontrak = 'Tidak Diperpanjang';
        }

        // OTOMATIS: Cek Pelanggaran Surat Peringatan (SP) semiotomatis
        \App\Models\SuratPeringatan::syncDraftSpForPegawai($pegawai);

        // Jika mode bulanan (format YYYY-MM), sinkronkan skor kinerja ke tabel skor_kinerja untuk riwayat
        if (strlen($periodeKey) === 7) {
            \App\Models\SkorKinerja::simpanAtauPerbarui($pegawai->id, $periodeKey);
        }

        $scoreData->status = 'Real-time';
        return $scoreData;
    }
}
