<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Pegawai;
use App\Models\Presensi;
use App\Models\SkorKinerja;
use App\Models\LaporanKegiatan;
use App\Models\SuratPeringatan;
use Carbon\Carbon;

class AdminLaporanController extends Controller
{
    public function index(Request $request): View
    {
        $activeTab = $request->get('tab', 'absensi');
        
        $attendanceReports = collect();
        $performanceReports = collect();
        $activityReports = collect();
        $spReports = collect();

        // 1. Laporan Absensi
        $monthAbsensi = $request->get('month_absensi', Carbon::now()->format('Y-m'));
        $bidangAbsensi = $request->get('bidang_absensi');
        $statusAbsensi = $request->get('status_absensi');
        
        $queryPegawaiAbsensi = Pegawai::query();
        if ($bidangAbsensi) {
            $queryPegawaiAbsensi->where('bidang', $bidangAbsensi);
        }
        
        $pegawaiListAbsensi = $queryPegawaiAbsensi->get();
        $yearAbsensi = explode('-', $monthAbsensi)[0] ?? Carbon::now()->year;
        $monthNumAbsensi = explode('-', $monthAbsensi)[1] ?? Carbon::now()->month;

        $attendanceReports = $pegawaiListAbsensi->map(function ($p) use ($yearAbsensi, $monthNumAbsensi, $statusAbsensi) {
            $q = Presensi::where('pegawai_id', $p->id)
                         ->whereYear('tanggal', $yearAbsensi)
                         ->whereMonth('tanggal', $monthNumAbsensi);
                         
            if ($statusAbsensi && $statusAbsensi !== 'semua') {
                if ($statusAbsensi === 'hadir') {
                    $q->whereIn('status', ['Hadir', 'Terlambat']);
                } else if (in_array($statusAbsensi, ['izin', 'cuti', 'sakit', 'dinas_luar'])) {
                    $q->where('status', 'like', "%{$statusAbsensi}%");
                } else {
                    $q->where('status', ucfirst($statusAbsensi));
                }
            }
            
            $total = $q->count();
            return (object)[
                'employee_name' => $p->nama,
                'nip' => $p->nip,
                'department' => $p->bidang,
                'total_hadir' => $total
            ];
        });
        
        if ($statusAbsensi && $statusAbsensi !== 'semua') {
            $attendanceReports = $attendanceReports->filter(function($item) {
                return $item->total_hadir > 0;
            })->values();
        }
        
        // 2. Laporan Kinerja
        $monthKinerja = $request->get('month_kinerja', Carbon::now()->format('Y-m'));
        $bidangKinerja = $request->get('bidang_kinerja');
        $kategoriKinerja = $request->get('kategori_kinerja');
        
        $pegawaiQueryKinerja = Pegawai::where('status', 'Aktif');
        if ($bidangKinerja) {
            $pegawaiQueryKinerja->where('bidang', $bidangKinerja);
        }
        $pegawaiListKinerja = $pegawaiQueryKinerja->get();

        $performanceReports = $pegawaiListKinerja->map(function ($p) use ($monthKinerja) {
            $skor = SkorKinerja::where('pegawai_id', $p->id)
                ->where('periode', $monthKinerja)
                ->first();

            if (!$skor) {
                $skor = SkorKinerja::calculateLiveScore($p->id, $monthKinerja);
            }

            return (object)[
                'employee_name' => $p->nama ?? '-',
                'department'    => $p->bidang ?? '-',
                'ikp_score'     => $skor->nilai_akhir ?? 0,
                'predikat'      => $skor->kategori ?? 'Kurang',
            ];
        });
        
        if ($kategoriKinerja && $kategoriKinerja !== 'semua') {
            $kategoriMap = [
                'sangat_baik' => 'Sangat Baik',
                'baik'        => 'Baik',
                'cukup'       => 'Cukup',
                'kurang'      => 'Kurang',
            ];
            if (isset($kategoriMap[$kategoriKinerja])) {
                $performanceReports = $performanceReports->where('predikat', $kategoriMap[$kategoriKinerja])->values();
            }
        }
        
        // 3. Laporan Kegiatan
        $periodeKegiatan = $request->get('periode_kegiatan', 'rentang');
        $bidangKegiatan = $request->get('bidang_kegiatan');
        $statusKegiatan = $request->get('status_kegiatan');

        $queryKegiatan = LaporanKegiatan::with('pegawai');

        if ($periodeKegiatan === 'bulanan') {
            $month = $request->get('month_kegiatan', Carbon::now()->format('Y-m'));
            $y = explode('-', $month)[0] ?? Carbon::now()->year;
            $m = explode('-', $month)[1] ?? Carbon::now()->month;
            $queryKegiatan->whereYear('tanggal', $y)->whereMonth('tanggal', $m);
        } elseif ($periodeKegiatan === 'tahunan') {
            $y = $request->get('year_kegiatan', Carbon::now()->year);
            $queryKegiatan->whereYear('tanggal', $y);
        } elseif ($request->filled('date_kegiatan')) {
            $queryKegiatan->whereDate('tanggal', $request->date_kegiatan);
        } else {
            $startDate = $request->get('start_date_kegiatan', Carbon::now()->startOfMonth()->toDateString());
            $endDate = $request->get('end_date_kegiatan', Carbon::today()->toDateString());
            $queryKegiatan->whereBetween('tanggal', [$startDate, $endDate]);
        }
        
        if ($bidangKegiatan) {
            $queryKegiatan->whereHas('pegawai', function($q) use ($bidangKegiatan) {
                $q->where('bidang', $bidangKegiatan);
            });
        }
        if ($statusKegiatan && $statusKegiatan !== 'semua') {
            $queryKegiatan->where('status_verifikasi', ucfirst($statusKegiatan));
        }
        
        $activityReports = $queryKegiatan->orderBy('tanggal', 'desc')->get()->map(function($act) {
            return (object)[
                'employee_name' => $act->pegawai->nama ?? '-',
                'date'          => $act->tanggal ? (is_object($act->tanggal) ? $act->tanggal->toDateString() : $act->tanggal) : '-',
                'activity_name' => $act->nama_kegiatan ?? $act->kegiatan ?? '-',
                'status'        => strtolower($act->status_verifikasi),
            ];
        });
        
        // 4. Laporan SP
        $yearSp = $request->get('year_sp', Carbon::now()->year);
        $bidangSp = $request->get('bidang_sp');
        $tingkatSp = $request->get('tingkat_sp');
        
        $querySp = SuratPeringatan::with('pegawai')->whereYear('tanggal_terbit', $yearSp);
        
        if ($bidangSp) {
            $querySp->whereHas('pegawai', function($q) use ($bidangSp) {
                $q->where('bidang', $bidangSp);
            });
        }
        if ($tingkatSp && $tingkatSp !== 'semua') {
            $querySp->where('tingkat_sp', $tingkatSp);
        }
        
        $spReports = $querySp->get()->map(function($sp) {
            return (object)[
                'id'            => $sp->id,
                'employee_name' => $sp->pegawai->nama ?? '-',
                'nip'           => $sp->pegawai->nip ?? '-',
                'department'    => $sp->pegawai->bidang ?? '-',
                'sp_level'      => $sp->tingkat_sp,
                'letter_number' => $sp->nomor_surat,
                'date_issued'   => $sp->tanggal_terbit,
                'status'        => $sp->status,
            ];
        });
        
        return view('admin.pusat-laporan', compact(
            'activeTab',
            'attendanceReports',
            'performanceReports',
            'activityReports',
            'spReports'
        ));
    }
    
    public function export(Request $request, $format)
    {
        $activeTab = $request->get('tab', 'absensi');
        $settings = \App\Models\PengaturanKantor::getPengaturan();
        
        if ($format === 'excel') {
            if ($activeTab === 'absensi') {
                return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\AbsensiExport($request), 'Laporan_Absensi_Pegawai.xlsx');
            } elseif ($activeTab === 'kinerja') {
                return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\KinerjaExport($request), 'Laporan_Kinerja_Pegawai.xlsx');
            } elseif ($activeTab === 'kegiatan') {
                return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\KegiatanExport($request), 'Laporan_Kegiatan_Pegawai.xlsx');
            } elseif ($activeTab === 'sp') {
                return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\SpExport($request), 'Laporan_Surat_Peringatan.xlsx');
            }
            return back()->with('error', 'Tab laporan tidak valid untuk ekspor Excel.');
        }
        
        if ($format === 'pdf') {
            if ($activeTab === 'absensi') {
                $export = new \App\Exports\AbsensiExport($request);
                $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView($export->viewName, array_merge($export->viewData, ['settings' => $settings]))->setPaper('a4', 'landscape');
                return $pdf->download('Laporan_Absensi_Pegawai.pdf');
            } elseif ($activeTab === 'kinerja') {
                $export = new \App\Exports\KinerjaExport($request);
                $reports = $export->collection();
                $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.exports.kinerja-pdf', compact('reports', 'settings'));
                return $pdf->download('Laporan_Kinerja_Pegawai.pdf');
            } elseif ($activeTab === 'kegiatan') {
                $export = new \App\Exports\KegiatanExport($request);
                $reports = $export->collection();
                $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.exports.kegiatan-pdf', compact('reports', 'settings'));
                return $pdf->download('Laporan_Kegiatan_Pegawai.pdf');
            } elseif ($activeTab === 'sp') {
                $export = new \App\Exports\SpExport($request);
                $reports = $export->collection();
                $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.exports.sp-pdf', compact('reports', 'settings'));
                return $pdf->download('Laporan_Surat_Peringatan.pdf');
            }
            return back()->with('error', 'Tab laporan tidak valid untuk ekspor PDF.');
        }
        
        return back()->with('error', 'Format tidak valid');
    }
}
