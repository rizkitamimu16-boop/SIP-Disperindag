# Analisis Kesiapan Laporan Kerja Praktek – SIP-PERFORMA

Tanggal analisis: 28 Okt 2026. Tahap ini **hanya membaca**. Tidak ada kode, database, PRD, atau dokumen laporan yang diubah. Tidak ada draf bab baru.

## 0. Status Pembacaan Sumber

| # | Berkas | Status | Catatan |
|---|---|---|---|
| 1 | `Panduan Kampus.md` | Terbaca penuh (834 baris) | Acuan utama |
| 2 | `Contoh Laporan Kaka Tingkat.md` | Terbaca (awal–Bab II, Bab IV–lampiran; Bab III dibaca lewat daftar isi) | Referensi pola saja |
| 3 | `Hasil Analisa Project.md` | **Kosong (0 byte)** | Tidak ada isi untuk dianalisis |
| 4 | `Laporan Magang Saya.md` | Terbaca penuh (67 baris) | Draf baru sampai Bab II |
| 5a | `04-hasil-analisis-project/audit-kode-aplikasi.md` | Terbaca penuh (524 baris) | Pengganti `Hasil Analisa Project.md` sebagai sumber fakta proyek |
| 5b | `04-hasil-analisis-project/analisis-referensi.md` | Terbaca penuh (84 baris) | Analisis tahap sebelumnya; sebagian sudah kedaluwarsa (kode kini sudah diaudit) |

> [!IMPORTANT]
> `Hasil Analisa Project.md` kosong. Seluruh fakta proyek dalam analisis ini bersumber dari `audit-kode-aplikasi.md`. Perlu konfirmasi apakah berkas itu memang sengaja kosong (lihat bagian 6).

---

## 1. Sistematika Laporan Sesuai Panduan Kampus

### 1.1 Struktur isi (Panduan §2.1)

**A. Bagian Awal**: Halaman Sampul; Halaman Logo; Halaman Judul (sama dengan sampul); Halaman Pengesahan; Kata Pengantar; Daftar Isi; Daftar Tabel; Daftar Gambar; Daftar Lampiran; Daftar Lainnya.

**B. Bagian Inti**

| Bab | Subbab wajib |
|---|---|
| BAB I Pendahuluan | 1.1 Sekilas instansi; 1.2 Sejarah; 1.3 Visi dan Misi; 1.4 Struktur organisasi; 1.5 Deskripsi tugas instansi |
| BAB II Gambaran Sistem Informasi dan Teknologi Informasi Organisasi | 2.1 Deskripsi Sistem dan TI (narasi **dan** pemetaan/arsitektur); 2.2 Analisis Implementasi Sistem (analisis proses bisnis yang belum berjalan baik dan perlu dikembangkan) |
| BAB III Hasil Kerja Praktik | Pengembangan SI: evaluasi, desain jaringan, perancangan/implementasi sistem (subbab tidak dirinci panduan) |
| BAB IV Penutup | 4.1 Kesimpulan; 4.2 Saran |

**C. Bagian Akhir**: Daftar Pustaka; Lampiran (Log Kegiatan; Surat Keterangan diterima KP; Surat Keterangan selesai KP; Tabel Kegiatan KP per mahasiswa; Lembar Konsultasi Bimbingan per kelompok; Sumber Dokumen).

### 1.2 Format penulisan (Panduan §2.2–2.4)

| Aspek | Ketentuan |
|---|---|
| Kertas | A4, 70 gram |
| Margin | Kanan & atas 3 cm; bawah & kiri 4 cm |
| Spasi | 2 spasi |
| Font | Times New Roman |
| Judul bab | Angka Romawi, tengah, HURUF BESAR, 14 pt, tebal |
| Subbab | Angka latin mengacu nomor bab (2.1, 2.2.1), rata kiri, awal huruf besar, 12 pt, tebal |
| Nomor halaman – bagian awal | Romawi kecil (i, ii, …), tengah bawah (2 cm dari bawah). Sampul & pengesahan dihitung tetapi nomor tidak diketik |
| Nomor halaman – inti | Latin; Bab I hlm. 1. Awal bab: tengah bawah; halaman lain: pojok kanan atas |
| Nomor halaman – akhir | Tengah bawah, lanjutan penomoran inti |
| Gambar/grafik | Judul di **bawah tengah**; nomor per bab (Gambar 3.1) |
| Tabel | Judul di **atas kiri**; nomor per bab |
| Sampul | Judul TNR 18 center; "KERJA PRAKTEK" TNR 16; penyusun (Nama, NIM) TNR 14; logo; "PROGRAM STUDI SISTEM INFORMASI / FAKULTAS TEKNIK / UNIVERSITAS NEGERI GORONTALO / tahun" |
| Cetak | 1 rangkap untuk perpustakaan fakultas; hard cover biru muda; softcopy (laporan, slide, aplikasi) PDF di CD |
| Penyerahan | Ditandatangani pembimbing, disahkan Prodi (stempel), diserahkan ke perpustakaan; CD ke prodi |
| Pengesahan | Format: judul, nama organisasi, alamat, waktu pelaksanaan, mahasiswa (nama/NIM), Pembimbing 1 & 2, Kaprodi |

### 1.3 Ketentuan lain yang relevan
- KP 4 SKS, durasi ±1,5 bulan (45 hari), dibuktikan absensi dan log harian/mingguan.
- Penilaian seminar: Analisis 40%, Pemrograman 30%, Penulisan laporan 20%, Presentasi 10%; nilai akhir = 70% pembimbing + 30% pendamping lapangan.
- Formulir pendukung: KP-1 s.d. KP-7 (kesediaan, persetujuan, tabel kegiatan, konsultasi, pengajuan seminar, berita acara & penilaian, presensi seminar min. 10 peserta).

### 1.4 Hal yang **tidak** diatur panduan
- Gaya sitasi di dalam teks dan format Daftar Pustaka (tidak ada).
- Ukuran/format gambar, aturan Daftar Lainnya, batas halaman.
- Subbab Bab III (hanya disebut: evaluasi, desain jaringan, perancangan/implementasi).
- Format Bab: contoh senior memakai gaya APA ringan; **belum ada aturan resmi**, perlu keputusan/konfirmasi dosen pembimbing.

### 1.5 Ketidakrapian internal panduan (tidak diikuti)
Daftar isi panduan: subbab 1.3 tertulis hlm. 1; nomor 1.7 ganda (seharusnya 1.9). Panduan menyebut tahun 2020. Isi aturan tetap dipakai.

---

## 2. Ringkasan Isi dan Fungsi Dokumen Sumber

| Dokumen | Isi | Fungsi untuk laporan | Keterbatasan |
|---|---|---|---|
| **Panduan Kampus** | Aturan KP, sistematika, format, formulir KP-1–7 | Acuan utama struktur & format | Tanpa aturan sitasi; subbab Bab III terbuka |
| **Contoh Laporan Kaka Tingkat** (AgriSched, UNG, 2025) | Sampul ganda, Kata Pengantar, Daftar Isi/Tabel/Gambar, Bab I–IV, Daftar Pustaka (7 entri), Lampiran (log, tabel kegiatan, lembar asistensi) | Pola Bab III dan gaya narasi; contoh lampiran | Ada kesalahan (lihat 2.1). Jangan menyalin isi/identitas |
| **Hasil Analisa Project** | Kosong | – | Belum ada |
| **Laporan Magang Saya** | Sampul, Bab I (1.1–1.5), Bab II (2.1 SP2KP & SIHALAL; 2.2 analisis) | Draf dasar | Belum lengkap & ada inkonsistensi (bagian 3) |
| **audit-kode-aplikasi.md** | Teknologi, arsitektur, peran, 24 fitur beserta status, tabel DB, alur, temuan F-01–F-16, status uji, DB aktif, git | Sumber fakta proyek (kode, DB, uji) | Bukan hasil uji jalan; unit test belum dijalankan |
| **analisis-referensi.md** | Ringkasan panduan, kondisi draf, daftar kebutuhan | Pendahulu analisis ini | Sebagian sudah terjawab oleh audit kode |

### 2.1 Pola dari contoh senior yang layak dipakai
- Sampul → Judul ulang → Kata Pengantar (ucapan terima kasih bernomor) → Daftar Isi, Tabel, Gambar.
- Bab II: tabel definisi konsep (dengan sitasi), uraian tiap sistem + tangkapan layar, analisis proses berjalan dan **Cross Functional Flowchart** (Gambar 2.4).
- Bab III: 3.1 Proses bisnis usulan (flowchart usulan); 3.2 Pemodelan (external entity, diagram konteks, hierarchy chart, DAD level 0 & 1); 3.3 Desain database; 3.4–3.6 Tampilan sistem per peran.
- Bab IV: kesimpulan dan saran (saran untuk instansi dan pengembang lanjutan).
- Lampiran: Log kegiatan, Tabel kegiatan KP, Lembar asistensi.

### 2.2 Yang **tidak** boleh ditiru dari contoh
- "Universitas Gorontalo" (seharusnya Universitas Negeri Gorontalo); sampul ganda dengan nama sama.
- Penomoran kacau (3.3.1 di bawah 3.4, dll), salah rujuk gambar, typo, daftar gambar/halaman tidak sinkron.
- Daftar pustaka dengan entri kurang lengkap (mis. tanpa penerbit/jurnal; huruf kapital semua; tahun 2000 tanpa sumber jelas). Jangan dijadikan model; jangan memakai ulang referensinya tanpa memeriksa aslinya.
- Judul "1.1 Jurusan..." dan bagian lampiran berorientasi MBKM (lembar asistensi) tidak serta-merta sama dengan KP prodi SI.
- Sejarah instansi terlalu panjang dan lebih menyangkut fakultas; ambil hanya pola, bukan isi.

---

## 3. Pemetaan Draf Saat Ini terhadap Struktur Wajib

Legenda: ✅ sesuai | ⚠️ perlu revisi | ❌ belum ada

| Bagian wajib | Status | Kondisi di draf | Catatan |
|---|---|---|---|
| Halaman Sampul | ⚠️ | Ada: judul, "KERJA PRAKTEK", 2 penyusun (nama + NIM), prodi/fakultas/universitas, 2026 | Judul memakai "Perindustrian dan Perdagangan" (nama instansi benar: *Perdagangan dan Perindustrian*). Logo belum ada. Format font/ukuran belum bisa diverifikasi dari Markdown |
| Halaman Logo | ❌ | – | Perlu berkas logo UNG |
| Halaman Judul | ❌ | – | Salinan sampul |
| Halaman Pengesahan | ❌ | – | Butuh data pembimbing, periode, dll |
| Kata Pengantar | ❌ | – | |
| Daftar Isi / Tabel / Gambar / Lampiran | ❌ | – | Perlu disusun terakhir |
| **BAB I** | | | Penulisan "BAB 1" harus "BAB I" |
| 1.1 Sekilas instansi | ✅/⚠️ | 3 paragraf, relevan | Judul subbab "Dinas Perdagangan dan Perindustrian Kota Gorontalo" dapat dipertahankan; periksa klaim tugas dengan sumber resmi |
| 1.2 Sejarah | ⚠️ | Narasi kabinet 1945–1950, UU 32/2004, Perda 5/2016, alamat | Bagian awal (kabinet) agak jauh dari instansi; sumber (Perda/UU) perlu dikutip di Daftar Pustaka dan diverifikasi. Nomor UU 12/2008 "Perubahan Kedua" perlu dicek |
| 1.3 Visi dan Misi | ⚠️ | Visi "KOTA JASA" (karakter rusak); Misi dan Tujuan dinomori berlanjut 1–3 | Perbaiki encoding; pisahkan Misi (1) dan Tujuan (1–2) |
| 1.4 Struktur organisasi | ⚠️ | 1 paragraf, tanpa gambar | Perlu Gambar 1.1 (bagan resmi) |
| 1.5 Deskripsi tugas | ⚠️ | Tugas 7 unit, lalu paragraf tentang SIP-PERFORMA | Bagian tugas unit sesuai panduan; paragraf SIP-PERFORMA lebih tepat jadi **latar belakang/tujuan KP** (lihat bagian 4) |
| **BAB II** | | | Heading "BAB 2" dan tanpa nomor 2.1/2.2 |
| 2.1 Deskripsi Sistem dan TI | ⚠️ | SP2KP dan SIHALAL (narasi) + Gambar 2.1, 2.2 (gambar belum ada di file) | Belum ada **pemetaan/arsitektur** TI instansi (wajib). Penomoran 2.1.1/2.1.2 belum ada. Gaya contoh memuat landasan teori + sitasi |
| 2.2 Analisis Implementasi Sistem | ❌ **Inkonsisten** | Membahas "Sistem Informasi Manajemen Verifikasi Status Operasional IKM Berbasis Kelurahan" | **Tidak sesuai proyek** (SIP-PERFORMA: absensi & kinerja P3K). Harus ditulis ulang berbasis fakta absensi/kinerja yang dikonfirmasi pengguna |
| Rujukan gambar | ⚠️ | "Gambar 2.2 berikut" untuk flowchart, padahal gambarnya "Gambar 2.3" | Perbaiki rujukan |
| **BAB III** | ❌ | – | Bahan tersedia di audit kode (bagian 5) |
| **BAB IV** | ❌ | – | Bergantung pada Bab III dan hasil uji |
| Daftar Pustaka | ❌ | – | Draf menyebut UU, Perda, RPJMD, RENSTRA tanpa daftar rujukan |
| Lampiran | ❌ | – | Semua |

### Kekuatan draf yang dipertahankan
- Struktur Bab I–II sudah mengikuti panduan; isi 1.1–1.5 relevan dan fokus pada Disperindag.
- Deskripsi tugas unit dan nama instansi di isi sudah benar (15 kemunculan, menurut audit).
- Penyebutan SP2KP dan SIHALAL sudah memberi konteks sistem yang sudah ada.

### Isu Format yang tidak bisa dinilai dari Markdown
Font, margin, spasi, penomoran halaman romawi/latin, penempatan judul gambar/tabel. Perlu diterapkan ketika dokumen diekspor ke Word/PDF.

---

## 4. Daftar Perubahan yang Disarankan

### 4.1 Ditambahkan
| Item | Alasan |
|---|---|
| Halaman Logo, Judul, Pengesahan, Kata Pengantar, Daftar Isi/Tabel/Gambar/Lampiran | Wajib (§2.1.A) |
| Gambar 1.1 Struktur Organisasi | Pendukung 1.4 |
| Pemetaan/arsitektur sistem & TI instansi di 2.1 | Wajib (§2.1.B Bab II). Isi hanya dari fakta yang dikonfirmasi |
| Flowchart/CFF proses berjalan (absensi & kinerja P3K) | Mengikuti pola contoh dan klaim draf; gambar belum ada |
| BAB III penuh (lihat kerangka bagian 5) | Wajib dan inti penilaian (Analisis 40%, Pemrograman 30%) |
| BAB IV Kesimpulan dan Saran | Wajib |
| Daftar Pustaka | Wajib |
| Lampiran (log, surat diterima/selesai, tabel kegiatan, lembar konsultasi, sumber dokumen) | Wajib |
| Uraian keterbatasan/temuan implementasi (mis. F-01 SP, F-02 produktivitas) di Bab III/IV | Kejujuran akademik; pengguna menetapkan PRD sebagai acuan final, penanganan selisih menunggu keputusan |

### 4.2 Direvisi
| Item | Revisi | Alasan |
|---|---|---|
| Judul sampul | Samakan nama instansi: "Dinas Perdagangan dan Perindustrian Kota Gorontalo" | F-13; konsistensi |
| "BAB 1", "BAB 2" | "BAB I", "BAB II" | Panduan §2.2 |
| 1.3 Visi dan Misi | Perbaiki karakter "KOTA JASA"; pisahkan Misi dan Tujuan | Encoding & penomoran |
| 1.2 Sejarah | Persingkat bagian kabinet 1945–1950; tambahkan sitasi sumber hukum | Relevansi & verifikasi |
| 1.4 | Tambahkan gambar bagan + keterangan | Kelengkapan |
| 2.1 | Tambah penomoran 2.1.1 (SP2KP), 2.1.2 (SIHALAL), dan pemetaan TI | Panduan |
| 2.2 | Tulis ulang berdasar masalah absensi & evaluasi kinerja P3K | Inkonsistensi dengan SIP-PERFORMA |
| Rujukan gambar | Gambar 2.2 → 2.3 untuk flowchart | Kesalahan rujukan |
| Nama bidang | Samakan nama bidang di laporan dengan struktur resmi dan dengan aplikasi (Industri/Perindustrian, PK/Perlindungan Konsumen[dan Kemetrologian]) | Audit bagian 14.2 |

### 4.3 Dipindahkan
| Item | Dari → Ke | Alasan |
|---|---|---|
| Paragraf "Dalam kegiatan Kerja Praktek ini... SIP-PERFORMA..." | 1.5 → paragraf pembuka Bab III (atau latar belakang di 1.5 secara singkat) | Panduan 1.5 hanya deskripsi tugas **instansi**; contoh senior mencampur, tetapi panduan diutamakan |
| Fakta/flowchart usulan | – → Bab III | Bukan bagian Bab II |

### 4.4 Dihapus / tidak dipakai (usulan; menunggu persetujuan)
| Item | Alasan |
|---|---|
| Seluruh narasi IKM/kelurahan di 2.2 (paragraf 60–62 draf) | Tidak terkait proyek; berasal dari objek lain. **Disarankan diarsipkan di berkas terpisah, bukan dibuang** sebelum Anda setuju |
| Pernyataan "real-time", "otomatis" yang tidak didukung bukti | Hindari klaim tak terverifikasi |

Tidak ada bagian yang dihapus pada tahap ini.

---

## 5. Usulan Kerangka Laporan Final

> Kerangka ini bersifat usulan; isi hanya akan memakai fakta yang tersedia/dikonfirmasi. Tanda **[F]** = fakta sudah ada di audit; **[K]** = perlu konfirmasi/bahan dari pengguna.

### Bagian Awal
1. Halaman Sampul (TNR 18/16/14, logo) **[K logo]**
2. Halaman Logo
3. Halaman Judul
4. Lembar Pengesahan **[K]**
5. Kata Pengantar **[K]**
6. Daftar Isi, Daftar Tabel, Daftar Gambar, Daftar Lampiran
7. Daftar Lainnya (singkatan/istilah, opsional)

### Bagian Inti
**BAB I PENDAHULUAN**
1.1 Sekilas Instansi · 1.2 Sejarah · 1.3 Visi dan Misi · 1.4 Struktur Organisasi (Gambar 1.1) · 1.5 Deskripsi Tugas Instansi

**BAB II GAMBARAN SISTEM INFORMASI DAN TEKNOLOGI INFORMASI ORGANISASI**
2.1 Deskripsi Sistem dan Teknologi Informasi
 2.1.1 SP2KP (Gambar 2.1) · 2.1.2 SIHALAL (Gambar 2.2) · 2.1.3 Pemetaan/Arsitektur SI & TI instansi (Gambar/Tabel) **[K]**
2.2 Analisis Implementasi Sistem
 Kondisi absensi dan evaluasi kinerja P3K sebelum sistem, masalah, pihak terlibat, flowchart berjalan (Gambar 2.3) **[K, wajib dari pengguna]**

**BAB III HASIL KERJA PRAKTIK**
3.1 Evaluasi dan Latar Belakang Pengembangan (tujuan KP, masalah, kebutuhan) **[F+K]**
3.2 Analisis Kebutuhan Sistem
 3.2.1 Kebutuhan fungsional per peran (admin, pegawai) **[F]**
 3.2.2 Kebutuhan non-fungsional dan aturan bisnis (jam, geofence, IKP, SP) **[F; PRD acuan]**
3.3 Analisis Proses Bisnis Usulan (flowchart usulan) **[F: bagian 6 audit]**
3.4 Pemodelan Sistem (external entity, diagram konteks, hierarchy chart, DAD 0/1; use case bila dipilih) **[dibuat dari kode; perlu persetujuan metode]**
3.5 Desain Basis Data (tabel, relasi, Gambar ERD) **[F: bagian 7]**
3.6 Arsitektur dan Teknologi (Laravel 13, PHP 8.3, MySQL, Blade, Tailwind/Vite, DomPDF, Excel, Chart.js, SweetAlert2, scheduler) **[F: bagian 2–3]**; *desain jaringan* sesuai panduan: bila tidak ada, cukup arsitektur klien–server dan alasan **[K]**
3.7 Implementasi dan Tampilan Sistem
 3.7.1 Halaman Umum/Login · 3.7.2 Antarmuka Admin · 3.7.3 Antarmuka Pegawai **[tangkapan layar K; samarkan nama/NIP]**
3.8 Pengujian
 Hanya skenario yang benar-benar diuji (status A di audit §11/24) dan **dengan bukti**; skenario belum diuji ditulis sebagai belum diuji **[K]**
3.9 Temuan dan Keterbatasan Implementasi (SP, produktivitas 85, IKP tidak tersimpan, email log, dsb) **[F; keputusan pengguna]**

**BAB IV PENUTUP**
4.1 Kesimpulan · 4.2 Saran

### Bagian Akhir
- **Daftar Pustaka** (hanya sumber nyata dan sudah diperiksa; gaya sitasi disepakati) **[K]**
- **Lampiran**
 1. Log Kegiatan **[K]**
 2. Surat Keterangan Diterima KP **[K]**
 3. Surat Keterangan Selesai KP **[K]**
 4. Tabel Kegiatan KP (per mahasiswa: 2 berkas) **[K]**
 5. Lembar Konsultasi Bimbingan (Form KP-4) **[K]**
 6. Sumber Dokumen (PRD, skema DB, dsb)
 7. Dokumentasi tambahan (opsional: tangkapan layar, kode ringkas)

---

## 6. Peta Fakta Proyek: Teruji vs Analisis Kode vs Belum Terverifikasi

Ringkasan dari `audit-kode-aplikasi.md` agar bab laporan nanti tidak mengarang.

| Kategori | Isi |
|---|---|
| **A – Diuji langsung (menurut pengguna)** | Perilaku jam absensi; absen masuk/pulang; terlambat; Alpha (scheduler & pengajuan ditolak); izin & sakit (sampai persetujuan admin); laporan kegiatan; penilaian laporan; kesesuaian pengaturan; ekspor; tambah pegawai |
| **Catatan atas A** | Jejak data uji tidak ada di DB aktif (tidak ada Alpha, pengajuan, SP, skor; 3 laporan, 2 presensi). Persetujuan "Sakit" bertentangan dengan enum DB (diperkirakan gagal) → status D |
| **C – Dari kode, belum diuji** | Rumus IKP; rekomendasi kontrak; draf SP otomatis & terbit (berpotensi error); PDF SP; Pusat Laporan 4 tab; dashboard; email |
| **B – Belum diuji** | Alur SP (3 Alpha); scheduler menyeluruh; email; batas 3× salah login (fitur tidak ditemukan); impor (tidak ada kode) |
| **D – Belum pasti** | QR Code; asal nilai 85; hierarki Bagian Program; kondisi `schedule:run`; ponsel nyata |
| **Fakta teknis tetap** | Laravel ^13.17, PHP ^8.3, MySQL, Blade, Tailwind 4/Vite 8, DomPDF 3.1, Maatwebsite Excel 4.0, Chart.js & SweetAlert2 (CDN), PHPUnit 12 (6 file Feature test, belum dijalankan) |
| **Peran** | admin dan pegawai (PPPK) |
| **Data pegawai** | Data uji bernama nyata (24 pegawai di DB aktif) → samarkan di laporan |

> [!WARNING]
> Beberapa fitur dalam PRD **belum** diimplementasikan penuh (produktivitas otomatis, SP semiotomatis, IKP tersimpan per bulan, 7 laporan, QR). Laporan tidak boleh menyatakannya sudah berjalan.

---

## 7. Informasi yang Masih Kurang dan Perlu Dikonfirmasi

### 7.1 Administratif dan halaman awal
1. Apakah `Hasil Analisa Project.md` memang sengaja kosong, atau berkas yang benar belum tersimpan?
2. Logo UNG (berkas gambar).
3. Nama dosen pembimbing 1 & 2, pendamping lapangan, Kaprodi, Kepala Dinas; alamat dan **periode pelaksanaan KP** (tanggal mulai–selesai).
4. Apakah penyusun tetap 2 orang (Rizqi & Safwan)? Pembagian tugas masing-masing (untuk Bab III/Kata Pengantar)?
5. Ucapan terima kasih (siapa saja).
6. Judul final: "SIP-PERFORMA: Sistem Informasi Absensi dan Evaluasi Kinerja Pegawai P3K/PPPK ..." (apakah "P3K" atau "PPPK" yang dipakai konsisten?).
7. Ketentuan sitasi/daftar pustaka dari pembimbing (APA/IEEE?).

### 7.2 Bab I dan II
8. Sumber resmi sejarah, visi-misi, struktur organisasi (Perwal/Renstra) dan gambar bagan.
9. Hierarki resmi Bagian Program (subbagian di bawah Sekretariat atau tidak) dan nama bidang resmi.
10. Tangkapan layar SP2KP dan SIHALAL; apakah keduanya benar-benar dipakai pegawai sehari-hari?
11. **Kondisi absensi dan evaluasi kinerja P3K sebelum sistem**: cara pencatatan (buku, fingerprint, Excel, aplikasi lain), siapa yang merekap, masalah nyata, frekuensi evaluasi. Tanpa ini 2.2 tidak dapat ditulis.
12. Apakah narasi IKM/kelurahan berasal dari topik lain (boleh diarsipkan/dihapus)?
13. Apakah ada sistem/TI lain di instansi (jaringan, perangkat, server, website) untuk pemetaan 2.1.

### 7.3 Bab III
14. Metode pengembangan yang dipakai (Waterfall, prototyping, agile) dan tahapan nyata; tanggal aktivitas.
15. Metode pemodelan yang diinginkan (flowchart, DFD, use case, ERD) dan apakah boleh dibuat dari kode.
16. Desain jaringan: apakah perlu dan apa bahannya (hosting, server)?
17. Hasil pengujian (UAT/black-box): skenario, tanggal, penguji, bukti (tangkapan layar). Apakah akan diuji ulang sebelum laporan (khususnya "Sakit", SP, scheduler)?
18. Keputusan menangani selisih PRD–implementasi: dicatat sebagai keterbatasan, atau diperbaiki dahulu?
19. Apakah sistem sudah diserahkan/didemokan ke Disperindag, dan siapa pengguna sasarannya?
20. Status deployment (lokal Laragon atau hosting)?

### 7.4 Lampiran
21. Log kegiatan harian/mingguan (tanggal, lokasi, uraian) untuk ±45 hari.
22. Surat keterangan diterima dan selesai KP (scan, cap, tanda tangan).
23. Tabel Kegiatan KP per mahasiswa (Form KP-3) dan lembar konsultasi (Form KP-4).
24. Daftar referensi ilmiah/buku/jurnal yang ingin dipakai (atau izin untuk mencari dan memverifikasi sumber nyata).

---

## 8. Rekomendasi Urutan Kerja Selanjutnya (menunggu arahan)

1. Jawab pertanyaan prioritas 1, 3, 11, 14, 17, 18, 21.
2. Perbaiki Bab I–II (revisi, tanpa menghapus isi lama).
3. Susun Bab III dari audit kode + bahan yang dikonfirmasi.
4. Lengkapi Bab IV, Daftar Pustaka, Lampiran.
5. Bagian awal dan daftar isi dibuat terakhir; finalisasi format (TNR, margin, nomor halaman) saat ekspor ke Word/PDF.
