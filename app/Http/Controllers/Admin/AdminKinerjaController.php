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
        $currentPeriod = $request->get('period', Carbon::now()->format('Y-m'));
        $year = Carbon::parse($currentPeriod)->year;
        $month = Carbon::parse($currentPeriod)->month;

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
            $scoreData = $this->calculatePegawaiScore($pegawai, $year, $month);
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
        
        // Data for Line Chart (Last 6 months based on current filter)
        $trendMonths = [];
        $trendScores = [];
        for ($i = 5; $i >= 0; $i--) {
            $tMonth = Carbon::parse($currentPeriod)->subMonths($i);
            $monthName = $tMonth->isoFormat('MMM Y');
            
            $tYear = $tMonth->year;
            $tMonthNum = $tMonth->month;

            $monthTotal = 0;
            foreach ($pegawais as $pegawai) {
                $mScore = $this->calculatePegawaiScore($pegawai, $tYear, $tMonthNum);
                $monthTotal += $mScore->nilai_akhir;
            }

            $avgNilaiAkhir = $monthTotal / $count;

            $trendMonths[] = $monthName;
            $trendScores[] = round($avgNilaiAkhir, 1);
        }

        return view('admin.indeks-kinerja', [
            'scores'        => $scores,
            'skorList'      => $scores, // For backwards compatibility with view if needed
            'currentPeriod' => $currentPeriod,
            'chartData'     => json_encode([
                'radar' => [round($avgKehadiran, 1), round($avgProduktivitas, 1), round($avgKualitas, 1)],
                'trend_labels' => $trendMonths,
                'trend_data' => $trendScores,
            ]),
        ]);
    }

    private function calculatePegawaiScore($pegawai, $year, $month)
    {
        $periode = sprintf('%04d-%02d', $year, $month);
        $scoreData = \App\Models\SkorKinerja::calculateLiveScore($pegawai->id, $periode);

        if ($scoreData->nilai_akhir >= 90) {
            $scoreData->rekomendasi_kontrak = 'Diperpanjang';
        } elseif ($scoreData->nilai_akhir >= 80) {
            $scoreData->rekomendasi_kontrak = 'Diperpanjang';
        } elseif ($scoreData->nilai_akhir >= 70) {
            $scoreData->rekomendasi_kontrak = 'Dipertimbangkan';
        } else {
            $scoreData->rekomendasi_kontrak = 'Tidak Diperpanjang';
        }

        $presensi = Presensi::where('pegawai_id', $pegawai->id)
            ->whereYear('tanggal', $year)
            ->whereMonth('tanggal', $month)
            ->get();
        $alphaCount = $presensi->where('status', 'Alpha')->count();

        // OTOMATIS: Cek Pelanggaran Surat Peringatan (SP) secara live
        // Supaya SP tetap ter-generate otomatis saat dihitung secara live
        if ($alphaCount >= 3) {
            $tingkatSp = 'SP1';
            if ($alphaCount >= 9) {
                $tingkatSp = 'SP3';
            } elseif ($alphaCount >= 6) {
                $tingkatSp = 'SP2';
            }

            // Cek apakah bulan ini sudah dibuatkan draf SP untuk pegawai tersebut
            $existingSp = \App\Models\SuratPeringatan::where('pegawai_id', $pegawai->id)
                ->where('tingkat_sp', $tingkatSp)
                ->whereMonth('created_at', $month)
                ->whereYear('created_at', $year)
                ->first();

            if (!$existingSp) {
                \App\Models\SuratPeringatan::create([
                    'pegawai_id' => $pegawai->id,
                    'tingkat_sp' => $tingkatSp,
                    'jumlah_alpha' => $alphaCount,
                    'status' => 'Aktif',
                    'created_at' => Carbon::createFromDate($year, $month, 1),
                ]);
            }
        }

        $scoreData->status = 'Real-time';
        return $scoreData;
    }
}
