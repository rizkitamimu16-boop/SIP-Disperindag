<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use App\Models\PengajuanIzin;
use App\Models\Presensi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminAbsensiController extends Controller
{
    public function index(Request $request): View
    {
        $today = Carbon::today()->toDateString();
        $targetDate = $request->get('date', $today);

        // Ambil seluruh pegawai aktif PPPK (23 pegawai)
        $pegawaiList = Pegawai::where('status', 'Aktif')->orderBy('nama')->get();
        $totalPegawai = $pegawaiList->count();

        // Ambil data presensi yang sudah tercatat pada targetDate
        $presensiHariIni = Presensi::with('pegawai')
            ->where('tanggal', $targetDate)
            ->get()
            ->keyBy('pegawai_id');

        // Ambil izin/cuti/sakit yang disetujui pada targetDate
        $izinsHariIni = PengajuanIzin::where('status', 'Disetujui')
            ->whereDate('tanggal_mulai', '<=', $targetDate)
            ->whereDate('tanggal_selesai', '>=', $targetDate)
            ->get()
            ->keyBy('pegawai_id');

        // Bentuk list presensi harian lengkap untuk seluruh 23 pegawai aktif
        $dailyRoster = collect();
        foreach ($pegawaiList as $pegawai) {
            if ($presensiHariIni->has($pegawai->id)) {
                $dailyRoster->push($presensiHariIni->get($pegawai->id));
            } elseif ($izinsHariIni->has($pegawai->id)) {
                $izin = $izinsHariIni->get($pegawai->id);
                $p = new Presensi([
                    'pegawai_id'   => $pegawai->id,
                    'tanggal'      => $targetDate,
                    'status'       => $izin->jenis,
                    'status_masuk' => $izin->jenis,
                    'catatan'      => $izin->alasan,
                ]);
                $p->setRelation('pegawai', $pegawai);
                $dailyRoster->push($p);
            } else {
                // Pegawai belum absen -> Alpha / Belum Hadir
                $p = new Presensi([
                    'pegawai_id'   => $pegawai->id,
                    'tanggal'      => $targetDate,
                    'status'       => 'Alpha',
                    'status_masuk' => 'Belum Hadir',
                    'jam_masuk'    => null,
                    'jam_pulang'   => null,
                ]);
                $p->setRelation('pegawai', $pegawai);
                $dailyRoster->push($p);
            }
        }

        // Ambil juga riwayat presensi hari-hari lainnya agar filter bulan/tahun tetap menyajikan data historis
        $pastPresensis = Presensi::with('pegawai')
            ->where('tanggal', '!=', $targetDate)
            ->latest('tanggal')
            ->take(300)
            ->get();

        $combinedPresensi = $dailyRoster->merge($pastPresensis);

        $stats = [
            'tepat_waktu' => $dailyRoster->where('status', 'Hadir')->filter(fn($p) => ($p->status_masuk ?? 'Tepat Waktu') === 'Tepat Waktu')->count(),
            'terlambat'   => $dailyRoster->where('status', 'Terlambat')->count(),
            'alpha'       => $dailyRoster->where('status', 'Alpha')->count(),
            'izin_cuti'   => $dailyRoster->whereIn('status', ['Izin', 'Cuti', 'Sakit', 'Dinas Luar'])->count(),
        ];

        return view('admin.monitoring-absensi', [
            'attendances'   => $combinedPresensi,
            'presensiList'  => $combinedPresensi,
            'selectedDate'  => $targetDate,
            'totalPegawai'  => $totalPegawai,
            'stats'         => $stats,
        ]);
    }
}
