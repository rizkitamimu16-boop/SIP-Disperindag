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
                'nama_skpd'           => 'Dinas Perdagangan dan Perindustrian Kota Gorontalo',
                'nama_instansi'       => 'Pemerintah Kota Gorontalo',
                'alamat_kantor'       => 'Jl. Jalaluddin Tantu No. 45, Kota Gorontalo',
                'telepon_kantor'      => '(0435) 821xxx',
                'titik_koordinat'     => '0.5573330,123.0562500',
                'radius_absensi_meter'=> 50,
                'jam_masuk'           => '07:30:00',
                'batas_terlambat'     => '08:30:00',
                'batas_akhir_masuk'   => '09:00:00',
                'jam_pulang'          => '16:00:00',
                'batas_akhir_pulang'  => '18:00:00',
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

        // 2.1 Akun Admin Kepegawaian (Nita) - Administrator Global
        User::firstOrCreate(
            ['username' => 'nita'],
            [
                'nama'     => 'Nita (Admin Kepegawaian)',
                'email'    => 'nita@disperindag.gorontalokota.go.id',
                'password' => Hash::make('nita123'),
                'peran'    => 'admin',
                'bidang'   => null,
                'status'   => 'aktif',
            ]
        );

        // 2.2 Akun 4 Kepala Bidang (Kabid)
        $dataKabid = [
            [
                'username' => 'kabid_perindustrian',
                'nama'     => 'Kepala Bidang Perindustrian',
                'email'    => 'kabid.industri@disperindag.gorontalokota.go.id',
                'bidang'   => 'Perindustrian',
            ],
            [
                'username' => 'kabid_perdagangan',
                'nama'     => 'Kepala Bidang Perdagangan',
                'email'    => 'kabid.dagang@disperindag.gorontalokota.go.id',
                'bidang'   => 'Perdagangan',
            ],
            [
                'username' => 'kabid_sekretariat',
                'nama'     => 'Sekretaris Dinas',
                'email'    => 'sekretariat@disperindag.gorontalokota.go.id',
                'bidang'   => 'Sekretariat',
            ],
            [
                'username' => 'kabid_konsumen',
                'nama'     => 'Kepala Bidang Perlindungan Konsumen',
                'email'    => 'kabid.konsumen@disperindag.gorontalokota.go.id',
                'bidang'   => 'Perlindungan Konsumen',
            ],
        ];

        foreach ($dataKabid as $kb) {
            User::firstOrCreate(
                ['username' => $kb['username']],
                [
                    'nama'     => $kb['nama'],
                    'email'    => $kb['email'],
                    'password' => Hash::make('kabid123'),
                    'peran'    => 'admin',
                    'bidang'   => $kb['bidang'],
                    'status'   => 'aktif',
                ]
            );
        }

        // 3. Pegawai PPPK Resmi di 4 Bidang (23 Pegawai Resmi Instansi)
        $this->call(PegawaiSeeder::class);
    }
}
