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
        $date = $this->request->get('date_kegiatan', Carbon::today()->toDateString());
        $bidang = $this->request->get('bidang_kegiatan');
        $status = $this->request->get('status_kegiatan');
        
        $query = \App\Models\LaporanKegiatan::with('pegawai')->whereDate('tanggal', $date);
        
        if ($bidang) {
            $query->whereHas('pegawai', function($q) use ($bidang) {
                $q->where('bidang', $bidang);
            });
        }
        if ($status && $status !== 'semua') {
            $query->where('status_verifikasi', ucfirst($status));
        }
        
        $reports = $query->get()->map(function($act) {
            return (object)[
                'employee_name' => $act->pegawai->nama ?? '-',
                'date' => $act->tanggal,
                'activity_name' => $act->kegiatan,
                'status' => strtolower($act->status_verifikasi),
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
