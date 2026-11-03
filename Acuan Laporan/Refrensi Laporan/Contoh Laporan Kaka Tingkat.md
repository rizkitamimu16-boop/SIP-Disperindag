RANCANG BANGUN SISTEM PENJADWALAN 
(AGRISCHED) DI JURUSAN AGRIBISNIS 
UNIVERSITAS NEGERI GORONTALO 
KERJA PRAKTEK 
DISUSUN OLEH: 
Sindi Adelia Mamonto (531422022) 
Satria Indra Dewangga (531422023) 
PROGRAM STUDI SISTEM INFORMASI  
FAKULTAS TEKNIK  
UNIVERSITAS GORONTALO  
2025 
 
 
 
RANCANG BANGUN SISTEM PENJADWALAN 
(AGRISCHED) DI JURUSAN AGRIBISNIS 
UNIVERSITAS NEGERI GORONTALO 
KERJA PRAKTEK 
DISUSUN OLEH: 
Sindi Adelia Mamonto (531422022) 
Satria Indra Dewangga (531422023) 
PROGRAM STUDI SISTEM INFORMASI  
FAKULTAS TEKNIK  
UNIVERSITAS GORONTALO  
2025
KATA PENGANTAR 
Puji syukur penulis panjatkan kepada Tuhan Yang Maha Esa atas berkat dan 
rahmat-Nya, penulis dapat menyelesaikan laporan akhir Magang MBKM (Kerja 
Praktek) yang berjudul “RANCANG BANGUN SISTEM PENJADWALAN 
(AGRISCHED) DI JURUSAN AGRIBISNIS UNIVERSITAS NEGERI 
GORONTALO” dengan baik. Laporan ini disusun sebagai salah satu syarat untuk 
menyelesaikan program pendidikan di Universitas Negeri Gorontalo pada jurusan 
Teknik Informatika, program studi S1 Sistem Informasi. Kerja Praktek ini 
dilaksanakan di Jurusan Agribisnis Universitas Negeri Gorontalo Kampus Empat 
Tilongkabila dengan tujuan untuk mengembangkan sebuah sistem yang dapat 
mengatur penjadwalan seminar proposal, seminar hasil dan ujian skripsi pada 
jurusan Agribisnis. Sistem ini diharapkan dapat membantu jurusan Agribisnis 
Universitas Negeri Gorontalo dalam memperoleh data secara lebih cepat dan 
efisien, sehingga dapat mendukung proses bisnis. Dalam penyusunan laporan ini, 
penulis mendapatkan banyak bimbingan dan dukungan dari berbagai pihak. Untuk 
itu, penulis ingin menyampaikan terima kasih kepada: 
1.1 Ibu Indhitya R. Padiku, S.Kom., M.Kom selaku Ketua jurusan Teknik 
Informatika sekaligus pembimbing lapangan 1 
1.2 Bapak Muchlis Polin, S.Kom., M.Kom selaku Ketua program studi Sistem 
Informasi sekaligus pembimbing lapangan 2 
1.3 Bapak Dr. Zulham Sirajuddin, S.TP., MmoD.Ph.D selaku Ketua jurusan 
Agribisnis dan pembimbing lapangan  
i 
1.4 Bapak Echan Adam, S.E., M.M. selaku Ketua jurusan Agribisnis dan 
pembimbing lapangan  
1.5 Bapak/Ibu pegawai Jurusan Agribisnis Universitas Negeri Gorontalo yang telah 
membantu penulis selama Kerja Praktek  
1.6 Serta semua pihak yang tidak bisa penulis sebutkan satu persatu Namanya yang 
telah membantu dalam menyelesaikan laporan ini dengan baik  
Penulis menyadari bahwa laporan ini masih jauh dari kesempurnaan, maka dari itu 
kritik dan saran yang membangun sangat penulis harapkan demi perbaikan di 
masa yang akan datang. Semoga, laporan ini dapat memberikan manfaat, baik 
bagi para pembaca dan khususnya bagi penulis sendiri.  
Gorontalo, Oktober 2025 
ii 
 
 
iii 
 
DAFTAR ISI 
 
KATA PENGANTAR ............................................................................................ i 
DAFTAR ISI .......................................................................................................... iii 
DAFTAR TABEL.................................................................................................. v 
DAFTAR GAMBAR ............................................................................................ vi 
BAB I PENDAHULUAN ...................................................................................... 1 
1.1 Jurusan Agribisnis Universitas Negeri Gorontalo......................................... 1 
1.2 Sejarah Instansi ............................................................................................. 1 
1.3 Visi dan Misi Instansi.................................................................................... 4 
1.4 Struktur Organisasi........................................................................................ 5 
1.5 Deskripsi Tugas Dari Instansi/Perusahaan .................................................... 5 
BAB II  GAMBARAN SISTEM INFORMASI DAN TEKNOLOGI 
INFORMASI ORGANISASI ............................................................................... 7 
2.1. Deskripsi Sistem dan Teknologi Informasi .................................................. 7  
2.1.1 Website Jurusan Agribisnis ...................................................................... 10 
2.1.2 SIAT (Sistem Informasi Akademik Terpadu) ...................................... 11 
2.1.3 SIAKAD (Sistem Informasi Akademik) .............................................. 11 
2.2 Analisis Implementasi Sistem ..................................................................... 12 
BAB III HASIL KERJA PRAKTIK ................................................................. 15 
3.1 Analisis Proses Bisnis Usulan ..................................................................... 15 
3.1.1 Flowchart System Usulan .................................................................... 15 
3.2 Analisis Pemodelan ..................................................................................... 16 
3.2.1 Identifikasi External Entity .................................................................. 16 
3.2.2 Diagram Konteks ................................................................................. 18 
3.2.3 Hierarchy chart ..................................................................................... 19 
3.2.4 Diagram Alir Data Level 0 ................................................................... 19 
3.2.5 Diagram Alir Data Level 1 ................................................................... 20 
3.3 Desain Database .......................................................................................... 22 
3.4 Tampilan Umum Sistem ............................................................................. 25 
3.4.1 Halaman Home..................................................................................... 25 
3.4.2 Halaman Login ..................................................................................... 28 
3.5 Tampilan Admin ......................................................................................... 28 
3.5.1 Tampilan Halaman Dashboard role Ketua Jurusan, Sekretaris Jurusan, 
dan Panitia ..................................................................................................... 29 
3.5.2 Halaman Data Master ........................................................................... 32 
 
 
iv 
 
3.5.3 Tampilan Halaman verifikasi ............................................................... 35 
3.5.4 Tampilan buat jadwal ........................................................................... 36 
3.5.5 Tampilan halaman laporan masing- masing role ................................. 37 
3.5.6 Tampilan fitur profile masing-masing role .......................................... 38 
3.6 Tampilan Mahasiswa .................................................................................. 39 
3.6.1 Halaman Dashboard ............................................................................. 39 
3.6.2 Halaman pendaftaran seminar proposal ............................................... 40 
3.6.3 Halaman pendaftaran seminar hasil ..................................................... 41 
3.6.4 Halaman pendaftaran ujian skripsi ....................................................... 42 
3.6.5 Halaman Profil Mahasiswa .................................................................. 43 
3.6.6 Halaman jadwal .................................................................................... 43 
BAB IV KESIMPULAN ..................................................................................... 45 
4.1 Kesimpulan ................................................................................................. 45 
4.2 Saran ............................................................................................................ 46 
DAFTAR PUSTAKA .......................................................................................... 48 
LAMPIRAN ......................................................................................................... 49 
Lampiran 1: Log Kegiatan Kerja Praktek ....................................................... 49 
Lampiran 2: Tabel Kegiatan KP ..................................................................... 56 
Lampiran 3: Lembar Asistensi ........................................................................ 66 
 
 
 
 
 
 
v 
 
DAFTAR TABEL 
Tabel 2.1 Definisi Sistem Dan Teknologi Informasi Menurut Para Ahli ............. 7 
Tabel 2.2 hubungan konseptual antara sistem,sistem informasi dan teknologi 
informasi ............................................................................................................... 9 
Tabel 3.1 External Entity ...................................................................................... 17 
 
 
 
vi 
 
DAFTAR GAMBAR 
Gambar 1.1 Struktur Organisasi ............................................................................ 5 
Gambar 2.1 Tampilan Website Jurusan Agribisnis............................................... 10 
Gambar 2.2 Tampilan Beranda Siat ...................................................................... 11 
Gambar 2.3 Tampilan Siakad ................................................................................ 12 
Gambar 2.4 Flowchart Berjalan ............................................................................ 14 
Gambar 3.1 Flowchart System Usulan.................................................................. 16 
Gambar 3.2 diagram konteks ................................................................................ 18 
Gambar 3.3 hierarchy chart ................................................................................... 19 
Gambar 3.4 DAD level 0 ...................................................................................... 20 
Gambar 3.5 DAD level 1 proses 1 ........................................................................ 21 
Gambar 3.6 DAD level 1 proses 2 ........................................................................ 21 
Gambar 3.7 DAD level 1 proses 3 ........................................................................ 22 
Gambar 3.8 Relasi Database ................................................................................. 24 
Gambar 3.9 Halaman Home .................................................................................. 25 
Gambar 3.10 Halaman Home Jadwal Mingguan .................................................. 26 
Gambar 3.11 Tampilan Jadwal Ujian.................................................................... 27 
Gambar 3.12 Tampilan halaman pengajuan pendaftaran ...................................... 27 
Gambar 3.13 Halaman Login ................................................................................ 28 
Gambar 3.14 Dashboard Ketua Jurusan ................................................................ 30 
Gambar 3.15 Dashboard sekretaris Jurusan .......................................................... 31 
Gambar 3.16 Dashboard Panitia ........................................................................... 32 
Gambar 3.17 Data Dosen ...................................................................................... 34 
Gambar 3.18 Data Mahasiswa .............................................................................. 34 
Gambar 3.19 Data Admin ..................................................................................... 35 
Gambar 3.20 Verifikasi Pendaftaran ..................................................................... 36 
Gambar 3.21 Penetapan Penguji ........................................................................... 36 
Gambar 3.22 Buat Jadwal ..................................................................................... 38 
Gambar 3.23 Laporan Sistem ................................................................................ 39 
Gambar 3.24 Profile Admin .................................................................................. 40 
Gambar 3.25 Halaman dashboard mahasiswa ...................................................... 41 
Gambar 3.26 Tampilan pendaftaran sempro ......................................................... 41 
Gambar 3.27 Tampilsn pendaftaran sempro ......................................................... 42 
Gambar 3.28 Tampilan pendaftaran semhas ......................................................... 43 
Gambar 3.29 Tampilan pendaftaran ujian skripsi ................................................. 43 
Gambar 3.30 Halaman profile ............................................................................... 44 
Gambar 3.31 Tampilan jadwal ujian ..................................................................... 45
BAB I 
PENDAHULUAN 
1.1 Jurusan Agribisnis Universitas Negeri Gorontalo 
Jurusan Agribisnis merupakan salah satu program studi unggulan di bawah 
Fakultas Pertanian, Universitas Negeri Gorontalo (UNG). Jurusan ini bertanggung 
jawab dalam menyelenggarakan pendidikan tinggi di bidang agribisnis yang 
berorientasi pada pengembangan sumber daya dan kearifan lokal. Sebagai bagian 
dari universitas negeri, jurusan agribisnis memiliki komitmen untuk menyediakan 
pendidikan berkualitas yang didukung oleh tenaga pengajar berkualifikasi serta 
fasilitas penunjang yang memadai. Dalam operasionalnya, jurusan ini telah 
memanfaatkan beberapa sistem informasi seperti website jurusan, SIAT (Sistem 
Informasi Akademik Terpadu), dan SIAKAD untuk mendukung kegiatan 
akademik. 
1.2 Sejarah Instansi 
Pendirian Fakultas Pertanian diawali berdirinya Program Balai Pelatihan 
Agrokompleks STKIP Gorontalo Tahun 1994, berdasarkan Surat Keputusan Ketua 
Sekolah Tinggi Keguruan dan Ilmu Pendidikan (STKIP) Gorontalo Nomor. 
01/PT.STKIP/GT/G/1994, tertanggal 12 September 1994. Pada Tahun 2000 
melalui perluasan mandate bagi STKIP Gorontalo untuk membuka program studi 
non kependidikan, maka melalui SK No.280/DIKTI/KEP/2000 penyelenggaraan 
D3 Pertanian. Tahun 2001 STKIP berubah status menjadi
1 
2 
IKIP Negeri Gorontalo melalui KEPRES RI No. 19 Tahun 2001 Tanggal 5 
Februari 2001, pada Tahun 2004 berdasarkan KEPRES RI No. 54 Tahun 2004 
Tanggal 23 Juni 2004, alih status IKIP Negeri Gorontalo berubah menjadi 
Universitas Negeri Gorontalo (UNG), salah satu fakultas adalah Fakultas Pertanian. 
Menindaklanjuti KEPRES tersebut melalui Surat Persetujuan Menteri Pendidikan 
Nasional Izin Pembukaan Fakultas Pertanian No. 82/MPN/KL/2004, tanggal 17 
Juni 2004. Selanjutnya melalui Surat Keputusan Rektor UNG tentang 
Penyelenggaraan Fakultas Pertanian No. 289/K15.A2/KP/2004. Jurusan yang 
dikelola oleh Fakultas Pertanian adalah Agribisnis (Jenjang pendidikan S1), 
Agroteknologi (Jenjang pendidikan S1), Peternakan (Jenjang pendidikan S1) dan 
Ilmu Teknologi Pertanian (Jenjang pendidikan S1). 
Visi Fakultas Pertanian Universitas Negeri Gorontalo disesuaikan dengan 
pencapaian visi UNG Tahun 2035 dengan mengacu pada Rencana Induk 
Pengembangan UNG yaitu “Leading University dalam Pengembangan 
Kebudayaan dan Inovasi Berbasis Potensi Regional di Kawasan Asia Tenggara”. 
Berdasarkan hal tersebut sesuai Renstra UNG 2019-2023 ditetapkan Visi UNG 
yaitu: “Terwujudnya Universitas Negeri Gorontalo yang Unggul dan Berdaya Saing 
di Asia Tenggara”. Berdasarkan hal tersebut di atas Rencana Strategis Fakultas 
Pertanian Universitas Negeri Gorontalo Tahun 2010-2023 menetapkan Visi 
Fakultas Pertanian yaitu: ”Menjadi Fakultas Pertanian yang Unggul dan Berdaya 
Saing di Bidang Pertanian Berbasis Sumberdaya dan Kearifan Lokal Tahun 2023” 
Program Studi Agribisnis merupakan salah satu Program Studi yang ada di Fakultas 
Pertanian Universitas Negeri Gorontalo yang didirikan berdasarkan SK Dirjen 
3 
Pendidikan Tinggi Kementerian Pendidikan Nasional Nomor SK No 
4304/D/T/2008 dan tanggal 28 November 2008 tentang Izin Pembukaan Program 
Studi Agribisnis Program Sarjana pada Universitas Negeri Gorontalo. Visi, Misi, 
Tujuan dan Sasaran (VMTS) Program Studi Agribisnis Fakultas Pertanian 
Universitas Negeri Gorontalo secara konsisten mengacu pada visi, misi, tujuan dan 
sasaran institusi Universitas dan Fakultas Pertanian Universitas Negeri Gorontalo. 
Wujud konsistensi yaitu “Menjadi salah satu program studi yang unggul dan 
berdaya saing dalam bidang Agribisnis berbasis kearifan lokal tahun 2023. 
Pedoman Tata pamong Fakultas Pertanian Universitas Negeri Gorontalo, 
disusun dengan asas good governance yaitu kredibilitas, transparansi, akuntabilitas, 
tanggungjawab, dan berkeadilan yang dipimpin oleh Dekan dan 3 (Tiga) Wakil 
Dekan. Fungsi manajemen di Prodi Agribisnis Fakultas Pertanian Universitas 
Negeri Gorontalo digunakan secara baik, setiap kegiatan didasarkan pada 
perencanaan, pengorganisasian, penempatan personil, pengarahan dan pengawasan. 
Sistem penjaminan mutu fakultas berjalan dengan baik, secara operasional 
berkoordinasi dengan Lembaga Pengembangan Pembelajaran dan Penjamin Mutu 
(LP3M) Universitas Negeri Gorontalo dan dibantu dengan Gugus Penjaminan Mutu 
(GPM) Program Studi. Jumlah peminat mahasiswa Prodi Agribisnis Fakultas 
Pertanian Universitas Negeri Gorontalo mengalami fluktuasi pada tiga tahun 
terakhir, namun diterima sesuai kuota yang ditetapkan. Total jumlah mahasiswa 
Agribisnis sebanyak 470 mahasiswa. Penerimaaan melalui 3 jalur yakni SNMPTN, 
SBMPTN dan seleksi mandiri. Total jumlah dosen tetap program studi sebanyak 16 
orang dan 16 dosen tetap dengan kualifikasi guru besar 2 orang, pendidikan S3 
4 
sebanyak 4 orang dan pendidikan S2 sebanyak 10 orang dengan rasio mahasiswa 
pada tahun TS yaitu 1:29, kemudian dalam menunjang tugas program studi sampai 
tingkat fakultas dibantu oleh tenaga kependidikan sebanyak 8 orang tenaga 
kependidikan PNS dan 12 orang tenaga kependidikan non PNS. 
1.3 Visi dan Misi Instansi 
Visi: 
"Program Studi yang unggul dan berdaya saing dalam bidang agribisnis 
berbasis kearifan lokal tahun 2023" 
Misi: 
1. Mengembangkan pendidikan, penelitian dan pengabdian pada masyarakat 
berbasis digital guna menghasilkan lulusan yang memiliki kecakapan 
digital, profesional, nilai-nilai budaya pertanian bidang Agribisnis 
2. Meningkatkan kompetensi penelitian dan mengembangkan kompetensi 
peneliti untuk menghasilkan IPTEK terbarukan bidang Agribisnis secara 
berkelanjutan 
3. Mengembangkan hilirisasi riset melalui kegiatan pengabdian masyarakat 
yang inovatif, berkelanjutan dan terpadu di bidang Agribisnis 
4. Menyelenggarakan tata kelola dan layanan yang profesional transparan, 
akuntabel dan bertanggung jawab menuju tata kelola jurusan yang baik 
5. Menjalin dan meningkatkan kemitraan dan jejaring kerjasama mendukung 
tri dama perguruan tinggi bidang pertanian baik tingkat lokal, regional, 
nasional dan internasional. 
5 
1.4 Struktur Organisasi 
Struktur organisasi di tingkat program studi, Jurusan Agribisnis dikelola 
oleh seorang Ketua Jurusan yang bertanggung jawab atas pelaksanaan Tri Dama 
Perguruan Tinggi. Operasional jurusan didukung oleh para dosen serta tenaga 
kependidikan (baik PNS maupun non-PNS) yang menangani administrasi 
akademik, kemahasiswaan, yang dapat dilihat pada gambar 1.1. 
Gambar 1.1 Struktur Organisasi 
1.5 Deskripsi Tugas Dari Instansi/Perusahaan 
Kegiatan kerja praktek ini berfokus pada Perancangan dan Pembangunan 
Sistem Penjadwalan Ujian untuk tiga kategori yaitu seminar proposal, seminar 
hasil, dan ujian skripsi berbasis web yang diberi nama AgriSched di Jurusan 
Agribisnis Universitas Negeri Gorontalo. Sistem ini bertujuan utama untuk 
mengotomatisasikan seluruh proses administrasi akademik akhir mahasiswa, mulai 
dari pendaftaran, verifikasi berkas, hingga penjadwalan untuk tiga tahapan krusial: 
Seminar Proposal Skripsi, Seminar Hasil Penelitian, dan Ujian Skripsi. Dengan 
6 
adanya AgriSched, proses manual yang selama ini memakan waktu dan rentan 
kesalahan akan digantikan oleh proses digital yang terintegrasi, yang 
memungkinkan penentuan tim penguji (dosen pembimbing dan penguji) serta 
penetapan waktu dan lokasi ujian berlangsung secara terstruktur. Hal ini diharapkan 
mampu mempercepat birokrasi, meminimalisir tabrakan jadwal, menyediakan 
informasi yang transparan dan real-time bagi seluruh pemangku kepentingan 
(mahasiswa, dosen, dan pengelola jurusan), serta secara langsung mendukung 
efisiensi pengelolaan data skripsi dan mempercepat kelulusan mahasiswa Jurusan 
Agribisnis.
BAB II  
GAMBARAN SISTEM INFORMASI DAN TEKNOLOGI 
INFORMASI ORGANISASI 
2.1. Deskripsi Sistem dan Teknologi Informasi 
Pemahaman mengenai konsep sistem dan teknologi informasi menjadi dasar 
penting dalam pengembangan AgriSched. Sistem dipandang sebagai sekumpulan 
komponen yang saling terhubung dan berfungsi mencapai tujuan organisasi, 
sedangkan teknologi informasi merupakan infrastruktur yang mendukung 
pemrosesan, penyimpanan, dan penyebaran data. Tabel 2.1 menampilkan definisi 
sistem dan teknologi informasi dari beberapa ahli: 
No Sumber / 
Tahun 
Konsep 
Definisi Ahli 
Pandangan Penulis 
1 
Maydianto 
& Ridho 
(2021) 
Sistem 
Sistem dipandang 
sebagai jaringan 
proses kerja yang 
saling terkait 
Menunjukkan 
pentingnya keterpaduan 
elemen organisasi. 
Dalam konteks 
untuk mencapai 
tujuan organisasi. 
akademik, hubungan 
antarproses sering 
bersifat adaptif 
terhadap kebijakan 
kampus. 
7 
8 
 
 
 
2 Lim (2021) Sistem Gabungan elemen 
yang saling 
berhubungan dan 
berfungsi 
mencapai tujuan 
tertentu. 
Menggambarkan 
struktur sistematis. 
Namun, dalam 
lingkungan akademik 
perlu fleksibilitas 
terhadap perubahan 
prosedur dan teknologi. 
3 Komala 
Sari & 
Isnaini 
(2021) 
Sistem 
Informasi 
Kumpulan elemen 
yang bekerja sama 
menghasilkan 
informasi yang 
bermanfaat secara 
terpadu. 
Sesuai dengan sistem 
akademik di perguruan 
tinggi, tetapi aspek 
keamanan data juga 
harus dijaga. 
4 Siswanto 
(2025) 
Teknologi 
Sistem 
Informasi 
Kumpulan elemen 
yang berinteraksi 
untuk memproses 
data menjadi 
informasi bagi 
pengambilan 
keputusan. 
Relevan untuk 
mendukung 
pengelolaan akademik, 
terutama dalam sistem 
berbasis web seperti 
AgriSched. 
5 Purwani 
(2025) 
Infrastruktur 
Teknologi 
Informasi 
Perangkat keras, 
perangkat lunak, 
jaringan, dan 
Menegaskan bahwa 
keberlanjutan TI 
bergantung pada 
9 
layanan 
terintegrasi yang 
kemampuan SDM dan 
literasi digital. 
mendukung 
inovasi organisasi. 
Tabel 2.1 Definisi Sistem dan Teknologi Informasi Menurut Para Ahli 
Selain memahami definisi dasar, penting pula melihat hubungan antara 
sistem, sistem informasi, dan teknologi informasi. Ketiganya saling terhubung 
dalam mendukung kegiatan organisasi dan pencapaian tujuan institusi pendidikan. 
Hubungan konseptual antara ketiga unsur ini dapat dilihat pada Tabel 2.2. 
Konsep 
Cakupan Utama 
Fungsi 
Sistem 
Elemen yang saling 
berhubungan dalam 
Menyusun struktur kerja dan 
alur proses 
organisasi 
Sistem 
Informasi 
Integrasi manusia, prosedur, 
dan teknologi 
Menghasilkan informasi untuk 
pengambilan keputusan 
Teknologi 
Informasi 
Infrastruktur perangkat keras 
dan lunak 
Mendukung pemrosesan dan 
distribusi data 
Tabel 2.2 Hubungan Konseptual antara Sistem, Sistem Informasi, dan Teknologi 
Informasi 
Jurusan Agribisnis Universitas Negeri Gorontalo telah mengadopsi 
beberapa sistem informasi untuk mendukung pelaksanaan Tri Dama Perguruan 
Tinggi serta operasional administrasi sehari-hari. Sistem-sistem ini digunakan oleh 
10 
dosen, tenaga kependidikan, dan mahasiswa agar dapat menjalankan aktivitas 
akademik dengan lebih efisien. Berikut uraian beberapa sistem informasi utama 
yang digunakan di Jurusan Agribisnis. 
2.1.1 Website Jurusan Agribisnis 
Website Jurusan Agribisnis merupakan platform informasi dan komunikasi 
utama yang menjadi wajah digital dari program studi. Sistem ini berfungsi sebagai 
pusat penyebaran informasi publik seperti profil jurusan, berita, agenda kegiatan, 
pengumuman penting, dan prestasi dosen serta mahasiswa. Dengan adanya website 
ini, jurusan dapat membangun citra dan menyampaikan informasi secara luas dan 
cepat kepada masyarakat akademik internal maupun eksternal. Website ini juga 
menjadi sarana promosi dan penghubung dengan alumni serta pemangku 
kepentingan lainnya  
Gambar 2.1 Tampilan Website Jurusan Agribisnis 
11 
2.1.2 SIAT (Sistem Informasi Akademik Terpadu) 
SIAT merupakan Sistem Informasi Akademik Terpadu yang digunakan 
oleh Universitas Negeri Gorontalo, termasuk di Jurusan Agribisnis. Sistem ini 
menjadi tulang punggung operasional akademik, yang mendukung berbagai fungsi 
kritikal seperti penginputan Kartu Rencana Studi (KRS), pengelolaan nilai, 
pencetakan transkrip, dan monitoring perkembangan studi mahasiswa. Bagi dosen, 
SIAT memudahkan dalam pengisian nilai dan melihat jadwal mengajar. Dengan 
adanya SIAT, proses administrasi akademik menjadi lebih terstruktur dan terpusat. 
Gambar 2.2 Tampilan Beranda SIAT 
2.1.3 SIAKAD (Sistem Informasi Akademik) 
Sistem Informasi Akademik (SIAKAD) beroperasi berdampingan dengan 
SIAT dan lebih berfokus pada pendataan dan administrasi kemahasiswaan. Sistem 
ini mengelola data lengkap mahasiswa, mulai dari proses registrasi semester, 
hingga data pribadi dan akademik. SIAKAD berperan penting dalam menyediakan 
12 
data dasar mahasiswa yang diperlukan untuk berbagai keperluan administrasi di 
tingkat jurusan dan fakultas. Integrasi antara SIAT dan SIAKAD sangat penting 
untuk memastikan konsistensi dan keakuratan data akademik seluruh civitas 
akademika. 
Gambar 2.3 Tampilan SIAKAD 
2.2 Analisis Implementasi Sistem 
Sebelumnya, Jurusan Agribisnis Universitas Negeri Gorontalo sebenarnya 
telah memanfaatkan berbagai platform digital seperti website jurusan, SIAT, dan 
SIAKAD sebagai bagian dari Sistem Informasi Akademik. Ketiga platform tersebut 
berfungsi cukup baik untuk mendukung aktivitas akademik umum seperti 
pengelolaan data mahasiswa, perkuliahan, dan administrasi akademik standar. 
Namun, keberadaan sistem tersebut belum mampu menjawab kebutuhan khusus 
pada pengelolaan administrasi pendaftaran seminar proposal, seminar hasil, serta 
ujian skripsi. 
13 
Pada tahapan ini, proses masih bergantung pada kombinasi Google Form 
dan pengolahan data melalui spreadsheet Excel. Sistem ini memang sudah 
memenuhi fungsi dasar sebagai media input pendaftaran mahasiswa, tetapi belum 
mencapai efisiensi dan transparansi optimal. Tidak adanya fitur integrasi dan 
otomatisasi menyebabkan alur kerja administrasi tetap memerlukan banyak 
intervensi manual terutama pada proses penjadwalan dan penentuan dosen penguji. 
Data yang terkumpul belum dapat mengolah ketersediaan dosen, kuota penguji, dan 
bidang keahlian secara otomatis sehingga Ketua/Sekretaris Jurusan harus 
melakukan penjadwalan manual. Tahap ini menjadi titik paling rawan karena 
berpotensi menimbulkan benturan jadwal, beban kerja tidak merata, dan 
keterlambatan pengumuman ujian. Di sinilah urgensi pengembangan Sistem 
Penjadwalan Ujian Skripsi (AgriSched) menjadi jelas. AgriSched dirancang untuk 
tidak hanya mengumpulkan data pendaftaran tetapi juga memverifikasi berkas 
secara digital, mengelola ketersediaan dosen, dan melakukan penjadwalan serta 
penentuan penguji secara otomatis dan real-time. Dengan begitu, proses yang 
sebelumnya lambat dan manual dapat berubah menjadi sistematis, cepat, dan minim 
human error. 
Implementasi AgriSched berpotensi mempercepat waktu tunggu ujian, 
meningkatkan akurasi penjadwalan, serta mendukung efektivitas penyelenggaraan 
ujian akhir mahasiswa yang pada akhirnya menjadi faktor pendukung percepatan 
kelulusan di Jurusan Agribisnis UNG. Dalam masalah ini dibuatkan analisis proses 
bisnis berupa Cross Functional Flowchart (CFF) yang sedang berjalan saat ini 
seperti pada gambar 2.4 dibawah ini: 
14 
 
 
 
 
 
Gambar 2.4 Flowchart Berjalan
BAB III 
HASIL KERJA PRAKTIK 
3.1 Analisis Proses Bisnis Usulan 
Berdasarkan permasalahan yang telah dijelaskan sebelumnya, maka 
dikembangkan sebuah sistem aplikasi penjadwalan ujian berbasis web yang 
dinamakan AgriSched. Sistem ini dapat mengotomatisasi seluruh proses 
administrasi akademik akhir mahasiswa, mulai dari pendaftaran, verifikasi berkas, 
hingga penjadwalan untuk tiga tahapan krusial: Seminar Proposal Skripsi, Seminar 
Hasil Penelitian, dan Ujian Skripsi. Dengan adanya AgriSched, proses manual yang 
selama ini memakan waktu dan rentan kesalahan akan digantikan oleh proses digital 
yang terintegrasi. Hal ini akan mempercepat proses birokrasi, meminimalisir 
tabrakan jadwal, menyediakan informasi yang transparan dan real-time, serta 
mempercepat kelulusan mahasiswa. 
3.1.1 Flowchart System Usulan 
Flowchart atau bagan alir adalah skema/bagan (chart) yang menunjukkan 
aliran (flow) di dalam suatu program secara logika. Flowchart merupakan alat yang 
banyak digunakan dalam menggambarkan algoritma dalam bentuk notasi-notasi 
tertentu.
15 
16 
Gambar 3.1 Flowchart system usulan 
3.2 Analisis Pemodelan 
3.2.1 Identifikasi External Entity 
Entitas eksternal merujuk pada unit di luar sistem yang berinteraksi melalui 
pertukaran data. entitas ini merupakan pihak-pihak yang memanfaatkan sistem 
meskipun berada di luar batasan sistem. Entitas tersebut dapat memberikan 
masukan dan menerima keluaran dari sistem (budiani 2000). Pada AgriSched, 
terdapat empat entitas eksternal yaitu Mahasiswa, Ketua Jurusan, Sekretaris 
Jurusan, dan Panitia.  
17 
Entity 
Input 
Output 
Mahasiswa 
Data Mahasiswa 
Jadwal Ujian 
Data pendaftaran 
Ketua jurusan 
Verifikasi pendaftaran 
Data Pendaftaran 
Mahasiswa 
Data Pendaftaran 
Sekretaris Jurusan 
Data penguji 
Mahasiswa 
Verifikasi Pendaftaran 
Data Pendaftaran 
Panitia 
Data jadwal 
Mahasiswa  
Verifikasi Pendaftaran 
Data Penguji 
Table 3.1 External Entity 
18 
3.2.2 Diagram Konteks 
Gambar 3.2 Diagram Konteks 
Berdasarkan Eksternal Entity yang telah ada, maka kemudian dibuatkan 
Diagram Konteks seperti pada Gambar 3.2, Entity Mahasiswa melakukan input data 
berupa data mahasiswa dan data pendaftaran. Kemudian sistem akan membuat 
laporan pendaftaran berdasarkan data mahasiswa dan pendaftaran yang akan 
diverifikasi oleh Entity ketua jurusan. Setelah diverifikasi maka Entity Sekretaris 
Jurusan akan mendapat laporan pendaftaran yang sudah di verifikasi, kemudian 
input data Penguji. Setelah laporan pendaftaran diverifikasi dan ditetapkan penguji 
maka Entitas Panitia input data jadwal ke sistem, Entity mahasiswa mendapatkan 
data jadwal 
19 
3.2.3 Hierarchy chart 
Gambar 3.3 Hierarchy Chart 
Setelah itu dibuatkan Hierarchy Chart untuk menjelaskan 
Gambaran diagram konteks dengan menggambarkan input, proses dan 
output yang ada pada sistem informasi penjadwalan skripsi. 
3.2.4 Diagram Alir Data Level 0 
Diagram Alir Data (DAD) berfungsi sebagai instrumen pemodelan yang 
merepresentasikan sistem dalam bentuk jejaring proses fungsional yang saling 
terhubung melalui aliran data, baik yang diproses secara manual maupun 
terkomputerisasi (Ummah et al., 2019). Dalam perancangan sistem, DAD memiliki 
dua tingkat representasi yaitu level 0 dan level 1. Level 0 menyajikan gambaran 
menyeluruh sistem sebagai satu kesatuan utuh sebelum diuraikan menjadi sub
sistem yang lebih spesifik. Pada tingkat ini, fokus utama terletak pada komponen 
masukan, keluaran, dan proses inti tanpa mengungkap detail implementasi internal 
masing-masing proses. Berikut disajikan DAD Level 0 untuk sistem aplikasi 
AgriSched. 
20 
Gambar 3.4 DAD Level 0 
3.2.5 Diagram Alir Data Level 1   
A.  Diagram alir data level 1 proses 1 
DAD Level 1 Proses 1 seperti pada Gambar 3.5 menjelaskan 
input data tiap Entity yang terhubung dengan proses input 1.0 yang 
kemudian akan diproses di dalam sistem. 
21 
Gambar 3.5 DAD Level 1 Proses 1 
B. Diagram alir data level 1 proses 2 
DAD Level 1 Proses 2 yaitu proses Verifikasi pada data 
pendaftaran yang dilakukan oleh Entity mahasiswa kemudian di verifikasi 
Entity Ketua Jurusan, dan pembuatan Jadwal oleh Entitas dari data 
pendaftaran mahasiswa yang sudah di verifikasi oleh ketua jurusan dan di 
input penguji oleh sekretaris jurusan. 
Gambar 3.6 DAD Level 1 Proses 2 
22 
C. Diagram alir data level 1 proses 3 
DAD Level 1 Proses 3 yaitu output pada data mahasiswa dan 
pendaftaran yang dilakukan oleh Entity mahasiswa yang menghasilkan data 
pendaftaran mahasiswa, masing-masing Entitas mendapatkan data 
pendaftaran mahasiswa, kemudian data pendaftaran mahasiswa, data penguji 
yang sudah di verifikasi serta data jadwal menghasilkan jadwal ujian yang 
akan diterima Entitas mahasiswa.   
Gambar 3.7 DAD Level 1 Proses 3 
3.3 Desain Database 
Database merupakan kumpulan data yang tersusun secara sistematis dan saling 
berkaitan dalam satu atau beberapa berkas (file), yang diolah dengan cara tertentu 
untuk menghasilkan informasi baru. Hubungan antar data di dalamnya 
memungkinkan proses pengolahan dan penyajian informasi yang lebih kompleks 
(Puan et al., 2023). Dalam sistem database, fungsi utamanya adalah menyimpan 
data secara terstruktur dan teratur. Komponen dasar database terdiri atas baris 
23 
(record) dan kolom (field), di mana titik perpotongannya disebut nilai data (data 
value). Setiap tabel dalam database dapat saling terhubung melalui kolom kunci 
(key field), sehingga membentuk struktur yang mendukung penyimpanan serta 
pemrosesan data secara efisien. Struktur tabel database pada sistem Penjadwalan 
dapat dilihat pada Gambar 3.8.
24 
Gambar 3.8 Relasi Database
25 
3.4 Tampilan Umum Sistem  
3.4.1 Halaman Home 
Halaman Home pada sistem AgriSched dirancang sebagai titik akses utama 
bagi pengguna umum, termasuk mahasiswa dan dosen, tanpa memerlukan 
autentikasi. Tujuan utama halaman ini adalah memberikan gambaran ringkas 
mengenai fungsi sistem, serta menyediakan akses informasi cepat terkait kegiatan 
akademik yang berhubungan dengan proses seminar proposal, seminar hasil, dan 
ujian skripsi. Bagian ini memberikan penjelasan singkat mengenai tujuan dan 
manfaat sistem sebagai platform pengelolaan jadwal ujian akademik di Jurusan 
Agribisnis yang dapat dilihat pada Gambar 3.9 Halaman Home  
Gambar 3.9 Halaman home 
Tampilan Statistik Jadwal Minggu Ini Ditampilkan dalam bentuk ringkasan 
visual yang menunjukkan jumlah kegiatan ujian aktif berdasarkan kategori: 
26 
Seminar Proposal, Seminar Hasil, dan Ujian Skripsi. Yang dapat dilihat pada 
Gambar 3.10 Halaman Home -Statistik Jadwal Minggu ini. 
Gambar 3.10 Halman Home Jadwal Mingguan 
Tampilan halaman Jadwal Ujian pengguna dapat melihat daftar mahasiswa 
yang dijadwalkan ujian dalam minggu berjalan. Informasi yang ditampilkan 
meliputi kategori ujian, waktu pelaksanaan, ruang, judul tugas akhir, serta nama 
dosen pembimbing. Yang dapat dilihat pada Gambar 3.11 Halaman Home-Jadwal 
Ujian 
27 
Gambar 3.11 Tampilan Jadwal ujian 
Tampilan Pengajuan fitur ini memungkinkan pengguna umum untuk 
menelusuri daftar mahasiswa yang telah mengajukan permohonan ujian, beserta 
statusnya. Yang dapat dilihat pada Gambar 3.12 Halaman Home-Pengajuan. 
Gambar 3.12 Tampilan halaman pengajuan pendaftaran 
28 
3.4.2 Halaman Login 
Halaman Login merupakan gerbang utama menuju area khusus sistem yang 
hanya dapat diakses oleh pengguna terdaftar seperti mahasiswa, ketua jurusan, 
sekretaris jurusan, dan panitia. Proses autentikasi dilakukan untuk menjaga 
keamanan data dan membatasi akses hanya pada pengguna dengan hak tertentu. 
Setelah berhasil masuk, pengguna akan diarahkan ke halaman dashboard masing
masing sesuai peran. Desain halaman login dibuat sederhana namun profesional, 
dengan fokus pada kemudahan akses dan keamanan pengguna. 
Gambar 3.13 Halaman Login 
3.5 Tampilan Admin 
Halaman admin pada sistem AgriSched dirancang untuk pendekatan yang 
memastikan bahwa setiap pengguna hanya dapat mengakses fitur, data, dan fungsi 
sesuai kewenangannya. namun dengan satu pengecualian: Ketua Jurusan berfungsi 
sebagai pemegang akses penuh (full access / super admin). Artinya, Ketua Jurusan 
dapat melihat, mengelola, dan memodifikasi seluruh fitur dan data dalam sistem 
tanpa batasan. Keputusan ini didasarkan pada posisi Ketua Jurusan sebagai 
29 
pemegang otoritas tertinggi dalam proses penjadwalan ujian akademik di jurusan. 
Walaupun demikian, dashboard role lain Sekretaris Jurusan, Panitia tetap dibatasi 
sesuai tugas operasional masing-masing. Dengan cara ini, sistem tetap memiliki 
struktur kerja yang terdistribusi, tetapi tetap berada di bawah kontrol penuh Ketua 
Jurusan. Berikut penjelasan tampilan gambar dashboard dan fitur-fitur berdasarkan 
masing-masing role: 
3.5.1 Tampilan Halaman Dashboard role Ketua Jurusan, Sekretaris Jurusan, dan 
Panitia 
1.) Tampilan dashboard untuk role Ketua Jurusan pada sistem AgriSched 
dirancang untuk mendukung fungsi pengawasan dan pengambilan 
keputusan akademik secara menyeluruh. Pada bagian utama dashboard 
ditampilkan ringkasan status berbentuk indikator jumlah pengajuan yang 
masih menunggu verifikasi dan total pengajuan yang telah disetujui. 
Penyajian informasi ini bersifat action-oriented, sehingga membantu 
Ketua Jurusan mengidentifikasi prioritas pekerjaan secara cepat. Selain 
itu, disediakan fitur Quick Actions yang berfungsi sebagai pintasan 
menuju halaman verifikasi sehingga mempercepat alur kerja tanpa harus 
melalui navigasi menu yang panjang. Dashboard ini memberikan 
pengalaman penggunaan yang efisien, terarah, dan sesuai dengan 
kebutuhan peran Ketua Jurusan sebagai administrator utama sistem. Yang 
dapat dilihat pada Gambar 3.14 dibawah ini. 
30 
Gambar 3.14 Dashboard ketua jurusan 
2.) Pada halaman dashboard Sekretaris Jurusan dapat memperoleh ringkasan 
informasi berupa kartu statistik jumlah dosen, jadwal kegiatan minggu ini, 
serta status pembimbing dan penguji yang masih perlu diatur. Tampilan 
ini berfungsi sebagai informasi cepat (quick overview) untuk mendukung 
pengambilan keputusan tanpa harus membuka menu tambahan. Selain itu, 
bagian Quick Actions menyediakan shortcut untuk proses yang paling 
sering dilakukan, misalnya pengelolaan pembimbing dan penguji, data 
dosen, serta verifikasi seminar proposal sedangkan untuk semhas dan ujian 
skripsi mengambil data dari seminar proposal. Ini mempercepat alur kerja 
dan mengurangi waktu navigasi. Dengan membatasi akses berdasarkan 
peran, sistem tidak hanya menjaga integritas informasi tetapi juga 
memberikan pengalaman penggunaan yang lebih terarah, relevan, dan 
31 
fokus pada fungsi yang benar-benar dibutuhkan oleh peran tersebut. Yang 
dapat dilihat pada gambar 3.15 
Gambar 3.15 Dashboard sekretaris jurusan 
3.) Tampilan dashboard Panitia bagian utama, terdapat tiga indikator 
informasi penting yaitu Total Mahasiswa, Total Dosen, dan Total 
Pendaftaran. Setiap indikator tidak hanya menampilkan angka statistik, 
tetapi juga ikon visual agar informasi lebih mudah dikenali dan dipahami 
dalam satu kali lihat. Penyajian data ini membantu panitia mengetahui 
perkembangan data pendaftaran dan kesiapan sumber daya dosen serta 
mahasiswa sebelum penjadwalan dilakukan. Selain tampilan statistik, 
terdapat area Quick Actions yang berfungsi sebagai akses cepat menuju 
fitur inti sesuai kewenangan panitia, yaitu: pengelolaan Data Mahasiswa, 
Data Dosen, dan fitur pembuatan jadwal ujian melalui menu Buat Jadwal. 
Penempatan fitur tersebut pada bagian utama menunjukkan bahwa proses 
32 
pembuatan jadwal menjadi fungsi sentral dari role panitia di dalam sistem 
yang dapat dilihat pada gambar 3.16 
Gambar 3.16 Dashboard Panitia 
3.5.2 Halaman Data Master 
Peranan antarmuka pada gambar 3.17 dibawah ini menunjukkan halaman 
Data master yang hanya dapat diakses oleh Ketua Jurusan. Pada level ini, pengguna 
memperoleh hak akses penuh terhadap keseluruhan modul Data Master, mencakup 
pengelolaan data dosen, data mahasiswa, dan data admin. Selain fungsi 
pengelolaan, Ketua Jurusan juga memiliki akses untuk meninjau statistik 
komprehensif, seperti jumlah dosen total, dosen pembimbing aktif, dosen penguji 
aktif, serta distribusi status mahasiswa pada berbagai tahapan seminar dan ujian. 
Fitur pencarian turut disediakan untuk mempermudah proses pelacakan data pada 
skala besar. Meskipun antar peran memiliki tampilan antarmuka yang relatif 
33 
seragam untuk menjaga konsistensi visual dan kemudahan penggunaan, perbedaan 
mendasar terletak pada batasan fungsi yang dapat dijalankan. Sekretaris Jurusan 
hanya memiliki akses terhadap pengelolaan data dosen. Hak akses ini diberikan 
karena berperan dalam menentukan dosen penguji sehingga tidak diberikan akses 
terhadap data mahasiswa maupun data admin guna menjaga batasan tugas dan 
mengurangi risiko manipulasi data yang tidak relevan dengan lingkup 
kewenangannya yang dapat kita lihat pada gambar 3.18. Di sisi lain, Panitia 
memperoleh kewenangan untuk menambahkan dan mengelola data dosen serta 
mahasiswa. Hal ini diperlukan dalam proses penyusunan jadwal ujian, yang 
bergantung pada ketersediaan informasi dosen dan status akademik mahasiswa. 
Panitia kemudian dapat membuat jadwal berdasarkan tiga kategori ujian yang sudah 
ditetapkan, yaitu Seminar Proposal, Seminar Hasil, dan Ujian Skripsi. Namun 
demikian, Panitia tidak memiliki akses terhadap perubahan struktur peran ataupun 
verifikasi data, sehingga ruang lingkup tugas tetap terjaga sesuai prosedur akademik 
yang dapat kita lihat pada gambar 3.19  
34 
Gambar 3.17 Data Dosen 
Gambar 3.18 Data Mahasiswa 
Gambar 3.19 Data Admin 
35 
3.5.3 Tampilan Halaman verifikasi 
Halaman verifikasi pada sistem ini memiliki tampilan antarmuka yang sama 
untuk dua peran utama, yaitu Ketua Jurusan dan Sekretaris Jurusan. Meskipun 
demikian, kedua role tersebut memiliki perbedaan pada batasan akses dan 
kewenangan dalam memvalidasi data pendaftaran mahasiswa. Ketua jurusan 
memiliki akses penuh untuk memvalidasi seluruh tahapan proses, mulai dari 
Seminar Proposal, Seminar Hasil, hingga Ujian Skripsi. Pada setiap tahap tersebut, 
Ketua jurusan berwenang melakukan verifikasi lengkap, seperti menyetujui, 
memberikan revisi, serta menetapkan dosen penguji yang dapat dilihat pada gambar 
3.20. Sementara itu, sekretaris jurusan memiliki akses yang lebih terbatas. Pada 
tahap Seminar Proposal, sekretaris jurusan hanya dapat memvalidasi penetapan 
dosen penguji tanpa kewenangan memberikan keputusan akhir terhadap status 
persetujuan pendaftaran. Untuk tahap Seminar Hasil dan Ujian Skripsi, sekretaris 
jurusan tidak lagi menetapkan penguji secara langsung, karena sistem otomatis 
mengambil data penguji berdasarkan hasil validasi awal di tahap Seminar Proposal. 
Dengan demikian, meskipun tampilan kedua halaman terlihat serupa, perbedaan 
mekanisme kontrol akses memastikan bahwa proses memvalidasi dan 
memverifikasi setiap tahapan sesuai dengan peran dan tanggung jawab masing
masing. Ini dapat dilihat pada gambar 3.21 
36 
Gambar 3.20 Verifikasi pendaftaran 
Gambar 3.21 Penetapan Penguji  
3.5.4 Tampilan buat jadwal 
Halaman Buat Jadwal Ujian pada sistem ini menampilkan antarmuka yang 
digunakan untuk mengatur jadwal pelaksanaan seminar maupun ujian skripsi. 
Meskipun Ketua Jurusan memiliki akses penuh terhadap seluruh fitur dalam sistem, 
termasuk pembuatan jadwal, proses operasional penjadwalan sebenarnya menjadi 
wewenang utama panitia. Panitia bertugas untuk membuat dan mengatur jadwal 
37 
ujian, baik itu Seminar Proposal, Seminar Hasil, maupun Ujian Skripsi, sesuai 
dengan data mahasiswa dan tim dosen penguji yang telah divalidasi pada tahap 
sebelumnya. Pada halaman ini, panitia dapat memilih mahasiswa, melihat informasi 
jenis ujian dan daftar dosen penguji yang sudah ditetapkan, kemudian menentukan 
tanggal pelaksanaan, jam mulai, jam selesai dan ruangan ujian. Dengan demikian, 
meskipun Ketua jurusan tetap memiliki hak akses penuh sebagai bentuk kontrol dan 
supervisi, otoritas pelaksanaan penjadwalan diberikan kepada panitia agar proses 
administrasi akademik dapat berjalan lebih terstruktur, terdistribusi, dan efisien. 
Gambar 3.22 
Gambar 3.22 Buat Jadwal 
3.5.5 Tampilan halaman laporan masing- masing role 
Halaman Laporan Sistem pada aplikasi ini menyediakan fitur untuk 
menghasilkan berbagai jenis laporan yang dibutuhkan dalam proses administrasi 
akademik, seperti laporan dosen pembimbing, dosen penguji, serta rekap kegiatan 
seminar dan ujian mahasiswa. Secara tampilan, halaman laporan pada setiap role 
38 
baik Ketua Jurusan maupun Sekretaris Jurusan memiliki antarmuka yang serupa, 
mulai dari form pemilihan jenis laporan, bulan, tahun, hingga tombol untuk 
menampilkan data (Preview Data) dan mengunduh laporan dalam format Excel atau 
PDF. 
Gambar 3.23 Laporan Sistem 
3.5.6 Tampilan fitur profile masing-masing role 
Fitur Profil Admin pada aplikasi ini dirancang dengan tampilan yang sama 
untuk semua role, baik Ketua Jurusan, Sekretaris Jurusan, maupun Panitia, sehingga 
setiap pengguna dapat memperbarui informasi pribadinya dengan mudah dan 
konsisten. Pada halaman ini, sistem menampilkan identitas pengguna di panel kiri, 
termasuk nama lengkap, role, serta status akun yang sedang aktif. Sementara itu, 
panel kanan menyediakan formulir untuk mengubah data pribadi seperti nama, 
email, serta nomor WhatsApp yang digunakan untuk menerima notifikasi dari 
sistem. Selain itu, pengguna juga dapat memperbarui keamanan akun melalui fitur 
penggantian password. Meskipun tampilan dan fungsi halaman profil ini serupa 
39 
untuk semua role, data yang dapat diubah tetap terbatas pada informasi pribadi 
masing-masing pengguna, tanpa akses untuk memodifikasi data admin lain. Dengan 
demikian, fitur profil ini membantu memastikan bahwa setiap role dapat mengelola 
akunnya secara mandiri sambil tetap menjaga batasan keamanan dan tanggung 
jawab masing-masing dalam sistem yang dapat dilihat pada gambar 3.24. 
Gambar 3.24 Profile Admin 
3.6 Tampilan Mahasiswa 
3.6.1 Halaman Dashboard 
Setelah login, mahasiswa langsung melihat Dashboard berisi status 
pendaftarannya. Bagian ini memperlihatkan tahapan yang sudah dilalui mulai dari 
pengajuan, verifikasi, hingga penetapan jadwal ujian. Dengan tampilan yang 
ringkas, mahasiswa bisa memantau kemajuan pendaftaran tanpa perlu membuka 
banyak menu. 
40 
Gambar 3.25 Halaman dashboard mahasiswa 
3.6.2 Halaman pendaftaran seminar proposal 
Sebelum mengakses halaman ini mahasiswa harus melengkapi profil 
terlebih dulu agar bisa mengakses halaman pendaftaran. Pada saat mendaftar 
mahasiswa mengisi data pendaftaran seminar proposal, termasuk nama 
pembimbing, judul penelitian, dan berkas pengesahan. Setelah semua data 
dimasukkan. 
Gambar 3.26 Tampilan pendaftaran sempro 
41 
Gambar 3.27 Tampilan pendaftaran sempro 
3.6.3 Halaman pendaftaran seminar hasil 
Tahapan berikutnya adalah pendaftaran seminar hasil mahasiswa harus 
menyelesaikan seminar proposal agar bisa daftar seminar hasil. Data pembimbing 
dan judul otomatis diambil dari pendaftaran sebelumnya, sementara penguji sudah 
ditetapkan oleh sekretaris. Mahasiswa hanya perlu melengkapi dokumen tambahan 
yang diperlukan. 
42 
Gambar 3.28 Tampilan pendaftaran seminar hasil 
3.6.4 Halaman pendaftaran ujian skripsi 
Pendaftaran ujian skripsi memiliki alur serupa, namun dengan tambahan 
unggahan file pendukung lainnya. Semua berkas dikumpulkan secara daring agar 
proses administrasi lebih cepat dan tidak bergantung pada pengumpulan berkas 
fisik 
Gambar 3.29 Tampilan pendaftaran ujian skripsi 
43 
3.6.5 Halaman Profil Mahasiswa 
Sebelum mendaftar, mahasiswa diminta melengkapi profil pribadinya. 
Nomor WhatsApp yang tercantum di sini digunakan untuk mengirim notifikasi 
status pendaftaran dan jadwal ujian. Dengan begitu, mahasiswa bisa terus 
memantau proses tanpa harus membuka sistem setiap saat. 
Gambar 3.30 halaman profile 
3.6.6 Halaman jadwal  
Menu Jadwal menampilkan daftar lengkap jadwal ujian yang sudah 
ditetapkan panitia. Mahasiswa dapat melihat tanggal, waktu, ruangan, serta nama 
dosen penguji. Tampilan ini membantu mereka mempersiapkan diri lebih baik dan 
memastikan tidak ada benturan waktu dengan kegiatan lain. 
44 
 
 
 
 
Gambar 3.31 Tampilan jadwal ujian 
 
 
BAB IV 
KESIMPULAN 
4.1 Kesimpulan 
Berdasarkan hasil perancangan dan implementasi sistem penjadwalan ujian 
berbasis Web (AgriSched) di Jurusan Agribisnis Universitas Negeri Gorontalo, 
dapat disimpulkan bahwa sistem ini berhasil menghasilkan output data yang relevan 
dan sesuai dengan kebutuhan pengelolaan administrasi akademik di tingkat jurusan. 
Sistem AgriSched menampilkan output berupa data pendaftaran mahasiswa, status 
verifikasi berkas, jadwal ujian seminar proposal, seminar hasil, dan ujian skripsi, 
daftar dosen pembimbing dan penguji, serta lokasi dan waktu pelaksanaan ujian. 
Semua data tersebut disajikan dalam bentuk tabel interaktif yang dapat diakses 
secara real-time oleh pengguna melalui antarmuka web yang sederhana dan mudah 
dipahami.  
Selain menampilkan data utama tersebut, sistem juga menyediakan fitur 
pencarian dan penyaringan data untuk memudahkan pihak jurusan dalam meninjau 
status ujian setiap mahasiswa. Dengan adanya fitur ini, proses administrasi yang 
sebelumnya dilakukan secara manual melalui Google Form dan Excel kini dapat 
berjalan lebih cepat, akurat, dan terpusat dalam satu sistem digital. Secara 
keseluruhan, implementasi AgriSched memberikan dampak positif dalam 
meningkatkan efisiensi kerja, transparansi informasi, serta akurasi dalam 
penjadwalan ujian skripsi.  
Sistem ini membantu mengurangi potensi kesalahan administratif, 
mempercepat proses pengumuman jadwal, serta memberikan kemudahan bagi 
45 
46 
mahasiswa dan dosen dalam memantau kegiatan ujian. Dengan demikian, 
AgriSched dapat dikatakan berhasil memenuhi tujuan perancangannya sebagai 
solusi digital yang relevan dan bermanfaat bagi Jurusan Agribisnis Universitas 
Negeri Gorontalo. 
4.2 Saran 
Penulis menyarankan bagi Jurusan Agribisnis Universitas Negeri Gorontalo 
yaitu agar melakukan pemeliharaan sistem secara rutin, baik dari sisi server, basis 
data, maupun antarmuka pengguna, sehingga performa dan keamanan data tetap 
terjaga dengan baik. Selain itu, sistem disarankan untuk diintegrasikan dengan 
platform akademik kampus seperti SIAT atau SIAKAD agar proses pembaruan data 
mahasiswa dan penjadwalan ujian dapat berlangsung otomatis tanpa perlu 
melakukan input data berulang. Jurusan juga perlu memberikan pelatihan kepada 
dosen maupun tenaga kependidikan agar penggunaan sistem AgriSched dapat 
berjalan secara merata di lingkungan civitas akademika. 
Diharapkan pihak instansi dan bagi peneliti atau pengembang selanjutnya, 
pengembangan sistem dapat diarahkan pada integrasi teknologi kecerdasan buatan 
(AI) untuk memberikan rekomendasi penguji berdasarkan bidang keahlian dosen 
serta topik penelitian mahasiswa. Selain itu, sistem juga dapat dikembangkan 
menuju analitik akademik yang mampu menyajikan wawasan strategis terkait 
tingkat kelulusan, beban kerja dosen, serta efektivitas pelaksanaan seminar 
proposal, seminar hasil, dan ujian skripsi.
DAFTAR PUSTAKA 
Siswanto, E. (2025). Penerapan teknologi sistem informasi untuk mendukung bisnis 
berbasis website. Jurnal Teknologi Sistem Informasi, 7(2), 101-115.    
Maydianto, & Ridho. (2021). Sistem sebagai jaringan proses kerja yang saling 
terkait untuk mencapai tujuan organisasi. Jurnal Sistem Informasi, 15(1), 75
90.  
Komala Sari, & Isnaini. (2021). Sistem informasi dan pengelolaan data: Perspektif 
teknologi dan manajemen. Jurnal Sistem Informasi Pengelolaan, 12(3), 30-45.  
Lim, M. (2021). Konsep sistem dan variabel dasarnya dalam teknologi informasi. 
Jurnal Comasie, 5(4), 54-68.  
Budiani, N. (2000). DATA FLOW DIAGRAM: sebagai alat bantu desain sistem. 
Analisis dan Perancangan Sistem 
Ummah, H. A., Sodikin, I., & Susetyo, J. (2019). Perancangan Sistem Informasi 
Rental & Inventaris Alat Multimedia Berbasis Web Menggunakan Metode 
Customer Relationship Management. Jurnal Rekavasi, 7(2), 15-24 
Puan, A., Syahputra, R., Aldine, T. T., Islam, U., & Sumatera, N. (2023). 
MANFAAT PENGGUNAAN DATABASE DALAM PENINGKATAN. 1(3), 
14–19. 
48 
LAMPIRAN 
Lampiran 1: Log Kegiatan Kerja Praktek 
Hari/Tanggal  
Lokasi   
Uraian Kegiatan 
Hari/Tanggal  
Lokasi   
Uraian Kegiatan 
: 11 September 2025 
: Jurusan Agribisnis UNG 
: Penerimaan Mahasiswa Magang 
: Jum’at, 16 September 2025 
: Jurusan Agribisnis UNG 
: Analisis Sistem yang ada di Jurusan Agribisnis 
49 
Hari/Tanggal  
Lokasi   
Uraian Kegiatan 
: Rabu, 17-09-2025 
: Ruangan Ketua jurusan Agribisnis UNG 
: Diskusi Proses Bisnis Pendaftaran Ujian 
Hari/Tanggal  
Lokasi   
Uraian Kegiatan 
: Selasa, 19 September 2025 
: Jurusan Agribisnis UNG 
: Mengunjungi Lahan  
50 
Hari/Tanggal  
Lokasi   
Uraian Kegiatan 
: Senin, 06-10-2025 
: Lab Komputer 2 Agribisnis UNG 
: Asistensi Desain UI/UX Sistem AgriSched 
Hari/Tanggal  
Lokasi   
Uraian Kegiatan 
: Selasa, 04-11-2025 
: Lab Kompuer 2 Agribisnis UNG 
: Asistensi Sistem AgriSched 
51 
Hari/Tanggal  
Lokasi   
Uraian Kegiatan 
: Selasa, 04-11-2025 
: Ruang Ujian Agribisnis UNG 
: Asistensi Sistem 
Hari/Tanggal  
Lokasi   
Uraian Kegiatan 
: Rabu, 05-11-2025 
: Ruang Ujian Agribisnis UNG 
: Simulasi Sistem AgriSched 
52 
Hari/Tanggal  
Lokasi   
Uraian Kegiatan 
: Kamis, 06-11-2025 
: Ruang Podast Agribisnis UNG 
: Mengatur Alat untuk Podcast 
Hari/Tanggal  
Lokasi   
Uraian Kegiatan 
: Senin, 10-11-2025 
: Lab Komputer 2 Agribisnis UNG 
: Penginstalan Aplikasi 
53 
Hari/Tanggal  
Lokasi   
Uraian Kegiatan 
: Selasa, 11-11-2025 
: Jurusan Agribisnis UNG 
: Syuting Film Pendek  
Hari/Tanggal  
Lokasi   
Uraian Kegiatan 
: jum`at 14-11-2025 
: Ruang Ujian Agribisnis UNG 
: Asistensi Laporan 
54 
 
 
55 
 
 
 
  
 
 
 
56 
 
Lampiran 2: Tabel Kegiatan KP 
 
 
 
 
57 
 
 
 
 
58 
 
 
 
 
59 
 
 
 
 
 
 
60 
 
 
 
 
61 
 
 
 
 
 
62 
 
 
 
 
63 
 
 
 
 
64 
 
 
 
 
 
65 
 
 
 
 
66 
 
Lampiran 3: Lembar Asistensi 
 
 
 
67 
 
 
 
68 
 
 
 
69 
 
 