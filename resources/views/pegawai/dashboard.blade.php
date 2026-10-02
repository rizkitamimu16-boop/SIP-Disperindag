@extends('layouts.pegawai')

@section('title', 'Dashboard - Panel Pegawai')

@section('header_title', 'Selamat pagi, ' . (auth()->user()->name ?? 'Pegawai'))
@section('header_subtitle', 'Ringkasan kehadiran dan performa kerja Anda hari ini')

@section('content')
<!-- HERO BANNER DENGAN LIVE CLOCK & 4 AKSI CEPAT -->
<div
    class="bg-[#0D2240] text-white rounded-2xl sm:rounded-3xl p-6 sm:p-8 shadow-sm relative overflow-hidden mb-6">
    <div
        class="absolute inset-0 bg-[linear-gradient(to_right,rgba(255,255,255,0.03)_1px,transparent_1px),linear-gradient(to_bottom,rgba(255,255,255,0.03)_1px,transparent_1px)] bg-[size:28px_28px] pointer-events-none">
    </div>

    <div class="relative z-10 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
        <!-- Info Waktu -->
        <div>
            <div
                class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-white/10 text-xs font-semibold text-sky-200 mb-3 border border-white/10">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                <span>Waktu Server Presensi (WITA)</span>
            </div>
            <div class="flex items-baseline space-x-2">
                <div id="liveClock" class="text-3xl sm:text-5xl font-extrabold tracking-tight">07:42:15
                </div>
                <span class="text-sm sm:text-base font-semibold text-sky-200">WITA</span>
            </div>
            <p id="liveDate" class="text-xs sm:text-sm text-slate-300 mt-1">{{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, DD MMMM Y') }}</p>
            <p class="text-xs text-slate-400 mt-0.5">
                Masuk: {{ \Carbon\Carbon::parse($officeSettings->jam_masuk)->format('H:i') }} - {{ \Carbon\Carbon::parse($officeSettings->batas_terlambat)->format('H:i') }} (Toleransi) • 
                Batas Masuk: {{ \Carbon\Carbon::parse($officeSettings->batas_akhir_masuk)->format('H:i') }} • 
                Pulang: {{ \Carbon\Carbon::parse($officeSettings->jam_pulang)->format('H:i') }} - {{ \Carbon\Carbon::parse($officeSettings->batas_akhir_pulang)->format('H:i') }} 
                (Jumat: {{ \Carbon\Carbon::parse($officeSettings->jam_pulang_jumat)->format('H:i') }})
            </p>
        </div>

        <!-- 3 Tombol Aksi Cepat (Absen Datang, Absen Pulang, Laporan Kegiatan) -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-2.5 sm:gap-3 w-full lg:w-auto">
            <!-- Aksi 1: Absen Datang (Buka Modal Presensi Datang) -->
            <button type="button" onclick="openPresensiModal('masuk')"
                class="flex flex-col items-center justify-center p-3 sm:p-4 rounded-xl bg-emerald-500 hover:bg-emerald-600 text-white font-medium shadow-sm transition active:scale-98 cursor-pointer min-w-[125px]">
                <svg class="w-5 h-5 mb-1 text-white" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                </svg>
                <span class="text-xs sm:text-sm font-bold">Absen Datang</span>
                <span class="text-[10px] text-emerald-100 mt-0.5">{{ isset($todayAttendance->check_in) ? 'Tercatat ' . \Carbon\Carbon::parse($todayAttendance->check_in)->format('H:i') : 'Belum Absen' }}</span>
            </button>

            <!-- Aksi 2: Absen Pulang (Buka Modal Presensi Pulang) -->
            <button type="button" onclick="openPresensiModal('pulang')"
                class="flex flex-col items-center justify-center p-3 sm:p-4 rounded-xl bg-white/10 hover:bg-white/15 text-white font-medium border border-white/15 shadow-sm transition active:scale-98 cursor-pointer min-w-[125px]">
                <svg class="w-5 h-5 mb-1 text-slate-200" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                <span class="text-xs sm:text-sm font-bold">Absen Pulang</span>
                <span class="text-[10px] text-slate-300 mt-0.5">{{ isset($todayAttendance->jam_pulang) ? 'Tercatat ' . \Carbon\Carbon::parse($todayAttendance->jam_pulang)->format('H:i') : 'Pukul ' . \Carbon\Carbon::parse($officeSettings->jam_pulang)->format('H:i') }}</span>
            </button>

            <!-- Aksi 3: Laporan Kegiatan (Buka Modal Lapor Kegiatan) -->
            <button type="button" onclick="openKegiatanModal()"
                class="flex flex-col items-center justify-center p-3 sm:p-4 rounded-xl bg-white/10 hover:bg-white/15 text-white font-medium border border-white/15 shadow-sm transition active:scale-98 cursor-pointer min-w-[125px]">
                <svg class="w-5 h-5 mb-1 text-sky-300" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <span class="text-xs sm:text-sm font-bold">Laporan Kegiatan</span>
                <span class="text-[10px] text-sky-200 mt-0.5">{{ ($hasReportedToday ?? false) ? 'Sudah Lapor' : 'Wajib Harian' }}</span>
            </button>
        </div>
    </div>
</div>

<!-- 2 KARTU STATISTIK UTAMA PEGAWAI (KEHADIRAN & LAPORAN KEGIATAN) -->
<div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5 mb-6">
    <!-- Kartu 1: Kehadiran Bulan Ini (dengan Sub Terlambat & Izin) -->
    <div
        class="bg-white p-5 rounded-2xl border border-gray-200 shadow-xs hover:border-gray-300 transition flex flex-col justify-between">
        <div>
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Kehadiran
                    Bulan Ini</span>
                <div
                    class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-3 flex items-baseline space-x-2">
                <span class="text-3xl font-extrabold text-gray-900">{{ $attendancePercentage ?? '0%' }}</span>
                <span
                    class="text-xs font-semibold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-200">{{ $attendanceDelta ?? '0%' }}</span>
            </div>
            <p class="text-xs text-gray-500 mt-1">{{ $totalHadirBulanIni ?? 0 }} hadir dari {{ $totalHariKerjaBulanIni ?? 0 }} hari kerja aktif bulan berjalan</p>
        </div>
        <!-- Sub: Terlambat & Izin -->
        <div class="mt-4 pt-3 border-t border-gray-100 grid grid-cols-2 gap-2.5">
            <div
                class="flex items-center space-x-2.5 p-2.5 rounded-xl bg-amber-50/70 border border-amber-200/60">
                <div class="w-2.5 h-2.5 rounded-full bg-amber-500 shrink-0"></div>
                <div>
                    <span class="text-[11px] font-semibold text-amber-800">Terlambat</span>
                    <p class="text-xs font-bold text-amber-950">{{ $terlambatCount ?? 0 }} Kali <span
                            class="text-[10px] font-normal text-amber-700">({{ $terlambatMenit ?? 0 }} mnt)</span></p>
                </div>
            </div>
            <div
                class="flex items-center space-x-2.5 p-2.5 rounded-xl bg-sky-50/70 border border-sky-200/60">
                <div class="w-2.5 h-2.5 rounded-full bg-sky-500 shrink-0"></div>
                <div>
                    <span class="text-[11px] font-semibold text-sky-800">Izin / Sakit</span>
                    <p class="text-xs font-bold text-sky-950">{{ $izinSakitCount ?? 0 }} Hari</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Kartu 2: Laporan Kegiatan (Menggantikan Kepatuhan Waktu & Menghapus Sisa Hak Cuti) -->
    <div
        class="bg-white p-5 rounded-2xl border border-gray-200 shadow-xs hover:border-gray-300 transition flex flex-col justify-between">
        <div>
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Laporan
                    Kegiatan</span>
                <div class="w-9 h-9 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
            </div>
            <div class="mt-3 flex items-baseline space-x-2">
                <span class="text-3xl font-extrabold text-gray-900">{{ $totalLaporanKegiatan ?? 0 }} Hari</span>
                <span
                    class="text-xs font-semibold text-sky-600 bg-sky-50 px-2 py-0.5 rounded-full border border-sky-200">{{ $persenLaporan ?? '0%' }}
                    Lengkap</span>
            </div>
            <p class="text-xs text-gray-500 mt-1">Seluruh laporan tugas &amp; kegiatan harian
                terverifikasi pimpinan</p>
        </div>
        <!-- Sub: Status Harian & Verifikasi -->
        <div class="mt-4 pt-3 border-t border-gray-100 grid grid-cols-2 gap-2.5">
            <div
                class="flex items-center space-x-2.5 p-2.5 rounded-xl bg-emerald-50/70 border border-emerald-200/60">
                <div class="w-2.5 h-2.5 rounded-full bg-emerald-500 shrink-0"></div>
                <div>
                    <span class="text-[11px] font-semibold text-emerald-800">Hari Ini</span>
                    <p class="text-xs font-bold text-emerald-950">{{ ($hasReportedToday ?? false) ? 'Sudah Lapor' : 'Belum Lapor' }}</p>
                </div>
            </div>
            <div
                class="flex items-center space-x-2.5 p-2.5 rounded-xl bg-slate-50 border border-gray-200">
                <div class="w-2.5 h-2.5 rounded-full bg-slate-400 shrink-0"></div>
                <div>
                    <span class="text-[11px] font-semibold text-gray-700">Verifikasi</span>
                    <p class="text-xs font-bold text-gray-900">{{ $laporanTerverifikasiCount ?? 0 }} Disetujui</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- DUA PANEL KONTEN UTAMA: RIWAYAT TERBARU (KIRI) & PENGAJUAN DINAS LUAR (KANAN) -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <!-- Panel Kiri: Riwayat Absensi Terbaru (2 Kolom Lebar) -->
    <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-200 shadow-xs p-5 sm:p-6">
        <div class="flex items-center justify-between pb-4 border-b border-gray-100">
            <div>
                <h3 class="text-base font-bold text-gray-900">Riwayat Absensi Terbaru</h3>
                <p class="text-xs text-gray-500 mt-0.5">Catatan kehadiran 5 hari kerja terakhir</p>
            </div>
            <a href="{{ url('pegawai/absensi') }}"
                class="text-xs font-semibold text-[#0D2240] hover:text-sky-700 transition cursor-pointer">
                Lihat Semua
            </a>
        </div>

        <div class="mt-4 divide-y divide-gray-100">
            @forelse($recentAttendances ?? [] as $att)
                <div class="py-3.5 flex items-center justify-between">
                    <div class="flex items-center space-x-3.5">
                        <div
                            class="w-10 h-10 rounded-xl {{ ($att->status ?? '') == 'Terlambat' ? 'bg-amber-50 text-amber-600' : (($att->status ?? '') == 'Dinas Luar' ? 'bg-blue-50 text-blue-600' : 'bg-emerald-50 text-emerald-600') }} flex flex-col items-center justify-center shrink-0">
                            <span class="text-[10px] font-bold uppercase leading-tight">{{ \Carbon\Carbon::parse($att->tanggal ?? now())->locale('id')->isoFormat('ddd') }}</span>
                            <span class="text-sm font-extrabold leading-tight">{{ \Carbon\Carbon::parse($att->tanggal ?? now())->format('d') }}</span>
                        </div>
                        <div>
                            <p class="text-xs sm:text-sm font-bold text-gray-900">{{ \Carbon\Carbon::parse($att->tanggal ?? now())->locale('id')->isoFormat('dddd, DD MMMM Y') }}</p>
                            <p class="text-[11px] text-gray-500">
                                @if(($att->status ?? '') == 'Dinas Luar')
                                    Penugasan Dinas Luar (SPT)
                                @else
                                    Masuk: {{ !empty($att->jam_masuk) ? \Carbon\Carbon::parse($att->jam_masuk)->format('H:i') . ' WITA' : '-' }}
                                    @if(!empty($att->jam_pulang))
                                        • Keluar: {{ \Carbon\Carbon::parse($att->jam_pulang)->format('H:i') . ' WITA' }}
                                    @endif
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="text-right">
                        @if(($att->status ?? '') == 'Hadir')
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                Tepat Waktu
                            </span>
                        @elseif(($att->status ?? '') == 'Terlambat')
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                Terlambat
                            </span>
                        @elseif(($att->status ?? '') == 'Dinas Luar')
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200">
                                Dinas Luar (SPT)
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-50 text-slate-700 border border-slate-200">
                                {{ ucfirst($att->status ?? 'Alpha') }}
                            </span>
                        @endif
                        <p class="text-[11px] text-gray-400 mt-0.5">{{ ($att->status ?? '') == 'Dinas Luar' ? 'Disetujui' : (!empty($att->jam_pulang) ? 'Datang & Pulang' : 'Datang') }}</p>
                    </div>
                </div>
            @empty
                <div class="py-12 text-center text-gray-500">
                    <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <p class="text-xs font-medium text-gray-500">Belum ada riwayat kehadiran tercatat.</p>
                    <p class="text-[11px] text-gray-400 mt-0.5">Silakan lakukan presensi datang harian Anda.</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Panel Kanan: Ajukan Izin, Cuti, & Dinas (Diarahkan ke Nav Pengajuan) -->
    <div
        class="bg-white rounded-2xl border border-gray-200 shadow-xs p-5 sm:p-6 flex flex-col justify-between">
        <div>
            <div class="flex items-center justify-between pb-4 border-b border-gray-100">
                <div>
                    <h3 class="text-base font-bold text-gray-900">Pengajuan Pegawai</h3>
                    <p class="text-xs text-gray-500 mt-0.5">Ajukan izin sakit, cuti tahunan, atau dinas
                        luar</p>
                </div>

            </div>

            <!-- 3 Kartu Aksi: Ajukan Izin, Cuti, Dinas (Klik langsung diarahkan ke nav pengajuan) -->
            <div class="mt-4 space-y-3">
                <!-- 1. Ajukan Izin -->
                <a href="{{ url('pegawai/pengajuan') }}"
                    class="block group p-3.5 rounded-xl border border-amber-200 bg-amber-50/40 hover:bg-amber-50 hover:border-amber-300 hover:shadow-xs transition cursor-pointer flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div
                            class="w-10 h-10 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center shrink-0 group-hover:scale-105 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div>
                            <div class="flex items-center space-x-2">
                                <span
                                    class="text-xs font-bold text-gray-900 group-hover:text-amber-900 transition">Ajukan
                                    Izin</span>
                                <span
                                    class="text-[10px] font-semibold text-amber-800 bg-amber-100 px-2 py-0.5 rounded-full">Sakit
                                    &amp; Izin</span>
                            </div>
                            <p class="text-[11px] text-gray-600 mt-0.5">Dispensasi izin kerja &amp;
                                surat sakit dokter</p>
                        </div>
                    </div>
                    <span
                        class="text-xs font-bold text-amber-700 group-hover:translate-x-1 transition flex items-center">
                        Ajukan
                    </span>
                </a>

                <!-- 2. Ajukan Cuti -->
                <a href="{{ url('pegawai/pengajuan') }}"
                    class="block group p-3.5 rounded-xl border border-emerald-200 bg-emerald-50/40 hover:bg-emerald-50 hover:border-emerald-300 hover:shadow-xs transition cursor-pointer flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div
                            class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0 group-hover:scale-105 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <div class="flex items-center space-x-2">
                                <span
                                    class="text-xs font-bold text-gray-900 group-hover:text-emerald-900 transition">Ajukan
                                    Cuti</span>
                                <span
                                    class="text-[10px] font-semibold text-emerald-800 bg-emerald-100 px-2 py-0.5 rounded-full">Sisa
                                    {{ $sisaCuti ?? 12 }} Hari</span>
                            </div>
                            <p class="text-[11px] text-gray-600 mt-0.5">Permohonan resmi cuti tahunan
                                pegawai</p>
                        </div>
                    </div>
                    <span
                        class="text-xs font-bold text-emerald-700 group-hover:translate-x-1 transition flex items-center">
                        Ajukan
                    </span>
                </a>

                <!-- 3. Ajukan Dinas -->
                <a href="{{ url('pegawai/pengajuan') }}"
                    class="block group p-3.5 rounded-xl border border-blue-200 bg-blue-50/40 hover:bg-blue-50 hover:border-blue-300 hover:shadow-xs transition cursor-pointer flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div
                            class="w-10 h-10 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center shrink-0 group-hover:scale-105 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <div class="flex items-center space-x-2">
                                <span
                                    class="text-xs font-bold text-gray-900 group-hover:text-blue-900 transition">Ajukan
                                    Dinas</span>
                                <span
                                    class="text-[10px] font-semibold text-blue-800 bg-blue-100 px-2 py-0.5 rounded-full">SPT
                                    Luar</span>
                            </div>
                            <p class="text-[11px] text-gray-600 mt-0.5">Penugasan dinas &amp; workshop
                                luar kantor</p>
                        </div>
                    </div>
                    <span
                        class="text-xs font-bold text-blue-700 group-hover:translate-x-1 transition flex items-center">
                        Ajukan
                    </span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
