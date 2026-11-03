<?php

namespace Tests\Feature;

use App\Models\LaporanKegiatan;
use App\Models\Pegawai;
use App\Models\PengaturanKantor;
use App\Models\Presensi;
use App\Models\SkorKinerja;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SkorKinerjaIkpTest extends TestCase
{
    use RefreshDatabase;

    protected $pegawai;

    protected function setUp(): void
    {
        parent::setUp();

        PengaturanKantor::create([
            'nama_skpd'           => 'Dinas Perdagangan dan Perindustrian Kota Gorontalo',
            'nama_instansi'       => 'Pemerintah Kota Gorontalo',
            'bobot_kehadiran'     => 60.00,
            'bobot_produktivitas' => 25.00,
            'bobot_kualitas'      => 15.00,
        ]);

        $this->pegawai = Pegawai::create([
            'nip'     => '199003032026011003',
            'nama'    => 'Ahmad Kinerja',
            'jabatan' => 'Analis Perdagangan',
            'bidang'  => 'Perdagangan',
            'status'  => 'Aktif',
        ]);
    }

    public function test_ikp_calculation_formula_with_weights()
    {
        $periode = '2026-09';

        // 1. Kehadiran: Buat presensi hadir tanpa alpha & tanpa terlambat -> nilai_kehadiran = 100
        Presensi::create([
            'pegawai_id' => $this->pegawai->id,
            'tanggal'    => '2026-09-01',
            'jam_masuk'  => '07:30:00',
            'status'     => 'Hadir',
        ]);

        // 2. Produktivitas: Buat laporan dengan nilai 80.00, kualitas 90.00, status Disetujui
        LaporanKegiatan::create([
            'pegawai_id'          => $this->pegawai->id,
            'tanggal'             => '2026-09-01',
            'nama_kegiatan'       => 'Penyuluhan Pedagang Pasar',
            'deskripsi'           => 'Memberikan sosialisasi tera timbangan kepada pedagang pasar.',
            'nilai_produktivitas' => 80.00,
            'nilai_kualitas'      => 90.00,
            'status_verifikasi'   => 'Disetujui',
        ]);

        $score = SkorKinerja::calculateLiveScore($this->pegawai->id, $periode);

        // Rumus PRD: (100 * 0.60) + (80 * 0.25) + (90 * 0.15)
        // = 60 + 20 + 13.5 = 93.5
        $this->assertEquals(100.00, $score->nilai_kehadiran);
        $this->assertEquals(80.00, $score->nilai_produktivitas);
        $this->assertEquals(90.00, $score->nilai_kualitas);
        $this->assertEquals(93.50, $score->nilai_akhir);
        $this->assertEquals('Sangat Baik', $score->kategori);
        $this->assertEquals('Final', $score->status);
        $this->assertEquals('Diperpanjang', $score->rekomendasi_kontrak);
    }

    public function test_ikp_status_is_belum_lengkap_when_reports_are_unrated()
    {
        $periode = '2026-09';

        Presensi::create([
            'pegawai_id' => $this->pegawai->id,
            'tanggal'    => '2026-09-01',
            'jam_masuk'  => '07:30:00',
            'status'     => 'Hadir',
        ]);

        // Laporan kegiatan berstatus 'Menunggu Review' belum dinilai kualitasnya
        LaporanKegiatan::create([
            'pegawai_id'          => $this->pegawai->id,
            'tanggal'             => '2026-09-01',
            'nama_kegiatan'       => 'Penyuluhan Pedagang',
            'deskripsi'           => 'Sosialisasi pasar.',
            'nilai_produktivitas' => 80.00,
            'nilai_kualitas'      => 0,
            'status_verifikasi'   => 'Menunggu Review',
        ]);

        $score = SkorKinerja::calculateLiveScore($this->pegawai->id, $periode);

        // Berdasarkan PRD §28: Jika kualitas belum dinilai, status IKP = 'Belum Lengkap'
        $this->assertEquals('Belum Lengkap', $score->status);
    }

    public function test_simpan_atau_perbarui_persists_to_database()
    {
        $periode = '2026-09';

        Presensi::create([
            'pegawai_id' => $this->pegawai->id,
            'tanggal'    => '2026-09-01',
            'jam_masuk'  => '07:30:00',
            'status'     => 'Hadir',
        ]);

        LaporanKegiatan::create([
            'pegawai_id'          => $this->pegawai->id,
            'tanggal'             => '2026-09-01',
            'nama_kegiatan'       => 'Penyuluhan Pedagang',
            'deskripsi'           => 'Sosialisasi tera timbangan pasar.',
            'nilai_produktivitas' => 80.00,
            'nilai_kualitas'      => 80.00,
            'status_verifikasi'   => 'Disetujui',
        ]);

        $saved = SkorKinerja::simpanAtauPerbarui($this->pegawai->id, $periode);

        $this->assertDatabaseHas('skor_kinerja', [
            'id'         => $saved->id,
            'pegawai_id' => $this->pegawai->id,
            'periode'    => $periode,
            'kategori'   => 'Sangat Baik',
        ]);
    }
}
