<?php

namespace Tests\Feature;

use App\Models\Pegawai;
use App\Models\PengajuanIzin;
use App\Models\Presensi;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PersetujuanSakitTest extends TestCase
{
    use RefreshDatabase;

    protected $adminUser;
    protected $pegawai;

    protected function setUp(): void
    {
        parent::setUp();

        $this->pegawai = Pegawai::create([
            'nip'     => '199004042026011004',
            'nama'    => 'Siti Sakit',
            'jabatan' => 'Penyusun Laporan',
            'bidang'  => 'Sekretariat',
            'status'  => 'Aktif',
        ]);

        $this->adminUser = User::create([
            'nama'     => 'Admin Pengajuan',
            'username' => 'admin.pengajuan',
            'email'    => 'admin.pengajuan@disperindag.local',
            'password' => bcrypt('password'),
            'peran'    => 'admin',
            'status'   => 'aktif',
        ]);
    }

    public function test_persetujuan_sakit_writes_valid_status_to_presensi_schema()
    {
        // Buat pengajuan izin sakit
        $pengajuan = PengajuanIzin::create([
            'pegawai_id'      => $this->pegawai->id,
            'jenis'           => 'Sakit',
            'tanggal_mulai'   => '2026-09-10',
            'tanggal_selesai' => '2026-09-11',
            'alasan'          => 'Demam tinggi dan istirahat dokter',
            'status'          => 'Menunggu Review',
        ]);

        $response = $this->actingAs($this->adminUser)
            ->post(route('admin.pengajuan.status', $pengajuan->id), [
                'status'        => 'Disetujui',
                'catatan_admin' => 'Surat dokter terlampir valid, disetujui.',
            ]);

        $response->assertRedirect();
        $response->assertSessionHasNoErrors();

        // Verifikasi status pengajuan menjadi Disetujui
        $pengajuan->refresh();
        $this->assertEquals('Disetujui', $pengajuan->status);

        // Verifikasi bahwa status yang ditulis ke tabel presensi adalah 'Sakit' sesuai enum baru
        $presensiList = Presensi::where('pegawai_id', $this->pegawai->id)->get();
        $this->assertCount(2, $presensiList);

        foreach ($presensiList as $presensi) {
            $this->assertEquals('Sakit', $presensi->status);
        }
    }

    public function test_persetujuan_cuti_and_dinas_luar_written_accordingly()
    {
        $pengajuanCuti = PengajuanIzin::create([
            'pegawai_id'      => $this->pegawai->id,
            'jenis'           => 'Cuti',
            'tanggal_mulai'   => '2026-09-15',
            'tanggal_selesai' => '2026-09-15',
            'alasan'          => 'Cuti Tahunan',
            'status'          => 'Menunggu Review',
        ]);

        $this->actingAs($this->adminUser)
            ->post(route('admin.pengajuan.status', $pengajuanCuti->id), [
                'status' => 'Disetujui',
            ]);

        $this->assertEquals(1, Presensi::where('pegawai_id', $this->pegawai->id)
            ->whereDate('tanggal', '2026-09-15')
            ->where('status', 'Cuti')
            ->count());
    }
}
