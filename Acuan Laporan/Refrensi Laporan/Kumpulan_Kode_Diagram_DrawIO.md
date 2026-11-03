# KUMPULAN KODE DIAGRAM DAN FLOWCHART UNTUK DRAW.IO (MERMAID)

File ini memuat seluruh kode diagram yang ada pada Laporan Magang **SIP-PERFORMA**. Kode di bawah menggunakan format **Mermaid**, yaitu format diagram teks yang didukung secara resmi dan langsung oleh **draw.io** (app.diagrams.net).

---

## CARA MEMASUKKAN KODE KE DRAW.IO:
1. Buka browser dan kunjungi **[draw.io](https://app.diagrams.net)** (atau buka aplikasi desktop Draw.io).
2. Buat dokumen baru (*Create New Diagram* &rarr; *Blank Diagram*).
3. Di bilah menu atas, klik: **Arrange** &rarr; **Insert** &rarr; **Advanced** &rarr; **Mermaid**  
   *(Atau klik tanda **`+`** pada toolbar &rarr; **Advanced** &rarr; **Mermaid**)*.
4. Salin (*copy*) kode diagram yang diinginkan dari file ini, lalu tempel (*paste*) ke dalam kotak Mermaid yang muncul.
5. Klik tombol **Insert**.
6. Diagram akan langsung terbentang otomatis dalam bentuk kotak-kotak dan panah rapi yang dapat Anda geser, ubah warna, atau ekspor menjadi gambar (**File &rarr; Export as &rarr; PNG / JPEG**) untuk dimasukkan ke Microsoft Word!

---

## DAFTAR DIAGRAM

### 1. Gambar 1.1 Bagan Struktur Organisasi Disperindag Kota Gorontalo
```mermaid
graph TD
    KD["KEPALA DINAS"] --> SEK["SEKRETARIS DINAS"]
    
    SEK --> PROG["Subbagian Program"]
    SEK --> KEU["Subbagian Adm. Keuangan, Umum & Kepegawaian"]
    
    SEK --> BID1["Bidang Perdagangan"]
    SEK --> BID2["Bidang Perlindungan Konsumen & Kemetrologian"]
    SEK --> BID3["Bidang Perindustrian"]

    classDef chief fill:#0D2240,stroke:#0D2240,stroke-width:2px,color:#fff,font-weight:bold;
    classDef sec fill:#163660,stroke:#163660,stroke-width:2px,color:#fff,font-weight:bold;
    classDef sub fill:#F1F5F9,stroke:#64748B,stroke-width:1.5px,color:#0F172A;
    classDef bid fill:#E0F2FE,stroke:#0284C7,stroke-width:2px,color:#0369A1,font-weight:bold;

    class KD chief;
    class SEK sec;
    class PROG,KEU sub;
    class BID1,BID2,BID3 bid;
```

---

### 2. Gambar 2.3 Arsitektur Jaringan dan SI/TI Berjalan pada Disperindag
```mermaid
graph TD
    subgraph CLOUD["INTERNET PUBLIK / CLOUD"]
        SP2KP["Portal SP2KP Kemendag RI"]
        SIHALAL["Portal SIHALAL BPJPH Kemenag"]
        SIPD["Portal SIPD Kemendagri"]
    end

    CLOUD -->|Fiber Optic Diskominfotik| GW["Router / Gateway Utama Kantor"]
    
    GW --> AP["Access Point Wi-Fi Bidang"]
    GW --> SW["Switch Hub LAN Sekretariat"]

    AP -.-> HP1["Smartphone Pegawai 1<br/>(Kirim Foto Presensi WA)"]
    AP -.-> HP2["Smartphone Pegawai 2<br/>(Kirim Laporan WA)"]

    SW --> PC1["PC Staf Subbag<br/>(Unduh Gambar dari WA Web)"]
    SW --> PC2["PC Staf Kepegawaian<br/>(Ketik Ulang ke File Excel)"]

    classDef net fill:#F8FAFC,stroke:#334155,stroke-width:1.5px;
    classDef client fill:#FEF3C7,stroke:#D97706,stroke-width:1.5px,color:#78350F;
    classDef staff fill:#ECFDF5,stroke:#059669,stroke-width:1.5px,color:#064E3B;

    class GW,AP,SW net;
    class HP1,HP2 client;
    class PC1,PC2 staff;
```

---

### 3. Gambar 2.4 Cross-Functional Flowchart (CFF) Alur Presensi & Evaluasi Berjalan (Manual)
```mermaid
sequenceDiagram
    autonumber
    actor Pegawai as Pegawai P3K
    actor WA as Grup WhatsApp Disperindag
    actor Admin as Admin Kepegawaian
    actor Excel as File Microsoft Excel

    Pegawai->>Pegawai: Buka Kamera GPS (Geolokasi & Timestamp)
    Pegawai->>Pegawai: Ambil Foto Swafoto (Selfie)
    Pegawai->>WA: Kirim Foto Absen & Laporan ke Grup WA
    Admin->>WA: Buka WhatsApp Web & Unduh Foto Satu per Satu
    Admin->>Admin: Cek Jam & Koordinat secara Manual
    Admin->>Excel: Buka File Spreadsheet Excel Lokal
    Admin->>Excel: Ketik Ulang Jam Masuk, Pulang, dan Status
    Note over Admin,Excel: Akhir Periode Kontrak Tahunan
    Admin->>Excel: Rekapitulasi Manual Hari Kerja & Alpa
    Admin->>Admin: Hitung IKP Subjektif & Ketik Manual Draft SP
```

---

### 4. Gambar 3.1 Flowchart Proses Bisnis Usulan Sistem SIP-PERFORMA
```mermaid
flowchart TD
    START([Mulai]) --> LOGIN[Akses Web & Login Pegawai]
    LOGIN --> CHECK_TIME{Periksa Jam Dinas Masuk?}
    
    CHECK_TIME -- Tidak / Lewat Jam Masuk --> REJECT_TIME[Form Masuk Ditutup]
    REJECT_TIME --> END_FLOW([Selesai])

    CHECK_TIME -- Ya --> GPS_CAM[Deteksi Sensor GPS & Buka Kamera]
    GPS_CAM --> CHECK_RADIUS{Jarak Haversine <= 50 Meter?}
    
    CHECK_RADIUS -- Tidak --> REJECT_RAD[Tolak Absensi: Di Luar Radius]
    REJECT_RAD --> END_FLOW

    CHECK_RADIUS -- Ya --> SAVE_PRES[Simpan Presensi Datang Tepat Waktu/Terlambat]
    SAVE_PRES --> WORK_ACT[Input Laporan Kegiatan Harian & Foto]
    WORK_ACT --> AUTO_PROD[Sistem Hitung Skor Produktivitas Otomatis 0-100]
    
    AUTO_PROD --> ADM_REV[Admin Verifikasi Kegiatan & Beri Nilai Mutu A/B/C/D]
    
    SAVE_PRES -.-> DISP{Pegawai Perlu Izin/Sakit/Cuti/SPT?}
    DISP -- Ya --> APPLY_DISP[Pegawai Ajukan Permohonan & Upload Surat]
    APPLY_DISP --> ADM_DISP[Admin Review & Tetapkan Status Disetujui/Ditolak]
    ADM_DISP --> UPDATE_PRES[Presensi Otomatis Diperbarui: Sakit / Izin / Cuti]

    WORK_ACT --> PULANG[Absen Pulang: Validasi Radius & Foto]
    PULANG --> CALC_IKP[Sistem Rekapitulasi IKP Bulanan 60% Hadir + 25% Prod + 15% Kual]
    
    CALC_IKP --> CHECK_SP{Akumulasi Alpa >= 3 Hari?}
    CHECK_SP -- Ya --> GEN_SP[Sistem Buat Draf Surat Peringatan SP-1 / SP-2 / SP-3]
    GEN_SP --> ADM_PUB[Admin Isi Nomor Surat Resmi & Klik Terbitkan]
    ADM_PUB --> PRINT_PDF[Cetak Berkas PDF SP & Ekspor Laporan Excel]

    CHECK_SP -- Tidak --> PRINT_PDF
    PRINT_PDF --> END_FLOW
```

---

### 4B. Alternatif Gambar 3.1: Flowchart Lintas Fungsi 3 User / 3 Kolom (Swimlane)
*(Persis seperti format contoh: Kolom Pegawai P3K, Kolom Admin Kepegawaian, dan Kolom Pimpinan/Kepala Dinas)*

```mermaid
flowchart TD
    %% ==========================================
    %% KOLOM 1: PEGAWAI P3K
    %% ==========================================
    subgraph S1["1. Pegawai P3K"]
        P_START([Mulai])
        P_LOGIN[Halaman Login]
        P_INPUT_LOGIN[/Input NIP dan Password/]
        P_VALID_LOGIN{Kredensial<br/>Valid?}
        P_DASH[Halaman Dashboard Pegawai]
        P_PILIH{Pilih Jenis<br/>Aktivitas}
        
        %% Cabang Absensi
        P_CAM[Deteksi Sensor GPS & Kamera]
        P_VALID_RAD{Jarak <= 50m<br/>& Jam Sesuai?}
        P_TOLAK_RAD[Notifikasi di Luar Radius]
        P_DB_PRES[(Database<br/>Presensi)]
        
        %% Cabang Kegiatan
        P_INPUT_KEG[/Input Rincian Kegiatan & Foto/]
        P_AUTO_PROD[Hitung Skor Produktivitas Otomatis]
        P_DB_KEG[(Database<br/>Kegiatan)]
        P_NOTIF_KEG[Kirim Notifikasi Laporan ke Admin]
        
        %% Cabang Dispensasi
        P_INPUT_IZIN[/Input Izin / Sakit / Cuti & Upload Berkas/]
        P_DB_IZIN[(Database<br/>Pengajuan)]
        P_NOTIF_IZIN[Kirim Notifikasi Pengajuan ke Admin]

        P_LIHAT_IKP[Melihat Rekap IKP & Berkas SP Pribadi]
        P_END([Selesai])
    end

    %% ==========================================
    %% KOLOM 2: ADMIN KEPEGAWAIAN
    %% ==========================================
    subgraph S2["2. Admin Kepegawaian"]
        A_DASH[Halaman Dashboard Admin]
        
        %% Verifikasi Kegiatan
        A_VERIF_KEG{Verifikasi<br/>Kegiatan?}
        A_NILAI_MUTU[/Input Nilai Mutu A / B / C / D/]
        A_STATUS_KEG[(Status Verifikasi<br/>Disetujui)]
        
        %% Persetujuan Pengajuan
        A_REVIEW_IZIN{Tinjau Bukti<br/>Surat / SPT?}
        A_STATUS_IZIN[(Status Disetujui<br/>/ Ditolak)]
        A_SYNC_PRES[Sinkronisasi Presensi: Sakit / Izin / Cuti]
        
        %% Evaluasi IKP & SP
        A_REKAP_IKP[Kalkulasi IKP: Hadir 60% + Prod 25% + Kual 15%]
        A_DB_IKP[(Database<br/>Skor Kinerja)]
        A_CHECK_ALPA{Akumulasi<br/>Alpa >= 3 Hari?}
        A_GEN_SP[Sistem Generate Draf Otomatis SP-1 / SP-2 / SP-3]
        A_INPUT_SP[/Input Nomor Surat Resmi/]
        A_DB_SP[(Database<br/>Surat Peringatan)]
        A_NOTIF_PIM[Kirim Rekap IKP & Draf SP ke Pimpinan]
    end

    %% ==========================================
    %% KOLOM 3: PIMPINAN (KEPALA DINAS)
    %% ==========================================
    subgraph S3["3. Pimpinan (Kepala Dinas / Sekretaris)"]
        L_DASH[Halaman Dashboard Pimpinan]
        L_REVIEW_IKP[Tinjau Evaluasi Kinerja Bulanan SKPD]
        L_EVAL_KONTRAK{Evaluasi<br/>Perpanjangan<br/>Kontrak?}
        L_STATUS_KONTRAK[(Rekomendasi<br/>Kontrak Kerja)]
        L_SIGN_SP[Pengesahan & Tanda Tangan Dokumen Surat Peringatan]
        L_SELESAI([Selesai])
    end

    %% ==========================================
    %% HUBUNGAN & ALIRAN DATA ANTAR ELEMEN
    %% ==========================================
    P_START --> P_LOGIN
    P_LOGIN --> P_INPUT_LOGIN
    P_INPUT_LOGIN --> P_VALID_LOGIN
    P_VALID_LOGIN -- no --> P_INPUT_LOGIN
    P_VALID_LOGIN -- yes --> P_DASH
    P_DASH --> P_PILIH
    
    %% Alur Presensi
    P_PILIH --> P_CAM
    P_CAM --> P_VALID_RAD
    P_VALID_RAD -- no --> P_TOLAK_RAD
    P_TOLAK_RAD --> P_END
    P_VALID_RAD -- yes --> P_DB_PRES
    
    %% Alur Kegiatan
    P_PILIH --> P_INPUT_KEG
    P_INPUT_KEG --> P_AUTO_PROD
    P_AUTO_PROD --> P_DB_KEG
    P_DB_KEG --> P_NOTIF_KEG
    P_NOTIF_KEG --> A_DASH
    A_DASH --> A_VERIF_KEG
    A_VERIF_KEG -- no --> P_INPUT_KEG
    A_VERIF_KEG -- yes --> A_NILAI_MUTU
    A_NILAI_MUTU --> A_STATUS_KEG
    A_STATUS_KEG --> A_REKAP_IKP
    
    %% Alur Dispensasi
    P_PILIH --> P_INPUT_IZIN
    P_INPUT_IZIN --> P_DB_IZIN
    P_DB_IZIN --> P_NOTIF_IZIN
    P_NOTIF_IZIN --> A_DASH
    A_DASH --> A_REVIEW_IZIN
    A_REVIEW_IZIN -- no --> A_STATUS_IZIN
    A_REVIEW_IZIN -- yes --> A_SYNC_PRES
    A_SYNC_PRES --> A_STATUS_IZIN
    A_STATUS_IZIN --> P_DB_PRES
    
    %% Alur IKP & SP
    P_DB_PRES --> A_REKAP_IKP
    A_REKAP_IKP --> A_DB_IKP
    A_DB_IKP --> A_CHECK_ALPA
    A_CHECK_ALPA -- no --> A_NOTIF_PIM
    A_CHECK_ALPA -- yes --> A_GEN_SP
    A_GEN_SP --> A_INPUT_SP
    A_INPUT_SP --> A_DB_SP
    A_DB_SP --> A_NOTIF_PIM
    
    %% Alur ke Pimpinan
    A_NOTIF_PIM --> L_DASH
    L_DASH --> L_REVIEW_IKP
    L_REVIEW_IKP --> L_EVAL_KONTRAK
    L_EVAL_KONTRAK --> L_STATUS_KONTRAK
    L_STATUS_KONTRAK --> L_SIGN_SP
    L_SIGN_SP --> P_LIHAT_IKP
    L_SIGN_SP --> L_SELESAI
    P_LIHAT_IKP --> P_END

---

### 5. Gambar 3.2 Diagram Konteks Sistem SIP-PERFORMA
```mermaid
flowchart TD
    ADM["ADMINISTRATOR<br/>(Subbag Kepegawaian)"]
    PEG["PEGAWAI P3K<br/>(Aparatur Dinas)"]
    SYS(("SISTEM INFORMASI<br/>SIP-PERFORMA<br/>(PROSES 0)"))
    PIM["PIMPINAN<br/>(Kepala Dinas)"]

    %% Interaksi Pegawai
    PEG -- "1. Koordinat GPS & Swafoto Masuk/Pulang<br/>2. Laporan Kegiatan & Foto Bukti<br/>3. Permohonan Izin / Sakit / Cuti / SPT" --> SYS
    SYS -- "1. Status Validasi Radius & Presensi<br/>2. Rincian Skor Kinerja (IKP) Mandiri<br/>3. Berkas Surat Peringatan (PDF)" --> PEG

    %% Interaksi Admin
    ADM -- "1. Data Master Pegawai & Akun<br/>2. Verifikasi & Nilai Mutu Kegiatan<br/>3. Persetujuan Dispensasi (Izin/Sakit/Cuti)<br/>4. Nomor & Penerbitan SP<br/>5. Parameter Lokasi, Jam & Bobot IKP" --> SYS
    SYS -- "1. Rekapitulasi Presensi Seluruh Pegawai<br/>2. Peringatan Draf SP Otomatis<br/>3. Berkas Laporan Excel & PDF" --> ADM

    %% Interaksi Pimpinan
    SYS -- "1. Laporan Eksekutif Disiplin Bulanan<br/>2. Rekomendasi Kelayakan Kontrak Kerja" --> PIM

    classDef user fill:#E0F2FE,stroke:#0284C7,stroke-width:2px,color:#0369A1,font-weight:bold;
    classDef sys fill:#0D2240,stroke:#0D2240,stroke-width:2.5px,color:#FFFFFF,font-weight:bold;
    class ADM,PEG,PIM user;
    class SYS sys;
```

---

### 6. Gambar 3.3 Hierarchy Chart (Dekomposisi Fungsional Sistem)
```mermaid
graph TD
    ROOT["0.0 SISTEM INFORMASI SIP-PERFORMA"]
    
    ROOT --> M1["1.0 Modul Data & Pengguna"]
    ROOT --> M2["2.0 Modul Presensi & Dispensasi"]
    ROOT --> M3["3.0 Modul Kegiatan Harian"]
    ROOT --> M4["4.0 Modul Evaluasi & Pelaporan"]

    M1 --> M11["1.1 Kelola Master Data Pegawai"]
    M1 --> M12["1.2 Kelola Akun & Reset Password"]
    M1 --> M13["1.3 Pengaturan Parameter Kantor"]

    M2 --> M21["2.1 Absensi Datang & Pulang Geofence"]
    M2 --> M22["2.2 Riwayat Presensi Pegawai"]
    M2 --> M23["2.3 Pengajuan Izin, Cuti, Sakit, Dinas"]
    M2 --> M24["2.4 Persetujuan Dispensasi Admin"]

    M3 --> M31["3.1 Input Laporan Kegiatan & Foto"]
    M3 --> M32["3.2 Hitung Skor Produktivitas Otomatis"]
    M3 --> M33["3.3 Verifikasi & Penilaian Mutu Atasan"]

    M4 --> M41["4.1 Kalkulasi Indeks Kinerja Pegawai (IKP)"]
    M4 --> M42["4.2 Deteksi Ambang & Draf SP Otomatis"]
    M4 --> M43["4.3 Penerbitan & Cetak PDF SP"]
    M4 --> M44["4.4 Ekspor Rekapitulasi Excel & PDF"]

    classDef main fill:#0D2240,stroke:#0D2240,color:#fff,font-weight:bold;
    classDef mod fill:#1E40AF,stroke:#1E40AF,color:#fff,font-weight:bold;
    classDef sub fill:#F8FAFC,stroke:#64748B,color:#0F172A;

    class ROOT main;
    class M1,M2,M3,M4 mod;
    class M11,M12,M13,M21,M22,M23,M24,M31,M32,M33,M41,M42,M43,M44 sub;
```

---

### 7. Gambar 3.4 Data Flow Diagram (DFD) Level 0
```mermaid
flowchart TD
    PEG["PEGAWAI P3K"]
    ADM["ADMINISTRATOR"]
    
    P1["1.0 MANAJEMEN PRESENSI"]
    P2["2.0 MANAJEMEN KEGIATAN"]
    P3["3.0 PENGAJUAN & DISPENSASI"]
    P4["4.0 EVALUASI IKP & SP AUTO"]

    D1[("D1: pegawai")]
    D2[("D2: pengguna")]
    D3[("D3: presensi")]
    D4[("D4: laporan_kegiatan")]
    D5[("D5: pengajuan_izin")]
    D6[("D6: skor_kinerja")]
    D7[("D7: surat_peringatan")]
    D8[("D8: pengaturan_kantor")]

    PEG -->|Kirim Koordinat & Foto| P1
    P1 -->|Catat Jam & Status| D3
    D3 -->|Riwayat Presensi| PEG
    D8 -->|Aturan Radius & Jam| P1

    PEG -->|Input Laporan & Bukti| P2
    P2 -->|Simpan Laporan & Skor Prod| D4
    ADM -->|Verifikasi Mutu A/B/C/D| P2

    PEG -->|Form Izin / Sakit / Cuti| P3
    P3 -->|Simpan Pengajuan| D5
    ADM -->|Keputusan Disetujui / Tolak| P3
    P3 -->|Update Status Presensi| D3

    D3 -->|Data Kehadiran & Alpa| P4
    D4 -->|Nilai Kualitas & Prod| P4
    D8 -->|Bobot IKP & Ambang SP| P4
    P4 -->|Simpan Rekap IKP| D6
    P4 -->|Buat Draf SP Otomatis| D7
    ADM -->|Nomor Surat & Terbitkan SP| P4
    P4 -->|Ekspor Excel / PDF| ADM

    classDef p fill:#0D2240,stroke:#0D2240,color:#fff,font-weight:bold;
    classDef d fill:#FEF3C7,stroke:#D97706,color:#78350F;
    class P1,P2,P3,P4 p;
    class D1,D2,D3,D4,D5,D6,D7,D8 d;
```

---

### 8. Gambar 3.5 DFD Level 1 Proses 1.0 (Manajemen Presensi)
```mermaid
flowchart TD
    PEG["PEGAWAI P3K"]
    ADM["ADMINISTRATOR"]
    D8[("D8: pengaturan_kantor")]
    D3[("D3: presensi")]

    P11["1.1 Validasi Geofence & Jam Kerja"]
    P12["1.2 Simpan Presensi Masuk / Pulang"]
    P13["1.3 Monitoring Presensi Admin"]

    PEG -->|Koordinat GPS & Kamera| P11
    D8 -->|Radius & Batas Jam| P11
    P11 -->|Lolos Validasi| P12
    P12 -->|Tulis Record Absensi| D3
    D3 -->|Riwayat Presensi Pribadi| PEG
    D3 -->|Tabel Absensi Harian| P13
    P13 -->|Tampilan Real-Time| ADM
```

---

### 9. Gambar 3.6 DFD Level 1 Proses 2.0 (Manajemen Laporan Kegiatan)
```mermaid
flowchart TD
    PEG["PEGAWAI P3K"]
    ADM["ADMINISTRATOR"]
    D4[("D4: laporan_kegiatan")]

    P21["2.1 Kalkulasi Produktivitas Otomatis"]
    P22["2.2 Verifikasi Kualitas Atasan"]

    PEG -->|Judul, Tanggal, Deskripsi, Foto| P21
    P21 -->|Simpan Laporan: Menunggu Review| D4
    D4 -->|Daftar Laporan Masuk| P22
    ADM -->|Nilai Mutu A/B/C/D & Catatan| P22
    P22 -->|Update: Disetujui & Nilai Kualitas| D4
    D4 -->|Status & Umpan Balik Mutu| PEG
```

---

### 10. Gambar 3.7 DFD Level 1 Proses 3.0 (Manajemen Pengajuan & Dispensasi)
```mermaid
flowchart TD
    PEG["PEGAWAI P3K"]
    ADM["ADMINISTRATOR"]
    D5[("D5: pengajuan_izin")]
    D3[("D3: presensi")]

    P31["3.1 Pengisian Formulir Dispensasi"]
    P32["3.2 Peninjauan Berkas Pengajuan"]
    P33["3.3 Sinkronisasi Status Presensi"]

    PEG -->|Pilih Izin/Sakit/Cuti & Bukti Surat| P31
    P31 -->|Simpan Permohonan Status Review| D5
    D5 -->|Daftar Permohonan Pending| P32
    ADM -->|Putusan: Setujui / Tolak| P32
    P32 -->|Update Status Pengajuan| D5
    P32 -->|Kirim Perintah Update| P33
    P33 -->|Tulis Status: Sakit/Izin/Cuti/Dinas| D3
    D3 -->|Badge Status di Riwayat Absen| PEG
```

---

### 11. Gambar 3.8 DFD Level 1 Proses 4.0 (Perhitungan Kinerja & Penerbitan SP)
```mermaid
flowchart TD
    D3[("D3: presensi")]
    D4[("D4: laporan_kegiatan")]
    D8[("D8: pengaturan_kantor")]
    D6[("D6: skor_kinerja")]
    D7[("D7: surat_peringatan")]
    ADM["ADMINISTRATOR"]
    PEG["PEGAWAI P3K"]

    P41["4.1 Hitung Indeks Kinerja Pegawai (IKP)"]
    P42["4.2 Deteksi Alpa & Buat Draf SP"]
    P43["4.3 Penerbitan Resmi & Cetak PDF"]

    D3 -->|Total Alpa & Terlambat| P41
    D4 -->|Rata-rata Prod & Kualitas| P41
    D8 -->|Bobot: 60/25/15| P41
    P41 -->|Simpan Skor IKP Bulanan| D6

    D3 -->|Hitung Akumulasi Alpa| P42
    D8 -->|Ambang: 3, 6, 9 Hari| P42
    P42 -->|Simpan Draf SP-1/SP-2/SP-3| D7

    D7 -->|Draf SP Tanpa Nomor| P43
    ADM -->|Input Nomor Surat Resmi| P43
    P43 -->|Update: Aktif & No Surat| D7
    P43 -->|Cetak Berkas PDF Resmi| ADM
    P43 -->|Unduh Berkas SP Terbit| PEG
```

---

### 12. Gambar 3.9 Entity Relationship Diagram (ERD) Sistem SIP-PERFORMA
```mermaid
erDiagram
    PEGAWAI ||--o| PENGGUNA : "memiliki akun"
    PEGAWAI ||--o{ PRESENSI : "merekam"
    PEGAWAI ||--o{ LAPORAN_KEGIATAN : "melaporkan"
    PEGAWAI ||--o{ PENGAJUAN_IZIN : "mengajukan"
    PEGAWAI ||--o{ SKOR_KINERJA : "dihitung"
    PEGAWAI ||--o{ SURAT_PERINGATAN : "dikenakan"

    PEGAWAI {
        bigint id PK
        string nip UK
        string nama
        string no_hp
        string jabatan
        enum bidang
        text alamat
        string foto
        enum status
    }

    PENGGUNA {
        bigint id PK
        bigint pegawai_id FK
        string nama
        string username UK
        string email UK
        string password
        enum peran
        enum status
    }

    PRESENSI {
        bigint id PK
        bigint pegawai_id FK
        date tanggal
        time jam_masuk
        enum status_masuk
        decimal jarak_masuk
        string foto_masuk
        time jam_pulang
        enum status_pulang
        decimal jarak_pulang
        string foto_pulang
        enum status
    }

    LAPORAN_KEGIATAN {
        bigint id PK
        bigint pegawai_id FK
        date tanggal
        string nama_kegiatan
        text deskripsi
        string foto
        time waktu_kirim
        decimal nilai_produktivitas
        string kategori_produktivitas
        decimal nilai_kualitas
        string kategori_kualitas
        text catatan_kualitas
        enum status_verifikasi
    }

    PENGAJUAN_IZIN {
        bigint id PK
        bigint pegawai_id FK
        enum jenis
        date tanggal_mulai
        date tanggal_selesai
        text alasan
        string dokumen
        enum status
        text catatan_admin
        timestamp tanggal_disetujui
    }

    SKOR_KINERJA {
        bigint id PK
        bigint pegawai_id FK
        string periode
        decimal nilai_kehadiran
        decimal nilai_produktivitas
        decimal nilai_kualitas
        decimal bobot_kehadiran
        decimal bobot_produktivitas
        decimal bobot_kualitas
        decimal nilai_akhir
        enum kategori
        enum status
        enum rekomendasi_kontrak
    }

    SURAT_PERINGATAN {
        bigint id PK
        bigint pegawai_id FK
        enum tingkat_sp
        int jumlah_alpha
        string nomor_surat
        date tanggal_terbit
        string dokumen
        enum status
    }

    PENGATURAN_KANTOR {
        bigint id PK
        string nama_skpd
        string titik_koordinat
        int radius_absensi_meter
        time jam_masuk
        time batas_terlambat
        time batas_akhir_masuk
        time jam_pulang
        decimal bobot_kehadiran
        decimal bobot_produktivitas
        decimal bobot_kualitas
        int ambang_sp1
        int ambang_sp2
        int ambang_sp3
        boolean is_wfh_jumat
    }
```

---

### 13. Gambar 3.10 Arsitektur Software Model-View-Controller (MVC) Laravel
```mermaid
graph TD
    CLIENT["Client Web Browser<br/>(Desktop / Smartphone)<br/>HTML5 + Tailwind CSS + Vanilla JS"]
    
    CLIENT -->|HTTP Request / Session / CSRF| ROUTE["Router: routes/web.php"]
    ROUTE --> MID["Middleware Layer<br/>(Auth & Role: admin | pegawai)"]
    
    MID --> CTRL["Controller Layer<br/>(Admin*Controller & Pegawai*Controller)"]

    CTRL -->|Query & Simpan Data| MODEL["Model Layer (Eloquent ORM)<br/>(Pegawai, Presensi, SkorKinerja, SP)"]
    MODEL -->|SQL Query / Transaction| DB[(Database MySQL 8.0)]
    DB -->|Result Set| MODEL

    CTRL -->|Kirim Data Variabel| VIEW["View Layer (Blade Template Engine)<br/>Chart.js Radar/Line + SweetAlert2"]
    VIEW -->|Render HTML Response| CLIENT

    CTRL -.->|Export File Generator| EXPORT["Laravel-DomPDF (.pdf)<br/>Maatwebsite Excel (.xlsx)"]
    EXPORT -.->|Unduh Berkas| CLIENT

    classDef cl fill:#E0F2FE,stroke:#0284C7,stroke-width:2px,color:#0369A1;
    classDef srv fill:#0D2240,stroke:#0D2240,stroke-width:2px,color:#fff;
    classDef dt fill:#FEF3C7,stroke:#D97706,stroke-width:2px,color:#78350F;

    class CLIENT cl;
    class ROUTE,MID,CTRL,VIEW,EXPORT srv;
    class MODEL,DB dt;
```
