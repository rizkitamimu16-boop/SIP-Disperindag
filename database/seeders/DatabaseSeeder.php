<?php

namespace Database\Seeders;

use App\Models\LaporanKegiatan;
use App\Models\Pegawai;
use App\Models\PengajuanIzin;
use App\Models\PengaturanKantor;
use App\Models\Presensi;
use App\Models\SkorKinerja;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Pengaturan Default Instansi (PRD Bab 51)
        $kantor = PengaturanKantor::firstOrCreate(
            ['id' => 1],
            [
                'nama_skpd'           => 'Dinas Perindustrian dan Perdagangan Kota Gorontalo',
                'nama_instansi'       => 'Pemerintah Kota Gorontalo',
                'alamat_kantor'       => 'Jl. Jalaluddin Tantu No. 45, Kota Gorontalo',
                'telepon_kantor'      => '(0435) 821xxx',
                'titik_koordinat'     => '0.5573330,123.0562500',
                'radius_absensi_meter'=> 50,
                'jam_masuk'           => '07:30:00',
                'batas_terlambat'     => '08:00:00',
                'batas_akhir_masuk'   => '11:00:00',
                'jam_pulang'          => '16:30:00',
                'batas_akhir_pulang'  => '19:00:00',
                'jam_pulang_jumat'    => '16:00:00',
                'bobot_kehadiran'     => 60.00,
                'bobot_produktivitas' => 25.00,
                'bobot_kualitas'      => 15.00,
                'ambang_sp1'          => 3,
                'ambang_sp2'          => 6,
                'ambang_sp3'          => 9,
                'pola_nomor_sp'       => '800/{nomor}/DISPERINDAG/{tahun}',
                'template_sp'         => 'Berdasarkan rekapitulasi data kehadiran terpadu DISPERINDAG Kota Gorontalo, yang bersangkutan telah mengakumulasi ketidakhadiran tanpa izin sah...',
            ]
        );

        // 2. Akun Administrator Utama (PRD Bab 7.1 & 7.2)
        $admin = User::firstOrCreate(
            ['username' => 'admin'],
            [
                'nama'     => 'Administrator Utama',
                'email'    => 'admin@disperindag.gorontalokota.go.id',
                'password' => Hash::make('admin123'),
                'peran'    => 'admin',
                'status'   => 'aktif',
            ]
        );

        // 3. Pegawai PPPK di 4 Bidang Resmi (PRD Bab 65.2)
        $dataPegawai = [
            [
                'nip'      => '19950620 202203 2 007',
                'nama'     => 'Rani Ayu Pratiwi',
                'no_hp'    => '081234567891',
                'jabatan'  => 'Staf PPPK / Petugas Pemantau Pasar',
                'bidang'   => 'Perdagangan',
                'alamat'   => 'Jl. Pangeran Hidayat No. 12, Kota Gorontalo',
                'status'   => 'Aktif',
                'username' => 'rani.ayu',
                'email'    => 'rani.ayu@disperindag.gorontalokota.go.id',
            ],
            [
                'nip'      => '19861103 201001 1 006',
                'nama'     => 'Budi Santoso',
                'no_hp'    => '081234567892',
                'jabatan'  => 'Penyuluh Perindag Ahli Pertama',
                'bidang'   => 'Perindustrian',
                'alamat'   => 'Jl. Nani Wartabone No. 88, Kota Gorontalo',
                'status'   => 'Aktif',
                'username' => 'budi.santoso',
                'email'    => 'budi.santoso@disperindag.gorontalokota.go.id',
            ],
            [
                'nip'      => '19880314 201101 1 002',
                'nama'     => 'Andi Saputra',
                'no_hp'    => '081234567893',
                'jabatan'  => 'Pengelola Administrasi Kepegawaian',
                'bidang'   => 'Sekretariat',
                'alamat'   => 'Jl. Sudirman No. 40, Kota Gorontalo',
                'status'   => 'Aktif',
                'username' => 'andi.saputra',
                'email'    => 'andi.saputra@disperindag.gorontalokota.go.id',
            ],
            [
                'nip'      => '19890115 201402 1 003',
                'nama'     => 'Dedi Kurniawan',
                'no_hp'    => '081234567894',
                'jabatan'  => 'Petugas Pengawas Peredaran Barang',
                'bidang'   => 'Perlindungan Konsumen',
                'alamat'   => 'Jl. Dua Susun No. 5, Kota Gorontalo',
                'status'   => 'Aktif',
                'username' => 'dedi.kurniawan',
                'email'    => 'dedi.kurniawan@disperindag.gorontalokota.go.id',
            ],
        ];

        $pegawaiModels = [];

        foreach ($dataPegawai as $data) {
            $pegawai = Pegawai::updateOrCreate(
                ['nip' => $data['nip']],
                [
                    'nama'    => $data['nama'],
                    'no_hp'   => $data['no_hp'],
                    'jabatan' => $data['jabatan'],
                    'bidang'  => $data['bidang'],
                    'alamat'  => $data['alamat'],
                    'status'  => $data['status'],
                ]
            );

            User::updateOrCreate(
                ['username' => $data['username']],
                [
                    'pegawai_id' => $pegawai->id,
                    'nama'       => $data['nama'],
                    'email'      => $data['email'],
                    'password'   => Hash::make('pegawai123'),
                    'peran'      => 'pegawai',
                    'status'     => 'aktif',
                ]
            );

            $pegawaiModels[] = $pegawai;
        }

        // 4. Presensi Hari Ini (Sampel Data Riil)
        $today = Carbon::today()->toDateString();

        if (isset($pegawaiModels[0])) {
            Presensi::updateOrCreate(
                ['pegawai_id' => $pegawaiModels[0]->id, 'tanggal' => $today],
                [
                    'jam_masuk'    => '07:22:15',
                    'status_masuk' => 'Tepat Waktu',
                    'jarak_masuk'  => 14.5,
                    'status'       => 'Hadir',
                ]
            );
        }

        if (isset($pegawaiModels[1])) {
            Presensi::updateOrCreate(
                ['pegawai_id' => $pegawaiModels[1]->id, 'tanggal' => $today],
                [
                    'jam_masuk'    => '08:08:42',
                    'status_masuk' => 'Terlambat',
                    'jarak_masuk'  => 28.2,
                    'status'       => 'Terlambat',
                ]
            );
        }

        if (isset($pegawaiModels[2])) {
            Presensi::updateOrCreate(
                ['pegawai_id' => $pegawaiModels[2]->id, 'tanggal' => $today],
                [
                    'jam_masuk'    => '07:15:00',
                    'status_masuk' => 'Tepat Waktu',
                    'jarak_masuk'  => 10.0,
                    'status'       => 'Hadir',
                ]
            );
        }

        // 5. Sampel Laporan Kegiatan Harian
        if (isset($pegawaiModels[0])) {
            LaporanKegiatan::updateOrCreate(
                [
                    'pegawai_id'    => $pegawaiModels[0]->id,
                    'tanggal'       => $today,
                    'nama_kegiatan' => 'Pendataan Harga Sembako di Pasar Sentral Kota Gorontalo',
                ],
                [
                    'deskripsi'             => 'Melakukan survei fluktuasi harga komoditas beras, minyak goreng, dan cabai rawit bersama tim seksi stabilisasi harga.',
                    'waktu_kirim'           => '14:30:00',
                    'nilai_produktivitas'   => 100.0,
                    'kategori_produktivitas' => 'Target Tercapai',
                    'nilai_kualitas'        => 90.0,
                    'kategori_kualitas'     => 'A',
                    'catatan_kualitas'      => 'Laporan sangat lengkap disertai dokumentasi foto timbangan dan wawancara pedagang.',
                    'status_verifikasi'     => 'Disetujui',
                ]
            );
        }

        if (isset($pegawaiModels[1])) {
            LaporanKegiatan::updateOrCreate(
                [
                    'pegawai_id'    => $pegawaiModels[1]->id,
                    'tanggal'       => $today,
                    'nama_kegiatan' => 'Monitoring Standarisasi Kemasan IKM Olahan Jagung',
                ],
                [
                    'deskripsi'             => 'Pemeriksaan kelayakan label kemasan dan izin PIRT pada 5 unit usaha olahan pangan lokal.',
                    'waktu_kirim'           => '15:10:00',
                    'nilai_produktivitas'   => 85.0,
                    'kategori_produktivitas' => 'Target Tercapai',
                    'nilai_kualitas'        => 85.0,
                    'kategori_kualitas'     => 'B',
                    'catatan_kualitas'      => 'Cukup baik, perlu ditambahkan nomor registrasi PIRT tiap pelaku usaha.',
                    'status_verifikasi'     => 'Disetujui',
                ]
            );
        }

        // 6. Sampel Pengajuan Izin / Cuti
        if (isset($pegawaiModels[3])) {
            PengajuanIzin::updateOrCreate(
                [
                    'pegawai_id'     => $pegawaiModels[3]->id,
                    'tanggal_mulai'  => Carbon::today()->addDays(2)->toDateString(),
                    'tanggal_selesai'=> Carbon::today()->addDays(4)->toDateString(),
                ],
                [
                    'jenis'             => 'Cuti',
                    'alasan'            => 'Cuti tahunan keperluan keluarga di luar daerah',
                    'status'            => 'Menunggu Review',
                ]
            );
        }

        // 7. Sampel Skor Kinerja Bulanan
        $currentMonth = Carbon::today()->format('Y-m');
        foreach ($pegawaiModels as $p) {
            SkorKinerja::updateOrCreate(
                [
                    'pegawai_id' => $p->id,
                    'periode'    => $currentMonth,
                ],
                [
                    'nilai_kehadiran'     => 92.5,
                    'nilai_produktivitas' => 90.0,
                    'nilai_kualitas'      => 88.0,
                    'bobot_kehadiran'     => 60.0,
                    'bobot_produktivitas' => 25.0,
                    'bobot_kualitas'      => 15.0,
                    'nilai_akhir'         => (92.5 * 0.6) + (90.0 * 0.25) + (88.0 * 0.15),
                    'kategori'            => 'Sangat Baik',
                    'status'              => 'Final',
                    'rekomendasi_kontrak' => 'Diperpanjang',
                ]
            );
        }
    }
}
