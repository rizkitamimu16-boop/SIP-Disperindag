@extends('layouts.pegawai')

@section('title', 'Riwayat Kehadiran - Panel Pegawai')

@section('header_title', 'Riwayat Absensi')
@section('header_subtitle', 'Catatan kehadiran harian dan log waktu presensi')

@section('content')
<!-- Header & Filter -->
<div
    class="bg-white rounded-2xl border border-gray-200 p-5 shadow-xs flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
    <div>
        <h2 class="text-lg font-bold text-gray-900">Riwayat Kehadiran Lengkap</h2>
        <p class="text-xs text-gray-500 mt-0.5">Daftar rekap log absensi datang, pulang, dan jam kerja
            efektif</p>
    </div>
    <form action="{{ route('pegawai.riwayat-absensi') }}" method="GET" class="flex flex-wrap items-center gap-2.5">
        <input type="month" name="month" value="{{ request('month', \Carbon\Carbon::now()->format('Y-m')) }}" onchange="this.form.submit()"
            class="text-xs font-semibold bg-gray-50 border border-gray-300 rounded-xl px-3 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#0D2240]">
        <select name="status" onchange="this.form.submit()"
            class="text-xs font-semibold bg-gray-50 border border-gray-300 rounded-xl px-3 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#0D2240]">
            <option value="semua">Semua Status</option>
            <option value="hadir" {{ request('status') == 'hadir' ? 'selected' : '' }}>Hadir (Tepat/Terlambat)</option>
            <option value="alpha" {{ request('status') == 'alpha' ? 'selected' : '' }}>Alpha</option>
            <option value="izin" {{ request('status') == 'izin' ? 'selected' : '' }}>Izin / Cuti</option>
            <option value="dinas_luar" {{ request('status') == 'dinas_luar' ? 'selected' : '' }}>Dinas Luar</option>
        </select>
        <a href="{{ route('pegawai.riwayat-absensi.export', request()->query()) }}"
            class="text-xs font-semibold bg-[#0D2240] text-white px-4 py-2 rounded-xl hover:bg-[#163660] transition cursor-pointer flex items-center space-x-1.5">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
            </svg>
            <span>Unduh PDF</span>
        </a>
    </form>
</div>

<!-- Tabel Riwayat Presensi -->
<div class="bg-white rounded-2xl border border-gray-200 shadow-xs overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs text-gray-700">
            <thead class="bg-slate-50 text-gray-600 font-bold border-b border-gray-200">
                <tr>
                    <th class="p-3.5">Tanggal</th>
                    <th class="p-3.5">Jam Masuk</th>
                    <th class="p-3.5">Jarak Masuk</th>
                    <th class="p-3.5">Jam Pulang</th>
                    <th class="p-3.5">Jarak Pulang</th>
                    <th class="p-3.5">Durasi Kerja</th>
                    <th class="p-3.5">Status</th>
                    <th class="p-3.5 text-center">Foto</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($attendances ?? [] as $att)
                    <tr class="hover:bg-slate-50 transition {{ strtolower($att->status ?? '') == 'dinas luar' ? 'bg-blue-50/20' : '' }}">
                        <td class="p-3.5 font-bold text-gray-900">
                            {{ \Carbon\Carbon::parse($att->tanggal ?? now())->locale('id')->isoFormat('DD MMM Y (ddd)') }}
                        </td>
                        <td class="p-3.5 {{ strtolower($att->status ?? '') == 'terlambat' ? 'text-amber-600' : (strtolower($att->status ?? '') == 'dinas luar' ? 'text-blue-700' : 'text-emerald-700') }} font-semibold">
                            @if(strtolower($att->status ?? '') == 'dinas luar')
                                Surat Tugas
                            @else
                                {{ !empty($att->jam_masuk) ? \Carbon\Carbon::parse($att->jam_masuk)->format('H:i') . ' WITA' : '-' }}
                            @endif
                        </td>
                        <td class="p-3.5 text-gray-600">
                            {{ !empty($att->jarak_masuk) ? round($att->jarak_masuk) . ' meter' : '-' }}
                        </td>
                        <td class="p-3.5 {{ strtolower($att->status ?? '') == 'dinas luar' ? 'text-blue-700 font-semibold' : 'text-emerald-700 font-semibold' }}">
                            @if(strtolower($att->status ?? '') == 'dinas luar')
                                Surat Tugas
                            @else
                                {{ !empty($att->jam_pulang) ? \Carbon\Carbon::parse($att->jam_pulang)->format('H:i') . ' WITA' : '-' }}
                            @endif
                        </td>
                        <td class="p-3.5 text-gray-600">
                            {{ !empty($att->jarak_pulang) ? round($att->jarak_pulang) . ' meter' : '-' }}
                        </td>
                        <td class="p-3.5 font-bold text-gray-800">
                            @if(strtolower($att->status ?? '') == 'dinas luar')
                                Dinas Luar (SPT)
                            @elseif(!empty($att->jam_masuk) && !empty($att->jam_pulang))
                                {{ \Carbon\Carbon::parse($att->jam_masuk)->diff(\Carbon\Carbon::parse($att->jam_pulang))->format('%Hj %Im') }}
                            @elseif(!empty($att->jam_masuk) && empty($att->jam_pulang))
                                <span class="text-gray-400 font-normal">Berlangsung</span>
                            @else
                                -
                            @endif
                        </td>
                        <td class="p-3.5">
                            @if(strtolower($att->status ?? '') == 'hadir')
                                <span class="px-2.5 py-1 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">Hadir Tepat Waktu</span>
                            @elseif(strtolower($att->status ?? '') == 'terlambat')
                                <span class="px-2.5 py-1 rounded-full text-[11px] font-semibold bg-amber-50 text-amber-700 border border-amber-200">Terlambat</span>
                            @elseif(strtolower($att->status ?? '') == 'dinas luar')
                                <span class="px-2.5 py-1 rounded-full text-[11px] font-semibold bg-blue-50 text-blue-700 border border-blue-200">Dinas Luar</span>
                            @elseif(strtolower($att->status ?? '') == 'izin' || strtolower($att->status ?? '') == 'cuti' || strtolower($att->status ?? '') == 'sakit')
                                <span class="px-2.5 py-1 rounded-full text-[11px] font-semibold bg-indigo-50 text-indigo-700 border border-indigo-200">{{ ucfirst($att->status) }}</span>
                            @else
                                <span class="px-2.5 py-1 rounded-full text-[11px] font-semibold bg-red-50 text-red-700 border border-red-200">{{ ucfirst($att->status ?? 'Alpha') }}</span>
                            @endif
                        </td>
                        <td class="p-3.5 text-center">
                            @if(!empty($att->foto_masuk) || !empty($att->foto_pulang))
                                <div class="flex flex-col space-y-1 items-center">
                                    @if(!empty($att->foto_masuk))
                                        <button type="button" onclick="openBuktiFotoModal('{{ $att->jam_masuk ? date('H:i', strtotime($att->jam_masuk)) : '-' }} WITA', '{{ $att->jarak_masuk ?? '-' }}m', '{{ $att->status_masuk ?? '-' }}', '{{ asset('storage/' . $att->foto_masuk) }}')" class="text-xs text-sky-600 hover:underline font-semibold cursor-pointer">Foto Masuk</button>
                                    @endif
                                    @if(!empty($att->foto_pulang))
                                        <button type="button" onclick="openBuktiFotoModal('{{ $att->jam_pulang ? date('H:i', strtotime($att->jam_pulang)) : '-' }} WITA', '{{ $att->jarak_pulang ?? '-' }}m', '{{ $att->status_pulang ?? '-' }}', '{{ asset('storage/' . $att->foto_pulang) }}')" class="text-xs text-emerald-600 hover:underline font-semibold cursor-pointer">Foto Pulang</button>
                                    @endif
                                </div>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="p-12 text-center text-gray-500">
                            <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                            </svg>
                            <p class="text-xs font-semibold text-gray-700">Belum ada riwayat kehadiran tercatat</p>
                            <p class="text-[11px] text-gray-400 mt-1">Data presensi akan muncul secara otomatis setelah Anda melakukan absensi.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
