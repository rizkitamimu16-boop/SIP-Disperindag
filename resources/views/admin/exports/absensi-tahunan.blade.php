<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Rekapitulasi Absensi Tahunan</title>
    <style>
        body { font-family: sans-serif; font-size: 9px; color: #1e293b; margin: 0; padding: 10px; }
        .header { text-align: center; margin-bottom: 15px; border-bottom: 2px solid #000; padding-bottom: 8px; }
        .header h2 { margin: 2px 0; font-size: 13px; font-weight: bold; }
        .header h3 { margin: 2px 0; font-size: 12px; font-weight: bold; }
        .header h4 { margin: 2px 0; font-size: 11px; font-weight: bold; }
        .header p { margin: 2px 0; font-size: 10px; }
        table.data-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table.data-table th, table.data-table td { border: 1px solid #333333; padding: 4px 2px; text-align: center; font-size: 9px; }
        .text-left { text-align: left !important; padding-left: 5px !important; }
        th { background-color: #f1f5f9; font-weight: bold; }
        .th-rekap { background-color: #e2e8f0; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <h2>PEMERINTAH KABUPATEN/KOTA</h2>
        <h3>DINAS PERINDUSTRIAN DAN PERDAGANGAN</h3>
        <h4>LAPORAN REKAPITULASI ABSENSI TAHUNAN PEGAWAI</h4>
        <p>Tahun: {{ $year }}</p>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th rowspan="2">NO</th>
                <th rowspan="2" class="text-left">NAMA PEGAWAI</th>
                <th rowspan="2" class="text-left">NIP</th>
                <th rowspan="2" class="text-left">BIDANG</th>
                <th colspan="12">BULAN (TOTAL KEHADIRAN)</th>
                <th colspan="6" class="th-rekap">REKAPITULASI TAHUNAN</th>
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
                <th class="th-rekap">Hadir</th>
                <th class="th-rekap">Izin</th>
                <th class="th-rekap">Sakit</th>
                <th class="th-rekap" style="color: #dc2626;">TK</th>
                <th class="th-rekap">TL</th>
                <th class="th-rekap" style="color: #d97706;">TAP</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reports as $index => $row)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td class="text-left">{{ $row->employee_name }}</td>
                <td class="text-left" style="mso-number-format:'\@';">{{ $row->nip }}</td>
                <td class="text-left">{{ $row->department }}</td>
                @for($m=1; $m<=12; $m++)
                <td>{{ $row->monthly[$m] }}</td>
                @endfor
                <td>{{ $row->total_hadir }}</td>
                <td>{{ $row->total_izin }}</td>
                <td>{{ $row->total_sakit }}</td>
                <td style="{{ $row->total_tk > 0 ? 'color: #dc2626; font-weight: bold;' : '' }}">{{ $row->total_tk }}</td>
                <td>{{ $row->total_tl }}</td>
                <td style="{{ $row->total_tap > 0 ? 'color: #d97706; font-weight: bold;' : '' }}">{{ $row->total_tap }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <table style="width: 100%; border: none; margin-top: 30px;" border="0">
        <tr>
            <td colspan="10" style="border: none;"></td>
            <td colspan="12" style="border: none; text-align: center;">
                <p style="margin: 0;">Mengetahui,</p>
                <p style="margin: 2px 0 60px 0;">Kepala Dinas Perindustrian dan Perdagangan</p>
                <p style="font-weight: bold; text-decoration: underline; margin: 0;">(...........................................)</p>
                <p style="margin: 2px 0;">NIP. .......................................</p>
            </td>
        </tr>
    </table>
</body>
</html>
