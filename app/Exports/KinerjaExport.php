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
        $month = $this->request->get('month_kinerja', Carbon::now()->format('Y-m'));
        $bidang = $this->request->get('bidang_kinerja');
        $kategori = $this->request->get('kategori_kinerja');
        
        $pegawaiQuery = Pegawai::where('status', 'Aktif');
        if ($bidang) {
            $pegawaiQuery->where('bidang', $bidang);
        }
        $pegawaiList = $pegawaiQuery->get();

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
