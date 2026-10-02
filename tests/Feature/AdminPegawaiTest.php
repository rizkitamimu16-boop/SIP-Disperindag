<?php

namespace Tests\Feature;

use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminPegawaiTest extends TestCase
{
    use RefreshDatabase;

    protected $adminUser;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->adminUser = User::create([
            'nama' => 'Admin Test',
            'username' => 'admin.test',
            'email' => 'admin@test.com',
            'password' => bcrypt('password123'),
            'peran' => 'admin',
            'status' => 'aktif',
        ]);
    }

    public function test_admin_can_view_pegawai_list()
    {
        $response = $this->actingAs($this->adminUser)->get('/admin/data-pegawai');
        $response->assertStatus(200);
        $response->assertViewIs('admin.data-pegawai');
    }

    public function test_admin_can_create_pegawai()
    {
        $response = $this->actingAs($this->adminUser)->post('/admin/data-pegawai', [
            'nip' => '987654321',
            'nama' => 'Pegawai Baru',
            'bidang' => 'Perindustrian',
            'jabatan' => 'Analis',
            'email' => 'baru@test.com',
            'no_hp' => '081234567',
        ]);

        $response->assertRedirect('/admin/pegawai'); // Because the route redirects to admin.pegawai
        $response->assertSessionHas('success');

        // Memastikan pegawai tersimpan
        $this->assertDatabaseHas('pegawai', [
            'nip' => '987654321',
            'nama' => 'Pegawai Baru',
            'bidang' => 'Perindustrian',
        ]);

        // Memastikan akun pengguna otomatis dibuat
        $this->assertDatabaseHas('pengguna', [
            'email' => 'baru@test.com',
            'peran' => 'pegawai',
        ]);
    }

    public function test_admin_can_update_pegawai()
    {
        $pegawai = Pegawai::create([
            'nip' => '111111',
            'nama' => 'Lama',
            'jabatan' => 'Staf',
            'bidang' => 'Sekretariat',
            'status' => 'Aktif',
        ]);

        $user = User::create([
            'pegawai_id' => $pegawai->id,
            'nama' => 'Lama',
            'username' => 'lama',
            'email' => 'lama@test.com',
            'password' => bcrypt('pass'),
            'peran' => 'pegawai',
            'status' => 'aktif',
        ]);

        $response = $this->actingAs($this->adminUser)->put("/admin/data-pegawai/{$pegawai->id}", [
            'nip' => '111111',
            'nama' => 'Nama Baru',
            'bidang' => 'Sekretariat',
            'jabatan' => 'Staf Senior',
            'status' => 'Aktif',
            'email' => 'baru_email@test.com',
        ]);

        $response->assertRedirect('/admin/pegawai');

        // Memastikan nama pegawai terupdate
        $this->assertDatabaseHas('pegawai', [
            'id' => $pegawai->id,
            'nama' => 'Nama Baru',
        ]);

        // Memastikan email di pengguna terupdate
        $this->assertDatabaseHas('pengguna', [
            'pegawai_id' => $pegawai->id,
            'email' => 'baru_email@test.com',
        ]);
    }

    public function test_admin_can_delete_pegawai()
    {
        $pegawai = Pegawai::create([
            'nip' => '222222',
            'nama' => 'Akan Dihapus',
            'jabatan' => 'Staf',
            'bidang' => 'Sekretariat',
        ]);

        $response = $this->actingAs($this->adminUser)->delete("/admin/data-pegawai/{$pegawai->id}");

        $response->assertRedirect('/admin/pegawai');
        
        $this->assertDatabaseMissing('pegawai', [
            'id' => $pegawai->id,
        ]);
    }
}
