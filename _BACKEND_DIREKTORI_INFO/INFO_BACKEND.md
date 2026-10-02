# ⚙️ PETUNJUK DIREKTORI BACK-END

Folder ini merupakan penanda bahwa seluruh berkas **Back-End (Logika Bisnis, Proses Data, dan Database)** pada sistem aplikasi Disperindag berada di lokasi berikut:

### 1. Pengendali Logika Bisnis & Request (Controllers)
📍 **`app/Http/Controllers/`**
- `app/Http/Controllers/Admin/` : Controller data pegawai (CRUD), absensi, kegiatan, pengajuan, pengaturan
- `app/Http/Controllers/Pegawai/` : Controller presensi GPS geofencing, pelaporan tugas, dan izin
- `app/Http/Controllers/Auth/` : Controller otentikasi login dan logout

### 2. Model Data Eloquent & Relasi Database (Bahasa Indonesia)
📍 **`app/Models/`**
- `Pegawai.php` : Model biodata pegawai PPPK (tabel `pegawai`)
- `User.php` : Model akun pengguna & hak akses (tabel `pengguna`)
- `Presensi.php` : Model presensi harian (tabel `presensi`)
- `LaporanKegiatan.php` : Model laporan aktivitas kerja (tabel `laporan_kegiatan`)
- `PengajuanIzin.php` : Model permohonan cuti / izin (tabel `pengajuan_izin`)
- `SkorKinerja.php` : Model perhitungan IKP (tabel `skor_kinerja`)
- `CatatanAlpha.php` : Model pencatatan ketidakhadiran (tabel `catatan_alpha`)
- `SuratPeringatan.php` : Model surat peringatan SP (tabel `surat_peringatan`)
- `PengaturanKantor.php` : Model konfigurasi instansi & radius (tabel `pengaturan_kantor`)

### 3. Pemetaan Rute URL Sistem
📍 **`routes/web.php`**

### 4. Skema Database & Seeder Data Awal
📍 **`database/migrations/`** & **`database/seeders/`**

> **Catatan:** Untuk mengubah logika penyimpanan, validasi form, rumus perhitungan, atau query ke database MySQL, silakan buka folder **`app/Http/Controllers/`** dan **`app/Models/`**.
