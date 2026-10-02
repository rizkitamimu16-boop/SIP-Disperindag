<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Presensi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminAbsensiController extends Controller
{
    public function index(Request $request): View
    {
        $today = Carbon::today()->toDateString();
        $selectedDate = $request->get('date', $today);

        $query = Presensi::with('pegawai')->latest();

        if ($request->filled('date')) {
            $query->where('tanggal', $request->date);
        }

        if ($request->filled('status') && $request->status !== 'Semua Status') {
            $query->where('status', $request->status);
        }

        $presensiList = $query->get();

        $stats = [
            'tepat_waktu' => Presensi::where('tanggal', $selectedDate)->where('status', 'Hadir')->count(),
            'terlambat'   => Presensi::where('tanggal', $selectedDate)->where('status', 'Terlambat')->count(),
            'alpha'       => Presensi::where('tanggal', $selectedDate)->where('status', 'Alpha')->count(),
            'izin_cuti'   => Presensi::where('tanggal', $selectedDate)->whereIn('status', ['Izin', 'Cuti', 'Dinas Luar'])->count(),
        ];

        return view('admin.monitoring-absensi', [
            'attendances'  => $presensiList,
            'presensiList' => $presensiList,
            'selectedDate' => $selectedDate,
            'stats'        => $stats,
        ]);
    }
}
