<?php

use App\Http\Controllers\Admin\AdminAbsensiController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminKegiatanController;
use App\Http\Controllers\Admin\AdminKinerjaController;
use App\Http\Controllers\Admin\AdminLaporanController;
use App\Http\Controllers\Admin\AdminPegawaiController;
use App\Http\Controllers\Admin\AdminPengajuanController;
use App\Http\Controllers\Admin\AdminPengaturanController;
use App\Http\Controllers\Admin\AdminSpController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Pegawai\PegawaiAbsensiController;
use App\Http\Controllers\Pegawai\PegawaiDashboardController;
use App\Http\Controllers\Pegawai\PegawaiKegiatanController;
use App\Http\Controllers\Pegawai\PegawaiKinerjaController;
use App\Http\Controllers\Pegawai\PegawaiPengajuanController;
use App\Http\Controllers\Pegawai\PegawaiProfilController;
use App\Http\Controllers\Pegawai\PegawaiSpController;
use Illuminate\Support\Facades\Route;

// 1. Root Redirection
Route::get('/', function () {
    return redirect()->route('login');
});

// 2. Autentikasi
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('logout');

// 3. Panel Administrator (Wajib Auth & Peran: admin)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // 2. Data Pegawai (CRUD & Manajemen Pegawai)
    Route::get('/data-pegawai', [AdminPegawaiController::class, 'index'])->name('data-pegawai');
    Route::get('/pegawai', [AdminPegawaiController::class, 'index'])->name('pegawai');
    Route::post('/pegawai', [AdminPegawaiController::class, 'store'])->name('pegawai.store');
    Route::post('/data-pegawai', [AdminPegawaiController::class, 'store'])->name('data-pegawai.store');
    Route::post('/pegawai/{id}/reset-password', [AdminPegawaiController::class, 'resetPassword'])->name('pegawai.reset-password');
    Route::post('/data-pegawai/{id}/reset-password', [AdminPegawaiController::class, 'resetPassword'])->name('data-pegawai.reset-password');
    Route::put('/pegawai/{id}', [AdminPegawaiController::class, 'update'])->name('pegawai.update');
    Route::put('/data-pegawai/{id}', [AdminPegawaiController::class, 'update'])->name('data-pegawai.update');
    Route::delete('/pegawai/{id}', [AdminPegawaiController::class, 'destroy'])->name('pegawai.destroy');
    Route::delete('/data-pegawai/{id}', [AdminPegawaiController::class, 'destroy'])->name('data-pegawai.destroy');
    
    // 3. Monitoring Absensi
    Route::get('/monitoring-absensi', [AdminAbsensiController::class, 'index'])->name('monitoring-absensi');
    Route::get('/absensi', [AdminAbsensiController::class, 'index'])->name('absensi');
    
    // 4. Laporan Kegiatan & Verifikasi
    Route::get('/laporan-kegiatan', [AdminKegiatanController::class, 'index'])->name('laporan-kegiatan');
    Route::get('/kegiatan', [AdminKegiatanController::class, 'index'])->name('kegiatan');
    Route::post('/kegiatan/{id}/verifikasi', [AdminKegiatanController::class, 'verifikasi'])->name('kegiatan.verifikasi');
    Route::post('/laporan-kegiatan/{id}/verifikasi', [AdminKegiatanController::class, 'verifikasi'])->name('laporan-kegiatan.verifikasi');
    
    // 5. Persetujuan Izin & Cuti
    Route::get('/persetujuan-izin-cuti', [AdminPengajuanController::class, 'index'])->name('persetujuan-izin-cuti');
    Route::get('/pengajuan', [AdminPengajuanController::class, 'index'])->name('pengajuan');
    Route::post('/pengajuan/{id}/status', [AdminPengajuanController::class, 'updateStatus'])->name('pengajuan.status');
    Route::post('/persetujuan-izin-cuti/{id}/status', [AdminPengajuanController::class, 'updateStatus'])->name('persetujuan-izin-cuti.status');
    
    // 6. Indeks Kinerja & 7. Surat Peringatan (SP)
    Route::get('/indeks-kinerja', [AdminKinerjaController::class, 'index'])->name('indeks-kinerja');
    Route::get('/kinerja', [AdminKinerjaController::class, 'index'])->name('kinerja');
    Route::get('/surat-peringatan', [AdminSpController::class, 'index'])->name('surat-peringatan');
    Route::post('/surat-peringatan/{id}/terbitkan', [AdminSpController::class, 'terbitkan'])->name('surat-peringatan.terbitkan');
    Route::get('/surat-peringatan/{id}/pdf', [AdminSpController::class, 'exportPdf'])->name('surat-peringatan.pdf');
    Route::get('/sp', [AdminSpController::class, 'index'])->name('sp');
    
    // 8. Pusat Laporan & 9. Pengaturan Sistem
    Route::get('/pusat-laporan', [AdminLaporanController::class, 'index'])->name('pusat-laporan');
    Route::get('/laporan', [AdminLaporanController::class, 'index'])->name('laporan');
    Route::get('/pusat-laporan/export/{format}', [AdminLaporanController::class, 'export'])->name('pusat-laporan.export');
    Route::get('/laporan/export/{format}', [AdminLaporanController::class, 'export'])->name('laporan.export');
    Route::get('/pengaturan-sistem', [AdminPengaturanController::class, 'index'])->name('pengaturan-sistem');
    Route::get('/pengaturan', [AdminPengaturanController::class, 'index'])->name('pengaturan');
    Route::post('/pengaturan', [AdminPengaturanController::class, 'update'])->name('pengaturan.update');
    Route::post('/pengaturan-sistem', [AdminPengaturanController::class, 'update'])->name('pengaturan-sistem.update');
    Route::post('/pengaturan/admin', [AdminPengaturanController::class, 'storeAdmin'])->name('pengaturan.admin.store');
    Route::post('/pengaturan-sistem/admin', [AdminPengaturanController::class, 'storeAdmin'])->name('pengaturan-sistem.admin.store');
    Route::put('/pengaturan/admin/{id}', [AdminPengaturanController::class, 'updateAdmin'])->name('pengaturan.admin.update');
    Route::put('/pengaturan-sistem/admin/{id}', [AdminPengaturanController::class, 'updateAdmin'])->name('pengaturan-sistem.admin.update');
    Route::delete('/pengaturan-sistem/admin/{id}', [AdminPengaturanController::class, 'destroyAdmin'])->name('pengaturan-sistem.admin.destroy');
});

// 4. Panel Pegawai PPPK (Wajib Auth & Peran: pegawai)
Route::middleware(['auth', 'role:pegawai'])->prefix('pegawai')->name('pegawai.')->group(function () {
    Route::get('/dashboard', [PegawaiDashboardController::class, 'index'])->name('dashboard');
    
    // 2. Riwayat Absensi
    Route::get('/riwayat-absensi', [PegawaiAbsensiController::class, 'index'])->name('riwayat-absensi');
    Route::get('/riwayat-absensi/export/pdf', [PegawaiAbsensiController::class, 'exportPdf'])->name('riwayat-absensi.export');
    Route::get('/absensi', [PegawaiAbsensiController::class, 'index'])->name('absensi');
    Route::post('/absensi/record', [PegawaiAbsensiController::class, 'record'])->name('absensi.record');
    Route::post('/riwayat-absensi/record', [PegawaiAbsensiController::class, 'record'])->name('riwayat-absensi.record');
    
    // 3. Kegiatan
    Route::get('/kegiatan', [PegawaiKegiatanController::class, 'index'])->name('kegiatan');
    Route::get('/kegiatan/export/pdf', [PegawaiKegiatanController::class, 'exportPdf'])->name('kegiatan.export');
    Route::post('/kegiatan', [PegawaiKegiatanController::class, 'store'])->name('kegiatan.store');
    
    // 4. Pengajuan
    Route::get('/pengajuan', [PegawaiPengajuanController::class, 'index'])->name('pengajuan');
    Route::post('/pengajuan', [PegawaiPengajuanController::class, 'store'])->name('pengajuan.store');
    
    // 5. Kinerja
    Route::get('/kinerja', [PegawaiKinerjaController::class, 'index'])->name('kinerja');
    
    // 6. Pelanggaran / SP
    Route::get('/pelanggaran-sp', [PegawaiSpController::class, 'index'])->name('pelanggaran-sp');
    Route::get('/sp', [PegawaiSpController::class, 'index'])->name('sp');
    
    // 7. Profil
    Route::get('/profil', [PegawaiProfilController::class, 'index'])->name('profil');
    Route::post('/profil', [PegawaiProfilController::class, 'update'])->name('profil.update');
});
