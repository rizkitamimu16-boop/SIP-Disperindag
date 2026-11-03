<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengaturanKantor;
use App\Models\SuratPeringatan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminSpController extends Controller
{
    public function index(Request $request): View
    {
        // Deteksi ambang batas dan sinkronisasi draf SP otomatis
        SuratPeringatan::syncAllDrafts();

        $query = SuratPeringatan::with('pegawai')->latest();

        if ($request->filled('sp_level')) {
            $level = str_replace(['SP', '-'], '', $request->sp_level);
            $query->where('tingkat_sp', 'SP-' . $level);
        }

        if ($request->filled('status')) {
            if ($request->status === 'Pending Review' || $request->status === 'Draft') {
                $query->where(function ($q) {
                    $q->whereNull('nomor_surat')->orWhere('nomor_surat', '');
                });
            } elseif ($request->status === 'Terbit' || $request->status === 'Aktif') {
                $query->whereNotNull('nomor_surat')->where('nomor_surat', '!=', '');
            } else {
                $query->where('status', $request->status);
            }
        }

        $spLetters = $query->get();
        $settings = PengaturanKantor::getPengaturan();

        return view('admin.surat-peringatan', [
            'spLetters' => $spLetters,
            'settings'  => $settings,
        ]);
    }

    public function terbitkan(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'nomor_surat' => 'required|string|max:100',
        ]);

        $sp = SuratPeringatan::findOrFail($id);
        
        $sp->update([
            'nomor_surat'    => $request->nomor_surat,
            'tanggal_terbit' => Carbon::now()->format('Y-m-d'),
            'status'         => 'Aktif',
        ]);

        return back()->with('success', "Surat Peringatan {$sp->tingkat_sp} untuk pegawai {$sp->pegawai->nama} berhasil diterbitkan.");
    }

    public function exportPdf($id)
    {
        $sp = SuratPeringatan::with('pegawai')->findOrFail($id);
        
        if (empty($sp->nomor_surat)) {
            return back()->with('error', 'Surat Peringatan belum diterbitkan (belum ada nomor surat).');
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
