# Analisis Referensi Laporan Kerja Praktek – SIP-PERFORMA

## 0. Status Pembacaan File

| File | Status | Catatan |
|---|---|---|
| Panduan Kampus.md | Terbaca | Sumber aturan utama |
| Contoh Laporan Kaka Tingkat.md | Terbaca | Hanya referensi struktur/gaya |
| Laporan Magang Saya.md | Terbaca | Dokumen berjalan (baru s.d. Bab II) |
| Hasil Analisa Project.md | **Kosong** | Tidak ada isi, belum dianalisis |

Catatan: folder aktual bernama `Acuan Laporan/Refrensi Laporan` (bukan `referensi-laporan`). Kode aplikasi **belum** dibaca pada tahap ini dan tidak diubah.

## 1. Ketentuan Resmi Kampus (Panduan Kampus)

- KP = 4 SKS, Prodi S1 Sistem Informasi, FT UNG. Durasi 1,5 bulan (±45 hari), dibuktikan absensi + log harian/mingguan.
- Laporan terdiri dari 3 bagian:
  - **Awal**: Sampul, Logo, Judul, Pengesahan, Kata Pengantar, Daftar Isi, Daftar Tabel, Daftar Gambar, Daftar Lampiran, daftar lainnya.
  - **Inti**: BAB I Pendahuluan (1.1 Sekilas instansi, 1.2 Sejarah, 1.3 Visi Misi, 1.4 Struktur Organisasi, 1.5 Deskripsi Tugas); BAB II Gambaran SI & TI Organisasi (2.1 Deskripsi Sistem & TI – narasi **dan pemetaan/arsitektur**; 2.2 Analisis Implementasi Sistem – proses bisnis yang belum berjalan baik); BAB III Hasil Kerja Praktik (evaluasi, desain jaringan, perancangan/implementasi sistem); BAB IV Penutup (4.1 Kesimpulan, 4.2 Saran).
  - **Akhir**: Daftar Pustaka; Lampiran (Log Kegiatan, Surat Keterangan diterima KP, Surat Keterangan selesai KP, Tabel Kegiatan KP per mahasiswa, Lembar Konsultasi per kelompok, Sumber Dokumen).
- Format:
  - A4 70 gr; margin kanan & atas 3 cm, bawah & kiri 4 cm; spasi 2; Times New Roman.
  - Bab: angka Romawi, tengah, kapital, 14 pt, tebal. Subbab: angka latin, rata kiri, 12 pt, tebal.
  - Halaman: bagian awal Romawi kecil tengah bawah (sampul & pengesahan dihitung tapi tidak ditulis); bagian inti angka latin (awal bab di tengah bawah, lainnya pojok kanan atas); bagian akhir lanjutan, tengah bawah.
  - Judul gambar di bawah tengah; judul tabel di atas kiri; penomoran per bab (Gambar 3.1).
  - Sampul: judul TNR 18, "KERJA PRAKTEK" 16, penyusun 14, semua center, logo, Prodi SI – FT – Universitas Negeri Gorontalo – tahun.
  - Cetak 1 rangkap, hard cover biru muda; softcopy (laporan, slide, aplikasi) PDF di CD.
- Form: KP-1 s.d. KP-7 (kesediaan, persetujuan, tabel kegiatan, konsultasi, pengajuan seminar, berita acara/penilaian, presensi).

## 2. Struktur Wajib yang Harus Diikuti

Sampul → Logo → Pengesahan → Kata Pengantar → Daftar Isi/Tabel/Gambar/Lampiran → BAB I (1.1–1.5) → BAB II (2.1, 2.2) → BAB III → BAB IV (4.1, 4.2) → Daftar Pustaka → Lampiran.

## 3. Kondisi Laporan Saya

### Sudah tersedia
- Sampul (judul, nama + NIM 2 penyusun, prodi, fakultas, universitas, 2026).
- BAB I: 1.1–1.5 sudah ada isi narasi.
- BAB II: 2.1 (SP2KP, SIHALAL) dan 2.2 analisis (draf).

### Belum tersedia
- Logo, Lembar Pengesahan, Kata Pengantar, Daftar Isi/Tabel/Gambar/Lampiran.
- BAB III dan BAB IV.
- Daftar Pustaka dan seluruh Lampiran.
- Seluruh gambar (struktur organisasi, SP2KP, SIHALAL, flowchart).

### Perlu direvisi
1. **Inkonsistensi utama BAB II 2.2**: analisis membahas "Sistem Informasi Manajemen Verifikasi Status Operasional IKM Berbasis Kelurahan", padahal judul/proyek adalah SIP-PERFORMA (absensi & evaluasi kinerja P3K). Perlu ditulis ulang agar berbasis masalah absensi/kinerja P3K (sumber fakta harus dari Anda).
2. Rujukan "Gambar 2.2" untuk flowchart padahal gambarnya Gambar 2.3; Gambar 2.2 sudah SIHALAL.
3. Karakter rusak pada "KOTA JASA" (encoding), perlu diperbaiki.
4. Penomoran 1.3 berlanjut (1, 2, 3) antara Misi dan Tujuan; perlu dipisah.
5. Judul memakai "Perindustrian dan Perdagangan", isi memakai "Perdagangan dan Perindustrian"; samakan.
6. Heading "BAB 2" dan "Deskripsi Sistem..." tanpa nomor 2.1/2.2, serta sub-subbab 2.1.1/2.1.2; ubah ke "BAB II" dan penomoran sesuai panduan.
7. 2.1 belum memuat pemetaan/arsitektur sistem (diwajibkan panduan).
8. 1.4 hanya satu paragraf; gambar struktur organisasi belum ada.
9. Format (TNR, margin, spasi, nomor halaman) belum bisa diverifikasi dari file markdown.

## 4. Perbedaan Panduan vs Contoh vs Laporan Saya

| Aspek | Panduan | Contoh kakak tingkat | Laporan saya |
|---|---|---|---|
| Penulisan bab | BAB I (Romawi) | BAB I | BAB 1 / BAB 2 (angka biasa) |
| Nama universitas | Universitas Negeri Gorontalo | "Universitas Gorontalo" | Universitas Negeri Gorontalo (sesuai panduan) |
| Bagian awal | Logo, pengesahan wajib | Kata pengantar, daftar isi/tabel/gambar/lampiran (pengesahan & logo tidak terlihat di teks) | Belum ada |
| BAB III | Evaluasi, desain jaringan, perancangan/implementasi | Flowchart usulan, eksternal entity, hierarchy chart, DAD 0/1, desain database, tampilan sistem | Belum ada |
| Lampiran | Log, surat diterima, surat selesai, tabel kegiatan, konsultasi, sumber dokumen | Log, surat kesediaan, tabel kegiatan, surat penarikan magang, konsultasi (berorientasi MBKM) | Belum ada |
| Kesalahan contoh | – | Numbering 3.3.1 di bawah 3.4, rujukan gambar keliru, typo | Jangan ditiru |

Panduan juga memiliki ketidakrapian internal (daftar isi: nomor 1.3 halaman 1, 1.7 ganda); diikuti sebatas isi aturan.

Keputusan: panduan kampus diutamakan. Contoh dipakai hanya untuk pola BAB III dan gaya penulisan.

## 5. Informasi Tambahan yang Perlu Anda Sediakan

- Logo UNG, data pengesahan: nama dosen pembimbing 1 & 2, pendamping lapangan, Kaprodi, Kepala Dinas, periode pelaksanaan KP.
- Nama-nama untuk Kata Pengantar (ucapan terima kasih).
- Gambar struktur organisasi dinas; screenshot SP2KP & SIHALAL.
- Fakta kondisi absensi/evaluasi kinerja P3K sebelum sistem (cara pencatatan, masalah nyata, siapa terlibat) – agar 2.2 tidak mengarang.
- Konfirmasi: fitur, peran pengguna, dan teknologi akan diambil dari kode aplikasi (perlu persetujuan membaca kode, read-only).
- Hasil pengujian (jika ada) – jika belum ada, bagian ini tidak akan ditulis.
- Log kegiatan harian, surat diterima/selesai KP, tabel kegiatan, lembar konsultasi.
- Referensi pustaka yang akan dipakai (jurnal/buku).
- Apakah Hasil Analisa Project.md memang sengaja kosong atau berkas yang benar belum tersimpan.
