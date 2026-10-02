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
        $query = SuratPeringatan::with('pegawai')->latest();

        if ($request->filled('sp_level')) {
            $query->where('tingkat_sp', $request->sp_level);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
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
            'nomor_surat' => $request->nomor_surat,
            'tanggal_terbit' => Carbon::now()->format('Y-m-d'),
            'status' => 'Terbit', // assuming 'Terbit' is in the database enum or just use 'Selesai' if that's what was in DB
        ]);

        return back()->with('success', "Surat Peringatan {$sp->tingkat_sp} untuk pegawai {$sp->pegawai->nama} berhasil diterbitkan.");
    }

    public function exportPdf($id)
    {
        $sp = SuratPeringatan::with('pegawai')->findOrFail($id);
        
        if ($sp->status !== 'Terbit' && $sp->status !== 'Selesai') {
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
