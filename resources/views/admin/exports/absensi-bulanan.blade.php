<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Rekapitulasi Absensi Bulanan</title>
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
        .weekend-header { background-color: #fee2e2 !important; color: #dc2626 !important; font-weight: bold; }
        .weekend-cell { background-color: #fef2f2 !important; color: #dc2626 !important; }
        .tk-cell { color: #dc2626 !important; font-weight: bold; }
        .tap-cell { color: #d97706 !important; font-weight: bold; }
        .tl-cell { color: #ea580c !important; font-weight: bold; }
        .tltap-cell { color: #b45309 !important; font-weight: bold; }
        .legend { margin-top: 12px; font-size: 8.5px; color: #475569; }
    </style>
</head>
<body>
    <div class="header">
        <h2>PEMERINTAH KABUPATEN/KOTA</h2>
        <h3>DINAS PERINDUSTRIAN DAN PERDAGANGAN</h3>
        <h4>LAPORAN REKAPITULASI ABSENSI BULANAN PEGAWAI</h4>
        <p>Bulan: {{ \Carbon\Carbon::parse($month.'-01')->locale('id')->isoFormat('MMMM Y') }}</p>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th rowspan="2">NO</th>
                <th rowspan="2" class="text-left">NAMA PEGAWAI</th>
                <th rowspan="2" class="text-left">NIP</th>
                <th colspan="{{ $daysInMonth }}">TANGGAL</th>
                <th colspan="6" class="th-rekap">REKAPITULASI</th>
            </tr>
            <tr>
                @for($d=1; $d<=$daysInMonth; $d++)
                @php
                    $isWeekend = \Carbon\Carbon::createFromDate((int)$year, (int)$monthNum, $d)->isWeekend();
                @endphp
                <th class="{{ $isWeekend ? 'weekend-header' : '' }}" style="{{ $isWeekend ? 'background-color: #fee2e2; color: #dc2626;' : '' }}">{{ $d }}</th>
                @endfor
                <th class="th-rekap">H</th>
                <th class="th-rekap">S</th>
                <th class="th-rekap">I</th>
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
                @for($d=1; $d<=$daysInMonth; $d++)
                @php
                    $isWeekend = \Carbon\Carbon::createFromDate((int)$year, (int)$monthNum, $d)->isWeekend();
                    $val = $row->daily[$d] ?? '-';
                    $cellClass = '';
                    $cellStyle = '';
                    if ($isWeekend) {
                        $cellClass = 'weekend-cell';
                        $cellStyle = 'background-color: #fef2f2; color: #dc2626;';
                    } elseif ($val === 'TK') {
                        $cellClass = 'tk-cell';
                        $cellStyle = 'color: #dc2626; font-weight: bold;';
                    } elseif ($val === 'TL/TAP') {
                        $cellClass = 'tltap-cell';
                        $cellStyle = 'color: #b45309; font-weight: bold;';
                    } elseif ($val === 'TAP') {
                        $cellClass = 'tap-cell';
                        $cellStyle = 'color: #d97706; font-weight: bold;';
                    } elseif ($val === 'TL') {
                        $cellClass = 'tl-cell';
                        $cellStyle = 'color: #ea580c; font-weight: bold;';
                    }
                @endphp
                <td class="{{ $cellClass }}" style="{{ $cellStyle }}">
                    {{ $val }}
                </td>
                @endfor
                <td>{{ $row->hadir }}</td>
                <td>{{ $row->s }}</td>
                <td>{{ $row->i }}</td>
                <td style="{{ $row->tk > 0 ? 'color: #dc2626; font-weight: bold;' : '' }}">{{ $row->tk }}</td>
                <td>{{ $row->tl }}</td>
                <td style="{{ $row->tap > 0 ? 'color: #d97706; font-weight: bold;' : '' }}">{{ $row->tap }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="legend">
        <strong>Keterangan:</strong> 
        H = Hadir | S = Sakit | I = Izin/Cuti/DL | TK = Tanpa Keterangan | TL = Terlambat | TAP = Tidak Absen Pulang | TL/TAP = Terlambat & Tidak Absen Pulang
    </div>

    <table style="width: 100%; border: none; margin-top: 30px;" border="0">
        <tr>
            <td colspan="{{ (int)($daysInMonth / 2) + 3 }}" style="border: none;"></td>
            <td colspan="{{ (int)($daysInMonth / 2) + 6 }}" style="border: none; text-align: center;">
                <p style="margin: 0;">Mengetahui,</p>
                <p style="margin: 2px 0 60px 0;">Kepala Dinas Perindustrian dan Perdagangan</p>
                <p style="font-weight: bold; text-decoration: underline; margin: 0;">(...........................................)</p>
                <p style="margin: 2px 0;">NIP. .......................................</p>
            </td>
        </tr>
    </table>
</body>
</html>
