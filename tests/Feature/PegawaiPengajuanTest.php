<?php

namespace Tests\Feature;

use App\Models\Pegawai;
use App\Models\PengajuanIzin;
use App\Models\Presensi;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PegawaiPengajuanTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed');
    }

    public function test_pegawai_can_submit_pengajuan()
    {
        Storage::fake('public');
        
        $user = User::where('peran', 'pegawai')->first();
        $this->actingAs($user);

        $file = UploadedFile::fake()->create('dokumen.pdf', 100);

        $response = $this->post(route('pegawai.pengajuan.store'), [
            'jenis'           => 'Cuti',
            'tanggal_mulai'   => '2026-09-27',
            'tanggal_selesai' => '2026-09-28',
            'alasan'          => 'Acara Keluarga',
            'dokumen'         => $file,
        ]);

        $response->assertStatus(302);
        $response->assertSessionHas('success');

        $this->assertTrue(PengajuanIzin::where('jenis', 'Cuti')->where('status', 'Menunggu Review')->exists());

        $pengajuan = PengajuanIzin::where('alasan', 'Acara Keluarga')->first();
        Storage::disk('public')->assertExists($pengajuan->dokumen);
    }

    public function test_admin_can_approve_pengajuan_and_create_presensi()
    {
        $pegawaiUser = User::where('peran', 'pegawai')->first();
        $pegawai = $pegawaiUser->pegawai;

        $pengajuan = PengajuanIzin::create([
            'pegawai_id' => $pegawai->id,
            'jenis' => 'Dinas Luar',
            'tanggal_mulai' => '2026-09-27',
            'tanggal_selesai' => '2026-09-28',
            'alasan' => 'Dinas Luar Kota',
            'status' => 'Menunggu Review'
        ]);

        $adminUser = User::where('peran', 'admin')->first();
        $this->actingAs($adminUser);

        $response = $this->post(route('admin.pengajuan.status', $pengajuan->id), [
            'status' => 'Disetujui',
            'catatan_admin' => 'Baik, hati-hati di jalan',
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('pengajuan_izin', [
            'id' => $pengajuan->id,
            'status' => 'Disetujui'
        ]);

        // Assert Presensi was created for both days
        $this->assertEquals(2, Presensi::where('pegawai_id', $pegawai->id)->where('status', 'Dinas Luar')->count());
    }
}
