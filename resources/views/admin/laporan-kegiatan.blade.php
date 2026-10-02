@extends('layouts.admin')

@section('title', 'Laporan Kegiatan - Panel Administrator')

@section('header_title', 'Monitoring & Verifikasi Laporan Kegiatan Pegawai')
@section('header_subtitle', 'Evaluasi produktivitas kerja harian, uraian tugas, dan validasi bukti fisik staf PPPK')

@section('header_right')

    <div class="flex items-center space-x-3 bg-[#EEF2FF] px-3.5 py-1.5 rounded-2xl border border-emerald-100/80 shadow-2xs">
        <div class="flex flex-col text-right">
            <span class="text-xs font-bold text-[#1E1B4B] leading-tight">Administrator</span>
            <span class="text-[11px] text-emerald-600 font-medium">Sekretariat</span>
        </div>
        <div class="w-8 h-8 rounded-full bg-[#4F46E5] text-white font-bold text-xs flex items-center justify-center shadow-xs">
            AD
        </div>
    </div>
@endsection

@section('content')
<div class="space-y-6">



    <!-- 4 KPI CARDS RINGKASAN LAPORAN -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-xs">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">TOTAL LAPORAN</span>
                <div class="w-8 h-8 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
            </div>
            <div class="text-3xl font-extrabold text-gray-900 mt-2">{{ $totalLaporan ?? 0 }}</div>
            <p class="text-xs text-gray-500 mt-1">Laporan masuk periode ini</p>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-xs">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">TERVERIFIKASI</span>
                <div
                    class="w-8 h-8 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
            </div>
            <div class="text-3xl font-extrabold text-emerald-600 mt-2">{{ $terverifikasi ?? 0 }}</div>
            <p class="text-xs text-gray-500 mt-1">Laporan telah dinilai kualitasnya</p>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-xs">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">MENUNGGU REVIEW</span>
                <div
                    class="w-8 h-8 rounded-full bg-amber-50 text-amber-600 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        stroke-width="2">
                        <circle cx="12" cy="12" r="10" />
                        <polyline points="12 6 12 12 16 14" />
                    </svg>
                </div>
            </div>
            <div class="text-3xl font-extrabold text-amber-600 mt-2">{{ $menungguReview ?? 0 }}</div>
            <p class="text-xs text-gray-500 mt-1">Menunggu penilaian kualitas admin</p>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-xs">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">RATA-RATA PRODUKTIVITAS</span>
                <div
                    class="w-8 h-8 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                </div>
            </div>
            <div class="text-3xl font-extrabold text-emerald-600 mt-2">{{ $avgProduktivitas ?? '0.0' }}</div>
            <p class="text-xs text-gray-500 mt-1">Skor rata-rata otomatis sistem</p>
        </div>
    </div>

    <!-- SECTION DUA GRAFIK VISUALISASI KEGIATAN -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-stretch">

        <!-- Grafik 1: Distribusi Laporan per Bidang (7 Cols) -->
        <div
            class="lg:col-span-7 bg-white p-6 rounded-2xl border border-gray-200 shadow-2xs flex flex-col justify-between">
            <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                <div>
                    <h3 class="text-sm sm:text-base font-bold text-gray-900">Distribusi Laporan per Bidang
                        Kerja</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Jumlah aktivitas kerja terlapor per bidang di
                        DISPERDAGIN</p>
                </div>
                <span
                    class="text-xs font-semibold px-2.5 py-1 bg-slate-100 text-slate-700 rounded-lg">September
                    2026</span>
            </div>
            <div class="h-64 sm:h-72 w-full mt-4">
                <canvas id="chartLaporanBidang"></canvas>
            </div>
        </div>

        <!-- Grafik 2: Tren Pengumpulan Laporan Harian (5 Cols) -->
        <div
            class="lg:col-span-5 bg-white p-6 rounded-2xl border border-gray-200 shadow-2xs flex flex-col justify-between">
            <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                <div>
                    <h3 class="text-sm sm:text-base font-bold text-gray-900">Tren Pengumpulan Harian</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Volume laporan masuk dalam 7 hari terakhir</p>
                </div>
                <span
                    class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-200">Live
                    7 Hari</span>
            </div>
            <div class="h-64 sm:h-72 w-full mt-4">
                <canvas id="chartLaporanTren"></canvas>
            </div>
        </div>

    </div>

    <!-- KARTU FILTER DATA LAPORAN KEGIATAN -->
    <div class="bg-white p-5 sm:p-6 rounded-2xl border border-gray-200 shadow-2xs">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h3 class="text-base font-bold text-gray-900">Filter Data Laporan Kegiatan</h3>
                <p class="text-xs text-gray-500 mt-0.5">Terapkan filter pencarian, bidang, dan periode untuk menyaring data</p>
            </div>
            <div class="flex items-center space-x-3">
                <button type="button" onclick="resetFilterKegiatan()" title="Reset Filter"
                    class="w-10 h-10 shrink-0 bg-white hover:bg-slate-50 border border-gray-200 rounded-xl text-gray-500 hover:text-gray-700 shadow-2xs transition flex items-center justify-center cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                </button>
                <button type="button"
                    onclick="alert('Rekap seluruh laporan kegiatan berhasil di-export ke format Excel (.xlsx)!')"
                    class="h-10 px-4 bg-[#0D2240] hover:bg-[#163660] text-white rounded-xl text-xs font-bold shadow-xs transition flex items-center space-x-2 cursor-pointer">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    <span>Export Data</span>
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 mt-4">

            <!-- 1. Search Nama & Kegiatan -->
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </div>
                <input type="text" id="filterKegiatanSearch"
                    placeholder="Cari nama atau kegiatan..."
                    oninput="applyKegiatanFilter()"
                    class="w-full h-10 pl-10 pr-4 text-xs sm:text-sm bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#0D2240]/20 focus:border-[#0D2240] text-gray-700 placeholder-gray-400 transition">
            </div>

            <!-- 2. Dropdown Bidang -->
            <div class="relative">
                <select id="filterKegiatanBidang"
                    class="w-full h-10 px-3.5 pr-8 text-xs sm:text-sm bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#0D2240]/20 focus:border-[#0D2240] text-gray-700 transition cursor-pointer appearance-none">
                    <option value="Semua Bidang">Semua Bidang</option>
                    <option value="Sekretariat">Sekretariat</option>
                    <option value="Perdagangan">Perdagangan</option>
                    <option value="Perindustrian">Perindustrian</option>
                    <option value="Perlindungan Konsumen">Perlindungan Konsumen</option>
                </select>
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </div>
            </div>

            <!-- 3. Filter Tanggal Spesifik -->
            <div class="relative">
                <input type="date" id="filterKegiatanTanggal"
                    class="w-full h-10 px-3.5 text-xs sm:text-sm bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#0D2240]/20 focus:border-[#0D2240] text-gray-700 transition cursor-pointer">
            </div>

            <!-- 4. Dropdown Bulan -->
            <div class="relative">
                <select id="filterKegiatanBulan"
                    class="w-full h-10 px-3.5 pr-8 text-xs bg-slate-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#0D2240]/20 text-gray-700 transition cursor-pointer appearance-none">
                    <option value="Semua Bulan">Semua Bulan</option>
                    <option value="01">Januari</option>
                    <option value="02">Februari</option>
                    <option value="03">Maret</option>
                    <option value="04">April</option>
                    <option value="05">Mei</option>
                    <option value="06">Juni</option>
                    <option value="07">Juli</option>
                    <option value="08">Agustus</option>
                    <option value="09" selected>September</option>
                    <option value="10">Oktober</option>
                    <option value="11">November</option>
                    <option value="12">Desember</option>
                </select>
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                    <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </div>
            </div>

            <!-- 5. Dropdown Tahun -->
            <div class="relative">
                <select id="filterKegiatanTahun"
                    class="w-full h-10 px-3.5 pr-8 text-xs bg-slate-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#0D2240]/20 text-gray-700 transition cursor-pointer appearance-none">
                    <option value="Semua Tahun">Semua Tahun</option>
                    <option value="2026" selected>Tahun 2026</option>
                    <option value="2025">Tahun 2025</option>
                </select>
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                    <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </div>
            </div>

            <!-- 6. Dropdown Status Verifikasi -->
            <div class="relative">
                <select id="filterKegiatanStatus"
                    class="w-full h-10 px-3.5 pr-8 text-xs bg-slate-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#0D2240]/20 text-gray-700 transition cursor-pointer appearance-none">
                    <option value="Semua Status">Semua Status Verifikasi</option>
                    <option value="Terverifikasi">Terverifikasi</option>
                    <option value="Menunggu Review">Menunggu Review</option>
                </select>
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                    <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </div>
            </div>

        </div>

        <!-- Indikator Filter Aktif -->
        <div class="flex items-center space-x-2 mt-3.5 text-xs text-slate-500">
            <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor"
                viewBox="0 0 24 24" stroke-width="2">
                <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
            </svg>
            <span id="filterKegiatanActiveLabel" class="text-slate-500 font-medium">Filter aktif: semua
                bidang • September 2026</span>
        </div>
    </div>

    <!-- KARTU TABEL REKAP LAPORAN KEGIATAN -->
    <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-2xs">
        <div class="flex items-center justify-between pb-4 border-b border-gray-100">
            <div>
                <h3 class="text-base font-bold text-gray-900">Daftar Laporan Pelaksanaan Tugas Harian</h3>
                <p class="text-xs text-gray-500 mt-0.5">Merupakan sumber data produktivitas dan bukti verifikasi untuk penilaian kualitas kerja.</p>
            </div>
            <span class="text-xs font-semibold px-2.5 py-1 bg-slate-100 text-slate-700 rounded-lg"
                id="totalKegiatanFiltered">Menampilkan {{ isset($activityReports) ? count($activityReports) : 0 }} laporan</span>
        </div>

        <div class="overflow-x-auto mt-4">
            <table class="w-full text-left text-xs sm:text-sm">
                <thead class="bg-slate-50 text-gray-600 font-semibold border-b border-gray-200">
                    <tr>
                        <th class="py-3 px-3">Pegawai</th>
                        <th class="py-3 px-3">Tanggal</th>
                        <th class="py-3 px-3">Nama Kegiatan</th>
                        <th class="py-3 px-3">Deskripsi</th>
                        <th class="py-3 px-3 text-center">Foto</th>
                        <th class="py-3 px-3 text-center">Produktivitas</th>
                        <th class="py-3 px-3 text-center">Kualitas</th>
                        <th class="py-3 px-3 text-center">Status</th>
                        <th class="py-3 px-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-gray-700" id="tabelKegiatanBody">
                    @forelse($activityReports ?? [] as $rep)
                    <tr class="kegiatan-data-row hover:bg-slate-50/70 transition"
                        data-nama="{{ $rep->pegawai->nama ?? '-' }}"
                        data-bidang="{{ $rep->pegawai->bidang ?? '-' }}"
                        data-kegiatan="{{ $rep->nama_kegiatan }}"
                        data-tanggal="{{ $rep->tanggal ? date('Y-m-d', strtotime($rep->tanggal)) : '' }}"
                        data-bulan="{{ $rep->tanggal ? date('m', strtotime($rep->tanggal)) : '' }}"
                        data-tahun="{{ $rep->tanggal ? date('Y', strtotime($rep->tanggal)) : '' }}"
                        data-status="{{ $rep->status_verifikasi }}">
                        <td class="py-3.5 px-3">
                            <p class="font-bold text-gray-900">{{ $rep->pegawai->nama ?? '-' }}</p>
                            <span class="text-[11px] text-gray-400">NIP {{ $rep->pegawai->nip ?? '-' }}</span>
                        </td>
                        <td class="py-3.5 px-3 text-gray-600 font-mono text-xs">{{ $rep->tanggal ? \Carbon\Carbon::parse($rep->tanggal)->locale('id')->translatedFormat('l, d F Y') : '-' }}</td>
                        <td class="py-3.5 px-3 font-bold text-gray-900">{{ $rep->nama_kegiatan }}</td>
                        <td class="py-3.5 px-3 text-gray-600">
                            <div class="max-h-24 overflow-y-auto whitespace-pre-wrap pr-2">{{ $rep->deskripsi }}</div>
                        </td>
                        <td class="py-3.5 px-3 text-center">
                            @if(!empty($rep->foto))
                            <button type="button" onclick="openFotoLaporanModal('{{ $rep->pegawai->nama ?? '-' }}', '{{ $rep->nama_kegiatan }}', '{{ asset('storage/' . $rep->foto) }}')" class="inline-flex items-center space-x-1 text-xs font-semibold text-sky-600 hover:text-sky-800 cursor-pointer">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                </svg>
                                <span>Foto</span>
                            </button>
                            @else
                            <span class="text-xs text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="py-3.5 px-3 text-center">
                            <div class="font-bold text-gray-900 text-sm">{{ $rep->nilai_produktivitas ?? '-' }}</div>
                            <div class="text-[10px] text-emerald-600 font-semibold">{{ $rep->kategori_produktivitas ?? '' }}</div>
                        </td>
                        <td class="py-3.5 px-3 text-center">
                            <div class="font-bold {{ $rep->nilai_kualitas ? 'text-gray-900' : 'text-gray-400' }} text-sm">{{ $rep->nilai_kualitas ?? '-' }}</div>
                            <div class="text-[10px] text-blue-600 font-semibold">{{ $rep->kategori_kualitas ?? '' }}</div>
                        </td>
                        <td class="py-3.5 px-3 text-center">
                            @if(strtolower($rep->status_verifikasi) == 'menunggu review')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full bg-amber-100 text-amber-800 text-xs font-semibold">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 mr-1.5 animate-pulse"></span>
                                    Menunggu Review
                                </span>
                            @elseif(strtolower($rep->status_verifikasi) == 'ditolak')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full bg-red-100 text-red-800 text-xs font-semibold">
                                    Ditolak
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-800 text-xs font-semibold">
                                    Disetujui
                                </span>
                            @endif
                        </td>
                        <td class="py-3.5 px-3 text-center">
                            <button type="button" 
                                data-id="{{ $rep->id }}"
                                data-nama="{{ $rep->pegawai->nama ?? '-' }}"
                                data-kegiatan="{{ $rep->nama_kegiatan }}"
                                data-tanggal="{{ $rep->tanggal }}"
                                data-foto="{{ $rep->foto }}"
                                data-uraian="{{ $rep->deskripsi }}"
                                data-status="{{ $rep->status_verifikasi }}"
                                data-prod="{{ $rep->nilai_produktivitas ?? 0 }}"
                                data-kual="{{ $rep->nilai_kualitas ?? '' }}"
                                onclick="openReviewKegiatanModal(this)"
                                class="px-3 py-1 bg-sky-600 hover:bg-sky-700 text-white rounded-lg text-xs font-bold transition shadow-2xs cursor-pointer">
                                Detail/Nilai
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="py-12 text-center text-gray-500">
                            <div class="flex flex-col items-center justify-center space-y-2">
                                <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <p class="text-sm font-bold text-gray-700">Belum Ada Laporan Kegiatan</p>
                                <p class="text-xs text-gray-400">Laporan aktivitas tugas harian pegawai PPPK akan ditampilkan di sini.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse

                    <!-- Empty State Row -->
                    <tr id="emptyKegiatanRow" style="display: none;">
                        <td colspan="9" class="py-12 text-center text-gray-400">
                            <div class="flex flex-col items-center justify-center space-y-2">
                                <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" stroke-width="2">
                                    <circle cx="11" cy="11" r="8"></circle>
                                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                </svg>
                                <p class="text-sm font-semibold text-gray-600">Tidak ada laporan kegiatan
                                    yang sesuai kriteria filter</p>
                                <p class="text-xs text-gray-400">Coba ubah kata kunci pencarian, bidang,
                                    atau periode tanggal.</p>
                            </div>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>

</div>

<script>
    window.chartDataKegiatan = {
        bidangMasuk: {{ json_encode(array_column($chartBidang ?? [], 'masuk')) }},
        bidangTerverifikasi: {{ json_encode(array_column($chartBidang ?? [], 'terverifikasi')) }},
        trenLabels: {!! json_encode($chartTrenLabels ?? []) !!},
        trenData: {{ json_encode($chartTrenData ?? []) }}
    };
</script>
@endsection
