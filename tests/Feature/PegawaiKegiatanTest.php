<?php

namespace Tests\Feature;

use App\Models\LaporanKegiatan;
use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PegawaiKegiatanTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed');
    }

    public function test_pegawai_can_submit_kegiatan()
    {
        Storage::fake('public');
        
        $user = User::where('peran', 'pegawai')->first();
        $this->actingAs($user);

        // Simulasi absen datang agar bisa lapor kegiatan
        \App\Models\Presensi::create([
            'pegawai_id' => $user->pegawai->id,
            'tanggal'    => '2026-09-26',
            'jam_masuk'  => '07:30:00',
            'status'     => 'Hadir',
        ]);

        $file = UploadedFile::fake()->image('kegiatan.jpg');

        $response = $this->post(route('pegawai.kegiatan.store'), [
            'nama_kegiatan' => 'Kegiatan Test',
            'deskripsi'     => 'Deskripsi kegiatan test.',
            'tanggal'       => '2026-09-26',
            'foto'          => $file,
        ]);

        $response->assertStatus(302);
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('laporan_kegiatan', [
            'nama_kegiatan' => 'Kegiatan Test',
            'deskripsi'     => 'Deskripsi kegiatan test.',
            'status_verifikasi' => 'Menunggu Review'
        ]);

        $kegiatan = LaporanKegiatan::where('nama_kegiatan', 'Kegiatan Test')->first();
        Storage::disk('public')->assertExists($kegiatan->foto);
    }

    public function test_admin_can_verify_kegiatan()
    {
        $pegawaiUser = User::where('peran', 'pegawai')->first();
        $pegawai = $pegawaiUser->pegawai;

        $kegiatan = LaporanKegiatan::create([
            'pegawai_id' => $pegawai->id,
            'nama_kegiatan' => 'Kegiatan Verify Test',
            'deskripsi' => 'Deskripsi Verify Test',
            'tanggal' => '2026-09-26',
            'waktu_kirim' => '08:00:00',
            'status_verifikasi' => 'Menunggu Review'
        ]);

        $adminUser = User::where('peran', 'admin')->first();
        $this->actingAs($adminUser);

        $response = $this->post(route('admin.kegiatan.verifikasi', $kegiatan->id), [
            'status_verifikasi' => 'Disetujui',
            'nilai_kualitas'    => 90,
            'catatan_kualitas'  => 'Sangat baik',
        ]);

        $response->assertStatus(302);
        
        $this->assertDatabaseHas('laporan_kegiatan', [
            'id' => $kegiatan->id,
            'status_verifikasi' => 'Disetujui',
            'nilai_kualitas' => 90,
            'kategori_kualitas' => 'A'
        ]);
    }
}
