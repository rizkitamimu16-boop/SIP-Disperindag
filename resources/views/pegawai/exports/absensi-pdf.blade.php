<!DOCTYPE html>
<html>
<head>
    <title>Laporan Absensi Pegawai</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .header h2, .header h3, .header h4 { margin: 2px 0; }
        .info { margin-bottom: 15px; }
        .info table { width: 100%; border: none; margin-top: 0; }
        .info td { padding: 3px; border: none; }
        table.data { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table.data th, table.data td { border: 1px solid #000; padding: 6px; text-align: left; }
        table.data th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <div class="header">
        <h2>PEMERINTAH KABUPATEN/KOTA</h2>
        <h3>DINAS PERINDUSTRIAN DAN PERDAGANGAN</h3>
        <h4>LAPORAN RIWAYAT ABSENSI PEGAWAI</h4>
    </div>

    <div class="info">
        <table>
            <tr>
                <td width="20%"><strong>Nama Pegawai</strong></td>
                <td width="2%">:</td>
                <td>{{ $employee->nama }}</td>
            </tr>
            <tr>
                <td><strong>NIP</strong></td>
                <td>:</td>
                <td>{{ $employee->nip }}</td>
            </tr>
            <tr>
                <td><strong>Bidang</strong></td>
                <td>:</td>
                <td>{{ $employee->bidang }}</td>
            </tr>
            <tr>
                <td><strong>Periode</strong></td>
                <td>:</td>
                <td>{{ $monthLabel }}</td>
            </tr>
        </table>
    </div>

    <table class="data">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="20%">Tanggal</th>
                <th width="15%">Jam Masuk</th>
                <th width="15%">Jam Pulang</th>
                <th width="20%">Status Kehadiran</th>
            </tr>
        </thead>
        <tbody>
            @forelse($attendances as $index => $row)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($row->tanggal)->translatedFormat('d F Y') }}</td>
                <td>{{ $row->jam_masuk ? \Carbon\Carbon::parse($row->jam_masuk)->format('H:i') . ' (' . ($row->status_masuk ?? '-') . ')' : '-' }}</td>
                <td>{{ $row->jam_pulang ? \Carbon\Carbon::parse($row->jam_pulang)->format('H:i') . ' (' . ($row->status_pulang ?? '-') . ')' : '-' }}</td>
                <td>{{ $row->status }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center;">Tidak ada data presensi pada periode ini</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 40px; text-align: right; width: 100%;">
        <div style="display: inline-block; text-align: center; width: 250px;">
            <p>Mengetahui,</p>
            <p style="margin-bottom: 60px;">Kepala Bidang / Atasan</p>
            <p style="font-weight: bold; text-decoration: underline;">(...........................................)</p>
            <p>NIP. .......................................</p>
        </div>
    </div>
</body>
</html>
