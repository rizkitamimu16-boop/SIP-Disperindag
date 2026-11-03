<?php

namespace Tests\Feature;

use App\Models\Pegawai;
use App\Models\PengaturanKantor;
use App\Models\Presensi;
use App\Models\SuratPeringatan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SuratPeringatanTest extends TestCase
{
    use RefreshDatabase;

    protected $adminUser;
    protected $pegawaiUser;
    protected $pegawai;

    protected function setUp(): void
    {
        parent::setUp();

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
            'bobot_kehadiran'     => 60.00,
            'bobot_produktivitas' => 25.00,
            'bobot_kualitas'      => 15.00,
            'ambang_sp1'          => 3,
            'ambang_sp2'          => 6,
            'ambang_sp3'          => 9,
        ]);

        $this->pegawai = Pegawai::create([
            'nip'     => '199001012026011001',
            'nama'    => 'Budi Pegawai',
            'jabatan' => 'Tenaga Teknis',
            'bidang'  => 'Perdagangan',
            'status'  => 'Aktif',
        ]);

        $this->pegawaiUser = User::create([
            'pegawai_id' => $this->pegawai->id,
            'nama'       => 'Budi Pegawai',
            'username'   => 'budi.pegawai',
            'email'      => 'budi@disperindag.local',
            'password'   => bcrypt('password'),
            'peran'      => 'pegawai',
            'status'     => 'aktif',
        ]);

        $this->adminUser = User::create([
            'nama'     => 'Admin Personalia',
            'username' => 'admin.test',
            'email'    => 'admin@disperindag.local',
            'password' => bcrypt('password'),
            'peran'    => 'admin',
            'status'   => 'aktif',
        ]);
    }

    public function test_threshold_3_alpha_creates_draft_sp1()
    {
        // Buat 3 catatan Alpha
        for ($i = 1; $i <= 3; $i++) {
            Presensi::create([
                'pegawai_id' => $this->pegawai->id,
                'tanggal'    => "2026-09-0{$i}",
                'status'     => 'Alpha',
            ]);
        }

        // Jalankan sinkronisasi
        SuratPeringatan::syncDraftSpForPegawai($this->pegawai);

        $sp = SuratPeringatan::where('pegawai_id', $this->pegawai->id)->first();
        $this->assertNotNull($sp);
        $this->assertEquals('SP-1', $sp->tingkat_sp);
        $this->assertEquals(3, $sp->jumlah_alpha);
        $this->assertTrue($sp->is_draft);
        $this->assertEmpty($sp->nomor_surat);
    }

    public function test_threshold_6_and_9_alpha_creates_sp2_and_sp3()
    {
        // Buat 6 catatan Alpha
        for ($i = 1; $i <= 6; $i++) {
            Presensi::create([
                'pegawai_id' => $this->pegawai->id,
                'tanggal'    => sprintf("2026-09-%02d", $i),
                'status'     => 'Alpha',
            ]);
        }

        SuratPeringatan::syncDraftSpForPegawai($this->pegawai);
        $this->assertDatabaseHas('surat_peringatan', [
            'pegawai_id'   => $this->pegawai->id,
            'tingkat_sp'   => 'SP-2',
            'jumlah_alpha' => 6,
        ]);

        // Tambah 3 lagi hingga 9 Alpha
        for ($i = 7; $i <= 9; $i++) {
            Presensi::create([
                'pegawai_id' => $this->pegawai->id,
                'tanggal'    => sprintf("2026-09-%02d", $i),
                'status'     => 'Alpha',
            ]);
        }

        SuratPeringatan::syncDraftSpForPegawai($this->pegawai);
        $this->assertDatabaseHas('surat_peringatan', [
            'pegawai_id'   => $this->pegawai->id,
            'tingkat_sp'   => 'SP-3',
            'jumlah_alpha' => 9,
        ]);
    }

    public function test_draft_sp_is_not_visible_to_pegawai_until_published()
    {
        // Buat 3 Alpha sehingga draf SP-1 terbuat
        for ($i = 1; $i <= 3; $i++) {
            Presensi::create([
                'pegawai_id' => $this->pegawai->id,
                'tanggal'    => "2026-09-0{$i}",
                'status'     => 'Alpha',
            ]);
        }
        SuratPeringatan::syncDraftSpForPegawai($this->pegawai);

        // Pegawai membuka dashboard pelanggaran SP
        $response = $this->actingAs($this->pegawaiUser)
            ->get(route('pegawai.pelanggaran-sp'));

        $response->assertStatus(200);
        // SP count harus 0 karena SP masih draf (belum terbit nomor surat)
        $response->assertViewHas('spCount', 0);
        $this->assertCount(0, $response->viewData('spLetters'));
    }

    public function test_admin_can_publish_sp_with_nomor_surat()
    {
        $draftSp = SuratPeringatan::create([
            'pegawai_id'     => $this->pegawai->id,
            'tingkat_sp'     => 'SP-1',
            'jumlah_alpha'   => 3,
            'nomor_surat'    => '',
            'tanggal_terbit' => '2026-09-03',
            'status'         => 'Aktif',
        ]);

        $response = $this->actingAs($this->adminUser)
            ->post(route('admin.surat-peringatan.terbitkan', $draftSp->id), [
                'nomor_surat' => '800/015/DISPERINDAG/2026',
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $draftSp->refresh();
        $this->assertEquals('800/015/DISPERINDAG/2026', $draftSp->nomor_surat);
        $this->assertTrue($draftSp->is_terbit);
        $this->assertEquals(Carbon::now()->format('Y-m-d'), $draftSp->tanggal_terbit->format('Y-m-d'));
    }

    public function test_pegawai_can_view_and_download_published_sp()
    {
        $sp = SuratPeringatan::create([
            'pegawai_id'     => $this->pegawai->id,
            'tingkat_sp'     => 'SP-1',
            'jumlah_alpha'   => 3,
            'nomor_surat'    => '800/015/DISPERINDAG/2026',
            'tanggal_terbit' => '2026-09-03',
            'status'         => 'Aktif',
        ]);

        $response = $this->actingAs($this->pegawaiUser)
            ->get(route('pegawai.pelanggaran-sp'));

        $response->assertStatus(200);
        $response->assertViewHas('spCount', 1);
        $response->assertSee('800/015/DISPERINDAG/2026');

        // Test download PDF oleh pegawai
        $pdfResponse = $this->actingAs($this->pegawaiUser)
            ->get(route('pegawai.pelanggaran-sp.pdf', $sp->id));

        $pdfResponse->assertStatus(200);
        $this->assertStringContainsString('application/pdf', $pdfResponse->headers->get('content-type'));
    }

    public function test_admin_cannot_publish_sp_without_nomor_surat()
    {
        $draftSp = SuratPeringatan::create([
            'pegawai_id'     => $this->pegawai->id,
            'tingkat_sp'     => 'SP-1',
            'jumlah_alpha'   => 3,
            'nomor_surat'    => '',
            'tanggal_terbit' => '2026-09-03',
            'status'         => 'Aktif',
        ]);

        $response = $this->actingAs($this->adminUser)
            ->post(route('admin.surat-peringatan.terbitkan', $draftSp->id), [
                'nomor_surat' => '',
            ]);

        $response->assertSessionHasErrors('nomor_surat');
    }
}
