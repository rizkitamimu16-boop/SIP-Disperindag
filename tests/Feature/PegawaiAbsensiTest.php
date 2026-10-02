<?php

namespace Tests\Feature;

use App\Models\Pegawai;
use App\Models\PengaturanKantor;
use App\Models\Presensi;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Storage;

class PegawaiAbsensiTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $pegawai;
    protected $kantor;

    protected function setUp(): void
    {
        parent::setUp();
        
        Storage::fake('public');

        $this->kantor = PengaturanKantor::create([
            'nama_skpd'           => 'Dinas Perindustrian dan Perdagangan',
            'nama_instansi'       => 'Pemerintah',
            'alamat_kantor'       => 'Jl. Test No. 1',
            'telepon_kantor'      => '0812345',
            'titik_koordinat'     => '0.5573330,123.0562500',
            'radius_absensi_meter'=> 50, // 50 meter
            'jam_masuk'           => '07:30:00',
            'batas_terlambat'     => '08:00:00',
            'batas_akhir_masuk'   => '11:00:00',
            'jam_pulang'          => '16:30:00',
            'batas_akhir_pulang'  => '19:00:00',
            'jam_pulang_jumat'    => '16:00:00',
        ]);

        $this->pegawai = Pegawai::create([
            'nip' => '123456789',
            'nama' => 'Pegawai Test',
            'jabatan' => 'Staf',
            'bidang' => 'Perdagangan',
            'status' => 'Aktif',
        ]);

        $this->user = User::create([
            'pegawai_id' => $this->pegawai->id,
            'nama' => 'Pegawai Test',
            'username' => 'pegawai.test',
            'email' => 'pegawai@test.com',
            'password' => bcrypt('password123'),
            'peran' => 'pegawai',
            'status' => 'aktif',
        ]);
    }

    public function test_pegawai_dapat_merekam_absensi_masuk_di_dalam_radius()
    {
        Carbon::setTestNow(Carbon::createFromTime(7, 45, 0)); // Jam 07:45 (Tepat Waktu)

        $response = $this->actingAs($this->user)->postJson('/pegawai/absensi/record', [
            'type' => 'masuk',
            'latitude' => 0.5573330, // Titik yang sama dengan kantor
            'longitude' => 123.0562500,
            'photo' => 'data:image/jpeg;base64,/9j/4AAQSkZJRgABAQEAAAAAAAD/2wBD...',
        ]);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $this->assertDatabaseHas('presensi', [
            'pegawai_id' => $this->pegawai->id,
            'status_masuk' => 'Tepat Waktu',
            'status' => 'Hadir'
        ]);
        
        Carbon::setTestNow();
    }

    public function test_pegawai_ditolak_absen_masuk_jika_di_luar_radius()
    {
        Carbon::setTestNow(Carbon::createFromTime(7, 45, 0));

        $response = $this->actingAs($this->user)->postJson('/pegawai/absensi/record', [
            'type' => 'masuk',
            'latitude' => 0.5583330, // Titik yang cukup jauh dari kantor (>50m)
            'longitude' => 123.0562500,
            'photo' => 'data:image/jpeg;base64,/9j/4AAQSkZJRg...',
        ]);

        $response->assertStatus(422); // Gagal validasi jarak
        $response->assertJsonFragment(['success' => false]);
        
        // Memastikan presensi tidak tersimpan
        $this->assertDatabaseMissing('presensi', [
            'pegawai_id' => $this->pegawai->id,
            'tanggal' => Carbon::today()->toDateString(),
        ]);
        
        Carbon::setTestNow();
    }
    
    public function test_pegawai_tercatat_terlambat_jika_melewati_batas_terlambat()
    {
        Carbon::setTestNow(Carbon::createFromTime(8, 15, 0)); // Jam 08:15 (Terlambat)

        $response = $this->actingAs($this->user)->postJson('/pegawai/absensi/record', [
            'type' => 'masuk',
            'latitude' => 0.5573330,
            'longitude' => 123.0562500,
            'photo' => 'data:image/jpeg;base64,12345',
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('presensi', [
            'pegawai_id' => $this->pegawai->id,
            'status_masuk' => 'Terlambat',
            'status' => 'Terlambat'
        ]);
        
        Carbon::setTestNow();
    }
}
