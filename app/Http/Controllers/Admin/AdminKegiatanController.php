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

        // Jika status Ditolak, hapus laporan dan berkas lampirannya secara permanen
        if ($validated['status_verifikasi'] === 'Ditolak') {
            $isTugasLapangan = (bool)$laporan->is_tugas_lapangan;
            $pegawaiId = $laporan->pegawai_id;
            $tanggalLap = $laporan->tanggal;
            $periode = Carbon::parse($tanggalLap)->format('Y-m');
            $namaKegiatan = $laporan->nama_kegiatan;

            if ($laporan->foto && \Illuminate\Support\Facades\Storage::disk('public')->exists($laporan->foto)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($laporan->foto);
            }
            if ($laporan->surat_tugas && \Illuminate\Support\Facades\Storage::disk('public')->exists($laporan->surat_tugas)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($laporan->surat_tugas);
            }

            $laporan->delete();

            // Jika laporan ini tugas lapangan dan tidak ada laporan tugas lapangan lain yang disetujui,
            // batalkan dispensasi presensi Dinas Luar dan ubah menjadi Alpha
            if ($isTugasLapangan) {
                $hasOtherApprovedFieldTask = LaporanKegiatan::where('pegawai_id', $pegawaiId)
                    ->whereDate('tanggal', $tanggalLap)
                    ->where('is_tugas_lapangan', true)
                    ->where('status_verifikasi', 'Disetujui')
                    ->exists();

                if (!$hasOtherApprovedFieldTask) {
                    $presensi = \App\Models\Presensi::where('pegawai_id', $pegawaiId)
                        ->whereDate('tanggal', $tanggalLap)
                        ->first();

                    if ($presensi && ($presensi->status === 'Dinas Luar' || str_contains($presensi->keterangan ?? '', 'Lapangan'))) {
                        $presensi->update([
                            'status'       => 'Alpha',
                            'jam_masuk'    => null,
                            'status_masuk' => null,
                            'jarak_masuk'  => null,
                            'jam_pulang'   => null,
                            'status_pulang'=> null,
                            'keterangan'   => 'Laporan Tugas Lapangan Ditolak (Alpha)',
                        ]);
                    }
                }
            }

            // Sinkronkan ulang skor kinerja pegawai setelah laporan dihapus / status presensi berubah
            \App\Models\SkorKinerja::simpanAtauPerbarui($pegawaiId, $periode);

            // Sinkronkan draf Surat Peringatan (SP) jika akumulasi Alpha bertambah
            $pegawai = \App\Models\Pegawai::find($pegawaiId);
            if ($pegawai) {
                \App\Models\SuratPeringatan::syncDraftSpForPegawai($pegawai);
            }

            return back()->with('success', "Laporan kegiatan '{$namaKegiatan}' berhasil ditolak. Status presensi disesuaikan.");
        }

        // Jika Disetujui, nilai_kualitas wajib diisi
        if ($validated['status_verifikasi'] === 'Disetujui') {
            if (!isset($validated['nilai_kualitas']) || $validated['nilai_kualitas'] === '') {
                return back()->with('error', 'Silakan masukkan Nilai Kualitas (0 - 100) sebelum menyetujui laporan.');
            }
        }

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

        // Jika laporan yang disetujui adalah tugas lapangan, sahkan status presensi menjadi Dinas Luar resmi
        if ($laporan->is_tugas_lapangan) {
            $presensi = \App\Models\Presensi::where('pegawai_id', $laporan->pegawai_id)
                ->whereDate('tanggal', $laporan->tanggal)
                ->first();

            if ($presensi) {
                $presensi->update([
                    'status'     => 'Dinas Luar',
                    'keterangan' => 'Dinas Luar Lapangan (Disetujui)',
                ]);
            } else {
                \App\Models\Presensi::create([
                    'pegawai_id'   => $laporan->pegawai_id,
                    'tanggal'      => $laporan->tanggal,
                    'jam_masuk'    => $laporan->waktu_kirim ?? '07:30:00',
                    'status_masuk' => 'Tepat Waktu',
                    'jarak_masuk'  => 0,
                    'status'       => 'Dinas Luar',
                    'keterangan'   => 'Dinas Luar Lapangan (Disetujui)',
                ]);
            }
        }

        // Sinkronkan ulang skor kinerja pegawai
        \App\Models\SkorKinerja::simpanAtauPerbarui($laporan->pegawai_id, Carbon::parse($laporan->tanggal)->format('Y-m'));

        return back()->with('success', "Laporan kegiatan berhasil diverifikasi dengan predikat Kualitas {$kategori}.");
    }

    public function destroy(int $id): RedirectResponse
    {
        $laporan = LaporanKegiatan::findOrFail($id);

        if ($laporan->foto && \Illuminate\Support\Facades\Storage::disk('public')->exists($laporan->foto)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($laporan->foto);
        }
        if ($laporan->surat_tugas && \Illuminate\Support\Facades\Storage::disk('public')->exists($laporan->surat_tugas)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($laporan->surat_tugas);
        }

        $pegawaiId = $laporan->pegawai_id;
        $periode = Carbon::parse($laporan->tanggal)->format('Y-m');
        $namaKegiatan = $laporan->nama_kegiatan;
        $laporan->delete();

        // Sinkronkan ulang skor kinerja pegawai setelah laporan dihapus
        \App\Models\SkorKinerja::simpanAtauPerbarui($pegawaiId, $periode);

        return back()->with('success', "Laporan kegiatan '{$namaKegiatan}' berhasil dihapus dari sistem.");
    }
}
