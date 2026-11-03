<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PegawaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pegawaiList = [
            // SEKRETARIAT (8)
            ['nama' => 'Indriani Fransisca Daliuwa, SE', 'nip' => '198910292025212051', 'bidang' => 'Sekretariat'],
            ['nama' => 'Intan Van Gobel, S.AP', 'nip' => '199407202025212086', 'bidang' => 'Sekretariat'],
            ['nama' => 'Jein Kalengkongan', 'nip' => '198001132025212020', 'bidang' => 'Sekretariat'],
            ['nama' => 'Lindawati said', 'nip' => '198803202025212067', 'bidang' => 'Sekretariat'],
            ['nama' => 'Marwiyah Abd Gafur', 'nip' => '198811292025212042', 'bidang' => 'Sekretariat'],
            ['nama' => 'Rahmat Utija', 'nip' => '198004192025211041', 'bidang' => 'Sekretariat'],
            ['nama' => 'Ram N. Hakim, S.IP', 'nip' => '197310042025212015', 'bidang' => 'Sekretariat'],
            ['nama' => 'Sri Hartati Hala, S.Pd', 'nip' => '198602152025212047', 'bidang' => 'Sekretariat'],

            // BIDANG PERDAGANGAN (9)
            ['nama' => 'Fandi Kamah', 'nip' => '198511272025211048', 'bidang' => 'Perdagangan'],
            ['nama' => 'Imam Husin', 'nip' => '198512222025211066', 'bidang' => 'Perdagangan'],
            ['nama' => 'Jefri Dama', 'nip' => '198401052025211061', 'bidang' => 'Perdagangan'],
            ['nama' => 'Rini Otoluwa, S.IP', 'nip' => '197706182025212025', 'bidang' => 'Perdagangan'],
            ['nama' => 'Rusmin Adjunge, SE', 'nip' => '197604222025212016', 'bidang' => 'Perdagangan'],
            ['nama' => 'Wahyunie Bahsoan', 'nip' => '197706172025212023', 'bidang' => 'Perdagangan'],
            ['nama' => 'Yulinda M. Lasibu, S.Kom', 'nip' => '199307012025212075', 'bidang' => 'Perdagangan'],
            ['nama' => 'Yuningsih Sadu', 'nip' => '197303032025212021', 'bidang' => 'Perdagangan'],
            ['nama' => 'Yusuf Manopo', 'nip' => '197411022025211014', 'bidang' => 'Perdagangan'],

            // BIDANG PERINDUSTRIAN (3)
            ['nama' => 'Rita Ronosumitro, S.IP', 'nip' => '197002202025212008', 'bidang' => 'Perindustrian'],
            ['nama' => 'Ningsih Ayu Woloto, A.Md', 'nip' => '198801082025212058', 'bidang' => 'Perindustrian'],
            ['nama' => 'Helmi Mbuinga', 'nip' => '198203272025212035', 'bidang' => 'Perindustrian'],

            // BIDANG PERLINDUNGAN KONSUMEN (3)
            ['nama' => 'Hendrik pakudu, S.Kom', 'nip' => '198707112025211071', 'bidang' => 'Perlindungan Konsumen'],
            ['nama' => 'Agustina Mailensun', 'nip' => '197508202025212016', 'bidang' => 'Perlindungan Konsumen'],
            ['nama' => 'Heni Wartabone', 'nip' => '198512242025212047', 'bidang' => 'Perlindungan Konsumen'],
        ];

        foreach ($pegawaiList as $data) {
            $nip = preg_replace('/\D/', '', $data['nip']);
            $namaClean = preg_replace('/[,.]/', '', $data['nama']);
            $jabatan = 'Staf Pegawai';
            $bidang = $data['bidang'] ?? 'Sekretariat';

            if (!Pegawai::where('nip', $nip)->exists()) {
                $pegawai = Pegawai::create([
                    'nip' => $nip,
                    'nama' => $data['nama'],
                    'no_hp' => null,
                    'jabatan' => $jabatan,
                    'bidang' => $bidang,
                    'alamat' => null,
                    'status' => 'Aktif',
                ]);

                $firstName = strtolower(preg_replace('/[^a-zA-Z]/', '', explode(' ', $namaClean)[0] ?? 'pegawai'));
                $userPass = $firstName . '.123';
                $username = $userPass;
                $email = Str::slug($namaClean, '.') . '@disperindag.gorontalokota.go.id';
                
                $baseUsername = $username;
                $counter = 1;
                while (User::where('username', $username)->exists()) {
                    $username = $baseUsername . $counter;
                    $counter++;
                }
                
                $baseEmail = $email;
                $counterEmail = 1;
                while (User::where('email', $email)->exists()) {
                    $email = str_replace('@', $counterEmail . '@', $baseEmail);
                    $counterEmail++;
                }

                User::create([
                    'pegawai_id' => $pegawai->id,
                    'nama' => $data['nama'],
                    'username' => $username,
                    'email' => $email,
                    'password' => Hash::make($userPass),
                    'peran' => 'pegawai',
                    'status' => 'aktif',
                ]);
            }
        }
    }
}
