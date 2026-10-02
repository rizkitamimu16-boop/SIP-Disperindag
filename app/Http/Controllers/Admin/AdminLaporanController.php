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
        if ($activeTab === 'absensi') {
            $month = $request->get('month_absensi', Carbon::now()->format('Y-m'));
            $bidang = $request->get('bidang_absensi');
            $status = $request->get('status_absensi');
            
            $query = Pegawai::query();
            if ($bidang) {
                $query->where('bidang', $bidang);
            }
            
            $pegawaiList = $query->get();
            $year = explode('-', $month)[0] ?? Carbon::now()->year;
            $monthNum = explode('-', $month)[1] ?? Carbon::now()->month;

            $attendanceReports = $pegawaiList->map(function ($p) use ($year, $monthNum, $status) {
                $q = Presensi::where('pegawai_id', $p->id)
                             ->whereYear('tanggal', $year)
                             ->whereMonth('tanggal', $monthNum);
                             
                if ($status && $status !== 'semua') {
                    if ($status === 'hadir') {
                        $q->whereIn('status', ['Hadir', 'Terlambat']);
                    } else if (in_array($status, ['izin', 'cuti', 'sakit', 'dinas_luar'])) {
                        $q->where('status', 'like', "%{$status}%");
                    } else {
                        $q->where('status', ucfirst($status));
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
            
            if ($status && $status !== 'semua') {
                $attendanceReports = $attendanceReports->filter(function($item) {
                    return $item->total_hadir > 0;
                })->values();
            }
        }
        
        // 2. Laporan Kinerja
        if ($activeTab === 'kinerja') {
            $month = $request->get('month_kinerja', Carbon::now()->format('Y-m'));
            $bidang = $request->get('bidang_kinerja');
            $kategori = $request->get('kategori_kinerja');
            
            $query = SkorKinerja::with('pegawai')->where('periode', $month);
            
            if ($bidang) {
                $query->whereHas('pegawai', function($q) use ($bidang) {
                    $q->where('bidang', $bidang);
                });
            }
            
            $performanceReports = $query->get()->map(function($skor) {
                return (object)[
                    'employee_name' => $skor->pegawai->nama ?? '-',
                    'department' => $skor->pegawai->bidang ?? '-',
                    'ikp_score' => $skor->nilai_akhir,
                    'predikat' => $skor->predikat,
                ];
            });
            
            if ($kategori && $kategori !== 'semua') {
                $kategoriMap = [
                    'sangat_baik' => 'Sangat Baik',
                    'baik' => 'Baik',
                    'cukup' => 'Cukup',
                    'kurang' => 'Kurang',
                ];
                if (isset($kategoriMap[$kategori])) {
                    $performanceReports = $performanceReports->where('predikat', $kategoriMap[$kategori])->values();
                }
            }
        }
        
        // 3. Laporan Kegiatan
        if ($activeTab === 'kegiatan') {
            $date = $request->get('date_kegiatan', Carbon::today()->toDateString());
            $bidang = $request->get('bidang_kegiatan');
            $status = $request->get('status_kegiatan');
            
            $query = LaporanKegiatan::with('pegawai')->whereDate('tanggal', $date);
            
            if ($bidang) {
                $query->whereHas('pegawai', function($q) use ($bidang) {
                    $q->where('bidang', $bidang);
                });
            }
            if ($status && $status !== 'semua') {
                $query->where('status_verifikasi', ucfirst($status));
            }
            
            $activityReports = $query->get()->map(function($act) {
                return (object)[
                    'employee_name' => $act->pegawai->nama ?? '-',
                    'date' => $act->tanggal,
                    'activity_name' => $act->kegiatan,
                    'status' => strtolower($act->status_verifikasi),
                ];
            });
        }
        
        // 4. Laporan SP
        if ($activeTab === 'sp') {
            $year = $request->get('year_sp', Carbon::now()->year);
            $bidang = $request->get('bidang_sp');
            $tingkat = $request->get('tingkat_sp');
            
            $query = SuratPeringatan::with('pegawai')->whereYear('tanggal_terbit', $year);
            
            if ($bidang) {
                $query->whereHas('pegawai', function($q) use ($bidang) {
                    $q->where('bidang', $bidang);
                });
            }
            if ($tingkat && $tingkat !== 'semua') {
                $query->where('tingkat_sp', $tingkat);
            }
            
            $spReports = $query->get()->map(function($sp) {
                return (object)[
                    'employee_name' => $sp->pegawai->nama ?? '-',
                    'nip' => $sp->pegawai->nip ?? '-',
                    'department' => $sp->pegawai->bidang ?? '-',
                    'sp_level' => $sp->tingkat_sp,
                    'letter_number' => $sp->nomor_surat,
                    'date_issued' => $sp->tanggal_terbit,
                    'status' => $sp->status,
                ];
            });
        }
        
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
        
        // This is a placeholder for actual export logic using maatwebsite/excel or dompdf.
        // Once installed, we will generate the corresponding file.
        
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
            return back()->with('success', 'Fungsi Ekspor Excel siap diintegrasikan. (Data sedang diproses)');
        }
        
        if ($format === 'pdf') {
            if ($activeTab === 'absensi') {
                $export = new \App\Exports\AbsensiExport($request);
                $reports = $export->collection();
                $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.exports.absensi-pdf', compact('reports'));
                return $pdf->download('Laporan_Absensi_Pegawai.pdf');
            } elseif ($activeTab === 'kinerja') {
                $export = new \App\Exports\KinerjaExport($request);
                $reports = $export->collection();
                $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.exports.kinerja-pdf', compact('reports'));
                return $pdf->download('Laporan_Kinerja_Pegawai.pdf');
            } elseif ($activeTab === 'kegiatan') {
                $export = new \App\Exports\KegiatanExport($request);
                $reports = $export->collection();
                $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.exports.kegiatan-pdf', compact('reports'));
                return $pdf->download('Laporan_Kegiatan_Pegawai.pdf');
            } elseif ($activeTab === 'sp') {
                $export = new \App\Exports\SpExport($request);
                $reports = $export->collection();
                $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.exports.sp-pdf', compact('reports'));
                return $pdf->download('Laporan_Surat_Peringatan.pdf');
            }
            return back()->with('success', 'Fungsi Ekspor PDF siap diintegrasikan. (Data sedang diproses)');
        }
        
        return back()->with('error', 'Format tidak valid');
    }
}
