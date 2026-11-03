<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Models\PengaturanKantor;
use App\Models\SuratPeringatan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PegawaiSpController extends Controller
{
    public function index(): View
    {
        $employee = Auth::user()->pegawai;
        $spCount = 0;
        $alphaCount = 0;
        $spLetters = collect();

        if ($employee) {
            $alphaCount = \App\Models\Presensi::where('pegawai_id', $employee->id)
                ->where('status', 'Alpha')
                ->count();
            // Pegawai hanya melihat SP yang sudah diterbitkan resmi (memiliki nomor surat)
            $spLetters = SuratPeringatan::where('pegawai_id', $employee->id)
                ->where('status', 'Aktif')
                ->whereNotNull('nomor_surat')
                ->where('nomor_surat', '!=', '')
                ->latest()
                ->get();
            $spCount = $spLetters->count();
        }

        return view('pegawai.pelanggaran-sp', compact('employee', 'spCount', 'alphaCount', 'spLetters'));
    }

    public function exportPdf($id)
    {
        $employee = Auth::user()->pegawai;
        if (!$employee) {
            return back()->with('error', 'Data pegawai tidak ditemukan.');
        }

        $sp = SuratPeringatan::with('pegawai')->find($id);
        if (!$sp) {
            abort(404, 'Surat Peringatan tidak ditemukan.');
        }

        if ($sp->pegawai_id !== $employee->id) {
            abort(403, 'Anda tidak memiliki hak akses untuk mengunduh Surat Peringatan ini.');
        }

        if (empty($sp->nomor_surat)) {
            return back()->with('error', 'Surat Peringatan belum diterbitkan secara resmi.');
        }

        $settings = PengaturanKantor::getPengaturan();

        $pdf = Pdf::loadView('admin.exports.cetak-sp-pdf', [
            'sp' => $sp,
            'settings' => $settings
        ]);

        $filename = 'Surat_Peringatan_' . $sp->tingkat_sp . '_' . str_replace(' ', '_', $sp->pegawai->nama) . '.pdf';

        return $pdf->download($filename);
    }
}
