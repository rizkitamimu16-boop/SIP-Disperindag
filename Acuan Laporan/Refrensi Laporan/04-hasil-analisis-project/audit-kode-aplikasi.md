# Audit Kode Aplikasi – SIP-PERFORMA

Audit dilakukan **read-only** (membaca file saja). Tidak ada migrasi, seeder, test, instalasi dependensi, atau perubahan file aplikasi. `.env` hanya dicek untuk nilai non-sensitif (`DB_CONNECTION`, `APP_ENV`, `APP_LOCALE`); isi lain tidak dicatat. Unit test **tidak dijalankan** karena berpotensi menyentuh database.

## 1. Ringkasan Aplikasi

Aplikasi web berbasis Laravel untuk absensi (GPS + foto), laporan kegiatan harian, pengajuan izin/cuti/sakit/dinas luar, penilaian kinerja (Indeks Kinerja Pegawai/IKP) dan Surat Peringatan (SP) untuk pegawai PPPK Dinas Perindustrian dan Perdagangan Kota Gorontalo. Terdapat dua peran: **admin** dan **pegawai**.

## 2. Teknologi Terverifikasi

| Komponen | Temuan | Bukti |
|---|---|---|
| Bahasa | PHP ^8.3 | `composer.json` |
| Framework | Laravel `^13.17` | `composer.json` |
| Database | MySQL (`DB_CONNECTION=mysql`), InnoDB utf8mb4 | `.env` (hanya key itu), `database/aplikasi_disperindag.sql` |
| PDF | `barryvdh/laravel-dompdf ^3.1` | `composer.json`, dipakai di `AdminLaporanController`, `AdminSpController`, `Pegawai*Controller::exportPdf` |
| Excel | `maatwebsite/excel ^4.0` | `composer.json`, `app/Exports/*` |
| Frontend build | Vite ^8, Tailwind CSS ^4 (build lokal), `laravel-vite-plugin` | `package.json`, `vite.config.js`, `resources/css/app.css` |
| Templating | Blade | `resources/views/**` |
| JS di browser | Chart.js (CDN jsDelivr), SweetAlert2 (CDN), JavaScript biasa (tanpa framework) | `layouts/app.blade.php`, `components/*-scripts.blade.php` |
| Font | Google Fonts Inter | `layouts/app.blade.php` |
| Geolokasi & foto | `navigator.geolocation`; input file `capture="user"` + canvas watermark + kompresi JPEG, dikirim base64 | `components/pegawai-scripts.blade.php`, `components/pegawai-modals.blade.php` |
| Auth | Session guard Laravel, model `User` (tabel `pengguna`), middleware `role` | `AuthController`, `RoleMiddleware`, `bootstrap/app.php` |
| Email | Mailable `AccountCreated`, `AccountUpdated`, `PasswordReset` | `app/Mail/*` (driver mail belum dipastikan) |
| Scheduler | Perintah `absensi:alpha`, Senin–Jumat 12:00 Asia/Makassar | `routes/console.php`, `app/Console/Commands/TandaiAlphaOtomatis.php` |
| API eksternal | `api-harilibur.vercel.app` (cek hari libur) | `TandaiAlphaOtomatis.php` |
| Testing | PHPUnit ^12.5; 6 file Feature test | `tests/Feature/*` |
| Timezone | `Asia/Makassar` (default) | `config/app.php` |

Tidak ditemukan Livewire, Inertia, Vue/React, Alpine, Leaflet, atau layanan peta (hanya dicek pada `resources/views`).

## 3. Struktur dan Arsitektur

Pola MVC Laravel monolit server-rendered:

```
Browser (Blade + JS/Chart.js/SweetAlert2)
   │ HTTP (session, CSRF)
Routes (routes/web.php) → Middleware (auth, role:admin|pegawai)
   → Controller (Admin/*, Pegawai/*, Auth/*)
   → Model Eloquent (app/Models/*) → MySQL
   → Export (app/Exports, DomPDF, Excel) / Mail
Scheduler: absensi:alpha → tabel presensi
```

- Controller admin: `AdminDashboard, AdminPegawai, AdminAbsensi, AdminKegiatan, AdminPengajuan, AdminKinerja, AdminSp, AdminLaporan, AdminPengaturan`.
- Controller pegawai: `PegawaiDashboard, Absensi, Kegiatan, Pengajuan, Kinerja, Sp, Profil`.
- View: `resources/views/{admin,pegawai,auth,layouts,components,emails}`.
- Nama tabel, kolom, dan enum berbahasa Indonesia (migrasi `2026_09_16_000001_create_tabel_sistem_bahasa_indonesia.php`, `0001_01_01_000000_create_users_table.php`).

## 4. Peran dan Hak Akses

| Peran | Hak akses | Bukti |
|---|---|---|
| Tamu | Hanya `/login` | `routes/web.php` |
| admin | Seluruh prefix `/admin/*` (dashboard, data pegawai, monitoring absensi, verifikasi kegiatan, persetujuan izin, indeks kinerja, SP, pusat laporan, pengaturan sistem) | `routes/web.php` grup `role:admin` |
| pegawai | Prefix `/pegawai/*` (dashboard, absensi, kegiatan, pengajuan, kinerja, SP, profil) | `routes/web.php` grup `role:pegawai` |

- `RoleMiddleware` juga menolak akun berstatus selain `aktif` dan mengalihkan pengguna yang salah peran ke dashboard-nya sendiri.
- Login dengan username atau email; opsional memilih tab peran; `Auth::logoutOtherDevices` dipanggil.
- Penghapusan akun admin hanya oleh pengguna dengan `id == 1` (`AdminPengaturanController::destroyAdmin`).
- Pegawai dibatasi data miliknya lewat `Auth::user()->pegawai`.

## 5. Daftar Fitur dan Status

Status berdasarkan penelusuran controller → model → tabel. "Berfungsi" berarti jalur kode lengkap ditemukan, **bukan** hasil uji jalan.

| # | Fitur | Status | Bukti | Catatan |
|---|---|---|---|---|
| 1 | Login/logout multi-peran | Berfungsi | `AuthController` | |
| 2 | Absensi masuk/pulang (GPS + foto + geofence) | Berfungsi | `PegawaiAbsensiController::record`, `pegawai-scripts.blade.php` | Rumus Haversine; radius dari `pengaturan_kantor`; Jumat WFH melewati radius; batas jam masuk/pulang; status Terlambat/Pulang Cepat |
| 3 | Riwayat absensi + filter + ekspor PDF | Berfungsi | `PegawaiAbsensiController::index/exportPdf` | |
| 4 | Laporan kegiatan harian pegawai | Berfungsi | `PegawaiKegiatanController::store` | Hanya setelah absen masuk dan sebelum absen pulang (kecuali dinas luar disetujui); foto opsional |
| 5 | Verifikasi kegiatan & penilaian kualitas oleh admin | Berfungsi | `AdminKegiatanController::verifikasi` | Admin mengisi `nilai_kualitas`; kategori A–D dihitung otomatis |
| 6 | Nilai produktivitas kegiatan | Sebagian | `PegawaiKegiatanController::store` baris `nilai_produktivitas => 85.00` | Nilai produktivitas **di-hardcode 85** saat laporan dibuat; tidak ada formula/input penilai |
| 7 | Pengajuan izin/cuti/sakit/dinas luar | Berfungsi | `PegawaiPengajuanController::store` | Batas 1 pengajuan per hari; lampiran PDF/JPG/PNG ≤5 MB |
| 8 | Persetujuan pengajuan oleh admin | Berfungsi | `AdminPengajuanController::updateStatus` | Disetujui → isi `presensi` per tanggal; Ditolak → jadikan Alpha bila belum ada data |
| 9 | Tandai Alpha otomatis | Berfungsi (perlu scheduler aktif) | `TandaiAlphaOtomatis`, `routes/console.php` | Melewati akhir pekan dan hari libur nasional (API); melewati pegawai yang pengajuannya masih menunggu |
| 10 | Dashboard admin & pegawai | Berfungsi | `AdminDashboardController`, `PegawaiDashboardController` | Hari kerja bulanan di-hardcode 22; sisa cuti di-hardcode 12 hari; `attendanceDelta`/`terlambatMenit` selalu bernilai awal |
| 11 | CRUD data pegawai + akun login | Berfungsi | `AdminPegawaiController` | Password default `pegawai123` bila tidak diisi; reset password ke default; email dikirim dengan try/catch |
| 12 | Monitoring absensi admin | Berfungsi | `AdminAbsensiController` | |
| 13 | Indeks Kinerja (IKP) | Berfungsi (hitung langsung, tidak disimpan) | `SkorKinerja::calculateLiveScore`, `AdminKinerjaController`, `PegawaiKinerjaController` | Kehadiran = 100 − 5×Alpha − 2×Terlambat; bobot dari pengaturan (default 60/25/15); kategori ≥90/80/70 |
| 14 | Rekomendasi kontrak | Berfungsi | `AdminKinerjaController::calculatePegawaiScore` | Diperpanjang ≥80, Dipertimbangkan ≥70, Tidak Diperpanjang <70 |
| 15 | SP otomatis (draf) | **Berpotensi bermasalah** | `AdminKinerjaController::calculatePegawaiScore` | Membuat `tingkat_sp` `'SP1'/'SP2'/'SP3'`, sedangkan enum DB `'SP-1','SP-2','SP-3'`; kolom `nomor_surat` & `tanggal_terbit` NOT NULL tanpa nilai; ambang hard-coded 3/6/9 (bukan dari pengaturan) |
| 16 | Terbitkan SP + cetak PDF | **Berpotensi bermasalah** | `AdminSpController::terbitkan` | Mengisi `status = 'Terbit'` yang tidak ada di enum (`Aktif`,`Selesai`) |
| 17 | Pusat laporan (absensi, kegiatan, kinerja, SP) + ekspor Excel/PDF | Sebagian | `AdminLaporanController`, `app/Exports/*` | Ekspor memakai class Export terpisah (ada). Tab tampilan memiliki rujukan atribut yang tidak ditemukan: `$act->kegiatan` (kolom aslinya `nama_kegiatan`) dan `$skor->predikat` (tidak ada) |
| 18 | Tab laporan kinerja di Pusat Laporan | Sebagian | `AdminLaporanController` | Membaca tabel `skor_kinerja`, padahal skor dihitung langsung dan tidak disimpan (hanya seeder demo yang mengisi) |
| 19 | Pengaturan sistem (lokasi, jam, bobot, ambang SP, WFH Jumat, template SP) | Berfungsi | `AdminPengaturanController::update` | Tanpa validasi input pada `update()` |
| 20 | Manajemen akun admin | Berfungsi | `AdminPengaturanController::storeAdmin/updateAdmin/destroyAdmin` | |
| 21 | Profil pegawai & ganti password | Berfungsi | `PegawaiProfilController` | Email notifikasi perubahan password |
| 22 | Halaman SP pegawai | Berfungsi | `PegawaiSpController` | Menampilkan SP berstatus `Aktif` saja |
| 23 | Notifikasi email akun | Sebagian | `app/Mail/*`, controller | Pengiriman dibungkus try/catch kosong; konfigurasi mail tidak diverifikasi |
| 24 | Unggah/preview lampiran | Berfungsi | `components/modal-preview-lampiran.blade.php`, `storage/public` | `public/storage` link ada |

Tidak ditemukan: peta interaktif, notifikasi real-time/push, rekap tersimpan bulanan (finalisasi IKP), API publik/mobile.

## 6. Alur Proses Utama

1. **Absensi**: Login → dashboard pegawai → ambil foto (kamera) + GPS → `POST /pegawai/absensi/record` → hitung jarak ke kantor → tolak bila di luar radius → simpan `presensi` (jam, status, jarak, foto).
2. **Kegiatan**: Pegawai absen masuk → kirim laporan kegiatan (+foto) → status "Menunggu Review" → admin verifikasi (Disetujui/Ditolak + nilai kualitas) → nilai ikut IKP.
3. **Izin/Cuti**: Pegawai ajukan → admin setujui/tolak → `presensi` per tanggal diisi status jenis pengajuan (atau Alpha bila ditolak).
4. **Alpha otomatis**: Scheduler 12:00 hari kerja → lewati libur nasional → pegawai tanpa presensi dan tanpa pengajuan tertunda dibuat Alpha.
5. **Kinerja & SP**: Admin buka Indeks Kinerja → skor dihitung langsung → bila Alpha ≥3 dalam bulan, draf SP dibuat → admin menerbitkan (nomor surat) → cetak PDF.
6. **Pelaporan**: Admin memilih tab → filter → ekspor Excel/PDF.

## 7. Tabel Database dan Relasi

Sumber: migrasi dan `database/aplikasi_disperindag.sql`. Seluruh tabel domain memakai FK `pegawai_id` → `pegawai.id` (`ON DELETE CASCADE`).

| Tabel | Kolom penting | Relasi |
|---|---|---|
| `pegawai` | nip (unik), nama, no_hp, jabatan, bidang (enum 4 bidang), alamat, foto, status (Aktif/Cuti) | 1–1 `pengguna`; 1–N ke semua tabel di bawah |
| `pengguna` | pegawai_id (nullable), nama, username, email, password, peran (admin/pegawai), status (aktif/nonaktif) | N–1 `pegawai` |
| `presensi` | tanggal, jam_masuk/pulang, status_masuk, status_pulang, jarak_masuk/pulang, foto_masuk/pulang, status (Hadir, Terlambat, Alpha, Izin, Cuti, Dinas Luar) | N–1 `pegawai` |
| `laporan_kegiatan` | tanggal, nama_kegiatan, deskripsi, foto, waktu_kirim, nilai_produktivitas, nilai_kualitas, kategori_*, catatan_kualitas, status_verifikasi | N–1 `pegawai` |
| `pengajuan_izin` | jenis (Izin/Cuti/Sakit/Dinas Luar), tanggal_mulai/selesai, alasan, dokumen, status, catatan_admin, tanggal_disetujui | N–1 `pegawai` |
| `skor_kinerja` | periode, nilai_*, bobot_*, nilai_akhir, kategori, status, rekomendasi_kontrak | N–1 `pegawai` (praktis hanya terisi oleh seeder; lihat catatan fitur 18) |
| `catatan_alpha` | tanggal, alasan, siklus_sp | N–1 `pegawai`. Model ada; **tidak ditemukan penggunaan** pada controller/command yang diperiksa |
| `surat_peringatan` | tingkat_sp (SP-1..3), jumlah_alpha, nomor_surat, tanggal_terbit, dokumen, status (Aktif/Selesai) | N–1 `pegawai` |
| `pengaturan_kantor` | lokasi, radius, jam kerja, bobot, ambang SP, pola nomor SP, template SP, is_wfh_jumat | Satu baris (id=1), tanpa FK |
| `sessions`, `password_reset_tokens`, `cache*`, `jobs*`, `migrations` | bawaan Laravel | – |

## 8. Temuan Kualitas yang Memengaruhi Isi Laporan

1. Ketidaksesuaian enum SP: `SP1` vs `SP-1`, dan status `Terbit` tidak ada di enum → alur SP otomatis/terbit berpotensi gagal pada MySQL mode ketat. Belum diuji.
2. `nilai_produktivitas` tetap 85 saat pengiriman laporan.
3. Konstanta hardcoded: 22 hari kerja, 12 hari cuti.
4. Pusat Laporan: rujukan `kegiatan`/`predikat` dan sumber `skor_kinerja` tidak konsisten.
5. `TandaiAlphaOtomatis` memfilter `status = 'aktif'` (enum `Aktif`); aman di MySQL collation yang tidak membedakan huruf besar-kecil.
6. Seeder (`DatabaseSeeder`, `PegawaiSeeder`) berisi data contoh dan kredensial default; **tidak dicantumkan di sini** dan sebaiknya tidak ditulis di laporan.
7. Nomor SP default menyebut tahun 2026 dan pola `{NO}`/`{nomor}` berbeda antara model dan seeder.
8. Sebagian kolom pada `pengaturan_kantor` (mis. `batas_terlambat`) dipakai langsung dalam logika absensi; `jam_masuk` tidak ditemukan dipakai untuk penentuan status.

## 9. Hal yang Perlu Dikonfirmasi Kepada Anda

1. Apakah alur SP (draf otomatis → terbit → PDF) sudah pernah dicoba berjalan di Laragon? Jika ya, mungkin DB Anda berbeda dengan dump `.sql`.
2. Apakah nilai produktivitas tetap 85 memang disengaja (aturan sementara), atau akan diubah?
3. Apakah scheduler (`schedule:run`) pernah dijalankan di lingkungan nyata/uji?
4. Apakah dokumen `PANDUAN_STRUKTUR_FRONTEND_BACKEND.md` / PRD asli ada? Beberapa komentar kode merujuk "PRD Bab …" yang tidak ada di repositori.
5. Konfigurasi email (driver SMTP) yang dipakai, untuk narasi fitur notifikasi.
6. Hasil pengujian apa yang sudah Anda lakukan (UAT/black-box), sebab saya tidak menjalankan test dan tidak akan menulis hasil uji tanpa bukti.
7. Apakah laporan menyebut kegiatan bidang Perindustrian, Perdagangan, Sekretariat, Perlindungan Konsumen (4 bidang dalam aplikasi) selaras dengan struktur organisasi resmi dinas yang di BAB I juga menyebut Bidang Perlindungan Konsumen dan Kemetrologian?
8. Akun/pengguna nyata: berapa jumlah pegawai PPPK sebenarnya yang memakai sistem (dump SQL memuat 35 baris `pegawai`, tetapi belum dipastikan data nyata atau uji).
9. Nama dinas yang dipakai di aplikasi ("Dinas Perindustrian dan Perdagangan") berbeda dari BAB I ("Dinas Perdagangan dan Perindustrian"); pilih satu.

---

# PEMBARUAN AUDIT (27 Okt 2026) – Kesesuaian PRD & Status Pengujian

Pembaruan ini berdasarkan koreksi dari pengguna dan pembacaan `Agents/Rules/prd.md`. Tetap **read-only**: tidak ada perubahan kode/data, tidak ada migrasi, tidak ada test, tidak ada scheduler yang dijalankan, dan tidak ada proses yang dapat membuat catatan Alpha/SP. Pertanyaan pada bagian 9 yang sudah dijawab ditandai pada bagian 15.

## 10. Legenda Status

| Kode | Arti |
|---|---|
| **A** | Sudah diuji langsung oleh pengguna (berdasarkan pernyataan pengguna; tidak saya verifikasi ulang) |
| **B** | Belum diuji langsung |
| **C** | Ditemukan lewat pemeriksaan kode, belum diuji saat aplikasi berjalan |
| **D** | Belum dapat dipastikan (perlu konfirmasi/bukti) |

## 11. Status Pengujian

### 11.1 Diuji langsung oleh pengguna (A)
Hanya yang disebut pengguna, tanpa menganggap semua kasus sudah teruji:

| Pengujian | Catatan |
|---|---|
| Perilaku jam absensi (sebelum jam kerja, saat jam kerja, setelah batas) | A. Hanya skenario tersebut |
| Mengubah jam lewat Admin dan memeriksa perilaku mengikuti | A. Kode memang membaca jam dari `pengaturan_kantor` (`PegawaiAbsensiController::record`) – selaras dengan klaim, namun nilai default berbeda dari PRD (lihat F-04) |
| Absensi masuk dan pulang | A |
| Perilaku terlambat dan Alpha | A, tetapi **cara Alpha terjadi tidak jelas** (scheduler, penolakan pengajuan, atau data manual). Tidak dianggap sebagai uji scheduler |
| Pengajuan izin dan sakit | A. Belum jelas apakah termasuk **persetujuan Admin** untuk "Sakit" (lihat F-05) |
| Membuat laporan kegiatan | A |
| Memeriksa kesesuaian pengaturan Admin dengan perilaku aplikasi | A |
| Penilaian laporan kegiatan | A |
| Ekspor laporan | A. Format/tab yang diuji tidak diketahui |
| Impor laporan | A menurut pengguna, **tetapi tidak ditemukan kode impor** (lihat F-12) → status D |
| Penambahan data pegawai | A |

### 11.2 Belum diuji langsung / belum terkonfirmasi (B atau D)
- **Alur SP sampai 3 Alpha** → B (dikonfirmasi pengguna). Dump SQL tidak memuat baris `surat_peringatan` maupun `catatan_alpha`, konsisten dengan belum pernah diuji (bukan bukti pasti: dump hanya cuplikan waktu tertentu).
- **Scheduler `absensi:alpha`** (pemicu otomatis pukul 12:00, cek API hari libur) → B. Belum ada bukti scheduler pernah dijalankan; Laravel Scheduler memerlukan `php artisan schedule:run` per menit (Task Scheduler/cron) dan tidak aktif otomatis di Laragon.
- **Email** (akun baru, ubah profil, reset password) → B/D (lihat bagian 13).
- Batas 3 kali login salah (PRD §8) → B; kode tidak ditemukan (F-06).
- Edit, hapus, reset password pegawai; kelola akun admin; ubah profil/password pegawai → belum terkonfirmasi.
- Perhitungan IKP, tampilan Indeks Kinerja admin & pegawai, dashboard, grafik → belum terkonfirmasi.
- Ekspor/PDF per tab Pusat Laporan (absensi, kinerja, kegiatan, SP) dan cetak PDF SP → belum terkonfirmasi.
- QR Code → belum terkonfirmasi (tidak ditemukan generator QR di kode).
- Akses perangkat ponsel nyata (kamera & GPS di browser seluler) → belum terkonfirmasi.
- Hasil Unit/Feature test di `tests/Feature` → belum dijalankan; tidak ada bukti lolos/gagal.

## 12. Temuan Berdasarkan Prioritas

Setiap temuan memiliki: status (A–D), bukti, dan kesesuaian terhadap PRD. Tidak ada perbaikan yang dilakukan.

### Prioritas TINGGI

**F-01 – Alur SP tidak sesuai PRD dan berpotensi gagal (C, belum diuji)**

| Aspek | PRD | Implementasi |
|---|---|---|
| Ambang 3/6/9 Alpha | §32 | Hard-coded `>= 3`, `>= 9`, `>= 6` di `AdminKinerjaController` (baris ~116–125); kolom `ambang_sp1..3` di pengaturan **tidak dipakai** di sini |
| Semiotomatis: sistem deteksi → notifikasi Admin → Admin periksa → Admin terbitkan | §32–33 | Draf SP dibuat sebagai **efek samping membuka halaman Indeks Kinerja** (`calculatePegawaiScore` → `SuratPeringatan::create`, baris ~132). Tidak ditemukan notifikasi ke Admin |
| Siklus SP & reset | §32 | Tabel/model `catatan_alpha` (`siklus_sp`) ada tetapi tidak ditemukan dipakai; perhitungan memakai Alpha **per bulan**, bukan akumulasi siklus |
| Nilai enum | – | Kode memakai `'SP1'/'SP2'/'SP3'`; DB `enum('SP-1','SP-2','SP-3')` (migrasi `2026_09_16_...` dan dump) |
| Kolom wajib | – | `nomor_surat` & `tanggal_terbit` NOT NULL tanpa default, tidak diisi saat draf dibuat |
| Admin mengisi nomor surat lalu terbitkan | §33 | `AdminSpController::terbitkan` (baris ~48) menyimpan `status = 'Terbit'`; enum DB hanya `Aktif`, `Selesai` |
| Pegawai melihat SP yang **telah diterbitkan** | §33 | `PegawaiSpController` (baris 25) menampilkan `status = 'Aktif'` → akan menampilkan draf, dan SP berstatus terbit tidak akan tampil bila enum diperbaiki ke nilai lain |
| Cetak PDF hanya jika sudah terbit | §33 | `AdminSpController::exportPdf` mensyaratkan `Terbit`/`Selesai` |

Dampak: pada MySQL mode ketat, pembuatan draf otomatis dan penerbitan berpotensi error. **Tidak diuji** (sesuai instruksi).

**F-02 – Nilai produktivitas tetap 85 (C; perlu diverifikasi terhadap PRD)**

- Bukti: `PegawaiKegiatanController::store` baris 116 `nilai_produktivitas => 85.00` dan `kategori_produktivitas => 'Target Tercapai'`.
- Konteks penggunaan: `SkorKinerja::calculateLiveScore` (baris ~80) mengambil **rata-rata** `nilai_produktivitas` laporan berstatus `Disetujui`. Karena semua laporan baru bernilai 85, produktivitas IKP untuk setiap pegawai yang punya laporan disetujui selalu 85. Halaman Kegiatan pegawai (`PegawaiKegiatanController::index`, baris ~46) juga menampilkan rata-rata ini.
- PRD §23 mensyaratkan hitungan otomatis dari empat subindikator: kelengkapan 25%, bukti 25%, ketepatan waktu 20%, jumlah kegiatan 30% (contoh: 18/20×30). **Tidak ditemukan** formula tersebut di kode.
- Angka 85 sama dengan angka contoh di PRD §4 dan §30; asal pasti nilai ini di kode **belum dapat dipastikan** (D) – hanya kemungkinan terbawa dari contoh. Seeder `DatabaseSeeder` mengisi 100 dan 85 manual untuk data contoh.
- Selisih lain: PRD tidak menyebut status Disetujui/Ditolak untuk laporan kegiatan; kode memakainya sebagai syarat masuk IKP.
- Ringkasan: produktivitas **belum diimplementasikan sesuai PRD**.

**F-03 – IKP tidak tersimpan per bulan; kualitas kosong dihitung 0 (C)**

- PRD §28 & §62: IKP tersimpan per bulan; jika kualitas belum dinilai → "Belum Lengkap" dan sistem tidak membuat nilai kualitas.
- Kode: skor dihitung langsung tiap tampilan (`SkorKinerja::calculateLiveScore`); tidak ada penyimpanan bulanan. Kolom `nilai_kualitas` default 0 dan dirata-rata → belum dinilai tampak sebagai 0 tanpa penanda "Belum Lengkap".
- Tabel `skor_kinerja` hanya terisi oleh seeder; tab Kinerja pada Pusat Laporan membacanya (`AdminLaporanController`), sehingga berpotensi kosong.

**F-04 – Aturan jam absensi berbeda dari PRD (C; perilaku mengikuti pengaturan = A)**

| Parameter | PRD §16–17 | Default kode (`PengaturanKantor`, migrasi) | Nilai di dump `.sql` (snapshot 2 Okt 2026) |
|---|---|---|---|
| Tepat waktu | ≤08:30 | 08:00 (`batas_terlambat`) | 08:15 |
| Batas absen datang | 09:00 | 11:00 | 09:00 |
| Pulang awal | <16:00 | 16:30 (Jumat 16:00) | 16:00 |
| Batas absen pulang | 18:00 | 19:00 | 22:00 |
| Radius | 50 m | 50 | 100 |
| Koordinat kantor | 0.557333, 123.056250 | 0.5375000,123.0625000 (model) / 0.5573330,123.0562500 (seeder) | 0.557776,123.055954 |
| WFH Jumat | tidak disebut (jadwal Jumat diatur Admin) | mati | aktif (1) |

Catatan: nilai dump diduga hasil uji coba pengaturan; kondisi database aktif **belum dapat dipastikan** (D). Nama status juga berbeda: kode memakai `Pulang Cepat`; PRD `Pulang Lebih Awal`/`Pulang`; PRD status `Incomplete` (§17) **tidak ditemukan** di kode maupun enum.

**F-05 – Pengajuan "Sakit" berpotensi gagal saat disetujui (C → D)**

- `AdminPengajuanController::updateStatus` menyimpan `presensi.status = jenis pengajuan`. Enum `presensi.status` hanya `Hadir, Terlambat, Alpha, Izin, Cuti, Dinas Luar` (migrasi & dump) → nilai `Sakit` tidak valid.
- Pengguna menyatakan menguji "izin dan sakit". Jika persetujuan Sakit pernah berhasil, database aktif kemungkinan berbeda dari migrasi/dump (D). Perlu konfirmasi bagian mana yang diuji.
- PRD §29: Izin dan Sakit "diterima sesuai aturan sistem" (tanpa persetujuan), Cuti/Dinas butuh persetujuan; kode memakai persetujuan Admin untuk semua jenis. Aturan PRD tidak spesifik (D).

### Prioritas SEDANG

**F-06 – Batas 3 kali salah login belum ditemukan (C)**: PRD §8 & §62. `AuthController::login` tidak memiliki penghitung/penguncian akun maupun `RateLimiter`. Login juga menerima email dan memiliki pilihan peran (PRD hanya username & password).

**F-07 – Foto absensi dan validasi file (C)**: PRD §14, §53, §62 (hanya kamera, 5 MB, validasi ekstensi/MIME/ukuran).
- Absensi: `record()` hanya memvalidasi `photo` sebagai string base64; tidak ada validasi ukuran/MIME. Atribut `capture="user"` pada input hanya petunjuk browser seluler dan tidak memaksa kamera (`components/pegawai-modals.blade.php`). Foto diberi watermark & dikompres di sisi klien.
- Kegiatan: foto **opsional** (`nullable|image|max:3072`, 3 MB), PRD: wajib, 5 MB (`PegawaiKegiatanController::store`).

**F-08 – Reset password memakai password tetap (C)**: `AdminPegawaiController::resetPassword` selalu `pegawai123` (dan password awal default sama). PRD §7.3 "sistem membuat password baru". Risiko keamanan; password awal seeder sama. Nilai tidak dicantumkan lebih lanjut di laporan.

**F-09 – Status pegawai "Cuti" memengaruhi akun login (C)**: `AdminPegawaiController::update` (baris ~159) mengisi `pengguna.status = strtolower(status pegawai)`. Nilai `cuti` tidak ada di enum `pengguna.status` (`aktif`,`nonaktif`) dan juga memblokir login (`RoleMiddleware`). Tidak ada fitur aktif/nonaktif akun pegawai terpisah (PRD §37). Penghapusan pegawai adalah hapus permanen berantai (`destroy`).

**F-10 – Pusat Laporan tidak lengkap dan memiliki rujukan salah (C)**: PRD §40 meminta 7 laporan (absensi, kinerja, kegiatan, pengajuan, alpha, SP, data pegawai); kode hanya 4 tab. Rujukan `$act->kegiatan` dan `$skor->predikat` tidak sesuai kolom (lihat bagian 5 no. 17–18).

**F-11 – Dashboard Admin belum memuat beberapa ringkasan PRD §35 (C)**: tidak ditemukan di `AdminDashboardController` data rata-rata IKP, distribusi kategori, belum absen, ringkasan SP. Dashboard pegawai memakai konstanta 22 hari kerja dan sisa cuti 12.

**F-12 – Fitur impor tidak ditemukan (D)**: tidak ada route, controller, atau class `Imports` di `app/`, `routes/`, `resources/views` (pencarian kata "import"). Pengguna menyebut pernah menguji impor laporan; perlu klarifikasi: impor apa, dan lewat menu mana.

**F-13 – Nama instansi tidak konsisten (C, terverifikasi)**: Nama benar: **Dinas Perdagangan dan Perindustrian Kota Gorontalo**. Penulisan keliru "Dinas Perindustrian dan Perdagangan" ditemukan pada (21 kemunculan):
- Kode/konfigurasi: `app/Models/PengaturanKantor.php`, migrasi `2026_09_16_000001_...`, `database/seeders/DatabaseSeeder.php`, `database/aplikasi_disperindag.sql` (2×, data `pengaturan_kantor` yang tersimpan).
- Tampilan: `auth/login.blade.php` (2×), `admin/pengaturan-sistem.blade.php`, `components/pegawai-modals.blade.php`.
- Ekspor/PDF: `admin/exports/absensi-bulanan`, `absensi-pdf` (2×), `absensi-rentang`, `absensi-tahunan`, `cetak-sp-pdf` (2×), `kegiatan-pdf` (2×), `kinerja-pdf`, `sp-pdf` (semua `.blade.php`).
- Dokumen: `Agents/Rules/prd.md` (baris 3), `PANDUAN_STRUKTUR_FRONTEND_BACKEND.md`, `Acuan Laporan/.../Laporan Magang Saya.md` (judul; isi sudah benar 15×).
- Sudah benar: `components/admin-scripts`, `modal-preview-lampiran`, `pegawai-scripts`, `pegawai/profil.blade.php`.
Nilai yang tersimpan di database (kolom `nama_skpd`) juga memakai versi keliru menurut dump.

### Prioritas RENDAH

**F-14 – QR Code (D)**: PRD §12 & §54 – QR hanya URL ke halaman absensi. Rute `/pegawai/absensi` ada (di balik login) tetapi tidak ditemukan generator/halaman QR. Dapat berupa QR eksternal; belum dapat dipastikan.

**F-15 – Penamaan menu**: PRD §61 mengganti istilah "Kedisiplinan" menjadi "Kinerja"; menu rute sudah `indeks-kinerja`/`kinerja`, namun `PegawaiKinerjaController` masih membuat label `'Disiplin ' . kategori` (kode, baris ~42). Perlu pengecekan tampilan (D).

**F-16 – Dokumen & seeder**: `database/README_BACKEND_DATABASE.md` dan komentar kode merujuk PRD nomor lama (mis. "Bab 51", "Bab 65.2" yang kini §41/§65). PRD §42–51 memakai nama tabel Inggris (`users`, `employees`, dst.) sedangkan implementasi memakai nama Indonesia (`pengguna`, `pegawai`, …) – ini perbedaan sengaja pada migrasi `2026_09_16_...`, tetapi laporan harus konsisten dengan tabel nyata.

## 13. Konfigurasi Email (penjelasan sederhana)

**Fungsi.** Aplikasi mengirim email otomatis ketika: akun pegawai dibuat (berisi info akun), data profil/email/status diubah Admin, password direset, dan pegawai mengubah password sendiri. Kode: `app/Mail/AccountCreated.php`, `AccountUpdated.php`, `PasswordReset.php`; template di `resources/views/emails/*.blade.php`; dipanggil dari `AdminPegawaiController` dan `PegawaiProfilController`.

**Cara kerja.** Laravel mengirim email sesuai "driver" di pengaturan `MAIL_MAILER` pada file `.env`. Jika kunci ini **tidak ada**, `config/mail.php` memakai nilai bawaan `log` (`env('MAIL_MAILER','log')`): email **tidak dikirim ke inbox**, hanya ditulis ke `storage/logs/laravel.log`.

**Kondisi yang ditemukan.**
- Di `.env` tidak ditemukan kunci `MAIL_MAILER`/`MAIL_HOST`/`MAIL_PORT`/`MAIL_FROM_*` (hanya diperiksa keberadaan kunci; isi `.env` lainnya tidak dibaca/ditampilkan). `.env.example` menyediakan kerangka kunci MAIL_* tanpa nilai yang saya tampilkan.
- Karena itu, dengan konfigurasi lokal saat ini, email kemungkinan hanya dicatat di log, bukan terkirim (C).
- Seluruh pengiriman dibungkus `try { ... } catch (\Exception $e) {}` kosong (`AdminPegawaiController::store/update/resetPassword`, `PegawaiProfilController::update`) → bila pengiriman gagal, tidak ada pesan galat.
- `storage/logs/laravel.log` saat ini hanya memuat satu galat konsol yang tidak terkait email; belum ada bukti email pernah dicoba atau terkirim.
- Pengiriman memakai pemanggilan sinkron (tanpa antrean).

**Status:** **Belum terverifikasi** (B/D). Tidak ada bukti pengujian email. Untuk penulisan laporan, fitur ini hanya boleh dinyatakan "tersedia dalam kode" atau "mencatat ke log pada konfigurasi lokal", bukan "terkirim ke email pegawai".

## 14. Data Pegawai, Bidang/Unit, dan Nama Instansi

### 14.1 Status data pegawai
- Klasifikasi: **data pengujian dengan nama yang berasal dari nama nyata** (23 pegawai), bukan data kepegawaian riil sepenuhnya, sesuai pernyataan pengguna. Akun atas nama Rizqi adalah akun pengguna sendiri.
- Bukti pendukung (tanpa menyalin data pribadi): `database/seeders/PegawaiSeeder.php` berisi daftar 23 entri; semua diberi `jabatan = 'Staf Pegawai'`, `bidang = 'Sekretariat'` (nilai bawaan), `no_hp`/`alamat` kosong, username/email dibuat otomatis dari nama, dan kata sandi awal seragam. Nama dan NIP tidak ditulis ulang di sini.
- `DatabaseSeeder` juga memuat 4 pegawai contoh fiktif dan akun admin awal; kredensialnya tidak dicantumkan.
- Dump `.sql` menunjukkan `AUTO_INCREMENT=36` pada tabel `pegawai` (35 pernah dibuat), berbeda dari 23 aktif → data dumping bukan keadaan terkini atau ada data terhapus (D).
- Laporan harus menyebut data sebagai data uji; jangan menampilkan nama/NIP pegawai di gambar atau tabel laporan tanpa menyamarkannya.

### 14.2 Struktur bidang/unit

| Sumber | Unit |
|---|---|
| Pengguna | Perdagangan, Industri, PK, Sekretariat + Bagian Program (tidak dianggap bidang kelima) |
| Aplikasi (`pegawai.bidang` enum, `Pegawai::BIDANG_RESMI`, validasi `AdminPegawaiController`) | Perindustrian, Perdagangan, Sekretariat, Perlindungan Konsumen (tepat 4 nilai) |
| PRD §65.2 | Sama dengan aplikasi (4 bidang) |
| `Laporan Magang Saya.md` §1.5 | Bidang Perdagangan; Bidang Perlindungan Konsumen dan Kemetrologian; Bidang Perindustrian; Sekretariat membawahi Subbagian Program dan Subbagian Administrasi Keuangan, Umum & Kepegawaian |

Temuan:
- Aplikasi **tidak memiliki** opsi Bagian/Subbagian Program; pegawai Program kemungkinan dicatat di salah satu dari 4 bidang (mis. Sekretariat) – belum dapat dipastikan (D).
- Perbedaan penamaan: "Industri" vs "Perindustrian"; "PK" vs "Perlindungan Konsumen" vs "Perlindungan Konsumen dan Kemetrologian".
- Hubungan hierarki Bagian Program (apakah subbagian di bawah Sekretariat, seperti pada draf laporan, atau unit tersendiri) dan nama resmi lengkap **perlu dikonfirmasi** dari dokumen struktur organisasi resmi (Peraturan Wali Kota/Perwal). Tidak diasumsikan.

## 15. Status Pertanyaan Audit Sebelumnya

| Pertanyaan (bagian 9) | Status |
|---|---|
| 1. Alur SP pernah dicoba? | Dijawab: **belum diuji** |
| 2. Nilai produktivitas 85 disengaja? | Dijawab: 85 dianggap contoh PRD, bukan nilai tetap → **F-02**, perlu verifikasi |
| 3. Scheduler pernah dijalankan? | Belum ada bukti → B |
| 4. Dokumen PRD/rujukan | PRD ditemukan di `Agents/Rules/prd.md` dan telah dibaca |
| 5. Driver email | Tidak terkonfigurasi di `.env` (lihat bagian 13) |
| 6. Hasil pengujian | Dijawab → bagian 11 |
| 7. Struktur bidang | Dijawab sebagian → bagian 14.2, hierarki Program masih perlu konfirmasi |
| 8. Data pegawai | Dijawab → bagian 14.1 (data uji, nama nyata) |
| 9. Nama dinas | Ditetapkan: **Dinas Perdagangan dan Perindustrian Kota Gorontalo** → F-13 |

## 16. Hal yang Masih Perlu Dikonfirmasi

1. Pengujian "Alpha": terjadi lewat apa (manual, penolakan pengajuan, scheduler)?
2. Pengujian "sakit": hanya pengajuan, atau sampai persetujuan Admin?
3. Pengujian "impor laporan": impor yang mana dan di menu mana (tidak ditemukan kodenya)?
4. Apakah database aktif sama dengan `database/aplikasi_disperindag.sql` (khususnya enum dan pengaturan jam)?
5. Apakah email memang sengaja hanya dicatat di log pada tahap pengembangan?
6. Struktur resmi Bagian Program dan nama lengkap bidang (dokumen sumber).
7. Apakah PRD menjadi acuan final bagi laporan, termasuk jam 08:30/09:00 dan 16:00/18:00?
8. Bagaimana laporan memperlakukan ketidaksesuaian PRD–implementasi (dicatat sebagai keterbatasan atau diperbaiki dahulu)? Keputusan ada pada pengguna.


## 17. Jawaban Pengguna (27 Okt 2026) dan Dampaknya pada Status

| Topik | Jawaban | Pembaruan status |
|---|---|---|
| Asal Alpha pada pengujian | Dari scheduler dan dari pengajuan ditolak | Alpha lewat **scheduler** dan **pengajuan ditolak** pernah terjadi (A, menurut pengguna). Cakupan uji scheduler (hari libur/API, akhir pekan, pengajuan tertunda) tetap **belum terkonfirmasi** |
| Pengujian "sakit" | Sampai persetujuan Admin | A. Bertentangan dengan temuan F-05 (enum `presensi.status` tanpa `Sakit` pada migrasi/dump) → database aktif kemungkinan berbeda; **F-05 diturunkan menjadi D** sampai skema database aktif diperiksa |
| Impor | "Import absen saja" | **Tidak ditemukan kode impor absensi** di `app/`, `routes/`, `resources/` (hanya ekspor Excel/PDF). Satu-satunya input file Admin selain lampiran adalah upload template `.docx` SP (`surat-peringatan.blade.php` baris 196). Status D: asal fitur impor perlu diperjelas |
| Isi dump SQL | Tidak diketahui | Dump tidak dianggap mewakili database aktif; semua nilai pengaturan dari dump berstatus D |
| Email | Hanya log selama pengembangan | Dicatat; tetap belum terverifikasi |
| Acuan PRD | PRD adalah acuan final | Dicatat |
| Revisi PRD | Perbaiki seperlunya agar sesuai project | Dilakukan (lihat bagian 18) |

Temuan tambahan: tombol Excel pada `admin/laporan-kegiatan.blade.php` (baris 147) hanya memunculkan `alert(...)` "berhasil di-export" tanpa mengunduh file (tampilan saja, C). Ekspor sesungguhnya ada di Pusat Laporan.

## 18. Penyesuaian PRD terhadap Project

Berkas: `Agents/Rules/prd.md`. Cadangan versi awal: `brain/.../scratch/prd.md.bak`. Hanya ditambahkan catatan "Penyesuaian implementasi" di bagian yang berbeda dari project dan satu koreksi nama instansi; isi PRD lainnya tidak diubah.

| Bagian PRD | Penyesuaian |
|---|---|
| Header | Nama instansi menjadi Dinas Perdagangan dan Perindustrian Kota Gorontalo |
| §7.3 | Pembuatan username dan password default |
| §8 | Login username/email + tab peran; batas 3 kali salah login belum ada |
| §15 | Tanpa FileStorageService |
| §16 | Jam dapat diatur Admin; Alpha oleh scheduler |
| §19 | Nama status pulang; Incomplete belum ada |
| §21 | Foto kegiatan opsional, 3 MB |
| §26 | Status verifikasi laporan; hanya Disetujui masuk IKP |
| §28 | Rumus kehadiran; IKP real-time; kualitas kosong = 0 |
| §40 | 4 dari 7 tab laporan tersedia |
| §42 | Pemetaan nama tabel |
| §60 | Tailwind via Vite; CDN Chart.js/SweetAlert2; tanpa getUserMedia |

**Sengaja tidak diubah** (dianggap kekurangan implementasi, bukan perbedaan rancangan; PRD tetap acuan):
- Produktivitas otomatis empat subindikator (§23) vs nilai tetap 85 (F-02).
- Alur SP semiotomatis, ambang, notifikasi Admin, siklus SP (§32–33) vs implementasi (F-01).
- Foto absensi hanya kamera dan validasi 5 MB (§14, §53) (F-07).
- IKP tersimpan per bulan dan status "Belum Lengkap" (§28, §62) — dicatat di catatan §28, aturan PRD tetap.
- Dashboard Admin (§35), QR Code (§12), jam default (§16–17).

---

# PEMERIKSAAN LANJUTAN (27 Okt 2026, read-only)

Tidak ada perbaikan kode, perubahan data, migrasi, seeder, atau scheduler yang dijalankan. Pemeriksaan database memakai satu skrip sementara di folder scratch yang hanya menjalankan `SELECT`/`SHOW` (tanpa mencetak kredensial). Penanda sumber: **[KODE]** hasil membaca kode, **[DB]** kondisi database aktif, **[UJI]** pernyataan pengujian pengguna, **[?]** belum diketahui.

## 19. Kondisi Git

Perintah yang dijalankan: `git status`, `git ls-files -d`, `git diff --stat`, `git log`, `git show HEAD:...`, `git ls-tree`. Tidak ada checkout/reset/clean/restore/commit/hapus.

Branch `main`, sejajar dengan `origin/main`. Berkas yang **terhapus di working tree** (masih ada di commit `ae12a13`, sehingga bisa dipulihkan jika diperlukan):

| Berkas | Isi di commit | Perkiraan dampak |
|---|---|---|
| `.tmp/sf_proc_00.err` (+`.lock`, `.out`, `.out.lock`) | Berkas sementara proses; `.err` 92 byte berisi pesan `'svn' is not recognized...`, lainnya kosong | Tidak berdampak pada aplikasi; sampah alat bantu |
| `Agents/Rules/AGENTS.md` | Instruksi bootstrap Laravel Boost untuk agen AI | Tidak memengaruhi aplikasi. `Agents/Rules/CLAUDE.md` baris 46 masih merujuk berkas ini |
| `_BACKEND_DIREKTORI_INFO/INFO_BACKEND.md`, `_FRONTEND_DIREKTORI_INFO/INFO_FRONTEND.md` | Dokumen penunjuk struktur folder | Hanya dokumentasi. Fungsi serupa dipegang `README_BACKEND_*.md` / `README_FRONTEND_*.md` yang masih tertrack (6 berkas), sehingga penghapusan kemungkinan merupakan perapian (belum pasti) |
| `resources/views/welcome.blade.php` | Tampilan bawaan Laravel | Tidak dirujuk: `routes/web.php` baris 23–25 mengalihkan `/` ke login; tidak ada `view('welcome')` |
| `routes_list.txt` | Kosong (0 baris) | Tidak berdampak |

Berkas **dimodifikasi**: `Agents/Rules/prd.md` (24 baris ditambah, 1 diubah) — itu perubahan catatan PRD dari tahap sebelumnya. Git juga memperingatkan konversi akhir baris CRLF→LF pada berkas tersebut (hanya peringatan).

**Untracked**: folder `Acuan Laporan/` (6 berkas, termasuk laporan dan audit) belum masuk Git, sehingga tidak terlindungi riwayat Git.

Kesimpulan: tidak ditemukan berkas kode aplikasi (controller, model, migrasi, view yang dipakai) yang hilang. Yang terhapus adalah berkas bantu/dokumentasi/bawaan. Siapa yang menghapus dan apakah disengaja **belum dapat dipastikan [?]** dari Git; hanya Anda yang bisa memastikan. Daftar ini sudah ada saat pemeriksaan awal sesi ini dimulai.

## 20. Database Aktif

**[DB]** Driver `mysql`, database `aplikasi_disperindag`, koneksi berhasil, `sql_mode` mengandung `STRICT_TRANS_TABLES`. Tabel migrasi: 6 migrasi tercatat (batch 1–3) sama dengan folder `database/migrations`.

### 20.1 Struktur vs migrasi vs dump
| Item | Database aktif | Migrasi | Dump `.sql` |
|---|---|---|---|
| `presensi.status` | `Hadir, Terlambat, Alpha, Izin, Cuti, Dinas Luar` (tanpa **Sakit**, tanpa Incomplete) | sama | sama |
| `presensi.status_pulang` | `Tepat Waktu, Pulang Cepat` | sama | sama |
| `pengajuan_izin.jenis` | `Izin, Cuti, Sakit, Dinas Luar` | sama | sama |
| `surat_peringatan.tingkat_sp` | `SP-1, SP-2, SP-3` | sama | sama |
| `surat_peringatan.status` | `Aktif, Selesai` | sama | sama |
| `surat_peringatan.nomor_surat`, `tanggal_terbit` | NOT NULL, tanpa default | sama | sama |
| `skor_kinerja` | enum kategori/status/rekomendasi sesuai migrasi | sama | sama |
| `pegawai.bidang` | 4 nilai (Perindustrian, Perdagangan, Sekretariat, Perlindungan Konsumen) | sama | sama |
| `pegawai.status` / `pengguna.status` | `Aktif,Cuti` / `aktif,nonaktif` | sama | sama |
| `catatan_alpha` | tabel ada | – | – |

Struktur tabel aktif **sesuai** migrasi dan dump. Yang berbeda adalah **isi data**.

### 20.2 Data aktif
| Tabel | Baris |
|---|---|
| `pegawai` | 24 (semua bidang Sekretariat, status Aktif) |
| `pengguna` | 26 (2 admin, 24 pegawai) |
| `presensi` | 2 (Hadir 1, Terlambat 1) |
| `laporan_kegiatan` | 3 (Disetujui 2, Menunggu Review 1; **seluruhnya `nilai_produktivitas = 85.00`**) |
| `pengajuan_izin` | 0 |
| `skor_kinerja` | 0 |
| `catatan_alpha` | 0 |
| `surat_peringatan` | 0 |
| `pengaturan_kantor` | 1 |

Pengaturan aktif (non-rahasia): `nama_skpd` = "Dinas Perindustrian dan Perdagangan Kota Gorontalo" (**nama keliru**), radius 100 m, koordinat `0.6226627,122.9765976` (berbeda dari PRD §13), `jam_masuk 01:00`, `batas_terlambat 02:00`, `batas_akhir_masuk 02:15`, `jam_pulang 14:00`, `batas_akhir_pulang 22:00`, `jam_pulang_jumat 09:00`, `is_wfh_jumat = 0`, bobot 60/25/15 (total 100), ambang SP 3/6/9, `pola_nomor_sp = 800/{nomor}/DISPERINDAG/{tahun}`.

Catatan:
- Jam aktif tampak nilai uji (sesuai pengujian jam absensi Anda). Dengan jam server 08:36, `batas_akhir_masuk` 02:15 membuat absen masuk saat ini **ditolak** (`PegawaiAbsensiController.php`, pengecekan batas akhir masuk) sampai pengaturan dikembalikan. Tidak diubah.
- Dump `.sql` berbeda dari data aktif (mis. dump: radius 100, jam 08:00/08:15/09:00, WFH aktif; aktif: jam 01:00..., WFH mati) → dump bukan cerminan database sekarang, sesuai pernyataan pengguna.
- **Jejak pengujian tidak ada di database aktif**: tidak ada Alpha, pengajuan (izin/sakit), SP, maupun skor. Pengujian Alpha (scheduler & pengajuan ditolak) dan izin/sakit **tidak dapat dikonfirmasi dari data** [?]: data mungkin sudah dibersihkan atau uji dilakukan di database lain.
- 24 pegawai konsisten dengan keterangan "23 pegawai + akun Rizqi" tetapi tidak diverifikasi per nama.
- Dengan skema aktif, persetujuan pengajuan **Sakit** menulis `presensi.status = 'Sakit'` (`AdminPengajuanController.php:65`), nilai yang tidak ada di enum, dan mode ketat aktif → seharusnya gagal. Ini bertentangan dengan pernyataan uji pengguna. Status F-05: **D**, perlu diuji ulang.

## 21. Alur SP Semiotomatis

Uji langsung: **belum pernah** (pengguna) dan tidak ada data SP/Alpha di DB. Semua di bawah berstatus **[KODE]**.

| Langkah PRD | Implementasi (file:baris) | Kesesuaian |
|---|---|---|
| 1. Alpha tercatat | Scheduler `routes/console.php:13-16` (Senin–Jumat 12:00, WITA) → `TandaiAlphaOtomatis.php:28` lewati akhir pekan, `:36` API libur, `:61` pegawai aktif, `:74-79` lewati pengajuan "Menunggu Review", `:86` `Presensi::create(status 'Alpha')`. Pengajuan ditolak → `AdminPengajuanController.php:70-83` | Presensi Alpha ada. **`catatan_alpha` tidak pernah diisi** (model hanya ada di `Pegawai.php:63-65`, tidak ada tulis). Scheduler butuh `schedule:run` aktif [?] |
| 2. Deteksi 3/6/9 | `AdminKinerjaController.php:112-121`: hitung Alpha **per bulan**, 3→`SP1`, 6→`SP2`, 9→`SP3` (hard-coded) | Ambang pada pengaturan (`ambang_sp1..3`, `pengaturan-sistem.blade.php:281-291`, disimpan `AdminPengaturanController.php:47-49`) **tidak dipakai**. PRD memakai akumulasi/siklus, bukan per bulan |
| 3. Draf | `AdminKinerjaController.php:125-135` membuat `SuratPeringatan` bila belum ada pada bulan itu | Dipicu **hanya saat Admin membuka Indeks Kinerja** (`:42`) dan juga untuk 5 bulan sebelumnya lewat grafik tren (`:71`), bukan oleh pencatatan Alpha. Insert memakai `'SP1'` (enum `SP-1`) dan tanpa `nomor_surat`/`tanggal_terbit` → pada MySQL ketat diperkirakan **gagal** [C] |
| 4. Notifikasi Admin | Tidak ditemukan notifikasi (hanya trait `Notifiable` di `User.php:9`) | **Tidak sesuai PRD §32–33** |
| 5. Admin isi nomor/tanggal | Modal `surat-peringatan.blade.php:262-332` (field `nomor_surat`), `AdminSpController.php:40` wajib, `:46-47` tanggal diisi otomatis hari ini | Tidak ada input tanggal (diisi otomatis). **Form dikirim ke `/surat-peringatan/{id}/terbitkan`** (`surat-peringatan.blade.php:372`) padahal rute `routes/web.php:68` berada di prefix `/admin/...` → perkiraan **404** [C] |
| 6. Terbitkan | `AdminSpController.php:48` `status = 'Terbit'` | Nilai tidak ada pada enum (`Aktif`,`Selesai`) → diperkirakan error pada mode ketat |
| 7. Dokumen PDF | `AdminSpController.php:54-` hanya jika `Terbit`/`Selesai`; view `admin/exports/cetak-sp-pdf.blade.php` | PDF memakai view bawaan, **bukan** template `.docx`. Upload template hanya tampilan (lihat bagian 23) |
| 8. Pegawai melihat SP | `PegawaiSpController.php:24-25` memuat `status = 'Aktif'`; `pelanggaran-sp.blade.php:39` menampilkan "n / TERBIT" | Yang tampil adalah **draf** (Aktif), bukan SP yang sudah diterbitkan. Jumlah Alpha dihitung seluruh waktu (`:21-23`), bukan per siklus |
| 9. Siklus & reset | Hanya teks penjelasan di `pelanggaran-sp.blade.php:169` | Tidak ada logika siklus/reset |

Ringkasan: langkah pencatatan Alpha berfungsi pada level presensi; deteksi 3/6/9, notifikasi, penerbitan, dan penayangan pegawai **belum sesuai PRD** dan berpotensi gagal (belum diuji).

## 22. Produktivitas dan IKP

| Pertanyaan | Temuan |
|---|---|
| Sumber nilai produktivitas | **Konstanta** `85.00` dan kategori "Target Tercapai" saat laporan dibuat: `PegawaiKegiatanController.php:116-117`. **[DB]** 3 dari 3 laporan bernilai 85.00 |
| Empat indikator PRD §23 | **Tidak ada** formula. Data mentahnya ada sebagian: kelengkapan (nama/deskripsi/tanggal wajib `:67-69`), bukti (foto `nullable` `:70`), waktu kirim (`waktu_kirim` `:115`, tanpa tenggat), jumlah (`$targetHariKerja = 22` di `PegawaiKegiatanController.php` dekat `:43`, konstanta, bukan target periode PRD) |
| Penggunaan di IKP | `SkorKinerja.php:74,80` = rata-rata `nilai_produktivitas` laporan **Disetujui** → pegawai dengan laporan disetujui selalu 85 |
| Kualitas sebelum dinilai | Kolom default `0.00` [DB]. `AdminKegiatanController.php:91` memakai nilai lama (0) bila admin tidak mengisi; `:95-98` lalu memberi kategori **D** karena 0 bukan null. Pada IKP `SkorKinerja.php:81` merata-rata kualitas laporan **Disetujui**; tanpa laporan disetujui → 0 (`:77-78`). Tidak ada status "Belum Lengkap" |
| Kehadiran | `SkorKinerja.php:66-68`: 0 jika tidak ada baris presensi, selain itu `100 - 5×Alpha - 2×Terlambat` (min 0) |
| Bobot dan kategori | Bobot dari `pengaturan_kantor` (`SkorKinerja.php:85-87`; aktif 60/25/15). Kategori `:95-102` (≥90/80/70) sesuai PRD §5. `AdminPengaturanController::update` tidak memvalidasi total 100% (PRD §41) |
| Tersimpan atau dihitung saat dibuka? | **Dihitung saat halaman dibuka** (`calculateLiveScore`, dipanggil dari `AdminKinerjaController.php:42,71`, `PegawaiKinerjaController`, `PegawaiDashboardController`). Tidak ada kode yang menulis `skor_kinerja`; **[DB]** tabelnya 0 baris |
| Dampak ke laporan | `KinerjaExport.php:27` dan tab Kinerja Pusat Laporan membaca tabel `skor_kinerja` (kosong) → laporan kinerja **kosong** pada database sekarang |
| Perbedaan PRD | Produktivitas otomatis (§23) belum ada; IKP tidak tersimpan per bulan (§62); filter status laporan kegiatan memakai nilai "Terverifikasi" (`laporan-kegiatan.blade.php:241`) yang tidak cocok dengan data (`Disetujui`) pada `AdminKegiatanController.php:25` |

## 23. Pusat Laporan, Ekspor, dan Impor

### 23.1 Laporan yang tersedia
Rute: `GET admin/pusat-laporan` (alias `admin/laporan`) `web.php:73-74`; ekspor `GET admin/pusat-laporan/export/{format}` (alias `admin/laporan/export/{format}`) `web.php:75-76`. Empat tab: **Absensi, Kinerja, Kegiatan, SP** (`pusat-laporan.blade.php:61, 203, 343, 477`). Tidak ada tab Pengajuan, Alpha, Data Pegawai (PRD §40). Ekspor pegawai: `pegawai/riwayat-absensi/export/pdf` (`web.php:94`), `pegawai/kegiatan/export/pdf` (`:101`).

### 23.2 Apakah ekspor menghasilkan file sungguhan? [KODE]
| Tab | Tautan | Excel | PDF | Catatan |
|---|---|---|---|---|
| Absensi | `pusat-laporan.blade.php:189,193` | `AbsensiExport` (FromView) | DomPDF landscape | Mendukung varian bulanan/tahunan/rentang |
| Kinerja | `:329,333` | `KinerjaExport` | DomPDF | Sumber `skor_kinerja` kosong |
| Kegiatan | `:463,467` | `KegiatanExport` | DomPDF | Data per tanggal |
| SP | `:611,615` | `SpExport` | DomPDF | Hanya SP dengan tahun `tanggal_terbit` |

`AdminLaporanController::export` memanggil `Excel::download(...)` dan `Pdf::...->download(...)`, sehingga file sungguhan dihasilkan oleh kode. Pengguna menyatakan pernah menguji ekspor **[UJI]**, tab/format tidak diketahui.

### 23.3 Tombol yang hanya tampilan (`alert`) [KODE]
- `admin/laporan-kegiatan.blade.php:147` (Export Excel "berhasil" tanpa unduh)
- `admin/pusat-laporan.blade.php:584-585` (unduh SP .docx/.pdf)
- `admin/surat-peringatan.blade.php:187` (unduh template), `:67` (reset filter)
- `admin/persetujuan-izin-cuti.blade.php:90` (membuka lampiran)
- `auth/login.blade.php:156` (lupa password), `components/pegawai-scripts.blade.php:337`

### 23.4 Impor
- Tidak ada rute, controller, atau class impor (Excel/CSV) di `routes/web.php`, `app/`, `app/Imports` (tidak ada folder).
- Sesuai koreksi pengguna, yang dimaksud sebelumnya adalah **ekspor**; **impor SP belum pernah diuji**.
- Satu-satunya fitur mirip impor adalah **"Kelola Master Template SP (.docx)"** (`surat-peringatan.blade.php:196, 340-353`): memilih berkas hanya mengganti teks nama berkas dan menampilkan `alert('...berhasil diperbarui & disimpan')`. **Tidak ada rute atau penyimpanan di server**. Kolom `template_sp` (teks) ada di pengaturan, tetapi bukan berkas.
- Cara pengujian pengguna tidak diasumsikan.

## 24. Ringkasan Sumber Bukti

| Kategori | Cakupan |
|---|---|
| Pemeriksaan kode | Bagian 21–23 (file:baris) |
| Database aktif | Bagian 20 (kolom enum, jumlah baris, pengaturan, sql_mode) |
| Pengujian langsung pengguna | Jam absensi, absen masuk/pulang, terlambat, Alpha (scheduler & pengajuan ditolak), izin & sakit, laporan kegiatan, penilaian kegiatan, kesesuaian pengaturan, ekspor, tambah pegawai. Jejak datanya tidak ada di DB aktif |
| Belum diuji | SP sampai 3 Alpha, impor SP, scheduler secara menyeluruh, email, login 3 kali salah |
| Belum diketahui | Pelaku penghapusan berkas Git, apakah scheduler (`schedule:run`) aktif, nilai asli `85`, struktur resmi Bagian Program |

