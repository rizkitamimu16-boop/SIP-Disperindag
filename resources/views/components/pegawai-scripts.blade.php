<script>
    let currentPresensiType = 'masuk';
    let currentPhotoBase64 = null;
    let currentLat = null;
    let currentLng = null;

    function calculateDistance(lat1, lon1, lat2, lon2) {
        const R = 6371e3;
        const p1 = lat1 * Math.PI/180;
        const p2 = lat2 * Math.PI/180;
        const deltaP = p2 - p1;
        const deltaLon = lon2 - lon1;
        const deltaLambda = (deltaLon) * Math.PI/180;
        const a = Math.sin(deltaP/2) * Math.sin(deltaP/2) +
                  Math.cos(p1) * Math.cos(p2) *
                  Math.sin(deltaLambda/2) * Math.sin(deltaLambda/2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
        return Math.round(R * c);
    }

    // 1. Fungsi Pop Up Presensi Kehadiran (Gambar 1)
    function openPresensiModal(type) {
        currentPresensiType = type || 'masuk';
        const modal = document.getElementById('modalPresensiKehadiran');
        const title = document.getElementById('modalPresensiTitle');
        if (title) {
            title.textContent = currentPresensiType === 'pulang'
                ? 'Presensi Kehadiran Absen Pulang'
                : 'Presensi Kehadiran Absen Datang';
        }
        if (modal) {
            modal.classList.remove('hidden');
            syncLocation(); // Auto-sync when opened
        }
    }

    function closePresensiModal() {
        const modal = document.getElementById('modalPresensiKehadiran');
        if (modal) modal.classList.add('hidden');
    }

    let currentOriginalImage = null;

    function applyWatermark() {
        if (!currentOriginalImage) return;
        
        const img = currentOriginalImage;
        const canvas = document.createElement('canvas');
        const MAX_WIDTH = 800;
        const MAX_HEIGHT = 800;
        let width = img.width;
        let height = img.height;

        if (width > height) {
            if (width > MAX_WIDTH) {
                height *= MAX_WIDTH / width;
                width = MAX_WIDTH;
            }
        } else {
            if (height > MAX_HEIGHT) {
                width *= MAX_HEIGHT / height;
                height = MAX_HEIGHT;
            }
        }

        canvas.width = width;
        canvas.height = height;
        const ctx = canvas.getContext('2d');
        ctx.drawImage(img, 0, 0, width, height);

        // --- Menambahkan Watermark GPS & Waktu ---
        var now = new Date();
        var tglStr = now.toLocaleDateString('id-ID', { day: '2-digit', month: '2-digit', year: 'numeric' });
        var jamStr = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' }) + " WITA";
        var coordsStr = (currentLat && currentLng) ? currentLat.toFixed(6) + ", " + currentLng.toFixed(6) : "GPS Tidak Terdeteksi";

        var fontSize = Math.max(14, Math.floor(canvas.width * 0.032));
        var lineHeight = fontSize * 1.35;

        var textLines = [
          "📍 Link: https://maps.google.com/",
          "📌 Loc: ?q=" + coordsStr,
          "📅 Waktu: " + tglStr + " " + jamStr
        ];

        var boxPadding = fontSize * 0.8;
        var boxHeight = (textLines.length * lineHeight) + (boxPadding * 2);

        // Kotak latar belakang transparan
        ctx.fillStyle = "rgba(15, 35, 63, 0.90)";
        ctx.fillRect(0, canvas.height - boxHeight, canvas.width, boxHeight);

        var accentWidth = Math.max(6, canvas.width * 0.012);
        ctx.fillStyle = "#38bdf8";
        ctx.fillRect(0, canvas.height - boxHeight, accentWidth, boxHeight);

        ctx.font = "bold " + fontSize + "px Arial, sans-serif";
        var paddingLeft = accentWidth + (canvas.width * 0.025);

        // Menulis teks watermark
        for (var i = 0; i < textLines.length; i++) {
          var yPos = canvas.height - boxHeight + boxPadding + (i * lineHeight) + fontSize * 0.8;
          var color = (i === 2) ? "#FFFFFF" : "#38bdf8";

          ctx.strokeStyle = '#000000';
          ctx.lineWidth = Math.max(2, fontSize * 0.12);
          ctx.strokeText(textLines[i], paddingLeft, yPos);

          ctx.fillStyle = color;
          ctx.fillText(textLines[i], paddingLeft, yPos);
        }
        // --- Akhir Watermark ---

        const compressedBase64 = canvas.toDataURL('image/jpeg', 0.6);
        currentPhotoBase64 = compressedBase64;

        const statusText = document.getElementById('fotoStatusText');
        if (statusText) {
            statusText.textContent = 'Foto tersimpan (OK ✓)';
            statusText.className = 'text-[11px] font-bold text-emerald-700';
        }
        const thumb = document.getElementById('fotoPresensiThumb');
        if (thumb) {
            thumb.innerHTML = `<img src="${compressedBase64}" class="w-full h-full object-cover rounded-xl" />`;
        }
    }

    function handleFotoPresensi(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = new Image();
                img.onload = function() {
                    currentOriginalImage = img;
                    applyWatermark();
                };
                img.src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function syncLocation() {
        const syncIcon = document.getElementById('syncIcon');
        if (syncIcon) syncIcon.classList.add('animate-spin');
        
        if (navigator.geolocation) {
            const optionsHigh = { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 };
            const optionsLow = { enableHighAccuracy: false, timeout: 20000, maximumAge: 60000 };

            function success(position) {
                currentLat = position.coords.latitude;
                currentLng = position.coords.longitude;
                if (syncIcon) syncIcon.classList.remove('animate-spin');
                
                @php
                    $officeSettings = \App\Models\PengaturanKantor::getPengaturan();
                    $coords = explode(',', $officeSettings->titik_koordinat ?? '0.5573330,123.0562500');
                    $officeLat = trim($coords[0] ?? '0.5573330');
                    $officeLng = trim($coords[1] ?? '123.0562500');
                    $radiusMaksimal = $officeSettings->radius_absensi_meter ?? 50;
                @endphp
                const officeLat = {{ (float)$officeLat }};
                const officeLng = {{ (float)$officeLng }};
                const maxRadius = {{ (int)$radiusMaksimal }};
                
                const distance = calculateDistance(currentLat, currentLng, officeLat, officeLng);
                
                const koordText = document.getElementById('modalKoordinatText');
                if (koordText) {
                    koordText.innerHTML = `<span>Lat: ${currentLat.toFixed(5)} &bull; Long: ${currentLng.toFixed(5)}</span>`;
                }
                
                const banner = document.getElementById('modalRadiusBanner');
                const title = document.getElementById('modalRadiusTitle');
                const subtitle = document.getElementById('modalRadiusSubtitle');
                const badge = document.getElementById('modalRadiusBadge');
                const iconBox = document.getElementById('modalRadiusIconBox');
                
                if (banner && title && subtitle && badge && iconBox) {
                    badge.classList.remove('hidden');
                    if (distance <= maxRadius) {
                        banner.className = 'rounded-xl border border-emerald-300 bg-emerald-50/70 p-3.5 flex items-center justify-between';
                        iconBox.className = 'w-8 h-8 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0';
                        title.textContent = `Radius Lokasi Valid (${distance} meter)`;
                        title.className = 'text-xs sm:text-sm font-bold text-emerald-900';
                        subtitle.textContent = `Posisi terdeteksi di area Kantor (Radius aman < ${maxRadius}m)`;
                        subtitle.className = 'text-[11px] text-emerald-700';
                        badge.className = 'bg-emerald-600 text-white text-xs font-black px-3 py-1 rounded-full shadow-xs tracking-wider';
                        badge.textContent = 'VALID';
                    } else {
                        banner.className = 'rounded-xl border border-red-300 bg-red-50/70 p-3.5 flex items-center justify-between';
                        iconBox.className = 'w-8 h-8 rounded-full bg-red-100 text-red-700 flex items-center justify-center shrink-0';
                        title.textContent = `Di Luar Radius Kantor (${distance} meter)`;
                        title.className = 'text-xs sm:text-sm font-bold text-red-900';
                        subtitle.textContent = `Maksimal ${maxRadius} meter dari titik koordinat kantor!`;
                        subtitle.className = 'text-[11px] text-red-700';
                        badge.className = 'bg-red-600 text-white text-xs font-black px-3 py-1 rounded-full shadow-xs tracking-wider';
                        badge.textContent = 'TOLAK';
                    }
                }
                
                // Redraw watermark photo with updated GPS coordinates
                applyWatermark();
            }

            function errorHigh(err) {
                console.warn('High accuracy failed, trying low accuracy...', err);
                navigator.geolocation.getCurrentPosition(success, errorLow, optionsLow);
            }

            function errorLow(err) {
                if (syncIcon) syncIcon.classList.remove('animate-spin');
                let errMsg = 'Gagal mendapatkan lokasi GPS. Pastikan izin lokasi aktif.';
                if (err.code === 1) {
                    errMsg = 'Akses GPS ditolak (Permission Denied). Jika Anda menggunakan HP, pastikan mengetik URL menggunakan HTTPS (Ngrok) atau izinkan akses lokasi di pengaturan browser.';
                } else if (err.code === 2) {
                    errMsg = 'Posisi tidak tersedia (Position Unavailable). Coba aktifkan ulang GPS HP Anda.';
                } else if (err.code === 3) {
                    errMsg = 'Waktu pencarian lokasi habis (Timeout). Coba cari area yang sedikit lebih terbuka.';
                }
                Swal.fire('Gagal!', errMsg + ' [Code: ' + err.code + ' - ' + err.message + ']', 'error');
            }

            navigator.geolocation.getCurrentPosition(success, errorHigh, optionsHigh);
        } else {
            if (syncIcon) syncIcon.classList.remove('animate-spin');
            Swal.fire('Error', 'Browser Anda tidak mendukung deteksi Geolocation.', 'error');
        }
    }

    function konfirmasiPresensi() {
        if (!currentPhotoBase64) {
            Swal.fire('Perhatian', 'Harap ambil/unggah foto wajah Anda terlebih dahulu!', 'warning');
            return;
        }
        if (!currentLat || !currentLng) {
            Swal.fire('Perhatian', 'Lokasi GPS belum disinkronkan. Tekan tombol "Sinkronkan GPS Sekarang".', 'warning');
            return;
        }

        const type = currentPresensiType === 'pulang' ? 'pulang' : 'masuk';
        const token = '{{ csrf_token() }}';

        fetch('{{ route("pegawai.absensi.record") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                type: type,
                latitude: currentLat,
                longitude: currentLng,
                photo: currentPhotoBase64
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    title: 'Berhasil!',
                    text: data.message || 'Presensi berhasil dicatat ke database!',
                    icon: 'success',
                    confirmButtonText: 'Tutup'
                }).then(() => {
                    closePresensiModal();
                    window.location.reload();
                });
            } else {
                Swal.fire('Gagal!', data.message || 'Gagal merekam presensi.', 'error');
            }
        })
        .catch(err => {
            console.error(err);
            Swal.fire('Error!', 'Terjadi kesalahan saat menghubungi server presensi.', 'error');
        });
    }

    // 2. Fungsi Pop Up Pelaporan Kegiatan (Gambar 2)
    function openKegiatanModal() {
        const modal = document.getElementById('modalPelaporanKegiatan');
        if (modal) modal.classList.remove('hidden');
    }

    function closeKegiatanModal() {
        const modal = document.getElementById('modalPelaporanKegiatan');
        if (modal) modal.classList.add('hidden');
    }

    function handleFotoKegiatanUploaded(input) {
        if (input.files && input.files[0]) {
            const status = document.getElementById('fotoKegiatanStatus');
            if (status) {
                status.textContent = input.files[0].name + ' (Siap dikirim)';
                status.className = 'text-[11px] font-semibold text-emerald-600';
            }
        }
    }

    function submitKegiatan(e) {
        e.preventDefault();
        const jam = document.getElementById('kegiatanJam').value;
        const nama = document.getElementById('kegiatanNama').value;
        const desc = document.getElementById('kegiatanDeskripsi').value;

        // Tambahkan baris baru ke tabel kegiatan jika ada
        const tbody = document.getElementById('tabelKegiatanBody');
        if (tbody) {
            const newRow = document.createElement('tr');
            newRow.className = 'hover:bg-slate-50/70 transition bg-sky-50/30 animate-pulse';
            newRow.innerHTML = `
                <td class="p-3.5 font-medium whitespace-nowrap">
                    <p class="font-bold text-gray-900">Hari Ini (Baru)</p>
                    <p class="text-[11px] text-gray-500">${jam || '09:00 - 11:30'}</p>
                </td>
                <td class="p-3.5">
                    <span class="font-bold text-gray-900 block">${nama || 'Kegiatan Kantor'}</span>
                    <span class="text-[11px] text-slate-500">Staf PPPK</span>
                </td>
                <td class="p-3.5 max-w-xs">
                    <p class="truncate font-medium text-gray-700">${desc || '-'}</p>
                </td>
                <td class="p-3.5 text-center whitespace-nowrap">
                    <span class="inline-flex items-center space-x-1 px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-700 text-[11px] font-semibold border border-emerald-200">
                        <span>Terlampir</span>
                    </span>
                </td>
                <td class="p-3.5 whitespace-nowrap">
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold bg-amber-50 text-amber-800 border border-amber-200">
                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 mr-1.5 animate-pulse"></span>
                        Menunggu Review
                    </span>
                </td>
                <td class="p-3.5 text-center whitespace-nowrap">
                    <button type="button" onclick="alert('Laporan kegiatan baru terkirim dan menunggu verifikasi atasan.')" class="text-[#0D2240] hover:text-sky-700 font-bold hover:underline cursor-pointer">
                        Detail
                    </button>
                </td>
            `;
            tbody.insertBefore(newRow, tbody.firstChild);
        }

        alert(`Laporan Kegiatan "${nama}" berhasil dikirim ke Subkoordinator untuk penilaian produktivitas harian!`);
        closeKegiatanModal();
        document.getElementById('formModalKegiatan').reset();
    }

    // 4. Inisialisasi Chart.js Kinerja dengan Perlindungan Destroy
    let chartRadarInstance = null;
    let chartTrenInstance = null;

    function renderKinerjaCharts() {
        if (typeof Chart === 'undefined') return;

        // Radar Chart Kinerja 3 Indikator
        const ctxRadar = document.getElementById('chartRadarKinerja');
        if (ctxRadar) {
            if (chartRadarInstance) {
                chartRadarInstance.destroy();
            }
            chartRadarInstance = new Chart(ctxRadar.getContext('2d'), {
                type: 'radar',
                data: {
                    labels: {!! json_encode($chartRadarLabels ?? ['Kehadiran (60%)', 'Produktivitas (25%)', 'Kualitas (15%)']) !!},
                    datasets: [{
                        label: 'Capaian Anda',
                        data: {!! json_encode($chartRadarData ?? [0, 0, 0]) !!},
                        backgroundColor: 'rgba(13, 34, 64, 0.2)',
                        borderColor: '#0D2240',
                        borderWidth: 2.5,
                        pointBackgroundColor: '#0D2240',
                        pointBorderColor: '#FFFFFF',
                        pointHoverBackgroundColor: '#FFFFFF',
                        pointHoverBorderColor: '#0D2240',
                        pointRadius: 4
                    }, {
                        label: 'Standar Minimal SKPD',
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

        // Line Chart Tren Kinerja 6 Bulan
        const ctxTren = document.getElementById('chartTrenKinerja');
        if (ctxTren) {
            if (chartTrenInstance) {
                chartTrenInstance.destroy();
            }
            chartTrenInstance = new Chart(ctxTren.getContext('2d'), {
                type: 'line',
                data: {
                    labels: {!! json_encode($chartTrendLabels ?? ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun']) !!},
                    datasets: [{
                        label: 'Indeks Kinerja',
                        data: {!! json_encode($chartTrendData ?? [0, 0, 0, 0, 0, 0]) !!},
                        borderColor: '#0D2240',
                        backgroundColor: 'rgba(13, 34, 64, 0.08)',
                        borderWidth: 2.5,
                        fill: true,
                        tension: 0.35,
                        pointBackgroundColor: '#0D2240',
                        pointBorderColor: '#FFFFFF',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 7
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    return ' Nilai Kinerja: ' + context.parsed.y + ' / 100';
                                }
                            }
                        }
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

    document.addEventListener('DOMContentLoaded', () => {
        // Sidebar mobile toggle
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

        // Render/resize charts jika elemen canvas Kinerja ditemukan
        if (document.getElementById('chartRadarKinerja')) {
            setTimeout(renderKinerjaCharts, 60);
        }

        // Live Clock WITA (Sinkronkan juga jam modal presensi)
        function updateClock() {
            const now = new Date();
            const witaTime = new Date(now.toLocaleString('en-US', { timeZone: 'Asia/Makassar' }));
            const hours = String(witaTime.getHours()).padStart(2, '0');
            const minutes = String(witaTime.getMinutes()).padStart(2, '0');
            const seconds = String(witaTime.getSeconds()).padStart(2, '0');
            const timeString = `${hours}:${minutes}:${seconds}`;

            const clockEl = document.getElementById('liveClock');
            if (clockEl) clockEl.textContent = timeString;

            const modalClock = document.getElementById('modalLiveClock');
            if (modalClock) modalClock.textContent = `${timeString} WITA`;
        }
        setInterval(updateClock, 1000);
        updateClock();

        // Search filter pada tabel kegiatan
        const searchKegiatan = document.getElementById('searchKegiatanInput');
        if (searchKegiatan) {
            searchKegiatan.addEventListener('keyup', function () {
                const val = this.value.toLowerCase();
                const rows = document.querySelectorAll('#tabelKegiatanBody tr');
                rows.forEach(r => {
                    const text = r.textContent.toLowerCase();
                    r.style.display = text.includes(val) ? '' : 'none';
                });
            });
        }
    });

    // Helper Modal Universal
    function openModal(id) {
        const el = document.getElementById(id);
        if (el) el.classList.remove('hidden');
    }

    function closeModal(id) {
        const el = document.getElementById(id);
        if (el) el.classList.add('hidden');
    }

    function openBuktiFotoModal(jam, jarak, status, fotoUrl) {
        document.getElementById('fotoModalJam').textContent = jam;
        document.getElementById('fotoModalJarak').textContent = jarak;
        document.getElementById('fotoModalStatus').textContent = status;
        document.getElementById('fotoModalImage').src = fotoUrl;
        document.getElementById('modalBuktiFoto').classList.remove('hidden');
    }

    function openFotoLaporanModal(kegiatan, fotoUrl) {
        document.getElementById('fotoLaporanModalKegiatan').textContent = kegiatan;
        document.getElementById('fotoLaporanModalImage').src = fotoUrl;
        document.getElementById('modalFotoLaporan').classList.remove('hidden');
    }

    // Database Lampiran untuk Pegawai
    const lampiranDatabasePegawai = {
        'cuti_tahunan': {
            tipe: 'sk_cuti',
            jenis: 'SK Cuti Tahunan',
            badge: 'SK Cuti Sah',
            judulDokumen: 'SURAT KEPUTUSAN PEMBERIAN CUTI TAHUNAN',
            nomorSurat: '800/DISPERDAGIN/SK-CUTI/035/VIII/2026',
            pegawai: 'Rani Ayu Pratiwi',
            nip: '19950620 202203 2 007',
            pangkat: 'Pengatur / II/c',
            jabatan: 'Staf PPPK / Petugas Pemantau Pasar',
            bidang: 'Perdagangan',
            tanggal: '18 – 19 Agustus 2026 (2 Hari Kerja)',
            alasan: 'Keperluan keluarga tahunan dan pemenuhan hak cuti resmi pegawai.',
            dasar: 'Surat Permohonan Cuti Tahunan Pegawai tertanggal 12 Agustus 2026 dan Peraturan Pemerintah Nomor 11 Tahun 2017 tentang Manajemen Kepegawaian ASN/PPPK.',
            pernyataan: 'MEMBERIKAN IZIN CUTI TAHUNAN KEPADA:',
            lokasi: '-',
            ketentuan: 'Hak cuti tahunan ini telah dipotongkan secara otomatis dari sisa kuota tahun berjalan dan pegawai wajib kembali bertugas setelah masa cuti selesai.',
            tanggalPengesahan: 'Pada tanggal 15 Agustus 2026',
            penandatangan: 'Drs. H. M. Dahlan, M.Si',
            nipPenandatangan: '19680512 199403 1 005',
            jabatanPenandatangan: 'Kepala Dinas Perdagangan dan Perindustrian Kota Gorontalo',
            namaFile: 'SK_Cuti_Tahunan_Rani_Ayu.pdf',
            ukuranFile: '248 KB'
        },
        'spt_bimtek': {
            tipe: 'spt_dinas',
            jenis: 'Surat Perintah Tugas (SPT)',
            badge: 'SPT Penugasan Sah',
            judulDokumen: 'SURAT PERINTAH TUGAS (SPT)',
            nomorSurat: '090/DISPERDAGIN/SPT-DL/231/IX/2026',
            pegawai: 'Rani Ayu Pratiwi',
            nip: '19950620 202203 2 007',
            pangkat: 'Pengatur / II/c',
            jabatan: 'Staf PPPK / Petugas Pemantau Pasar',
            bidang: 'Perdagangan',
            tanggal: '01 September 2026 (1 Hari Penuh)',
            alasan: 'Mengikuti Bimbingan Teknis Sistem Informasi Perdagangan Kemendag Wilayah Sulawesi Utara & Gorontalo.',
            dasar: 'Surat Undangan Kementerian Perdagangan RI dan Surat Perintah Kepala DISPERDAGIN Kota Gorontalo.',
            pernyataan: 'MEMERINTAHKAN KEPADA:',
            lokasi: 'Hotel Peninsula, Manado / Sentra Pelatihan Kemendag',
            ketentuan: 'Setelah selesai menjalankan tugas, yang bersangkutan wajib menyampaikan laporan tertulis pelaksanaan tugas kepada Kepala Dinas.',
            tanggalPengesahan: 'Pada tanggal 28 Agustus 2026',
            penandatangan: 'Drs. H. M. Dahlan, M.Si',
            nipPenandatangan: '19680512 199403 1 005',
            jabatanPenandatangan: 'Kepala Dinas Perdagangan dan Perindustrian Kota Gorontalo',
            namaFile: 'SPT_Bimtek_Kemendag_Rani.pdf',
            ukuranFile: '320 KB'
        },
        'spt_monitoring': {
            tipe: 'spt_dinas',
            jenis: 'Surat Perintah Tugas (SPT)',
            badge: 'SPT Penugasan Sah',
            judulDokumen: 'SURAT PERINTAH TUGAS (SPT)',
            nomorSurat: '090/DISPERDAGIN/SPT-DL/810/VIII/2026',
            pegawai: 'Rani Ayu Pratiwi',
            nip: '19950620 202203 2 007',
            pangkat: 'Pengatur / II/c',
            jabatan: 'Staf PPPK / Petugas Pemantau Pasar',
            bidang: 'Perdagangan',
            tanggal: '22 Agustus 2026 (1 Hari Penuh)',
            alasan: 'Monitoring Fluktuasi Harga Pasar Perdagangan Bersehati dan Pasar Sentral.',
            dasar: 'Program Pemantauan Pasokan dan Pengendalian Inflasi Pangan Kota Gorontalo 2026.',
            pernyataan: 'MEMERINTAHKAN KEPADA:',
            lokasi: 'Pasar Perdagangan Bersehati Kota Gorontalo',
            ketentuan: 'Melaksanakan tugas verifikasi harga pasar dan berkoordinasi dengan pengelola pasar setempat.',
            tanggalPengesahan: 'Pada tanggal 20 Agustus 2026',
            penandatangan: 'Drs. H. M. Dahlan, M.Si',
            nipPenandatangan: '19680512 199403 1 005',
            jabatanPenandatangan: 'Kepala Dinas Perdagangan dan Perindustrian Kota Gorontalo',
            namaFile: 'SPT_Monitoring_Harga_Rani.pdf',
            ukuranFile: '290 KB'
        }
    };

    let activePreviewLampiran = null;

    function openPreviewLampiranPegawai(key) {
        const data = lampiranDatabasePegawai[key];
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

    function unduhLampiranDokumen() {
        if (!activePreviewLampiran) return;
        alert(`Mengunduh Berkas Elektronik:\n• Berkas: ${activePreviewLampiran.namaFile}\n• Ukuran: ${activePreviewLampiran.ukuranFile}\n• Status: Berhasil diunduh dengan sertifikat digital sah.`);
    }

    function cetakLampiranDokumen() {
        window.print();
    }
</script>
