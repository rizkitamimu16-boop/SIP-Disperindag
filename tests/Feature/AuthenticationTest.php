<?php

namespace Tests\Feature;

use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_can_be_rendered()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    public function test_pegawai_can_login_with_correct_credentials()
    {
        $pegawai = Pegawai::create([
            'nip' => '1234567890',
            'nama' => 'Test Pegawai',
            'jabatan' => 'Staf',
            'bidang' => 'Perdagangan',
            'status' => 'Aktif',
        ]);

        $user = User::create([
            'pegawai_id' => $pegawai->id,
            'nama' => 'Test Pegawai',
            'username' => 'test.pegawai',
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
            'peran' => 'pegawai',
            'status' => 'aktif',
        ]);

        $response = $this->post('/login', [
            'username' => 'test.pegawai',
            'password' => 'password123',
        ]);

        $this->assertAuthenticatedAs($user);
        $response->assertRedirect('/pegawai/dashboard');
    }

    public function test_admin_can_login_with_correct_credentials()
    {
        $user = User::create([
            'nama' => 'Admin Test',
            'username' => 'admin.test',
            'email' => 'admin.test@example.com',
            'password' => Hash::make('password123'),
            'peran' => 'admin',
            'status' => 'aktif',
        ]);

        $response = $this->post('/login', [
            'username' => 'admin.test',
            'password' => 'password123',
        ]);

        $this->assertAuthenticatedAs($user);
        $response->assertRedirect('/admin/dashboard');
    }

    public function test_user_cannot_login_with_incorrect_password()
    {
        $user = User::create([
            'nama' => 'Test',
            'username' => 'test.wrong',
            'email' => 'test.wrong@example.com',
            'password' => Hash::make('password123'),
            'peran' => 'pegawai',
            'status' => 'aktif',
        ]);

        $response = $this->post('/login', [
            'username' => 'test.wrong',
            'password' => 'wrongpassword',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors(['login']);
    }
}
