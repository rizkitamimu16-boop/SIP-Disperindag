<?php

namespace Tests\Feature;

use App\Models\Pegawai;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DatabaseSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_database_seeder_runs_successfully(): void
    {
        $this->seed(DatabaseSeeder::class);

        // Pastikan Super Admin terbentuk
        $admin = User::where('username', 'admin')->first();
        $this->assertNotNull($admin);
        $this->assertTrue($admin->isSuperAdmin());

        // Pastikan Nita terbentuk
        $nita = User::where('username', 'nita')->first();
        $this->assertNotNull($nita);
        $this->assertFalse($nita->isSuperAdmin());
        $this->assertFalse($nita->isKabid());

        // Pastikan 4 Kabid terbentuk
        $kabids = [
            'kabid_perindustrian' => 'Perindustrian',
            'kabid_perdagangan'   => 'Perdagangan',
            'kabid_sekretariat'   => 'Sekretariat',
            'kabid_konsumen'      => 'Perlindungan Konsumen',
        ];

        foreach ($kabids as $username => $bidang) {
            $kabid = User::where('username', $username)->first();
            $this->assertNotNull($kabid, "Akun Kabid {$username} gagal dibuat.");
            $this->assertTrue($kabid->isKabid(), "Akun {$username} tidak terdeteksi sebagai Kabid.");
            $this->assertEquals($bidang, $kabid->bidang);
        }

        // Pastikan 23 pegawai PPPK di 4 bidang resmi terbentuk
        $this->assertEquals(23, Pegawai::count());
    }
}
