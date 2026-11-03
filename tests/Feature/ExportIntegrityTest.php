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
use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Tests\TestCase;

class ExportIntegrityTest extends TestCase
{
    use RefreshDatabase;

    protected $adminUser;
    protected $pegawaiUser;
    protected $pegawai;
    protected $otherPegawai;
    protected $otherPegawaiUser;

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
            'nama'    => 'Rahmat Export',
            'jabatan' => 'Analis Data',
            'bidang'  => 'Perdagangan',
            'status'  => 'Aktif',
        ]);

        $this->pegawaiUser = User::create([
            'nama'       => 'Rahmat Export',
            'username'   => 'rahmat.export',
            'email'      => 'rahmat@disperindag.local',
            'password'   => bcrypt('password'),
            'peran'      => 'pegawai',
            'status'     => 'aktif',
            'pegawai_id' => $this->pegawai->id,
        ]);

        $this->otherPegawai = Pegawai::create([
            'nip'     => '199201012026011009',
            'nama'    => 'Siti Lain',
            'jabatan' => 'Staf Perindustrian',
            'bidang'  => 'Perindustrian',
            'status'  => 'Aktif',
        ]);

        $this->otherPegawaiUser = User::create([
            'nama'       => 'Siti Lain',
            'username'   => 'siti.lain',
            'email'      => 'siti@disperindag.local',
            'password'   => bcrypt('password'),
            'peran'      => 'pegawai',
            'status'     => 'aktif',
            'pegawai_id' => $this->otherPegawai->id,
        ]);

        $this->adminUser = User::create([
            'nama'     => 'Admin Export Test',
            'username' => 'admin.export',
            'email'    => 'admin.export@disperindag.local',
            'password' => bcrypt('password'),
            'peran'    => 'admin',
            'status'   => 'aktif',
        ]);
    }

    protected function getSpreadsheetFromResponse($response)
    {
        if ($response->baseResponse instanceof BinaryFileResponse) {
            $filePath = $response->baseResponse->getFile()->getPathname();
            return IOFactory::load($filePath);
        }

        $tempPath = tempnam(sys_get_temp_dir(), 'test_exp_') . '.xlsx';
        file_put_contents($tempPath, $response->getContent());
        $spreadsheet = IOFactory::load($tempPath);
        @unlink($tempPath);
        return $spreadsheet;
    }

    protected function getDecompressedPdfContent($content)
    {
        $text = $content;
        if (preg_match_all('/stream[\r\n]+(.*?)[\r\n]+endstream/s', $content, $matches)) {
            foreach ($matches[1] as $stream) {
                $decompressed = @gzuncompress($stream);
                if ($decompressed) {
                    $text .= ' ' . $decompressed;
                }
            }
        }
        return $text;
    }

    public function test_admin_export_absensi_excel_can_be_parsed_and_has_valid_columns()
    {
        Presensi::create([
            'pegawai_id'    => $this->pegawai->id,
            'tanggal'       => Carbon::today()->toDateString(),
            'jam_masuk'     => '07:25:00',
            'status_masuk'  => 'Tepat Waktu',
            'jam_pulang'    => '16:05:00',
            'status_pulang' => 'Tepat Waktu',
            'status'        => 'Hadir',
        ]);

        $response = $this->actingAs($this->adminUser)
            ->get(route('admin.pusat-laporan.export', ['format' => 'excel', 'tab' => 'absensi']));

        $response->assertStatus(200);
        $spreadsheet = $this->getSpreadsheetFromResponse($response);
        $sheet = $spreadsheet->getActiveSheet();
        
        // Check headers in row 5
        $headers = [];
        foreach (range('A', 'D') as $col) {
            $val = $sheet->getCell($col . '5')->getValue();
            if ($val !== null && $val !== '') {
                $headers[] = (string) $val;
            }
        }
        $this->assertContains('NO', $headers);
        $this->assertContains('NAMA PEGAWAI', $headers);
        $this->assertContains('NIP', $headers);

        // Check row 7 contains employee data
        $namaCell = (string) $sheet->getCell('B7')->getValue();
        $nipCell = (string) $sheet->getCell('C7')->getValue();
        $this->assertEquals('Rahmat Export', $namaCell);
        $this->assertEquals('199005052026011005', $nipCell);
    }

    public function test_admin_export_absensi_pdf_is_valid_binary_pdf()
    {
        Presensi::create([
            'pegawai_id'    => $this->pegawai->id,
            'tanggal'       => Carbon::today()->toDateString(),
            'jam_masuk'     => '07:25:00',
            'status'        => 'Hadir',
        ]);

        $response = $this->actingAs($this->adminUser)
            ->get(route('admin.pusat-laporan.export', ['format' => 'pdf', 'tab' => 'absensi']));

        $response->assertStatus(200);
        $content = $response->getContent();

        $this->assertStringStartsWith('%PDF-', $content);
        $this->assertStringContainsString('%%EOF', $content);
        
        $fullText = $this->getDecompressedPdfContent($content);
        $this->assertStringContainsString('LAPORAN REKAPITULASI ABSENSI', $fullText);
        $this->assertStringContainsString('Rahmat Export', $fullText);
    }

    public function test_admin_export_kinerja_excel_can_be_parsed_and_has_valid_columns()
    {
        Presensi::create([
            'pegawai_id' => $this->pegawai->id,
            'tanggal'    => Carbon::today()->toDateString(),
            'jam_masuk'  => '07:30:00',
            'status'     => 'Hadir',
        ]);

        $response = $this->actingAs($this->adminUser)
            ->get(route('admin.pusat-laporan.export', ['format' => 'excel', 'tab' => 'kinerja']));

        $response->assertStatus(200);
        $spreadsheet = $this->getSpreadsheetFromResponse($response);
        $sheet = $spreadsheet->getActiveSheet();
        
        $headers = [];
        foreach (range('A', 'D') as $col) {
            $val = $sheet->getCell($col . '1')->getValue();
            if ($val !== null && $val !== '') {
                $headers[] = (string) $val;
            }
        }
        $this->assertContains('Nama Pegawai', $headers);
        $this->assertContains('Indeks Kinerja (IKP)', $headers);
        $this->assertContains('Predikat', $headers);

        // Row 2
        $namaCell = (string) $sheet->getCell('A2')->getValue();
        $this->assertEquals('Rahmat Export', $namaCell);
    }

    public function test_admin_export_kinerja_pdf_is_valid_binary_pdf()
    {
        Presensi::create([
            'pegawai_id' => $this->pegawai->id,
            'tanggal'    => Carbon::today()->toDateString(),
            'jam_masuk'  => '07:30:00',
            'status'     => 'Hadir',
        ]);

        $response = $this->actingAs($this->adminUser)
            ->get(route('admin.pusat-laporan.export', ['format' => 'pdf', 'tab' => 'kinerja']));

        $response->assertStatus(200);
        $content = $response->getContent();

        $this->assertStringStartsWith('%PDF-', $content);
        $this->assertStringContainsString('%%EOF', $content);
        
        $fullText = $this->getDecompressedPdfContent($content);
        $this->assertStringContainsString('LAPORAN REKAPITULASI KINERJA PEGAWAI', $fullText);
        $this->assertStringContainsString('Rahmat Export', $fullText);
    }

    public function test_admin_export_kegiatan_excel_can_be_parsed_and_has_valid_columns()
    {
        LaporanKegiatan::create([
            'pegawai_id'          => $this->pegawai->id,
            'tanggal'             => Carbon::today()->toDateString(),
            'nama_kegiatan'       => 'Pemeriksaan Harga Bahan Pokok',
            'deskripsi'           => 'Survei komparasi harga komoditas pasar sentral.',
            'nilai_produktivitas' => 92.50,
            'nilai_kualitas'      => 88.00,
            'status_verifikasi'   => 'Disetujui',
        ]);

        $response = $this->actingAs($this->adminUser)
            ->get(route('admin.pusat-laporan.export', ['format' => 'excel', 'tab' => 'kegiatan']));

        $response->assertStatus(200);
        $spreadsheet = $this->getSpreadsheetFromResponse($response);
        $sheet = $spreadsheet->getActiveSheet();
        
        $headers = [];
        foreach (range('A', 'D') as $col) {
            $val = $sheet->getCell($col . '1')->getValue();
            if ($val !== null && $val !== '') {
                $headers[] = (string) $val;
            }
        }
        $this->assertContains('Nama Pegawai', $headers);
        $this->assertContains('Uraian Tugas', $headers);
        $this->assertContains('Status', $headers);

        $kegiatanCell = (string) $sheet->getCell('C2')->getValue();
        $this->assertEquals('Pemeriksaan Harga Bahan Pokok', $kegiatanCell);
    }

    public function test_admin_export_kegiatan_pdf_is_valid_binary_pdf()
    {
        LaporanKegiatan::create([
            'pegawai_id'          => $this->pegawai->id,
            'tanggal'             => Carbon::today()->toDateString(),
            'nama_kegiatan'       => 'Pemeriksaan Harga Bahan Pokok',
            'deskripsi'           => 'Survei pasar tradisional.',
            'nilai_produktivitas' => 88.00,
            'status_verifikasi'   => 'Disetujui',
        ]);

        $response = $this->actingAs($this->adminUser)
            ->get(route('admin.pusat-laporan.export', ['format' => 'pdf', 'tab' => 'kegiatan']));

        $response->assertStatus(200);
        $content = $response->getContent();

        $this->assertStringStartsWith('%PDF-', $content);
        $this->assertStringContainsString('%%EOF', $content);
        
        $fullText = $this->getDecompressedPdfContent($content);
        $this->assertStringContainsString('LAPORAN REKAPITULASI KEGIATAN PEGAWAI', $fullText);
        $this->assertStringContainsString('Pemeriksaan Harga Bahan Pokok', $fullText);
    }

    public function test_admin_export_sp_excel_can_be_parsed_and_has_valid_columns()
    {
        SuratPeringatan::create([
            'pegawai_id'     => $this->pegawai->id,
            'tingkat_sp'     => 'SP-1',
            'jumlah_alpha'   => 3,
            'nomor_surat'    => '800/088/DISPERINDAG/2026',
            'tanggal_terbit' => Carbon::today()->toDateString(),
            'status'         => 'Aktif',
        ]);

        $response = $this->actingAs($this->adminUser)
            ->get(route('admin.pusat-laporan.export', ['format' => 'excel', 'tab' => 'sp']));

        $response->assertStatus(200);
        $spreadsheet = $this->getSpreadsheetFromResponse($response);
        $sheet = $spreadsheet->getActiveSheet();
        
        $headers = [];
        foreach (range('A', 'I') as $col) {
            $val = $sheet->getCell($col . '1')->getValue();
            if ($val !== null && $val !== '') {
                $headers[] = (string) $val;
            }
        }
        $this->assertContains('Tingkat SP', $headers);
        $this->assertContains('Nomor Surat', $headers);

        $nomorSuratCell = (string) $sheet->getCell('E2')->getValue();
        $this->assertEquals('800/088/DISPERINDAG/2026', $nomorSuratCell);
    }

    public function test_admin_export_sp_pdf_is_valid_binary_pdf()
    {
        SuratPeringatan::create([
            'pegawai_id'     => $this->pegawai->id,
            'tingkat_sp'     => 'SP-1',
            'jumlah_alpha'   => 3,
            'nomor_surat'    => '800/088/DISPERINDAG/2026',
            'tanggal_terbit' => Carbon::today()->toDateString(),
            'status'         => 'Aktif',
        ]);

        $response = $this->actingAs($this->adminUser)
            ->get(route('admin.pusat-laporan.export', ['format' => 'pdf', 'tab' => 'sp']));

        $response->assertStatus(200);
        $content = $response->getContent();

        $this->assertStringStartsWith('%PDF-', $content);
        $this->assertStringContainsString('%%EOF', $content);
        
        $fullText = $this->getDecompressedPdfContent($content);
        $this->assertStringContainsString('LAPORAN REKAPITULASI SURAT PERINGATAN', $fullText);
        $this->assertStringContainsString('800/088/DISPERINDAG/2026', $fullText);
    }

    public function test_admin_single_sp_pdf_is_valid_binary_pdf()
    {
        $sp = SuratPeringatan::create([
            'pegawai_id'     => $this->pegawai->id,
            'tingkat_sp'     => 'SP-2',
            'jumlah_alpha'   => 6,
            'nomor_surat'    => '800/099/DISPERINDAG/2026',
            'tanggal_terbit' => Carbon::today()->toDateString(),
            'status'         => 'Aktif',
        ]);

        $response = $this->actingAs($this->adminUser)
            ->get(route('admin.surat-peringatan.pdf', $sp->id));

        $response->assertStatus(200);
        $content = $response->getContent();

        $this->assertStringStartsWith('%PDF-', $content);
        $this->assertStringContainsString('%%EOF', $content);
        
        $fullText = $this->getDecompressedPdfContent($content);
        $this->assertStringContainsString('SURAT PERINGATAN', $fullText);
        $this->assertStringContainsString('800/099/DISPERINDAG/2026', $fullText);
        $this->assertStringContainsString('Rahmat Export', $fullText);
    }

    public function test_pegawai_export_absensi_pdf_is_valid_binary_pdf()
    {
        Presensi::create([
            'pegawai_id' => $this->pegawai->id,
            'tanggal'    => Carbon::today()->toDateString(),
            'jam_masuk'  => '07:30:00',
            'status'     => 'Hadir',
        ]);

        $response = $this->actingAs($this->pegawaiUser)
            ->get(route('pegawai.riwayat-absensi.export', [
                'format' => 'pdf',
                'month'  => Carbon::today()->format('Y-m'),
            ]));

        $response->assertStatus(200);
        $content = $response->getContent();

        $this->assertStringStartsWith('%PDF-', $content);
        $this->assertStringContainsString('%%EOF', $content);
        
        $fullText = $this->getDecompressedPdfContent($content);
        $this->assertStringContainsString('LAPORAN RIWAYAT ABSENSI PEGAWAI', $fullText);
        $this->assertStringContainsString('Rahmat Export', $fullText);
    }

    public function test_pegawai_export_kegiatan_pdf_is_valid_binary_pdf()
    {
        LaporanKegiatan::create([
            'pegawai_id'          => $this->pegawai->id,
            'tanggal'             => Carbon::today()->toDateString(),
            'nama_kegiatan'       => 'Penyusunan Rencana Kerja',
            'deskripsi'           => 'Drafting program kerja bulanan.',
            'nilai_produktivitas' => 85.00,
            'status_verifikasi'   => 'Disetujui',
        ]);

        $response = $this->actingAs($this->pegawaiUser)
            ->get(route('pegawai.kegiatan.export', [
                'format' => 'pdf',
                'month'  => Carbon::today()->format('Y-m'),
            ]));

        $response->assertStatus(200);
        $content = $response->getContent();

        $this->assertStringStartsWith('%PDF-', $content);
        $this->assertStringContainsString('%%EOF', $content);
        
        $fullText = $this->getDecompressedPdfContent($content);
        $this->assertStringContainsString('LAPORAN KEGIATAN HARIAN PEGAWAI', $fullText);
        $this->assertStringContainsString('Penyusunan Rencana', $fullText);
    }

    public function test_pegawai_single_sp_pdf_is_valid_binary_pdf_and_protected()
    {
        $publishedSp = SuratPeringatan::create([
            'pegawai_id'     => $this->pegawai->id,
            'tingkat_sp'     => 'SP-1',
            'jumlah_alpha'   => 3,
            'nomor_surat'    => '800/100/DISPERINDAG/2026',
            'tanggal_terbit' => Carbon::today()->toDateString(),
            'status'         => 'Aktif',
        ]);

        $draftSp = SuratPeringatan::create([
            'pegawai_id'     => $this->pegawai->id,
            'tingkat_sp'     => 'SP-2',
            'jumlah_alpha'   => 6,
            'nomor_surat'    => '',
            'tanggal_terbit' => Carbon::today()->toDateString(),
            'status'         => 'Aktif',
        ]);

        // 1. Employee downloads own published SP: SUCCESS
        $response = $this->actingAs($this->pegawaiUser)
            ->get(route('pegawai.pelanggaran-sp.pdf', $publishedSp->id));

        $response->assertStatus(200);
        $content = $response->getContent();
        $this->assertStringStartsWith('%PDF-', $content);
        $this->assertStringContainsString('%%EOF', $content);
        
        $fullText = $this->getDecompressedPdfContent($content);
        $this->assertStringContainsString('800/100/DISPERINDAG/2026', $fullText);

        // 2. Employee cannot download draft SP (redirects to index with warning flash)
        $draftResponse = $this->actingAs($this->pegawaiUser)
            ->get(route('pegawai.pelanggaran-sp.pdf', $draftSp->id));
        $draftResponse->assertRedirect();
        $draftResponse->assertSessionHas('error');
    }

    public function test_other_pegawai_cannot_download_unauthorized_sp_returns_403()
    {
        $publishedSp = SuratPeringatan::create([
            'pegawai_id'     => $this->pegawai->id,
            'tingkat_sp'     => 'SP-1',
            'jumlah_alpha'   => 3,
            'nomor_surat'    => '800/100/DISPERINDAG/2026',
            'tanggal_terbit' => Carbon::today()->toDateString(),
            'status'         => 'Aktif',
        ]);

        $unauthorizedResponse = $this->actingAs($this->otherPegawaiUser)
            ->get(route('pegawai.pelanggaran-sp.pdf', $publishedSp->id));
        $unauthorizedResponse->assertStatus(403);
    }

    public function test_exports_with_empty_data_render_gracefully()
    {
        // No records in database (except settings & admin user)

        // 1. Absensi Excel with empty data
        $excelResponse = $this->actingAs($this->adminUser)
            ->get(route('admin.pusat-laporan.export', ['format' => 'excel', 'tab' => 'absensi']));
        $excelResponse->assertStatus(200);
        $spreadsheet = $this->getSpreadsheetFromResponse($excelResponse);
        $this->assertGreaterThanOrEqual(1, $spreadsheet->getSheetCount());
        $sheet = $spreadsheet->getActiveSheet();
        $this->assertGreaterThanOrEqual(1, $sheet->getHighestRow());

        // 2. Absensi PDF with empty data
        $pdfResponse = $this->actingAs($this->adminUser)
            ->get(route('admin.pusat-laporan.export', ['format' => 'pdf', 'tab' => 'absensi']));
        $pdfResponse->assertStatus(200);
        $pdfContent = $pdfResponse->getContent();
        $this->assertStringStartsWith('%PDF-', $pdfContent);
        $this->assertStringContainsString('%%EOF', $pdfContent);

        // 3. Kegiatan PDF with empty data
        $kegiatanPdf = $this->actingAs($this->adminUser)
            ->get(route('admin.pusat-laporan.export', ['format' => 'pdf', 'tab' => 'kegiatan']));
        $kegiatanPdf->assertStatus(200);
        $kegiatanContent = $kegiatanPdf->getContent();
        $this->assertStringStartsWith('%PDF-', $kegiatanContent);

        // 4. SP PDF with empty data
        $spPdf = $this->actingAs($this->adminUser)
            ->get(route('admin.pusat-laporan.export', ['format' => 'pdf', 'tab' => 'sp']));
        $spPdf->assertStatus(200);
        $spContent = $spPdf->getContent();
        $this->assertStringStartsWith('%PDF-', $spContent);
    }
}
