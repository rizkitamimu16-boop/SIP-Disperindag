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
        $user = auth()->user();
        $isKabid = $user ? $user->isKabid() : false;
        $kabidBidang = $isKabid ? $user->bidang : null;

        $query = PengajuanIzin::with('pegawai')->latest();

        if ($isKabid) {
            $query->whereHas('pegawai', fn($q) => $q->where('bidang', $kabidBidang));
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $leaveRequests = $query->get();

        $statsBase = PengajuanIzin::query();
        if ($isKabid) {
            $statsBase->whereHas('pegawai', fn($q) => $q->where('bidang', $kabidBidang));
        }

        $stats = [
            'total'    => (clone $statsBase)->count(),
            'pending'  => (clone $statsBase)->where('status', 'Menunggu Review')->count(),
            'approved' => (clone $statsBase)->where('status', 'Disetujui')->count(),
            'rejected' => (clone $statsBase)->where('status', 'Ditolak')->count(),
        ];

        return view('admin.persetujuan-izin-cuti', [
            'leaveRequests' => $leaveRequests,
            'pengajuanList' => $leaveRequests,
            'stats'         => $stats,
            'isKabid'       => $isKabid,
            'kabidBidang'   => $kabidBidang,
        ]);
    }

    public function updateStatus(Request $request, int $id): RedirectResponse
    {
        $pengajuan = PengajuanIzin::with('pegawai')->findOrFail($id);

        $user = auth()->user();
        if ($user && $user->isKabid() && ($pengajuan->pegawai->bidang ?? '') !== $user->bidang) {
            abort(403, 'Anda tidak berwenang memproses permohonan izin pegawai di luar bidang Anda.');
        }

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
            // Pemetaan jenis pengajuan ke status presensi sesuai skema database enum('Hadir','Terlambat','Alpha','Izin','Cuti','Dinas Luar','Sakit')
            $statusPresensi = match ($pengajuan->jenis) {
                'Sakit'      => 'Sakit',
                'Cuti'       => 'Cuti',
                'Dinas Luar' => 'Dinas Luar',
                default      => 'Izin',
            };

            for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
                // Hari libur akhir pekan (Sabtu & Minggu) bukan hari kerja kantor, lewati pencatatan presensi
                if ($date->isWeekend()) {
                    continue;
                }

                Presensi::updateOrCreate(
                    [
                        'pegawai_id' => $pengajuan->pegawai_id,
                        'tanggal'    => $date->toDateString(),
                    ],
                    [
                        'status' => $statusPresensi,
                    ]
                );
            }
        } elseif ($validated['status'] === 'Ditolak') {
            // Jika ditolak, dan tidak ada data absen di tanggal tersebut, jadikan Alpha (kecuali akhir pekan)
            for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
                if ($date->isWeekend()) {
                    continue;
                }

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

        return redirect()->route('admin.persetujuan-izin-cuti')->with('success', "Status pengajuan telah diubah menjadi {$validated['status']}.");
    }
}
