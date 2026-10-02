@extends('layouts.pegawai')

@section('title', 'Laporan Kegiatan - Panel Pegawai')

@section('header_title', 'Laporan Kegiatan Harian')
@section('header_subtitle', 'Rekapitulasi seluruh pekerjaan harian dan tugas dinas')

@section('content')
<!-- Header Banner Laporan Kegiatan & Tombol Popup Lapor -->
<div
    class="bg-white rounded-2xl border border-gray-200 p-5 shadow-xs flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
    <div>
        <div
            class="inline-flex items-center space-x-2 px-2.5 py-0.5 rounded-full bg-sky-50 text-sky-700 text-xs font-semibold mb-1 border border-sky-200">
            <span class="w-1.5 h-1.5 rounded-full bg-sky-500"></span>
            <span>Bobot Produktivitas 25%</span>
        </div>
        <h2 class="text-lg font-bold text-gray-900">Daftar Laporan Kegiatan Harian</h2>
        <p class="text-xs text-gray-500 mt-0.5">Rekapitulasi seluruh pekerjaan harian, tugas dinas, dan
            verifikasi atasan</p>
    </div>

    <!-- Tombol Lapor Kegiatan Langsung Pop Up (Gambar 2) -->
    <button type="button" onclick="openKegiatanModal()"
        class="inline-flex items-center justify-center space-x-2 bg-[#0D2240] hover:bg-[#163660] text-white px-5 py-2.5 rounded-xl text-xs sm:text-sm font-semibold shadow-sm transition active:scale-98 cursor-pointer shrink-0">
        <svg class="w-4 h-4 text-sky-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"
            stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
        </svg>
        <span>Tambah / Lapor Kegiatan</span>
    </button>
</div>

<!-- 4 Statistik Ringkasan Kegiatan -->
<div class="grid grid-cols-2 lg:grid-cols-4 gap-3.5 sm:gap-4 mb-6">
    <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-xs">
        <span class="text-[11px] font-bold text-gray-500 uppercase tracking-wider">Total Laporan Bulan
            Ini</span>
        <div class="mt-2 flex items-baseline space-x-2">
            <span class="text-2xl font-extrabold text-gray-900">{{ $totalLaporan ?? 0 }}</span>
            <span
                class="text-xs font-semibold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">{{ $persenTargetLaporan ?? '100%' }}
                Target</span>
        </div>
        <p class="text-[11px] text-gray-400 mt-1">{{ $totalLaporan ?? 0 }} dari {{ $targetHariKerja ?? 22 }} hari kerja aktif</p>
    </div>

    <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-xs">
        <span class="text-[11px] font-bold text-gray-500 uppercase tracking-wider">Disetujui
            Atasan</span>
        <div class="mt-2 flex items-baseline space-x-2">
            <span class="text-2xl font-extrabold text-emerald-600">{{ $disetujuiCount ?? 0 }}</span>
            <span
                class="text-xs font-semibold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-full">Terverifikasi</span>
        </div>
        <p class="text-[11px] text-gray-400 mt-1">Sesuai uraian output dinas</p>
    </div>

    <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-xs">
        <span class="text-[11px] font-bold text-gray-500 uppercase tracking-wider">Menunggu
            Review</span>
        <div class="mt-2 flex items-baseline space-x-2">
            <span class="text-2xl font-extrabold text-amber-600">{{ $menungguReviewCount ?? 0 }}</span>
            <span class="text-xs font-semibold text-amber-700 bg-amber-50 px-2.5 py-1 rounded-full">Belum Dinilai</span>
        </div>
        <p class="text-[11px] text-gray-400 mt-1">Menunggu paraf subkoordinator</p>
    </div>

    <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-xs">
        <span class="text-[11px] font-bold text-gray-500 uppercase tracking-wider">Nilai
            Produktivitas</span>
        <div class="mt-2 flex items-baseline space-x-2">
            <span class="text-2xl font-extrabold text-sky-600">{{ $nilaiProduktivitas ?? '0.0' }}</span>
            <span class="text-xs font-semibold text-sky-700 bg-sky-50 px-2 py-0.5 rounded-full">{{ $poinProduktivitas ?? '0.0' }}
                Poin</span>
        </div>
        <p class="text-[11px] text-gray-400 mt-1">Bobot 25% maksimal dihitung</p>
    </div>
</div>

<!-- Filter & Pencarian List Kegiatan -->
<form action="{{ route('pegawai.kegiatan') }}" method="GET" class="bg-white rounded-2xl border border-gray-200 p-4 shadow-xs flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-4">
    <div class="relative flex-1 max-w-md">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama pekerjaan atau kegiatan..." onchange="this.form.submit()"
            class="w-full text-xs bg-slate-50 border border-gray-200 rounded-xl pl-9 pr-4 py-2.5 text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#0D2240] focus:bg-white transition">
        <svg class="w-4 h-4 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor"
            viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
    </div>

    <div class="flex flex-wrap items-center gap-2">
        <input type="month" name="month" value="{{ request('month', \Carbon\Carbon::now()->format('Y-m')) }}" onchange="this.form.submit()"
            class="text-xs font-semibold bg-gray-50 border border-gray-300 rounded-xl px-3 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#0D2240]">
        <select name="status" onchange="this.form.submit()"
            class="text-xs font-semibold bg-gray-50 border border-gray-300 rounded-xl px-3 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#0D2240]">
            <option value="semua">Semua Status</option>
            <option value="Disetujui" {{ request('status') == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
            <option value="Menunggu Review" {{ request('status') == 'Menunggu Review' ? 'selected' : '' }}>Menunggu Review</option>
            <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
        </select>
        <a href="{{ route('pegawai.kegiatan.export', request()->query()) }}"
            class="text-xs font-semibold bg-white border border-gray-300 text-gray-700 px-3 py-2 rounded-xl hover:bg-gray-50 transition cursor-pointer flex items-center space-x-1.5">
            <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
            </svg>
            <span>Ekspor PDF</span>
        </a>
    </div>
</form>

<div class="mb-3">
    <p class="text-xs text-gray-500 bg-blue-50/50 p-2.5 rounded-lg border border-blue-100 inline-block font-medium">Merupakan sumber data produktivitas dan bukti verifikasi untuk penilaian kualitas kerja.</p>
</div>
<!-- Tabel List Kegiatan Lengkap -->
<div class="bg-white rounded-2xl border border-gray-200 shadow-xs overflow-hidden mb-6">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs text-gray-700">
            <thead class="bg-slate-50 text-gray-600 font-bold border-b border-gray-200">
                <tr>
                    <th class="p-3.5">Tanggal &amp; Waktu</th>
                    <th class="p-3.5">Nama Pekerjaan / Kegiatan</th>
                    <th class="p-3.5">Deskripsi Hasil Pekerjaan</th>
                    <th class="p-3.5 text-center">Dokumentasi</th>
                    <th class="p-3.5">Status Penilaian</th>
                    <th class="p-3.5 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200" id="tabelKegiatanBody">
                @forelse($activities ?? [] as $rep)
                    <tr class="hover:bg-slate-50 transition {{ strtolower($rep->status_verifikasi) == 'menunggu review' ? 'bg-amber-50/10' : '' }}">
                        <td class="p-3.5 font-medium whitespace-nowrap">
                            <p class="font-bold text-gray-900">{{ \Carbon\Carbon::parse($rep->tanggal)->locale('id')->isoFormat('DD MMM Y (ddd)') }}</p>
                            <p class="text-[11px] text-gray-500">{{ $rep->waktu_kirim ?? '-' }} WITA</p>
                        </td>
                        <td class="p-3.5">
                            <span class="font-bold text-gray-900 block">{{ $rep->nama_kegiatan ?? '-' }}</span>
                            <span class="text-[11px] text-slate-500">{{ $employee->bidang ?? '-' }}</span>
                        </td>
                        <td class="p-3.5 max-w-xs">
                            <p class="truncate font-medium text-gray-700" title="{{ $rep->deskripsi ?? '' }}">
                                {{ $rep->deskripsi ?? '-' }}
                            </p>
                            @if(!empty($rep->catatan_kualitas))
                                <div class="mt-1 text-[10px] text-blue-700 bg-blue-50 px-2 py-1 rounded border border-blue-100 max-w-xs">
                                    <span class="font-bold">Feedback Admin:</span> {{ $rep->catatan_kualitas }}
                                </div>
                            @endif
                        </td>
                        <td class="p-3.5 text-center whitespace-nowrap">
                            @if(!empty($rep->foto))
                                <button type="button" onclick="openFotoLaporanModal('{{ $rep->nama_kegiatan }}', '{{ asset('storage/' . $rep->foto) }}')" class="inline-flex items-center space-x-1 px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-700 text-[11px] font-semibold border border-emerald-200 hover:bg-emerald-100 transition cursor-pointer">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <span>Lihat Foto</span>
                                </button>
                            @else
                                <span class="text-gray-400 text-[11px]">-</span>
                            @endif
                        </td>
                        <td class="p-3.5 whitespace-nowrap">
                            @if(($rep->status ?? '') == 'disetujui')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    Disetujui
                                </span>
                            @elseif(strtolower($rep->status_verifikasi ?? '') == 'menunggu review')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold bg-amber-50 text-amber-800 border border-amber-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 mr-1.5 animate-pulse"></span>
                                    Menunggu Review
                                </span>
                            @elseif(strtolower($rep->status_verifikasi ?? '') == 'ditolak')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold bg-red-50 text-red-700 border border-red-200">
                                    Ditolak
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    Disetujui
                                </span>
                            @endif
                        </td>
                        <td class="p-3.5 text-center whitespace-nowrap">
                            <button type="button"
                                onclick="alert('Detail Laporan Kegiatan:\n\nKegiatan: {{ addslashes($rep->nama_kegiatan ?? '-') }}\nDeskripsi: {{ addslashes($rep->deskripsi ?? '-') }}\nStatus: {{ ucfirst($rep->status_verifikasi ?? 'menunggu') }}')"
                                class="text-[#0D2240] hover:text-sky-700 font-bold hover:underline cursor-pointer">
                                Detail
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-12 text-center text-gray-500">
                            <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <p class="text-xs font-semibold text-gray-700">Belum ada laporan kegiatan</p>
                            <p class="text-[11px] text-gray-400 mt-1">Klik tombol "+ Tambah / Lapor Kegiatan" di atas untuk mengisi laporan harian Anda.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination List Kegiatan -->
    <div class="p-4 border-t border-gray-100 flex items-center justify-between text-xs text-gray-500">
        <span>Menampilkan 1 - 6 dari 22 kegiatan bulan September 2026</span>
        <div class="flex items-center space-x-1.5">
            <button type="button"
                class="px-3 py-1.5 rounded-lg border border-gray-200 bg-white text-gray-400 cursor-not-allowed">Sebelumnya</button>
            <button type="button"
                class="px-3 py-1.5 rounded-lg bg-[#0D2240] text-white font-bold">1</button>
            <button type="button"
                class="px-3 py-1.5 rounded-lg border border-gray-200 bg-white text-gray-700 hover:bg-gray-50">2</button>
            <button type="button"
                class="px-3 py-1.5 rounded-lg border border-gray-200 bg-white text-gray-700 hover:bg-gray-50">Selanjutnya</button>
        </div>
    </div>
</div>
@endsection
