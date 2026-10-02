@extends('layouts.admin')

@section('title', 'Pusat Laporan - Panel Administrator')

@section('header_title', 'Pusat Rekapitulasi Laporan')
@section('header_subtitle', 'Pilih format laporan absensi dan kinerja resmi untuk arsip dinas')

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
    <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-2xs">
        <h2 class="text-lg font-bold text-gray-900 mb-1">Pusat Rekapitulasi &amp; Ekspor Laporan</h2>
        <p class="text-xs text-gray-500 mb-6">Pilih jenis laporan untuk memfilter, melihat preview, dan mengekspor data resmi dinas</p>

        <!-- Tabs Navigasi Laporan -->
        <div class="flex overflow-x-auto border-b border-gray-200 mb-6 custom-scrollbar gap-2">
            <button type="button" onclick="openReportTab('tab-absensi')" id="btn-tab-absensi" class="report-tab-btn active px-4 py-3 text-sm font-bold text-[#0D2240] border-b-2 border-[#0D2240] whitespace-nowrap transition cursor-pointer">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    Laporan Absensi
                </div>
            </button>
            <button type="button" onclick="openReportTab('tab-kinerja')" id="btn-tab-kinerja" class="report-tab-btn px-4 py-3 text-sm font-medium text-gray-500 border-b-2 border-transparent hover:text-gray-700 hover:border-gray-300 whitespace-nowrap transition cursor-pointer">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                    Laporan Kinerja
                </div>
            </button>
            <button type="button" onclick="openReportTab('tab-kegiatan')" id="btn-tab-kegiatan" class="report-tab-btn px-4 py-3 text-sm font-medium text-gray-500 border-b-2 border-transparent hover:text-gray-700 hover:border-gray-300 whitespace-nowrap transition cursor-pointer">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    Laporan Kegiatan
                </div>
            </button>
            <button type="button" onclick="openReportTab('tab-sp')" id="btn-tab-sp" class="report-tab-btn px-4 py-3 text-sm font-medium text-gray-500 border-b-2 border-transparent hover:text-gray-700 hover:border-gray-300 whitespace-nowrap transition cursor-pointer">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    Laporan SP
                </div>
            </button>
        </div>
        
        <form id="reportForm" method="GET" action="{{ route('admin.pusat-laporan') }}">
            <input type="hidden" name="tab" id="activeTabInput" value="{{ $activeTab ?? 'absensi' }}">

        <!-- ==============================
             TAB: LAPORAN ABSENSI 
             ============================== -->
        <div id="tab-absensi" class="report-tab-content {{ ($activeTab ?? 'absensi') === 'absensi' ? 'block' : 'hidden' }} animate-[fadeInUp_0.3s_ease-out]">
            <div class="mb-6 bg-gray-50 p-5 rounded-2xl border border-gray-200">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 items-start">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Periode Filter</label>
                        <select id="filter-periode-absensi" onchange="toggleFilterType('absensi')" class="w-full text-sm border border-gray-300 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#0D2240] focus:border-transparent cursor-pointer">
                            <option value="harian">Harian</option>
                            <option value="bulanan" selected>Bulanan</option>
                            <option value="tahunan">Tahunan</option>
                            <option value="rentang">Rentang Waktu</option>
                        </select>
                    </div>
                    <div id="input-waktu-absensi">
                        <label class="block text-xs font-bold text-gray-700 mb-1">Bulan</label>
                        <input type="month" name="month_absensi" value="{{ request('month_absensi', \Carbon\Carbon::now()->format('Y-m')) }}" onchange="document.getElementById('reportForm').submit()" class="w-full text-sm border border-gray-300 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#0D2240] focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Unit Kerja / Bidang</label>
                        <select name="bidang_absensi" onchange="document.getElementById('reportForm').submit()" class="w-full text-sm border border-gray-300 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#0D2240] focus:border-transparent cursor-pointer">
                            <option value="">Semua Bidang</option>
                            <option value="Perindustrian" {{ request('bidang_absensi') == 'Perindustrian' ? 'selected' : '' }}>Perindustrian</option>
                            <option value="Perdagangan" {{ request('bidang_absensi') == 'Perdagangan' ? 'selected' : '' }}>Perdagangan</option>
                            <option value="Sekretariat" {{ request('bidang_absensi') == 'Sekretariat' ? 'selected' : '' }}>Sekretariat</option>
                            <option value="Perlindungan Konsumen" {{ request('bidang_absensi') == 'Perlindungan Konsumen' ? 'selected' : '' }}>Perlindungan Konsumen</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Status Kehadiran</label>
                        <select name="status_absensi" onchange="document.getElementById('reportForm').submit()" class="w-full text-sm border border-gray-300 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#0D2240] focus:border-transparent cursor-pointer">
                            <option value="">Semua Status</option>
                            <option value="hadir" {{ request('status_absensi') == 'hadir' ? 'selected' : '' }}>Hadir</option>
                            <option value="terlambat" {{ request('status_absensi') == 'terlambat' ? 'selected' : '' }}>Terlambat</option>
                            <option value="alpha" {{ request('status_absensi') == 'alpha' ? 'selected' : '' }}>Alpha</option>
                            <option value="izin" {{ request('status_absensi') == 'izin' ? 'selected' : '' }}>Izin</option>
                            <option value="cuti" {{ request('status_absensi') == 'cuti' ? 'selected' : '' }}>Cuti</option>
                            <option value="sakit" {{ request('status_absensi') == 'sakit' ? 'selected' : '' }}>Sakit</option>
                            <option value="dinas_luar" {{ request('status_absensi') == 'dinas_luar' ? 'selected' : '' }}>Dinas Luar</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="border border-gray-200 rounded-xl bg-white overflow-hidden shadow-2xs">
                <div class="p-4 border-b border-gray-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white">
                    <div class="flex items-center gap-2">
                        <span class="text-sm text-gray-600">Tampilkan</span>
                        <select class="text-sm border border-gray-300 rounded-lg px-2 py-1.5 focus:outline-none focus:ring-2 focus:ring-[#0D2240] focus:border-transparent cursor-pointer">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="all">Semua</option>
                        </select>
                        <span class="text-sm text-gray-600">entri</span>
                    </div>
                    <div class="relative w-full sm:w-64">
                        <input type="text" placeholder="Cari nama, NIP, atau ID pegawai..."
                            class="w-full h-10 pl-9 pr-3 text-xs bg-slate-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-1 focus:ring-[#0D2240]">
                        <svg class="w-4 h-4 text-gray-400 absolute left-3 top-3 pointer-events-none" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" stroke-width="2">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                    </div>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left divide-y divide-gray-200 text-sm">
                        <thead class="bg-slate-50 text-gray-600 font-semibold border-b border-gray-200">
                            <tr>
                                <th class="px-4 py-3 text-left">No</th>
                                <th class="px-4 py-3 text-left">Nama Pegawai</th>
                                <th class="px-4 py-3 text-left">NIP</th>
                                <th class="px-4 py-3 text-left">Bidang</th>
                                <th class="px-4 py-3 text-left">Total Hadir</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse($attendanceReports ?? [] as $idx => $row)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-4 py-3 whitespace-nowrap text-gray-500">{{ $idx + 1 }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap font-bold text-gray-900">{{ $row->employee_name ?? '-' }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-gray-500">{{ $row->nip ?? '-' }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-gray-500">{{ $row->department ?? '-' }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap"><span class="px-2.5 py-1 bg-emerald-100 text-emerald-800 rounded-md font-bold text-xs">{{ $row->total_hadir ?? 0 }} Hari</span></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-12 text-center text-gray-400">
                                        <svg class="w-10 h-10 mx-auto text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                                        </svg>
                                        <p class="text-xs font-semibold text-gray-700">Belum ada data rekapitulasi absensi</p>
                                        <p class="text-[11px] text-gray-400 mt-0.5">Terapkan filter periode atau bidang untuk menampilkan data.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="p-4 border-t border-gray-200 flex flex-col sm:flex-row items-center justify-between gap-4 bg-gray-50">
                    <p class="text-sm text-gray-600 text-center sm:text-left">Menampilkan <span class="font-bold text-gray-900">1</span> hingga <span class="font-bold text-gray-900">10</span> dari <span class="font-bold text-gray-900">45</span> data pegawai</p>
                    <nav class="flex items-center space-x-1" aria-label="Pagination">
                        <button class="px-3 py-1.5 rounded-lg border border-gray-300 text-sm font-medium text-gray-400 hover:bg-gray-50 bg-white cursor-not-allowed" disabled>Sebelumnya</button>
                        <button class="px-3 py-1.5 rounded-lg border border-[#0D2240] text-sm font-bold text-white bg-[#0D2240] cursor-pointer">1</button>
                        <button class="px-3 py-1.5 rounded-lg border border-gray-300 text-sm font-medium text-gray-700 hover:bg-gray-50 bg-white transition cursor-pointer">2</button>
                        <button class="px-3 py-1.5 rounded-lg border border-gray-300 text-sm font-medium text-gray-700 hover:bg-gray-50 bg-white transition cursor-pointer">3</button>
                        <span class="px-2 py-1 text-gray-500">...</span>
                        <button class="px-3 py-1.5 rounded-lg border border-gray-300 text-sm font-medium text-gray-700 hover:bg-gray-50 bg-white transition cursor-pointer">Selanjutnya</button>
                    </nav>
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <a href="{{ route('admin.pusat-laporan.export', array_merge(request()->all(), ['format' => 'excel', 'tab' => 'absensi'])) }}" class="px-5 py-2.5 bg-emerald-600 text-white rounded-xl text-sm font-bold hover:bg-emerald-700 flex items-center gap-2 shadow-sm transition cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Ekspor Excel
                </a>
                <a href="{{ route('admin.pusat-laporan.export', array_merge(request()->all(), ['format' => 'pdf', 'tab' => 'absensi'])) }}" class="px-5 py-2.5 bg-red-600 text-white rounded-xl text-sm font-bold hover:bg-red-700 flex items-center gap-2 shadow-sm transition cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                    Ekspor PDF
                </a>
            </div>
        </div>

        <!-- ==============================
             TAB: LAPORAN KINERJA 
             ============================== -->
        <div id="tab-kinerja" class="report-tab-content {{ ($activeTab ?? 'absensi') === 'kinerja' ? 'block' : 'hidden' }} animate-[fadeInUp_0.3s_ease-out]">
            <div class="mb-6 bg-gray-50 p-5 rounded-2xl border border-gray-200">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 items-start">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Periode Filter</label>
                        <select id="filter-periode-kinerja" onchange="toggleFilterType('kinerja')" class="w-full text-sm border border-gray-300 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#0D2240] focus:border-transparent cursor-pointer">
                            <option value="harian">Harian</option>
                            <option value="bulanan" selected>Bulanan</option>
                            <option value="tahunan">Tahunan</option>
                            <option value="rentang">Rentang Waktu</option>
                        </select>
                    </div>
                    <div id="input-waktu-kinerja">
                        <label class="block text-xs font-bold text-gray-700 mb-1">Bulan</label>
                        <input type="month" name="month_kinerja" value="{{ request('month_kinerja', \Carbon\Carbon::now()->format('Y-m')) }}" onchange="document.getElementById('reportForm').submit()" class="w-full text-sm border border-gray-300 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#0D2240] focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Unit Kerja / Bidang</label>
                        <select name="bidang_kinerja" onchange="document.getElementById('reportForm').submit()" class="w-full text-sm border border-gray-300 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#0D2240] focus:border-transparent cursor-pointer">
                            <option value="">Semua Bidang</option>
                            <option value="Perindustrian" {{ request('bidang_kinerja') == 'Perindustrian' ? 'selected' : '' }}>Perindustrian</option>
                            <option value="Perdagangan" {{ request('bidang_kinerja') == 'Perdagangan' ? 'selected' : '' }}>Perdagangan</option>
                            <option value="Sekretariat" {{ request('bidang_kinerja') == 'Sekretariat' ? 'selected' : '' }}>Sekretariat</option>
                            <option value="Perlindungan Konsumen" {{ request('bidang_kinerja') == 'Perlindungan Konsumen' ? 'selected' : '' }}>Perlindungan Konsumen</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Kategori Predikat</label>
                        <select name="kategori_kinerja" onchange="document.getElementById('reportForm').submit()" class="w-full text-sm border border-gray-300 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#0D2240] focus:border-transparent cursor-pointer">
                            <option value="">Semua Predikat</option>
                            <option value="sangat_baik" {{ request('kategori_kinerja') == 'sangat_baik' ? 'selected' : '' }}>Sangat Baik</option>
                            <option value="baik" {{ request('kategori_kinerja') == 'baik' ? 'selected' : '' }}>Baik</option>
                            <option value="cukup" {{ request('kategori_kinerja') == 'cukup' ? 'selected' : '' }}>Cukup</option>
                            <option value="kurang" {{ request('kategori_kinerja') == 'kurang' ? 'selected' : '' }}>Kurang</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="border border-gray-200 rounded-xl bg-white overflow-hidden shadow-2xs">
                <div class="p-4 border-b border-gray-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white">
                    <div class="flex items-center gap-2">
                        <span class="text-sm text-gray-600">Tampilkan</span>
                        <select class="text-sm border border-gray-300 rounded-lg px-2 py-1.5 focus:outline-none focus:ring-2 focus:ring-[#0D2240] focus:border-transparent cursor-pointer">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="all">Semua</option>
                        </select>
                        <span class="text-sm text-gray-600">entri</span>
                    </div>
                    <div class="relative w-full sm:w-64">
                        <input type="text" placeholder="Cari nama, NIP, atau ID pegawai..."
                            class="w-full h-10 pl-9 pr-3 text-xs bg-slate-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-1 focus:ring-[#0D2240]">
                        <svg class="w-4 h-4 text-gray-400 absolute left-3 top-3 pointer-events-none" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" stroke-width="2">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                    </div>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left divide-y divide-gray-200 text-sm">
                        <thead class="bg-slate-50 text-gray-600 font-semibold border-b border-gray-200">
                            <tr>
                                <th class="px-4 py-3 text-left">No</th>
                                <th class="px-4 py-3 text-left">Nama Pegawai</th>
                                <th class="px-4 py-3 text-left">Bidang</th>
                                <th class="px-4 py-3 text-left">Indeks SKPD</th>
                                <th class="px-4 py-3 text-left">Predikat</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse($performanceReports ?? [] as $idx => $row)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-4 py-3 whitespace-nowrap text-gray-500">{{ $idx + 1 }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap font-bold text-gray-900">{{ $row->employee_name ?? '-' }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-gray-500">{{ $row->department ?? '-' }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap font-bold text-gray-900">{{ number_format($row->ikp_score ?? 0, 1) }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span class="px-2.5 py-1 {{ ($row->ikp_score ?? 0) >= 90 ? 'bg-emerald-100 text-emerald-800' : (($row->ikp_score ?? 0) >= 80 ? 'bg-blue-100 text-blue-800' : (($row->ikp_score ?? 0) >= 70 ? 'bg-amber-100 text-amber-800' : 'bg-red-100 text-red-800')) }} rounded-md font-bold text-xs">
                                            {{ $row->predikat ?? 'Cukup' }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-12 text-center text-gray-400">
                                        <svg class="w-10 h-10 mx-auto text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                        </svg>
                                        <p class="text-xs font-semibold text-gray-700">Belum ada data rekapitulasi kinerja</p>
                                        <p class="text-[11px] text-gray-400 mt-0.5">Pilih periode atau terapkan filter untuk melihat peringkat pegawai.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="p-4 border-t border-gray-200 flex flex-col sm:flex-row items-center justify-between gap-4 bg-gray-50">
                    <p class="text-sm text-gray-600 text-center sm:text-left">Menampilkan <span class="font-bold text-gray-900">1</span> hingga <span class="font-bold text-gray-900">2</span> dari <span class="font-bold text-gray-900">2</span> data</p>
                    <nav class="flex items-center space-x-1" aria-label="Pagination">
                        <button class="px-3 py-1.5 rounded-lg border border-gray-300 text-sm font-medium text-gray-400 hover:bg-gray-50 bg-white cursor-not-allowed" disabled>Sebelumnya</button>
                        <button class="px-3 py-1.5 rounded-lg border border-[#0D2240] text-sm font-bold text-white bg-[#0D2240] cursor-pointer">1</button>
                        <button class="px-3 py-1.5 rounded-lg border border-gray-300 text-sm font-medium text-gray-400 hover:bg-gray-50 bg-white cursor-not-allowed" disabled>Selanjutnya</button>
                    </nav>
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <a href="{{ route('admin.pusat-laporan.export', array_merge(request()->all(), ['format' => 'excel', 'tab' => 'kinerja'])) }}" class="px-5 py-2.5 bg-emerald-600 text-white rounded-xl text-sm font-bold hover:bg-emerald-700 flex items-center gap-2 shadow-sm transition cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Ekspor Excel
                </a>
                <a href="{{ route('admin.pusat-laporan.export', array_merge(request()->all(), ['format' => 'pdf', 'tab' => 'kinerja'])) }}" class="px-5 py-2.5 bg-red-600 text-white rounded-xl text-sm font-bold hover:bg-red-700 flex items-center gap-2 shadow-sm transition cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                    Ekspor PDF
                </a>
            </div>
        </div>

        <!-- ==============================
             TAB: LAPORAN KEGIATAN
             ============================== -->
        <div id="tab-kegiatan" class="report-tab-content {{ ($activeTab ?? 'absensi') === 'kegiatan' ? 'block' : 'hidden' }} animate-[fadeInUp_0.3s_ease-out]">
            <div class="mb-6 bg-gray-50 p-5 rounded-2xl border border-gray-200">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 items-start">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Periode Filter</label>
                        <select id="filter-periode-kegiatan" onchange="toggleFilterType('kegiatan')" class="w-full text-sm border border-gray-300 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#0D2240] focus:border-transparent cursor-pointer">
                            <option value="harian" selected>Harian</option>
                            <option value="bulanan">Bulanan</option>
                            <option value="tahunan">Tahunan</option>
                            <option value="rentang">Rentang Waktu</option>
                        </select>
                    </div>
                    <div id="input-waktu-kegiatan">
                        <label class="block text-xs font-bold text-gray-700 mb-1">Tanggal</label>
                        <input type="date" name="date_kegiatan" value="{{ request('date_kegiatan', \Carbon\Carbon::today()->toDateString()) }}" onchange="document.getElementById('reportForm').submit()" class="w-full text-sm border border-gray-300 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#0D2240] focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Unit Kerja / Bidang</label>
                        <select name="bidang_kegiatan" onchange="document.getElementById('reportForm').submit()" class="w-full text-sm border border-gray-300 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#0D2240] focus:border-transparent cursor-pointer">
                            <option value="">Semua Bidang</option>
                            <option value="Perindustrian" {{ request('bidang_kegiatan') == 'Perindustrian' ? 'selected' : '' }}>Perindustrian</option>
                            <option value="Perdagangan" {{ request('bidang_kegiatan') == 'Perdagangan' ? 'selected' : '' }}>Perdagangan</option>
                            <option value="Sekretariat" {{ request('bidang_kegiatan') == 'Sekretariat' ? 'selected' : '' }}>Sekretariat</option>
                            <option value="Perlindungan Konsumen" {{ request('bidang_kegiatan') == 'Perlindungan Konsumen' ? 'selected' : '' }}>Perlindungan Konsumen</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Status Verifikasi</label>
                        <select name="status_kegiatan" onchange="document.getElementById('reportForm').submit()" class="w-full text-sm border border-gray-300 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#0D2240] focus:border-transparent cursor-pointer">
                            <option value="">Semua Status</option>
                            <option value="disetujui" {{ request('status_kegiatan') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                            <option value="menunggu" {{ request('status_kegiatan') == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                            <option value="ditolak" {{ request('status_kegiatan') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="border border-gray-200 rounded-xl bg-white overflow-hidden shadow-2xs">
                <div class="p-4 border-b border-gray-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white">
                    <div class="flex items-center gap-2">
                        <span class="text-sm text-gray-600">Tampilkan</span>
                        <select class="text-sm border border-gray-300 rounded-lg px-2 py-1.5 focus:outline-none focus:ring-2 focus:ring-[#0D2240] focus:border-transparent cursor-pointer">
                            <option value="10">10</option>
                            <option value="25">25</option>
                        </select>
                        <span class="text-sm text-gray-600">entri</span>
                    </div>
                    <div class="relative w-full sm:w-64">
                        <input type="text" placeholder="Cari kegiatan atau nama..."
                            class="w-full h-10 pl-9 pr-3 text-xs bg-slate-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-1 focus:ring-[#0D2240]">
                        <svg class="w-4 h-4 text-gray-400 absolute left-3 top-3 pointer-events-none" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" stroke-width="2">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left divide-y divide-gray-200 text-sm">
                        <thead class="bg-slate-50 text-gray-600 font-semibold border-b border-gray-200">
                            <tr>
                                <th class="px-4 py-3 text-left">No</th>
                                <th class="px-4 py-3 text-left">Nama Pegawai</th>
                                <th class="px-4 py-3 text-left">Tanggal</th>
                                <th class="px-4 py-3 text-left w-1/3">Uraian Tugas</th>
                                <th class="px-4 py-3 text-left">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse($activityReports ?? [] as $idx => $row)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-4 py-3 whitespace-nowrap text-gray-500">{{ $idx + 1 }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap font-bold text-gray-900">{{ $row->employee_name ?? '-' }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-gray-500">{{ \Carbon\Carbon::parse($row->date ?? now())->locale('id')->isoFormat('DD MMM Y') }}</td>
                                    <td class="px-4 py-3 text-gray-500">{{ $row->activity_name ?? ($row->description ?? '-') }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span class="px-2.5 py-1 {{ ($row->status ?? '') == 'disetujui' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }} rounded-md font-bold text-xs">
                                            {{ ucfirst($row->status ?? 'menunggu') }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-12 text-center text-gray-400">
                                        <svg class="w-10 h-10 mx-auto text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                        </svg>
                                        <p class="text-xs font-semibold text-gray-700">Belum ada data rekapitulasi kegiatan</p>
                                        <p class="text-[11px] text-gray-400 mt-0.5">Terapkan filter periode atau bidang untuk menampilkan data.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-4 border-t border-gray-200 flex flex-col sm:flex-row items-center justify-between gap-4 bg-gray-50">
                    <p class="text-sm text-gray-600 text-center sm:text-left">Menampilkan <span class="font-bold text-gray-900">1</span> hingga <span class="font-bold text-gray-900">1</span> dari <span class="font-bold text-gray-900">1</span> data</p>
                    <nav class="flex items-center space-x-1" aria-label="Pagination">
                        <button class="px-3 py-1.5 rounded-lg border border-[#0D2240] text-sm font-bold text-white bg-[#0D2240] cursor-pointer">1</button>
                    </nav>
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <a href="{{ route('admin.pusat-laporan.export', array_merge(request()->all(), ['format' => 'excel', 'tab' => 'kegiatan'])) }}" class="px-5 py-2.5 bg-emerald-600 text-white rounded-xl text-sm font-bold hover:bg-emerald-700 flex items-center gap-2 shadow-sm transition cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Ekspor Excel
                </a>
                <a href="{{ route('admin.pusat-laporan.export', array_merge(request()->all(), ['format' => 'pdf', 'tab' => 'kegiatan'])) }}" class="px-5 py-2.5 bg-red-600 text-white rounded-xl text-sm font-bold hover:bg-red-700 flex items-center gap-2 shadow-sm transition cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                    Ekspor PDF
                </a>
            </div>
        </div>

        <!-- ==============================
             TAB: LAPORAN SP
             ============================== -->
        <div id="tab-sp" class="report-tab-content {{ ($activeTab ?? 'absensi') === 'sp' ? 'block' : 'hidden' }} animate-[fadeInUp_0.3s_ease-out]">
            <div class="mb-6 bg-gray-50 p-5 rounded-2xl border border-gray-200">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 items-start">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Periode Filter</label>
                        <select id="filter-periode-sp" onchange="toggleFilterType('sp')" class="w-full text-sm border border-gray-300 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#0D2240] focus:border-transparent cursor-pointer">
                            <option value="harian">Harian</option>
                            <option value="bulanan">Bulanan</option>
                            <option value="tahunan" selected>Tahunan</option>
                            <option value="rentang">Rentang Waktu</option>
                        </select>
                    </div>
                    <div id="input-waktu-sp">
                        <label class="block text-xs font-bold text-gray-700 mb-1">Tahun</label>
                        <select name="year_sp" onchange="document.getElementById('reportForm').submit()" class="w-full text-sm border border-gray-300 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#0D2240] focus:border-transparent cursor-pointer">
                            <option value="2026" {{ request('year_sp') == '2026' ? 'selected' : '' }}>2026</option>
                            <option value="2025" {{ request('year_sp') == '2025' ? 'selected' : '' }}>2025</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Unit Kerja / Bidang</label>
                        <select name="bidang_sp" onchange="document.getElementById('reportForm').submit()" class="w-full text-sm border border-gray-300 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#0D2240] focus:border-transparent cursor-pointer">
                            <option value="">Semua Bidang</option>
                            <option value="Perindustrian" {{ request('bidang_sp') == 'Perindustrian' ? 'selected' : '' }}>Perindustrian</option>
                            <option value="Perdagangan" {{ request('bidang_sp') == 'Perdagangan' ? 'selected' : '' }}>Perdagangan</option>
                            <option value="Sekretariat" {{ request('bidang_sp') == 'Sekretariat' ? 'selected' : '' }}>Sekretariat</option>
                            <option value="Perlindungan Konsumen" {{ request('bidang_sp') == 'Perlindungan Konsumen' ? 'selected' : '' }}>Perlindungan Konsumen</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Tingkat SP</label>
                        <select name="tingkat_sp" onchange="document.getElementById('reportForm').submit()" class="w-full text-sm border border-gray-300 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#0D2240] focus:border-transparent cursor-pointer">
                            <option value="">Semua SP</option>
                            <option value="sp1" {{ request('tingkat_sp') == 'sp1' ? 'selected' : '' }}>Surat Peringatan 1</option>
                            <option value="sp2" {{ request('tingkat_sp') == 'sp2' ? 'selected' : '' }}>Surat Peringatan 2</option>
                            <option value="sp3" {{ request('tingkat_sp') == 'sp3' ? 'selected' : '' }}>Surat Peringatan 3</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="border border-gray-200 rounded-xl bg-white overflow-hidden shadow-2xs">
                <div class="p-4 border-b border-gray-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white">
                    <div class="flex items-center gap-2">
                        <span class="text-sm text-gray-600">Tampilkan</span>
                        <select class="text-sm border border-gray-300 rounded-lg px-2 py-1.5 focus:outline-none focus:ring-2 focus:ring-[#0D2240] focus:border-transparent cursor-pointer">
                            <option value="10">10</option>
                            <option value="25">25</option>
                        </select>
                        <span class="text-sm text-gray-600">entri</span>
                    </div>
                    <div class="relative w-full sm:w-64">
                        <input type="text" placeholder="Cari nama atau No. SP..."
                            class="w-full h-10 pl-9 pr-3 text-xs bg-slate-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-1 focus:ring-[#0D2240]">
                        <svg class="w-4 h-4 text-gray-400 absolute left-3 top-3 pointer-events-none" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" stroke-width="2">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left divide-y divide-gray-200 text-sm">
                        <thead class="bg-slate-50 text-gray-600 font-semibold border-b border-gray-200">
                            <tr>
                                <th class="px-4 py-3 text-left">No</th>
                                <th class="px-4 py-3 text-left">Nama Pegawai</th>
                                <th class="px-4 py-3 text-left">Bidang</th>
                                <th class="px-4 py-3 text-left">Tingkat SP</th>
                                <th class="px-4 py-3 text-left">Nomor Surat</th>
                                <th class="px-4 py-3 text-left">Tanggal Terbit</th>
                                <th class="px-4 py-3 text-left">Status</th>
                                <th class="px-4 py-3 text-center">Dokumen SP</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse($spReports ?? [] as $idx => $row)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-4 py-3 whitespace-nowrap text-gray-500">{{ $idx + 1 }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <div class="font-bold text-gray-900">{{ $row->employee_name ?? '-' }}</div>
                                        <div class="text-[11px] text-gray-400">NIP: {{ $row->nip ?? '-' }}</div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-gray-600">{{ $row->department ?? '-' }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span class="px-2.5 py-1 {{ ($row->sp_level ?? '') == 'sp3' ? 'bg-red-100 text-red-800' : (($row->sp_level ?? '') == 'sp2' ? 'bg-orange-100 text-orange-800' : 'bg-amber-100 text-amber-800') }} rounded-md font-bold text-xs">
                                            {{ strtoupper($row->sp_level ?? 'SP 1') }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap font-mono text-xs font-semibold text-gray-800">{{ $row->letter_number ?? '-' }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-gray-500">{{ \Carbon\Carbon::parse($row->date_issued ?? now())->locale('id')->isoFormat('DD MMM Y') }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span class="px-2.5 py-1 bg-emerald-100 text-emerald-800 rounded-full font-bold text-xs">{{ $row->status ?? 'Terbit' }}</span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-center space-x-1.5">
                                        <button type="button" onclick="alert('Mengunduh dokumen Surat Peringatan (Format .docx)...')" class="px-2.5 py-1 bg-blue-50 text-blue-700 hover:bg-blue-100 rounded-lg text-xs font-semibold transition cursor-pointer">Word</button>
                                        <button type="button" onclick="alert('Mengunduh berkas Surat Peringatan resmi (.pdf)...')" class="px-2.5 py-1 bg-red-50 text-red-700 hover:bg-red-100 rounded-lg text-xs font-semibold transition cursor-pointer">PDF</button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-4 py-12 text-center text-gray-400">
                                        <svg class="w-10 h-10 mx-auto text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                        </svg>
                                        <p class="text-xs font-semibold text-gray-700">Belum ada data rekapitulasi Surat Peringatan</p>
                                        <p class="text-[11px] text-gray-400 mt-0.5">Tidak ditemukan penerbitan SP pada periode ini.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-4 border-t border-gray-200 flex flex-col sm:flex-row items-center justify-between gap-4 bg-gray-50">
                    <p class="text-sm text-gray-600 text-center sm:text-left">Menampilkan <span class="font-bold text-gray-900">1</span> hingga <span class="font-bold text-gray-900">2</span> dari <span class="font-bold text-gray-900">2</span> data</p>
                    <nav class="flex items-center space-x-1" aria-label="Pagination">
                        <button class="px-3 py-1.5 rounded-lg border border-[#0D2240] text-sm font-bold text-white bg-[#0D2240] cursor-pointer">1</button>
                    </nav>
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <a href="{{ route('admin.pusat-laporan.export', array_merge(request()->all(), ['format' => 'excel', 'tab' => 'sp'])) }}" class="px-5 py-2.5 bg-emerald-600 text-white rounded-xl text-sm font-bold hover:bg-emerald-700 flex items-center gap-2 shadow-sm transition cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Ekspor Excel
                </a>
                <a href="{{ route('admin.pusat-laporan.export', array_merge(request()->all(), ['format' => 'pdf', 'tab' => 'sp'])) }}" class="px-5 py-2.5 bg-red-600 text-white rounded-xl text-sm font-bold hover:bg-red-700 flex items-center gap-2 shadow-sm transition cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                    Ekspor PDF
                </a>
            </div>
        </div>
        </form>

        <!-- Script for Tab Logic & Filter Dynamics -->
        <script>
            function openReportTab(tabId) {
                document.querySelectorAll('.report-tab-content').forEach(el => {
                    el.classList.add('hidden');
                    el.classList.remove('block');
                });
                document.querySelectorAll('.report-tab-btn').forEach(el => {
                    el.classList.remove('active', 'text-[#0D2240]', 'border-[#0D2240]', 'font-bold');
                    el.classList.add('text-gray-500', 'border-transparent', 'font-medium');
                });
                
                document.getElementById(tabId).classList.remove('hidden');
                document.getElementById(tabId).classList.add('block');
                
                const activeBtn = document.getElementById('btn-' + tabId);
                if(activeBtn) {
                    activeBtn.classList.add('active', 'text-[#0D2240]', 'border-[#0D2240]', 'font-bold');
                    activeBtn.classList.remove('text-gray-500', 'border-transparent', 'font-medium');
                }
            }

            function toggleFilterType(tabName) {
                const selectElement = document.getElementById(`filter-periode-${tabName}`);
                const container = document.getElementById(`input-waktu-${tabName}`);
                const val = selectElement.value;
                
                let html = '';
                if (val === 'harian') {
                    html = `
                        <label class="block text-xs font-bold text-gray-700 mb-1">Rentang Tanggal</label>
                        <div class="flex items-center gap-2">
                            <input type="date" class="w-full text-sm border border-gray-300 rounded-lg px-2 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#0D2240] focus:border-transparent" title="Mulai">
                            <span class="text-gray-500 text-xs font-medium">s/d</span>
                            <input type="date" class="w-full text-sm border border-gray-300 rounded-lg px-2 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#0D2240] focus:border-transparent" title="Selesai">
                        </div>
                    `;
                } else if (val === 'bulanan') {
                    html = `
                        <label class="block text-xs font-bold text-gray-700 mb-1">Bulan</label>
                        <input type="month" class="w-full text-sm border border-gray-300 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#0D2240] focus:border-transparent">
                    `;
                } else if (val === 'tahunan') {
                    html = `
                        <label class="block text-xs font-bold text-gray-700 mb-1">Tahun</label>
                        <select class="w-full text-sm border border-gray-300 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#0D2240] focus:border-transparent cursor-pointer">
                            <option value="2026">2026</option>
                            <option value="2025">2025</option>
                            <option value="2024">2024</option>
                        </select>
                    `;
                } else if (val === 'rentang') {
                    html = `
                        <label class="block text-xs font-bold text-gray-700 mb-1">Rentang Tanggal</label>
                        <div class="flex items-center gap-2">
                            <input type="date" class="w-full text-sm border border-gray-300 rounded-lg px-2 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#0D2240] focus:border-transparent" title="Mulai">
                            <span class="text-gray-500 text-xs font-medium">s/d</span>
                            <input type="date" class="w-full text-sm border border-gray-300 rounded-lg px-2 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#0D2240] focus:border-transparent" title="Selesai">
                        </div>
                    `;
                }
                
                container.innerHTML = html;
            }
        </script>
    </div>
</div>

@endsection
