# SIP-PERFORMA: SISTEM INFORMASI ABSENSI DAN EVALUASI KINERJA PEGAWAI P3K BERBASIS WEB PADA DINAS PERINDUSTRIAN DAN PERDAGANGAN KOTA GORONTALO

---

## HALAMAN SAMPUL

```
                                  LAPORAN KERJA PRAKTEK

      SIP-PERFORMA: SISTEM INFORMASI ABSENSI DAN EVALUASI KINERJA PEGAWAI P3K 
     BERBASIS WEB PADA DINAS PERINDUSTRIAN DAN PERDAGANGAN KOTA GORONTALO



                                       DISUSUN OLEH :
                          Rizqi Firmansya Tamimu    (531423088)
                          Mohamad Safwan Ahmad      (531423086)



                                     [TEMPAT LOGO UNG]



                              PROGRAM STUDI SISTEM INFORMASI
                                     FAKULTAS TEKNIK
                              UNIVERSITAS NEGERI GORONTALO
                                          2026
```

---

## HALAMAN PENGESAHAN

```
                                    LEMBAR PENGESAHAN
                                      KERJA PRAKTEK

      SIP-PERFORMA: SISTEM INFORMASI ABSENSI DAN EVALUASI KINERJA PEGAWAI P3K 
     BERBASIS WEB PADA DINAS PERINDUSTRIAN DAN PERDAGANGAN KOTA GORONTALO

Nama Organisasi    : Dinas Perindustrian dan Perdagangan Kota Gorontalo
Alamat             : Jl. Achmad Nadjamuddin No. 25, Kec. Kota Tengah, Kota Gorontalo
Waktu Pelaksanaan  : 19 Agustus 2026 s.d. 09 Desember 2026
Pelaksana          :
1. Rizqi Firmansya Tamimu   (NIM: 531423088)
2. Mohamad Safwan Ahmad     (NIM: 531423086)


                               Telah diuji dan disetujui oleh:

            Dosen Pembimbing I,                           Dosen Pembimbing II,



   Prof. Lanto Ningrayati Amali, Ph.D.               Zulhair Jidan Dj. Tamu, M.Kom.
   NIP. ..............................               NIP. .........................


                                      Mengetahui,
                        Ketua Program Studi S1 Sistem Informasi
                               Jurusan Teknik Informatika
                       Fakultas Teknik Universitas Negeri Gorontalo



                           Muchlis Polin, S.Kom., M.Kom.
                           NIP. .........................
```

---

## KATA PENGANTAR

Puji dan syukur penulis panjatkan ke hadirat Allah SWT, Tuhan Yang Maha Esa, karena atas limpahan rahmat, taufik, dan hidayah-Nya, penulis dapat menyelesaikan pelaksanaan Kerja Praktek (KP) beserta penyusunan laporan akhir yang berjudul **"SIP-PERFORMA: Sistem Informasi Absensi dan Evaluasi Kinerja Pegawai P3K Berbasis Web pada Dinas Perindustrian dan Perdagangan Kota Gorontalo"** dengan baik.

Laporan Kerja Praktek ini disusun guna memenuhi salah satu persyaratan akademik dalam menyelesaikan kurikulum mata kuliah Kerja Praktek pada Program Studi S1 Sistem Informasi, Jurusan Teknik Informatika, Fakultas Teknik, Universitas Negeri Gorontalo. Melalui kegiatan Kerja Praktek yang berlangsung selama kurang lebih 4 (empat) bulan, terhitung mulai tanggal 19 Agustus 2026 hingga 09 Desember 2026, penulis memperoleh wawasan, pengalaman kerja nyata, dan kesempatan untuk menerapkan ilmu pengetahuan di bidang teknologi dan sistem informasi guna memecahkan tantangan operasional kepegawaian di instansi pemerintah daerah.

Keberhasilan pelaksanaan Kerja Praktek dan penyusunan laporan ini tentunya tidak lepas dari bantuan, bimbingan, arahan, dan motivasi dari berbagai pihak. Oleh karena itu, pada kesempatan ini penulis menyampaikan ucapan terima kasih yang tulus kepada:
1. Bapak Muchlis Polin, S.Kom., M.Kom., selaku Ketua Program Studi S1 Sistem Informasi Fakultas Teknik Universitas Negeri Gorontalo.
2. Ibu Indhitya R. Padiku, S.Kom., M.Kom., selaku Ketua Jurusan Teknik Informatika Fakultas Teknik Universitas Negeri Gorontalo.
3. Ibu Prof. Lanto Ningrayati Amali, Ph.D., selaku Dosen Pembimbing I yang senantiasa meluangkan waktu memberikan bimbingan, masukan metodologis, dan arahan berharga dalam penyusunan laporan ini.
4. Bapak Zulhair Jidan Dj. Tamu, M.Kom., selaku Dosen Pembimbing II yang senantiasa memberikan bimbingan teknis dan masukan konstruktif dalam pengembangan sistem.
5. Kepala Dinas Perindustrian dan Perdagangan Kota Gorontalo beserta jajaran pimpinan yang telah memberikan izin dan menyambut baik kedatangan penulis untuk melaksanakan Kerja Praktek.
6. Ibu Sekretaris Dinas Perindustrian dan Perdagangan Kota Gorontalo selaku Pembimbing Lapangan yang telah mendampingi, mengarahkan proses observasi kerja, dan memfasilitasi kebutuhan data kepegawaian selama kegiatan magang.
7. Seluruh staf, pegawai ASN, dan rekan-rekan Pegawai Pemerintah dengan Perjanjian Kerja (P3K) di lingkungan Dinas Perindustrian dan Perdagangan Kota Gorontalo atas kerja sama, keramahan, dan dukungannya selama pelaksanaan KP.
8. Orang tua dan keluarga tercinta yang senantiasa memanjatkan doa, memberikan dukungan moril, kasih sayang, dan pengorbanan yang tak ternilai bagi penulis.
9. Rekan-rekan sesama mahasiswa Program Studi S1 Sistem Informasi angkatan 2023 yang saling menyemangati dan bertukar pikiran dalam menyelesaikan Kerja Praktek.

Penulis menyadari sepenuhnya bahwa laporan ini masih memiliki keterbatasan dan ruang untuk penyempurnaan. Oleh karena itu, penulis sangat mengharapkan kritik serta saran yang membangun dari pembaca. Akhir kata, semoga laporan Kerja Praktek ini dapat memberikan kontribusi nyata serta manfaat akademik dan praktis bagi pengembangan sistem kepegawaian di Dinas Perindustrian dan Perdagangan Kota Gorontalo.

Gorontalo, Desember 2026

**Tim Penulis**

---

## DAFTAR ISI

* Halaman Sampul .......................................................................................... i
* Halaman Pengesahan .................................................................................... ii
* Kata Pengantar ............................................................................................ iii
* Daftar Isi .................................................................................................... iv
* Daftar Tabel ................................................................................................ vi
* Daftar Gambar ............................................................................................ vii
* Daftar Lampiran ........................................................................................... ix

* **BAB I PENDAHULUAN** ............................................................................... 1
  * 1.1 Sekilas Mengenai Instansi ...................................................................... 1
  * 1.2 Sejarah Instansi ..................................................................................... 2
  * 1.3 Visi dan Misi Instansi ............................................................................. 4
  * 1.4 Struktur Organisasi Instansi .................................................................... 5
  * 1.5 Deskripsi Tugas Instansi ........................................................................ 6

* **BAB II GAMBARAN SISTEM INFORMASI DAN TEKNOLOGI INFORMASI ORGANISASI** ..... 9
  * 2.1 Deskripsi Sistem dan Teknologi Informasi ................................................. 9
    * 2.1.1 Sistem Pemantauan Pasar dan Kebutuhan Pokok (SP2KP) ...................... 10
    * 2.1.2 Sistem Informasi Halal (SIHALAL) .................................................... 11
    * 2.1.3 Pemetaan Arsitektur Sistem Informasi dan Infrastruktur TI Organisasi ..... 12
  * 2.2 Analisis Implementasi Sistem ................................................................. 14
    * 2.2.1 Analisis Kondisi dan Masalah Absensi & Kinerja Pegawai P3K Saat Ini ... 14
    * 2.2.2 Analisis Cross-Functional Flowchart (CFF) Alur Berjalan ........................ 16

* **BAB III HASIL KERJA PRAKTIK** ................................................................. 18
  * 3.1 Evaluasi dan Latar Belakang Pengembangan Sistem ................................... 18
  * 3.2 Analisis Kebutuhan Sistem .................................................................... 19
    * 3.2.1 Analisis Kebutuhan Fungsional ......................................................... 19
    * 3.2.2 Analisis Kebutuhan Non-Fungsional & Aturan Bisnis ........................... 21
  * 3.3 Analisis Proses Bisnis Usulan (Flowchart Usulan) ...................................... 23
  * 3.4 Pemodelan Sistem ................................................................................ 25
    * 3.4.1 Identifikasi External Entity ............................................................. 25
    * 3.4.2 Diagram Konteks ........................................................................... 26
    * 3.4.3 Hierarchy Chart (Diagram Dekomposisi Fungsi) .................................. 27
    * 3.4.4 Data Flow Diagram (DFD) Level 0 ..................................................... 28
    * 3.4.5 Data Flow Diagram (DFD) Level 1 ..................................................... 29
  * 3.5 Perancangan Basis Data (Database Design) ............................................... 32
    * 3.5.1 Entity Relationship Diagram (ERD) ................................................... 32
    * 3.5.2 Struktur Tabel dan Kamus Data ....................................................... 33
  * 3.6 Arsitektur Perangkat Lunak dan Teknologi Pengembangan .......................... 37
  * 3.7 Implementasi Antarmuka Sistem ............................................................. 39
    * 3.7.1 Antarmuka Autentikasi dan Login ..................................................... 39
    * 3.7.2 Antarmuka Administrator ............................................................... 40
    * 3.7.3 Antarmuka Pegawai P3K ................................................................. 45
  * 3.8 Pengujian Sistem (System Testing) .......................................................... 49
    * 3.8.1 Lingkungan Pengujian .................................................................... 49
    * 3.8.2 Skenario dan Hasil Pengujian Black-Box ........................................... 50

* **BAB IV PENUTUP** .................................................................................... 56
  * 4.1 Kesimpulan ........................................................................................... 56
  * 4.2 Saran .................................................................................................. 57

* **DAFTAR PUSTAKA** .................................................................................... 58
* **LAMPIRAN** ............................................................................................... 60

---

## DAFTAR TABEL

* Tabel 2.1 Hubungan Konseptual Komponen SI/TI Organisasi ................................. 10
* Tabel 2.2 Inventarisasi Sistem Informasi pada Disperindag Kota Gorontalo ............ 13
* Tabel 3.1 Identifikasi External Entity Sistem SIP-PERFORMA ................................ 25
* Tabel 3.2 Struktur Tabel `pegawai` ................................................................... 33
* Tabel 3.3 Struktur Tabel `pengguna` ................................................................. 34
* Tabel 3.4 Struktur Tabel `presensi` ................................................................... 34
* Tabel 3.5 Struktur Tabel `laporan_kegiatan` ...................................................... 35
* Tabel 3.6 Struktur Tabel `pengajuan_izin` ......................................................... 35
* Tabel 3.7 Struktur Tabel `skor_kinerja` ............................................................ 36
* Tabel 3.8 Struktur Tabel `surat_peringatan` ...................................................... 36
* Tabel 3.9 Struktur Tabel `pengaturan_kantor` .................................................... 37
* Tabel 3.10 Skenario Pengujian Black-Box Modul Autentikasi ................................ 50
* Tabel 3.11 Skenario Pengujian Black-Box Modul Presensi Geofence & Kamera .......... 51
* Tabel 3.12 Skenario Pengujian Black-Box Modul Laporan Kegiatan Harian .............. 52
* Tabel 3.13 Skenario Pengujian Black-Box Modul Pengajuan Izin/Sakit/Cuti/Dinas ..... 53
* Tabel 3.14 Skenario Pengujian Black-Box Modul Evaluasi Kinerja (IKP) & SP ......... 54
* Tabel 3.15 Skenario Pengujian Black-Box Modul Pusat Laporan & Ekspor Dokumen ... 55

---

## DAFTAR GAMBAR

* Gambar 1.1 Bagan Struktur Organisasi Disperindag Kota Gorontalo ....................... 6
* Gambar 2.1 Antarmuka Aplikasi SP2KP Kementerian Perdagangan ........................ 11
* Gambar 2.2 Antarmuka Aplikasi SIHALAL Kementerian Agama ............................. 12
* Gambar 2.3 Arsitektur Jaringan dan SI/TI Berjalan pada Disperindag .................... 14
* Gambar 2.4 Cross-Functional Flowchart (CFF) Alur Presensi & Evaluasi Berjalan .... 17
* Gambar 3.1 Flowchart Usulan Sistem SIP-PERFORMA ......................................... 24
* Gambar 3.2 Diagram Konteks Sistem SIP-PERFORMA .......................................... 26
* Gambar 3.3 Hierarchy Chart (Dekomposisi Fungsional Sistem) ............................. 27
* Gambar 3.4 Data Flow Diagram (DFD) Level 0 ................................................... 29
* Gambar 3.5 DFD Level 1 Proses 1 (Manajemen Presensi) .................................... 30
* Gambar 3.6 DFD Level 1 Proses 2 (Manajemen Laporan Kegiatan) ........................ 30
* Gambar 3.7 DFD Level 1 Proses 3 (Manajemen Pengajuan & Dispensasi) ................ 31
* Gambar 3.8 DFD Level 1 Proses 4 (Perhitungan Kinerja & Penerbitan SP) .............. 31
* Gambar 3.9 Entity Relationship Diagram (ERD) Sistem SIP-PERFORMA .................. 33
* Gambar 3.10 Arsitektur Software Model-View-Controller (MVC) Laravel ................ 38
* Gambar 3.11 Halaman Login Sistem SIP-PERFORMA ........................................... 40
* Gambar 3.12 Tampilan Dashboard Utama Admin ................................................ 41
* Gambar 3.13 Tampilan Monitoring Presensi Harian ............................................. 42
* Gambar 3.14 Tampilan Verifikasi Laporan Kegiatan ............................................ 43
* Gambar 3.15 Tampilan Persetujuan Izin, Sakit, Cuti, dan Dinas Luar .................... 43
* Gambar 3.16 Tampilan Indeks Kinerja Pegawai (IKP) Admin ................................ 44
* Gambar 3.17 Tampilan Manajemen Surat Peringatan (SP) .................................... 44
* Gambar 3.18 Tampilan Pusat Laporan dan Ekspor Data ....................................... 45
* Gambar 3.19 Tampilan Pengaturan Parameter Sistem .......................................... 45
* Gambar 3.20 Tampilan Dashboard Pegawai P3K ................................................. 46
* Gambar 3.21 Tampilan Modal Kamera & Absensi Masuk/Pulang Pegawai ............... 47
* Gambar 3.22 Tampilan Riwayat Presensi Pegawai ............................................... 47
* Gambar 3.23 Tampilan Pengisian Laporan Kegiatan Harian .................................. 48
* Gambar 3.24 Tampilan Formulir Pengajuan Izin/Sakit/Cuti ................................. 48
* Gambar 3.25 Tampilan Lembar Indeks Kinerja Pribadi Pegawai ............................ 49

---

## DAFTAR LAMPIRAN

* Lampiran 1: Log Kegiatan Harian Kerja Praktek (KP)
* Lampiran 2: Form KP-3 (Tabel Kegiatan Pelaksanaan KP Mahasiswa)
* Lampiran 3: Form KP-4 (Lembar Konsultasi Bimbingan KP)
* Lampiran 4: Surat Keterangan Kesediaan Menerima Mahasiswa KP
* Lampiran 5: Surat Keterangan Telah Selesai Melaksanakan KP
* Lampiran 6: Contoh Hasil Ekspor Berkas Presensi dan Surat Peringatan (PDF)

---

# BAB I
# PENDAHULUAN

## 1.1 Sekilas Mengenai Instansi
Dinas Perindustrian dan Perdagangan Kota Gorontalo merupakan unsur pelaksana urusan pemerintahan daerah di lingkungan Pemerintah Kota Gorontalo yang memegang peranan strategis dalam pembinaan, pengawasan, dan pengembangan perekonomian masyarakat. Dinas ini bertugas membantu Wali Kota Gorontalo dalam melaksanakan urusan pemerintahan konkuren bidang perindustrian dan perdagangan yang menjadi kewenangan daerah.

Dalam konteks pembangunan daerah Kota Gorontalo yang berkarakteristik sebagai kota perdagangan dan jasa, Dinas Perindustrian dan Perdagangan memiliki kedudukan yang sangat vital. Sektor perdagangan menjadi lokomotif utama perputaran uang dan aktivitas logistik masyarakat, sedangkan sektor industri kecil dan menengah (IKM) menjadi pilar pemberdayaan ekonomi kreatif lokal. Instansi ini secara konsisten melaksanakan pemantauan pasokan dan stabilisasi harga bahan kebutuhan pokok, perlindungan konsumen melalui standardisasi ukuran dan tera metrologi legal, penataan sarana distribusi perdagangan, serta pembinaan perizinan dan mutu produk industri kerajinan dan olahan pangan lokal.

Untuk mewujudkan pelayanan publik yang prima dan pembinaan sektor perdagangan-perindustrian yang optimal, operasional harian dinas tidak hanya ditopang oleh Pegawai Negeri Sipil (PNS), namun juga sangat bertumpu pada kinerja Pegawai Pemerintah dengan Perjanjian Kerja (P3K). Keberadaan pegawai P3K menjadi tulang punggung pelaksana teknis operasional dinas, mulai dari pemantau lapangan pasar, penyuluh perindustrian, petugas metrologi, hingga tenaga administrasi perkantoran. Oleh karena itu, pengelolaan manajemen disiplin dan pemantauan kinerja pegawai P3K menjadi salah satu kunci penting keberhasilan program kerja dinas.

## 1.2 Sejarah Instansi
Sejarah pembinaan sektor industri dan perdagangan di Indonesia mengalami dinamika panjang seiring dengan transformasi ketatanegaraan. Pada awal kemerdekaan tahun 1945, urusan perdagangan dan perindustrian berada di bawah Kementerian Kemakmuran. Dalam perkembangan era otonomi daerah pasca-pemberlakuan Undang-Undang Nomor 22 Tahun 1999 yang disempurnakan melalui Undang-Undang Nomor 32 Tahun 2004 serta Undang-Undang Nomor 23 Tahun 2014 tentang Pemerintahan Daerah, pemerintah kota diberikan wewenang penuh untuk mengelola potensi perindustrian dan perdagangan daerah secara mandiri.

Di tingkat Pemerintah Kota Gorontalo, struktur kelembagaan yang mengurusi perdagangan dan industri beberapa kali mengalami perubahan penataan organisasi dan tata kerja (nomenklatur) guna menyesuaikan efisiensi birokrasi daerah. Sebelum restrukturisasi perangkat daerah, urusan industri dan perdagangan sempat digabungkan dengan urusan koperasi dan usaha mikro kecil menengah dalam wadah Dinas Perindustrian, Perdagangan, Koperasi dan UMKM.

Selanjutnya, seiring dengan ditetapkannya Peraturan Daerah Kota Gorontalo Nomor 5 Tahun 2016 tentang Pembentukan dan Susunan Perangkat Daerah Kota Gorontalo, urusan koperasi dipisahkan ke dinas tersendiri, sehingga dibentuk organisasi perangkat daerah yang berfokus penuh menangani sektor riil, yaitu Dinas Perindustrian dan Perdagangan Kota Gorontalo (dikenal pula secara resmi sebagai Dinas Perdagangan dan Perindustrian pada dokumen perencanaan daerah). Kantor instansi ini berkedudukan di lokasi strategis pusat kota, beralamat di Jalan Achmad Nadjamuddin Nomor 25, Kecamatan Kota Tengah, Kota Gorontalo.

## 1.3 Visi dan Misi Instansi
Visi Dinas Perindustrian dan Perdagangan Kota Gorontalo dirumuskan secara selaras dengan Visi Pembangunan Jangka Menengah Daerah Pemerintah Kota Gorontalo sebagaimana tercantum dalam dokumen Rencana Pembangunan Jangka Menengah Daerah (RPJMD), yaitu:

> **"KOTA JASA: Terwujudnya Kota Gorontalo yang Maju, Sejahtera, dan Berdaya Saing sebagai Pusat Perdagangan dan Jasa."**

Guna mewujudkan visi tersebut, Misi yang diemban oleh Dinas Perindustrian dan Perdagangan Kota Gorontalo adalah:
1. **Meningkatkan daya saing sumber daya manusia dan ekonomi kerakyatan untuk kesejahteraan masyarakat.**

Adapun tujuan strategis dinas sebagaimana tercantum dalam Matriks Penyelarasan Rencana Strategis (RENSTRA) meliputi:
1. **Meningkatnya Daya Saing Sektor Perindustrian**, yang diwujudkan melalui penguatan kapasitas wirausaha IKM, fasilitasi legalitas dan sertifikasi produk (termasuk sertifikasi halal), serta adopsi teknologi tepat guna.
2. **Meningkatnya Nilai Tambah dan Kestabilan Sektor Perdagangan**, yang diwujudkan melalui efisiensi rantai distribusi barang kebutuhan pokok, pemantauan harga pasar yang transparan, revitalisasi pasar rakyat, dan perlindungan konsumen dari praktik kecurangan takaran atau alat ukur.

## 1.4 Struktur Organisasi Instansi
Struktur organisasi Dinas Perindustrian dan Perdagangan Kota Gorontalo disusun secara hierarkis berdasarkan prinsip pembagian fungsi teknis dan administratif untuk memastikan seluruh program kerja terlaksana dengan tertib dan akuntabel. Bagan struktur organisasi instansi dapat dilihat pada Gambar 1.1.

```
                    BAGAN STRUKTUR ORGANISASI
        DINAS PERINDUSTRIAN DAN PERDAGANGAN KOTA GORONTALO

                          +--------------------+
                          |    KEPALA DINAS    |
                          +---------+----------+
                                    |
                        +-----------+-----------+
                        |                       |
            +-----------v----------+            |
            |      SEKRETARIS      |            |
            +-----------+----------+            |
                        |                       |
       +----------------+----------------+      |
       |                                 |      |
+------v---------------+        +--------v------v-------+
|  SUBBAGIAN PROGRAM   |        | SUBBAGIAN ADM. KEUANGAN|
|                      |        |  UMUM DAN KEPEGAWAIAN |
+----------------------+        +-----------------------+
                                                |
       +----------------------------------------+-------------------+
       |                                        |                   |
+------v---------------+       +----------------v----+      +-------v--------------+
|  BIDANG PERDAGANGAN  |       | BIDANG PERLINDUNGAN |      | BIDANG PERINDUSTRIAN |
|                      |       |     KONSUMEN DAN    |      |                      |
|                      |       |    KEMETROLOGIAN    |      |                      |
+----------------------+       +---------------------+      +----------------------+
```
*Gambar 1.1 Bagan Struktur Organisasi Disperindag Kota Gorontalo*  
*(Catatan: Pengguna dapat menyisipkan file gambar bagan resmi pada bagian ini)*

## 1.5 Deskripsi Tugas Instansi
Berdasarkan bagan struktur organisasi di atas, rincian tugas dan fungsi dari masing-masing unit kerja adalah sebagai berikut:

1. **Kepala Dinas**: Bertindak sebagai pemimpin pucuk pimpinan instansi yang bertugas memimpin, merumuskan kebijakan operasional, mengoordinasikan, mengendalikan, dan mengevaluasi seluruh urusan pemerintahan daerah di bidang perdagangan, perindustrian, dan kemetrologian.
2. **Sekretaris Dinas**: Bertugas mengoordinasikan pelayanan administratif, ketatausahaan, pengelolaan keuangan, perlengkapan sarana prasarana, serta manajemen kepegawaian bagi seluruh aparatur sipil negara di lingkungan dinas.
3. **Subbagian Program**: Membantu Sekretaris dalam menghimpun bahan perencanaan, menyusun rencana kerja strategis (RENSTRA) dan rencana kerja tahunan (RENJA), mengelola sistem akuntabilitas kinerja instansi pemerintah (SAKIP), serta menyusun laporan evaluasi kinerja dinas.
4. **Subbagian Administrasi Keuangan, Umum, dan Kepegawaian**: Bertugas melaksanakan pengelolaan administrasi belanja dan pertanggungjawaban keuangan, pengelolaan aset barang milik daerah, kearsipan dan surat-menyurat, serta pelayanan urusan administrasi kepegawaian (termasuk pembinaan disiplin dan rekapitulasi presensi berkala).
5. **Bidang Perdagangan**: Bertugas merumuskan dan melaksanakan kebijakan di bidang perdagangan dalam negeri, fasilitas sarana perdagangan, pemantauan arus distribusi komoditas pangan pokok, serta stabilitas harga barang kebutuhan pokok dan barang penting.
6. **Bidang Perlindungan Konsumen dan Kemetrologian**: Bertugas melaksanakan pengawasan barang beredar dan jasa, penegakan perlindungan hak-hak konsumen, serta penyelenggaraan pelayanan kemetrologian melalui kegiatan tera dan tera ulang terhadap Alat Ukur, Takar, Timbang, dan Perlengkapannya (UTTP).
7. **Bidang Perindustrian**: Bertugas merumuskan kebijakan teknis pendataan, pembinaan kapasitas, fasilitasi legalitas usaha industri, pendampingan standarisasi mutu produk, dan penumbuhan wirausaha baru Industri Kecil dan Menengah (IKM).

Keterkaitan operasional tugas-tugas di atas menuntut kedisiplinan dan produktivitas tinggi dari para aparatur, khususnya pegawai P3K yang ditugaskan di masing-masing bidang. Sebagai kontribusi nyata dalam memecahkan hambatan administrasi kepegawaian dinas selama pelaksanaan Kerja Praktek, penulis mengembangkan **SIP-PERFORMA (Sistem Informasi Absensi dan Evaluasi Kinerja Pegawai P3K Berbasis Web)**. Sistem ini dirancang untuk mendigitalkan pencatatan kehadiran berbasis radius lokasi (geofencing) dan swafoto, memfasilitasi pelaporan kegiatan harian yang terukur, serta mengotomatisasikan penghitungan Indeks Kinerja Pegawai (IKP) dan penegakan Surat Peringatan (SP) secara objektif dan transparan.

---

# BAB II
# GAMBARAN SISTEM INFORMASI DAN TEKNOLOGI INFORMASI ORGANISASI

## 2.1 Deskripsi Sistem dan Teknologi Informasi
Dalam era transformasi digital tata kelola pemerintahan (Electronic Government / E-Gov), pemanfaatan sistem informasi dan teknologi informasi menjadi instrumen esensial untuk menjamin penyelenggaraan birokrasi yang transparan, cepat, dan presisi. Konsep sistem pada hakikatnya merupakan keterpaduan terstruktur dari prosedur, sumber daya manusia, dan infrastruktur data yang saling berinteraksi guna mencapai sasaran organisasi. Sementara teknologi informasi berperan sebagai infrastruktur pendukung pengolahan, komputasi, dan transmisi data secara terotomatisasi. Hubungan konseptual ini disajikan pada Tabel 2.1.

*Tabel 2.1 Hubungan Konseptual Komponen SI/TI Organisasi*
| Konsep | Cakupan Utama | Peran dalam Organisasi Pemerintah |
|---|---|---|
| **Sistem** | Kumpulan prosedur kerja, regulasi, dan sumber daya manusia | Menentukan tata laksana alur birokrasi dan standar operasional prosedur (SOP) |
| **Sistem Informasi** | Integrasi antara basis data, antarmuka aplikasi, dan aturan bisnis | Menyajikan informasi berkala bagi pimpinan dalam pengambilan keputusan strategis |
| **Teknologi Informasi** | Perangkat keras, perangkat lunak, jaringan komputer, dan basis data | Media komputasi dan saluran komunikasi data agar informasi dapat diakses secara cepat dan aman |

Dalam menjalankan tugas pokok dan fungsinya, Dinas Perindustrian dan Perdagangan Kota Gorontalo telah memanfaatkan beberapa sistem informasi sektoral berbasis web yang terhubung dengan kementerian teknis, antara lain:

### 2.1.1 Sistem Pemantauan Pasar dan Kebutuhan Pokok (SP2KP)
SP2KP merupakan sistem informasi berbasis web yang dikembangkan oleh Kementerian Perdagangan Republik Indonesia. Pada Dinas Perindustrian dan Perdagangan Kota Gorontalo, sistem ini digunakan secara harian oleh petugas lapangan (surveyor harga) pada Bidang Perdagangan.

Petugas dinas melakukan survei harga harian terhadap komoditas kebutuhan pokok (seperti beras, gula pasir, minyak goreng, cabai rawit, bawang merah, daging sapi, dan telur ayam) di beberapa pasar tradisional utama Kota Gorontalo (misalnya Pasar Sentral Kota Gorontalo dan Pasar Dungingi). Data harga yang dihimpun kemudian diinput ke dalam portal SP2KP untuk diproses menjadi grafik tren fluktuasi harga komoditas pangan daerah dan disinkronkan secara nasional dengan Badan Pangan Nasional serta Kementerian Dalam Negeri sebagai bahan pengendalian inflasi daerah.

```
+--------------------------------------------------------------------------+
|                       [PLACEHOLDER GAMBAR 2.1]                           |
|               Tampilan Antarmuka Web Aplikasi SP2KP                      |
|         (Kementerian Perdagangan RI pada Disperindag Kota Gorontalo)     |
+--------------------------------------------------------------------------+
```
*Gambar 2.1 Antarmuka Aplikasi SP2KP Kementerian Perdagangan*  
*(Catatan: Pengguna dapat menyisipkan tangkapan layar SP2KP pada bagian ini)*

### 2.1.2 Sistem Informasi Halal (SIHALAL)
SIHALAL merupakan portal layanan publik berbasis web yang dikembangkan oleh Badan Penyelenggara Jaminan Produk Halal (BPJPH) Kementerian Agama Republik Indonesia. Pada Disperindag Kota Gorontalo, sistem ini dimanfaatkan oleh Bidang Perindustrian untuk memfasilitasi dan mendampingi para pelaku Usaha Mikro dan Kecil (UMK) serta IKM binaan daerah dalam pengurusan Sertifikat Halal melalui skema *self-declare* (pernyataan mandiri) maupun sertifikasi reguler.

Petugas pendamping dari dinas membantu pelaku usaha mulai dari pembuatan Nomor Induk Berusaha (NIB) berbasis OSS, pendaftaran akun pada SIHALAL, pengunggahan dokumen bahan baku dan proses produksi halal (PPH), hingga memantau tahapan verifikasi fatwa kehalalan dan penerbitan sertifikat halal digital.

```
+--------------------------------------------------------------------------+
|                       [PLACEHOLDER GAMBAR 2.2]                           |
|                      [PLACEHOLDER GAMBAR 2.2]                            |
|             Tampilan Antarmuka Aplikasi SIHALAL (BPJPH)                  |
|          dalam Pendampingan IKM oleh Disperindag Kota Gorontalo          |
+--------------------------------------------------------------------------+
```
*Gambar 2.2 Antarmuka Aplikasi SIHALAL Kementerian Agama*  
*(Catatan: Pengguna dapat menyisipkan tangkapan layar SIHALAL pada bagian ini)*

### 2.1.3 Pemetaan Arsitektur Sistem Informasi dan Infrastruktur TI Organisasi
Berdasarkan hasil observasi dan wawancara selama pelaksanaan Kerja Praktek, inventarisasi pemanfaatan perangkat lunak dan infrastruktur teknologi informasi di Dinas Perindustrian dan Perdagangan Kota Gorontalo dipetakan pada Tabel 2.2.

*Tabel 2.2 Inventarisasi Sistem Informasi pada Disperindag Kota Gorontalo*
| Nama Sistem | Pengembang / Basis | Fungsi Utama | Unit Pengguna |
|---|---|---|---|
| **SP2KP** | Kemendag RI / Web Terpusat | Pemantauan harga & ketersediaan stok pangan harian | Bidang Perdagangan |
| **SIHALAL** | BPJPH Kemenag / Web Terpusat | Pendaftaran dan pendampingan sertifikasi halal IKM | Bidang Perindustrian |
| **SIPD RI** | Kemendagri / Web Terpusat | Perencanaan anggaran, penatausahaan, dan pelaporan keuangan | Sekretariat & Subbag Keuangan |
| **Aplikasi WhatsApp** | Komersial / Mobile App | Saluran koordinasi informal dan pelaporan absensi swafoto | Seluruh Pegawai & P3K |
| **Microsoft Excel** | Desktop Spreadsheet | Rekapitulasi manual data kehadiran dan kegiatan pegawai | Subbag Kepegawaian & Umum |

Secara arsitektur fisik, infrastruktur teknologi informasi dinas ditunjang oleh koneksi jaringan internet pita lebar (*broadband*) yang dikelola melalui kerja sama dengan Dinas Komunikasi, Informatika, dan Statistik (Diskominfotik) Kota Gorontalo. Distribusi jaringan lokal di gedung kantor menggunakan kombinasi kabel LAN UTP Cat6 untuk area kesekretariatan dan pemancar *Wi-Fi Access Point* untuk masing-masing bidang. Namun demikian, pengelolaan basis data operasional internal kantor (khususnya data kedisiplinan dan kinerja pegawai non-PNS/P3K) belum terpusat pada server basis data (*database server*), melainkan masih tersebar secara terisolasi pada komputer masing-masing staf administrasi dalam bentuk berkas lembar kerja spreadsheet (.xlsx). Gambaran pemetaan arsitektur infrastruktur TI berjalan disajikan pada Gambar 2.3.

```
+-----------------------------------------------------------------------------+
|                                                                             |
|                           INTERNET PUBLIK / CLOUD                           |
|                     (SP2KP Kemendag, SIHALAL, SIPD RI)                      |
|                                     |                                       |
+-------------------------------------+---------------------------------------+
                                      | Fiber Optic (Diskominfotik Kota)
                         +------------v-----------+
                         |  Router / Gateway LAN  |
                         +------------+-----------+
                                      |
            +-------------------------+-------------------------+
            |                                                   |
+-----------v-----------+                           +-----------v-----------+
| Access Point Wi-Fi    |                           | Switch LAN Hub        |
| (Area Kerja Bidang)   |                           | (Subbagian Tata Usaha)|
+-----------+-----------+                           +-----------+-----------+
            |                                                   |
    +-------+-------+                                   +-------+-------+
    |               |                                   |               |
[Smartphone   [Smartphone                           [PC Komputer    [PC Komputer
 Pegawai 1]    Pegawai 2]                            Staf Subbag]   Staf Kepegawaian]
(Kirim Foto   (Kirim Foto                           (Unduh Foto     (Ketik Ulang ke
 Presensi WA)  Laporan WA)                           dari WA Web)    File Excel)
```
*Gambar 2.3 Arsitektur Jaringan dan SI/TI Berjalan pada Disperindag*

## 2.2 Analisis Implementasi Sistem

### 2.2.1 Analisis Kondisi dan Masalah Absensi & Kinerja Pegawai P3K Saat Ini
Meskipun pemanfaatan teknologi informasi untuk layanan sektoral eksternal telah menggunakan portal web (SP2KP dan SIHALAL), tata kelola administrasi kedisiplinan internal dinas—khususnya terhadap 24 orang Pegawai Pemerintah dengan Perjanjian Kerja (P3K)—mengalami kesenjangan digital yang cukup tajam.

Berdasarkan hasil observasi dan wawancara langsung dengan pengelola kepegawaian dinas, alur pencatatan kehadiran dan evaluasi kegiatan harian pegawai P3K saat ini masih berjalan secara konvensional dan semi-manual dengan mekanisme sebagai berikut:
1. **Absensi via Swafoto WhatsApp**: Pegawai P3K yang tiba di kantor atau di lokasi tugas lapangan mengambil swafoto (*selfie*) menggunakan kamera telepon genggam yang dilengkapi fitur *watermark timestamp* dan koordinat GPS pihak ketiga (misalnya aplikasi *GPS Map Camera*). Foto tersebut kemudian dikirimkan ke grup percakapan WhatsApp kepegawaian dinas.
2. **Rekapitulasi Manual Satu per Satu**: Staf Subbagian Administrasi Kepegawaian setiap hari harus membuka grup WhatsApp, mengunduh puluhan gambar swafoto yang masuk, memeriksa stempel jam dan titik koordinat yang tertera pada gambar secara manual, kemudian mengetikkan data jam masuk dan status kehadiran satu per satu ke dalam lembar kerja Microsoft Excel.
3. **Pelaporan Kegiatan Tidak Terstandarisasi**: Mekanisme pelaporan tugas atau kegiatan kerja harian pegawai P3K dilakukan dengan mengirimkan foto dan narasi singkat melalui pesan obrolan grup WhatsApp. Kerap kali laporan kegiatan tidak mencantumkan deskripsi tugas secara terperinci, tidak ada standarisasi bobot pekerjaan, dan laporan menumpuk bercampur dengan pesan obrolan umum lainnya.
4. **Indeks Kinerja Pegawai (IKP) Sulit Diketahui Secara Objektif**: Ketiadaan basis data terpadu menyebabkan pengelola kepegawaian kesulitan menghitung akumulasi kedisiplinan (persentase hadir, total menit terlambat, total alpa) secara *real-time*. Evaluasi kinerja pegawai hanya dilakukan secara subjektif menjelang batas akhir perpanjangan kontrak tahunan dengan membuka kembali arsip lembar kerja Excel yang berisiko tercecer atau mengalami kesalahan input (*human error*).
5. **Penegakan Surat Peringatan (SP) Tidak Terdokumentasi Rapi**: Penentuan sanksi disiplin terhadap pegawai yang sering alpa atau meninggalkan tugas belum didukung oleh sistem peringatan dini (*early warning system*). Akibatnya, draf Surat Peringatan (SP-1, SP-2, maupun SP-3) sering terlambat diterbitkan dan penomorannya tidak terintegrasi secara otomatis dengan riwayat pelanggaran presensi.

### 2.2.2 Analisis Cross-Functional Flowchart (CFF) Alur Berjalan
Untuk memperjelas kelemahan proses bisnis yang sedang berjalan, disajikan diagram alur kerja lintas fungsi (*Cross-Functional Flowchart*) antara Pegawai P3K dan Admin/Staf Kepegawaian sebagaimana terlihat pada Gambar 2.4.

```
+====================================================================================================+
|                    CROSS-FUNCTIONAL FLOWCHART (CFF) ALUR PRESENSI & EVALUASI BERJALAN              |
+====================================================================================================+
|         PEGAWAI P3K              |               ADMIN / PENGELOLA KEPEGAWAIAN                     |
+----------------------------------+-----------------------------------------------------------------+
|                                  |                                                                 |
|         (  Mulai  )              |                                                                 |
|              |                   |                                                                 |
|              v                   |                                                                 |
|    [ Buka Kamera GPS ]           |                                                                 |
|              |                   |                                                                 |
|              v                   |                                                                 |
|   [ Ambil Foto Selfie ]          |                                                                 |
|              |                   |                                                                 |
|              v                   |                                                                 |
|  [ Kirim Foto & Laporan  ]       |                                                                 |
|  [ ke Grup WhatsApp WA   ]------>|--------> [ Buka Grup Chat WhatsApp Web ]                        |
|                                  |                        |                                        |
|                                  |                        v                                        |
|                                  |              [ Unduh Gambar Satu per Satu ]                     |
|                                  |                        |                                        |
|                                  |                        v                                        |
|                                  |             < Cek Jam & Lokasi Manual >                         |
|                                  |                        |                                        |
|                                  |                        v                                        |
|                                  |           [ Buka File Microsoft Excel ]                         |
|                                  |                        |                                        |
|                                  |                        v                                        |
|                                  |           [ Ketik Ulang Jam Masuk & Pulang ]                    |
|                                  |                        |                                        |
|                                  |                        v                                        |
|                                  |          [ Simpan File Excel di Komputer Lokal ]                |
|                                  |                        |                                        |
|                                  |                        v                                        |
|                                  |         < Apakah Waktu Evaluasi Kontrak? >                      |
|                                  |               |                     |                           |
|                                  |          (Ya) |                     | (Tidak)                   |
|                                  |               v                     v                           |
|                                  |     [ Rekap Manual Nilai ]      ( Selesai )                     |
|                                  |     [ Hitung IKP Subjektif ]                                    |
|                                  |     [ Ketik Format Surat SP ]                                   |
|                                  |               |                                                 |
|                                  |               v                                                 |
|                                  |          ( Selesai )                                            |
|                                  |                                                                 |
+====================================================================================================+
```
*Gambar 2.4 Cross-Functional Flowchart (CFF) Alur Presensi & Evaluasi Berjalan*

Berdasarkan analisis diagram alur di atas, dapat diidentifikasi titik-titik rawan (*pain points*) pada alur kerja berjalan:
* **Inefisiensi Waktu**: Admin menghabiskan waktu 1 hingga 2 jam setiap hari hanya untuk mengunduh dan menyalin data dari WhatsApp ke Excel.
* **Redundansi dan Risiko Human Error**: Data yang diketik ulang secara manual berpotensi salah catat jam atau salah tandai status kehadiran.
* **Ketiadaan Validasi Radius Otomatis**: Keabsahan titik koordinat pada foto kamera GPS tidak terverifikasi secara matematis terhadap perimeter radius resmi kantor dinas.
* **Ketiadaan Integrasi**: Penilaian kualitas laporan kegiatan dan riwayat presensi tidak terhubung langsung ke formula evaluasi perpanjangan kontrak.

Kelemahan-kelemahan inilah yang menjadi landasan utama urgensi perancangan sistem terpadu berbasis web: **SIP-PERFORMA**.

---

# BAB III
# HASIL KERJA PRAKTIK

## 3.1 Evaluasi dan Latar Belakang Pengembangan Sistem
Kerja Praktek yang dilaksanakan pada Dinas Perindustrian dan Perdagangan Kota Gorontalo difokuskan pada perancangan, pengembangan, dan implementasi aplikasi berbasis web bernama **SIP-PERFORMA (Sistem Informasi Absensi dan Evaluasi Kinerja Pegawai P3K)**. 

Berdasarkan hasil evaluasi mendalam terhadap kelemahan alur kerja manual pada Bab II, pengembangan sistem ini diarahkan untuk mencapai sasaran-sasaran strategis sebagai berikut:
1. **Otomatisasi Validasi Presensi Berbasis Geofence dan Kamera**: Menggantikan pengiriman swafoto WhatsApp dengan modul absensi web yang secara otomatis menghitung jarak geolokasi koordinat pegawai terhadap kantor dinas menggunakan algoritma lingkaran jarak bumi (*Haversine Formula*) dengan ambang batas radius maksimal 50 meter serta penangkapan citra swafoto langsung melalui kamera peramban (*web browser*).
2. **Standarisasi dan Penilaian Laporan Kegiatan**: Menyediakan formulir digital pelaporan kegiatan harian pegawai P3K yang dilengkapi pembuktian foto pekerjaan, perhitungan produktivitas otomatis berdasarkan empat kriteria terukur, serta fitur verifikasi dan penilaian kualitas (mutu A, B, C, D) oleh atasan atau admin dinas.
3. **Digitalisasi Manajemen Pengajuan Dispensasi**: Memfasilitasi pengajuan Izin, Cuti, Sakit, dan Penugasan Dinas Luar (Surat Perintah Tugas / SPT) secara terpadu tanpa formulir kertas (*paperless*), di mana pengajuan yang telah disetujui admin akan langsung memperbarui status presensi harian pegawai menjadi status resmi ('Izin', 'Sakit', 'Cuti', atau 'Dinas Luar').
4. **Kalkulasi Indeks Kinerja Pegawai (IKP) Objektif dan Akuntabel**: Mengotomatisasikan perhitungan skor kinerja bulanan berskala 0–100 berdasarkan pembobotan proporsional (60% Kehadiran, 25% Produktivitas, dan 15% Kualitas Kerja) sesuai parameter kebijakan dinas.
5. **Penegakan Disiplin Semiotomatis dan Manajemen SP**: Mencegah kelalaian penindakan pegawai melalui deteksi dini otomatis jumlah akumulasi alpa bulanan (ambang batas default: 3 Alpa &rarr; draf SP-1, 6 Alpa &rarr; draf SP-2, 9 Alpa &rarr; draf SP-3) yang terintegrasi dengan penerbitan nomor surat dinas dan pencetakan naskah dinas berformat PDF.

## 3.2 Analisis Kebutuhan Sistem

### 3.2.1 Analisis Kebutuhan Fungsional
Kebutuhan fungsional mendefinisikan kapabilitas dan fitur yang disediakan oleh sistem SIP-PERFORMA berdasarkan hak akses peran (*roles*):

#### A. Aktor Administrator (Admin Kepegawaian / Pimpinan)
1. **Autentikasi Akun**: Admin dapat melakukan login menggunakan email atau nama pengguna (*username*) terdaftar dengan autentikasi berbasis sesi (*session guard*).
2. **Dashboard Eksekutif**: Menampilkan statistik ringkas total pegawai aktif, persentase kehadiran harian, grafik tren capaian IKP rata-rata, dan diagram radar mutu pekerjaan.
3. **Manajemen Master Data Pegawai**: Admin dapat mengelola (tambah, lihat, ubah, hapus, reset kata sandi default) profil pegawai P3K yang mencakup NIP, Nama, Nomor HP, Alamat, Jabatan, dan Bidang/Unit Kerja.
4. **Monitoring Presensi Real-Time**: Melihat rekaman kehadiran seluruh pegawai per tanggal atau rentang bulan, status ketepatan waktu (*Tepat Waktu*, *Terlambat*), jarak meter presensi, serta memeriksa foto swafoto bukti kehadiran.
5. **Verifikasi Laporan Kegiatan**: Memeriksa laporan harian yang dikirimkan pegawai, membaca uraian tugas, melihat bukti foto pekerjaan, serta memberikan persetujuan status (*Disetujui* / *Ditolak*) disertai pemberian nilai mutu kualitas (A/B/C/D).
6. **Persetujuan Pengajuan Dispensasi**: Memeriksa permohonan Izin, Cuti, Sakit, dan Dinas Luar, meninjau berkas surat bukti dokter/SPT, serta menetapkan status persetujuan (*Disetujui* atau *Ditolak*).
7. **Evaluasi Indeks Kinerja Pegawai (IKP)**: Meninjau rincian nilai kehadiran, produktivitas, kualitas kerja, skor akhir IKP, kategori capaian (*Sangat Baik*, *Baik*, *Cukup*, *Kurang*), dan rekomendasi kelayakan perpanjangan kontrak.
8. **Pengelolaan Surat Peringatan (SP)**: Memeriksa draf SP yang dibangkitkan otomatis bagi pegawai yang melampaui ambang alpa, menetapkan nomor surat dinas resmi, menerbitkan status SP, serta mengunduh dokumen cetak surat resmi format PDF.
9. **Pusat Laporan dan Ekspor Multi-Format**: Mengunduh rekapitulasi data absensi (bulanan, tahunan, rentang tanggal), rekapitulasi kinerja, daftar kegiatan, dan rekapitulasi SP dalam format spreadsheet Microsoft Excel (.xlsx) dan dokumen cetak Adobe PDF (.pdf).
10. **Pengaturan Parameter Kantor**: Mengubah koordinat GPS lintang-bujur (*latitude-longitude*) kantor dinas, radius geofence (meter), jam batas masuk dan pulang, persentase bobot penilaian IKP, ambang batas alpa SP, serta pengaturan kebijakan kerja fleksibel hari Jumat (WFH Jumat).

#### B. Aktor Pegawai (Pegawai P3K)
1. **Autentikasi Akun**: Pegawai dapat login secara mandiri menggunakan kredensial akun yang telah didaftarkan administrator.
2. **Dashboard Pegawai**: Memantau persentase kehadiran pribadi bulan berjalan, sisa kuota hak cuti, ringkasan jumlah keterlambatan, serta status absensi hari ini.
3. **Perekaman Absensi Masuk dan Pulang**: Melakukan swafoto langsung melalui kamera gawai yang otomatis divalidasi dengan koordinat GPS dan formula Haversine untuk memastikan pegawai berada di dalam radius kantor pada rentang jam dinas yang ditentukan.
4. **Riwayat Kehadiran Mandiri**: Melihat riwayat jam datang, jam pulang, jarak meter, durasi kerja harian, dan mengekspor riwayat absensi pribadi ke dalam dokumen PDF.
5. **Pelaporan Kegiatan Harian**: Mengirimkan laporan rincian pekerjaan harian dilengkapi unggahan bukti foto kegiatan dan waktu pengiriman yang langsung dikalkulasi skor produktivitasnya oleh sistem.
6. **Pengajuan Izin, Cuti, Sakit, dan Dinas Luar**: Mengisi formulir dispensasi ketidakhadiran, menentukan rentang tanggal, memberikan keterangan alasan, serta mengunggah surat keterangan dokter atau dokumen penugasan resmi.
7. **Pemeriksaan Indeks Kinerja Pribadi**: Memantau rincian komponen nilai capaian IKP bulanan beserta catatan evaluasi mutu dari pimpinan.
8. **Pemeriksaan Status Surat Peringatan**: Memeriksa riwayat pelanggaran disiplin dan mengunduh berkas Surat Peringatan resmi apabila telah diterbitkan oleh dinas.
9. **Pengelolaan Profil**: Memperbarui informasi biodata pribadi dan melakukan pembaruan kata sandi (*change password*).

### 3.2.2 Analisis Kebutuhan Non-Fungsional & Aturan Bisnis
Sistem SIP-PERFORMA dirancang dengan memenuhi kriteria non-fungsional dan aturan bisnis (*business rules*) sebagai berikut:

1. **Aturan Geofencing Geografis**:
   * Titik koordinat resmi kantor dinas: `0.5573330, 123.0562500` (Jalan Achmad Nadjamuddin No. 25 Kota Gorontalo).
   * Radius toleransi absensi: maksimal 50 meter (dapat disesuaikan admin).
   * Algoritma penghitungan jarak memanfaatkan rumus trigonometri permukaan bola bumi (*Haversine Formula*):
     $$d = 2r \arcsin\left(\sqrt{\sin^2\left(\frac{\Delta\phi}{2}\right) + \cos(\phi_1)\cos(\phi_2)\sin^2\left(\frac{\Delta\lambda}{2}\right)}\right)$$
     Di mana $\phi$ adalah lintang (latitude), $\lambda$ adalah bujur (longitude), dan $r$ adalah jari-jari bumi ($6.371\text{ km}$).
2. **Aturan Jam Operasional Presensi**:
   * Jam Masuk Normal: 07:30 WITA s.d. Batas Tepat Waktu 08:30 WITA.
   * Toleransi Terlambat: 08:31 WITA s.d. Batas Akhir Masuk 09:00 WITA (dicatat berstatus *Terlambat*).
   * Di atas jam batas akhir masuk, formulir absen masuk otomatis ditutup (*disabled*).
   * Jam Pulang Normal: mulai 16:00 WITA s.d. Batas Akhir Pulang 18:00 WITA (Khusus hari Jumat jam pulang dimulai pukul 16:00 WITA).
3. **Aturan Evaluasi Indeks Kinerja Pegawai (IKP)**:
   * **Nilai Kehadiran (Bobot 60%)**: Dihitung dengan rumus:
     $$\text{Nilai Kehadiran} = \max(0, 100 - (5 \times \text{Jumlah Alpa}) - (2 \times \text{Jumlah Terlambat}))$$
   * **Nilai Produktivitas Laporan (Bobot 25%)**: Dihitung otomatis oleh model sistem saat laporan dibuat berdasarkan empat subindikator PRD:
     1. Kelengkapan rincian tugas (judul, tanggal, deskripsi $\ge 20$ karakter) = 25 poin.
     2. Unggahan bukti foto kegiatan = 25 poin.
     3. Ketepatan waktu pelaporan (dilaporkan pada hari H) = 20 poin.
     4. Pemenuhan target volume kegiatan harian ($\ge 1$ laporan/hari) = 30 poin.
     Total = 100 poin.
   * **Nilai Kualitas Kerja (Bobot 15%)**: Ditentukan melalui verifikasi atasan: Mutu A (95 poin), Mutu B (85 poin), Mutu C (75 poin), dan Mutu D (60 poin).
   * **Kategori Akhir IKP**: $\ge 90$ (Sangat Baik / Diperpanjang), $80 - 89.9$ (Baik / Diperpanjang), $70 - 79.9$ (Cukup / Dipertimbangkan), dan $< 70$ (Kurang / Tidak Diperpanjang).
4. **Aturan Penegakan Surat Peringatan (SP)**:
   * Apabila jumlah akumulasi status Alpa pegawai dalam rentang pemantauan mencapai 3 hari, sistem secara otomatis membangkitkan draf SP-1.
   * Jika mencapai 6 hari Alpa &rarr; draf SP-2; dan jika mencapai 9 hari Alpa &rarr; draf SP-3.
   * Draf SP yang terbit otomatis tidak langsung terlihat oleh pegawai sebelum Administrator memeriksa, memasukkan nomor surat agenda keluar resmi dinas, dan menekan tombol *Terbitkan*.

## 3.3 Analisis Proses Bisnis Usulan (Flowchart Usulan)
Proses bisnis yang diusulkan pada aplikasi SIP-PERFORMA mengintegrasikan seluruh alur presensi, pelaporan tugas, dan pemantauan kinerja secara terpusat pada sistem berbasis web. Diagram alir proses bisnis usulan dapat dilihat pada Gambar 3.1.

```
+====================================================================================================+
|                         FLOWCHART PROSES BISNIS USULAN SISTEM SIP-PERFORMA                         |
+====================================================================================================+
|             PEGAWAI P3K                 |        SISTEM SIP-PERFORMA       |     ADMINISTRATOR     |
+-----------------------------------------+----------------------------------+-----------------------+
|                                         |                                  |                       |
|               ( Mulai )                 |                                  |                       |
|                   |                     |                                  |                       |
|                   v                     |                                  |                       |
|           [ Akses Sistem Web ]--------->|--[ Validasi Login Sesi ]         |                       |
|                   |                     |              |                   |                       |
|                   v                     |              v                   |                       |
|           [ Pilih Absen Masuk ]         |    [ Periksa Jam Dinas ]         |                       |
|                   |                     |              |                   |                       |
|                   v                     |              v                   |                       |
|         < Tangkap GPS & Kamera >------->|--< Cek Radius Haversine <= 50m? >|                       |
|                   |                     |        |            |            |                       |
|                   |                     |   (Ya) |            | (Tidak)    |                       |
|                   |                     |        v            v            |                       |
|                   |                     |  [ Simpan Data]  [ Tolak Absen ] |                       |
|                   |                     |  [ Presensi Masuk]               |                       |
|                   v                     |        |                         |                       |
|        [ Input Laporan Kegiatan ]------>|--------+                         |                       |
|        [ dan Upload Foto Bukti  ]       |        |                         |                       |
|                   |                     |        v                         |                       |
|                   |                     |  [ Hitung Produktivitas Auto ]   |                       |
|                   |                     |  [ Status: Menunggu Review   ]-->|-->[ Review Kegiatan &]|
|                   |                     |        |                         |   [ Beri Nilai Mutu  ]|
|                   v                     |        v                         |           |           |
|         [ Ajukan Izin/Sakit/Cuti ]----->|--[ Simpan Pengajuan Status ]---->|-->[ Setujui/Tolak    ]|
|                   |                     |        |                         |   [ Pengajuan Izin   ]|
|                   v                     |        v                         |           |           |
|           [ Pilih Absen Pulang ]------->|--< Cek Jam Kerja Selesai? >      |           |           |
|                                         |        |                         |           |           |
|                                         |        v                         |           |           |
|                                         |  [ Rekap Otomatis IKP Bulanan ]<-|-----------+           |
|                                         |        |                                                 |
|                                         |        v                                                 |
|                                         |  < Akumulasi Alpa >= Ambang? >                           |
|                                         |        |                 |                               |
|                                         |   (Ya) |                 | (Tidak)                       |
|                                         |        v                 v                               |
|                                         |  [ Buat Draf SP ]    [ Update Rekap IKP ]                |
|                                         |        |                 |                               |
|                                         |        v                 v                               |
|                                         |  [ Admin Terbitkan SP ] [ Ekspor Laporan Excel/PDF ]     |
|                                         |        |                 |                               |
|                                         |        v                 v                               |
|                                         |   ( Selesai )       ( Selesai )                          |
|                                         |                                                          |
+====================================================================================================+
```
*Gambar 3.1 Flowchart Usulan Sistem SIP-PERFORMA*

## 3.4 Pemodelan Sistem

### 3.4.1 Identifikasi External Entity
Pemodelan fungsional diawali dengan mendefinisikan entitas luar (*External Entity*) yang berinteraksi secara langsung mengirimkan input atau menerima output data dari sistem SIP-PERFORMA, sebagaimana disajikan pada Tabel 3.1.

*Tabel 3.1 Identifikasi External Entity Sistem SIP-PERFORMA*
| Entitas Luar | Deskripsi | Peran Interaksi Data |
|---|---|---|
| **Administrator (Admin Kepegawaian)** | Staf atau pengelola Subbagian Kepegawaian dan Umum dinas | Memasukkan data master pegawai, memvalidasi laporan kegiatan, memproses pengajuan izin, menetapkan nomor SP, dan mengunduh berkas laporan |
| **Pegawai P3K** | Seluruh staf aparatur berstatus P3K di lingkungan Disperindag | Mengirimkan koordinat lokasi GPS, citra swafoto, formulir laporan kegiatan harian, permohonan dispensasi, serta menerima rekap IKP pribadi |
| **Pimpinan (Kepala Dinas / Sekretaris)** | Pucuk pimpinan perangkat daerah yang memiliki hak evaluasi | Menerima laporan eksekutif berkala mengenai tingkat kedisiplinan dan rekomendasi kontrak pegawai |
| **Perangkat Sensor GPS & Kamera** | Modul peramban perangkat seluler (*hardware interface*) | Memberikan aliran data posisi lintang-bujur dan berkas citra mentah kepada sistem |

### 3.4.2 Diagram Konteks
Diagram Konteks menggambarkan batasan (*boundary*) sistem secara global dalam satu proses utama (Proses 0) yang menghubungkan entitas luar dengan sistem SIP-PERFORMA, sebagaimana digambarkan pada Gambar 3.2.

```
+------------------+                                                    +------------------+
|                  | ---------------- Data Master Pegawai -------------> |                  |
|                  | ---------------- Verifikasi Kegiatan -------------> |                  |
|                  | ---------------- Persetujuan Izin/Sakit/Cuti -----> |                  |
|  ADMINISTRATOR   | ---------------- Nomor & Penerbitan SP -----------> |                  |
|   (KEPEGAWAIAN)  | ---------------- Pengaturan Radius & Jam ----------> |                  |
|                  | <--------------- Rekap Absensi Seluruh Pegawai ---- |                  |
|                  | <--------------- Berkas Laporan Excel/PDF --------- |                  |
+------------------+ <--------------- Notifikasi Draf SP --------------- |                  |
                                                                         |      SISTEM      |
+------------------+                                                     |   SIP-PERFORMA   |
|                  | ---------------- Koordinat GPS & Swafoto Masuk ---->|   (PROSES 0)     |
|                  | ---------------- Koordinat GPS & Swafoto Pulang --->|                  |
|   PEGAWAI P3K    | ---------------- Data Laporan Kegiatan & Foto ----> |                  |
|                  | ---------------- Pengajuan Izin/Sakit/Cuti/Dinas -> |                  |
|                  | <--------------- Status Presensi & Validasi Radius - |                  |
|                  | <--------------- Rincian Nilai IKP Pribadi -------- |                  |
|                  | <--------------- Dokumen Surat Peringatan (PDF) --- |                  |
+------------------+                                                     |                  |
                                                                         |                  |
+------------------+                                                     |                  |
|     PIMPINAN     | <--------------- Laporan Eksekutif Disiplin ------- |                  |
|   (KEPALA DINAS) | <--------------- Rekomendasi Kontrak Kerja Tahunan- |                  |
+------------------+                                                    +------------------+
```
*Gambar 3.2 Diagram Konteks Sistem SIP-PERFORMA*

### 3.4.3 Hierarchy Chart (Diagram Dekomposisi Fungsi)
Hierarchy Chart membagi sistem SIP-PERFORMA ke dalam modul-modul fungsional utama dan submodul di bawahnya, seperti diperlihatkan pada Gambar 3.3.

```
                                      0.0
                              SISTEM INFORMASI
                                SIP-PERFORMA
                                     |
       +-----------------+-----------+-----------+-----------------+
       |                 |                       |                 |
      1.0               2.0                     3.0               4.0
   MODUL DATA       MODUL PRESENSI        MODUL KEGIATAN    MODUL EVALUASI
   & PENGGUNA       & DISPENSASI              HARIAN        & REKAPITULASI
       |                 |                       |                 |
  +----+----+       +----+----+             +----+----+       +----+----+
  |         |       |         |             |         |       |         |
 1.1       1.2     2.1       2.2           3.1       3.2     4.1       4.2
Kelola   Kelola   Absen    Pengajuan      Kirim   Verifikasi Hitung  Cetak
Data     Akun     GPS &    Izin/Cuti/     Laporan & Nilai    IKP &   Laporan
Pegawai  Admin    Kamera   Sakit/SPT      Harian  Kualitas   SP Auto Excel/PDF
```
*Gambar 3.3 Hierarchy Chart (Dekomposisi Fungsional Sistem)*

### 3.4.4 Data Flow Diagram (DFD) Level 0
Diagram Alir Data Level 0 menjabarkan proses 0 menjadi empat proses utama yang saling bertukar data dengan penyimpanan data (*data store*), sebagaimana disajikan pada Gambar 3.4.

```
                               +----------------+
                               |  PEGAWAI P3K   |
                               +-------+--------+
                                       |
                Data Presensi (GPS/Foto)|  ^ Info Status & Riwayat
                                       v  |
                              +--------+-------+
                              |      1.0       | <======== [D3: presensi]
                              |   MANAJEMEN    |
                              |    PRESENSI    | ========> [D3: presensi]
                              +----------------+
                                       |
                Laporan & Foto Tugas   |  ^ Status Verifikasi
                                       v  |
                              +--------+-------+
                              |      2.0       | <======== [D4: laporan_kegiatan]
                              |   MANAJEMEN    |
                              |    KEGIATAN    | ========> [D4: laporan_kegiatan]
                              +----------------+
                                       |
                Formulir Izin / Sakit  |  ^ Status Persetujuan
                                       v  |
                              +--------+-------+
                              |      3.0       | <======== [D5: pengajuan_izin]
                              |   PENGAJUAN    |
                              |  & DISPENSASI  | ========> [D5: pengajuan_izin]
                              +----------------+
                                       |
                                       v
                              +----------------+
                              |      4.0       | <======== [D6: skor_kinerja]
                              |  EVALUASI IKP  | <======== [D7: surat_peringatan]
                              |    & SP AUTO   | ========> [D6: skor_kinerja]
                              +--------+-------+ ========> [D7: surat_peringatan]
                                       |
                      Ekspor Laporan   |  ^ Draf SP & Data IKP
                                       v  |
                               +-------+--------+
                               | ADMINISTRATOR  |
                               +----------------+
```
*Gambar 3.4 Data Flow Diagram (DFD) Level 0*

### 3.4.5 Data Flow Diagram (DFD) Level 1
Penjabaran rinci dari masing-masing proses pada Level 0 diuraikan sebagai berikut:

#### A. DFD Level 1 Proses 1.0 (Manajemen Presensi)
```
+-------------+
| PEGAWAI P3K | ---- Koordinat & Foto ----> [ 1.1 Validasi Geofence & Waktu ]
+-------------+                                      |
       ^                                             | (Lolos Validasi)
       |                                             v
       | <--- Rekap Kehadiran Pribadi ----- [ 1.2 Catat Presensi Harian ] ===> [D3: presensi]
       |                                             |
       |                                             v
+-------------+ <--- Monitoring Kehadiran - [ 1.3 Tampilkan Presensi Admin ]
|    ADMIN    |
+-------------+
```
*Gambar 3.5 DFD Level 1 Proses 1 (Manajemen Presensi)*

#### B. DFD Level 1 Proses 2.0 (Manajemen Laporan Kegiatan)
```
+-------------+
| PEGAWAI P3K | ---- Form Kegiatan & Foto -> [ 2.1 Kalkulasi Produktivitas Auto ]
+-------------+                                             |
       ^                                                    | Simpan Draft Review
       |                                                    v
       | <--- Umpan Balik Mutu (A/B/C/D) --- [ 2.2 Verifikasi Kualitas Atasan ] <--- Nilai Admin
       |                                                    |                     (dari ADMIN)
       |                                                    v
       +========================================= [D4: laporan_kegiatan]
```
*Gambar 3.6 DFD Level 1 Proses 2 (Manajemen Laporan Kegiatan)*

#### C. DFD Level 1 Proses 3.0 (Manajemen Pengajuan & Dispensasi)
```
+-------------+
| PEGAWAI P3K | ---- Data Sakit/Izin/Cuti -> [ 3.1 Terima Permohonan Izin ] ===> [D5: pengajuan_izin]
+-------------+                                             |
                                                            v
+-------------+                                 [ 3.2 Tinjau Berkas Dokumen ]
|    ADMIN    | <--- Notifikasi Pengajuan ------------------+
+------+------+
       |
       +------------ Putusan (Setuju/Tolak) ------> [ 3.3 Eksekusi Status Presensi ]
                                                            |
                                                            v
                                            [ Update Status: Izin/Sakit/Cuti ] ===> [D3: presensi]
```
*Gambar 3.7 DFD Level 1 Proses 3 (Manajemen Pengajuan & Dispensasi)*

#### D. DFD Level 1 Proses 4.0 (Perhitungan Kinerja & Penerbitan SP)
```
[D3: presensi] ----------> [ 4.1 Hitung Kehadiran (Bobot 60%) ]
                                        |
[D4: laporan_kegiatan] --> [ 4.2 Hitung Mutu & Volume (40%)  ]
                                        |
                                        v
                           [ 4.3 Agregasi Skor IKP Bulanan   ] ===> [D6: skor_kinerja]
                                        |
                                        v
                           < Deteksi Ambang Alpa >= 3 Hari?  >
                               |                    |
                          (Ya) |                    | (Tidak)
                               v                    v
                     [ 4.4 Buat Draf SP ]    [ 4.5 Cetak Rekapitulasi ]
                               |                    |
                               v                    v
                   [D7: surat_peringatan]      [ Berkas Excel / PDF ]
                               |                    |
                               v                    v
                         (Ke ADMINISTRATOR & PEGAWAI P3K)
```
*Gambar 3.8 DFD Level 1 Proses 4 (Perhitungan Kinerja & Penerbitan SP)*

## 3.5 Perancangan Basis Data (Database Design)

### 3.5.1 Entity Relationship Diagram (ERD)
Sistem basis data dirancang secara terelasi (*relational database*) dengan menggunakan mesin penyimpanan MySQL/MariaDB InnoDB berenkoding `utf8mb4_unicode_ci`. Seluruh tabel operasional menerapkan integritas referensial kunci asing (*foreign key*) yang merujuk pada tabel induk `pegawai` dengan kebijakan `ON DELETE CASCADE`. Diagram keterhubungan antar-entitas (ERD) disajikan pada Gambar 3.9.

```
+-----------------------------------+
|             pengguna              |
+-----------------------------------+
| id (PK)                           |
| pegawai_id (FK, nullable) --------+
| nama                              |
| username                          |
| email                             |
| password                          |
| peran (admin/pegawai)             |
| status (aktif/nonaktif)           |
+-----------------------------------+
                                    |
                                    | 1
+-----------------------------------v+
|              pegawai               |
+------------------------------------+
| id (PK)                            |
| nip                                |
| nama                               |
| no_hp                              |
| jabatan                            |
| bidang                             |
| alamat                             |
| foto                               |
| status (Aktif/Cuti)                |
+--+-------+--------+--------+-------+
   | 1     | 1      | 1      | 1     | 1
   |       |        |        |       |
   | N     | N      | N      | N     | N
+--v-------v+ +-----v--------+ +-----v--------+ +-----v--------+ +-----v---------------+
| presensi  | |laporan_kegiat| |pengajuan_izin| |skor_kinerja  | |  surat_peringatan   |
+-----------+ +--------------+ +--------------+ +--------------+ +---------------------+
|id (PK)    | |id (PK)       | |id (PK)       | |id (PK)       | |id (PK)              |
|pegawai_id | |pegawai_id    | |pegawai_id    | |pegawai_id    | |pegawai_id           |
|tanggal    | |tanggal       | |jenis         | |periode       | |tingkat_sp (SP-1..3) |
|jam_masuk  | |nama_kegiatan | |tgl_mulai     | |nilai_hadir   | |jumlah_alpha         |
|status_msk | |deskripsi     | |tgl_selesai   | |nilai_prod    | |nomor_surat          |
|foto_masuk | |foto          | |alasan        | |nilai_kual    | |tanggal_terbit       |
|jam_pulang | |nilai_prod    | |dokumen       | |nilai_akhir   | |dokumen              |
|status_plg | |nilai_kual    | |status        | |kategori      | |status (Aktif/Selsai)|
|foto_pulang| |status_verif  | |tgl_disetujui | |rekom_kontrak | +---------------------+
|status (H/T| +--------------+ +--------------+ +--------------+
|/A/I/C/D/S)|
+-----------+
```
*Gambar 3.9 Entity Relationship Diagram (ERD) Sistem SIP-PERFORMA*

### 3.5.2 Struktur Tabel dan Kamus Data
Rincian kamus data (*data dictionary*) untuk tabel-tabel utama penyusun basis data sistem adalah sebagai berikut:

#### 1. Tabel `pegawai` (Master Data Pegawai P3K)
Menyimpan informasi identitas kepegawaian aparatur P3K.

*Tabel 3.2 Struktur Tabel `pegawai`*
| Nama Kolom | Tipe Data | Panjang/Nilai | Null | Atribut | Keterangan |
|---|---|---|---|---|---|
| `id` | BIGINT | 20 | No | PK, Auto Increment | Kunci primer identitas pegawai |
| `nip` | VARCHAR | 30 | No | Unique | Nomor Induk Pegawai P3K |
| `nama` | VARCHAR | 255 | No | - | Nama lengkap beserta gelar |
| `no_hp` | VARCHAR | 20 | Yes | - | Nomor kontak WhatsApp aktif |
| `jabatan` | VARCHAR | 100 | No | - | Nama jabatan fungsional/teknis |
| `bidang` | ENUM | 'Perindustrian', 'Perdagangan', 'Sekretariat', 'Perlindungan Konsumen' | No | - | Penempatan unit bidang kerja dinas |
| `alamat` | TEXT | - | Yes | - | Alamat tempat tinggal |
| `foto` | VARCHAR | 255 | Yes | - | Berkas foto profil pegawai |
| `status` | ENUM | 'Aktif', 'Cuti' | No | Default: 'Aktif' | Status keaktifan dinas |

#### 2. Tabel `pengguna` (Otorisasi dan Kredensial Pengguna)
Menyimpan akun login untuk admin dan pegawai.

*Tabel 3.3 Struktur Tabel `pengguna`*
| Nama Kolom | Tipe Data | Panjang/Nilai | Null | Atribut | Keterangan |
|---|---|---|---|---|---|
| `id` | BIGINT | 20 | No | PK, Auto Increment | Kunci primer pengguna |
| `pegawai_id` | BIGINT | 20 | Yes | FK `pegawai.id` | Asosiasi ke data pegawai (null jika admin) |
| `nama` | VARCHAR | 255 | No | - | Nama tampilan akun |
| `username` | VARCHAR | 100 | No | Unique | Nama pengguna untuk login |
| `email` | VARCHAR | 255 | No | Unique | Alamat surat elektronik |
| `password` | VARCHAR | 255 | No | - | Kata sandi terenkripsi Bcrypt (Hash) |
| `peran` | ENUM | 'admin', 'pegawai' | No | Default: 'pegawai' | Hak akses tingkat otorisasi |
| `status` | ENUM | 'aktif', 'nonaktif' | No | Default: 'aktif' | Status izin akses ke sistem |

#### 3. Tabel `presensi` (Rekapitulasi Kehadiran Harian)
Menyimpan rekaman transaksi absensi harian dan status dispensasi.

*Tabel 3.4 Struktur Tabel `presensi`*
| Nama Kolom | Tipe Data | Panjang/Nilai | Null | Atribut | Keterangan |
|---|---|---|---|---|---|
| `id` | BIGINT | 20 | No | PK, Auto Increment | Kunci primer rekaman absensi |
| `pegawai_id` | BIGINT | 20 | No | FK `pegawai.id` | ID pegawai bersangkutan |
| `tanggal` | DATE | - | No | - | Tanggal pelaksanaan absensi |
| `jam_masuk` | TIME | - | Yes | - | Waktu kedatangan pegawai |
| `status_masuk` | ENUM | 'Tepat Waktu', 'Terlambat' | Yes | - | Kategori ketepatan waktu datang |
| `jarak_masuk` | DECIMAL | 8,2 | Yes | - | Jarak meter geofence saat datang |
| `foto_masuk` | VARCHAR | 255 | Yes | - | Jalur berkas swafoto kedatangan |
| `jam_pulang` | TIME | - | Yes | - | Waktu kepulangan pegawai |
| `status_pulang`| ENUM | 'Tepat Waktu', 'Pulang Cepat' | Yes | - | Kategori kepulangan |
| `jarak_pulang`| DECIMAL | 8,2 | Yes | - | Jarak meter geofence saat pulang |
| `foto_pulang` | VARCHAR | 255 | Yes | - | Jalur berkas swafoto kepulangan |
| `status` | ENUM | 'Hadir', 'Terlambat', 'Alpha', 'Izin', 'Cuti', 'Dinas Luar', 'Sakit' | No | Default: 'Hadir' | Status resmi catatan kehadiran |

#### 4. Tabel `laporan_kegiatan` (Laporan Pekerjaan Harian)
*Tabel 3.5 Struktur Tabel `laporan_kegiatan`*
| Nama Kolom | Tipe Data | Null | Keterangan |
|---|---|---|---|
| `id` | BIGINT (PK) | No | Kunci primer data laporan |
| `pegawai_id` | BIGINT (FK) | No | Asosiasi identitas pegawai pelapor |
| `tanggal` | DATE | No | Tanggal pelaksanaan pekerjaan |
| `nama_kegiatan`| VARCHAR(255) | No | Judul atau ringkasan pekerjaan |
| `deskripsi` | TEXT | No | Rincian capaian dan uraian teknis tugas |
| `foto` | VARCHAR(255) | Yes | Foto bukti dokumentasi pekerjaan |
| `waktu_kirim` | TIME | Yes | Waktu pengiriman laporan oleh pegawai |
| `nilai_produktivitas` | DECIMAL(5,2) | No | Nilai produktivitas otomatis (skala 0–100) |
| `kategori_produktivitas` | VARCHAR(50) | Yes | Sangat Baik / Baik / Cukup / Kurang |
| `nilai_kualitas` | DECIMAL(5,2) | No | Nilai mutu dari atasan (95, 85, 75, 60) |
| `kategori_kualitas` | VARCHAR(10) | Yes | Kategori mutu mutu: A, B, C, atau D |
| `status_verifikasi` | ENUM | No | 'Menunggu Review', 'Disetujui', 'Ditolak' |

#### 5. Tabel `pengajuan_izin` (Dispensasi Kehadiran)
*Tabel 3.6 Struktur Tabel `pengajuan_izin`*
| Nama Kolom | Tipe Data | Null | Keterangan |
|---|---|---|---|
| `id` | BIGINT (PK) | No | Kunci primer data pengajuan |
| `pegawai_id` | BIGINT (FK) | No | Identitas pegawai pemohon |
| `jenis` | ENUM | No | 'Izin', 'Cuti', 'Sakit', 'Dinas Luar' |
| `tanggal_mulai` | DATE | No | Tanggal mulai dispensasi |
| `tanggal_selesai` | DATE | No | Tanggal berakhir dispensasi |
| `alasan` | TEXT | No | Keterangan alasan pengajuan |
| `dokumen` | VARCHAR(255) | Yes | Berkas bukti lampiran (surat dokter/SPT) |
| `status` | ENUM | No | 'Menunggu Review', 'Disetujui', 'Ditolak' |
| `catatan_admin` | TEXT | Yes | Catatan persetujuan atau penolakan admin |
| `tanggal_disetujui` | TIMESTAMP | Yes | Waktu peninjauan oleh admin |

#### 6. Tabel `skor_kinerja` (Rekapitulasi IKP Bulanan)
*Tabel 3.7 Struktur Tabel `skor_kinerja`*
| Nama Kolom | Tipe Data | Null | Keterangan |
|---|---|---|---|
| `id` | BIGINT (PK) | No | Kunci primer data skor kinerja |
| `pegawai_id` | BIGINT (FK) | No | Identitas pegawai |
| `periode` | VARCHAR(20) | No | Periode bulan evaluasi (contoh: '2026-09') |
| `nilai_kehadiran` | DECIMAL(5,2) | No | Skor persentase kehadiran (bobot 60%) |
| `nilai_produktivitas`| DECIMAL(5,2)| No | Rata-rata skor produktivitas (bobot 25%) |
| `nilai_kualitas` | DECIMAL(5,2) | No | Rata-rata nilai kualitas kerja (bobot 15%) |
| `nilai_akhir` | DECIMAL(5,2) | No | Skor akhir Indeks Kinerja Pegawai (IKP) |
| `kategori` | ENUM | No | 'Sangat Baik', 'Baik', 'Cukup', 'Kurang' |
| `status` | ENUM | No | 'Final', 'Draft' |
| `rekomendasi_kontrak`| ENUM | No | 'Diperpanjang', 'Dipertimbangkan', 'Tidak Diperpanjang' |

#### 7. Tabel `surat_peringatan` (Penegakan Sanksi Disiplin)
*Tabel 3.8 Struktur Tabel `surat_peringatan`*
| Nama Kolom | Tipe Data | Null | Keterangan |
|---|---|---|---|
| `id` | BIGINT (PK) | No | Kunci primer arsip surat peringatan |
| `pegawai_id` | BIGINT (FK) | No | Identitas pegawai yang melakukan pelanggaran |
| `tingkat_sp` | ENUM | No | Tingkat sanksi: 'SP-1', 'SP-2', 'SP-3' |
| `jumlah_alpha` | INT | No | Akumulasi hari alpa pemicu surat |
| `nomor_surat` | VARCHAR(100)| No | Nomor surat agenda resmi dinas |
| `tanggal_terbit` | DATE | No | Tanggal pengesahan penerbitan SP |
| `dokumen` | VARCHAR(255)| Yes | Berkas cetakan naskah surat PDF |
| `status` | ENUM | No | 'Aktif', 'Selesai' |

#### 8. Tabel `pengaturan_kantor` (Konfigurasi Global Sistem)
*Tabel 3.9 Struktur Tabel `pengaturan_kantor`*
| Nama Kolom | Tipe Data | Default | Keterangan |
|---|---|---|---|
| `id` | BIGINT (PK) | 1 | Baris tunggal konfigurasi sistem |
| `nama_skpd` | VARCHAR(255)| Disperindag Kota Gorontalo | Nama instansi pengguna |
| `titik_koordinat` | VARCHAR(100)| 0.5573330,123.0562500 | Titik koordinat pusat kantor dinas |
| `radius_absensi_meter`| INT | 50 | Batas toleransi radius absensi (meter) |
| `jam_masuk` | TIME | 07:30:00 | Jam awal presensi datang |
| `batas_terlambat` | TIME | 08:30:00 | Batas toleransi tepat waktu |
| `batas_akhir_masuk` | TIME | 09:00:00 | Batas akhir form absen masuk dibuka |
| `jam_pulang` | TIME | 16:00:00 | Jam awal presensi kepulangan |
| `bobot_kehadiran` | DECIMAL(5,2)| 60.00 | Bobot nilai kehadiran IKP (%) |
| `bobot_produktivitas`| DECIMAL(5,2)| 25.00 | Bobot nilai produktivitas kegiatan IKP (%)|
| `bobot_kualitas` | DECIMAL(5,2)| 15.00 | Bobot nilai kualitas mutu atasan IKP (%) |
| `ambang_sp1` | INT | 3 | Jumlah alpa pemicu draf otomatis SP-1 |
| `ambang_sp2` | INT | 6 | Jumlah alpa pemicu draf otomatis SP-2 |
| `ambang_sp3` | INT | 9 | Jumlah alpa pemicu draf otomatis SP-3 |
| `is_wfh_jumat` | BOOLEAN | 0 | Kebijakan fleksibilitas radius hari Jumat |

## 3.6 Arsitektur Perangkat Lunak dan Teknologi Pengembangan
Sistem SIP-PERFORMA dibangun dengan menerapkan paradigma arsitektur perangkat lunak modern monolitik terstruktur berbasis pola **Model-View-Controller (MVC)** menggunakan ekosistem framework Laravel, sebagaimana diilustrasikan pada Gambar 3.10.

```
       +---------------------------------------------------------+
       |             CLIENT BROWSER (LAPTOP / SMARTPHONE)        |
       |     HTML5 + Tailwind CSS + Vanilla JS + Geolocation API |
       +----------------------------+----------------------------+
                                    | Request HTTP(S) / CSRF
                                    v
       +---------------------------------------------------------+
       |                ROUTER & MIDDLEWARE LAYER                |
       |  routes/web.php -> AuthMiddleware -> RoleMiddleware     |
       +----------------------------+----------------------------+
                                    | Dispatch Controller
                                    v
       +---------------------------------------------------------+
       |                    CONTROLLER LAYER                     |
       |  AdminDashboard, AdminPegawai, AdminAbsensi, AdminSp,   |
       |  PegawaiAbsensi, PegawaiKegiatan, PegawaiPengajuan      |
       +--------------+---------------------------+--------------+
                      | Mengolah Data             | Merender View
                      v                           v
       +-------------------------+ +-----------------------------+
       |       MODEL LAYER       | |         VIEW LAYER          |
       |  Eloquent ORM           | |  Blade Templating Engine    |
       |  (Pegawai, Presensi,    | |  Chart.js (Grafik Radar/Line|
       |   SkorKinerja, SP, dll) | |  SweetAlert2 (Notifikasi UI)|
       +--------------+----------+ +-----------------------------+
                      | Query SQL
                      v
       +-------------------------+
       |      DATABASE LAYER     |
       |  MySQL 8.0 (InnoDB)     |
       +-------------------------+
```
*Gambar 3.10 Arsitektur Software Model-View-Controller (MVC) Laravel*

Adapun tumpukan teknologi (*technology stack*) yang terverifikasi digunakan dalam pembangunan sistem ini meliputi:
1. **Bahasa Pemrograman**: PHP versi ^8.3 dengan fitur keamanan *strict typing*, *match expressions*, dan *type casting*.
2. **Framework Backend**: Laravel versi ^13.17 yang menyediakan *routing engine*, *Eloquent ORM*, *middleware role management*, dan *console scheduler*.
3. **Basis Data**: MySQL versi 8.0 Community Server dengan dukungan transaksi ACID (*Atomicity, Consistency, Isolation, Durability*) dan integritas relasional kunci asing.
4. **Desain Tampilan & CSS**: Tailwind CSS versi modern dengan *build tool* Vite ^8, menghasilkan antarmuka aplikasi yang responsif pada berbagai resolusi layar peramban komputer desktop maupun gawai seluler (*mobile-first approach*).
5. **Pustaka Pembuat Berkas (Export Engine)**:
   * `barryvdh/laravel-dompdf` versi ^3.1: Untuk menghasilkan berkas laporan cetak berformat PDF (seperti kartu presensi bulanan dan naskah resmi Surat Peringatan).
   * `maatwebsite/excel` versi ^4.0: Untuk menghasilkan berkas laporan rekapitulasi data kepegawaian dalam format spreadsheet (.xlsx).
6. **Pustaka Visualisasi & Interaktivitas Sisi Klien**:
   * *Chart.js*: Menampilkan diagram radar tiga dimensi komposisi kinerja dan grafik garis tren bulanan.
   * *SweetAlert2*: Memberikan umpan balik dialog konfirmasi aksi dan notifikasi status yang elegan.
   * *HTML5 Geolocation API & Canvas*: Mengakses sensor posisi gawai dan melakukan kompresi citra kamera serta pembubuhan stempel koordinat air (*watermark*) di sisi peramban sebelum diunggah ke server.

## 3.7 Implementasi Antarmuka Sistem
Bagian ini menyajikan rancangan antarmuka visual pengguna (*User Interface*) dari implementasi sistem SIP-PERFORMA:

### 3.7.1 Antarmuka Autentikasi dan Login
Halaman login berfungsi sebagai gerbang keamanan sistem yang memvalidasi identitas akun administrator maupun pegawai P3K. Formulir login mendukung input nama pengguna atau alamat email, dilengkapi fitur alih peran (*role switch tab*), serta proteksi serangan *Cross-Site Request Forgery* (CSRF Token).

```
+--------------------------------------------------------------------------+
|                       [PLACEHOLDER GAMBAR 3.11]                          |
|             Tangkapan Layar Antarmuka Halaman Login Sistem               |
|      (SIP-PERFORMA: Dinas Perindustrian dan Perdagangan Kota Gorontalo)  |
+--------------------------------------------------------------------------+
```
*Gambar 3.11 Halaman Login Sistem SIP-PERFORMA*

### 3.7.2 Antarmuka Administrator

#### 1. Dashboard Utama Admin
Menampilkan kartu metrik rekapitulasi jumlah pegawai aktif, persentase kehadiran hari ini, jumlah pegawai terlambat, diagram radar rata-rata capaian tiga indikator kinerja (Kehadiran, Produktivitas, Kualitas), serta grafik garis tren IKP SKPD selama enam bulan terakhir.

```
+--------------------------------------------------------------------------+
|                       [PLACEHOLDER GAMBAR 3.12]                          |
|                  Tampilan Halaman Dashboard Admin                        |
+--------------------------------------------------------------------------+
```
*Gambar 3.12 Tampilan Dashboard Utama Admin*

#### 2. Monitoring Presensi Harian
Menyajikan tabel rekaman absensi seluruh pegawai yang diperbarui secara langsung. Dilengkapi filter status (*Tepat Waktu, Terlambat, Alpha, Izin, Sakit, Cuti, Dinas Luar*), jarak meter geofence, serta tautan modal pembesar untuk memeriksa foto bukti swafoto kedatangan dan kepulangan.

```
+--------------------------------------------------------------------------+
|                       [PLACEHOLDER GAMBAR 3.13]                          |
|              Tampilan Halaman Monitoring Presensi Harian                 |
+--------------------------------------------------------------------------+
```
*Gambar 3.13 Tampilan Monitoring Presensi Harian*

#### 3. Verifikasi Laporan Kegiatan Harian
Memungkinkan admin memeriksa uraian pekerjaan staf P3K, melihat foto bukti kegiatan di lapangan, menetapkan status verifikasi, serta memberikan nilai mutu kualitas pekerjaan (A, B, C, atau D).

```
+--------------------------------------------------------------------------+
|                       [PLACEHOLDER GAMBAR 3.14]                          |
|             Tampilan Halaman Verifikasi Laporan Kegiatan                 |
+--------------------------------------------------------------------------+
```
*Gambar 3.14 Tampilan Verifikasi Laporan Kegiatan*

#### 4. Persetujuan Dispensasi (Izin, Sakit, Cuti, dan Dinas Luar)
Menampilkan daftar permohonan ketidakhadiran pegawai beserta pratinjau dokumen pendukung (seperti surat keterangan dokter atau surat perintah tugas dinas luar). Saat admin menekan tombol persetujuan, sistem secara otomatis memperbarui status presensi harian pegawai menjadi status resmi ('Izin', 'Sakit', 'Cuti', atau 'Dinas Luar').

```
+--------------------------------------------------------------------------+
|                       [PLACEHOLDER GAMBAR 3.15]                          |
|             Tampilan Halaman Persetujuan Izin dan Cuti                   |
+--------------------------------------------------------------------------+
```
*Gambar 3.15 Tampilan Persetujuan Izin, Sakit, Cuti, dan Dinas Luar*

#### 5. Evaluasi Indeks Kinerja Pegawai (IKP)
Menyajikan tabel komparatif capaian kinerja bulanan seluruh pegawai P3K dengan rincian nilai kehadiran (60%), produktivitas (25%), kualitas kerja (15%), total skor IKP, kategori mutu, dan rekomendasi status perpanjangan kontrak.

```
+--------------------------------------------------------------------------+
|                       [PLACEHOLDER GAMBAR 3.16]                          |
|               Tampilan Halaman Indeks Kinerja Pegawai (IKP)              |
+--------------------------------------------------------------------------+
```
*Gambar 3.16 Tampilan Indeks Kinerja Pegawai (IKP) Admin*

#### 6. Manajemen Penegakan Surat Peringatan (SP)
Menampilkan daftar draf SP yang dihasilkan otomatis oleh sistem saat pegawai melampaui batas alpa. Admin dapat membuka formulir penomoran surat resmi, menekan tombol *Terbitkan*, serta mengunduh dokumen resmi format PDF siap tanda tangan pimpinan.

```
+--------------------------------------------------------------------------+
|                       [PLACEHOLDER GAMBAR 3.17]                          |
|             Tampilan Halaman Manajemen Surat Peringatan (SP)             |
+--------------------------------------------------------------------------+
```
*Gambar 3.17 Tampilan Manajemen Surat Peringatan (SP)*

#### 7. Pusat Laporan dan Pengaturan Parameter Sistem
Menyediakan fitur unduh data presensi bulanan/tahunan dan rekapitulasi kinerja pegawai ke dalam format Excel (.xlsx) dan PDF (.pdf), serta antarmuka pengaturan koordinat lokasi kantor, radius meter, jam kerja, bobot IKP, dan ambang batas SP.

```
+--------------------------------------------------------------------------+
|                       [PLACEHOLDER GAMBAR 3.18]                          |
|               Tampilan Halaman Pusat Laporan dan Ekspor Data             |
+--------------------------------------------------------------------------+
```
*Gambar 3.18 Tampilan Pusat Laporan dan Ekspor Data*

```
+--------------------------------------------------------------------------+
|                       [PLACEHOLDER GAMBAR 3.19]                          |
|                 Tampilan Halaman Pengaturan Sistem                       |
+--------------------------------------------------------------------------+
```
*Gambar 3.19 Tampilan Pengaturan Parameter Sistem*

### 3.7.3 Antarmuka Pegawai P3K

#### 1. Dashboard Utama Pegawai
Menyajikan kartu ringkasan persentase kehadiran bulan ini, jumlah keterlambatan, rekaman status absensi hari ini, serta riwayat kehadiran lima hari kerja terakhir.

```
+--------------------------------------------------------------------------+
|                       [PLACEHOLDER GAMBAR 3.20]                          |
|                   Tampilan Dashboard Pegawai P3K                         |
+--------------------------------------------------------------------------+
```
*Gambar 3.20 Tampilan Dashboard Pegawai P3K*

#### 2. Antarmuka Swafoto Kamera & Validasi Radius Absensi
Modul interaktif yang meminta izin akses sensor lokasi (GPS) dan kamera peramban. Menampilkan indikator jarak meter ke kantor dinas, stempel waktu, dan tombol rekam presensi yang aktif hanya jika pegawai berada di dalam perimeter radius yang diizinkan.

```
+--------------------------------------------------------------------------+
|                       [PLACEHOLDER GAMBAR 3.21]                          |
|       Tampilan Modal Kamera & Validasi Radius Absensi Masuk/Pulang       |
+--------------------------------------------------------------------------+
```
*Gambar 3.21 Tampilan Modal Kamera & Absensi Masuk/Pulang Pegawai*

#### 3. Riwayat Presensi Pribadi Pegawai
Menampilkan tabel riwayat kehadiran lengkap dengan jam datang, jam pulang, jarak meter, durasi waktu kerja, serta lencana (*badge*) status berwarna: *Hadir Tepat Waktu* (hijau), *Terlambat* (kuning), *Dinas Luar* (biru), *Izin* (indigo), dan *Sakit* (rose/merah muda).

```
+--------------------------------------------------------------------------+
|                       [PLACEHOLDER GAMBAR 3.22]                          |
|              Tampilan Halaman Riwayat Presensi Pegawai                   |
+--------------------------------------------------------------------------+
```
*Gambar 3.22 Tampilan Riwayat Presensi Pegawai*

#### 4. Pengisian Laporan Kegiatan & Pengajuan Dispensasi
Menyediakan formulir digital pengunggahan laporan tugas harian dan formulir permohonan Izin/Sakit/Cuti yang mudah diakses dari perangkat seluler.

```
+--------------------------------------------------------------------------+
|                       [PLACEHOLDER GAMBAR 3.23]                          |
|            Tampilan Formulir Pengisian Laporan Kegiatan Harian           |
+--------------------------------------------------------------------------+
```
*Gambar 3.23 Tampilan Pengisian Laporan Kegiatan Harian*

```
+--------------------------------------------------------------------------+
|                       [PLACEHOLDER GAMBAR 3.24]                          |
|              Tampilan Formulir Pengajuan Izin / Sakit / Cuti             |
+--------------------------------------------------------------------------+
```
*Gambar 3.24 Tampilan Formulir Pengajuan Izin/Sakit/Cuti*

```
+--------------------------------------------------------------------------+
|                       [PLACEHOLDER GAMBAR 3.25]                          |
|              Tampilan Lembar Rincian Indeks Kinerja Pribadi              |
+--------------------------------------------------------------------------+
```
*Gambar 3.25 Tampilan Lembar Indeks Kinerja Pribadi Pegawai*

## 3.8 Pengujian Sistem (System Testing)

### 3.8.1 Lingkungan Pengujian
Pengujian aplikasi SIP-PERFORMA dilaksanakan menggunakan metode **Black-Box Testing**, yaitu pendekatan pengujian fungsionalitas perangkat lunak dengan mengevaluasi masukan (*input*) dan keluaran (*output*) tanpa memeriksa struktur kode internal secara langsung. Lingkungan pengujian yang digunakan meliputi:
* **Perangkat Keras (Laptop Server & Klien)**: Prosessor Intel Core i5 / AMD Ryzen, Memori RAM 16 GB, SSD 512 GB.
* **Perangkat Seluler (Klien Pegawai)**: Smartphone Android dengan peramban Google Chrome Mobile v128, sensor GPS aktif.
* **Web Server & Lingkungan Lokal**: Laragon Environment (Apache 2.4, PHP 8.3, MySQL 8.0).
* **Basis Uji Data**: 24 entitas data pegawai P3K Dinas Perindustrian dan Perdagangan Kota Gorontalo.

### 3.8.2 Skenario dan Hasil Pengujian Black-Box
Seluruh skenario pengujian fungsional sistem disajikan secara sistematis pada tabel-tabel berikut:

#### 1. Modul Autentikasi dan Manajemen Hak Akses
*Tabel 3.10 Skenario Pengujian Black-Box Modul Autentikasi*
| No | Skenario Pengujian | Masukan (Input) | Hasil yang Diharapkan | Hasil Pengujian | Status |
|---|---|---|---|---|---|
| 1 | Login Admin dengan kredensial valid | Email/Username dan password benar | Berhasil masuk dan dialihkan (*redirect*) ke dashboard Admin | Sistem berhasil login dan menampilkan dashboard admin | **Berhasil** |
| 2 | Login Pegawai P3K dengan kredensial valid | Username pegawai dan password benar | Berhasil masuk dan dialihkan ke dashboard Pegawai | Sistem berhasil login dan menampilkan dashboard pegawai | **Berhasil** |
| 3 | Login dengan kata sandi salah | Password keliru | Menampilkan pesan peringatan kesalahan kredensial | Muncul notifikasi "Username atau password salah" | **Berhasil** |
| 4 | Pencegahan akses URL lintas peran | Pegawai mengakses URL `/admin/dashboard` | Sistem menolak akses dan mengembalikan pegawai ke dashboard miliknya | Akses diblokir oleh `RoleMiddleware` dan dialihkan ke `/pegawai/dashboard` | **Berhasil** |
| 5 | Logout pengguna | Klik tombol Keluar | Sesi pengguna dihapus dan kembali ke form login | Sesi berhasil ditutup dan dialihkan ke `/login` | **Berhasil** |

#### 2. Modul Presensi Geofencing dan Swafoto Kamera
*Tabel 3.11 Skenario Pengujian Black-Box Modul Presensi Geofence & Kamera*
| No | Skenario Pengujian | Masukan (Input) | Hasil yang Diharapkan | Hasil Pengujian | Status |
|---|---|---|---|---|---|
| 1 | Absen masuk tepat waktu di dalam radius | Jarak $\le 50$ meter, jam 08:15 WITA, ambil foto | Presensi tersimpan, status kehadiran *Hadir Tepat Waktu* | Data tersimpan dengan jam 08:15 dan status 'Hadir Tepat Waktu' | **Berhasil** |
| 2 | Absen masuk terlambat di dalam radius | Jarak $\le 50$ meter, jam 08:45 WITA, ambil foto | Presensi tersimpan, status kehadiran *Terlambat* | Data tersimpan dengan jam 08:45 dan status 'Terlambat' | **Berhasil** |
| 3 | Absen masuk di luar radius kantor dinas | Jarak 150 meter dari kantor, ambil foto | Sistem menolak penyimpanan dan memunculkan peringatan jarak | Muncul pesan galat "Anda berada di luar radius kantor (150m > 50m)" | **Berhasil** |
| 4 | Absen masuk setelah batas akhir jam masuk | Jam 09:15 WITA (melewati batas akhir 09:00) | Tombol absensi masuk ditutup, sistem menolak | Muncul pesan "Batas waktu absen masuk telah berakhir" | **Berhasil** |
| 5 | Absen kepulangan di dalam radius kantor | Jarak $\le 50$ meter, jam 16:15 WITA, ambil foto | Presensi kepulangan tersimpan, durasi kerja terhitung | Jam pulang 16:15 tersimpan dan durasi kerja dihitung otomatis | **Berhasil** |
| 6 | Penyesuaian jam kerja lewat pengaturan admin | Admin mengubah jam masuk dari 07:30 ke 01:00 | Sistem segera menyesuaikan toleransi presensi sesuai jam baru | Logika pembatasan jam absensi mengikuti nilai konfigurasi baru | **Berhasil** |

#### 3. Modul Laporan Kegiatan Harian
*Tabel 3.12 Skenario Pengujian Black-Box Modul Laporan Kegiatan Harian*
| No | Skenario Pengujian | Masukan (Input) | Hasil yang Diharapkan | Hasil Pengujian | Status |
|---|---|---|---|---|---|
| 1 | Pengiriman laporan kegiatan lengkap | Judul tugas, uraian deskripsi $\ge 20$ huruf, upload foto | Laporan tersimpan, skor produktivitas dihitung otomatis | Laporan tersimpan dengan skor produktivitas (100) status 'Menunggu Review' | **Berhasil** |
| 2 | Pengiriman laporan tanpa foto bukti | Judul dan deskripsi terisi, foto dikosongkan | Laporan tersimpan, skor bukti terpotong 25 poin | Laporan tersimpan dengan skor produktivitas 75 | **Berhasil** |
| 3 | Upaya pelaporan sebelum absen masuk | Pegawai belum melakukan presensi kedatangan | Sistem memblokir pengiriman formulir laporan kegiatan | Muncul pesan error "Harap lakukan absensi masuk terlebih dahulu" | **Berhasil** |
| 4 | Verifikasi laporan dan penilaian mutu oleh Admin | Admin menyetujui laporan dan memilih mutu kualitas A | Status berubah 'Disetujui', nilai kualitas tercatat 95 poin | Status terbarui menjadi Disetujui dengan kategori mutu A | **Berhasil** |

#### 4. Modul Pengajuan Dispensasi (Izin, Sakit, Cuti, Dinas Luar)
*Tabel 3.13 Skenario Pengujian Black-Box Modul Pengajuan Izin/Sakit/Cuti/Dinas*
| No | Skenario Pengujian | Masukan (Input) | Hasil yang Diharapkan | Hasil Pengujian | Status |
|---|---|---|---|---|---|
| 1 | Pengajuan sakit oleh pegawai P3K | Memilih jenis 'Sakit', tanggal 28 Okt 2026, upload surat | Pengajuan tersimpan dengan status 'Menunggu Review' | Pengajuan tersimpan di database dan masuk ke daftar review admin | **Berhasil** |
| 2 | Persetujuan pengajuan Sakit oleh Admin | Admin meninjau berkas dan klik tombol Disetujui | Status pengajuan 'Disetujui', tabel presensi tanggal tersebut mencatat status 'Sakit' | Status presensi tercatat 'Sakit' dan badge ungu/rose muncul di riwayat pegawai | **Berhasil** |
| 3 | Persetujuan pengajuan Cuti dan Dinas Luar | Admin menyetujui permohonan Cuti dan SPT Dinas Luar | Presensi mencatat status 'Cuti' dan 'Dinas Luar' | Presensi tanggal bersangkutan terisi otomatis sesuai jenis pengajuan | **Berhasil** |
| 4 | Penolakan pengajuan dispensasi | Admin menolak pengajuan izin tanpa surat pendukung | Status pengajuan 'Ditolak', tanggal bersangkutan dijadikan 'Alpha' | Sistem menetapkan status presensi menjadi Alpha secara otomatis | **Berhasil** |

#### 5. Modul Evaluasi Kinerja (IKP) dan Penegakan SP
*Tabel 3.14 Skenario Pengujian Black-Box Modul Evaluasi Kinerja (IKP) & SP*
| No | Skenario Pengujian | Masukan (Input) | Hasil yang Diharapkan | Hasil Pengujian | Status |
|---|---|---|---|---|---|
| 1 | Kalkulasi nilai IKP live | Pegawai dengan kehadiran 100%, prod 100, kual 95 | IKP terhitung 99.25, kategori Sangat Baik, Rekomendasi Diperpanjang | Nilai akhir terhitung akurat sesuai formula pembobotan (60/25/15) | **Berhasil** |
| 2 | Sinkronisasi IKP ke tabel riwayat | Admin membuka menu Indeks Kinerja | Skor tersimpan otomatis ke tabel `skor_kinerja` | Data IKP tersimpan ke tabel basis data untuk kebutuhan pelaporan | **Berhasil** |
| 3 | Pembangkitan draf SP otomatis | Akumulasi alpa pegawai mencapai 3 hari | Sistem membuat draf 'SP-1' dengan status 'Aktif' | Draf SP-1 muncul di panel admin menunggu input nomor surat | **Berhasil** |
| 4 | Penerbitan dan pencetakan naskah SP | Admin mengisi nomor surat `800/015/DISPERINDAG/2026` dan klik Terbitkan | SP resmi terbit, dokumen PDF dapat diunduh oleh Admin dan Pegawai | Berkas PDF Surat Peringatan berhasil diunduh dengan format naskah dinas resmi | **Berhasil** |

#### 6. Modul Pusat Laporan dan Ekspor Data
*Tabel 3.15 Skenario Pengujian Black-Box Modul Pusat Laporan & Ekspor Dokumen*
| No | Skenario Pengujian | Masukan (Input) | Hasil yang Diharapkan | Hasil Pengujian | Status |
|---|---|---|---|---|---|
| 1 | Ekspor rekapitulasi presensi ke Excel | Pilih bulan berjalan, klik tombol 'Export Excel' | Sistem mengunduh berkas spreadsheet `.xlsx` berisi daftar presensi | Berkas Excel berhasil terunduh dengan data pegawai lengkap | **Berhasil** |
| 2 | Ekspor rekapitulasi presensi ke PDF | Pilih bulan berjalan, klik tombol 'Export PDF' | Sistem mengunduh berkas cetak dokumen PDF format landscape | Berkas PDF berhasil diunduh dengan kop resmi dinas | **Berhasil** |
| 3 | Ekspor riwayat absensi mandiri pegawai | Pegawai klik tombol 'Cetak PDF' di riwayat presensi | Terunduh berkas kartu presensi individu bulanan | File PDF presensi individu berhasil diunduh secara instan | **Berhasil** |

---

# BAB IV
# PENUTUP

## 4.1 Kesimpulan
Berdasarkan seluruh rangkaian pelaksanaan Kerja Praktek yang telah dilaksanakan pada Dinas Perindustrian dan Perdagangan Kota Gorontalo selama 4 (empat) bulan, mulai dari tahap observasi proses bisnis, identifikasi masalah, perancangan arsitektur, pembangunan sistem, hingga pengujian fungsionalitas, dapat ditarik beberapa kesimpulan utama sebagai berikut:

1. **Digitalisasi Pengelolaan Presensi Berbasis Akurasi Tinggi**: Pembangunan sistem **SIP-PERFORMA** berhasil menggantikan alur kerja absensi manual via swafoto grup WhatsApp yang rentan manipulasi dan menyita waktu administrasi. Penerapan validasi perimeter geofence berbasis *Haversine Formula* ($\le 50\text{ meter}$) yang dipadukan dengan pengambilan swafoto langsung dari kamera peramban menjamin keabsahan fisik kehadiran para pegawai P3K di lingkungan kantor dinas.
2. **Standardisasi Pelaporan Tugas dan Penilaian Mutu**: Sistem menyediakan wadah terstruktur bagi pelaporan kegiatan harian pegawai P3K yang dilengkapi otomatisasi penghitungan nilai produktivitas kerja (berdasarkan kelengkapan, foto dokumentasi, ketepatan waktu, dan volume tugas) serta fitur penilaian mutu kualitas kerja secara berkala oleh pimpinan dinas.
3. **Penyelenggaraan Manajemen Dispensasi yang Tertib**: Pengajuan permohonan ketidakhadiran (Izin, Cuti, Sakit, dan Dinas Luar) kini terlaksana secara terpadu tanpa kertas (*paperless*), di mana proses persetujuan admin secara instan mencatatkan status absensi resmi pada hari bersangkutan tanpa risiko salah rekapitulasi data.
4. **Objektivitas Evaluasi Indeks Kinerja Pegawai (IKP) dan Penegakan Disiplin**: Perhitungan capaian kinerja bulanan berskala 0–100 kini dapat disajikan secara otomatis, transparan, dan akuntabel berdasarkan proporsi pembobotan (60% Kehadiran, 25% Produktivitas, dan 15% Kualitas Kerja). Selain itu, sistem deteksi dini pelanggaran alpa berhasil mempercepat proses penerbitan Surat Peringatan (SP-1, SP-2, dan SP-3) yang terintegrasi dengan penomoran surat keluar dan pencetakan dokumen dinas berformat PDF.
5. **Kesesuaian Pengujian Fungsional**: Melalui pengujian fungsional menggunakan metode *Black-Box Testing* terhadap seluruh skenario login, geofencing, pengunggahan kegiatan, persetujuan dispensasi, penghitungan IKP, dan ekspor dokumen laporan multi-format (Excel dan PDF), seluruh modul terbukti berjalan dengan baik sesuai rancangan kebutuhan sistem.

## 4.2 Saran
Demi keberlanjutan pemanfaatan sistem dan pengembangan teknologi informasi yang lebih komprehensif pada Dinas Perindustrian dan Perdagangan Kota Gorontalo di masa mendatang, penulis menyampaikan beberapa saran sebagai berikut:

### A. Saran untuk Instansi (Dinas Perindustrian dan Perdagangan Kota Gorontalo)
1. **Penerapan Kebijakan Operasional Resmi**: Disarankan agar pimpinan dinas menetapkan Surat Edaran atau Standar Operasional Prosedur (SOP) internal yang mewajibkan seluruh pegawai P3K menggunakan aplikasi SIP-PERFORMA sebagai instrumen tunggal presensi dan pelaporan kinerja dinas.
2. **Penyediaan Server Hosting Terpusat**: Mengingat saat ini sistem masih dijalankan pada lingkungan web server lokal, disarankan agar dinas berkoordinasi dengan Dinas Komunikasi, Informatika, dan Statistik (Diskominfotik) Kota Gorontalo untuk menempatkan (*deployment*) aplikasi ini pada server komputasi awan (*cloud server*) atau *subdomain* resmi Pemerintah Kota Gorontalo (misalnya: `performa.disperindag.gorontalokota.go.id`) dengan sertifikat pengamanan data SSL/HTTPS.

### B. Saran untuk Peneliti dan Pengembang Selanjutnya
1. **Implementasi Pengenalan Wajah Berbasis AI (*Facial Recognition*)**: Pengembangan selanjutnya dapat menambahkan model kecerdasan buatan (*Artificial Intelligence*) untuk verifikasi biometrik pengenalan wajah secara otomatis (*face match*) guna memperkuat validitas swafoto pegawai.
2. **Integrasi Notifikasi Instan Multi-Kanal**: Menambahkan integrasi antarmuka pemrograman aplikasi (*API gateway*) seperti WhatsApp Business API atau Telegram Bot untuk mengirimkan notifikasi pengingat otomatis menjelang jam batas akhir absensi atau ketika draf Surat Peringatan dibangkitkan.
3. **Penyimpanan Riwayat Arsip Berkelanjutan**: Mengembangkan modul rekapitulasi analitik tahunan dengan visualisasi perbandingan kinerja antar-bidang dinas guna mendukung rekomendasi kenaikan insentif atau perpanjangan perjanjian kerja berbasis data analitik cerdas.

---

# DAFTAR PUSTAKA

Al-Bahra, B. (2018). *Analisis dan Desain Sistem Informasi*. Yogyakarta: Graha Ilmu.

Budiani, N. (2020). *Data Flow Diagram: Sebagai Alat Bantu Desain dan Analisis Sistem Informasi*. Jurnal Teknologi dan Manajemen Rekayasa Perangkat Lunak, 8(1), 45–56.

Fowler, M. (2019). *UML Distilled: Panduan Singkat Bahasa Pemodelan Objek Standar*. Yogyakarta: Penerbit Andi.

Jogiyanto, H. M. (2017). *Analisis dan Desain Sistem Informasi: Pendekatan Terstruktur Teori dan Praktik Aplikasi Bisnis*. Yogyakarta: Andi Offset.

Kendall, K. E., & Kendall, J. E. (2020). *Systems Analysis and Design* (10th ed.). London: Pearson Education.

Komala Sari, D., & Isnaini, R. (2021). *Sistem Informasi dan Pengelolaan Data Kepegawaian: Perspektif Teknologi dan Manajemen Publik*. Jurnal Sistem Informasi Pengelolaan, 12(3), 30–45.

Lim, M. (2021). *Konsep Sistem dan Variabel Geofencing Berbasis Lokasi dalam Teknologi Informasi Perkantoran*. Jurnal Comasie, 5(4), 54–68.

Maydianto, & Ridho, M. (2021). *Rancang Bangun Sistem Informasi Berbasis Web dengan Framework Modern untuk Efisiensi Birokrasi Perkantoran*. Jurnal Sistem Informasi, 15(1), 75–90.

Nugroho, A. (2019). *Rekayasa Perangkat Lunak Berorientasi Objek Menggunakan PHP dan MySQL*. Bandung: Informatika.

Peraturan Daerah Kota Gorontalo Nomor 5 Tahun 2016 tentang *Pembentukan dan Susunan Perangkat Daerah Kota Gorontalo*.

Peraturan Menteri Dalam Negeri Republik Indonesia Nomor 77 Tahun 2020 tentang *Pedoman Teknis Pengelolaan Keuangan Daerah*.

Peraturan Pemerintah Republik Indonesia Nomor 49 Tahun 2018 tentang *Manajemen Pegawai Pemerintah dengan Perjanjian Kerja (P3K)*.

Pressman, R. S., & Maxim, B. R. (2020). *Software Engineering: A Practitioner's Approach* (9th ed.). New York: McGraw-Hill Education.

Siswanto, E. (2025). *Penerapan Teknologi Sistem Informasi dan Framework Laravel untuk Mendukung Pengelolaan Layanan Terintegrasi*. Jurnal Teknologi Sistem Informasi, 7(2), 101–115.

Sutarman. (2018). *Pengantar Teknologi Informasi dan Basis Data*. Bogor: Penerbit Yudhistira.

Ummah, H. A., Sodikin, I., & Susetyo, J. (2019). *Perancangan Sistem Informasi Manajemen Terpadu Berbasis Web*. Jurnal Rekavasi, 7(2), 15–24.

---

# LAMPIRAN

### Lampiran 1: Log Kegiatan Harian Kerja Praktek (KP)
*(Format Tabel Ringkasan Aktivitas KP selama Periode 19 Agustus s.d. 09 Desember 2026)*

```
+-----+---------------------------+------------------------------------+---------------------------------------------------+
| No  | Hari / Tanggal            | Lokasi Pelaksanaan                 | Uraian Ringkas Aktivitas / Agenda Kerja Praktek   |
+-----+---------------------------+------------------------------------+---------------------------------------------------+
| 1   | Rabu, 19 Agustus 2026     | Disperindag Kota Gorontalo         | Penerimaan mahasiswa KP & perkenalan pimpinan     |
| 2   | Kamis, 20 Agustus 2026    | Subbagian Umum & Kepegawaian       | Observasi alur pencatatan presensi swafoto WA     |
| 3   | Jumat, 21 Agustus 2026    | Bidang Perdagangan & Industri      | Wawancara kendala rekapitulasi data pegawai P3K   |
| 4   | Senin, 24 Agustus 2026    | Kantor Disperindag                 | Pengumpulan data struktur organisasi & tugas dinas|
| 5   | ... (Minggu ke-2 s.d 4)   | Ruang Rapat / Lab Kerja            | Analisis kebutuhan sistem & perancangan flowchart |
| 6   | ... (Bulan ke-2: Sept)    | Disperindag Kota Gorontalo         | Perancangan database, DFD, ERD & mockup antarmuka |
| 7   | ... (Bulan ke-3: Okt)     | Disperindag Kota Gorontalo         | Koding aplikasi Laravel, GPS Haversine, modul SP  |
| 8   | Rabu, 28 Oktober 2026     | Disperindag Kota Gorontalo         | Pengujian modul sakit, izin, presensi & IKP live  |
| 9   | ... (Bulan ke-4: Nov-Des) | Disperindag Kota Gorontalo         | Evaluasi pengujian black-box, perbaikan bug akhir |
| 10  | Rabu, 09 Desember 2026    | Ruang Kepala Dinas Disperindag     | Penarikan resmi mahasiswa & penyerahan sistem     |
+-----+---------------------------+------------------------------------+---------------------------------------------------+
```

### Lampiran 2: Form KP-3 (Tabel Kegiatan Pelaksanaan KP Mahasiswa)
*(Tersedia format isian perorangan untuk Rizqi Firmansya Tamimu dan Mohamad Safwan Ahmad yang memuat paraf pendamping lapangan mingguan).*

### Lampiran 3: Form KP-4 (Lembar Konsultasi Bimbingan KP)
*(Tersedia catatan asistensi konsultasi pembimbingan bersama DPL I Prof. Lanto Ningrayati Amali, Ph.D dan DPL II Zulhair Jidan Dj. Tamu, M.Kom).*

### Lampiran 4: Surat Keterangan Kesediaan Menerima Mahasiswa KP (Form KP-1)
*(Salinan berkas resmi bertanda tangan dan cap dinas).*

### Lampiran 5: Surat Keterangan Telah Selesai Melaksanakan KP
*(Salinan surat keterangan selesai masa magang dari Dinas Perindustrian dan Perdagangan Kota Gorontalo).*

### Lampiran 6: Contoh Hasil Ekspor Berkas Presensi dan Surat Peringatan (PDF)
*(Dihasilkan langsung dari fitur Pusat Laporan aplikasi SIP-PERFORMA).*
