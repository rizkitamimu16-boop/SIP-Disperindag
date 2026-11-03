<?php

namespace Tests\Feature;

use App\Models\LaporanKegiatan;
use App\Models\Pegawai;
use App\Models\PengaturanKantor;
use App\Models\Presensi;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProduktivitasTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $pegawai;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');

        PengaturanKantor::create([
            'nama_skpd'           => 'Dinas Perdagangan dan Perindustrian Kota Gorontalo',
            'nama_instansi'       => 'Pemerintah Kota Gorontalo',
            'titik_koordinat'     => '0.5573330,123.0562500',
            'radius_absensi_meter'=> 50,
            'jam_masuk'           => '07:30:00',
            'batas_terlambat'     => '08:30:00',
            'batas_akhir_masuk'   => '09:00:00',
            'jam_pulang'          => '16:00:00',
            'batas_akhir_pulang'  => '18:00:00',
            'jam_pulang_jumat'    => '16:00:00',
        ]);

        $this->pegawai = Pegawai::create([
            'nip'     => '199002022026011002',
            'nama'    => 'Rina Kegiatan',
            'jabatan' => 'Penyusun Program',
            'bidang'  => 'Perindustrian',
            'status'  => 'Aktif',
        ]);

        $this->user = User::create([
            'pegawai_id' => $this->pegawai->id,
            'nama'       => 'Rina Kegiatan',
            'username'   => 'rina.kegiatan',
            'email'      => 'rina@disperindag.local',
            'password'   => bcrypt('password'),
            'peran'      => 'pegawai',
            'status'     => 'aktif',
        ]);

        // Simulasi absen datang hari ini
        Presensi::create([
            'pegawai_id' => $this->pegawai->id,
            'tanggal'    => Carbon::today()->toDateString(),
            'jam_masuk'  => '07:45:00',
            'status'     => 'Hadir',
        ]);
    }

    public function test_produktivitas_complete_with_photo_gets_100_not_fixed_85()
    {
        $today = Carbon::today()->toDateString();
        $file = UploadedFile::fake()->image('bukti_kegiatan.jpg');

        $response = $this->actingAs($this->user)
            ->post(route('pegawai.kegiatan.store'), [
                'nama_kegiatan' => 'Penyusunan Rencana Monitoring Pasar',
                'deskripsi'     => 'Melakukan pendataan harga komoditas pangan dan evaluasi stok beras di pasar tradisional.',
                'tanggal'       => $today,
                'foto'          => $file,
            ]);

        $response->assertStatus(302);
        $response->assertSessionHas('success');

        $laporan = LaporanKegiatan::where('pegawai_id', $this->pegawai->id)->first();
        $this->assertNotNull($laporan);

        // Nilai produktivitas harus 100.00 (bukan 85.00 tetap)
        $this->assertEquals(100.00, $laporan->nilai_produktivitas);
        $this->assertEquals('Sangat Baik', $laporan->kategori_produktivitas);
        $this->assertNotEquals(85.00, $laporan->nilai_produktivitas);
    }

    public function test_produktivitas_without_photo_deducts_evidence_score()
    {
        $today = Carbon::today()->toDateString();

        $response = $this->actingAs($this->user)
            ->post(route('pegawai.kegiatan.store'), [
                'nama_kegiatan' => 'Rapat Koordinasi Mingguan Bidang',
                'deskripsi'     => 'Mengikuti rapat koordinasi teknis bersama seluruh staf bidang perindustrian.',
                'tanggal'       => $today,
                // Tanpa foto
            ]);

        $response->assertStatus(302);
        $response->assertSessionHas('success');

        $laporan = LaporanKegiatan::where('pegawai_id', $this->pegawai->id)->first();
        $this->assertNotNull($laporan);

        // Tanpa foto: 25 (kelengkapan) + 0 (bukti) + 20 (tepat waktu) + 30 (target) = 75
        $this->assertEquals(75.00, $laporan->nilai_produktivitas);
        $this->assertEquals('Cukup', $laporan->kategori_produktivitas);
    }

    public function test_produktivitas_late_reporting_penalty()
    {
        $yesterday = Carbon::yesterday()->toDateString();

        // Hitung skor produktivitas untuk laporan H+1 tanpa foto
        $result = LaporanKegiatan::hitungProduktivitas([
            'nama_kegiatan' => 'Laporan Kemarin',
            'deskripsi'     => 'Deskripsi lengkap kegiatan kemarin melebihi batas dua puluh karakter.',
            'tanggal'       => $yesterday,
            'foto'          => null,
        ], $this->pegawai->id);

        // 25 (kelengkapan) + 0 (bukti) + 10 (H+1) + 30 (jumlah) = 65
        $this->assertEquals(65.00, $result['nilai']);
        $this->assertEquals('Kurang', $result['kategori']);
    }
}
