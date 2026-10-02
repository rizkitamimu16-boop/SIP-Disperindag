@extends('layouts.admin')

@section('title', 'Monitoring Absensi - Panel Administrator')

@section('header_title', 'Monitoring Absensi')
@section('header_subtitle', 'Validasi waktu server WITA, koordinat GPS, dan verifikasi foto')

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



    <!-- KARTU FILTER DATA (Sesuai Gambar Referensi) -->
    <div class="bg-white p-5 sm:p-6 rounded-2xl border border-gray-200 shadow-2xs">
        <h3 class="text-base font-bold text-gray-900">Filter Data</h3>
        <p class="text-xs text-gray-500 mt-0.5">Terapkan filter untuk menyaring rekap kehadiran</p>

        <div class="flex flex-wrap items-center gap-3 mt-4">
            <!-- Input 1: Cari Nama Pegawai -->
            <div class="flex-1 min-w-[200px] relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </div>
                <input type="text" id="filterAbsensiNama" placeholder="Cari nama pegawai..."
                    class="w-full h-10 pl-10 pr-4 text-xs sm:text-sm bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#0D2240]/20 focus:border-[#0D2240] text-gray-700 placeholder-gray-400 transition">
            </div>

            <!-- Dropdown Bidang -->
            <div class="w-36 relative">
                <select id="filterAbsensiBidang"
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

            <!-- Input 2: Tanggal -->
            <div class="w-32 relative">
                <input type="date" id="filterAbsensiTanggal"
                    class="w-full h-10 px-2 text-xs sm:text-sm bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#0D2240]/20 focus:border-[#0D2240] text-gray-700 transition cursor-pointer">
            </div>

            <!-- Dropdown Bulan -->
            <div class="relative w-32">
                <select id="filterAbsensiBulan"
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

            <!-- Dropdown Tahun -->
            <div class="relative w-32">
                <select id="filterAbsensiTahun"
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

            <!-- Input 3: Dropdown Status -->
            <div class="w-36 relative">
                <select id="filterAbsensiStatus"
                    class="w-full h-10 px-3.5 pr-8 text-xs sm:text-sm bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#0D2240]/20 focus:border-[#0D2240] text-gray-700 transition cursor-pointer appearance-none">
                    <option value="Semua Status">Semua Status</option>
                    <option value="Tepat Waktu">Tepat Waktu</option>
                    <option value="Terlambat">Terlambat</option>
                    <option value="Alpha">Alpha</option>
                    <option value="Izin / Cuti">Izin / Cuti</option>
                    <option value="Dinas Luar">Dinas Luar</option>
                </select>
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </div>
            </div>

            <!-- Reset Filter Button -->
            <button type="button" onclick="resetFilterAbsensi()" title="Reset Filter"
                class="w-10 h-10 shrink-0 bg-white hover:bg-slate-50 border border-gray-200 rounded-xl text-gray-500 hover:text-gray-700 shadow-2xs transition flex items-center justify-center cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
            </button>
        </div>

        <!-- Indikator Filter Aktif -->
        <div class="flex items-center space-x-2 mt-3.5 text-xs text-slate-500">
            <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor"
                viewBox="0 0 24 24" stroke-width="2">
                <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
            </svg>
            <span id="filterActiveLabel" class="text-slate-500 font-medium">Filter aktif: semua
                status</span>
        </div>
    </div>

    <!-- KARTU TABEL REKAP PRESENSI -->
    <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-2xs">
        <div class="flex items-center justify-between pb-4 border-b border-gray-100">
            <div>
                <h3 class="text-base font-bold text-gray-900">Rekap Presensi Harian Pegawai</h3>
                <p class="text-xs text-gray-500 mt-0.5">Daftar presensi terverifikasi radius geofence &le;
                    50m</p>
            </div>
            <span class="text-xs font-semibold px-2.5 py-1 bg-slate-100 text-slate-700 rounded-lg"
                id="totalAbsensiFiltered">Menampilkan {{ isset($attendances) ? count($attendances) : 0 }} pegawai</span>
        </div>

        <div class="overflow-x-auto mt-4">
            <table class="w-full text-left text-xs sm:text-sm">
                <thead class="bg-slate-50 text-gray-600 font-semibold border-b border-gray-200">
                    <tr>
                        <th class="py-3 px-3">Pegawai</th>
                        <th class="py-3 px-3">Tanggal</th>
                        <th class="py-3 px-3">Datang</th>
                        <th class="py-3 px-3">Status Datang</th>
                        <th class="py-3 px-3">Jarak Geofence</th>
                        <th class="py-3 px-3">Pulang</th>
                        <th class="py-3 px-3">Status Pulang</th>
                        <th class="py-3 px-3 text-center">Bukti Selfie</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-gray-700" id="tabelAbsensiBody">
                    @forelse($attendances ?? [] as $att)
                    @php
                        $isIzin = in_array($att->status, ['Izin', 'Cuti', 'Sakit', 'Dinas Luar']);
                    @endphp
                    <tr class="data-row hover:bg-slate-50/70 transition" data-nama="{{ $att->pegawai->nama ?? '-' }}"
                        data-status="{{ $att->status ?? 'Hadir' }}" data-bidang="{{ $att->pegawai->bidang ?? '-' }}"
                        data-tanggal="{{ date('Y-m-d', strtotime($att->tanggal)) }}" data-bulan="{{ date('m', strtotime($att->tanggal)) }}"
                        data-tahun="{{ date('Y', strtotime($att->tanggal)) }}">
                        <td class="py-3.5 px-3">
                            <p class="font-bold text-gray-900">{{ $att->pegawai->nama ?? '-' }}</p>
                            <span class="text-[11px] text-gray-400">{{ $att->pegawai->bidang ?? '-' }} • NIP {{ $att->pegawai->nip ?? '-' }}</span>
                        </td>
                        <td class="py-3.5 px-3 text-gray-600 font-mono text-xs">
                            {{ $att->tanggal ? \Carbon\Carbon::parse($att->tanggal)->locale('id')->translatedFormat('l, d F Y') : '-' }}
                        </td>
                        
                        @if($isIzin)
                        <td colspan="7" class="py-3.5 px-3">
                            <div class="w-full flex items-center justify-center p-2 rounded-lg bg-blue-50 border border-blue-100">
                                <svg class="w-5 h-5 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-sm font-bold text-blue-700">Pegawai berstatus: {{ $att->status }}</span>
                            </div>
                        </td>
                        @else
                        <td class="py-3.5 px-3 text-emerald-700 font-bold">{{ $att->jam_masuk ? date('H:i', strtotime($att->jam_masuk)).' WITA' : '-' }}</td>
                        <td class="py-3.5 px-3">
                            <span class="px-2.5 py-1 rounded-full {{ ($att->status_masuk ?? '') === 'Tepat Waktu' ? 'bg-emerald-100 text-emerald-800' : (($att->status_masuk ?? '') === 'Terlambat' ? 'bg-amber-100 text-amber-800' : 'bg-slate-100 text-slate-800') }} text-xs font-semibold">
                                {{ $att->status_masuk ?? '-' }}
                            </span>
                        </td>
                        <td class="py-3.5 px-3 font-medium text-gray-900">{{ $att->jarak_masuk ? $att->jarak_masuk.' meter' : '-' }}</td>
                        <td class="py-3.5 px-3 text-emerald-700 font-bold">{{ $att->jam_pulang ? date('H:i', strtotime($att->jam_pulang)).' WITA' : '-' }}</td>
                        <td class="py-3.5 px-3">
                            <span class="px-2 py-0.5 rounded {{ ($att->status_pulang ?? '') === 'Tepat Waktu' ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-700' }} text-xs font-medium">
                                {{ $att->status_pulang ?? ($att->jam_masuk ? 'Sedang Bekerja' : '-') }}
                            </span>
                        </td>
                        <td class="py-3.5 px-3 text-center">
                            @if($att->foto_masuk || $att->foto_pulang)
                                <div class="flex flex-col space-y-1 items-center">
                                    @if($att->foto_masuk)
                                    <button type="button"
                                        onclick="openBuktiFotoModal('{{ $att->pegawai->nama ?? '-' }}', '{{ $att->jam_masuk }} WITA (Masuk)', '{{ $att->jarak_masuk }}m', '{{ $att->status_masuk }}', '{{ asset('storage/' . $att->foto_masuk) }}')"
                                        class="text-xs font-bold text-sky-600 hover:text-sky-800 cursor-pointer">Foto Masuk</button>
                                    @endif
                                    @if($att->foto_pulang)
                                    <button type="button"
                                        onclick="openBuktiFotoModal('{{ $att->pegawai->nama ?? '-' }}', '{{ $att->jam_pulang }} WITA (Pulang)', '{{ $att->jarak_pulang }}m', '{{ $att->status_pulang }}', '{{ asset('storage/' . $att->foto_pulang) }}')"
                                        class="text-xs font-bold text-emerald-600 hover:text-emerald-800 cursor-pointer">Foto Pulang</button>
                                    @endif
                                </div>
                            @else
                            <span class="text-xs text-gray-400">-</span>
                            @endif
                        </td>
                        @endif
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-12 px-4 text-center text-gray-500">
                            <div class="flex flex-col items-center justify-center space-y-2">
                                <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <p class="text-sm font-bold text-gray-700">Belum Ada Rekaman Presensi</p>
                                <p class="text-xs text-gray-400">Data kehadiran pegawai akan muncul otomatis setelah pegawai melakukan absensi datang/pulang.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse

                    <!-- Empty State Row -->
                    <tr id="emptyAbsensiRow" style="display: none;">
                        <td colspan="7" class="py-12 text-center text-gray-400">
                            <div class="flex flex-col items-center justify-center space-y-2">
                                <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" stroke-width="2">
                                    <circle cx="11" cy="11" r="8"></circle>
                                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                </svg>
                                <p class="text-sm font-semibold text-gray-600">Tidak ada data kehadiran yang
                                    cocok dengan filter</p>
                                <p class="text-xs text-gray-400">Coba ubah kata kunci pencarian atau ganti
                                    pilihan status.</p>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
