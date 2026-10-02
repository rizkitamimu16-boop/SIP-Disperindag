# [BACKEND] DIREKTORI MODEL ELOQUENT DATABASE

Folder ini adalah **BACK-END DATA MODELS AREA**:
Berisi model Eloquent yang merepresentasikan tabel-tabel di MySQL database `aplikasi_disperindag` dalam Bahasa Indonesia:
- `Pegawai.php` -> Tabel `pegawai` (Biodata PPPK, NIP, 4 bidang resmi)
- `User.php` -> Tabel `pengguna` (Akun login admin & pegawai)
- `Presensi.php` -> Tabel `presensi` (Log absensi datang & pulang, GPS distance)
- `LaporanKegiatan.php` -> Tabel `laporan_kegiatan` (Laporan tugas kerja harian)
- `PengajuanIzin.php` -> Tabel `pengajuan_izin` (Dispensasi izin, cuti, sakit, dinas luar)
- `SkorKinerja.php` -> Tabel `skor_kinerja` (Akumulasi Indeks Kinerja Pegawai / IKP)
- `CatatanAlpha.php` -> Tabel `catatan_alpha` (Rekap ketidakhadiran tanpa izin)
- `SuratPeringatan.php` -> Tabel `surat_peringatan` (Penerbitan SP-1, SP-2, SP-3)
- `PengaturanKantor.php` -> Tabel `pengaturan_kantor` (Konfigurasi koordinat GPS kantor, jam kerja WITA, bobot nilai)
