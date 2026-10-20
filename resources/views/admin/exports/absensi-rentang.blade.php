<!DOCTYPE html>
<html>
<head>
    <title>Laporan Absensi Rentang Waktu</title>
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
        <h4>LAPORAN REKAPITULASI ABSENSI PEGAWAI (RENTANG WAKTU)</h4>
        <p>Periode: {{ \Carbon\Carbon::parse($startDate)->translatedFormat('d F Y') }} s/d {{ \Carbon\Carbon::parse($endDate)->translatedFormat('d F Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th rowspan="2" width="3%">NO</th>
                <th rowspan="2" class="text-left" width="12%">NAMA PEGAWAI</th>
                <th rowspan="2" class="text-left" width="10%">NIP</th>
                <th colspan="{{ count($dates) }}">TANGGAL</th>
                <th colspan="6">REKAPITULASI</th>
            </tr>
            <tr>
                @foreach($dates as $date)
                <th>{{ $date->format('d/m') }}</th>
                @endforeach
                <th>H</th>
                <th>S</th>
                <th>I</th>
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
                @foreach($dates as $date)
                @php $colKey = $date->format('d/m'); @endphp
                <td>{{ $row->daily[$colKey] ?? '-' }}</td>
                @endforeach
                <td>{{ $row->hadir }}</td>
                <td>{{ $row->s }}</td>
                <td>{{ $row->i }}</td>
                <td>{{ $row->tk }}</td>
                <td>{{ $row->tl }}</td>
                <td>{{ $row->ptg }}</td>
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
