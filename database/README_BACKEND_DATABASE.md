# [BACKEND] DIREKTORI DATABASE & MIGRASI

Folder ini adalah **BACK-END DATABASE SCHEMA AREA**:
Berisi struktur pembentuk database MySQL Laragon:
- `migrations/` : Berkas migrasi pembuatan 9 tabel domain Bahasa Indonesia (`pengguna`, `pegawai`, `presensi`, `laporan_kegiatan`, `pengajuan_izin`, `skor_kinerja`, `catatan_alpha`, `surat_peringatan`, `pengaturan_kantor`) serta tabel infrastruktur Laravel (`sessions`, `cache`, `jobs`).
- `seeders/` : Berkas `DatabaseSeeder.php` yang mengisi data awal: Akun Administrator, data instansi Disperindag Kota Gorontalo, dan sampel pegawai pada 4 Bidang Resmi (*Perindustrian*, *Perdagangan*, *Sekretariat*, *Perlindungan Konsumen*).
