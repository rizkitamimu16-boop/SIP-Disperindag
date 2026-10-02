<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Models\LaporanKegiatan;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PegawaiKegiatanController extends Controller
{
    public function index(Request $request): View
    {
        $employee = Auth::user()->pegawai;
        $activities = collect();

        if ($employee) {
            $query = LaporanKegiatan::where('pegawai_id', $employee->id)
                ->orderBy('tanggal', 'desc')
                ->orderBy('waktu_kirim', 'asc');

            if ($request->filled('month')) {
                $query->whereMonth('tanggal', Carbon::parse($request->month)->month);
            }
            if ($request->filled('status') && $request->status !== 'semua') {
                $query->where('status_verifikasi', $request->status);
            }
            if ($request->filled('search')) {
                $query->where(function($q) use ($request) {
                    $q->where('nama_kegiatan', 'like', '%' . $request->search . '%')
                      ->orWhere('deskripsi', 'like', '%' . $request->search . '%');
                });
            }

            $activities = $query->get();
        }

        $totalLaporan = $activities->count();
        $targetHariKerja = 22; // Hardcode target or from settings
        $persenTargetLaporan = ($targetHariKerja > 0) ? min(100, round(($totalLaporan / $targetHariKerja) * 100)) . '%' : '0%';
        $disetujuiCount = $activities->where('status_verifikasi', 'Disetujui')->count();
        $menungguReviewCount = $activities->where('status_verifikasi', 'Menunggu Review')->count();
        $avgProduktivitas = $activities->avg('nilai_produktivitas') ?? 0;
        $nilaiProduktivitas = round($avgProduktivitas, 1);
        $poinProduktivitas = round($avgProduktivitas * 0.25, 1);

        return view('pegawai.kegiatan', [
            'activities'      => $activities,
            'laporanKegiatan' => $activities,
            'employee'        => $employee,
            'totalLaporan'    => $totalLaporan,
            'targetHariKerja' => $targetHariKerja,
            'persenTargetLaporan' => $persenTargetLaporan,
            'disetujuiCount'  => $disetujuiCount,
            'menungguReviewCount' => $menungguReviewCount,
            'nilaiProduktivitas' => $nilaiProduktivitas,
            'poinProduktivitas' => $poinProduktivitas
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'deskripsi'     => 'required|string',
            'tanggal'       => 'required|date',
            'foto'          => 'nullable|image|max:3072',
        ], [
            'nama_kegiatan.required' => 'Nama kegiatan wajib diisi.',
            'deskripsi.required'     => 'Deskripsi uraian kegiatan wajib diisi.',
            'tanggal.required'       => 'Tanggal pelaksanaan kegiatan wajib ditentukan.',
        ]);

        $employee = Auth::user()->pegawai;
        if (!$employee) {
            return back()->withErrors(['error' => 'Data pegawai tidak ditemukan.']);
        }

        $tanggalReq = Carbon::parse($validated['tanggal'])->toDateString();
        
        $isDinasLuar = \App\Models\PengajuanIzin::where('pegawai_id', $employee->id)
            ->where('jenis', 'Dinas Luar')
            ->where('status', 'Disetujui')
            ->whereDate('tanggal_mulai', '<=', $tanggalReq)
            ->whereDate('tanggal_selesai', '>=', $tanggalReq)
            ->exists();

        $presensi = \App\Models\Presensi::where('pegawai_id', $employee->id)
            ->whereDate('tanggal', $tanggalReq)
            ->first();

        if (!$isDinasLuar) {
            if (!$presensi || !$presensi->jam_masuk) {
                return back()->withErrors(['error' => 'Anda belum melakukan Absen Datang. Laporan kegiatan hanya dapat dikirim selama jam kerja.']);
            }
            if ($presensi->jam_pulang) {
                return back()->withErrors(['error' => 'Anda sudah melakukan Absen Pulang. Jam kerja telah selesai sehingga tidak dapat menambah laporan kegiatan.']);
            }
        }

        $photoPath = null;
        if ($request->hasFile('foto')) {
            $photoPath = $request->file('foto')->store('kegiatan', 'public');
        }

        LaporanKegiatan::create([
            'pegawai_id'            => $employee->id,
            'tanggal'               => $validated['tanggal'],
            'nama_kegiatan'         => $validated['nama_kegiatan'],
            'deskripsi'             => $validated['deskripsi'],
            'foto'                  => $photoPath,
            'waktu_kirim'           => Carbon::now()->format('H:i:s'),
            'nilai_produktivitas'   => 85.00,
            'kategori_produktivitas' => 'Target Tercapai',
            'status_verifikasi'     => 'Menunggu Review',
        ]);

        return back()->with('success', 'Laporan kegiatan harian berhasil dikirim untuk verifikasi admin/atasan.');
    }

    public function exportPdf(Request $request)
    {
        $employee = Auth::user()->pegawai;
        if (!$employee) {
            return back()->with('error', 'Data pegawai tidak ditemukan.');
        }

        $query = \App\Models\LaporanKegiatan::where('pegawai_id', $employee->id)->latest('tanggal');

        if ($request->filled('month')) {
            $query->whereMonth('tanggal', Carbon::parse($request->month)->month)
                  ->whereYear('tanggal', Carbon::parse($request->month)->year);
        }

        if ($request->filled('status') && $request->status !== 'semua') {
            $query->where('status_verifikasi', $request->status);
        }

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('nama_kegiatan', 'like', '%' . $request->search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $request->search . '%');
            });
        }

        $kegiatan = $query->get();
        $monthLabel = $request->filled('month') ? Carbon::parse($request->month)->translatedFormat('F Y') : 'Keseluruhan';

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pegawai.exports.kegiatan-pdf', compact('employee', 'kegiatan', 'monthLabel'));
        return $pdf->download('Laporan_Kegiatan_' . str_replace(' ', '_', $employee->nama) . '.pdf');
    }
}
