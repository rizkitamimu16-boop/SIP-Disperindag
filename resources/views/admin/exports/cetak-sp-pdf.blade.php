<!DOCTYPE html>
<html>
<head>
    <title>Surat Peringatan - {{ $sp->pegawai->nama }}</title>
    <style>
        body { font-family: 'Times New Roman', Times, serif; font-size: 12pt; line-height: 1.5; margin: 20px 40px; }
        .header { text-align: center; border-bottom: 3px solid #000; padding-bottom: 15px; margin-bottom: 30px; }
        .header h2, .header h3, .header h4 { margin: 2px 0; font-weight: bold; }
        .header p { margin: 2px 0; font-size: 10pt; }
        .title { text-align: center; margin-bottom: 30px; }
        .title h3 { text-decoration: underline; margin: 0; }
        .title p { margin: 5px 0 0 0; }
        .content { margin-bottom: 40px; }
        .indent { margin-left: 30px; }
        table { width: 100%; margin: 10px 0; }
        td { vertical-align: top; padding: 3px 0; }
        .signature { margin-top: 50px; float: right; width: 300px; text-align: center; }
        .signature-title { margin-bottom: 70px; }
        .signature-name { font-weight: bold; text-decoration: underline; margin-bottom: 0; }
    </style>
</head>
<body>
    <div class="header">
        <h2>PEMERINTAH {{ strtoupper($settings->nama_instansi ?? 'KABUPATEN') }}</h2>
        <h3>{{ strtoupper($settings->nama_instansi ?? 'DINAS PERINDUSTRIAN DAN PERDAGANGAN') }}</h3>
        <p>{{ $settings->alamat ?? 'Jl. Contoh Alamat No. 123' }} Telp. {{ $settings->telepon ?? '(021) 1234567' }}</p>
        <p>Email: {{ $settings->email ?? 'info@disperindag.go.id' }}</p>
    </div>

    <div class="title">
        <h3>SURAT PERINGATAN {{ substr($sp->tingkat_sp, 2) }} ({{ $sp->tingkat_sp }})</h3>
        <p>Nomor: {{ $sp->nomor_surat }}</p>
    </div>

    <div class="content">
        <p>Bersama surat ini, Kepala Dinas Perindustrian dan Perdagangan memberikan Surat Peringatan kepada:</p>
        
        <table class="indent" style="width: 80%;">
            <tr>
                <td width="30%">Nama</td>
                <td width="5%">:</td>
                <td width="65%"><strong>{{ $sp->pegawai->nama }}</strong></td>
            </tr>
            <tr>
                <td>NIP</td>
                <td>:</td>
                <td>{{ $sp->pegawai->nip }}</td>
            </tr>
            <tr>
                <td>Jabatan</td>
                <td>:</td>
                <td>{{ $sp->pegawai->jabatan }}</td>
            </tr>
            <tr>
                <td>Bidang</td>
                <td>:</td>
                <td>{{ $sp->pegawai->bidang }}</td>
            </tr>
        </table>

        <p style="margin-top: 20px;">
            Surat peringatan ini dikeluarkan karena yang bersangkutan telah melakukan tindakan indisipliner berupa:
        </p>
        <p class="indent">
            <strong>Tercatat tidak hadir bekerja (Alpha) sebanyak {{ $sp->jumlah_alpha ?? '-' }} hari secara berturut-turut atau akumulatif.</strong>
        </p>

        <p style="margin-top: 20px;">
            Sesuai dengan ketentuan dan peraturan yang berlaku di lingkungan Instansi, tindakan tersebut merupakan pelanggaran disiplin kerja. Melalui surat peringatan ini, kami mengharapkan Saudara/i untuk dapat memperbaiki kinerja dan kedisiplinan.
        </p>
        
        @if($sp->tingkat_sp == 'SP3')
        <p>
            Mengingat ini adalah Surat Peringatan ke-3 (Terakhir), apabila Saudara/i kembali mengulangi kesalahan atau pelanggaran disiplin kerja, maka Instansi akan mengambil tindakan tegas berupa pemutusan hubungan kerja (PHK) / pemberhentian.
        </p>
        @else
        <p>
            Apabila teguran ini tidak diindahkan dan Saudara/i kembali melakukan pelanggaran disiplin kerja, maka akan diberikan sanksi yang lebih berat sesuai dengan peraturan yang berlaku.
        </p>
        @endif

        <p style="margin-top: 20px;">
            Demikian Surat Peringatan ini dibuat agar dapat diperhatikan dan dilaksanakan dengan sebaik-baiknya.
        </p>
    </div>

    <div class="signature">
        <p>Dikeluarkan di: ............................</p>
        <p style="margin-top: -10px;">Pada Tanggal: {{ \Carbon\Carbon::parse($sp->tanggal_terbit)->isoFormat('D MMMM Y') }}</p>
        
        <p class="signature-title">Kepala Dinas,</p>
        
        <p class="signature-name">{{ $settings->kepala_dinas ?? 'NAMA KEPALA DINAS' }}</p>
        <p style="margin-top: 0;">NIP. {{ $settings->nip_kepala_dinas ?? '19700101 200001 1 001' }}</p>
    </div>
</body>
</html>
