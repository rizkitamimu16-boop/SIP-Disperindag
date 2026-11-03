# PRODUCT REQUIREMENT DOCUMENT (PRD)

## SISTEM INFORMASI ABSENSI DAN PENGUKURAN KINERJA PEGAWAI

**Instansi:** Dinas Perdagangan dan Perindustrian Kota Gorontalo
**Platform:** Web
**Pengguna:** Admin dan Pegawai P3K
**Versi:** Final Draft

---

# 1. Gambaran Umum

Sistem merupakan aplikasi web untuk mengelola absensi Pegawai P3K sekaligus melakukan pengukuran kinerja pegawai secara terstruktur.

Sistem tidak hanya berfungsi sebagai aplikasi absensi, tetapi mengintegrasikan:

* absensi;
* laporan kegiatan;
* pengajuan izin/sakit/cuti/perjalanan dinas;
* pengukuran kinerja;
* pelanggaran Alpha;
* Surat Peringatan (SP);
* laporan administrasi kepegawaian.

Pengukuran kinerja menggunakan **Indeks Kinerja Pegawai (IKP)** dengan tiga indikator:

1. Kehadiran & Ketepatan Waktu;
2. Produktivitas Kerja;
3. Kualitas Kerja.

---

# 2. Landasan Pengukuran Kinerja

Jurnal Nawir, Bachtiar, dan Afifah (2024) mengidentifikasi lima indikator disiplin kerja:

1. Kehadiran dan ketepatan waktu;
2. Kepatuhan terhadap aturan dan prosedur;
3. Produktivitas kerja;
4. Kualitas kerja;
5. Perilaku dan sikap.

Dalam sistem ini digunakan tiga indikator yang dapat diukur secara langsung melalui data sistem:

* Kehadiran & Ketepatan Waktu;
* Produktivitas Kerja;
* Kualitas Kerja.

Indikator kepatuhan terhadap aturan/prosedur dan perilaku/sikap tidak dimasukkan karena sistem tidak memiliki data objektif yang cukup untuk mengukurnya secara konsisten.

Penelitian Azmi, Mustafa, dan Juharni (2025) pada disiplin kerja ASN juga menggunakan indikator disiplin waktu, disiplin peraturan, dan disiplin tanggung jawab serta melibatkan PPPK sebagai sumber data.

---

# 3. Bobot Indeks Kinerja Pegawai

Bobot yang digunakan dalam sistem:

| Indikator                   |    Bobot |
| --------------------------- | -------: |
| Kehadiran & Ketepatan Waktu |      60% |
| Produktivitas Kerja         |      25% |
| Kualitas Kerja              |      15% |
| **Total**                   | **100%** |

### Dasar pembobotan

Bobot tersebut merupakan **adaptasi penelitian**, bukan angka yang diklaim sebagai bobot baku dari satu jurnal.

Penelitian AHP pada penilaian loyalitas berdasarkan kedisiplinan kerja menggunakan kelompok Absensi sebesar 62,5%, Kinerja sebesar 23,8%, dan Ketaatan sebesar 13,6%. Kelompok Kinerja mencakup produktivitas dan kualitas.

Karena sistem ini hanya menggunakan tiga indikator yang tersedia secara objektif, bobot tersebut diadaptasi menjadi:

* Kehadiran & Ketepatan Waktu: 60%;
* Produktivitas: 25%;
* Kualitas: 15%.

Bobot dapat dijelaskan dalam penelitian sebagai **bobot rancangan sistem yang mengacu pada kecenderungan pembobotan dalam penelitian terdahulu**, bukan sebagai bobot yang secara langsung diambil dari jurnal.

---

# 4. Rumus IKP

Nilai setiap indikator berada pada skala 0–100.

Rumus:

```text
IKP =
(Kehadiran × 60%)
+
(Produktivitas × 25%)
+
(Kualitas × 15%)
```

Contoh:

```text
Kehadiran    = 90
Produktivitas = 85
Kualitas     = 80
```

Maka:

```text
IKP =
(90 × 0,60)
+
(85 × 0,25)
+
(80 × 0,15)

= 54 + 21,25 + 12

= 87,25
```

Kategori:

```text
87,25 = Baik
```

---

# 5. Kategori IKP

|  Nilai | Kategori    |
| -----: | ----------- |
| 90–100 | Sangat Baik |
|  80–89 | Baik        |
|  70–79 | Cukup       |
|    <70 | Kurang      |

IKP dihitung secara **bulanan**.

---

# 6. Role Sistem

Sistem hanya memiliki dua role.

## 6.1 Admin

Admin merupakan petugas kepegawaian/personalia.

Admin dapat:

* mengelola data pegawai;
* membuat akun pegawai;
* membuat akun Admin;
* memantau absensi;
* melihat foto absensi;
* memantau laporan kegiatan;
* melihat skor produktivitas otomatis;
* memberikan penilaian kualitas kerja;
* memproses pengajuan;
* melihat IKP;
* memantau Alpha;
* menerbitkan SP;
* membuat laporan;
* mengatur konfigurasi sistem.

Admin tidak melakukan absensi sebagai Pegawai P3K.

## 6.2 Pegawai

Pegawai merupakan Pegawai P3K.

Pegawai dapat:

* login;
* melakukan absensi datang;
* melakukan absensi pulang;
* melihat riwayat absensi;
* membuat laporan kegiatan;
* melihat hasil produktivitas;
* mengajukan izin/sakit/cuti/perjalanan dinas;
* melihat IKP;
* melihat pelanggaran/SP;
* melihat profil.

---

# 7. Pembuatan Akun

## 7.1 Akun Admin Pertama

Tidak tersedia registrasi Admin dari halaman login.

Admin pertama dibuat menggunakan Laravel Seeder saat instalasi sistem.

Contoh:

```text
role = admin
username = admin
password = password awal
```

Password disimpan menggunakan hashing Laravel.

## 7.2 Admin Berikutnya

Admin yang sudah memiliki akses dapat membuat Admin baru melalui:

```text
Pengaturan Sistem
→ Manajemen Admin
→ Tambah Admin
```

## 7.3 Akun Pegawai

> **Penyesuaian implementasi:** username dibuat otomatis dari nama dan 4 digit akhir NIP; password awal dan hasil reset password adalah password default yang sama (bukan acak), dikirim lewat pesan sukses admin dan email.

Pegawai tidak melakukan registrasi sendiri.

Admin membuat akun melalui:

```text
Data Pegawai
→ Tambah Pegawai
```

Sistem membuat username dan password awal secara otomatis.

Admin tidak dapat melihat password lama pegawai.

Jika password lupa:

```text
Pegawai → Hubungi Admin
→ Admin Reset Password
→ Sistem membuat password baru
```

---

# 8. Login

> **Penyesuaian implementasi:** login dapat memakai username atau email, dan form memiliki pilihan tab peran (Admin/Pegawai) yang bersifat opsional. Pembatasan 3 kali salah login belum diimplementasikan.

Form login:

* Username;
* Password.

Tidak menggunakan:

* OTP;
* SMS verification;
* Email verification;
* 2FA.

Percobaan login salah maksimal 3 kali.

Jika melebihi batas:

> Akun dikunci. Hubungi Admin untuk mereset password.

---

# 9. Menu Pegawai

Menu final:

```text
Dashboard
Riwayat Absensi
Kegiatan
Pengajuan
Kinerja
Pelanggaran / SP
Profil
```

---

# 10. Dashboard Pegawai

Dashboard menampilkan:

* nama pegawai;
* jam saat ini;
* status absensi hari ini;
* tombol/area Presensi Sekarang;
* ringkasan absensi bulan berjalan;
* kegiatan terbaru;
* pengajuan terbaru;
* nilai IKP;
* kategori IKP.

Frontend yang sudah ada dapat dipertahankan dan disesuaikan, tidak perlu dibuat ulang dari awal.

---

# 11. Absensi

Jenis absensi hanya:

1. Datang;
2. Pulang.

Tidak ada absensi setelah istirahat.

---

# 12. QR Code

QR Code hanya berfungsi sebagai URL menuju halaman absensi.

Contoh:

```text
QR Code
   ↓
/absensi
```

QR tidak digunakan sebagai:

* validasi lokasi;
* validasi identitas;
* indikator disiplin;
* indikator kinerja.

Beberapa QR dapat dipasang di kantor dan semuanya menggunakan URL yang sama.

---

# 13. Validasi GPS

Koordinat kantor:

```text
Latitude  : 0.557333
Longitude : 123.056250
```

Radius:

```text
50 meter
```

Saat absensi:

1. Sistem meminta izin lokasi;
2. mengambil posisi perangkat;
3. menghitung jarak ke kantor;
4. memastikan jarak ≤ 50 meter.

Jika ≤50 meter:

```text
Absensi dapat dilanjutkan.
```

Jika >50 meter:

```text
Absensi ditolak.
```

Contoh tampilan:

```text
Jarak Anda:
+23 meter

✓ Anda berada dalam area absensi
```

GPS bukan indikator IKP.

GPS hanya digunakan sebagai validasi teknis absensi.

---

# 14. Foto Absensi

Setiap absensi wajib menggunakan foto.

Berlaku untuk:

* Datang;
* Pulang.

Foto harus diambil langsung melalui kamera perangkat.

Pegawai tidak dapat memilih foto dari galeri.

Maksimal ukuran:

```text
5 MB
```

Foto disimpan menggunakan Laravel Storage.

Admin dapat melihat foto absensi.

Pegawai tidak perlu melihat kembali foto absensi.

---

# 15. Penyimpanan File

> **Penyesuaian implementasi:** file disimpan langsung ke Laravel Storage (disk public) dari controller; FileStorageService belum dibuat.

Penyimpanan utama:

```text
Laravel Storage
```

Sistem menggunakan abstraction/service:

```text
FileStorageService
```

Tujuannya agar penyimpanan dapat dikembangkan ke Google Drive di kemudian hari tanpa mengubah seluruh sistem.

---

# 16. Aturan Absensi Datang

> **Penyesuaian implementasi:** seluruh jam dan batas absensi dapat diatur melalui Pengaturan Sistem; angka pada PRD ini adalah ketentuan acuan, sedangkan nilai default aplikasi dan nilai aktif ditentukan Admin. Alpha dicatat otomatis oleh scheduler `absensi:alpha` (Senin-Jumat pukul 12:00 WITA) yang melewati hari libur nasional (API) dan pegawai yang pengajuannya masih Menunggu Review.

Senin–Kamis:

| Waktu       | Status            |
| ----------- | ----------------- |
| ≤08:30      | Tepat Waktu       |
| 08:31–09:00 | Terlambat         |
| >09:00      | Tidak dapat absen |

Tidak ada status:

```text
Datang Awal
```

Absensi datang hanya dapat dilakukan satu kali per hari.

Jika sudah melakukan absensi:

> Anda sudah melakukan absensi datang hari ini.

Jika tidak melakukan absensi datang sampai batas yang ditentukan, sistem mencatat Alpha.

---

# 17. Absensi Pulang

Absensi pulang hanya dapat dilakukan jika pegawai sudah melakukan absensi datang.

Senin–Kamis:

| Waktu  | Status            |
| ------ | ----------------- |
| <16:00 | Pulang Lebih Awal |
| ≥16:00 | Pulang            |
| >18:00 | Tidak dapat absen |

Absensi pulang hanya satu kali.

Jika pegawai tidak melakukan absensi pulang setelah melakukan absensi datang:

```text
Status = Incomplete
```

Pegawai tetap dianggap Hadir dan tidak otomatis menjadi Alpha.

---

# 18. Jumat

Absensi Jumat menggunakan status:

```text
Pulang
```

Jadwal Jumat dapat diatur melalui Pengaturan Sistem.

---

# 19. Status Absensi

> **Penyesuaian implementasi:** status pulang pada aplikasi adalah Tepat Waktu dan Pulang Cepat (setara Pulang dan Pulang Lebih Awal). Status Incomplete belum diimplementasikan.

Status sistem:

```text
Tepat Waktu
Terlambat
Pulang Lebih Awal
Pulang
Incomplete
Alpha
Izin
Sakit
Cuti
Dinas Luar
```

---

# 20. Akses dari Luar Kantor

Pegawai dapat mengakses sistem dari mana saja untuk:

* login;
* dashboard;
* riwayat;
* kegiatan;
* pengajuan;
* kinerja;
* pelanggaran/SP.

Namun absensi tetap hanya dapat dilakukan dalam radius 50 meter.

---

# 21. Modul Kegiatan Pegawai

> **Penyesuaian implementasi:** foto bukti kegiatan bersifat opsional dengan ukuran maksimal 3 MB.

Pegawai dapat membuat laporan kegiatan.

Data:

```text
Tanggal
Nama Kegiatan
Deskripsi
Foto Bukti
Waktu Pengiriman
```

Foto wajib.

Maksimal:

```text
5 MB
```

Laporan kegiatan tidak wajib dibuat setiap hari.

Tidak membuat laporan kegiatan tidak otomatis menghasilkan nilai produktivitas 0.

---

# 22. Syarat Membuat Laporan Kegiatan

Pegawai normal:

```text
Harus sudah melakukan absensi datang.
```

Pegawai dengan status Dinas Luar:

```text
Dapat membuat laporan kegiatan tanpa absensi datang.
```

---

# 23. Penilaian Produktivitas Otomatis

Admin tidak mengisi nilai produktivitas secara manual.

Produktivitas dihitung sistem secara otomatis berdasarkan data laporan kegiatan yang dibuat oleh pegawai.

Sistem menggunakan empat subindikator berbobot:

### 23.1 Kelengkapan Laporan — 25%

Menilai kelengkapan isian laporan yang mencakup 4 elemen:
* Nama kegiatan;
* Deskripsi rincian kegiatan;
* Tanggal pelaksanaan kegiatan;
* Foto bukti kegiatan.

Masing-masing elemen bernilai 25 poin (total skor kelengkapan 0–100).

### 23.2 Bukti Kegiatan — 25%

Menilai keberadaan dan validitas berkas foto bukti kegiatan yang diunggah:
* Memiliki foto bukti: 100 poin;
* Tanpa foto bukti: 0 poin.

### 23.3 Ketepatan Waktu Pelaporan — 20%

Menilai kesesuaian waktu pelaporan terhadap tanggal kegiatan:
* Dilaporkan pada hari pelaksanaan (hari H): 100 poin;
* Dilaporkan selambat-lambatnya 1 hari setelah kegiatan (H+1): 50 poin;
* Terlambat lebih dari 1 hari (> H+1): 0 poin.

### 23.4 Jumlah Kegiatan — 30%

Dihitung berdasarkan rasio kumulatif kegiatan yang dilaporkan terhadap target standar periode bulanan (target acuan: 20 kegiatan per bulan):
* Skor = min(100, (Jumlah Kegiatan / Target Kegiatan) × 100).

Contoh:

```text
Target = 20 kegiatan
Realisasi = 18 kegiatan

Skor Rasio = (18 / 20) × 100 = 90
Kontribusi ke Total = 90 × 30% = 27
```

### Formula Total Produktivitas:

```text
Produktivitas = (Kelengkapan × 0,25) + (Bukti × 0,25) + (Ketepatan Waktu × 0,20) + (Jumlah Kegiatan × 0,30)
```

Skor total berada pada rentang 0–100 dan dihitung otomatis saat laporan dibuat atau diperbarui.

---

# 24. Kategori Produktivitas

|  Nilai | Kategori    |
| -----: | ----------- |
| 90–100 | Sangat Baik |
|  80–89 | Baik        |
|  70–79 | Cukup       |
|    <70 | Kurang      |

Sistem otomatis memberikan kategori tersebut.

---

# 25. Admin — Laporan Kegiatan

Admin membuka:

```text
Laporan Kegiatan
```

Tampilan berupa daftar laporan pegawai.

Contoh:

| Pegawai | Kegiatan   | Tanggal  | Produktivitas | Kualitas | Status        |
| ------- | ---------- | -------- | ------------: | -------: | ------------- |
| Andi    | Rekap Data | 08/09/26 |            92 |       88 | Dinilai       |
| Budi    | Monitoring | 08/09/26 |            84 |        — | Belum Dinilai |
| Citra   | Input Data | 07/09/26 |            76 |       80 | Dinilai       |

Produktivitas ditampilkan otomatis.

---

# 26. Penilaian Kualitas Kerja

> **Penyesuaian implementasi:** laporan kegiatan memiliki status verifikasi (Menunggu Review, Disetujui, Ditolak) yang diisi Admin bersama nilai kualitas; hanya laporan berstatus Disetujui diperhitungkan dalam IKP.

Admin tidak memiliki menu "Penilaian Khusus".

Penilaian kualitas dilakukan langsung dari laporan kegiatan.

Admin membuka:

```text
Detail Laporan Kegiatan
```

Kemudian melihat:

* pegawai;
* kegiatan;
* deskripsi;
* foto bukti;
* skor produktivitas otomatis.

Di bagian bawah:

```text
Kualitas Kerja

Nilai:
[ 0–100 ]

Catatan:
[........................]
```

Admin menyimpan nilai kualitas.

---

# 27. Kualitas Kerja

Kualitas kerja dinilai berdasarkan laporan dan bukti pekerjaan.

Skala:

```text
0–100
```

Kategori:

```text
90–100 → Sangat Baik
80–89  → Baik
70–79  → Cukup
<70    → Kurang
```

Kualitas kerja merupakan satu-satunya komponen IKP yang membutuhkan penilaian Admin.

---

# 28. Perhitungan IKP

> **Implementasi sistem:** Nilai kehadiran dihitung dengan formula `max(0, 100 - (5 × jumlah Alpha) - (2 × jumlah Terlambat))` per bulan. Produktivitas dihitung dari rata-rata skor produktivitas laporan yang disetujui (bobot 25%). Kualitas dihitung dari rata-rata nilai kualitas yang diberikan Admin pada laporan yang disetujui (bobot 15%). Jika terdapat laporan kegiatan yang belum dinilai kualitasnya atau belum diverifikasi oleh Admin, status IKP secara konsisten ditandai sebagai **'Belum Lengkap'**. Snapshot IKP disimpan secara idempoten menggunakan metode update-or-create per periode bulanan pada tabel `skor_kinerja` (`performance_scores`).

Setelah data tersedia:

```text
Kehadiran
      +
Produktivitas
      +
Kualitas
      ↓
Perhitungan IKP
```

Rumus:

```text
IKP =
(Kehadiran × 0,60)
+
(Produktivitas × 0,25)
+
(Kualitas × 0,15)
```

Jika terdapat laporan yang belum diverifikasi atau belum dinilai Admin:

```text
Status IKP = Belum Lengkap
```

Sistem tidak membuat nilai kualitas secara otomatis; penilaian kualitas tetap merupakan wewenang Admin.

---

# 29. Modul Pengajuan

Jenis pengajuan:

* Izin;
* Sakit;
* Cuti;
* Perjalanan Dinas.

## Izin

Diterima sesuai aturan sistem.

## Sakit

Diterima sesuai aturan sistem.

## Cuti

Membutuhkan persetujuan Admin dan dokumen/SK.

## Perjalanan Dinas

Membutuhkan persetujuan Admin dan dokumen/SK.

Pengajuan yang sah tidak dihitung sebagai Alpha.

Status absensi mengikuti jenis pengajuan:

```text
Izin
Sakit
Cuti
Dinas Luar
```

---

# 30. Modul Kinerja Pegawai

Menu:

```text
Kinerja
```

Menampilkan:

* IKP bulan berjalan;
* nilai kehadiran;
* nilai produktivitas;
* nilai kualitas;
* kategori;
* grafik perkembangan IKP;
* riwayat IKP.

Contoh:

```text
Indeks Kinerja Pegawai

87,25
BAIK

Kehadiran       90
Produktivitas   85
Kualitas        80
```

---

# 31. Modul Pelanggaran / SP

Pegawai dapat melihat informasi kedisiplinan dan pelanggaran secara transparan:

* jumlah akumulasi Alpha pada siklus berjalan;
* status peringatan aktif;
* riwayat Surat Peringatan (SP-1, SP-2, SP-3) yang telah **resmi diterbitkan** oleh Admin;
* tautan unduh dokumen PDF Surat Peringatan resmi.

Pegawai **tidak dapat melihat draf SP** yang belum diterbitkan.

---

# 32. Aturan Alpha dan Siklus SP

Alpha merupakan pelanggaran formal ketidakhadiran tanpa keterangan sah yang menjadi dasar penerbitan SP.

Ambang batas (threshold):

```text
3 Alpha → SP-1 (Peringatan Pertama)
6 Alpha → SP-2 (Peringatan Kedua)
9 Alpha → SP-3 (Peringatan Ketiga / Terakhir)
```

Sistem menerapkan siklus SP semi-otomatis:
* Penghitungan Alpha diakumulasikan dalam siklus berjalan.
* Setiap kali akumulasi Alpha mencapai ambang batas (3, 6, atau 9) dan belum ada record SP pada tingkat tersebut, sistem secara otomatis dan idempoten membuat **draf SP**.
* Pembuatan draf tidak menganggap SP telah diterbitkan.

---

# 33. Penerbitan SP

SP bersifat **semiotomatis**: sistem mendeteksi ambang Alpha dan menyiapkan draf, kemudian Admin memverifikasi dan menerbitkan secara resmi.

Alur penerbitan:

```text
Akumulasi Alpha mencapai ambang (3/6/9)
        ↓
Sistem membuat draf SP idempoten (nomor surat kosong)
        ↓
Admin memeriksa draf pada menu Surat Peringatan
        ↓
Admin mengisi nomor surat resmi & tanggal terbit
        ↓
Admin menekan tombol 'Terbitkan SP'
        ↓
SP resmi aktif dan tersimpan (nomor surat terisi)
        ↓
Pegawai dapat melihat SP dan mengunduh PDF resmi
```

Admin dapat:
* memfilter daftar SP (Semua, Draf, Terbit, serta tingkat SP-1/SP-2/SP-3);
* memeriksa alasan dan rincian pelanggaran pegawai;
* mengisi nomor surat agenda dinas dan tanggal penerbitan resmi;
* mengunduh dan mencetak dokumen PDF SP resmi.

Dokumen PDF SP mencakup kop resmi instansi Dinas Perdagangan dan Perindustrian Kota Gorontalo, konsiderans pelanggaran, klausul kewajiban/sanksi, dan tanda tangan pejabat berwenang.

---

# 34. Menu Admin

Menu final:

```text
Dashboard

Data Pegawai

Monitoring Absensi

Laporan Kegiatan

Persetujuan Izin & Cuti

Indeks Kinerja

Surat Peringatan (SP)

Pusat Laporan

Pengaturan Sistem
```

Tidak ada:

```text
Penilaian Khusus
Audit Log
```

---

# 35. Dashboard Admin

Dashboard menampilkan:

### Absensi

* total pegawai;
* hadir;
* terlambat;
* belum absen;
* Alpha.

### Kinerja

* rata-rata IKP;
* Sangat Baik;
* Baik;
* Cukup;
* Kurang.

### Kegiatan

* jumlah laporan;
* laporan belum dinilai kualitasnya;
* rata-rata produktivitas.

### Pengajuan

* menunggu;
* disetujui;
* ditolak.

### SP

* SP terpicu;
* SP1;
* SP2;
* SP3.

---

# 36. Indeks Kinerja Admin

Admin dapat melihat:

* daftar IKP seluruh pegawai;
* filter periode;
* filter pegawai;
* nilai kehadiran;
* nilai produktivitas;
* nilai kualitas;
* nilai akhir;
* kategori.

Admin juga dapat melihat:

### Tren IKP

Perkembangan nilai rata-rata IKP per bulan.

### Perbandingan indikator

```text
Kehadiran
Produktivitas
Kualitas
```

### Distribusi kinerja

```text
Sangat Baik
Baik
Cukup
Kurang
```

---

# 37. Data Pegawai

Admin dapat:

* melihat pegawai;
* menambah pegawai;
* mengubah data;
* melihat detail;
* mengaktifkan/nonaktifkan akun;
* reset password.

Data pegawai:

```text
ID Pegawai
Nama
Nomor HP
Jabatan
Unit/Bagian
Status
Foto
```

---

# 38. Monitoring Absensi

Admin dapat melihat:

* nama pegawai;
* tanggal;
* jam datang;
* status datang;
* jam pulang;
* status pulang;
* jarak absensi;
* foto absensi.

Filter:

* tanggal;
* bulan;
* pegawai;
* status.

---

# 39. Persetujuan Pengajuan

Admin dapat melihat:

* jenis pengajuan;
* pegawai;
* tanggal;
* alasan;
* dokumen;
* status.

Admin dapat:

```text
Setujui
Tolak
Lihat Detail
```

---

# 40. Pusat Laporan

> **Implementasi sistem:** Pusat Laporan menyediakan 4 tab aktif utama yang beroperasi penuh: Laporan Absensi, Laporan Kinerja, Laporan Kegiatan, dan Laporan Surat Peringatan. Masing-masing tab mendukung ekspor berkas valid dalam format **Excel (.xlsx)** dan **PDF (.pdf)** dengan filter periode, bulan, tahun, bidang, atau pegawai.

Tab laporan yang beroperasi penuh:

1. **Laporan Absensi**: rekapitulasi kehadiran harian/bulanan (Hadir, Terlambat, Izin, Cuti, Dinas Luar, Alpha) per pegawai atau bidang (Excel & PDF);
2. **Laporan Kinerja**: rekapitulasi skor kehadiran, produktivitas, kualitas, nilai akhir IKP, dan kategori kinerja (Excel & PDF);
3. **Laporan Kegiatan**: rekapitulasi pelaporan kegiatan pegawai, rincian aktivitas, status persetujuan, dan skor produktivitas (Excel & PDF);
4. **Laporan Surat Peringatan (SP)**: rekapitulasi data pelanggaran disiplin dan daftar SP yang telah diterbitkan (Excel & PDF).

Fitur ekspor pada portal Pegawai:
* Riwayat Absensi (PDF);
* Laporan Kegiatan (PDF);
* Surat Peringatan resmi (PDF).

Seluruh berkas ekspor menghasilkan file biner yang valid (.xlsx dapat dibuka oleh parser spreadsheet dan .pdf memiliki struktur stream yang sah).

---

# 41. Pengaturan Sistem

Admin dapat mengatur:

### Instansi

* nama instansi;
* tahun/periode.

### Lokasi

* latitude;
* longitude;
* radius.

### Absensi

* jam datang;
* batas terlambat;
* batas absensi datang;
* jam pulang;
* batas pulang;
* jadwal Jumat.

### IKP

Bobot default:

```text
Kehadiran       60%
Produktivitas   25%
Kualitas        15%
```

Total wajib:

```text
100%
```

### SP

* template SP;
* format nomor;
* pengaturan dokumen.

---

# 42. Database

> **Penyesuaian implementasi:** nama tabel pada implementasi memakai bahasa Indonesia: users = pengguna, employees = pegawai, attendances = presensi, activity_reports = laporan_kegiatan, leave_requests = pengajuan_izin, performance_scores = skor_kinerja, alpha_records = catatan_alpha, sp_letters = surat_peringatan, office_settings = pengaturan_kantor.

Database dibuat sederhana, normalisasi secukupnya, dan mudah digunakan dalam Laravel Migration.

Tabel utama:

```text
users
employees
attendances
activity_reports
leave_requests
performance_scores
alpha_records
sp_letters
office_settings
```

---

# 43. users

```text
id
employee_id
username
password
role
status
created_at
updated_at
```

Role:

```text
admin
pegawai
```

---

# 44. employees

```text
id
employee_number
name
phone
position
department
photo
status
created_at
updated_at
```

---

# 45. attendances

```text
id
employee_id
date

arrival_time
arrival_status
arrival_distance
arrival_photo

checkout_time
checkout_status
checkout_distance
checkout_photo

status

created_at
updated_at
```

---

# 46. activity_reports

```text
id
employee_id
date
activity_name
description
photo
submitted_at

productivity_score
productivity_category

quality_score
quality_category
quality_note

created_at
updated_at
```

Produktivitas otomatis dihasilkan sistem.

Kualitas diisi Admin dari halaman detail laporan.

---

# 47. leave_requests

```text
id
employee_id
type
start_date
end_date
reason
document
status
admin_note
approved_at
created_at
updated_at
```

---

# 48. performance_scores

```text
id
employee_id
period

attendance_score
productivity_score
quality_score

attendance_weight
productivity_weight
quality_weight

final_score
category
status

created_at
updated_at
```

---

# 49. alpha_records

```text
id
employee_id
date
reason
sp_cycle
created_at
```

---

# 50. sp_letters

```text
id
employee_id
sp_level
alpha_count
letter_number
issue_date
document
status
created_at
updated_at
```

---

# 51. office_settings

```text
id
office_name
latitude
longitude
radius

arrival_time
late_time
arrival_deadline

checkout_time
checkout_deadline

friday_settings

attendance_weight
productivity_weight
quality_weight

sp_template

created_at
updated_at
```

---

# 52. Keamanan

Sistem menggunakan fitur keamanan Laravel:

* authentication;
* authorization;
* password hashing;
* CSRF;
* session management;
* validation;
* role middleware.

Validasi absensi dilakukan di server.

Server memeriksa:

* user;
* waktu server;
* status absensi;
* GPS;
* jarak;
* foto;
* batas waktu;
* duplikasi absensi.

---

# 53. Validasi File

File harus divalidasi berdasarkan:

* extension;
* MIME type;
* ukuran;
* tipe file.

Maksimal:

```text
5 MB
```

---

# 54. Alur Absensi

```text
Login
 ↓
Scan QR
 ↓
Halaman Absensi
 ↓
Pilih Datang/Pulang
 ↓
Validasi GPS
 ↓
≤50 meter?
 ↓
Kamera
 ↓
Ambil Foto
 ↓
Validasi Waktu
 ↓
Validasi Status
 ↓
Simpan
 ↓
Berhasil
```

---

# 55. Alur Produktivitas

```text
Pegawai membuat laporan
        ↓
Sistem memeriksa:
- kelengkapan
- bukti
- ketepatan waktu
- jumlah kegiatan
        ↓
Skor Produktivitas
        ↓
Kategori
        ↓
Ditampilkan kepada Admin
```

Admin tidak memasukkan skor produktivitas secara manual.

---

# 56. Alur Kualitas

```text
Pegawai membuat laporan
        ↓
Laporan masuk Admin
        ↓
Admin membuka detail
        ↓
Melihat kegiatan + bukti
        ↓
Admin memberikan nilai kualitas
        ↓
Simpan
```

Penilaian kualitas dilakukan langsung pada laporan kegiatan.

Tidak ada menu:

```text
Penilaian Khusus
```

---

# 57. Alur IKP

```text
Data Absensi
      ↓
Kehadiran & Ketepatan Waktu
      ↓
     60%

Laporan Kegiatan
      ↓
Produktivitas Otomatis
      ↓
     25%

Penilaian Kualitas
      ↓
     15%

      ↓
     IKP
      ↓
0–100
      ↓
Kategori
```

---

# 58. Prinsip Penting Sistem

### GPS

Bukan indikator kinerja.

### QR

Bukan indikator kinerja.

### Foto

Bukan indikator kinerja.

### Alpha

Merupakan data pelanggaran dan dasar SP.

### Laporan kegiatan

Merupakan sumber data produktivitas dan bukti untuk penilaian kualitas.

### IKP

Merupakan hasil penggabungan:

```text
Kehadiran
+
Produktivitas
+
Kualitas
```

---

# 59. Teknologi

Backend:

```text
PHP
Laravel
```

Frontend:

```text
HTML5
Tailwind CSS
Vanilla JavaScript
```

Database:

```text
MySQL
```

Development:

```text
Laragon
```

File:

```text
Laravel Storage
```

Browser API:

```text
Geolocation API
Camera API
```

Export:

```text
Excel
PDF
```

---

# 60. Tailwind CSS

> **Penyesuaian implementasi:** implementasi memakai Tailwind CSS 4 melalui plugin Vite (@tailwindcss/vite) dengan build lokal, bukan Tailwind CLI mandiri, dan tidak memakai CDN Tailwind. Chart.js dan SweetAlert2 dimuat dari CDN. Foto absensi diambil melalui input file dengan atribut capture, bukan Camera API (getUserMedia).

Tailwind wajib menggunakan CLI.

Instalasi:

```bash
npm install tailwindcss @tailwindcss/cli
```

Input:

```css
@import "tailwindcss";
```

Build:

```bash
npx @tailwindcss/cli -i ./src/input.css -o ./src/output.css --watch
```

Tidak diperbolehkan menggunakan:

```text
cdn.tailwindcss.com
@tailwindcss/browser
Tailwind Play CDN
```

---

# 61. Struktur Frontend

Frontend yang sudah tersedia digunakan sebagai dasar implementasi.

Tidak perlu membuat ulang seluruh UI.

Perubahan utama:

1. Mengganti "Kedisiplinan" menjadi "Kinerja";
2. Menghapus "Penilaian Khusus" dari navigasi;
3. Memindahkan penilaian kualitas ke Detail Laporan Kegiatan;
4. Menampilkan skor produktivitas otomatis;
5. Menampilkan IKP berdasarkan tiga indikator;
6. Menyesuaikan istilah "Indeks Kedisiplinan" menjadi "Indeks Kinerja Pegawai";
7. Menghapus konsep penilaian "Perilaku dan Sikap" dari sistem.

---

# 62. Acceptance Criteria

Sistem dianggap memenuhi kebutuhan apabila:

### Login

* Admin dapat login;
* Pegawai dapat login;
* maksimal 3 percobaan salah;
* Admin tidak dapat melihat password lama.

### Absensi

* QR membuka halaman absensi;
* GPS wajib aktif;
* radius maksimal 50 meter;
* foto wajib;
* foto hanya dari kamera;
* absensi datang satu kali;
* absensi pulang satu kali;
* pulang tanpa datang ditolak.

### Kegiatan

* Pegawai dapat membuat laporan;
* foto bukti wajib;
* sistem menghitung produktivitas otomatis;
* Admin melihat hasil produktivitas;
* Admin dapat memberikan nilai kualitas langsung dari laporan.

### IKP

* sistem menghitung nilai kehadiran;
* sistem menghitung produktivitas;
* Admin menilai kualitas;
* sistem menghitung IKP;
* sistem menentukan kategori;
* IKP tersimpan per bulan.

### SP

* Alpha tercatat;
* threshold SP dapat diketahui;
* Admin mendapat notifikasi;
* Admin menerbitkan SP;
* pegawai dapat melihat SP.

### Laporan

* laporan dapat difilter;
* Excel tersedia;
* PDF tersedia.

---

# 63. Ringkasan Sistem

```text
                    SISTEM
                       │
          ┌────────────┴────────────┐
          │                         │
        ADMIN                    PEGAWAI
          │                         │
          ├── Data Pegawai          ├── Dashboard
          ├── Absensi               ├── Riwayat Absensi
          ├── Laporan Kegiatan      ├── Kegiatan
          ├── Pengajuan             ├── Pengajuan
          ├── IKP                   ├── Kinerja
          ├── SP                    ├── Pelanggaran/SP
          ├── Laporan               └── Profil
          └── Pengaturan
                       │
                       ↓
                INDEKS KINERJA
                       │
       ┌───────────────┼───────────────┐
       ↓               ↓               ↓
   Kehadiran       Produktivitas    Kualitas
      60%              25%             15%
       │                │                │
    Otomatis         Otomatis          Admin
       │           dari laporan       menilai
       └───────────────┼───────────────┘
                       ↓
                 IKP 0–100
                       ↓
          Sangat Baik / Baik /
             Cukup / Kurang
```

# 64. Referensi Landasan

1. Nawir, M., Bachtiar, R. A., & Afifah, S. R. (2024). **Indikator Disiplin Kerja**. *Didaktik: Jurnal Ilmiah PGSD STKIP Subang*, 10(03), 301–320. DOI: 10.36989/didaktik.v10i03.4451.

2. Azmi, C., Mustafa, D., & Juharni. (2025). **Analisis Disiplin Kerja Aparatur Sipil Negara Pada Dinas Pekerjaan Umum Kota Makassar**. *Paradigma Journal of Administration*, 3(1), 29–33. DOI: 10.35965/pja.v3i1.6019.

3. Hayati, H. N., Suharyanti, N., & Al Rasyid, H. (2025). **Penilaian Loyalitas Karyawan Berdasarkan Kedisiplinan Kerja Menggunakan Metode AHP (Studi Kasus pada PT Finansia Multi Finance)**. Penelitian tersebut menggunakan kelompok Absensi, Kinerja, dan Ketaatan dengan bobot 0,625; 0,238; dan 0,136.

4. Febriansyah, R., Harahap, U. N., & Walady, D. (2024). **Analisis Penilaian Kinerja Karyawan Menggunakan Metode AHP dan Fuzzy TOPSIS pada PT. XYZ**. *Integrasi: Jurnal Ilmiah Teknik Industri*, 9(1). Penelitian menggunakan kehadiran dan kualitas kerja sebagai kriteria penilaian kinerja.

---

# 65. Catatan Revisi & Penyesuaian Fitur
1. **Pembaruan Kolom Identitas Pegawai**: Penamaan NIK diubah menjadi NIP (Nomor Induk Pegawai) untuk relevansi administrasi PPPK.
2. **Kategori Bidang Resmi**: Sistem secara ketat hanya menggunakan 4 bidang instansi: Perindustrian, Perdagangan, Sekretariat, dan Perlindungan Konsumen.
3. **Otomatisasi dan Siklus Surat Peringatan (SP)**: SP diimplementasikan secara semiotomatis dengan ambang 3 Alpha (SP-1), 6 Alpha (SP-2), dan 9 Alpha (SP-3). Sistem menghasilkan draf idempoten saat ambang tercapai, dan Admin memverifikasi serta menerbitkan dengan mengisi nomor surat dinas. Pegawai hanya dapat mengakses SP yang telah diterbitkan.
4. **Formula 4 Subindikator Produktivitas**: Produktivitas dihitung otomatis dari laporan kegiatan berdasarkan kelengkapan (25%), keberadaan bukti kegiatan (25%), ketepatan waktu pelaporan hari H/H+1 (20%), dan rasio target bulanan (30%).
5. **Status IKP 'Belum Lengkap' dan Snapshot Historis**: IKP menerapkan status 'Belum Lengkap' jika terdapat laporan kegiatan yang belum diverifikasi/dinilai kualitasnya oleh Admin. Snapshot bulanan disimpan secara idempoten pada tabel `skor_kinerja` (`performance_scores`).
6. **Pusat Laporan & Ekspor Utuh**: Seluruh tombol ekspor pada 4 tab Pusat Laporan (Absensi, Kinerja, Kegiatan, SP) dan panel Pegawai telah terhubung penuh ke controller ekspor dan menghasilkan berkas Excel (.xlsx) dan PDF (.pdf) yang valid dan dapat dibuka.
