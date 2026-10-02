@extends('layouts.admin')

@section('title', 'Dashboard - Panel Administrator')

@section('header_title', 'Selamat pagi, Administrator')
@section('header_subtitle', 'Ringkasan sistem dan kehadiran hari ini')

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

    <!-- HERO BANNER (Sesuai Gambar Referensi) -->
    <div
        class="bg-[#0B2144] text-white rounded-2xl sm:rounded-3xl p-6 sm:p-7 shadow-sm relative overflow-hidden">
        <div
            class="absolute inset-0 bg-[linear-gradient(to_right,rgba(255,255,255,0.04)_1px,transparent_1px),linear-gradient(to_bottom,rgba(255,255,255,0.04)_1px,transparent_1px)] bg-[size:28px_28px] pointer-events-none">
        </div>

        <div class="relative z-10 grid grid-cols-1 lg:grid-cols-12 gap-6 items-center">
            <!-- Kiri: Tanggal, Live Clock & Badge Info -->
            <div class="lg:col-span-6 flex flex-col justify-center">
                <span id="heroDateUpper"
                    class="text-xs font-bold tracking-wider text-sky-200 uppercase">MINGGU, 6 SEPTEMBER
                    2026</span>
                <div class="flex items-baseline space-x-2 my-1">
                    <div id="liveClock"
                        class="text-3xl sm:text-5xl font-extrabold tracking-tight text-white">07:42:15</div>
                    <span class="text-sm sm:text-base font-semibold text-sky-200">WITA</span>
                </div>
                <div class="flex flex-wrap items-center gap-2 mt-2">
                    <div
                        class="inline-flex items-center space-x-1.5 px-3 py-1.5 rounded-xl bg-white/10 text-xs font-medium text-white border border-white/15">
                        <svg class="w-3.5 h-3.5 text-sky-300 shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span>Kantor DISPERDAGIN</span>
                    </div>
                    <div
                        class="inline-flex items-center space-x-1.5 px-3 py-1.5 rounded-xl bg-white/10 text-xs font-medium text-white border border-white/15">
                        <svg class="w-3.5 h-3.5 text-sky-300 shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" stroke-width="2">
                            <circle cx="12" cy="12" r="10" />
                            <polyline points="12 6 12 12 16 14" />
                        </svg>
                        <span>Jam kerja 08:00 – 16:00</span>
                    </div>
                </div>
            </div>

            <!-- Kanan: Box Portal Administrator -->
            <div
                class="lg:col-span-6 bg-white/10 backdrop-blur-xs rounded-2xl p-6 sm:p-7 border border-white/15 flex flex-col justify-center items-center text-center">
                <h3 class="text-lg sm:text-xl font-bold text-white tracking-tight">Portal Administrator</h3>
                <p class="text-xs sm:text-sm text-slate-200 mt-2 leading-relaxed max-w-md">
                    Kelola absensi, perizinan, dan laporan kegiatan seluruh pegawai DISPERDAGIN secara
                    terpusat.
                </p>
            </div>
        </div>
    </div>

    <!-- 4 KARTU METRIK STATISTIK (Sesuai Gambar Referensi) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">

        <!-- Kartu 1: TOTAL PEGAWAI -->
        <div
            class="bg-white p-5 rounded-[1.25rem] border border-gray-100 shadow-[0_2px_10px_-4px_rgba(0,0,0,0.05)] flex flex-col justify-between h-full hover:shadow-md transition-shadow duration-300">
            <div class="flex items-center justify-between mb-4">
                <span class="text-[11px] font-bold text-gray-500 uppercase tracking-wider">TOTAL PEGAWAI</span>
                <div class="flex items-center space-x-2.5">
                    <button type="button" onclick="showInfoModal('total')"
                        class="w-5 h-5 rounded-full bg-gray-100 text-gray-400 hover:bg-gray-200 hover:text-gray-600 flex items-center justify-center transition-colors">
                        <span class="text-[10px] font-bold italic font-serif">i</span>
                    </button>
                    <div class="w-8 h-8 rounded-full bg-sky-50 text-sky-500 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                </div>
            </div>
            <div class="mt-1">
                <div class="text-4xl font-extrabold text-[#0D2240] tracking-tight">{{ $totalPegawai ?? 0 }}</div>
                <p class="text-[11px] font-medium text-gray-400 mt-1">Pegawai terdaftar aktif</p>
            </div>
        </div>

        <!-- Kartu 2: HADIR HARI INI -->
        <div
            class="bg-white p-5 rounded-[1.25rem] border border-gray-100 shadow-[0_2px_10px_-4px_rgba(0,0,0,0.05)] flex flex-col justify-between h-full hover:shadow-md transition-shadow duration-300">
            <div class="flex items-center justify-between mb-4">
                <span class="text-[11px] font-bold text-gray-500 uppercase tracking-wider">HADIR HARI INI</span>
                <div class="flex items-center space-x-2.5">
                    <button type="button" onclick="showInfoModal('hadir')"
                        class="w-5 h-5 rounded-full bg-gray-100 text-gray-400 hover:bg-gray-200 hover:text-gray-600 flex items-center justify-center transition-colors">
                        <span class="text-[10px] font-bold italic font-serif">i</span>
                    </button>
                    <div class="w-8 h-8 rounded-full bg-emerald-50 text-emerald-500 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                </div>
            </div>
            <div class="mt-1">
                <div class="text-4xl font-extrabold text-[#0D2240] tracking-tight">{{ $hadirHariIni ?? 0 }}</div>
                <p class="text-[11px] font-medium text-gray-400 mt-1">Absensi masuk terverifikasi</p>
            </div>
        </div>

        <!-- Kartu 3: IZIN / SAKIT / CUTI -->
        <div
            class="bg-white p-5 rounded-[1.25rem] border border-gray-100 shadow-[0_2px_10px_-4px_rgba(0,0,0,0.05)] flex flex-col justify-between h-full hover:shadow-md transition-shadow duration-300">
            <div class="flex items-center justify-between mb-4">
                <span class="text-[11px] font-bold text-gray-500 uppercase tracking-wider">IZIN / SAKIT / CUTI</span>
                <div class="flex items-center space-x-2.5">
                    <button type="button" onclick="showInfoModal('izin')"
                        class="w-5 h-5 rounded-full bg-gray-100 text-gray-400 hover:bg-gray-200 hover:text-gray-600 flex items-center justify-center transition-colors">
                        <span class="text-[10px] font-bold italic font-serif">i</span>
                    </button>
                    <div class="w-8 h-8 rounded-full bg-amber-50 text-amber-500 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
            </div>
            <div class="mt-1">
                <div class="text-4xl font-extrabold text-[#0D2240] tracking-tight">{{ $izinSakitCuti ?? 0 }}</div>
                <p class="text-[11px] font-medium text-gray-400 mt-1">Disetujui tidak masuk kerja</p>
            </div>
        </div>

        <!-- Kartu 4: DINAS LUAR -->
        <div
            class="bg-white p-5 rounded-[1.25rem] border border-gray-100 shadow-[0_2px_10px_-4px_rgba(0,0,0,0.05)] flex flex-col justify-between h-full hover:shadow-md transition-shadow duration-300">
            <div class="flex items-center justify-between mb-4">
                <span class="text-[11px] font-bold text-gray-500 uppercase tracking-wider">DINAS LUAR</span>
                <div class="flex items-center space-x-2.5">
                    <button type="button" onclick="showInfoModal('dinas')"
                        class="w-5 h-5 rounded-full bg-gray-100 text-gray-400 hover:bg-gray-200 hover:text-gray-600 flex items-center justify-center transition-colors">
                        <span class="text-[10px] font-bold italic font-serif">i</span>
                    </button>
                    <div class="w-8 h-8 rounded-full bg-sky-50 text-sky-500 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                </div>
            </div>
            <div class="mt-1">
                <div class="text-4xl font-extrabold text-[#0D2240] tracking-tight">{{ $dinasLuar ?? 0 }}</div>
                <p class="text-[11px] font-medium text-gray-400 mt-1">Pegawai bertugas di luar kantor</p>
            </div>
        </div>

    </div>

    <!-- DUA PANEL KONTEN UTAMA: KEHADIRAN PEGAWAI HARI INI & MENUNGGU PERSETUJUAN (Sesuai Gambar Referensi) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

        <!-- Panel Kiri: Kehadiran Pegawai Hari Ini (Live) (8 Cols) -->
        <div class="lg:col-span-8 bg-white rounded-2xl border border-gray-100 shadow-xs p-6">
            <div class="flex items-center justify-between pb-4 border-b border-gray-100">
                <div>
                    <h3 class="text-base font-bold text-gray-900">Kehadiran Pegawai Hari Ini (Live)</h3>
                    <p id="tabelKehadiranDate" class="text-xs text-gray-500 font-medium mt-0.5">
                        {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }}
                    </p>
                </div>
                <a href="{{ url('admin/monitoring-absensi') }}"
                    class="text-xs font-semibold text-gray-800 hover:text-sky-700 transition cursor-pointer">
                    Lihat Rekap Lengkap
                </a>
            </div>

            <div class="overflow-x-auto mt-4">
                <table class="w-full text-left text-xs sm:text-sm">
                    <thead>
                        <tr class="text-gray-500 font-medium text-xs border-b border-gray-100">
                            <th class="py-3 px-3 font-medium">Nama</th>
                            <th class="py-3 px-3 font-medium">Bidang</th>
                            <th class="py-3 px-3 font-medium">Datang</th>
                            <th class="py-3 px-3 font-medium">Pulang</th>
                            <th class="py-3 px-3 font-medium text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 text-gray-700">
                        @forelse($kehadiranHariIni ?? [] as $k)
                        <tr class="hover:bg-slate-50/60 transition">
                            <td class="py-3.5 px-3 font-bold text-gray-900">{{ $k->pegawai->nama ?? $k->employee->name ?? '-' }}</td>
                            <td class="py-3.5 px-3 text-gray-600">{{ $k->pegawai->bidang ?? $k->employee->department ?? '-' }}</td>
                            <td class="py-3.5 px-3 text-gray-700 font-mono text-xs">{{ $k->jam_masuk ? date('H:i', strtotime($k->jam_masuk)) : ($k->arrival_time ? date('H:i', strtotime($k->arrival_time)) : '-') }}</td>
                            <td class="py-3.5 px-3 text-gray-700 font-mono text-xs">{{ $k->jam_pulang ? date('H:i', strtotime($k->jam_pulang)) : ($k->checkout_time ? date('H:i', strtotime($k->checkout_time)) : '-') }}</td>
                            <td class="py-3.5 px-3 text-center">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold border {{ ($k->status_masuk ?? $k->arrival_status ?? '') === 'Tepat Waktu' ? 'border-emerald-300 bg-emerald-50 text-emerald-700' : 'border-amber-300 bg-amber-50 text-amber-700' }}">
                                    {{ $k->status_masuk ?? $k->arrival_status ?? $k->status ?? 'Hadir' }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-10 text-center text-gray-400">
                                <div class="flex flex-col items-center justify-center space-y-1.5">
                                    <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <p class="text-xs font-medium text-gray-500">Belum ada aktivitas presensi hari ini.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Panel Kanan: Menunggu Persetujuan (4 Cols) -->
        <div class="lg:col-span-4 bg-white rounded-2xl border border-gray-100 shadow-xs p-6">
            <div class="pb-4 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <h3 class="text-base font-bold text-gray-900">Menunggu Persetujuan</h3>
                    <p class="text-xs text-gray-400 mt-0.5">{{ isset($pendingPengajuan) ? count($pendingPengajuan) : ($pendingPengajuanCount ?? 0) }} pengajuan izin/cuti</p>
                </div>
                <a href="{{ url('admin/persetujuan-izin-cuti') }}" class="text-xs font-semibold text-sky-600 hover:text-sky-800">Lihat Semua</a>
            </div>

            <div class="mt-4 space-y-3">
                @forelse($pendingPengajuan ?? [] as $pp)
                <div class="border border-gray-200/80 rounded-2xl p-4 bg-white shadow-2xs hover:shadow-xs transition text-center space-y-2">
                    <div class="flex items-center justify-center space-x-2">
                        <h4 class="text-sm font-bold text-gray-900">{{ $pp->pegawai->nama ?? $pp->employee->name ?? '-' }}</h4>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-sky-100 text-sky-700">
                            {{ $pp->jenis ?? $pp->type }}
                        </span>
                    </div>
                    <p class="text-xs text-gray-400 font-medium">{{ $pp->tanggal_mulai ? \Carbon\Carbon::parse($pp->tanggal_mulai)->locale('id')->isoFormat('D MMM Y') : '-' }}</p>
                    <p class="text-xs text-gray-600 leading-relaxed px-2 truncate">
                        {{ $pp->alasan ?? $pp->reason }}
                    </p>
                    <div class="pt-1 flex justify-center">
                        <a href="{{ url('admin/persetujuan-izin-cuti') }}"
                            class="px-4 py-1.5 rounded-xl bg-[#0D2240] hover:bg-[#163660] text-white text-xs font-bold transition shadow-2xs cursor-pointer">
                            Review
                        </a>
                    </div>
                </div>
                @empty
                <div class="py-10 px-4 text-center">
                    <div class="flex flex-col items-center justify-center">
                        <!-- Icon Centang Hijau Bersih, Indah & Proporsional (Kecil) -->
                        <div class="w-12 h-12 rounded-full bg-emerald-50 border border-emerald-100 flex items-center justify-center text-emerald-600 shadow-xs mb-3" style="width: 48px; height: 48px; min-width: 48px; min-height: 48px;">
                            <svg class="w-6 h-6 text-emerald-600" width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5" style="width: 24px; height: 24px;">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <h4 class="text-xs font-bold text-gray-900">Semua pengajuan telah ditinjau.</h4>
                        <p class="text-[11px] text-gray-400 mt-1">Tidak ada permohonan tertunda.</p>
                    </div>
                </div>
                @endforelse
            </div>
        </div>

    </div>
</div>
@endsection
