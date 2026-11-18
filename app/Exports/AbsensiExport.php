<?php

namespace App\Exports;

use App\Models\Pegawai;
use App\Models\Presensi;
use App\Models\PengajuanIzin;
use App\Models\PengaturanKantor;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class AbsensiExport implements FromView, WithStyles, WithColumnWidths
{
    protected $request;
    public $periode;
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
        $this->periode = $periode;
        $bidang = $this->request->get('bidang_absensi');
        $status = $this->request->get('status_absensi');
        
        $query = Pegawai::query();
        if ($bidang) {
            $query->where('bidang', $bidang);
        }
        $search = $this->request->get('search_absensi');
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%");
            });
        }
        $pegawaiList = $query->orderBy('nama')->get();

        $pengaturan = PengaturanKantor::getPengaturan();
        $batasAkhirPulangStr = $pengaturan->batas_akhir_pulang ?? '18:00:00';
        $currentTimeStr = Carbon::now()->format('H:i:s');
        $todayDateStr = Carbon::today()->toDateString();

        if ($periode === 'tahunan') {
            $year = (int)$this->request->get('year_absensi', Carbon::now()->year);
            $reports = $pegawaiList->map(function ($p) use ($year, $todayDateStr, $currentTimeStr, $batasAkhirPulangStr) {
                $attendances = Presensi::where('pegawai_id', $p->id)
                    ->whereYear('tanggal', $year)
                    ->get();
                
                $monthly = [];
                for ($m = 1; $m <= 12; $m++) {
                    $mStr = sprintf("%02d", $m);
                    $monthly[$m] = $attendances->where('tanggal', '>=', "{$year}-{$mStr}-01")
                                              ->where('tanggal', '<=', "{$year}-{$mStr}-31")
                                              ->whereIn('status', ['Hadir', 'Terlambat'])
                                              ->count();
                }

                $totalTap = $attendances->filter(function($a) use ($todayDateStr, $currentTimeStr, $batasAkhirPulangStr) {
                    $dateStr = is_object($a->tanggal) ? $a->tanggal->toDateString() : substr((string)$a->tanggal, 0, 10);
                    $isPastDay = ($dateStr < $todayDateStr);
                    $isToday = ($dateStr === $todayDateStr);
                    $isTapCondition = ($isPastDay || ($isToday && $currentTimeStr > $batasAkhirPulangStr));
                    return (!empty($a->jam_masuk) && empty($a->jam_pulang) && $isTapCondition);
                })->count();
                
                return (object)[
                    'employee_name' => $p->nama,
                    'nip'           => $p->nip,
                    'department'    => $p->bidang,
                    'monthly'       => $monthly,
                    'total_hadir'   => $attendances->whereIn('status', ['Hadir', 'Terlambat'])->count(),
                    'total_izin'    => $attendances->whereIn('status', ['Izin', 'Cuti', 'Dinas Luar'])->count(),
                    'total_sakit'   => $attendances->where('status', 'Sakit')->count(),
                    'total_tk'      => $attendances->where('status', 'Alpha')->count(),
                    'total_tl'      => $attendances->where('status', 'Terlambat')->count(),
                    'total_tap'     => $totalTap,
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

            // Hari kerja kantor aktif (Senin - Jumat yang ada presensi)
            $activeOfficeDates = Presensi::whereBetween('tanggal', [$startDate, $endDate])
                ->whereRaw('DAYOFWEEK(tanggal) NOT IN (1, 7)')
                ->distinct('tanggal')
                ->pluck('tanggal')
                ->map(fn($t) => is_object($t) ? $t->toDateString() : substr((string)$t, 0, 10))
                ->unique()
                ->toArray();

            $reports = $pegawaiList->map(function ($p) use ($startDate, $endDate, $dates, $todayDateStr, $currentTimeStr, $batasAkhirPulangStr, $activeOfficeDates) {
                $attendances = Presensi::where('pegawai_id', $p->id)
                    ->whereBetween('tanggal', [$startDate, $endDate])
                    ->get();

                $approvedIzins = PengajuanIzin::where('pegawai_id', $p->id)
                    ->where('status', 'Disetujui')
                    ->where(function($q) use ($startDate, $endDate) {
                        $q->whereBetween('tanggal_mulai', [$startDate, $endDate])
                          ->orWhereBetween('tanggal_selesai', [$startDate, $endDate]);
                    })
                    ->get();

                $daily = [];
                $hCount = 0;
                $sCount = 0;
                $iCount = 0;
                $tkCount = 0;
                $tlCount = 0;
                $tapCount = 0;

                foreach ($dates as $dateObj) {
                    $dateStr = $dateObj->toDateString();
                    $colKey = $dateObj->format('d/m');
                    $isWeekend = $dateObj->isWeekend();
                    $isPastDay = ($dateStr < $todayDateStr);
                    $isToday = ($dateStr === $todayDateStr);

                    if ($isWeekend) {
                        $daily[$colKey] = '-';
                        continue;
                    }

                    $att = $attendances->first(function ($a) use ($dateStr) {
                        if (is_object($a->tanggal)) {
                            return $a->tanggal->toDateString() === $dateStr;
                        }
                        return str_starts_with((string)$a->tanggal, $dateStr);
                    });

                    $matchingIzin = $approvedIzins->first(function($iz) use ($dateStr) {
                        $start = is_object($iz->tanggal_mulai) ? $iz->tanggal_mulai->toDateString() : substr((string)$iz->tanggal_mulai, 0, 10);
                        $end = is_object($iz->tanggal_selesai) ? $iz->tanggal_selesai->toDateString() : substr((string)$iz->tanggal_selesai, 0, 10);
                        return $dateStr >= $start && $dateStr <= $end;
                    });

                    if ($att) {
                        $isTapCondition = ($isPastDay || ($isToday && $currentTimeStr > $batasAkhirPulangStr));
                        $isLate = ($att->status === 'Terlambat');
                        $isTap = (!empty($att->jam_masuk) && empty($att->jam_pulang) && $isTapCondition);

                        if ($isLate) {
                            $tlCount++;
                        }
                        if ($isTap) {
                            $tapCount++;
                        }

                        if ($isLate && $isTap) {
                            $daily[$colKey] = 'TL/TAP';
                            $hCount++;
                        } elseif ($isTap) {
                            $daily[$colKey] = 'TAP';
                            $hCount++;
                        } elseif ($att->status === 'Hadir') {
                            $daily[$colKey] = 'H';
                            $hCount++;
                        } elseif ($att->status === 'Terlambat') {
                            $daily[$colKey] = 'TL';
                            $hCount++;
                        } elseif ($att->status === 'Sakit') {
                            $daily[$colKey] = 'S';
                            $sCount++;
                        } elseif ($att->status === 'Izin') {
                            $daily[$colKey] = 'I';
                            $iCount++;
                        } elseif ($att->status === 'Cuti') {
                            $daily[$colKey] = 'C';
                            $iCount++;
                        } elseif ($att->status === 'Dinas Luar') {
                            $daily[$colKey] = 'DL';
                            $iCount++;
                        } elseif ($att->status === 'Alpha') {
                            $daily[$colKey] = 'TK';
                            $tkCount++;
                        } else {
                            $daily[$colKey] = substr($att->status, 0, 2);
                        }
                    } elseif ($matchingIzin) {
                        if ($matchingIzin->jenis === 'Sakit') {
                            $daily[$colKey] = 'S';
                            $sCount++;
                        } else {
                            $daily[$colKey] = 'I';
                            $iCount++;
                        }
                    } else {
                        if ($isPastDay && in_array($dateStr, $activeOfficeDates)) {
                            $daily[$colKey] = 'TK';
                            $tkCount++;
                        } else {
                            $daily[$colKey] = '-';
                        }
                    }
                }
                
                return (object)[
                    'employee_name' => $p->nama,
                    'nip'           => $p->nip,
                    'daily'         => $daily,
                    'hadir'         => $hCount,
                    's'             => $sCount,
                    'i'             => $iCount,
                    'tk'            => $tkCount,
                    'tl'            => $tlCount,
                    'tap'           => $tapCount,
                ];
            });
            
            $this->viewName = 'admin.exports.absensi-rentang';
            $this->viewData = [
                'reports'   => $reports,
                'startDate' => $startDate,
                'endDate'   => $endDate,
                'dates'     => $dates
            ];

        } else {
            // Default: Bulanan
            $month = $this->request->get('month_absensi', Carbon::now()->format('Y-m'));
            $year = (int)(explode('-', $month)[0] ?? Carbon::now()->year);
            $monthNum = (int)(explode('-', $month)[1] ?? Carbon::now()->month);
            $daysInMonth = Carbon::parse($month.'-01')->daysInMonth;

            // Daftar tanggal hari kerja kantor yang aktif tercatat di sistem pada bulan tersebut (Senin - Jumat)
            $activeOfficeDates = Presensi::whereYear('tanggal', $year)
                ->whereMonth('tanggal', $monthNum)
                ->whereRaw('DAYOFWEEK(tanggal) NOT IN (1, 7)')
                ->distinct('tanggal')
                ->pluck('tanggal')
                ->map(fn($t) => is_object($t) ? $t->toDateString() : substr((string)$t, 0, 10))
                ->unique()
                ->toArray();

            $isPastMonth = ($month < Carbon::today()->format('Y-m'));

            $reports = $pegawaiList->map(function ($p) use ($year, $monthNum, $daysInMonth, $todayDateStr, $currentTimeStr, $batasAkhirPulangStr, $activeOfficeDates, $isPastMonth) {
                $attendances = Presensi::where('pegawai_id', $p->id)
                    ->whereYear('tanggal', $year)
                    ->whereMonth('tanggal', $monthNum)
                    ->get();

                $approvedIzins = PengajuanIzin::where('pegawai_id', $p->id)
                    ->where('status', 'Disetujui')
                    ->where(function($q) use ($year, $monthNum) {
                        $q->whereYear('tanggal_mulai', $year)->whereMonth('tanggal_mulai', $monthNum)
                          ->orWhereYear('tanggal_selesai', $year)->whereMonth('tanggal_selesai', $monthNum);
                    })
                    ->get();

                $daily = [];
                $hCount = 0;
                $sCount = 0;
                $iCount = 0;
                $tkCount = 0;
                $tlCount = 0;
                $tapCount = 0;

                for ($d = 1; $d <= $daysInMonth; $d++) {
                    $dateObj = Carbon::createFromDate($year, $monthNum, $d);
                    $dateStr = $dateObj->toDateString();
                    $isWeekend = $dateObj->isWeekend();
                    $isPastDay = ($dateStr < $todayDateStr);
                    $isToday = ($dateStr === $todayDateStr);

                    if ($isWeekend) {
                        // Akhir pekan (Sabtu & Minggu)
                        $daily[$d] = '-';
                        continue;
                    }

                    $att = $attendances->first(function ($a) use ($dateStr, $d) {
                        if (is_object($a->tanggal)) {
                            return (int)$a->tanggal->format('j') === (int)$d || $a->tanggal->toDateString() === $dateStr;
                        }
                        $rawStr = (string)$a->tanggal;
                        return str_starts_with($rawStr, $dateStr) || (int)date('j', strtotime($rawStr)) === (int)$d;
                    });

                    $matchingIzin = $approvedIzins->first(function($iz) use ($dateStr) {
                        $start = is_object($iz->tanggal_mulai) ? $iz->tanggal_mulai->toDateString() : substr((string)$iz->tanggal_mulai, 0, 10);
                        $end = is_object($iz->tanggal_selesai) ? $iz->tanggal_selesai->toDateString() : substr((string)$iz->tanggal_selesai, 0, 10);
                        return $dateStr >= $start && $dateStr <= $end;
                    });

                    if ($att) {
                        $isTapCondition = ($isPastDay || ($isToday && $currentTimeStr > $batasAkhirPulangStr));
                        $isLate = ($att->status === 'Terlambat');
                        $isTap = (!empty($att->jam_masuk) && empty($att->jam_pulang) && $isTapCondition);

                        if ($isLate) {
                            $tlCount++;
                        }
                        if ($isTap) {
                            $tapCount++;
                        }

                        if ($isLate && $isTap) {
                            $daily[$d] = 'TL/TAP';
                            $hCount++;
                        } elseif ($isTap) {
                            $daily[$d] = 'TAP';
                            $hCount++;
                        } elseif ($att->status === 'Hadir') {
                            $daily[$d] = 'H';
                            $hCount++;
                        } elseif ($att->status === 'Terlambat') {
                            $daily[$d] = 'TL';
                            $hCount++;
                        } elseif ($att->status === 'Sakit') {
                            $daily[$d] = 'S';
                            $sCount++;
                        } elseif ($att->status === 'Izin') {
                            $daily[$d] = 'I';
                            $iCount++;
                        } elseif ($att->status === 'Cuti') {
                            $daily[$d] = 'C';
                            $iCount++;
                        } elseif ($att->status === 'Dinas Luar') {
                            $daily[$d] = 'DL';
                            $iCount++;
                        } elseif ($att->status === 'Alpha') {
                            $daily[$d] = 'TK';
                            $tkCount++;
                        } else {
                            $daily[$d] = substr($att->status, 0, 2);
                        }
                    } elseif ($matchingIzin) {
                        if ($matchingIzin->jenis === 'Sakit') {
                            $daily[$d] = 'S';
                            $sCount++;
                        } else {
                            $daily[$d] = 'I';
                            $iCount++;
                        }
                    } else {
                        // Tidak ada presensi dan tidak ada izin pada hari kerja
                        $wasActiveWorkDay = in_array($dateStr, $activeOfficeDates) || ($isPastMonth && $isPastDay);
                        if ($wasActiveWorkDay) {
                            $daily[$d] = 'TK';
                            $tkCount++;
                        } else {
                            $daily[$d] = '-';
                        }
                    }
                }

                return (object)[
                    'employee_name' => $p->nama,
                    'nip'           => $p->nip,
                    'daily'         => $daily,
                    'hadir'         => $hCount,
                    's'             => $sCount,
                    'i'             => $iCount,
                    'tk'            => $tkCount,
                    'tl'            => $tlCount,
                    'tap'           => $tapCount,
                ];
            });

            $this->viewName = 'admin.exports.absensi-bulanan';
            $this->viewData = [
                'reports'     => $reports,
                'month'       => $month,
                'year'        => $year,
                'monthNum'    => $monthNum,
                'daysInMonth' => $daysInMonth
            ];
        }
    }

    public function view(): View
    {
        return view($this->viewName, $this->viewData);
    }

    public function columnWidths(): array
    {
        $widths = [
            'A' => 6,   // NO
            'B' => 32,  // NAMA PEGAWAI (nyaman untuk nama panjang)
            'C' => 24,  // NIP (lebar pas untuk 18 digit)
        ];

        if ($this->periode === 'tahunan') {
            $widths['D'] = 22; // BIDANG
            for ($col = 5; $col <= 16; $col++) {
                $colLetter = Coordinate::stringFromColumnIndex($col);
                $widths[$colLetter] = 6;
            }
            for ($col = 17; $col <= 22; $col++) {
                $colLetter = Coordinate::stringFromColumnIndex($col);
                $widths[$colLetter] = 7;
            }
        } elseif ($this->periode === 'rentang') {
            $numDates = count($this->viewData['dates'] ?? []);
            for ($i = 0; $i < $numDates; $i++) {
                $colLetter = Coordinate::stringFromColumnIndex(4 + $i);
                $widths[$colLetter] = 6.8;
            }
            for ($j = 0; $j < 6; $j++) {
                $colLetter = Coordinate::stringFromColumnIndex(4 + $numDates + $j);
                $widths[$colLetter] = 6.5;
            }
        } else {
            // Bulanan
            $daysInMonth = $this->viewData['daysInMonth'] ?? 30;
            // Kolom tanggal (D s/d ...)
            for ($d = 1; $d <= $daysInMonth; $d++) {
                $colLetter = Coordinate::stringFromColumnIndex(3 + $d);
                $widths[$colLetter] = 6.8;
            }
            // 6 Kolom Rekapitulasi (H, S, I, TK, TL, TAP)
            for ($j = 1; $j <= 6; $j++) {
                $colLetter = Coordinate::stringFromColumnIndex(3 + $daysInMonth + $j);
                $widths[$colLetter] = 6.5;
            }
        }

        return $widths;
    }

    public function styles(Worksheet $sheet): ?array
    {
        $highestRow = $sheet->getHighestRow();
        $highestCol = $sheet->getHighestColumn();

        // 1. Font umum Arial 9.5
        $sheet->getStyle("A1:{$highestCol}{$highestRow}")->getFont()->setName('Arial')->setSize(9.5);

        // 2. Format NIP sebagai teks murni agar tidak terpotong atau eksponensial di Excel
        $sheet->getStyle("C5:C{$highestRow}")->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);

        // 3. Header Tabel (Baris 5 dan 6)
        $sheet->getStyle("A5:{$highestCol}6")->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 9.5,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical'   => Alignment::VERTICAL_CENTER,
                'wrapText'   => true,
            ],
            'fill' => [
                'fillType'   => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'F1F5F9'],
            ],
        ]);

        // Rekapitulasi Header (Kolom Rekap)
        if ($this->periode === 'bulanan') {
            $daysInMonth = $this->viewData['daysInMonth'] ?? 30;
            $rekapStartCol = Coordinate::stringFromColumnIndex(3 + $daysInMonth + 1);
            $sheet->getStyle("{$rekapStartCol}5:{$highestCol}6")->applyFromArray([
                'fill' => [
                    'fillType'   => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'E2E8F0'],
                ],
            ]);

            // Highlight otomatis kolom akhir pekan (Sabtu & Minggu) warna merah di Excel
            $year = $this->viewData['year'] ?? (int)Carbon::now()->year;
            $monthNum = $this->viewData['monthNum'] ?? (int)Carbon::now()->month;

            for ($d = 1; $d <= $daysInMonth; $d++) {
                $dateObj = Carbon::createFromDate($year, $monthNum, $d);
                if ($dateObj->isWeekend()) {
                    $colLetter = Coordinate::stringFromColumnIndex(3 + $d);
                    // Header tanggal akhir pekan
                    $sheet->getStyle("{$colLetter}6")->applyFromArray([
                        'fill' => [
                            'fillType'   => Fill::FILL_SOLID,
                            'startColor' => ['rgb' => 'FEE2E2'],
                        ],
                        'font' => [
                            'color' => ['rgb' => 'DC2626'],
                            'bold'  => true,
                        ],
                    ]);
                    // Cell data akhir pekan
                    $sheet->getStyle("{$colLetter}7:{$colLetter}{$highestRow}")->applyFromArray([
                        'fill' => [
                            'fillType'   => Fill::FILL_SOLID,
                            'startColor' => ['rgb' => 'FEF2F2'],
                        ],
                        'font' => [
                            'color' => ['rgb' => 'DC2626'],
                        ],
                    ]);
                }
            }
        } elseif ($this->periode === 'rentang') {
            $dates = $this->viewData['dates'] ?? [];
            foreach ($dates as $idx => $dateObj) {
                if ($dateObj->isWeekend()) {
                    $colLetter = Coordinate::stringFromColumnIndex(4 + $idx);
                    $sheet->getStyle("{$colLetter}6")->applyFromArray([
                        'fill' => [
                            'fillType'   => Fill::FILL_SOLID,
                            'startColor' => ['rgb' => 'FEE2E2'],
                        ],
                        'font' => [
                            'color' => ['rgb' => 'DC2626'],
                            'bold'  => true,
                        ],
                    ]);
                    $sheet->getStyle("{$colLetter}7:{$colLetter}{$highestRow}")->applyFromArray([
                        'fill' => [
                            'fillType'   => Fill::FILL_SOLID,
                            'startColor' => ['rgb' => 'FEF2F2'],
                        ],
                        'font' => [
                            'color' => ['rgb' => 'DC2626'],
                        ],
                    ]);
                }
            }
        }

        // 4. Border seluruh tabel dari baris 5 s.d baris data terakhir
        $sheet->getStyle("A5:{$highestCol}{$highestRow}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color'       => ['rgb' => '444444'],
                ],
            ],
        ]);

        // 5. Alignment Data Rows (Row 7 s.d $highestRow)
        $sheet->getStyle("A7:A{$highestRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("B7:B{$highestRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle("C7:C{$highestRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("D7:{$highestCol}{$highestRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // 6. Set tinggi baris rapi
        $sheet->getRowDimension(5)->setRowHeight(22);
        $sheet->getRowDimension(6)->setRowHeight(20);
        for ($r = 7; $r <= $highestRow; $r++) {
            $sheet->getRowDimension($r)->setRowHeight(19);
        }

        return [];
    }
}
