DESIGN SPECIFICATION

CRITICAL BUILD REQUIREMENT — TAILWIND CSS

Proyek ini WAJIB menggunakan Tailwind CSS melalui Tailwind CLI sejak awal pengembangan.

DILARANG menggunakan:

https://cdn.tailwindcss.com

<script src="https://cdn.tailwindcss.com"></script>

@tailwindcss/browser

Tailwind Play CDN atau metode CDN/browser-runtime Tailwind lainnya.

Antigravity wajib menyiapkan build Tailwind lokal sebelum mengembangkan halaman UI, sehingga seluruh class Tailwind yang digunakan dalam HTML diproses menjadi CSS hasil build lokal.

Gunakan alur Tailwind CSS v4 berbasis CLI:

npm install tailwindcss @tailwindcss/cli

Buat file CSS input, misalnya:

@import "tailwindcss";

Jalankan proses build/watch:

npx @tailwindcss/cli -i ./src/input.css -o ./src/output.css --watch

HTML harus memuat CSS hasil build lokal, bukan CDN:

<link rel="stylesheet" href="./src/output.css">

Tujuan: struktur frontend sejak awal harus siap dipindahkan ke Laravel dan digunakan pada environment production tanpa ketergantungan terhadap CDN Tailwind.

Jika Antigravity mendeteksi bahwa project masih memiliki cdn.tailwindcss.com, @tailwindcss/browser, atau konfigurasi Tailwind berbasis CDN, hapus dan migrasikan ke Tailwind CLI sebelum melanjutkan implementasi UI.

Jangan menggunakan CDN sebagai fallback, bahkan untuk halaman prototype. Jika proses build belum tersedia, perbaiki konfigurasi Node/Tailwind CLI terlebih dahulu.

DESIGN.md

Design System --- Sistem Informasi Absensi & Monitoring Kedisiplinan Pegawai

Versi: 1.0 Final
Status: Frontend Prototype
Target implementasi: HTML5 + Tailwind CSS + Vanilla JavaScript
Tahap berikutnya: Laravel Blade + PHP + MySQL
Referensi visual: 9 screenshot pada paket referensi
2026-08-27_*.png

1. Tujuan Dokumen

Dokumen ini menjadi pedoman visual dan UX utama untuk pembangunan
frontend Sistem Informasi Absensi & Monitoring Kedisiplinan Pegawai.

Desain harus mengambil karakter visual dari 9 screenshot referensi yang
diberikan, terutama:

sidebar dark navy di sisi kiri;

header putih dengan identitas pengguna;

background utama abu-abu sangat muda;

card putih dengan border tipis;

dashboard yang padat tetapi terstruktur;

tabel data administratif;

badge status;

modal/form yang bersih;

filter dan search bar;

tombol utama berwarna biru;

layout desktop-first untuk Admin;

responsive mobile untuk Pegawai.

Jangan menyalin screenshot secara pixel-perfect. Gunakan screenshot
sebagai referensi gaya, struktur, kepadatan informasi, hierarchy, dan
pola komponen.

2. Prinsip Desain

Gunakan 8 prinsip berikut:

Professional Government Application

Terlihat seperti sistem resmi instansi pemerintah.

Hindari gaya startup yang terlalu playful.

Clean & Dense

Informasi cukup padat untuk kebutuhan monitoring.

Tetap gunakan whitespace agar tidak terasa sesak.

Functional First

Tombol, tabel, filter, modal, dan status harus mudah dipahami.

Consistent

Satu pola card, button, badge, table, modal, dan form digunakan
di seluruh halaman.

Responsive

Desktop dan mobile bukan sekadar ukuran berbeda.

Struktur layout harus menyesuaikan perangkat.

Readable

Teks tabel, angka statistik, dan status harus terbaca dengan
cepat.

Minimal Decoration

Tidak menggunakan gradient berlebihan, glassmorphism, shadow
berat, atau animasi dekoratif.

Ready for Laravel

Komponen dan struktur HTML harus mudah dipindahkan ke Blade
Components.

3. Karakter Visual Referensi

Dari 9 screenshot referensi, karakter desain utama yang harus
dipertahankan:

Sidebar

Dark navy.

Lebar tetap pada desktop.

Logo/identitas instansi di bagian atas.

Menu menggunakan icon + label.

Menu aktif menggunakan highlight biru.

Kelompok menu memiliki label section.

Informasi pengguna/sistem berada di area bawah.

Header

Background putih.

Tinggi relatif compact.

Judul/breadcrumb berada di area kiri content.

Profile/admin indicator di kanan.

Tidak menggunakan header yang terlalu tinggi.

Content

Background abu-abu sangat muda.

Content memiliki margin/padding yang cukup.

Judul halaman di atas.

Subtitle/deskripsi pendek di bawah judul jika diperlukan.

Card

Background putih.

Border tipis.

Radius kecil sampai sedang.

Shadow sangat ringan atau tanpa shadow.

Padding konsisten.

Modal

Screenshot referensi menunjukkan penggunaan modal yang compact.

Gunakan:

overlay gelap/transparan;

modal putih;

title;

close button;

form;

footer action;

tombol Cancel dan primary action.

Modal tidak boleh terlalu besar jika form sederhana.

Tabel

Header abu-abu muda/putih.

Row compact.

Border antar-row tipis.

Status memakai badge.

Action berada di kanan.

Search/filter berada di atas tabel.

4. Layout Global

Desktop

Gunakan struktur:

┌──────────────────────────────────────────────────────────┐
│ Sidebar │ Header                                         │
│         ├────────────────────────────────────────────────┤
│         │                                                │
│         │ Page Title                                     │
│         │ Subtitle                                       │
│         │                                                │
│         │ Content / Cards / Tables                       │
│         │                                                │
│         └────────────────────────────────────────────────┘
└──────────────────────────────────────────────────────────┘

Ukuran

Sidebar: 248px sampai 264px.

Header: 64px sampai 72px.

Main content: max-width sekitar 1440px.

Padding content desktop: 24px sampai 32px.

Gap antar-card: 16px sampai 24px.

Gunakan CSS/Tailwind agar ukuran tetap fleksibel.

5. Breakpoint

Gunakan breakpoint Tailwind:

sm  = 640px
md  = 768px
lg  = 1024px
xl  = 1280px
2xl = 1536px

Desktop

>= 1024px

Sidebar terlihat.

Header normal.

Dashboard menggunakan grid.

Tabel normal.

Tablet

768px – 1023px

Sidebar dapat menjadi drawer.

Card mulai turun menjadi 2 kolom.

Tabel dapat horizontal scroll.

Mobile

< 768px

Sidebar disembunyikan.

Hamburger button muncul.

Bottom navigation Pegawai dapat digunakan.

Card menjadi satu kolom.

Form menjadi satu kolom.

Tabel berubah menjadi scroll horizontal atau card list.

Action button dibuat lebih besar.

6. Color System

Gunakan warna yang tenang dan profesional.

Primary

Primary 900: #0B1F3A
Primary 800: #102A4C
Primary 700: #163B68
Primary 600: #1D4F91
Primary 500: #2563A8

Primary digunakan untuk:

sidebar;

primary button;

active menu;

link penting;

elemen utama dashboard.

Neutral

White:      #FFFFFF
Gray 50:    #F8FAFC
Gray 100:   #F1F5F9
Gray 200:   #E2E8F0
Gray 300:   #CBD5E1
Gray 500:   #64748B
Gray 600:   #475569
Gray 700:   #334155
Gray 900:   #0F172A

Background utama:

#F5F7FA

Status

Gunakan warna status secara konsisten:

Success:
#16A34A / background #DCFCE7

Warning:
#D97706 / background #FEF3C7

Danger:
#DC2626 / background #FEE2E2

Info:
#2563EB / background #DBEAFE

Neutral:
#64748B / background #F1F5F9

Jangan menggunakan warna status sebagai warna utama seluruh halaman.

7. Typography

Gunakan:

Inter

Fallback:

ui-sans-serif, system-ui, sans-serif

Hierarchy

Page Title

20px – 24px
font-weight: 700

Section Title

16px – 18px
font-weight: 600

Card Number

24px – 32px
font-weight: 700

Body

14px

Table

13px – 14px

Caption

12px – 13px

Jangan menggunakan terlalu banyak ukuran font.

8. Border Radius

Gunakan radius yang relatif kecil seperti referensi.

Card: 10px – 12px
Button: 8px
Input: 8px
Modal: 12px
Badge: 9999px
Avatar: 9999px

Hindari card dengan radius 24px atau lebih.

9. Shadow

Gunakan shadow ringan.

shadow-sm

atau:

box-shadow: 0 1px 3px rgba(15, 23, 42, 0.06);

Jangan menggunakan shadow besar/deep.

Border lebih penting daripada shadow.

10. Spacing

Gunakan spacing berbasis kelipatan 4/8.

4px
8px
12px
16px
20px
24px
32px
40px
48px

Standar:

gap kecil: 8px

gap antar elemen: 16px

gap antar section: 24px

padding card: 20px – 24px

page padding: 24px – 32px

11. Sidebar

Desktop

Sidebar:

width: 250px
position: fixed
height: 100vh

Background:

Primary 900

Struktur:

LOGO
Nama Sistem

Dashboard

OPERASIONAL
  Pegawai
  Absensi
  Kegiatan
  Pengajuan

KEDISIPLINAN
  Monitoring
  Indeks
  Ranking
  Pelanggaran

PERINGATAN & SP

LAPORAN

AUDIT LOG

PENGATURAN

-----------------
Profile
Logout

Menu Item

Normal:

teks putih/abu muda;

icon abu muda;

background transparan.

Hover:

background primary sedikit lebih terang.

Active:

background primary;

teks putih;

icon putih;

indicator kiri atau highlight yang jelas.

Jangan membuat sidebar terlalu berwarna.

12. Sidebar Mobile

Pada mobile:

sidebar default hidden;

hamburger membuka drawer;

overlay menutupi content;

drawer width sekitar 280px;

klik overlay menutup drawer;

tombol close tersedia.

Pastikan drawer dapat digunakan dengan satu tangan.

13. Header

Header desktop:

┌───────────────────────────────────────────────────────┐
│ Breadcrumb / Page Context              Admin   Avatar │
└───────────────────────────────────────────────────────┘

Gunakan:

background putih;

border-bottom;

tinggi sekitar 64px;

profile indicator di kanan.

Mobile:

┌──────────────────────────────────┐
│ ☰  Nama Halaman             👤   │
└──────────────────────────────────┘

14. Page Header

Setiap halaman harus mempunyai page header.

Contoh:

Data Pegawai
Kelola data pegawai dan informasi akun.

Di kanan:

[ + Tambah Pegawai ]

Jika halaman tidak membutuhkan action, jangan memaksakan tombol.

15. Breadcrumb

Gunakan breadcrumb hanya jika membantu.

Contoh:

Dashboard / Pegawai / Detail Pegawai

Font kecil:

12px – 13px

Current page lebih gelap.

16. Button System

Primary

[ + Tambah Pegawai ]

background primary;

text white;

hover lebih gelap;

height sekitar 36px – 40px.

Secondary

[ Batal ]

white;

border;

text dark.

Danger

[ Hapus ]

Gunakan hanya untuk tindakan berisiko.

Ghost

Untuk action kecil/icon button.

17. Card

Gunakan struktur:

Card
├── Header
│   ├── Title
│   └── Action
├── Content
└── Optional Footer

Card tidak harus memiliki shadow.

Default:

background: white
border: 1px solid #E2E8F0
border-radius: 12px

18. Statistic Card

Untuk dashboard Admin:

┌──────────────────────────┐
│ Total Pegawai       👥   │
│                          │
│ 50                       │
│ +2 bulan ini             │
└──────────────────────────┘

Gunakan:

icon kecil;

label;

angka besar;

optional trend;

status indicator.

Jangan menggunakan ilustrasi besar.

19. Badge

Badge berbentuk pill.

Contoh:

[ Tepat Waktu ]
[ Terlambat ]
[ Alpha ]
[ Disetujui ]
[ Menunggu ]
[ Ditolak ]

Gunakan:

font 11--12px;

medium/semibold;

padding horizontal 8--10px.

20. Table

Struktur:

Table Header
Search / Filter
------------------------------------
No | Pegawai | Tanggal | Status | Action
------------------------------------
1  | Budi    | 07 Sep  | Tepat  | ...
2  | Andi    | 07 Sep  | Telat  | ...

Header:

font 12--13px;

semibold;

uppercase boleh digunakan secara terbatas;

background sangat muda.

Row:

height sekitar 52px – 64px;

border-bottom;

hover background subtle.

Action:

View;

Edit;

Delete;

More.

Gunakan icon button jika action sangat pendek.

21. Search & Filter Bar

Gunakan card/filter container:

[ 🔍 Cari pegawai... ] [ Status ▼ ] [ Bulan ▼ ] [ Filter ]

Desktop:

horizontal.

Mobile:

stacked atau 2 kolom kecil.

Jangan membuat filter terlalu tinggi.

22. Pagination

Di bawah tabel:

Menampilkan 1–10 dari 50 data

[ < ] [ 1 ] [ 2 ] [ 3 ] ... [ > ]

Pagination sederhana.

23. Form

Gunakan label di atas input.

Nama Pegawai
[________________________]

ID Pegawai
[________________________]

Jabatan
[________________________]

Jangan menggunakan placeholder sebagai satu-satunya label.

Input:

height: 40px – 44px
border: 1px solid #CBD5E1
radius: 8px

Focus:

border primary;

subtle ring.

Error:

Nama wajib diisi.

24. Modal

Struktur:

Overlay
└── Modal
    ├── Header
    │   ├── Title
    │   └── Close
    ├── Body
    └── Footer
        ├── Batal
        └── Simpan

Ukuran:

small: 400px;

medium: 520px – 600px;

large: 720px – 900px.

Gunakan medium untuk form pegawai.

25. Toast

Toast berada di kanan atas desktop.

Mobile:

atas atau bawah dengan margin aman.

Contoh:

✓ Absensi berhasil disimpan

Jenis:

success;

warning;

error;

info.

Animasi singkat saja.

26. Dashboard Admin

Dashboard Admin harus paling mendekati karakter screenshot referensi.

Layout:

Page Header

Statistic Cards
─────────────────────────────────────

┌─────────────────────────┐ ┌───────┐
│ Grafik Absensi          │ │ Alert │
│                         │ │       │
└─────────────────────────┘ └───────┘

┌────────────────────────────────────┐
│ Monitoring Absensi Hari Ini        │
│                                    │
│ Table                              │
└────────────────────────────────────┘

Prioritas visual:

statistik;

kondisi absensi hari ini;

pegawai yang perlu perhatian;

grafik;

aktivitas/pengajuan terbaru.

27. Dashboard Pegawai

Dashboard Pegawai harus lebih sederhana daripada Admin.

Desktop:

Greeting

┌────────┬────────┬────────┬────────┐
│ Datang │ Pulang │ Alpha  │ Indeks │
└────────┴────────┴────────┴────────┘

┌──────────────────────┐ ┌───────────┐
│ Absensi Hari Ini     │ │ Indeks    │
└──────────────────────┘ └───────────┘

┌────────────────────────────────────┐
│ Aktivitas Terbaru                  │
└────────────────────────────────────┘

Mobile:

greeting;

status absensi;

lokasi;

tombol absensi;

ringkasan indeks;

aktivitas.

28. Halaman Absensi --- Prioritas Mobile

Ini adalah halaman yang paling berbeda dari dashboard Admin.

Pada mobile:

Header

Selamat pagi, Budi
07 September 2026

┌──────────────────────────┐
│ 📍 Lokasi Kantor         │
│                          │
│ +20 meter                │
│ Dalam Radius ✓           │
└──────────────────────────┘

┌────────────┬─────────────┐
│ DATANG     │ PULANG      │
│ 08:05      │ Belum       │
└────────────┴─────────────┘

[ 📷 ABSEN DATANG ]

Riwayat hari ini

Tombol absensi:

full width;

tinggi minimal 48px;

mudah ditekan;

primary color.

29. Status Lokasi

Jika valid:

✓ Dalam Radius Kantor
+20 meter

Jika invalid:

✕ Di Luar Radius Kantor
+125 meter

Absensi tidak tersedia karena Anda berada
di luar radius kantor.

Jangan menampilkan latitude/longitude pegawai.

Yang tampil hanya jarak.

30. Kamera Absensi

Modal/halaman kamera:

┌────────────────────────────┐
│ Foto Absensi               │
├────────────────────────────┤
│                            │
│      Camera Preview        │
│                            │
├────────────────────────────┤
│ [ Ambil Foto ]             │
└────────────────────────────┘

Setelah capture:

Foto berhasil

[ Ambil Ulang ] [ Gunakan Foto ]

Foto wajib.

Maksimum 5MB.

31. Status Tombol Absensi

Dalam radius + belum absen

[ Absen Datang ]

Enabled.

Di luar radius

[ Absen Datang ]

Disabled.

Sudah absen

✓ Sudah Absen
08:05

Disabled.

32. Riwayat Absensi

Desktop menggunakan tabel.

Mobile menggunakan card:

07 September 2026
────────────────────
Datang
08:05
Tepat Waktu

Pulang
16:01
Pulang

Jarak:
+20 meter

33. Rekap Bulanan

Gunakan:

summary cards;

calendar;

table.

Calendar status:

✓ Hadir
⚠ Terlambat
× Alpha
I Izin
S Sakit
C Cuti
D Dinas

Gunakan visual kecil agar calendar tidak ramai.

34. Halaman Kegiatan

Form utama:

Laporan Kegiatan

Tanggal
Nama Kegiatan
Deskripsi
Foto Bukti

[ Simpan Laporan ]

History:

Card kegiatan
Tanggal
Nama
Ringkasan
Foto
Status

Laporan kegiatan tidak wajib dibuat setiap hari.

35. Halaman Pengajuan

Gunakan tab/filter:

Semua | Izin | Sakit | Cuti | Dinas

List:

Cuti
01–03 September 2026
Menunggu

[ Lihat Detail ]

Admin mendapatkan action:

[ Setujui ] [ Tolak ]

36. Halaman Kedisiplinan

Gunakan hierarchy:

Indeks Kedisiplinan
        87.5
        BAIK

────────────────────

Kehadiran & Ketepatan Waktu
████████████░ 92

Kepatuhan Aturan
████████████░ 90

Produktivitas
███████████░░ 85

Kualitas Kerja
Belum Dinilai

Perilaku & Sikap
Belum Dinilai

Jangan memberikan nilai otomatis kepada kualitas atau perilaku jika
belum ada penilaian Admin.

37. Halaman Ranking Admin

Gunakan layout:

Ranking Kedisiplinan

🥇 Pegawai A     95.2
🥈 Pegawai B     93.8
🥉 Pegawai C     92.5

Tabel ranking lengkap

Gunakan visual sederhana.

Ranking adalah alat monitoring, bukan otomatis hukuman.

38. Halaman SP Pegawai

Jika tidak ada SP:

Tidak ada Surat Peringatan
Saat ini Anda tidak memiliki SP aktif.

Jika ada:

SP1
Nomor: 001/SP1/2026
Tanggal: 15 September 2026

[ Lihat Surat ]

Gunakan document viewer berbasis HTML.

39. Halaman SP Admin

Gunakan tiga bagian:

SP Terpicu
Riwayat SP
Penerbitan SP

SP terpicu:

Budi Santoso
Alpha: 6
SP berikutnya: SP2

[ Terbitkan SP ]

Setelah klik, gunakan modal konfirmasi.

40. Dokumen SP

Tampilan harus menyerupai surat resmi:

┌────────────────────────────────────┐
│        PEMERINTAH KOTA ...         │
│                                    │
│          SURAT PERINGATAN          │
│                                    │
│ Nomor: ...                         │
│                                    │
│ Kepada:                            │
│ Nama: Budi Santoso                │
│ ID: PEG001                         │
│ Jabatan: Staff                     │
│                                    │
│ Isi surat...                       │
│                                    │
│                         Gorontalo   │
└────────────────────────────────────┘

Tidak perlu membuat desain surat terlalu dekoratif.

41. Responsive Table Strategy

Untuk tabel lebar:

Opsi 1

Horizontal scroll:

overflow-x-auto

Opsi 2

Pada mobile, ubah menjadi card list.

Gunakan opsi 2 untuk:

Data Pegawai;

Monitoring Absensi;

Ranking;

Riwayat SP;

jika tabel menjadi terlalu sempit.

42. Bottom Navigation Pegawai

Pada mobile:

┌─────────────────────────────────┐
│ Beranda │ Absensi │ Kegiatan │ + │
└─────────────────────────────────┘

Menu yang disarankan:

Beranda

Absensi

Kegiatan

Pengajuan

Profil

Menu lainnya tetap tersedia melalui drawer.

Bottom navigation:

fixed;

background putih;

border-top;

active icon primary;

text 10--12px.

43. Empty State

Gunakan empty state standar:

        [ icon ]

Belum Ada Data

Belum terdapat laporan kegiatan
pada periode ini.

[ Tambah Data ]

Tidak boleh ada halaman putih kosong.

44. Loading State

Gunakan skeleton:

████████████
██████
████████████████

Gunakan hanya saat perpindahan/initial load mock.

45. Error State

Contoh:

Terjadi Kesalahan

Data belum dapat ditampilkan.

[ Coba Lagi ]

46. Confirmation Dialog

Untuk tindakan penting:

hapus;

approve;

reject;

terbitkan SP;

reset password.

Contoh:

Terbitkan SP?

SP2 akan diterbitkan untuk Budi Santoso.

[ Batal ] [ Terbitkan SP ]

47. Iconography

Gunakan Lucide Icons.

Style:

outline;

stroke sekitar 1.75--2px;

ukuran 16--20px untuk menu;

20--24px untuk card;

14--16px untuk table action.

Jangan mencampur banyak icon library.

48. Charts

Gunakan Chart.js.

Style chart:

sederhana;

grid tipis;

legend minimal;

tooltip jelas;

tidak menggunakan 3D;

tidak menggunakan gradient berat.

Jenis:

Absensi

Bar/line chart.

Indeks Kedisiplinan

Line chart.

Status Absensi

Doughnut boleh digunakan jika benar-benar membantu.

49. Animasi

Gunakan animasi minimal:

modal fade/scale ringan;

drawer slide;

toast slide/fade;

hover transition.

Durasi:

150ms – 250ms

Jangan menggunakan:

parallax;

bouncing;

animated background;

efek berlebihan.

50. Accessibility

Wajib:

label form;

focus state;

keyboard navigation;

aria-label untuk icon-only button;

kontras yang baik;

ukuran tombol mobile minimal sekitar 44px;

jangan menyampaikan status hanya menggunakan warna.

Contoh:

Jangan hanya:

● merah

Gunakan:

[ Alpha ]

51. Mock Data Visual

Frontend harus menggunakan mock data terpusat.

Data harus konsisten antar halaman.

Contoh:

const employees = [
  {
    id: 1,
    employeeCode: "PEG001",
    name: "Budi Santoso",
    position: "Staff",
    field: "Perdagangan",
    status: "Aktif"
  }
];

Data Budi yang sama harus muncul di:

Dashboard;

Data Pegawai;

Absensi;

Kegiatan;

Kedisiplinan;

Ranking;

SP.

52. Aturan Bisnis yang Mempengaruhi UI

QR

QR hanya URL statis.

Tidak boleh ada UI yang menyatakan QR memvalidasi pegawai.

GPS

GPS hanya gate absensi.

Radius:

50 meter

UI hanya menampilkan jarak.

Foto

Absensi Datang dan Pulang wajib foto.

Absensi

Hanya:

Datang
Pulang

Tidak ada absensi setelah istirahat.

53. Status Datang

Gunakan:

< 08:00
Datang Awal

08:00 – 08:30
Tepat Waktu

08:31 – 09:00
Terlambat

> 09:00
Alpha

Absensi tetap dapat dilakukan setelah 09:00 jika GPS dan foto valid,
tetapi statusnya Alpha.

54. Status Pulang

Senin--Kamis:

< 15:55
Pulang Lebih Awal

15:55 – 16:00
Tepat Waktu

> 16:00
Pulang

Jumat:

< 10:00
Pulang Lebih Awal

>= 10:00
Pulang

Absensi pulang tidak ditutup setelah jam normal.

55. SP

Visual progress:

3 Alpha → SP1
6 Alpha → SP2
9 Alpha → SP3

Alpha akumulatif.

Contoh:

Alpha
4 / 6

███████░░░

Jangan menggunakan keterlambatan sebagai trigger SP pada prototype ini.

56. Google Drive

Google Drive belum terhubung pada tahap frontend.

Tampilkan hanya informasi visual:

File tersimpan
Nama: foto-absensi.jpg
Ukuran: 1.8 MB
Storage: Google Drive

Jangan membuat Google Drive API.

57. Login Prototype

Login harus terasa nyata tetapi tetap frontend-only.

Flow:

login.html
      ↓
validasi mock
      ↓
role detection
      ↓
Admin Dashboard / Pegawai Dashboard

Jika 3 kali salah:

Percobaan login telah mencapai batas maksimal.
Hubungi Admin untuk mereset password.

58. Admin vs Pegawai Visual

Admin

Karakter:

information dense;

tabel;

monitoring;

filter;

chart;

modal;

desktop-first.

Pegawai

Karakter:

task oriented;

mobile-first;

status hari ini;

tombol absensi besar;

aktivitas;

pengajuan;

indeks pribadi.

Jangan membuat dashboard Pegawai serumit Dashboard Admin.

59. Mobile Safe Area

Untuk mobile fixed bottom navigation:

Gunakan padding bawah tambahan:

pb-20

atau setara.

Pastikan content tidak tertutup bottom navigation.

60. Dark Mode

Tidak perlu membuat dark mode pada versi prototype ini.

Gunakan light theme sesuai referensi.

61. Logo

Jika logo resmi belum tersedia:

Gunakan placeholder berbentuk:

Logo

atau logo abstrak sederhana.

Jangan membuat logo instansi palsu yang seolah resmi.

Struktur harus mudah diganti dengan logo asli nanti.

62. Halaman yang Wajib Dibuat

Public

Login

Pegawai

Dashboard
Absensi
Riwayat Absensi
Rekap Bulanan
Laporan Kegiatan
Riwayat Kegiatan
Buat Pengajuan
Riwayat Pengajuan
Indeks Kedisiplinan
Detail Penilaian
Riwayat Pelanggaran
Peringatan & SP
Profil

Admin

Dashboard
Data Pegawai
Tambah/Edit Pegawai
Detail Pegawai
Monitoring Absensi
Riwayat Absensi
Rekap Bulanan
Monitoring Kegiatan
Semua Pengajuan
Izin
Sakit
Cuti
Perjalanan Dinas
Monitoring Kedisiplinan
Indeks Kedisiplinan
Ranking
Pelanggaran
Tren Kedisiplinan
SP Terpicu
Riwayat SP
Penerbitan SP
Laporan Absensi
Laporan Kedisiplinan
Laporan Kegiatan
Laporan SP
Audit Log
Pengaturan

63. Struktur Komponen

Buat komponen reusable:

components/
├── Sidebar
├── Header
├── MobileDrawer
├── BottomNavigation
├── PageHeader
├── Breadcrumb
├── StatCard
├── Card
├── Badge
├── Button
├── Input
├── Select
├── SearchBar
├── FilterBar
├── Table
├── Pagination
├── Modal
├── Toast
├── EmptyState
├── LoadingState
├── ErrorState
├── CameraModal
├── DocumentViewer
└── ChartCard

Jika memakai HTML static, buat versi template/partial yang mudah
dipindahkan ke Blade.

64. Struktur JavaScript

Pisahkan tanggung jawab:

assets/js/
├── app.js
├── mockData.js
├── auth.js
├── components.js
├── attendance.js
├── activities.js
├── requests.js
├── discipline.js
├── warnings.js
├── charts.js
└── utils.js

Jangan membuat seluruh aplikasi dalam satu file JavaScript besar.

65. LocalStorage

Boleh digunakan untuk mensimulasikan:

login session;

absensi;

foto mock;

status pengajuan;

penerbitan SP;

perubahan data pegawai.

Contoh:

localStorage.setItem("attendance", JSON.stringify(data));

Tidak boleh dianggap sebagai database final.

66. Print / Export Prototype

Tombol:

Export Excel
Export PDF
Print

boleh tersedia.

Namun karena belum ada backend, cukup:

tampilkan toast;

atau buat print view frontend.

Jangan membuat API.

67. UX Rules

Jangan

membuat tombol tanpa fungsi;

membuat link menuju halaman kosong;

menggunakan teks terlalu kecil;

membuat modal terlalu panjang;

membuat tabel sulit dibaca;

menyembunyikan label form;

menggunakan terlalu banyak warna;

menampilkan koordinat GPS pegawai;

membuat QR seolah menjadi validasi;

memberikan nilai kualitas/perilaku otomatis tanpa assessment.

Wajib

semua menu utama dapat dibuka;

semua form memiliki validasi;

semua modal dapat ditutup;

semua toast dapat muncul;

semua state memiliki feedback;

mobile dapat digunakan dengan nyaman.

68. Referensi Screenshot

Gunakan 9 file berikut sebagai acuan visual:

2026-08-27_22-43-21.png
2026-08-27_22-43-58.png
2026-08-27_22-45-35.png
2026-08-27_22-48-26.png
2026-08-27_22-49-26.png
2026-08-27_22-49-49.png
2026-08-27_22-50-21.png
2026-08-27_22-50-36.png
2026-08-27_22-51-00.png

Gunakan referensi terutama untuk:

sidebar;

dashboard;

data table;

filter;

modal;

settings;

form;

status badge;

spacing;

density;

visual hierarchy.

Jangan menyalin isi data pada screenshot. Data harus berasal dari
mock data sistem absensi.

69. Acceptance Criteria Visual

Frontend dianggap berhasil jika:

Desktop

Sidebar konsisten di seluruh halaman Admin.

Header konsisten.

Background content konsisten.

Card konsisten.

Tabel konsisten.

Modal konsisten.

Badge status konsisten.

Dashboard memiliki hierarchy yang jelas.

Mobile

Tidak ada horizontal overflow pada layout utama.

Sidebar berubah menjadi drawer.

Bottom navigation Pegawai tersedia.

Tombol absensi mudah ditekan.

Kamera nyaman digunakan.

Form menjadi single-column.

Tabel menjadi scroll/card.

Modal tidak keluar layar.

UX

Tidak ada halaman kosong.

Tidak ada dead link.

Tidak ada tombol utama tanpa feedback.

Error state tersedia.

Empty state tersedia.

Loading state tersedia.

Toast tersedia.

70. Final Direction untuk Developer / Antigravity

Prioritas tertinggi bukan menambahkan dekorasi, tetapi membuat sistem
terlihat seperti aplikasi instansi yang benar-benar siap dipakai.

Gunakan referensi screenshot sebagai visual benchmark.

Gunakan PRD sebagai functional benchmark.

Jika terjadi konflik:

PRD = sumber aturan sistem
DESIGN.md = sumber aturan visual

Jangan mengubah aturan bisnis hanya karena alasan desain.

Frontend harus:

Professional
Clean
Compact
Responsive
Accessible
Interactive
Consistent
Laravel-ready

Hasil akhir harus terasa sebagai satu produk yang utuh, bukan
kumpulan halaman HTML yang berdiri sendiri.

TAILWIND CLI ENFORCEMENT CHECKLIST

Bagian ini bersifat wajib dan menjadi acceptance criteria untuk implementasi oleh Antigravity.

Tailwind CSS menggunakan Tailwind CLI, bukan CDN.

Tidak ada cdn.tailwindcss.com di file HTML/JS.

Tidak ada @tailwindcss/browser di project.

Tidak ada script Tailwind Play CDN.

Tersedia dependency tailwindcss dan @tailwindcss/cli.

Tersedia CSS input lokal yang menggunakan @import "tailwindcss";.

Tersedia proses build/watch Tailwind CLI.

HTML mengarah ke CSS hasil build lokal.

UI tetap dapat dijalankan tanpa koneksi internet untuk memuat Tailwind CSS.

Struktur build tidak bergantung pada layanan CDN eksternal.

Konfigurasi ini harus dipertahankan ketika frontend nantinya dimigrasikan ke Laravel Blade.

Larangan absolut:

JANGAN:
<script src="https://cdn.tailwindcss.com"></script>

JANGAN:
<script src="https://cdn.tailwindcss.com"></script>

JANGAN:
@tailwindcss/browser

WAJIB:
Tailwind CSS → Tailwind CLI → output.css → HTML