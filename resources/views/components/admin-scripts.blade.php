<script>
    // Tab Switcher Dinamis
    function switchAdminTab(targetSectionId) {
        // Karena sekarang kita pakai route terpisah, script ini mungkin tidak lagi digunakan untuk memindah section,
        // Tapi kita biarkan logic chart render dll untuk kompatibilitas jika dipanggil.
        if (targetSectionId === 'sec-kinerja') {
            setTimeout(renderAdminCharts, 60);
        }
        if (targetSectionId === 'sec-kegiatan') {
            setTimeout(renderKegiatanCharts, 60);
        }
    }

    // Inisialisasi Chart.js untuk Admin
    let adminRadarInstance = null;
    let adminTrenInstance = null;

    function renderAdminCharts() {
        if (typeof Chart === 'undefined') return;

        // 1. Radar Chart 3 Indikator (IKP 50/30/20)
        const ctxRadar = document.getElementById('chartAdminRadarKinerja');
        if (ctxRadar) {
            if (adminRadarInstance) adminRadarInstance.destroy();
            adminRadarInstance = new Chart(ctxRadar.getContext('2d'), {
                type: 'radar',
                data: {
                    labels: ['Kehadiran (60%)', 'Produktivitas (25%)', 'Kualitas (15%)'],
                    datasets: [{
                        label: 'Rata-Rata Capaian SKPD',
                        data: [88, 92, 85],
                        backgroundColor: 'rgba(13, 34, 64, 0.2)',
                        borderColor: '#0D2240',
                        borderWidth: 2.5,
                        pointBackgroundColor: '#0D2240',
                        pointBorderColor: '#FFFFFF',
                        pointRadius: 4
                    }, {
                        label: 'Standar Minimal Target',
                        data: [80, 80, 80],
                        backgroundColor: 'rgba(239, 68, 68, 0.05)',
                        borderColor: '#EF4444',
                        borderWidth: 1.5,
                        borderDash: [4, 4],
                        pointRadius: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        r: {
                            min: 50,
                            max: 100,
                            ticks: { stepSize: 10, font: { size: 10 } },
                            pointLabels: { font: { size: 11, weight: 'bold' } }
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: { font: { size: 11 }, boxWidth: 12 }
                        }
                    }
                }
            });
        }

        // 2. Line Chart Tren 6 Bulan
        const ctxTren = document.getElementById('chartAdminTrenKinerja');
        if (ctxTren) {
            if (adminTrenInstance) adminTrenInstance.destroy();
            adminTrenInstance = new Chart(ctxTren.getContext('2d'), {
                type: 'line',
                data: {
                    labels: ['Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep'],
                    datasets: [{
                        label: 'Indeks Rata-Rata SKPD',
                        data: [82.5, 84.1, 85.0, 86.2, 87.1, 87.5],
                        borderColor: '#0D2240',
                        backgroundColor: 'rgba(13, 34, 64, 0.08)',
                        borderWidth: 2.5,
                        fill: true,
                        tension: 0.35,
                        pointBackgroundColor: '#0D2240',
                        pointBorderColor: '#FFFFFF',
                        pointBorderWidth: 2,
                        pointRadius: 5
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            min: 70,
                            max: 100,
                            grid: { color: '#F1F5F9' },
                            ticks: { font: { size: 11 } }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { font: { size: 11 } }
                        }
                    }
                }
            });
        }
    }

    // Inisialisasi Chart.js untuk Laporan Kegiatan
    let kegiatanBidangInstance = null;
    let kegiatanTrenInstance = null;

    function renderKegiatanCharts() {
        if (typeof Chart === 'undefined') return;

        // 1. Bar Chart: Laporan Per Bidang
        const ctxBidang = document.getElementById('chartLaporanBidang');
        if (ctxBidang) {
            if (kegiatanBidangInstance) kegiatanBidangInstance.destroy();
            
            let dataMasuk = [35, 42, 28, 31];
            let dataTerverifikasi = [32, 39, 26, 29];
            if (window.chartDataKegiatan) {
                dataMasuk = window.chartDataKegiatan.bidangMasuk;
                dataTerverifikasi = window.chartDataKegiatan.bidangTerverifikasi;
            }
            
            kegiatanBidangInstance = new Chart(ctxBidang.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: ['Perindustrian', 'Perdagangan', 'Sekretariat', 'Perlindungan Konsumen'],
                    datasets: [
                        {
                            label: 'Laporan Masuk',
                            data: dataMasuk,
                            backgroundColor: '#0D2240',
                            borderRadius: 6,
                            barPercentage: 0.55
                        },
                        {
                            label: 'Terverifikasi',
                            data: dataTerverifikasi,
                            backgroundColor: '#10B981',
                            borderRadius: 6,
                            barPercentage: 0.55
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: { font: { size: 11, weight: 'bold' }, boxWidth: 12, padding: 14 }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: '#F1F5F9' },
                            ticks: { stepSize: 10, font: { size: 10 } }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { font: { size: 10, weight: '600' } }
                        }
                    }
                }
            });
        }

        // 2. Line Chart: Tren Pengumpulan Harian (7 Hari Terakhir)
        const ctxTren = document.getElementById('chartLaporanTren');
        if (ctxTren) {
            if (kegiatanTrenInstance) kegiatanTrenInstance.destroy();
            
            let trenLabels = ['01 Sep', '02 Sep', '03 Sep', '04 Sep', '05 Sep', '06 Sep', '07 Sep'];
            let trenData = [18, 22, 25, 20, 28, 24, 31];
            if (window.chartDataKegiatan) {
                trenLabels = window.chartDataKegiatan.trenLabels;
                trenData = window.chartDataKegiatan.trenData;
            }
            
            kegiatanTrenInstance = new Chart(ctxTren.getContext('2d'), {
                type: 'line',
                data: {
                    labels: trenLabels,
                    datasets: [{
                        label: 'Volume Laporan',
                        data: trenData,
                        borderColor: '#0284C7',
                        backgroundColor: 'rgba(2, 132, 199, 0.1)',
                        borderWidth: 2.5,
                        fill: true,
                        tension: 0.35,
                        pointBackgroundColor: '#0284C7',
                        pointBorderColor: '#FFFFFF',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: '#F1F5F9' },
                            ticks: { stepSize: 10, font: { size: 10 } }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { font: { size: 10 } }
                        }
                    }
                }
            });
        }
    }

    // Panggil render chart saat DOM loaded
    document.addEventListener('DOMContentLoaded', () => {
        setTimeout(() => {
            renderAdminCharts();
            renderKegiatanCharts();
        }, 100);
    });

    // Fungsi Buka & Tutup Modal
    function openModal(id) {
        const el = document.getElementById(id);
        if (el) el.classList.remove('hidden');
    }

    function closeModal(id) {
        const el = document.getElementById(id);
        if (el) el.classList.add('hidden');
    }

    function openTambahPegawaiModal() {
        openModal('modalTambahPegawai');
    }

    window.openDetailPegawaiModal = function (nama, id, nip, jabatan, bidang, email, status, noHp, alamat) {
        const setSafe = (elemId, text) => {
            const el = document.getElementById(elemId);
            if (el) el.textContent = (text !== undefined && text !== null && text !== '') ? text : '-';
        };
        setSafe('detailNama', nama);
        setSafe('detailId', nip || id);
        setSafe('detailNip', nip || id);
        setSafe('detailJabatan', jabatan);
        setSafe('detailBidang', bidang);
        setSafe('detailEmail', email);
        setSafe('detailStatus', status || 'Aktif');
        setSafe('detailNoHp', noHp);
        setSafe('detailAlamat', alamat);
        setSafe('detailIndeks', status);

        const statusEl = document.getElementById('detailStatus');
        if (statusEl) {
            if (status === 'Cuti') {
                statusEl.className = 'font-bold text-amber-700';
            } else {
                statusEl.className = 'font-bold text-emerald-700';
            }
        }

        const avatarEl = document.getElementById('detailAvatar');
        if (avatarEl) {
            if (nama && typeof nama === 'string') {
                const parts = nama.trim().split(/\s+/).filter(Boolean);
                const initials = parts.slice(0, 2).map(n => n[0]).join('').toUpperCase();
                avatarEl.textContent = initials || 'PG';
            } else {
                avatarEl.textContent = 'PG';
            }
        }
        openModal('modalDetailPegawai');
    };

    function openBuktiFotoModal(nama, jam, jarak, status, fotoUrl) {
        document.getElementById('fotoModalNama').textContent = nama;
        document.getElementById('fotoModalJam').textContent = jam;
        document.getElementById('fotoModalJarak').textContent = `${jarak} (Maks 50m)`;
        document.getElementById('fotoModalStatus').textContent = status;
        document.getElementById('fotoModalImage').src = fotoUrl;
        openModal('modalBuktiFoto');
    }

    function openFotoLaporanModal(nama, kegiatan, fotoUrl) {
        document.getElementById('fotoLaporanModalNama').textContent = nama;
        document.getElementById('fotoLaporanModalKegiatan').textContent = kegiatan;
        document.getElementById('fotoLaporanModalImage').src = fotoUrl;
        openModal('modalFotoLaporan');
    }

    // Database Lampiran Dokumen Pengajuan Pegawai
    const lampiranDatabase = {
        'Andi Saputra': {
            tipe: 'sk_cuti',
            jenis: 'SK Cuti Tahunan',
            badge: 'SK Cuti Sah',
            judulDokumen: 'SURAT KEPUTUSAN PEMBERIAN CUTI TAHUNAN',
            nomorSurat: '800/DISPERDAGIN/SK-CUTI/041/IX/2026',
            pegawai: 'Andi Saputra',
            nip: '19880314 201101 1 002',
            pangkat: 'Penata Muda / III/a',
            jabatan: 'Analis Perdagangan Ahli Pertama',
            bidang: 'Perdagangan',
            tanggal: '10 – 12 September 2026 (3 Hari Kerja)',
            alasan: 'Keperluan keluarga mendesak dan urusan pribadi tahunan di luar daerah.',
            dasar: 'Surat Permohonan Cuti Tahunan Pegawai tertanggal 05 September 2026 dan Peraturan Pemerintah Nomor 11 Tahun 2017 tentang Manajemen Pegawai Negeri Sipil / PPPK.',
            pernyataan: 'MEMBERIKAN IZIN CUTI TAHUNAN KEPADA:',
            lokasi: '-',
            ketentuan: 'Selama menjalankan cuti tahunan, hak penghasilan tetap diberikan sesuai perundang-undangan dan setelah berakhirnya masa cuti ini pegawai wajib aktif kembali bertugas.',
            tanggalPengesahan: 'Pada tanggal 08 September 2026',
            penandatangan: 'Drs. H. M. Dahlan, M.Si',
            nipPenandatangan: '19680512 199403 1 005',
            jabatanPenandatangan: 'Kepala Dinas Perdagangan dan Perindustrian Kota Gorontalo',
            namaFile: 'SK_Cuti_Tahunan_Andi_Saputra.pdf',
            ukuranFile: '245 KB'
        },
        'Rani Ayu Pratiwi': {
            tipe: 'spt_dinas',
            jenis: 'Surat Perintah Tugas (SPT)',
            badge: 'SPT Penugasan Sah',
            judulDokumen: 'SURAT PERINTAH TUGAS (SPT)',
            nomorSurat: '090/DISPERDAGIN/SPT-DL/218/VIII/2026',
            pegawai: 'Rani Ayu Pratiwi',
            nip: '19950620 202203 2 007',
            pangkat: 'Pengatur / II/c',
            jabatan: 'Staf PPPK / Petugas Pemantau Pasar',
            bidang: 'Perdagangan',
            tanggal: '19 Agustus 2026 (1 Hari Penuh - 08:00 s/d 17:00 WITA)',
            alasan: 'Melaksanakan monitoring ketersediaan dan kestabilan harga komoditas pangan pokok beras, gula, dan minyak goreng.',
            dasar: 'Instruksi Walikota Gorontalo Nomor 04 Tahun 2026 tentang Pengendalian Inflasi Daerah (TPID) dan Surat Tugas Kepala DISPERDAGIN Kota Gorontalo.',
            pernyataan: 'MEMERINTAHKAN KEPADA:',
            lokasi: 'Pasar Sentral & Pasar Sentuh Kota Gorontalo',
            ketentuan: 'Setelah melaksanakan perintah penugasan ini, yang bersangkutan wajib membuat dan menyerahkan laporan hasil pelaksanaan tugas kepada atasan langsung.',
            tanggalPengesahan: 'Pada tanggal 18 Agustus 2026',
            penandatangan: 'Drs. H. M. Dahlan, M.Si',
            nipPenandatangan: '19680512 199403 1 005',
            jabatanPenandatangan: 'Kepala Dinas Perdagangan dan Perindustrian Kota Gorontalo',
            namaFile: 'SPT_Dinas_Luar_Rani_Ayu.pdf',
            ukuranFile: '318 KB'
        },
        'Siti Rahmawati': {
            tipe: 'surat_sakit',
            jenis: 'Surat Keterangan Sakit Dokter',
            badge: 'Keterangan Medis',
            judulDokumen: 'SURAT KETERANGAN PEMERIKSAAN MEDIS',
            nomorSurat: '445/RSUD-AS/SKD/IX/2026/892',
            pegawai: 'Siti Rahmawati',
            nip: '19920411 201903 2 004',
            pangkat: 'Penata Muda / III/a',
            jabatan: 'Pengelola Pengadaan Barang/Jasa',
            bidang: 'Sekretariat',
            tanggal: '15 – 16 September 2026 (2 Hari Istirahat Medis)',
            alasan: 'Pasien didiagnosis Febris Observasi (Gejala Demam & Flu Berat) dan memerlukan istirahat tirah baring selama 2 hari kerja.',
            dasar: 'Surat Keterangan Pemeriksaan Kesehatan dari Fasilitas Pelayanan Kesehatan RSUD Prof. Dr. H. Aloei Saboe Kota Gorontalo.',
            pernyataan: 'MENERANGKAN DENGAN SEBENARNYA BAHWA:',
            lokasi: 'Poliklinik Rawat Jalan RSUD Aloei Saboe',
            ketentuan: 'Surat keterangan ini diberikan sebagai bukti pendukung resmi permohonan dispensasi izin sakit pegawai.',
            tanggalPengesahan: 'Pada tanggal 15 September 2026',
            penandatangan: 'dr. Hendra Pratama, Sp.PD',
            nipPenandatangan: 'SIP. 503/SIP-DOK/DINKES/2024/112',
            jabatanPenandatangan: 'Dokter Pemeriksa RSUD Prof. Dr. H. Aloei Saboe',
            namaFile: 'Surat_Keterangan_Sakit_Siti.pdf',
            ukuranFile: '180 KB'
        },
        'Dedi Kurniawan': {
            tipe: 'spt_dinas',
            jenis: 'Surat Perintah Tugas (SPT)',
            badge: 'SPT Penugasan Sah',
            judulDokumen: 'SURAT PERINTAH TUGAS (SPT)',
            nomorSurat: '090/DISPERDAGIN/SPT-MET/192/VIII/2026',
            pegawai: 'Dedi Kurniawan',
            nip: '19890115 201402 1 003',
            pangkat: 'Penata Muda Tk. I / III/b',
            jabatan: 'Penera Terampil / Pengawas Kemetrologian',
            bidang: 'Perlindungan Konsumen',
            tanggal: '20 Agustus 2026 (1 Hari Penuh)',
            alasan: 'Melaksanakan tera ulang timbangan meja, timbangan pegas, dan alat UTTP di Pasar Sentral Kota Gorontalo.',
            dasar: 'Program Kerja Pelayanan Tera dan Tera Ulang UTTP Tahun Anggaran 2026 Dinas Perdagangan dan Perindustrian Kota Gorontalo.',
            pernyataan: 'MEMERINTAHKAN KEPADA:',
            lokasi: 'Kios Pasar Tradisional & Pasar Sentral Kota Gorontalo',
            ketentuan: 'Melaksanakan tugas dengan penuh tanggung jawab dan berkoordinasi dengan pengelola pasar serta menyerahkan berita acara tera ulang.',
            tanggalPengesahan: 'Pada tanggal 19 Agustus 2026',
            penandatangan: 'Drs. H. M. Dahlan, M.Si',
            nipPenandatangan: '19680512 199403 1 005',
            jabatanPenandatangan: 'Kepala Dinas Perdagangan dan Perindustrian Kota Gorontalo',
            namaFile: 'SPT_Tera_Ulang_Dedi.pdf',
            ukuranFile: '412 KB'
        },
        'Budi Santoso': {
            tipe: 'sk_cuti',
            jenis: 'SK Cuti Tahunan',
            badge: 'SK Cuti Sah',
            judulDokumen: 'SURAT KEPUTUSAN PEMBERIAN CUTI TAHUNAN',
            nomorSurat: '800/DISPERDAGIN/SK-CUTI/038/VIII/2026',
            pegawai: 'Budi Santoso',
            nip: '19861103 201001 1 006',
            pangkat: 'Penata / III/c',
            jabatan: 'Penyuluh Perindag Ahli Muda',
            bidang: 'Perindustrian',
            tanggal: '25 – 27 Agustus 2026 (3 Hari Kerja)',
            alasan: 'Melaksanakan cuti tahunan terencana untuk menghadiri prosesi pernikahan keluarga kandung.',
            dasar: 'Surat Permohonan Cuti Tahunan Pegawai Nomor 800/038/CUTI/2026 tanggal 18 Agustus 2026.',
            pernyataan: 'MEMBERIKAN IZIN CUTI TAHUNAN KEPADA:',
            lokasi: '-',
            ketentuan: 'Pegawai bersangkutan telah memenuhi syarat hak cuti tahunan berjalan dan wajib masuk kerja kembali tepat waktu.',
            tanggalPengesahan: 'Pada tanggal 22 Agustus 2026',
            penandatangan: 'Drs. H. M. Dahlan, M.Si',
            nipPenandatangan: '19680512 199403 1 005',
            jabatanPenandatangan: 'Kepala Dinas Perdagangan dan Perindustrian Kota Gorontalo',
            namaFile: 'SK_Cuti_Tahunan_Budi.pdf',
            ukuranFile: '260 KB'
        }
    };

    let activePreviewLampiran = null;
    let currentReviewLampiranData = null;

    function openPreviewLampiranModal(data) {
        if (!data) return;
        activePreviewLampiran = data;

        // Set Title & Badge
        const titleEl = document.getElementById('lampiranModalTitle');
        const badgeEl = document.getElementById('lampiranModalBadge');
        if (titleEl) titleEl.textContent = `Preview ${data.jenis}`;
        if (badgeEl) {
            badgeEl.textContent = data.badge || 'Resmi Terverifikasi';
            if (data.tipe === 'spt_dinas') {
                badgeEl.className = 'px-2 py-0.5 rounded text-[10px] font-extrabold uppercase bg-blue-500/20 text-blue-300 border border-blue-500/30';
            } else if (data.tipe === 'surat_sakit') {
                badgeEl.className = 'px-2 py-0.5 rounded text-[10px] font-extrabold uppercase bg-amber-500/20 text-amber-300 border border-amber-500/30';
            } else {
                badgeEl.className = 'px-2 py-0.5 rounded text-[10px] font-extrabold uppercase bg-emerald-500/20 text-emerald-300 border border-emerald-500/30';
            }
        }

        // Set Surat Detail
        const judulEl = document.getElementById('lampiranDocJudul');
        const nomorEl = document.getElementById('lampiranDocNomor');
        const dasarEl = document.getElementById('lampiranDocDasar');
        const pernyataanEl = document.getElementById('lampiranDocPernyataan');

        if (judulEl) judulEl.textContent = data.judulDokumen || data.jenis.toUpperCase();
        if (nomorEl) nomorEl.textContent = `Nomor: ${data.nomorSurat}`;
        if (dasarEl) dasarEl.textContent = data.dasar;
        if (pernyataanEl) pernyataanEl.textContent = data.pernyataan || 'MEMBERIKAN DISPENSASI KEPADA:';

        // Set Pegawai Data
        const namaEl = document.getElementById('lampiranDocNama');
        const nipEl = document.getElementById('lampiranDocNip');
        const pangkatEl = document.getElementById('lampiranDocPangkat');
        const jabatanEl = document.getElementById('lampiranDocJabatan');
        const bidangEl = document.getElementById('lampiranDocBidang');
        const waktuEl = document.getElementById('lampiranDocWaktu');
        const alasanEl = document.getElementById('lampiranDocAlasan');
        const ketentuanEl = document.getElementById('lampiranDocKetentuan');

        if (namaEl) namaEl.textContent = data.pegawai;
        if (nipEl) nipEl.textContent = data.nip;
        if (pangkatEl) pangkatEl.textContent = data.pangkat;
        if (jabatanEl) jabatanEl.textContent = data.jabatan;
        if (bidangEl) bidangEl.textContent = data.bidang;
        if (waktuEl) waktuEl.textContent = data.tanggal;
        if (alasanEl) alasanEl.textContent = data.alasan;
        if (ketentuanEl) ketentuanEl.textContent = data.ketentuan;

        // Lokasi Row (Jika SPT)
        const lokasiRow = document.getElementById('lampiranDocLokasiRow');
        const lokasiEl = document.getElementById('lampiranDocLokasi');
        if (lokasiRow && lokasiEl) {
            if (data.lokasi && data.lokasi !== '-') {
                lokasiRow.classList.remove('hidden');
                lokasiEl.textContent = data.lokasi;
            } else {
                lokasiRow.classList.add('hidden');
            }
        }

        // Tanda Tangan & Pengesahan
        const tglSahEl = document.getElementById('lampiranDocTanggalPengesahan');
        const jabatanTtdEl = document.getElementById('lampiranDocJabatanTtd');
        const namaTtdEl = document.getElementById('lampiranDocNamaTtd');
        const nipTtdEl = document.getElementById('lampiranDocNipTtd');

        if (tglSahEl) tglSahEl.textContent = data.tanggalPengesahan;
        if (jabatanTtdEl) jabatanTtdEl.textContent = data.jabatanPenandatangan;
        if (namaTtdEl) namaTtdEl.textContent = data.penandatangan;
        if (nipTtdEl) nipTtdEl.textContent = data.nipPenandatangan ? `NIP. ${data.nipPenandatangan}` : '';

        openModal('modalPreviewLampiranDokumen');
    }

    function openLampiranByPegawai(nama) {
        if (lampiranDatabase[nama]) {
            openPreviewLampiranModal(lampiranDatabase[nama]);
        } else {
            alert(`Dokumen lampiran resmi untuk ${nama} sedang dalam proses sinkronisasi.`);
        }
    }

    function openLampiranFromReviewModal() {
        if (currentReviewLampiranData) {
            openPreviewLampiranModal(currentReviewLampiranData);
        }
    }

    function unduhLampiranDokumen() {
        if (!activePreviewLampiran) return;
        alert(`Mengunduh Berkas Elektronik:\n• Berkas: ${activePreviewLampiran.namaFile}\n• Ukuran: ${activePreviewLampiran.ukuranFile}\n• Status: Berhasil diunduh dengan sertifikat digital sah.`);
    }

    function cetakLampiranDokumen() {
        window.print();
    }

    function openReviewPengajuanModal(nama, jenis, waktu, alasan, customLampiran) {
        document.getElementById('reviewModalNama').textContent = nama;
        document.getElementById('reviewModalJenis').textContent = jenis;
        document.getElementById('reviewModalWaktu').textContent = waktu;
        document.getElementById('reviewModalAlasan').textContent = alasan;

        currentReviewLampiranData = customLampiran || lampiranDatabase[nama] || {
            tipe: 'dokumen',
            jenis: `Lampiran ${jenis}`,
            badge: 'Dokumen Sah',
            judulDokumen: `SURAT PENDUKUNG PENGAJUAN ${jenis.toUpperCase()}`,
            nomorSurat: '800/DISPERDAGIN/DISP/2026',
            pegawai: nama,
            nip: '19890115 201402 1 003',
            pangkat: 'Penata Muda / III/a',
            jabatan: 'Staf Pegawai',
            bidang: 'DISPERDAGIN Kota Gorontalo',
            tanggal: waktu,
            alasan: alasan,
            dasar: 'Surat Permohonan Pegawai Terverifikasi Sistem Absensi Digital DISPERDAGIN.',
            pernyataan: 'DIBERIKAN KEPADA:',
            lokasi: '-',
            ketentuan: 'Dokumen pendukung permohonan dispensasi resmi kehadiran pegawai.',
            tanggalPengesahan: 'Pada tanggal 08 September 2026',
            penandatangan: 'Drs. H. M. Dahlan, M.Si',
            nipPenandatangan: '19680512 199403 1 005',
            jabatanPenandatangan: 'Kepala Dinas Perdagangan dan Perindustrian Kota Gorontalo',
            namaFile: `Lampiran_${nama.replace(/\s+/g, '_')}.pdf`,
            ukuranFile: '240 KB'
        };

        const lampiranLabel = document.getElementById('reviewModalLampiranLabel');
        if (lampiranLabel && currentReviewLampiranData) {
            lampiranLabel.textContent = `Lihat ${currentReviewLampiranData.jenis}`;
        }

        openModal('modalReviewPengajuan');
    }

    // Filter Tab Pengajuan (Semua / Pending / Approved)
    function filterPengajuan(status, btnElement) {
        // Toggle tab style
        const buttons = document.querySelectorAll('.pengajuan-tab-btn');
        buttons.forEach(btn => {
            btn.className = 'pengajuan-tab-btn px-3 py-1.5 text-gray-600 font-medium rounded-lg text-xs hover:text-gray-900 transition cursor-pointer';
        });
        if (btnElement) {
            btnElement.className = 'pengajuan-tab-btn px-3 py-1.5 bg-white text-[#0D2240] font-bold rounded-lg text-xs shadow-2xs transition cursor-pointer';
        }

        // Filter Rows
        const rows = document.querySelectorAll('#pengajuanTableBody tr');
        rows.forEach(row => {
            const rowStatus = row.getAttribute('data-status');
            if (status === 'all' || rowStatus === status) {
                row.classList.remove('hidden');
            } else {
                row.classList.add('hidden');
            }
        });
    }

    function openPreviewSPModal(nama, tingkat, alasan, tanggal) {
        document.getElementById('spModalNama').textContent = nama;
        document.getElementById('spModalTingkat').textContent = `Surat Peringatan (${tingkat})`;
        document.getElementById('spModalAlasan').textContent = alasan;
        document.getElementById('spModalTanggal').textContent = tanggal;
        openModal('modalPreviewSP');
    }

    function resetPasswordModal(nama) {
        alert(`Tautan instruksi reset kata sandi berhasil dikirimkan ke email resmi dinas ${nama}.`);
    }

    document.addEventListener('DOMContentLoaded', () => {
        // Sidebar Mobile Toggle
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const openBtn = document.getElementById('openSidebarBtn');
        const closeBtn = document.getElementById('closeSidebarBtn');

        if (openBtn) openBtn.addEventListener('click', () => {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
        });

        if (closeBtn) closeBtn.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        });

        if (overlay) overlay.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        });

        // Live Clock Updates
        function updateClock() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            const timeString = `${hours}:${minutes}:${seconds}`;

            const clockEl = document.getElementById('liveClock');
            if (clockEl) clockEl.textContent = timeString;

            const timeEl = document.getElementById('liveTime');
            if (timeEl) timeEl.textContent = `${timeString} WITA`;

            const dateStr = now.toLocaleDateString('id-ID', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' });
            const dateEl = document.getElementById('liveDate');
            if (dateEl) dateEl.textContent = dateStr;

            const heroDateUpper = document.getElementById('heroDateUpper');
            if (heroDateUpper) heroDateUpper.textContent = dateStr.toUpperCase();
        }

        setInterval(updateClock, 1000);
        updateClock();

        // Search filter pada tabel data pegawai
        const searchPegawai = document.getElementById('searchPegawaiInput');
        if (searchPegawai) {
            searchPegawai.addEventListener('keyup', function () {
                const val = this.value.toLowerCase();
                const rows = document.querySelectorAll('#tabelPegawaiBody tr');
                rows.forEach(r => {
                    const text = r.textContent.toLowerCase();
                    r.style.display = text.includes(val) ? '' : 'none';
                });
            });
        }

        // Filter Data Monitoring Absensi (Sesuai Screenshot Referensi)
        const filterAbsensiNama = document.getElementById('filterAbsensiNama');
        const filterAbsensiTanggal = document.getElementById('filterAbsensiTanggal');
        const filterAbsensiBulan = document.getElementById('filterAbsensiBulan');
        const filterAbsensiTahun = document.getElementById('filterAbsensiTahun');
        const filterAbsensiStatus = document.getElementById('filterAbsensiStatus');
        const filterActiveLabel = document.getElementById('filterActiveLabel');
        const totalAbsensiFiltered = document.getElementById('totalAbsensiFiltered');

        function applyAbsensiFilter() {
            const qNama = (filterAbsensiNama ? filterAbsensiNama.value.trim().toLowerCase() : '');
            const qTanggal = (filterAbsensiTanggal ? filterAbsensiTanggal.value : '');
            const qBulan = (filterAbsensiBulan ? filterAbsensiBulan.value : 'Semua Bulan');
            const qTahun = (filterAbsensiTahun ? filterAbsensiTahun.value : 'Semua Tahun');
            const qStatus = (filterAbsensiStatus ? filterAbsensiStatus.value.toLowerCase() : 'semua status');
            
            const rows = document.querySelectorAll('#tabelAbsensiBody tr.data-row');
            let countVisible = 0;

            rows.forEach(r => {
                const nama = (r.getAttribute('data-nama') || '').toLowerCase();
                const status = (r.getAttribute('data-status') || '').toLowerCase();
                const tanggal = r.getAttribute('data-tanggal') || '';
                const bulan = r.getAttribute('data-bulan') || '';
                const tahun = r.getAttribute('data-tahun') || '';

                const matchNama = !qNama || nama.includes(qNama);
                const matchTanggal = !qTanggal || (tanggal === qTanggal);
                const matchBulan = qTanggal ? true : ((qBulan === 'Semua Bulan') || (bulan === qBulan));
                const matchTahun = qTanggal ? true : ((qTahun === 'Semua Tahun') || (tahun === qTahun));
                const matchStatus = (qStatus === 'semua status') || status.includes(qStatus);

                if (matchNama && matchTanggal && matchBulan && matchTahun && matchStatus) {
                    r.style.display = '';
                    countVisible++;
                } else {
                    r.style.display = 'none';
                }
            });

            const emptyRow = document.getElementById('emptyAbsensiRow');
            if (emptyRow) {
                emptyRow.style.display = (countVisible === 0) ? '' : 'none';
            }

            if (totalAbsensiFiltered) {
                totalAbsensiFiltered.textContent = `Menampilkan ${countVisible} pegawai`;
            }

            if (filterActiveLabel) {
                const parts = [];
                if (qNama) parts.push(`nama "${qNama}"`);
                if (qTanggal) parts.push(`tgl ${qTanggal}`);
                else if (qBulan !== 'Semua Bulan' || qTahun !== 'Semua Tahun') parts.push(`periode ${qBulan} ${qTahun}`);
                if (qStatus !== 'semua status') parts.push(`status ${qStatus}`);
                
                filterActiveLabel.textContent = parts.length ? `Filter aktif: ${parts.join(' • ')}` : 'Filter aktif: semua data';
            }
        }

        if (filterAbsensiNama) filterAbsensiNama.addEventListener('input', applyAbsensiFilter);
        if (filterAbsensiStatus) filterAbsensiStatus.addEventListener('change', applyAbsensiFilter);
        
        if (filterAbsensiTanggal) filterAbsensiTanggal.addEventListener('change', function() {
            if (this.value) {
                const [y, m, d] = this.value.split('-');
                if (filterAbsensiBulan) filterAbsensiBulan.value = m;
                if (filterAbsensiTahun) filterAbsensiTahun.value = y;
            }
            applyAbsensiFilter();
        });
        
        if (filterAbsensiBulan) filterAbsensiBulan.addEventListener('change', function() {
            if (filterAbsensiTanggal) filterAbsensiTanggal.value = '';
            applyAbsensiFilter();
        });
        
        if (filterAbsensiTahun) filterAbsensiTahun.addEventListener('change', function() {
            if (filterAbsensiTanggal) filterAbsensiTanggal.value = '';
            applyAbsensiFilter();
        });

        window.resetFilterAbsensi = function () {
            if (filterAbsensiNama) filterAbsensiNama.value = '';
            if (filterAbsensiStatus) filterAbsensiStatus.value = 'Semua Status';
            if (filterAbsensiTanggal) filterAbsensiTanggal.value = '';
            if (filterAbsensiBulan) filterAbsensiBulan.value = '09';
            if (filterAbsensiTahun) filterAbsensiTahun.value = '2026';
            applyAbsensiFilter();
        };

        // Filter Data Laporan Kegiatan
        const filterKegiatanSearch = document.getElementById('filterKegiatanSearch');
        const filterKegiatanBidang = document.getElementById('filterKegiatanBidang');
        const filterKegiatanTanggal = document.getElementById('filterKegiatanTanggal');
        const filterKegiatanBulan = document.getElementById('filterKegiatanBulan');
        const filterKegiatanTahun = document.getElementById('filterKegiatanTahun');
        const filterKegiatanStatus = document.getElementById('filterKegiatanStatus');
        const filterKegiatanActiveLabel = document.getElementById('filterKegiatanActiveLabel');
        const totalKegiatanFiltered = document.getElementById('totalKegiatanFiltered');

        function applyKegiatanFilter() {
            const qSearch = (filterKegiatanSearch ? filterKegiatanSearch.value.trim().toLowerCase() : '');
            const qBidang = (filterKegiatanBidang ? filterKegiatanBidang.value.toLowerCase() : 'semua bidang');
            const qTanggal = (filterKegiatanTanggal ? filterKegiatanTanggal.value : '');
            const qBulan = (filterKegiatanBulan ? filterKegiatanBulan.value : 'Semua Bulan');
            const qTahun = (filterKegiatanTahun ? filterKegiatanTahun.value : 'Semua Tahun');
            const qStatus = (filterKegiatanStatus ? filterKegiatanStatus.value.toLowerCase() : 'semua status');

            const rows = document.querySelectorAll('#tabelKegiatanBody tr.kegiatan-data-row');
            let countVisible = 0;

            rows.forEach(r => {
                const nama = (r.getAttribute('data-nama') || '').toLowerCase();
                const bidang = (r.getAttribute('data-bidang') || '').toLowerCase();
                const kegiatan = (r.getAttribute('data-kegiatan') || '').toLowerCase();
                const tanggal = r.getAttribute('data-tanggal') || '';
                const bulan = r.getAttribute('data-bulan') || '';
                const tahun = r.getAttribute('data-tahun') || '';
                const status = (r.getAttribute('data-status') || '').toLowerCase();

                const matchSearch = !qSearch || nama.includes(qSearch) || kegiatan.includes(qSearch);
                const matchBidang = (qBidang === 'semua bidang') || bidang.includes(qBidang);
                const matchTanggal = !qTanggal || (tanggal === qTanggal);
                const matchBulan = qTanggal ? true : ((qBulan === 'Semua Bulan') || (bulan === qBulan));
                const matchTahun = qTanggal ? true : ((qTahun === 'Semua Tahun') || (tahun === qTahun));
                const matchStatus = (qStatus === 'semua status') || status.includes(qStatus);

                if (matchSearch && matchBidang && matchTanggal && matchBulan && matchTahun && matchStatus) {
                    r.style.display = '';
                    countVisible++;
                } else {
                    r.style.display = 'none';
                }
            });

            const emptyRow = document.getElementById('emptyKegiatanRow');
            if (emptyRow) {
                emptyRow.style.display = (countVisible === 0) ? '' : 'none';
            }

            if (totalKegiatanFiltered) {
                totalKegiatanFiltered.textContent = `Menampilkan ${countVisible} laporan`;
            }

            if (filterKegiatanActiveLabel) {
                const parts = [];
                if (qSearch) parts.push(`cari "${qSearch}"`);
                if (qBidang !== 'semua bidang') parts.push(`bidang ${filterKegiatanBidang.value}`);
                if (qTanggal) parts.push(`tgl ${qTanggal}`);
                else {
                    if (qBulan !== 'Semua Bulan' || qTahun !== 'Semua Tahun') {
                        const bNama = filterKegiatanBulan.options[filterKegiatanBulan.selectedIndex].text;
                        parts.push(`periode ${bNama} ${qTahun !== 'Semua Tahun' ? qTahun : ''}`);
                    }
                }
                if (qStatus !== 'semua status') parts.push(`status ${filterKegiatanStatus.value}`);

                if (parts.length === 0) {
                    filterKegiatanActiveLabel.textContent = 'Filter aktif: semua data (tanpa filter)';
                } else {
                    filterKegiatanActiveLabel.textContent = `Filter aktif: ${parts.join(' • ')}`;
                }
            }
        }

        if (filterKegiatanSearch) filterKegiatanSearch.addEventListener('input', applyKegiatanFilter);
        if (filterKegiatanBidang) filterKegiatanBidang.addEventListener('change', applyKegiatanFilter);
        if (filterKegiatanStatus) filterKegiatanStatus.addEventListener('change', applyKegiatanFilter);
        
        if (filterKegiatanTanggal) filterKegiatanTanggal.addEventListener('change', function() {
            if (this.value) {
                const [y, m, d] = this.value.split('-');
                if (filterKegiatanBulan) filterKegiatanBulan.value = m;
                if (filterKegiatanTahun) filterKegiatanTahun.value = y;
            }
            applyKegiatanFilter();
        });
        
        if (filterKegiatanBulan) filterKegiatanBulan.addEventListener('change', function() {
            if (filterKegiatanTanggal) filterKegiatanTanggal.value = '';
            applyKegiatanFilter();
        });
        
        if (filterKegiatanTahun) filterKegiatanTahun.addEventListener('change', function() {
            if (filterKegiatanTanggal) filterKegiatanTanggal.value = '';
            applyKegiatanFilter();
        });

        window.resetFilterKegiatan = function () {
            if (filterKegiatanSearch) filterKegiatanSearch.value = '';
            if (filterKegiatanBidang) filterKegiatanBidang.value = 'Semua Bidang';
            if (filterKegiatanTanggal) filterKegiatanTanggal.value = '';
            if (filterKegiatanBulan) filterKegiatanBulan.value = '09';
            if (filterKegiatanTahun) filterKegiatanTahun.value = '2026';
            if (filterKegiatanStatus) filterKegiatanStatus.value = 'Semua Status';
            applyKegiatanFilter();
        };

        window.approveKegiatan = function (btn, nama) {
            const tr = btn.closest('tr');
            if (tr) {
                tr.setAttribute('data-status', 'Terverifikasi');
                btn.parentElement.innerHTML = '<span class="inline-flex items-center px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-800 text-xs font-semibold">Terverifikasi</span>';
            }
            alert(`Laporan kegiatan dari ${nama} berhasil disetujui & diverifikasi!`);
        };

        window.openReviewKegiatanModal = function (btn) {
            const id = btn.getAttribute('data-id');
            const nama = btn.getAttribute('data-nama');
            const judul = btn.getAttribute('data-kegiatan');
            const tanggal = btn.getAttribute('data-tanggal');
            const uraian = btn.getAttribute('data-uraian');
            const foto = btn.getAttribute('data-foto');
            let prod = btn.getAttribute('data-prod');
            const kual = btn.getAttribute('data-kual');

            document.getElementById('formReviewKegiatan').action = '/admin/laporan-kegiatan/' + id + '/verifikasi';
            document.getElementById('modalReviewNama').textContent = nama;
            document.getElementById('modalReviewKegiatan').textContent = judul;
            document.getElementById('modalReviewTanggal').textContent = tanggal;
            document.getElementById('modalReviewUraian').textContent = uraian;
            
            const fotoContainer = document.getElementById('modalReviewFotoContainer');
            if (foto && foto !== '') {
                document.getElementById('modalReviewFoto').src = '/storage/' + foto;
                fotoContainer.classList.remove('hidden');
            } else {
                fotoContainer.classList.add('hidden');
            }

            // Note: The modal might not have element 'modalReviewProduktivitas' and 'modalReviewKategoriProduktivitas' in this version,
            // but we update the input values if they exist.
            document.getElementById('inputKualitas').value = kual || '';
            
            openModal('modalReviewKegiatanModalId');
        };

        window.approveKegiatanModal = function () {
            const nama = document.getElementById('modalReviewNama').textContent;
            closeModal('modalReviewKegiatanModalId');
            alert(`Penilaian Kualitas untuk ${nama} berhasil disimpan!`);
        };
    });

    function showInfoModal(type) {
        const titleEl = document.getElementById('modalInfoTitle');
        const subTitleEl = document.getElementById('modalInfoSubtitle');
        const listEl = document.getElementById('modalInfoList');
        const modal = document.getElementById('modalInfoPegawai');

        let itemsHtml = '';

        if (type === 'total') {
            titleEl.textContent = 'Info Total Pegawai';
            subTitleEl.textContent = 'Daftar pegawai terdaftar aktif';
            const dummy = [
                { name: 'Rani Ayu Pratiwi', detail: 'Sekretariat', color: 'text-gray-500' },
                { name: 'Budi Santoso', detail: 'Perdagangan', color: 'text-gray-500' },
                { name: 'Andi Saputra', detail: 'Perindustrian', color: 'text-gray-500' },
                { name: 'Siti Aminah', detail: 'Perlindungan Konsumen', color: 'text-gray-500' },
                { name: 'Reza Pahlevi', detail: 'Perdagangan', color: 'text-gray-500' }
            ];
            itemsHtml = renderInfoList(dummy);
        } else if (type === 'hadir') {
            titleEl.textContent = 'Info Pegawai Hadir';
            subTitleEl.textContent = 'Daftar singkat pegawai yang hadir';
            const dummy = [
                { name: 'Rani Ayu Pratiwi', detail: '07:54', color: 'text-emerald-500' },
                { name: 'Budi Santoso', detail: '07:45', color: 'text-emerald-500' },
                { name: 'Andi Saputra', detail: '08:10 (Telat)', color: 'text-red-500' },
                { name: 'Siti Aminah', detail: '07:30', color: 'text-emerald-500' }
            ];
            itemsHtml = renderInfoList(dummy);
        } else if (type === 'izin') {
            titleEl.textContent = 'Info Pegawai Izin/Sakit/Cuti';
            subTitleEl.textContent = 'Pegawai yang tidak hadir dengan keterangan';
            const dummy = [
                { name: 'Reza Pahlevi', detail: 'Sakit', color: 'text-amber-500' },
                { name: 'Dian Sastro', detail: 'Izin', color: 'text-amber-500' },
                { name: 'Maya M', detail: 'Cuti', color: 'text-amber-500' }
            ];
            itemsHtml = renderInfoList(dummy);
        } else if (type === 'dinas') {
            titleEl.textContent = 'Info Pegawai Dinas Luar';
            subTitleEl.textContent = 'Pegawai yang bertugas di luar kantor';
            const dummy = [
                { name: 'Hendra Setiawan', detail: 'Bimtek', color: 'text-blue-500' },
                { name: 'Ratna Dewi', detail: 'Workshop', color: 'text-blue-500' },
                { name: 'Lina M', detail: 'Diklat', color: 'text-blue-500' }
            ];
            itemsHtml = renderInfoList(dummy);
        }

        listEl.innerHTML = itemsHtml;
        modal.classList.remove('hidden');
        modal.classList.add('flex');

        // Trigger animation
        setTimeout(() => {
            const panel = modal.querySelector('.relative.bg-white');
            panel.classList.remove('scale-95', 'opacity-0');
            panel.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    function renderInfoList(items) {
        return items.map(item => `
        <div class="flex items-center justify-between py-4 border-b border-gray-100/80 last:border-0">
            <span class="text-[15px] text-gray-800">${item.name}</span>
            <span class="text-sm ${item.color}">${item.detail}</span>
        </div>
    `).join('');
    }

    function closeInfoModal() {
        const modal = document.getElementById('modalInfoPegawai');
        const panel = modal.querySelector('.relative.bg-white');

        panel.classList.remove('scale-100', 'opacity-100');
        panel.classList.add('scale-95', 'opacity-0');

        setTimeout(() => {
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }, 300);
    }
</script>
