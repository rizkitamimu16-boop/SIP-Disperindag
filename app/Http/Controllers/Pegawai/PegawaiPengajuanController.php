<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Models\PengajuanIzin;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PegawaiPengajuanController extends Controller
{
    public function index(): View
    {
        $employee = Auth::user()->pegawai;
        $leaveRequests = collect();

        if ($employee) {
            $leaveRequests = PengajuanIzin::where('pegawai_id', $employee->id)->latest()->get();
        }

        return view('pegawai.pengajuan', [
            'leaveRequests' => $leaveRequests,
            'pengajuanList' => $leaveRequests,
            'employee'      => $employee,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'jenis'           => 'required|in:Cuti,Izin,Sakit,Dinas Luar',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'alasan'          => 'required|string',
            'dokumen'         => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ], [
            'jenis.required'                     => 'Pilih jenis permohonan dispensasi.',
            'tanggal_mulai.required'             => 'Tanggal mulai dispensasi wajib diisi.',
            'tanggal_selesai.after_or_equal'     => 'Tanggal selesai tidak boleh sebelum tanggal mulai.',
            'alasan.required'                    => 'Uraian alasan permohonan wajib diisi.',
        ]);

        $employee = Auth::user()->pegawai;
        if (!$employee) {
            return back()->withErrors(['error' => 'Data pegawai tidak ditemukan.']);
        }

        $today = Carbon::today()->toDateString();
        $existingPengajuan = PengajuanIzin::where('pegawai_id', $employee->id)
            ->whereDate('created_at', $today)
            ->first();
            
        if ($existingPengajuan) {
            return back()->withErrors(['error' => 'Anda sudah melakukan pengajuan hari ini. Pengajuan hanya dapat dilakukan 1 kali per hari.']);
        }

        $documentPath = null;
        if ($request->hasFile('dokumen')) {
            $documentPath = $request->file('dokumen')->store('dokumen_izin', 'public');
        }

        PengajuanIzin::create([
            'pegawai_id'      => $employee->id,
            'jenis'           => $validated['jenis'],
            'tanggal_mulai'   => $validated['tanggal_mulai'],
            'tanggal_selesai' => $validated['tanggal_selesai'],
            'alasan'          => $validated['alasan'],
            'dokumen'         => $documentPath,
            'status'          => 'Menunggu Review',
        ]);

        return back()->with('success', 'Permohonan dispensasi berhasil diajukan dan sedang menunggu persetujuan admin.');
    }
}
