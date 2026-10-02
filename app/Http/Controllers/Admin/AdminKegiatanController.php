<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LaporanKegiatan;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminKegiatanController extends Controller
{
    public function index(Request $request): View
    {
        $today = Carbon::today()->toDateString();
        // Base query for table
        $query = LaporanKegiatan::with('pegawai')->latest();

        if ($request->filled('date')) {
            $query->where('tanggal', $request->date);
        }

        if ($request->filled('status') && $request->status !== 'Semua Status') {
            $query->where('status_verifikasi', $request->status);
        }

        $activityReports = $query->get();

        // Stats Cards Data
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $totalLaporan = LaporanKegiatan::whereMonth('tanggal', $currentMonth)->whereYear('tanggal', $currentYear)->count();
        $terverifikasi = LaporanKegiatan::whereMonth('tanggal', $currentMonth)->whereYear('tanggal', $currentYear)->where('status_verifikasi', 'Disetujui')->count();
        $menungguReview = LaporanKegiatan::whereMonth('tanggal', $currentMonth)->whereYear('tanggal', $currentYear)->where('status_verifikasi', 'Menunggu Review')->count();
        $avgProduktivitas = LaporanKegiatan::whereMonth('tanggal', $currentMonth)->whereYear('tanggal', $currentYear)->avg('nilai_produktivitas') ?? 0;
        $avgProduktivitas = number_format($avgProduktivitas, 1);

        // Chart 1: Distribusi per Bidang
        $bidangData = [
            'Perindustrian' => ['masuk' => 0, 'terverifikasi' => 0],
            'Perdagangan' => ['masuk' => 0, 'terverifikasi' => 0],
            'Sekretariat' => ['masuk' => 0, 'terverifikasi' => 0],
            'Perlindungan Konsumen' => ['masuk' => 0, 'terverifikasi' => 0],
        ];
        
        $laporanBulanIni = LaporanKegiatan::with('pegawai')->whereMonth('tanggal', $currentMonth)->whereYear('tanggal', $currentYear)->get();
        foreach ($laporanBulanIni as $lap) {
            $b = $lap->pegawai->bidang ?? 'Lainnya';
            if (isset($bidangData[$b])) {
                $bidangData[$b]['masuk']++;
                if ($lap->status_verifikasi === 'Disetujui') {
                    $bidangData[$b]['terverifikasi']++;
                }
            }
        }

        // Chart 2: Tren 7 Hari Terakhir
        $trenLabels = [];
        $trenData = [];
        for ($i = 6; $i >= 0; $i--) {
            $d = Carbon::today()->subDays($i);
            $trenLabels[] = $d->format('d M');
            $trenData[] = LaporanKegiatan::whereDate('tanggal', $d->toDateString())->count();
        }

        return view('admin.laporan-kegiatan', [
            'activityReports'  => $activityReports,
            'laporanKegiatan'  => $activityReports,
            'totalLaporan'     => $totalLaporan,
            'terverifikasi'    => $terverifikasi,
            'menungguReview'   => $menungguReview,
            'avgProduktivitas' => $avgProduktivitas,
            'chartBidang'      => $bidangData,
            'chartTrenLabels'  => $trenLabels,
            'chartTrenData'    => $trenData,
        ]);
    }

    public function verifikasi(Request $request, int $id): RedirectResponse
    {
        $laporan = LaporanKegiatan::findOrFail($id);

        $validated = $request->validate([
            'status_verifikasi' => 'required|in:Disetujui,Ditolak,Menunggu Review',
            'nilai_kualitas'    => 'nullable|numeric|min:0|max:100',
            'catatan_kualitas'  => 'nullable|string',
        ]);

        $nilai = $validated['nilai_kualitas'] ?? $laporan->nilai_kualitas;
        $kategori = $laporan->kategori_kualitas;
        
        if ($nilai !== null) {
            if ($nilai >= 90) $kategori = 'A';
            elseif ($nilai >= 80) $kategori = 'B';
            elseif ($nilai >= 70) $kategori = 'C';
            else $kategori = 'D';
        }

        $laporan->update([
            'status_verifikasi' => $validated['status_verifikasi'],
            'nilai_kualitas'    => $nilai,
            'kategori_kualitas' => $kategori,
            'catatan_kualitas'  => $validated['catatan_kualitas'] ?? $laporan->catatan_kualitas,
        ]);

        return back()->with('success', "Status laporan kegiatan berhasil diperbarui menjadi '{$validated['status_verifikasi']}'.");
    }
}
