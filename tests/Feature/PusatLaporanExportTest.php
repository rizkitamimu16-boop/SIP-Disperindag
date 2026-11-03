<?php

namespace Tests\Feature;

use App\Models\LaporanKegiatan;
use App\Models\Pegawai;
use App\Models\PengaturanKantor;
use App\Models\Presensi;
use App\Models\SuratPeringatan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PusatLaporanExportTest extends TestCase
{
    use RefreshDatabase;

    protected $adminUser;
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
        ]);

        $this->pegawai = Pegawai::create([
            'nip'     => '199005052026011005',
            'nama'    => 'Dewi Laporan',
            'jabatan' => 'Pranata Komputer',
            'bidang'  => 'Sekretariat',
            'status'  => 'Aktif',
        ]);

        $this->adminUser = User::create([
            'nama'     => 'Admin Pusat Laporan',
            'username' => 'admin.laporan',
            'email'    => 'admin.laporan@disperindag.local',
            'password' => bcrypt('password'),
            'peran'    => 'admin',
            'status'   => 'aktif',
        ]);
    }

    public function test_export_absensi_excel_and_pdf()
    {
        Presensi::create([
            'pegawai_id' => $this->pegawai->id,
            'tanggal'    => Carbon::today()->toDateString(),
            'jam_masuk'  => '07:30:00',
            'status'     => 'Hadir',
        ]);

        // Excel
        $excelResponse = $this->actingAs($this->adminUser)
            ->get(route('admin.pusat-laporan.export', ['format' => 'excel', 'tab' => 'absensi']));

        $excelResponse->assertStatus(200);
        $this->assertStringContainsString('spreadsheet', $excelResponse->headers->get('content-type'));

        // PDF
        $pdfResponse = $this->actingAs($this->adminUser)
            ->get(route('admin.pusat-laporan.export', ['format' => 'pdf', 'tab' => 'absensi']));

        $pdfResponse->assertStatus(200);
        $this->assertStringContainsString('application/pdf', $pdfResponse->headers->get('content-type'));
    }

    public function test_export_kinerja_excel_and_pdf_with_live_score()
    {
        Presensi::create([
            'pegawai_id' => $this->pegawai->id,
            'tanggal'    => Carbon::today()->toDateString(),
            'jam_masuk'  => '07:30:00',
            'status'     => 'Hadir',
        ]);

        // Excel
        $excelResponse = $this->actingAs($this->adminUser)
            ->get(route('admin.pusat-laporan.export', ['format' => 'excel', 'tab' => 'kinerja']));

        $excelResponse->assertStatus(200);
        $this->assertStringContainsString('spreadsheet', $excelResponse->headers->get('content-type'));

        // PDF
        $pdfResponse = $this->actingAs($this->adminUser)
            ->get(route('admin.pusat-laporan.export', ['format' => 'pdf', 'tab' => 'kinerja']));

        $pdfResponse->assertStatus(200);
        $this->assertStringContainsString('application/pdf', $pdfResponse->headers->get('content-type'));
    }

    public function test_export_kegiatan_excel_and_pdf()
    {
        LaporanKegiatan::create([
            'pegawai_id'          => $this->pegawai->id,
            'tanggal'             => Carbon::today()->toDateString(),
            'nama_kegiatan'       => 'Pemeliharaan Server Database',
            'deskripsi'           => 'Backup rutin dan peremajaan sistem basis data kantor.',
            'nilai_produktivitas' => 90.00,
            'nilai_kualitas'      => 85.00,
            'status_verifikasi'   => 'Disetujui',
        ]);

        // Excel
        $excelResponse = $this->actingAs($this->adminUser)
            ->get(route('admin.pusat-laporan.export', ['format' => 'excel', 'tab' => 'kegiatan']));

        $excelResponse->assertStatus(200);
        $this->assertStringContainsString('spreadsheet', $excelResponse->headers->get('content-type'));

        // PDF
        $pdfResponse = $this->actingAs($this->adminUser)
            ->get(route('admin.pusat-laporan.export', ['format' => 'pdf', 'tab' => 'kegiatan']));

        $pdfResponse->assertStatus(200);
        $this->assertStringContainsString('application/pdf', $pdfResponse->headers->get('content-type'));
    }

    public function test_export_sp_excel_and_pdf()
    {
        SuratPeringatan::create([
            'pegawai_id'     => $this->pegawai->id,
            'tingkat_sp'     => 'SP-1',
            'jumlah_alpha'   => 3,
            'nomor_surat'    => '800/015/DISPERINDAG/2026',
            'tanggal_terbit' => Carbon::today()->toDateString(),
            'status'         => 'Aktif',
        ]);

        // Excel
        $excelResponse = $this->actingAs($this->adminUser)
            ->get(route('admin.pusat-laporan.export', ['format' => 'excel', 'tab' => 'sp']));

        $excelResponse->assertStatus(200);
        $this->assertStringContainsString('spreadsheet', $excelResponse->headers->get('content-type'));

        // PDF
        $pdfResponse = $this->actingAs($this->adminUser)
            ->get(route('admin.pusat-laporan.export', ['format' => 'pdf', 'tab' => 'sp']));

        $pdfResponse->assertStatus(200);
        $this->assertStringContainsString('application/pdf', $pdfResponse->headers->get('content-type'));
    }
}
