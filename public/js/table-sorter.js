/**
 * SIP-PERFORMA DISPERDAGIN
 * Universal Client-Side Table Sorter (Pengurutan Heading A-Z / Z-A)
 * Mengaktifkan interaktivitas pengurutan otomatis pada seluruh tabel Admin & Pegawai.
 * - Indikator selalu terlihat (Always Visible)
 * - Tanpa pergeseran tata letak (Zero Layout Shift)
 * - Mendukung sorting teks (A-Z), angka desimal, waktu, tanggal, dan username
 */

(function () {
    'use strict';

    // Daftar kata kunci kolom yang tidak boleh diurutkan (non-sortable)
    const NON_SORTABLE_KEYWORDS = [
        'aksi', 'action', 'foto', 'bukti', 'lampiran', 'dokumen', 
        'bukti selfie', 'unduh', 'download', 'pilih', 'select', 'checkbox'
    ];

    // Pemetaan nama bulan bahasa Indonesia
    const INDO_MONTHS = {
        'januari': 0, 'jan': 0,
        'februari': 1, 'feb': 1,
        'maret': 2, 'mar': 2,
        'april': 3, 'apr': 3,
        'mei': 4, 'may': 4,
        'juni': 5, 'jun': 5,
        'juli': 6, 'jul': 6,
        'agustus': 7, 'ags': 7, 'agu': 7, 'aug': 7,
        'september': 8, 'sep': 8,
        'oktober': 9, 'okt': 9, 'oct': 9,
        'november': 10, 'nov': 10,
        'desember': 11, 'des': 11, 'dec': 11
    };

    // SVG icon templates - Ukuran tetap presisi 14px x 14px (w-3.5 h-3.5) agar tidak ada pergeseran
    const ICONS = {
        // Default: Terlihat jelas dua arah (Up & Down) dengan warna slate-400
        default: `<svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 9l4-4 4 4m0 6l-4 4-4-4"/></svg>`,
        // Ascending (A-Z, 0-9): Panah atas warna biru terang sky-600
        asc: `<svg class="w-3.5 h-3.5 text-sky-600 font-bold shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7"/></svg>`,
        // Descending (Z-A, 9-0): Panah bawah warna biru terang sky-600
        desc: `<svg class="w-3.5 h-3.5 text-sky-600 font-bold shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>`
    };

    /**
     * Parse text dari cell ke tipe data komparasi yang sesuai
     */
    function parseCellValue(text) {
        if (!text) return { type: 'empty', value: '' };
        const clean = text.trim();
        if (clean === '-' || clean === '' || clean === 'Belum Hadir' || clean === 'Belum Pulang') {
            return { type: 'empty', value: '' };
        }

        // 1. Cek format Waktu (misal: "07:34 WITA", "16:15", "08:00")
        const timeMatch = clean.match(/^(\d{1,2})[:.](\d{2})(\s*[a-zA-Z]+)?$/);
        if (timeMatch) {
            const h = parseInt(timeMatch[1], 10);
            const m = parseInt(timeMatch[2], 10);
            return { type: 'number', value: h * 60 + m };
        }

        // Cek durasi kerja (misal: "09j 42m" atau "8 jam 15 menit")
        const durMatch = clean.match(/^(\d+)\s*[jJ]\w*\s*(\d+)?\s*[mM]?/);
        if (durMatch) {
            const hours = parseInt(durMatch[1], 10);
            const mins = durMatch[2] ? parseInt(durMatch[2], 10) : 0;
            return { type: 'number', value: hours * 60 + mins };
        }

        // 2. Cek format Tanggal
        // Format ISO YYYY-MM-DD
        if (/^\d{4}-\d{2}-\d{2}/.test(clean)) {
            const timestamp = Date.parse(clean);
            if (!isNaN(timestamp)) return { type: 'date', value: timestamp };
        }

        // Format DD/MM/YYYY atau DD-MM-YYYY
        const dmyMatch = clean.match(/^(\d{1,2})[\/\-](\d{1,2})[\/\-](\d{4})/);
        if (dmyMatch) {
            const d = parseInt(dmyMatch[1], 10);
            const m = parseInt(dmyMatch[2], 10) - 1;
            const y = parseInt(dmyMatch[3], 10);
            return { type: 'date', value: new Date(y, m, d).getTime() };
        }

        // Format Bahasa Indonesia: "Selasa, 17 November 2026", "16 Nov 2026 (Sen)", "17 November 2026"
        const indoDateMatch = clean.match(/(\d{1,2})\s+([a-zA-Z]+)\s+(\d{4})/);
        if (indoDateMatch) {
            const d = parseInt(indoDateMatch[1], 10);
            const monthStr = indoDateMatch[2].toLowerCase();
            const y = parseInt(indoDateMatch[3], 10);
            if (monthStr in INDO_MONTHS) {
                return { type: 'date', value: new Date(y, INDO_MONTHS[monthStr], d).getTime() };
            }
        }

        // 3. Cek format Angka / Numerik
        // Diawali emoji ranking atau nomor urut murni: "🥇 1", "🥈 2", "🥉 3", "#1", "1", "2"
        const rankMatch = clean.match(/^[🥇🥈🥉#]?\s*(\d+)\s*$/u);
        if (rankMatch) {
            return { type: 'number', value: parseInt(rankMatch[1], 10) };
        }

        // Angka murni atau angka bersatuan: "98.8", "100", "22.59 meter", "3 Hari", "10%", "3 Alpha", "10 Laporan"
        // Catatan: Jika diawali huruf (misal: "indriani.123", "user1", "ADM-001"), TIDAK masuk ke sini melainkan string!
        const startNumMatch = clean.match(/^([-+]?[0-9]+([.,][0-9]+)?)\s*([a-zA-Z%]+)?$/);
        if (startNumMatch && !clean.toLowerCase().includes('nip') && !clean.includes('/') && !clean.includes('@')) {
            const parsedFloat = parseFloat(startNumMatch[1].replace(',', '.'));
            if (!isNaN(parsedFloat)) {
                return { type: 'number', value: parsedFloat };
            }
        }

        // 4. Default: String / Teks (A-Z) - Mencakup Username akun, Nama, NIP, Bidang, Jabatan, Status
        return { type: 'string', value: clean.toLowerCase() };
    }

    /**
     * Dapatkan teks relevan dari suatu cell
     */
    function getCellContent(cell) {
        if (!cell) return '';
        // Prioritas 1: Jika cell memiliki data-sort-value eksplisit
        if (cell.hasAttribute('data-sort-value')) {
            return cell.getAttribute('data-sort-value');
        }
        // Prioritas 2: Jika cell memiliki nama utama p.font-bold di atas sub-teks NIP/email
        const pBold = cell.querySelector('p.font-bold, p.font-semibold, .font-bold');
        if (pBold && pBold.textContent.trim()) {
            return pBold.textContent.trim();
        }
        return cell.innerText || cell.textContent || '';
    }

    /**
     * Inisialisasi pengurutan pada satu tabel
     */
    function initTableSorter(table) {
        if (table.hasAttribute('data-sorter-initialized')) return;
        if (table.hasAttribute('data-no-sort')) return;

        const thead = table.querySelector('thead');
        const tbody = table.querySelector('tbody');
        if (!thead || !tbody) return;

        // Ambil header row terakhir di thead
        const headerRows = thead.querySelectorAll('tr');
        if (!headerRows.length) return;
        const lastHeaderRow = headerRows[headerRows.length - 1];
        const thList = Array.from(lastHeaderRow.querySelectorAll('th'));

        // Simpan urutan baris awal (original order)
        let originalRows = [];

        thList.forEach((th, colIndex) => {
            const rawText = th.textContent.trim().toLowerCase();

            // Cek apakah kolom ini dikecualikan
            const isExcluded = th.hasAttribute('data-no-sort') || 
                               NON_SORTABLE_KEYWORDS.some(kw => rawText === kw || rawText.includes(kw));

            if (isExcluded) return;

            // Dapatkan apakah kolom rata tengah
            const isCenter = th.classList.contains('text-center');
            const originalContent = th.innerHTML.trim();

            // Pastikan TH tidak patah baris (whitespace-nowrap) dan memiliki kursor pointer
            th.classList.add('sortable-th', 'cursor-pointer', 'select-none', 'transition-colors', 'whitespace-nowrap');
            th.setAttribute('title', `Klik untuk mengurutkan kolom "${th.textContent.trim()}" (A-Z / Z-A)`);

            // Bungkus konten TH dan Indikator Ikon dalam flex container presisi tanpa pergeseran
            th.innerHTML = `
                <span class="inline-flex items-center gap-1.5 ${isCenter ? 'justify-center' : 'justify-start'} pointer-events-none">
                    <span class="th-title-text">${originalContent}</span>
                    <span class="sort-indicator inline-flex items-center justify-center w-3.5 h-3.5 shrink-0">
                        ${ICONS.default}
                    </span>
                </span>
            `;

            const iconContainer = th.querySelector('.sort-indicator');

            // Event listener klik
            th.addEventListener('click', function () {
                // Catat baris data saat ini
                const currentDataRows = Array.from(tbody.querySelectorAll('tr')).filter(tr => {
                    if (tr.id && tr.id.toLowerCase().includes('empty')) return false;
                    const tds = tr.querySelectorAll('td');
                    if (!tds.length) return false;
                    if (tds.length === 1 && tds[0].hasAttribute('colspan')) return false;
                    return true;
                });

                if (!currentDataRows.length) return;

                // Simpan original order pertama kali
                if (!originalRows.length) {
                    originalRows = [...currentDataRows];
                }

                // Tentukan arah pengurutan saat ini: none -> asc -> desc -> none
                const currentSort = th.getAttribute('data-sort-direction') || 'none';
                let nextSort = 'asc';
                if (currentSort === 'asc') nextSort = 'desc';
                else if (currentSort === 'desc') nextSort = 'none';

                // Reset seluruh header lain di tabel yang sama
                thList.forEach(otherTh => {
                    otherTh.removeAttribute('data-sort-direction');
                    const otherIcon = otherTh.querySelector('.sort-indicator');
                    if (otherIcon) otherIcon.innerHTML = ICONS.default;
                    otherTh.classList.remove('text-sky-900', 'bg-sky-50/60');
                });

                if (nextSort === 'none') {
                    // Kembalikan ke urutan awal
                    originalRows.forEach(row => tbody.appendChild(row));
                    th.removeAttribute('data-sort-direction');
                    if (iconContainer) iconContainer.innerHTML = ICONS.default;
                    updateRowNumbers(tbody, thList);
                    return;
                }

                th.setAttribute('data-sort-direction', nextSort);
                if (iconContainer) {
                    iconContainer.innerHTML = nextSort === 'asc' ? ICONS.asc : ICONS.desc;
                }
                th.classList.add('text-sky-900', 'bg-sky-50/60');

                // Lakukan pengurutan
                currentDataRows.sort((rowA, rowB) => {
                    const cellsA = rowA.querySelectorAll('td');
                    const cellsB = rowB.querySelectorAll('td');

                    const cellA = cellsA[colIndex];
                    const cellB = cellsB[colIndex];

                    const textA = getCellContent(cellA);
                    const textB = getCellContent(cellB);

                    const parsedA = parseCellValue(textA);
                    const parsedB = parseCellValue(textB);

                    // Nilai kosong / dash ('-') selalu ditempatkan paling bawah
                    if (parsedA.type === 'empty' && parsedB.type !== 'empty') return 1;
                    if (parsedB.type === 'empty' && parsedA.type !== 'empty') return -1;
                    if (parsedA.type === 'empty' && parsedB.type === 'empty') return 0;

                    let cmp = 0;
                    if (parsedA.type === 'number' && parsedB.type === 'number') {
                        cmp = parsedA.value - parsedB.value;
                    } else if (parsedA.type === 'date' && parsedB.type === 'date') {
                        cmp = parsedA.value - parsedB.value;
                    } else {
                        // Perbandingan teks string (A-Z) dengan locale Indonesia & natural numeric
                        cmp = String(parsedA.value).localeCompare(String(parsedB.value), 'id', { numeric: true, sensitivity: 'base' });
                    }

                    return nextSort === 'asc' ? cmp : -cmp;
                });

                // Pasang kembali baris yang sudah diurutkan ke dalam DOM
                currentDataRows.forEach(row => tbody.appendChild(row));

                // Jika kolom pertama adalah nomor urut (NO), perbarui agar nomor tetap urut 1, 2, 3...
                updateRowNumbers(tbody, thList);
            });
        });

        table.setAttribute('data-sorter-initialized', 'true');
    }

    /**
     * Memperbarui nomor urut (NO) jika tabel memiliki kolom pertama bertajuk NO / No
     */
    function updateRowNumbers(tbody, thList) {
        if (!thList.length) return;
        const firstThText = thList[0].textContent.trim().toLowerCase();
        if (firstThText !== 'no' && firstThText !== 'no.' && firstThText !== 'rank') return;

        const rows = Array.from(tbody.querySelectorAll('tr')).filter(tr => {
            if (tr.id && tr.id.toLowerCase().includes('empty')) return false;
            const tds = tr.querySelectorAll('td');
            if (tds.length <= 1) return false;
            return true;
        });

        if (firstThText === 'no' || firstThText === 'no.') {
            rows.forEach((row, idx) => {
                const firstTd = row.querySelector('td');
                if (firstTd) {
                    const currentVal = firstTd.textContent.trim();
                    if (/^\d+$/.test(currentVal)) {
                        firstTd.textContent = idx + 1;
                    }
                }
            });
        }
    }

    /**
     * Jalankan sorter ke semua tabel di halaman
     */
    function initAllTables() {
        const tables = document.querySelectorAll('table');
        tables.forEach(table => {
            if (table.querySelector('thead') && table.querySelector('tbody')) {
                initTableSorter(table);
            }
        });
    }

    // Inisialisasi saat DOM siap
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initAllTables);
    } else {
        initAllTables();
    }

    // Ekspor fungsi ke global
    window.initTableSorter = initAllTables;

})();
