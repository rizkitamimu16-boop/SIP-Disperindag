<!DOCTYPE html>
<html>
<head>
    <title>Laporan Absensi Tahunan</title>
    <style>
        body { font-family: sans-serif; font-size: 10px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .header h2, .header h3, .header h4 { margin: 2px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 4px; text-align: center; }
        .text-left { text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <div class="header">
        <h2>PEMERINTAH KABUPATEN/KOTA</h2>
        <h3>DINAS PERINDUSTRIAN DAN PERDAGANGAN</h3>
        <h4>LAPORAN REKAPITULASI ABSENSI TAHUNAN PEGAWAI</h4>
        <p>Tahun: {{ $year }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th rowspan="2" width="3%">NO</th>
                <th rowspan="2" class="text-left" width="15%">NAMA PEGAWAI</th>
                <th rowspan="2" class="text-left" width="12%">NIP</th>
                <th rowspan="2" class="text-left" width="12%">BIDANG</th>
                <th colspan="12">BULAN (TOTAL KEHADIRAN)</th>
                <th colspan="6">REKAPITULASI TAHUNAN</th>
            </tr>
            <tr>
                <th>Jan</th>
                <th>Feb</th>
                <th>Mar</th>
                <th>Apr</th>
                <th>Mei</th>
                <th>Jun</th>
                <th>Jul</th>
                <th>Ags</th>
                <th>Sep</th>
                <th>Okt</th>
                <th>Nov</th>
                <th>Des</th>
                <th>Hadir</th>
                <th>Izin</th>
                <th>Sakit</th>
                <th>TK</th>
                <th>TL</th>
                <th>PTG</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reports as $index => $row)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td class="text-left">{{ $row->employee_name }}</td>
                <td class="text-left">{{ $row->nip }}</td>
                <td class="text-left">{{ $row->department }}</td>
                @for($m=1; $m<=12; $m++)
                <td>{{ $row->monthly[$m] }}</td>
                @endfor
                <td>{{ $row->total_hadir }}</td>
                <td>{{ $row->total_izin }}</td>
                <td>{{ $row->total_sakit }}</td>
                <td>{{ $row->total_tk }}</td>
                <td>{{ $row->total_tl }}</td>
                <td>{{ $row->total_ptg }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 30px; text-align: right; width: 100%;">
        <div style="display: inline-block; text-align: center; width: 250px;">
            <p>Mengetahui,</p>
            <p style="margin-bottom: 60px;">Kepala Dinas</p>
            <p style="font-weight: bold; text-decoration: underline;">(...........................................)</p>
            <p>NIP. .......................................</p>
        </div>
    </div>
</body>
</html>
