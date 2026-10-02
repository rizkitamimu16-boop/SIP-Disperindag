<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengajuanIzin;
use App\Models\Presensi;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminPengajuanController extends Controller
{
    public function index(Request $request): View
    {
        $query = PengajuanIzin::with('pegawai')->latest();

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $leaveRequests = $query->get();

        $stats = [
            'total'    => PengajuanIzin::count(),
            'pending'  => PengajuanIzin::where('status', 'Menunggu Review')->count(),
            'approved' => PengajuanIzin::where('status', 'Disetujui')->count(),
            'rejected' => PengajuanIzin::where('status', 'Ditolak')->count(),
        ];

        return view('admin.persetujuan-izin-cuti', [
            'leaveRequests' => $leaveRequests,
            'pengajuanList' => $leaveRequests,
            'stats'         => $stats,
        ]);
    }

    public function updateStatus(Request $request, int $id): RedirectResponse
    {
        $pengajuan = PengajuanIzin::findOrFail($id);

        $validated = $request->validate([
            'status'        => 'required|in:Disetujui,Ditolak',
            'catatan_admin' => 'nullable|string',
        ]);

        $pengajuan->update([
            'status'            => $validated['status'],
            'catatan_admin'     => $validated['catatan_admin'] ?? null,
            'tanggal_disetujui' => Carbon::now(),
        ]);

        $startDate = Carbon::parse($pengajuan->tanggal_mulai);
        $endDate = Carbon::parse($pengajuan->tanggal_selesai);

        if ($validated['status'] === 'Disetujui') {
            for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
                Presensi::updateOrCreate(
                    [
                        'pegawai_id' => $pengajuan->pegawai_id,
                        'tanggal'    => $date->toDateString(),
                    ],
                    [
                        'status' => $pengajuan->jenis,
                    ]
                );
            }
        } elseif ($validated['status'] === 'Ditolak') {
            // Jika ditolak, dan tidak ada data absen di tanggal tersebut, jadikan Alpha
            for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
                $existing = Presensi::where('pegawai_id', $pengajuan->pegawai_id)
                    ->where('tanggal', $date->toDateString())
                    ->first();
                
                if (!$existing || $existing->status === 'Alpha') {
                    Presensi::updateOrCreate(
                        [
                            'pegawai_id' => $pengajuan->pegawai_id,
                            'tanggal'    => $date->toDateString(),
                        ],
                        [
                            'status' => 'Alpha',
                        ]
                    );
                }
            }
        }

        return back()->with('success', "Pengajuan {$pengajuan->jenis} pegawai {$pengajuan->pegawai->nama} berhasil diubah menjadi '{$validated['status']}'.");
    }
}
