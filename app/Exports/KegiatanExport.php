<?php

namespace App\Exports;

use App\Models\Pegawai;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class KegiatanExport implements FromCollection, WithHeadings, WithMapping
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection(): \Illuminate\Support\Collection
    {
        $periodeKegiatan = $this->request->get('periode_kegiatan', 'rentang');
        $bidang = $this->request->get('bidang_kegiatan');
        $status = $this->request->get('status_kegiatan');
        
        $query = \App\Models\LaporanKegiatan::with('pegawai');

        if ($periodeKegiatan === 'bulanan') {
            $month = $this->request->get('month_kegiatan', Carbon::now()->format('Y-m'));
            $y = explode('-', $month)[0] ?? Carbon::now()->year;
            $m = explode('-', $month)[1] ?? Carbon::now()->month;
            $query->whereYear('tanggal', $y)->whereMonth('tanggal', $m);
        } elseif ($periodeKegiatan === 'tahunan') {
            $y = $this->request->get('year_kegiatan', Carbon::now()->year);
            $query->whereYear('tanggal', $y);
        } elseif ($this->request->filled('date_kegiatan')) {
            $query->whereDate('tanggal', $this->request->date_kegiatan);
        } else {
            $startDate = $this->request->get('start_date_kegiatan', Carbon::now()->startOfMonth()->toDateString());
            $endDate = $this->request->get('end_date_kegiatan', Carbon::today()->toDateString());
            $query->whereBetween('tanggal', [$startDate, $endDate]);
        }
        
        if ($bidang) {
            $query->whereHas('pegawai', function($q) use ($bidang) {
                $q->where('bidang', $bidang);
            });
        }
        if ($status && $status !== 'semua') {
            $query->where('status_verifikasi', ucfirst($status));
        }
        
        $reports = $query->orderBy('tanggal', 'desc')->get()->map(function($act) {
            return (object)[
                'employee_name' => $act->pegawai->nama ?? '-',
                'date'          => $act->tanggal ? (is_object($act->tanggal) ? $act->tanggal->toDateString() : $act->tanggal) : '-',
                'activity_name' => $act->nama_kegiatan ?? $act->kegiatan ?? '-',
                'status'        => strtolower($act->status_verifikasi),
            ];
        });

        return $reports;
    }

    public function headings(): array
    {
        return [
            'Nama Pegawai',
            'Tanggal',
            'Uraian Tugas',
            'Status'
        ];
    }

    public function map($row): array
    {
        return [
            $row->employee_name,
            $row->date,
            $row->activity_name,
            ucfirst($row->status),
        ];
    }
}
