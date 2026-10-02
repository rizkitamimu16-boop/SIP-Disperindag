<?php

namespace App\Exports;

use App\Models\Pegawai;
use App\Models\Presensi;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AbsensiExport implements FromCollection, WithHeadings, WithMapping
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection(): \Illuminate\Support\Collection
    {
        $month = $this->request->get('month_absensi', Carbon::now()->format('Y-m'));
        $bidang = $this->request->get('bidang_absensi');
        $status = $this->request->get('status_absensi');
        
        $query = Pegawai::query();
        if ($bidang) {
            $query->where('bidang', $bidang);
        }
        
        $pegawaiList = $query->get();
        $year = explode('-', $month)[0] ?? Carbon::now()->year;
        $monthNum = explode('-', $month)[1] ?? Carbon::now()->month;

        $reports = $pegawaiList->map(function ($p) use ($year, $monthNum, $status) {
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
            $reports = $reports->filter(function($item) {
                return $item->total_hadir > 0;
            })->values();
        }

        return $reports;
    }

    public function headings(): array
    {
        return [
            'Nama Pegawai',
            'NIP',
            'Bidang/Unit Kerja',
            'Total Hadir (Hari)'
        ];
    }

    public function map($row): array
    {
        return [
            $row->employee_name,
            $row->nip,
            $row->department,
            $row->total_hadir,
        ];
    }
}
