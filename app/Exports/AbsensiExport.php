<?php

namespace App\Exports;

use App\Models\Pegawai;
use App\Models\Presensi;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AbsensiExport implements FromView, ShouldAutoSize
{
    protected $request;
    public $viewName;
    public $viewData;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->prepareData();
    }

    protected function prepareData()
    {
        $periode = $this->request->get('periode_absensi', 'bulanan');
        $bidang = $this->request->get('bidang_absensi');
        $status = $this->request->get('status_absensi');
        
        $query = Pegawai::query();
        if ($bidang) {
            $query->where('bidang', $bidang);
        }
        $pegawaiList = $query->get();

        if ($periode === 'tahunan') {
            $year = $this->request->get('year_absensi', Carbon::now()->year);
            $reports = $pegawaiList->map(function ($p) use ($year, $status) {
                $attendances = Presensi::where('pegawai_id', $p->id)
                    ->whereYear('tanggal', $year)
                    ->get();
                
                $monthly = [];
                for ($m=1; $m<=12; $m++) {
                    $mStr = sprintf("%02d", $m);
                    $monthly[$m] = $attendances->where('tanggal', '>=', "$year-$mStr-01")
                                              ->where('tanggal', '<=', "$year-$mStr-31")
                                              ->whereIn('status', ['Hadir', 'Terlambat'])
                                              ->count();
                }
                
                return (object)[
                    'employee_name' => $p->nama,
                    'nip' => $p->nip,
                    'department' => $p->bidang,
                    'monthly' => $monthly,
                    'total_hadir' => $attendances->whereIn('status', ['Hadir', 'Terlambat'])->count(),
                    'total_izin' => $attendances->where('status', 'Izin')->count(),
                    'total_sakit' => $attendances->where('status', 'Sakit')->count(),
                    'total_tk' => $attendances->where('status', 'Alpha')->count(),
                    'total_tl' => $attendances->where('status', 'Terlambat')->count(),
                    'total_ptg' => $attendances->whereNull('jam_pulang')->whereNotNull('jam_masuk')->count(),
                ];
            });
            
            
            $this->viewName = 'admin.exports.absensi-tahunan';
            $this->viewData = ['reports' => $reports, 'year' => $year];
        } elseif ($periode === 'rentang') {
            $startDate = $this->request->get('start_date_absensi', Carbon::now()->startOfMonth()->toDateString());
            $endDate = $this->request->get('end_date_absensi', Carbon::today()->toDateString());
            
            $start = Carbon::parse($startDate);
            $end = Carbon::parse($endDate);
            
            $dates = [];
            $current = $start->copy();
            while($current <= $end) {
                $dates[] = $current->copy();
                $current->addDay();
            }

            $reports = $pegawaiList->map(function ($p) use ($startDate, $endDate, $dates) {
                $attendances = Presensi::where('pegawai_id', $p->id)
                    ->whereBetween('tanggal', [$startDate, $endDate])
                    ->get();
                
                $daily = [];
                foreach ($dates as $dateObj) {
                    $dateStr = $dateObj->toDateString();
                    $colKey = $dateObj->format('d/m');
                    $att = $attendances->firstWhere('tanggal', $dateStr);
                    if ($att) {
                        if ($att->jam_masuk && !$att->jam_pulang) {
                            $daily[$colKey] = 'PTG';
                        } elseif ($att->status == 'Hadir') {
                            $daily[$colKey] = 'H';
                        } elseif ($att->status == 'Terlambat') {
                            $daily[$colKey] = 'TL';
                        } elseif ($att->status == 'Sakit') {
                            $daily[$colKey] = 'S';
                        } elseif ($att->status == 'Izin') {
                            $daily[$colKey] = 'I';
                        } elseif ($att->status == 'Alpha') {
                            $daily[$colKey] = 'TK';
                        } else {
                            $daily[$colKey] = substr($att->status, 0, 2);
                        }
                    } else {
                        $daily[$colKey] = '-';
                    }
                }
                
                return (object)[
                    'employee_name' => $p->nama,
                    'nip' => $p->nip,
                    'daily' => $daily,
                    's' => $attendances->where('status', 'Sakit')->count(),
                    'i' => $attendances->where('status', 'Izin')->count(),
                    'tk' => $attendances->where('status', 'Alpha')->count(),
                    'tl' => $attendances->where('status', 'Terlambat')->count(),
                    'ptg' => $attendances->whereNull('jam_pulang')->whereNotNull('jam_masuk')->count(),
                    'hadir' => $attendances->whereIn('status', ['Hadir', 'Terlambat'])->count(),
                ];
            });
            
            $this->viewName = 'admin.exports.absensi-rentang';
            $this->viewData = ['reports' => $reports, 'startDate' => $startDate, 'endDate' => $endDate, 'dates' => $dates];
        } else {
            // Default: Bulanan
            $month = $this->request->get('month_absensi', Carbon::now()->format('Y-m'));
            $year = explode('-', $month)[0] ?? Carbon::now()->year;
            $monthNum = explode('-', $month)[1] ?? Carbon::now()->month;
            $daysInMonth = Carbon::parse($month.'-01')->daysInMonth;

            $reports = $pegawaiList->map(function ($p) use ($year, $monthNum, $daysInMonth) {
                $attendances = Presensi::where('pegawai_id', $p->id)
                    ->whereYear('tanggal', $year)
                    ->whereMonth('tanggal', $monthNum)
                    ->get();
                
                $daily = [];
                for ($d=1; $d<=$daysInMonth; $d++) {
                    $dateStr = "$year-$monthNum-".sprintf("%02d", $d);
                    $att = $attendances->firstWhere('tanggal', $dateStr);
                    if ($att) {
                        if ($att->jam_masuk && !$att->jam_pulang) {
                            $daily[$d] = 'PTG';
                        } elseif ($att->status == 'Hadir') {
                            $daily[$d] = 'H';
                        } elseif ($att->status == 'Terlambat') {
                            $daily[$d] = 'TL';
                        } elseif ($att->status == 'Sakit') {
                            $daily[$d] = 'S';
                        } elseif ($att->status == 'Izin') {
                            $daily[$d] = 'I';
                        } elseif ($att->status == 'Alpha') {
                            $daily[$d] = 'TK';
                        } else {
                            $daily[$d] = substr($att->status, 0, 2);
                        }
                    } else {
                        $daily[$d] = '-';
                    }
                }
                
                return (object)[
                    'employee_name' => $p->nama,
                    'nip' => $p->nip,
                    'daily' => $daily,
                    's' => $attendances->where('status', 'Sakit')->count(),
                    'i' => $attendances->where('status', 'Izin')->count(),
                    'tk' => $attendances->where('status', 'Alpha')->count(),
                    'tl' => $attendances->where('status', 'Terlambat')->count(),
                    'ptg' => $attendances->whereNull('jam_pulang')->whereNotNull('jam_masuk')->count(),
                    'hadir' => $attendances->whereIn('status', ['Hadir', 'Terlambat'])->count(),
                ];
            });
            
            $this->viewName = 'admin.exports.absensi-bulanan';
            $this->viewData = ['reports' => $reports, 'month' => $month, 'daysInMonth' => $daysInMonth];
        }
    }

    public function view(): View
    {
        return view($this->viewName, $this->viewData);
    }
}
