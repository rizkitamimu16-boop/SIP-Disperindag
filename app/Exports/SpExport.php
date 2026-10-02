<?php

namespace App\Exports;

use App\Models\Pegawai;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SpExport implements FromCollection, WithHeadings, WithMapping
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection(): \Illuminate\Support\Collection
    {
        $year = $this->request->get('year_sp', Carbon::now()->year);
        $bidang = $this->request->get('bidang_sp');
        $tingkat = $this->request->get('tingkat_sp');
        
        $query = \App\Models\SuratPeringatan::with('pegawai')->whereYear('tanggal_terbit', $year);
        
        if ($bidang) {
            $query->whereHas('pegawai', function($q) use ($bidang) {
                $q->where('bidang', $bidang);
            });
        }
        if ($tingkat && $tingkat !== 'semua') {
            $query->where('tingkat_sp', $tingkat);
        }
        
        $reports = $query->get()->map(function($sp) {
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

        return $reports;
    }

    public function headings(): array
    {
        return [
            'Nama Pegawai',
            'NIP',
            'Bidang/Unit Kerja',
            'Tingkat SP',
            'Nomor Surat',
            'Tanggal Terbit',
            'Status'
        ];
    }

    public function map($row): array
    {
        return [
            $row->employee_name,
            $row->nip,
            $row->department,
            strtoupper($row->sp_level),
            $row->letter_number,
            $row->date_issued,
            $row->status,
        ];
    }
}
