<?php

namespace App\Exports;

use App\Models\Pegawai;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class KinerjaExport implements FromCollection, WithHeadings, WithMapping
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection(): \Illuminate\Support\Collection
    {
        $periodeKinerja = $this->request->get('periode_kinerja', 'bulanan');
        $bidang = $this->request->get('bidang_kinerja');
        $kategori = $this->request->get('kategori_kinerja');
        $search = $this->request->get('search_kinerja');
        
        $pegawaiQuery = Pegawai::where('status', 'Aktif');
        if ($bidang) {
            $pegawaiQuery->where('bidang', $bidang);
        }
        if ($search) {
            $pegawaiQuery->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%");
            });
        }
        $pegawaiList = $pegawaiQuery->get();

        if ($periodeKinerja === 'tahunan') {
            $yearKinerja = $this->request->get('year_kinerja', Carbon::now()->year);
            $hasData = \App\Models\Presensi::whereYear('tanggal', $yearKinerja)->exists()
                    || \App\Models\LaporanKegiatan::whereYear('tanggal', $yearKinerja)->exists()
                    || \App\Models\SkorKinerja::where('periode', 'like', "{$yearKinerja}-%")->exists();

            if (!$hasData) {
                $reports = collect();
            } else {
                $reports = $pegawaiList->map(function ($p) use ($yearKinerja) {
                    $skors = \App\Models\SkorKinerja::where('pegawai_id', $p->id)
                        ->where('periode', 'like', "{$yearKinerja}-%")
                        ->get();
                    $hasAtt = \App\Models\Presensi::where('pegawai_id', $p->id)->whereYear('tanggal', $yearKinerja)->exists();
                    $hasAct = \App\Models\LaporanKegiatan::where('pegawai_id', $p->id)->whereYear('tanggal', $yearKinerja)->exists();

                    if ($skors->isEmpty() && !$hasAtt && !$hasAct) {
                        return null;
                    }

                    $avgScore = $skors->isNotEmpty() ? $skors->avg('nilai_akhir') : 0;
                    $kat = 'Kurang';
                    if ($avgScore >= 90) $kat = 'Sangat Baik';
                    elseif ($avgScore >= 80) $kat = 'Baik';
                    elseif ($avgScore >= 70) $kat = 'Cukup';

                    return (object)[
                        'employee_name' => $p->nama ?? '-',
                        'department'    => $p->bidang ?? '-',
                        'ikp_score'     => round($avgScore, 1),
                        'predikat'      => $kat,
                    ];
                })->filter()->values();
            }
        } elseif ($periodeKinerja === 'rentang') {
            $startDate = $this->request->get('start_date_kinerja', Carbon::now()->startOfMonth()->toDateString());
            $endDate = $this->request->get('end_date_kinerja', Carbon::today()->toDateString());
            $hasData = \App\Models\Presensi::whereBetween('tanggal', [$startDate, $endDate])->exists();
            if (!$hasData) {
                $reports = collect();
            } else {
                $reports = $pegawaiList->map(function ($p) use ($endDate) {
                    $periodKey = substr($endDate, 0, 7);
                    $skor = \App\Models\SkorKinerja::where('pegawai_id', $p->id)->where('periode', $periodKey)->first();
                    if (!$skor) {
                        $skor = \App\Models\SkorKinerja::calculateLiveScore($p->id, $periodKey);
                    }
                    return (object)[
                        'employee_name' => $p->nama ?? '-',
                        'department'    => $p->bidang ?? '-',
                        'ikp_score'     => $skor->nilai_akhir ?? 0,
                        'predikat'      => $skor->kategori ?? 'Kurang',
                    ];
                });
            }
        } else {
            $month = $this->request->get('month_kinerja', Carbon::now()->format('Y-m'));
            $y = explode('-', $month)[0] ?? Carbon::now()->year;
            $m = explode('-', $month)[1] ?? Carbon::now()->month;
            $hasData = \App\Models\Presensi::whereYear('tanggal', $y)->whereMonth('tanggal', $m)->exists()
                    || \App\Models\LaporanKegiatan::whereYear('tanggal', $y)->whereMonth('tanggal', $m)->exists()
                    || \App\Models\SkorKinerja::where('periode', $month)->exists();

            if (!$hasData) {
                $reports = collect();
            } else {
                $reports = $pegawaiList->map(function ($p) use ($month) {
                    $skor = \App\Models\SkorKinerja::where('pegawai_id', $p->id)
                        ->where('periode', $month)
                        ->first();

                    if (!$skor) {
                        $skor = \App\Models\SkorKinerja::calculateLiveScore($p->id, $month);
                    }

                    return (object)[
                        'employee_name' => $p->nama ?? '-',
                        'department'    => $p->bidang ?? '-',
                        'ikp_score'     => $skor->nilai_akhir ?? 0,
                        'predikat'      => $skor->kategori ?? 'Kurang',
                    ];
                });
            }
        }

        if ($kategori && $kategori !== 'semua') {
            $kategoriMap = [
                'sangat_baik' => 'Sangat Baik',
                'baik'        => 'Baik',
                'cukup'       => 'Cukup',
                'kurang'      => 'Kurang',
            ];
            if (isset($kategoriMap[$kategori])) {
                $reports = $reports->where('predikat', $kategoriMap[$kategori])->values();
            }
        }

        return $reports;
    }

    public function headings(): array
    {
        return [
            'Nama Pegawai',
            'Bidang/Unit Kerja',
            'Indeks Kinerja (IKP)',
            'Predikat'
        ];
    }

    public function map($row): array
    {
        return [
            $row->employee_name,
            $row->department,
            $row->ikp_score,
            $row->predikat,
        ];
    }
}
