<?php

namespace Tests\Feature;

use App\Models\LaporanKegiatan;
use App\Models\Pegawai;
use App\Models\PengajuanIzin;
use App\Models\PengaturanKantor;
use App\Models\Presensi;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class KabidAndSuperAdminScopeTest extends TestCase
{
    use RefreshDatabase;

    protected User $superAdmin;
    protected User $nitaAdmin;
    protected User $kabidPerdagangan;
    protected User $kabidPerindustrian;
    protected User $kabidSekretariat;
    protected User $kabidKonsumen;

    protected Pegawai $pegawaiDagang;
    protected Pegawai $pegawaiIndustri;
    protected Pegawai $pegawaiSekretariat;
    protected Pegawai $pegawaiKonsumen;

    protected LaporanKegiatan $laporanDagang;
    protected LaporanKegiatan $laporanIndustri;
    protected PengajuanIzin $izinDagang;
    protected PengajuanIzin $izinIndustri;

    protected function setUp(): void
    {
        parent::setUp();

        // 1. Inisialisasi Pengaturan Kantor
        PengaturanKantor::create([
            'id' => 1,
            'nama_skpd' => 'Dinas Perdagangan dan Perindustrian Kota Gorontalo',
            'nama_instansi' => 'Pemerintah Kota Gorontalo',
            'jam_masuk' => '07:30:00',
            'jam_pulang' => '16:00:00',
            'bobot_kehadiran' => 60,
            'bobot_produktivitas' => 25,
            'bobot_kualitas' => 15,
        ]);

        // 2. Akun Super Admin (id=1, username=admin)
        $this->superAdmin = User::create([
            'nama' => 'Administrator Utama (Super Admin)',
            'username' => 'admin',
            'email' => 'admin@disperindag.gorontalokota.go.id',
            'password' => Hash::make('admin123'),
            'peran' => 'admin',
            'bidang' => null,
            'status' => 'aktif',
        ]);

        // 3. Akun Admin Kepegawaian (Nita)
        $this->nitaAdmin = User::create([
            'nama' => 'Nita (Admin Kepegawaian)',
            'username' => 'nita',
            'email' => 'nita@disperindag.gorontalokota.go.id',
            'password' => Hash::make('nita123'),
            'peran' => 'admin',
            'bidang' => null,
            'status' => 'aktif',
        ]);

        // 4. Akun 4 Kepala Bidang (Kabid)
        $this->kabidPerdagangan = User::create([
            'nama' => 'Hj. Fatmawati, SE (Kabid Perdagangan)',
            'username' => 'kabid_perdagangan',
            'email' => 'kabid.dagang@disperindag.gorontalokota.go.id',
            'password' => Hash::make('kabid123'),
            'peran' => 'admin',
            'bidang' => 'Perdagangan',
            'status' => 'aktif',
        ]);

        $this->kabidPerindustrian = User::create([
            'nama' => 'Ir. Hendra Yusuf (Kabid Perindustrian)',
            'username' => 'kabid_perindustrian',
            'email' => 'kabid.industri@disperindag.gorontalokota.go.id',
            'password' => Hash::make('kabid123'),
            'peran' => 'admin',
            'bidang' => 'Perindustrian',
            'status' => 'aktif',
        ]);

        $this->kabidSekretariat = User::create([
            'nama' => 'Drs. Ramli Mahmud (Sekretaris Dinas)',
            'username' => 'kabid_sekretariat',
            'email' => 'sekretariat@disperindag.gorontalokota.go.id',
            'password' => Hash::make('kabid123'),
            'peran' => 'admin',
            'bidang' => 'Sekretariat',
            'status' => 'aktif',
        ]);

        $this->kabidKonsumen = User::create([
            'nama' => 'Rahmatia, SH (Kabid Perlindungan Konsumen)',
            'username' => 'kabid_konsumen',
            'email' => 'kabid.konsumen@disperindag.gorontalokota.go.id',
            'password' => Hash::make('kabid123'),
            'peran' => 'admin',
            'bidang' => 'Perlindungan Konsumen',
            'status' => 'aktif',
        ]);

        // 5. Data Pegawai PPPK (1 per bidang)
        $this->pegawaiDagang = Pegawai::create([
            'nip' => '199506202022032001',
            'nama' => 'Rani Ayu Pratiwi',
            'jabatan' => 'Petugas Pemantau Pasar',
            'bidang' => 'Perdagangan',
            'status' => 'Aktif',
            'no_hp' => '081234567801',
        ]);
        User::create([
            'pegawai_id' => $this->pegawaiDagang->id,
            'nama' => $this->pegawaiDagang->nama,
            'username' => 'rani.dagang',
            'email' => 'rani@disperindag.gorontalokota.go.id',
            'password' => Hash::make('rani.123'),
            'peran' => 'pegawai',
            'status' => 'aktif',
        ]);

        $this->pegawaiIndustri = Pegawai::create([
            'nip' => '199408152022031002',
            'nama' => 'Budi Santoso',
            'jabatan' => 'Pengawas Mutu Industri',
            'bidang' => 'Perindustrian',
            'status' => 'Aktif',
            'no_hp' => '081234567802',
        ]);
        User::create([
            'pegawai_id' => $this->pegawaiIndustri->id,
            'nama' => $this->pegawaiIndustri->nama,
            'username' => 'budi.industri',
            'email' => 'budi@disperindag.gorontalokota.go.id',
            'password' => Hash::make('budi.123'),
            'peran' => 'pegawai',
            'status' => 'aktif',
        ]);

        $this->pegawaiSekretariat = Pegawai::create([
            'nip' => '199602102022032003',
            'nama' => 'Siti Aminah',
            'jabatan' => 'Pengadministrasi Kepegawaian',
            'bidang' => 'Sekretariat',
            'status' => 'Aktif',
            'no_hp' => '081234567803',
        ]);
        User::create([
            'pegawai_id' => $this->pegawaiSekretariat->id,
            'nama' => $this->pegawaiSekretariat->nama,
            'username' => 'siti.sekretariat',
            'email' => 'siti@disperindag.gorontalokota.go.id',
            'password' => Hash::make('siti.123'),
            'peran' => 'pegawai',
            'status' => 'aktif',
        ]);

        $this->pegawaiKonsumen = Pegawai::create([
            'nip' => '199311252022031004',
            'nama' => 'Ahmad Fauzi',
            'jabatan' => 'Penyuluh Perlindungan Konsumen',
            'bidang' => 'Perlindungan Konsumen',
            'status' => 'Aktif',
            'no_hp' => '081234567804',
        ]);
        User::create([
            'pegawai_id' => $this->pegawaiKonsumen->id,
            'nama' => $this->pegawaiKonsumen->nama,
            'username' => 'ahmad.konsumen',
            'email' => 'ahmad@disperindag.gorontalokota.go.id',
            'password' => Hash::make('ahmad.123'),
            'peran' => 'pegawai',
            'status' => 'aktif',
        ]);

        $today = Carbon::today()->toDateString();

        // 6. Data Presensi Hari Ini
        Presensi::create([
            'pegawai_id' => $this->pegawaiDagang->id,
            'tanggal' => $today,
            'jam_masuk' => '07:45:00',
            'status_masuk' => 'Tepat Waktu',
            'status' => 'Hadir',
        ]);

        Presensi::create([
            'pegawai_id' => $this->pegawaiIndustri->id,
            'tanggal' => $today,
            'jam_masuk' => '08:15:00',
            'status_masuk' => 'Terlambat',
            'status' => 'Terlambat',
        ]);

        // 7. Laporan Kegiatan
        $this->laporanDagang = LaporanKegiatan::create([
            'pegawai_id' => $this->pegawaiDagang->id,
            'tanggal' => $today,
            'nama_kegiatan' => 'Monitoring Harga Beras di Pasar Sentral',
            'deskripsi' => 'Melakukan pencatatan harga komoditas pangan pokok beras premium dan medium.',
            'waktu_kirim' => '10:00:00',
            'nilai_produktivitas' => 90,
            'status_verifikasi' => 'Menunggu Review',
            'is_tugas_lapangan' => true,
        ]);

        $this->laporanIndustri = LaporanKegiatan::create([
            'pegawai_id' => $this->pegawaiIndustri->id,
            'tanggal' => $today,
            'nama_kegiatan' => 'Inspeksi IKM Olahan Kelapa',
            'deskripsi' => 'Pemeriksaan sanitasi dan kelayakan mesin produksi IKM kelapa.',
            'waktu_kirim' => '11:00:00',
            'nilai_produktivitas' => 85,
            'status_verifikasi' => 'Menunggu Review',
        ]);

        // 8. Pengajuan Izin
        $this->izinDagang = PengajuanIzin::create([
            'pegawai_id' => $this->pegawaiDagang->id,
            'jenis' => 'Izin',
            'tanggal_mulai' => Carbon::tomorrow()->toDateString(),
            'tanggal_selesai' => Carbon::tomorrow()->toDateString(),
            'alasan' => 'Ada keperluan keluarga mendesak',
            'status' => 'Menunggu Review',
        ]);

        $this->izinIndustri = PengajuanIzin::create([
            'pegawai_id' => $this->pegawaiIndustri->id,
            'jenis' => 'Sakit',
            'tanggal_mulai' => Carbon::tomorrow()->toDateString(),
            'tanggal_selesai' => Carbon::tomorrow()->addDay()->toDateString(),
            'alasan' => 'Demam dan flu berat',
            'status' => 'Menunggu Review',
        ]);
    }

    /**
     * 1. Uji helper roles & accessor User Model
     */
    public function test_user_roles_and_department_attributes(): void
    {
        $this->assertTrue($this->superAdmin->isSuperAdmin());
        $this->assertFalse($this->superAdmin->isKabid());
        $this->assertEquals('Super Administrator', $this->superAdmin->department);

        $this->assertFalse($this->nitaAdmin->isSuperAdmin());
        $this->assertFalse($this->nitaAdmin->isKabid());
        $this->assertEquals('Admin Kepegawaian', $this->nitaAdmin->department);

        $this->assertFalse($this->kabidPerdagangan->isSuperAdmin());
        $this->assertTrue($this->kabidPerdagangan->isKabid());
        $this->assertEquals('Kepala Bidang Perdagangan', $this->kabidPerdagangan->department);
    }

    /**
     * 2. Uji Dashboard: Kabid hanya melihat ringkasan bidangnya
     */
    public function test_dashboard_scoping(): void
    {
        // Login sebagai Super Admin: melihat total 4 pegawai
        $responseSuper = $this->actingAs($this->superAdmin)->get(route('admin.dashboard'));
        $responseSuper->assertStatus(200);
        $responseSuper->assertViewHas('totalPegawai', 4);

        $this->flushSession();

        // Login sebagai Nita (Admin Kepegawaian): melihat total 4 pegawai
        $responseNita = $this->actingAs($this->nitaAdmin)->get(route('admin.dashboard'));
        $responseNita->assertStatus(200);
        $responseNita->assertViewHas('totalPegawai', 4);

        $this->flushSession();

        // Login sebagai Kabid Perdagangan: HANYA melihat 1 pegawai bidang Perdagangan
        $responseKabid = $this->actingAs($this->kabidPerdagangan)->get(route('admin.dashboard'));
        $responseKabid->assertStatus(200);
        $responseKabid->assertViewHas('totalPegawai', 1);
        $responseKabid->assertViewHas('isKabid', true);
        $responseKabid->assertViewHas('kabidBidang', 'Perdagangan');
    }

    /**
     * 3. Uji Data Pegawai: Scoping, Tambah, Edit, dan Tombol Hapus dilarang untuk Kabid
     */
    public function test_data_pegawai_scoping_and_protection(): void
    {
        // Kabid Perdagangan hanya melihat staf Perdagangan di data tabel
        $response = $this->actingAs($this->kabidPerdagangan)->get(route('admin.data-pegawai'));
        $response->assertStatus(200);
        $employees = $response->viewData('employees');
        $this->assertCount(1, $employees);
        $this->assertEquals('Rani Ayu Pratiwi', $employees->first()->nama);

        // Kabid TIDAK boleh menghapus pegawai
        $delResponse = $this->actingAs($this->kabidPerdagangan)->delete(route('admin.pegawai.destroy', $this->pegawaiDagang->id));
        $delResponse->assertRedirect();
        $delResponse->assertSessionHas('error');
        $this->assertDatabaseHas('pegawai', ['id' => $this->pegawaiDagang->id]); // Data tetap utuh

        // Kabid TIDAK boleh mengedit data pegawai di luar bidangnya
        $editResponse = $this->actingAs($this->kabidPerdagangan)->put(route('admin.pegawai.update', $this->pegawaiIndustri->id), [
            'nip' => $this->pegawaiIndustri->nip,
            'nama' => 'Budi Santoso Diubah',
            'bidang' => 'Perindustrian',
            'jabatan' => 'Pengawas',
            'status' => 'Aktif',
            'email' => 'budi@disperindag.gorontalokota.go.id',
        ]);
        $editResponse->assertStatus(403);

        $this->flushSession();

        // Sebaliknya, Super Admin berhak menghapus pegawai
        $superDelResponse = $this->actingAs($this->superAdmin)->delete(route('admin.pegawai.destroy', $this->pegawaiIndustri->id));
        $superDelResponse->assertRedirect();
        $superDelResponse->assertSessionHas('success');
        $this->assertDatabaseMissing('pegawai', ['id' => $this->pegawaiIndustri->id]);
    }

    /**
     * 4. Uji Monitoring Absensi: Terisolasi per bidang
     */
    public function test_monitoring_absensi_scoping(): void
    {
        $response = $this->actingAs($this->kabidPerdagangan)->get(route('admin.monitoring-absensi'));
        $response->assertStatus(200);
        $response->assertViewHas('totalPegawai', 1);
        $attendances = $response->viewData('attendances');
        foreach ($attendances as $att) {
            $this->assertEquals('Perdagangan', $att->pegawai->bidang);
        }
    }

    /**
     * 5. Uji Laporan Kegiatan: Scoping dan wewenang verifikasi
     */
    public function test_laporan_kegiatan_scoping_and_verification(): void
    {
        // Kabid Perdagangan hanya melihat kegiatan Rani
        $response = $this->actingAs($this->kabidPerdagangan)->get(route('admin.laporan-kegiatan'));
        $response->assertStatus(200);
        $reports = $response->viewData('activityReports');
        $this->assertCount(1, $reports);
        $this->assertEquals('Monitoring Harga Beras di Pasar Sentral', $reports->first()->nama_kegiatan);

        // Kabid Perdagangan berhak memverifikasi kegiatan stafnya
        $verifRani = $this->actingAs($this->kabidPerdagangan)->post(route('admin.kegiatan.verifikasi', $this->laporanDagang->id), [
            'status_verifikasi' => 'Disetujui',
            'nilai_kualitas' => 95,
            'catatan_kualitas' => 'Sangat akurat',
        ]);
        $verifRani->assertRedirect();
        $this->assertDatabaseHas('laporan_kegiatan', [
            'id' => $this->laporanDagang->id,
            'status_verifikasi' => 'Disetujui',
            'nilai_kualitas' => 95,
        ]);

        // Kabid Perdagangan DILARANG memverifikasi kegiatan pegawai Industri
        $verifBudi = $this->actingAs($this->kabidPerdagangan)->post(route('admin.kegiatan.verifikasi', $this->laporanIndustri->id), [
            'status_verifikasi' => 'Disetujui',
            'nilai_kualitas' => 90,
        ]);
        $verifBudi->assertStatus(403);
    }

    /**
     * 6. Uji Persetujuan Izin: Scoping dan wewenang approve/reject
     */
    public function test_persetujuan_izin_scoping_and_approval(): void
    {
        // Kabid Perdagangan hanya melihat pengajuan izin stafnya
        $response = $this->actingAs($this->kabidPerdagangan)->get(route('admin.persetujuan-izin-cuti'));
        $response->assertStatus(200);
        $requests = $response->viewData('leaveRequests');
        $this->assertCount(1, $requests);
        $this->assertEquals('Ada keperluan keluarga mendesak', $requests->first()->alasan);

        // Kabid Perdagangan berhak menyetujui izin stafnya
        $approveRani = $this->actingAs($this->kabidPerdagangan)->post(route('admin.pengajuan.status', $this->izinDagang->id), [
            'status' => 'Disetujui',
            'catatan_admin' => 'Disetujui oleh Kabid',
        ]);
        $approveRani->assertRedirect();
        $this->assertDatabaseHas('pengajuan_izin', [
            'id' => $this->izinDagang->id,
            'status' => 'Disetujui',
        ]);

        // Kabid Perdagangan DILARANG menyetujui izin staf Industri
        $approveBudi = $this->actingAs($this->kabidPerdagangan)->post(route('admin.pengajuan.status', $this->izinIndustri->id), [
            'status' => 'Disetujui',
        ]);
        $approveBudi->assertStatus(403);
    }

    /**
     * 7. Uji Indeks Kinerja: Scoping ranking per bidang
     */
    public function test_indeks_kinerja_scoping(): void
    {
        // Super Admin melihat skor semua bidang (4 pegawai)
        $superRes = $this->actingAs($this->superAdmin)->get(route('admin.indeks-kinerja'));
        $superRes->assertStatus(200);
        $this->assertCount(4, $superRes->viewData('scores'));

        $this->flushSession();

        // Kabid Perdagangan HANYA melihat skor staf Perdagangan (1 pegawai)
        $kabidDagangRes = $this->actingAs($this->kabidPerdagangan)->get(route('admin.indeks-kinerja'));
        $kabidDagangRes->assertStatus(200);
        $scores = $kabidDagangRes->viewData('scores');
        $this->assertCount(1, $scores);
        $this->assertEquals('Perdagangan', $scores->first()->pegawai->bidang);

        $this->flushSession();

        // Kabid Perindustrian HANYA melihat staf Perindustrian (1 pegawai)
        $kabidIndustriRes = $this->actingAs($this->kabidPerindustrian)->get(route('admin.indeks-kinerja'));
        $kabidIndustriRes->assertStatus(200);
        $scoresIndustri = $kabidIndustriRes->viewData('scores');
        $this->assertCount(1, $scoresIndustri);
        $this->assertEquals('Perindustrian', $scoresIndustri->first()->pegawai->bidang);
    }

    /**
     * 8. Uji Menu Terlarang untuk Kabid: SP, Pusat Laporan, dan Pengaturan Sistem harus 403
     */
    public function test_kabid_forbidden_menus_return_403(): void
    {
        // Akses langsung ke SP
        $resSp = $this->actingAs($this->kabidPerdagangan)->get(route('admin.surat-peringatan'));
        $resSp->assertStatus(403);

        // Akses langsung ke Pusat Laporan
        $resLaporan = $this->actingAs($this->kabidPerdagangan)->get(route('admin.pusat-laporan'));
        $resLaporan->assertStatus(403);

        // Akses langsung ke Pengaturan Sistem
        $resPengaturan = $this->actingAs($this->kabidPerdagangan)->get(route('admin.pengaturan-sistem'));
        $resPengaturan->assertStatus(403);
    }

    /**
     * 8. Uji Menu Profil: Kabid dan Admin dapat mengakses dan mengubah profil sendiri
     */
    public function test_kabid_profile_view_and_update(): void
    {
        // Akses halaman profil
        $response = $this->actingAs($this->kabidPerdagangan)->get(route('admin.profil'));
        $response->assertStatus(200);
        $response->assertSee('Kepala Bidang Perdagangan');

        // Update nomor telepon dan nama
        $updateRes = $this->actingAs($this->kabidPerdagangan)->post(route('admin.profil.update'), [
            'nama' => 'Hj. Fatmawati, SE, MM',
            'email' => 'kabid.dagang@disperindag.gorontalokota.go.id',
            'no_hp' => '081122334455',
        ]);
        $updateRes->assertRedirect();
        $this->assertDatabaseHas('pengguna', [
            'id' => $this->kabidPerdagangan->id,
            'nama' => 'Hj. Fatmawati, SE, MM',
            'no_hp' => '081122334455',
        ]);
    }

    /**
     * 9. Uji Wewenang Admin Global & Super Admin dalam Pengaturan dan Manajemen Akun
     */
    public function test_super_admin_exclusivity_on_admin_management(): void
    {
        // Nita (Admin Kepegawaian / Global) BERHAK menambah admin baru
        $nitaCreate = $this->actingAs($this->nitaAdmin)->post(route('admin.pengaturan.admin.store'), [
            'nama' => 'Kabid Uji Nita',
            'username' => 'kabid_uji_nita',
            'email' => 'kabid.uji@example.com',
            'password' => 'secret123',
            'bidang' => 'Perdagangan',
        ]);
        $nitaCreate->assertSessionHasNoErrors();
        $this->assertDatabaseHas('pengguna', ['username' => 'kabid_uji_nita', 'bidang' => 'Perdagangan']);

        $this->flushSession();

        // Nita (Admin Kepegawaian / Global) BERHAK mengubah pengaturan kantor
        $nitaSettings = $this->actingAs($this->nitaAdmin)->post(route('admin.pengaturan.update'), [
            'nama_skpd' => 'Dinas Perdagangan dan Perindustrian Kota Gorontalo (Updated)',
            'nama_instansi' => 'Pemerintah Kota Gorontalo',
            'jam_masuk' => '07:30:00',
            'jam_pulang' => '16:00:00',
        ]);
        $nitaSettings->assertSessionHasNoErrors();
        $this->assertDatabaseHas('pengaturan_kantor', ['nama_skpd' => 'Dinas Perdagangan dan Perindustrian Kota Gorontalo (Updated)']);

        $this->flushSession();

        // Nita DILARANG menghapus akun admin lain (Khusus hak Super Admin)
        $nitaDel = $this->actingAs($this->nitaAdmin)->delete(route('admin.pengaturan-sistem.admin.destroy', $this->kabidPerdagangan->id));
        $nitaDel->assertSessionHasErrors(['error']);
        $this->assertDatabaseHas('pengguna', ['id' => $this->kabidPerdagangan->id]);

        $this->flushSession();

        // Sebaliknya, Super Admin BERHAK menghapus admin
        $adminToDelete = User::where('username', 'kabid_uji_nita')->first();
        $superDelete = $this->actingAs($this->superAdmin)->delete(route('admin.pengaturan-sistem.admin.destroy', $adminToDelete->id));
        $superDelete->assertSessionHasNoErrors();
        $this->assertDatabaseMissing('pengguna', ['id' => $adminToDelete->id]);

        $this->flushSession();

        // Kabid DILARANG menambah admin atau merubah pengaturan
        $kabidCreate = $this->actingAs($this->kabidPerdagangan)->post(route('admin.pengaturan.admin.store'), [
            'nama' => 'Admin Ditolak',
            'username' => 'admin_ditolak',
            'email' => 'ditolak@example.com',
            'password' => 'secret123',
        ]);
        $kabidCreate->assertSessionHasErrors(['error']);
    }

    /**
     * 10. Uji update pegawai berstatus 'Cuti' tetap aman untuk enum akun pengguna ('aktif')
     */
    public function test_update_pegawai_cuti_status_does_not_crash_user_account(): void
    {
        $response = $this->actingAs($this->superAdmin)->put(route('admin.pegawai.update', $this->pegawaiDagang->id), [
            'nip' => $this->pegawaiDagang->nip,
            'nama' => $this->pegawaiDagang->nama,
            'bidang' => $this->pegawaiDagang->bidang,
            'jabatan' => $this->pegawaiDagang->jabatan,
            'no_hp' => $this->pegawaiDagang->no_hp,
            'alamat' => $this->pegawaiDagang->alamat,
            'status' => 'Cuti',
            'email' => 'rani.cuti@disperindag.gorontalokota.go.id',
        ]);

        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('pegawai', [
            'id' => $this->pegawaiDagang->id,
            'status' => 'Cuti',
        ]);
        $this->assertDatabaseHas('pengguna', [
            'pegawai_id' => $this->pegawaiDagang->id,
            'status' => 'aktif',
        ]);
    }
}
