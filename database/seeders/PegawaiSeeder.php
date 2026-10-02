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
            ['nama' => 'Rita Ronosumitro, S.IP', 'nip' => '197002202025212008'],
            ['nama' => 'Indriani Fransisca Daliuwa, SE', 'nip' => '198910292025212051'],
            ['nama' => 'Intan Van Gobel, S.AP', 'nip' => '199407202025212086'],
            ['nama' => 'Marwiyah Abd Gafur', 'nip' => '198811292025212042'],
            ['nama' => 'Ningsih Ayu Woloto, A.Md', 'nip' => '198801082025212058'],
            ['nama' => 'Sri Hartati Hala, S.Pd', 'nip' => '198602152025212047'],
            ['nama' => 'Rahmat Utija', 'nip' => '198004192025211041'],
            ['nama' => 'Agustina Mailensun', 'nip' => '197508202025212016'],
            ['nama' => 'Fandi Kamah', 'nip' => '198511272025211048'],
            ['nama' => 'Helmi Mbuinga', 'nip' => '198203272025212035'],
            ['nama' => 'Hendrik pakudu, S.Kom', 'nip' => '198707112025211071'],
            ['nama' => 'Heni Wartabone', 'nip' => '198512242025212047'],
            ['nama' => 'Imam Husin', 'nip' => '198512222025211066'],
            ['nama' => 'Jein Kalengkongan', 'nip' => '198001132025212020'],
            ['nama' => 'Jefri Dama', 'nip' => '198401052025211061'],
            ['nama' => 'Lindawati said', 'nip' => '198803202025212067'],
            ['nama' => 'Ram N. Hakim, S.IP', 'nip' => '197310042025212015'],
            ['nama' => 'Rini Otoluwa, S.IP', 'nip' => '197706182025212025'],
            ['nama' => 'Rusmin Adjunge, SE', 'nip' => '197604222025212016'],
            ['nama' => 'Wahyunie Bahsoan', 'nip' => '197706172025212023'],
            ['nama' => 'Yulinda M. Lasibu, S.Kom', 'nip' => '199307012025212075'],
            ['nama' => 'Yuningsih Sadu', 'nip' => '197303032025212021'],
            ['nama' => 'Yusuf Manopo', 'nip' => '197411022025211014'],
        ];

        foreach ($pegawaiList as $data) {
            $nip = preg_replace('/\D/', '', $data['nip']);
            $namaClean = preg_replace('/[,.]/', '', $data['nama']);
            $jabatan = 'Staf Pegawai';
            $bidang = 'Sekretariat'; // default

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

                $username = Str::slug(explode(' ', $namaClean)[0], '') . '.' . substr($nip, -4);
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
                    'password' => Hash::make('pegawai123'),
                    'peran' => 'pegawai',
                    'status' => 'aktif',
                ]);
            }
        }
    }
}
