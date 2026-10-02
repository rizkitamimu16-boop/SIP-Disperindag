# PANDUAN STRUKTUR FRONTEND DAN BACKEND SISTEM DISPERINDAG

Dokumen ini merupakan panduan resmi penandaan direktori untuk membedakan secara tegas bagian **Front-End (Antarmuka & Tampilan)** dan **Back-End (Logika Bisnis & Database)** pada aplikasi Sistem Kedisiplinan & Kinerja PPPK Dinas Perindustrian dan Perdagangan Kota Gorontalo.

---

## 🧭 Peta Pembagian Direktori

```
aplikasi-disperindag/
│
├── 🎨 [FRONTEND - AREA TAMPILAN & ANTARMUKA]
│   ├── resources/views/             <-- KODE UTAMA VIEW & TAMPILAN BLADE
│   │   ├── admin/                   <-- Halaman antarmuka Administrator
│   │   ├── pegawai/                 <-- Halaman antarmuka Pegawai PPPK
│   │   ├── auth/                    <-- Halaman formulir Login
│   │   ├── layouts/                 <-- Template induk admin.blade & pegawai.blade
│   │   └── components/              <-- Modal dialogs, sidebar, dan scripts
│   ├── public/                      <-- ASET PUBLIK TERKOMPILASI
│   │   ├── assets/img/              <-- Logo resmi instansi Pemkot Gorontalo
│   │   └── css/ & js/               <-- File style visual
│   └── resources/css/ & js/         <-- File source style & script
│
├── ⚙️ [BACKEND - AREA LOGIKA, DATA & DATABASE]
│   ├── app/Http/Controllers/        <-- PUSAT LOGIKA CONTROLLER SISTEM
│   │   ├── Admin/                   <-- Controller CRUD & Cockpit Admin
│   │   ├── Pegawai/                 <-- Controller Aksi & Presensi Pegawai
│   │   └── Auth/                    <-- Controller Login & Sesi Keamanan
│   ├── app/Models/                  <-- MODEL DATA ELOQUENT (TABEL DATABASE)
│   │   ├── Pegawai.php              <-- Model tabel 'pegawai'
│   │   ├── User.php                 <-- Model tabel 'pengguna'
│   │   ├── Presensi.php             <-- Model tabel 'presensi'
│   │   ├── LaporanKegiatan.php      <-- Model tabel 'laporan_kegiatan'
│   │   ├── PengajuanIzin.php        <-- Model tabel 'pengajuan_izin'
│   │   ├── SkorKinerja.php          <-- Model tabel 'skor_kinerja'
│   │   ├── CatatanAlpha.php         <-- Model tabel 'catatan_alpha'
│   │   ├── SuratPeringatan.php      <-- Model tabel 'surat_peringatan'
│   │   └── PengaturanKantor.php     <-- Model tabel 'pengaturan_kantor'
│   ├── routes/web.php               <-- PENENTU RUTE URL & AKSES ROLE
│   ├── database/migrations/         <-- STRUKTUR SKEMA TABEL MYSQL
│   ├── database/seeders/            <-- DATA AWAL RESMI (4 BIDANG & ADMIN)
│   └── app/Http/Middleware/         <-- PENJAGA OTENTIKASI & HAK AKSES PERAN
│
└── 📁 [PENUNJUK CEPAT IDE]
    ├── _FRONTEND_DIREKTORI_INFO/    <-- Petunjuk cepat area Frontend
    └── _BACKEND_DIREKTORI_INFO/     <-- Petunjuk cepat area Backend
```

---

## 1. Bagian Front-End (Tampilan Pengguna)

Front-End bertugas merender tampilan antarmuka visual yang dilihat dan digunakan oleh Pengguna (Admin maupun Pegawai PPPK):

| Direktori / File | Fungsi & Peran Front-End |
| :--- | :--- |
| **`resources/views/`** | **Pusat template antarmuka sistem**. Menggunakan Blade engine dengan Tailwind CSS. |
| `resources/views/admin/` | Seluruh halaman antarmuka Admin: `dashboard.blade.php`, `data-pegawai.blade.php`, `monitoring-absensi.blade.php`, `laporan-kegiatan.blade.php`, `persetujuan-izin-cuti.blade.php`, `indeks-kinerja.blade.php`, `surat-peringatan.blade.php`, `pusat-laporan.blade.php`, `pengaturan-sistem.blade.php`. |
| `resources/views/pegawai/` | Seluruh halaman antarmuka Pegawai: `dashboard.blade.php`, `riwayat-absensi.blade.php`, `kegiatan.blade.php`, `pengajuan.blade.php`, `kinerja.blade.php`, `pelanggaran-sp.blade.php`, `profil.blade.php`. |
| `resources/views/auth/` | Halaman login interaktif pemilih peran (*Administrator* atau *Pegawai PPPK*). |
| `resources/views/layouts/` | Kerangka layout utama (`admin.blade.php` cockpit & `pegawai.blade.php` mobile navigation). |
| `resources/views/components/` | Komponen modular: Modal pop-up form, preview dokumen SK/SPT, sidebar navigasi, dan integrasi Javascript Chart/Clock. |
| **`public/`** | File asset statis yang dapat diakses langsung oleh browser web (gambar logo, favicon, stylesheet). |

---

## 2. Bagian Back-End (Logika Sistem & Database)

Back-End bertugas memproses data, memvalidasi input, menjalankan aturan bisnis (PRD), serta berkomunikasi dengan MySQL Laragon:

| Direktori / File | Fungsi & Peran Back-End |
| :--- | :--- |
| **`app/Http/Controllers/`** | **Pengendali logika utama**. Menerima HTTP Request, memvalidasi data form, memanggil Model Eloquent, dan mengembalikan response. |
| `app/Http/Controllers/Admin/` | Logika manajemen data pegawai (CRUD), persetujuan izin/cuti, penilaian kegiatan harian, dan pengaturan kantor. |
| `app/Http/Controllers/Pegawai/`| Logika perekaman presensi radius GPS (Haversine Formula), submit laporan tugas harian, dan permohonan izin/cuti. |
| `app/Http/Controllers/Auth/` | Logika otentikasi login, validasi kata sandi hash, dan sesi keamanan. |
| **`app/Models/`** | **Representasi tabel database (ORM Eloquent)** dalam Bahasa Indonesia (`Pegawai`, `User`, `Presensi`, dll). |
| **`routes/web.php`** | **Pusat pemetaan URL**, pengelompokan prefix (`/admin`, `/pegawai`), dan proteksi middleware role. |
| **`database/migrations/`** | Berkas Blueprint pembentuk skema tabel di database MySQL Laragon. |
| **`database/seeders/`** | Berkas pengisi data awal resmi instansi (Akun Superadmin, 4 Bidang Resmi, Pegawai contoh). |
| **`app/Http/Middleware/`** | Filter keamanan yang membatasi akses URL hanya untuk peran pengguna yang sah (`admin` atau `pegawai`). |

---

## 3. Cara Mengubah & Mengembangkan Kode

- **Jika ingin mengubah warna, tampilan tombol, tata letak teks, atau tabel antarmuka**:
  👉 Buka folder **`resources/views/`** (Front-End).
- **Jika ingin mengubah alur penyimpanan, validasi form, rumus skor, atau data yang disimpan ke MySQL**:
  👉 Buka folder **`app/Http/Controllers/`** dan **`app/Models/`** (Back-End).
- **Jika ingin menambah URL / halaman baru**:
  👉 Daftarkan rutenya di **`routes/web.php`** (Back-End Routing).
