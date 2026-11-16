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
            'nama_kegiatan'     => 'required|string|max:255',
            'deskripsi'         => 'required|string',
            'tanggal'           => 'required|date',
            'foto'              => 'nullable|image|max:10240',
            'surat_tugas'       => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:10240',
            'is_tugas_lapangan' => 'nullable|boolean',
            'jam_mulai_tugas'   => 'nullable|string',
        ], [
            'nama_kegiatan.required' => 'Nama kegiatan wajib diisi.',
            'deskripsi.required'     => 'Deskripsi uraian kegiatan wajib diisi.',
            'tanggal.required'       => 'Tanggal pelaksanaan kegiatan wajib ditentukan.',
            'surat_tugas.mimes'      => 'Berkas Surat Tugas harus berupa format JPG, PNG, atau PDF.',
        ]);

        $employee = Auth::user()->pegawai;
        if (!$employee) {
            return back()->with('error', 'Data pegawai tidak ditemukan.');
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

        $isTugasLapangan = $request->boolean('is_tugas_lapangan');

        if ($isTugasLapangan) {
            if (!$request->hasFile('foto')) {
                return back()->with('error', 'Laporan tugas lapangan wajib menyertakan Foto Dokumentasi / Selfie di lokasi tugas.');
            }
            if (!$request->hasFile('surat_tugas')) {
                return back()->with('error', 'Laporan tugas lapangan wajib menyertakan Foto / Berkas Surat Tugas.');
            }
        } elseif (!$isDinasLuar) {
            if (!$presensi || !$presensi->jam_masuk) {
                return back()->with('error', 'Anda belum melakukan Absen Datang di kantor. Laporan kegiatan reguler hanya dapat dikirim selama jam kerja, atau centang pilihan "Tugas Lapangan / Dinas Luar" jika langsung bertugas di luar kantor.');
            }
            if ($presensi->jam_pulang) {
                return back()->with('error', 'Anda sudah melakukan Absen Pulang. Jam kerja telah selesai sehingga tidak dapat menambah laporan kegiatan.');
            }
        }

        $photoPath = null;
        if ($request->hasFile('foto')) {
            $photoPath = $request->file('foto')->store('kegiatan', 'public');
        }

        $suratTugasPath = null;
        if ($request->hasFile('surat_tugas')) {
            $suratTugasPath = $request->file('surat_tugas')->store('kegiatan', 'public');
        }

        // Hitung skor produktivitas berdasarkan 4 subindikator PRD §23
        $hasilProduktivitas = LaporanKegiatan::hitungProduktivitas([
            'nama_kegiatan' => $validated['nama_kegiatan'],
            'tanggal'       => $validated['tanggal'],
            'deskripsi'     => $validated['deskripsi'],
            'foto'          => $photoPath,
        ], $employee->id);

        $jamMulai = Carbon::now('Asia/Makassar')->format('H:i:s');
        if ($request->filled('jam_mulai_tugas')) {
            $inputJam = trim($request->input('jam_mulai_tugas'));
            if (preg_match('/^\d{1,2}:\d{2}$/', $inputJam)) {
                $jamMulai = $inputJam . ':00';
            } elseif (preg_match('/^\d{1,2}:\d{2}:\d{2}$/', $inputJam)) {
                $jamMulai = $inputJam;
            }
        }

        $laporan = LaporanKegiatan::create([
            'pegawai_id'            => $employee->id,
            'tanggal'               => $validated['tanggal'],
            'nama_kegiatan'         => $validated['nama_kegiatan'],
            'deskripsi'             => $validated['deskripsi'],
            'foto'                  => $photoPath,
            'surat_tugas'           => $suratTugasPath,
            'is_tugas_lapangan'     => $isTugasLapangan,
            'waktu_kirim'           => $jamMulai,
            'nilai_produktivitas'   => $hasilProduktivitas['nilai'],
            'kategori_produktivitas' => $hasilProduktivitas['kategori'],
            'status_verifikasi'     => 'Menunggu Review',
        ]);

        // Jika dicentang tugas lapangan dan belum memiliki rekaman presensi datang hari itu,
        // buatkan rekaman presensi sementara berstatus Dinas Luar agar terlindungi dari vonis Alpha / SP.
        if ($isTugasLapangan) {
            if (!$presensi) {
                \App\Models\Presensi::create([
                    'pegawai_id'   => $employee->id,
                    'tanggal'      => $tanggalReq,
                    'jam_masuk'    => $jamMulai,
                    'status_masuk' => 'Tepat Waktu',
                    'jarak_masuk'  => 0,
                    'status'       => 'Dinas Luar',
                    'keterangan'   => 'Dinas Luar Lapangan (Menunggu Review)',
                ]);
            } elseif ($presensi->status === 'Alpha' || empty($presensi->jam_masuk)) {
                $presensi->update([
                    'jam_masuk'    => $jamMulai,
                    'status_masuk' => 'Tepat Waktu',
                    'jarak_masuk'  => 0,
                    'status'       => 'Dinas Luar',
                    'keterangan'   => 'Dinas Luar Lapangan (Menunggu Review)',
                ]);
            }
        }

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
