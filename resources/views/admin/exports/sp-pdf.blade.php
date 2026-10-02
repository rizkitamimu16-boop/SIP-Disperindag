<!DOCTYPE html>
<html>
<head>
    <title>Laporan Surat Peringatan</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .header h2, .header h3, .header h4 { margin: 2px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <div class="header">
        <h2>PEMERINTAH KABUPATEN/KOTA</h2>
        <h3>DINAS PERINDUSTRIAN DAN PERDAGANGAN</h3>
        <h4>LAPORAN REKAPITULASI SURAT PERINGATAN (SP)</h4>
        <p>Tahun: {{ request('year_sp', date('Y')) }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="20%">Nama Pegawai</th>
                <th width="15%">Bidang</th>
                <th width="10%">Tingkat SP</th>
                <th width="25%">Nomor Surat</th>
                <th width="15%">Tanggal Terbit</th>
                <th width="10%">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reports as $index => $row)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>
                    <b>{{ $row->employee_name }}</b><br>
                    NIP: {{ $row->nip }}
                </td>
                <td>{{ $row->department }}</td>
                <td>{{ strtoupper($row->sp_level) }}</td>
                <td>{{ $row->letter_number }}</td>
                <td>{{ $row->date_issued }}</td>
                <td>{{ $row->status }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center;">Tidak ada penerbitan SP pada periode ini</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 40px; text-align: right; width: 100%;">
        <div style="display: inline-block; text-align: center; width: 250px;">
            <p>Mengetahui,</p>
            <p style="margin-bottom: 60px;">Kepala Dinas</p>
            <p style="font-weight: bold; text-decoration: underline;">(...........................................)</p>
            <p>NIP. .......................................</p>
        </div>
    </div>
</body>
</html>
