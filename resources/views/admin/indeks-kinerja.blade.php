@extends('layouts.admin')

@section('title', 'Indeks Kinerja - Panel Administrator')

@section('header_title', 'Indeks Kinerja & Kedisiplinan')
@section('header_subtitle', 'Pantau evaluasi kinerja dan ranking pegawai')

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

    <!-- Filter Indeks Kinerja -->
    <div class="bg-white p-5 sm:p-6 rounded-2xl border border-gray-200 shadow-2xs">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h3 class="text-base font-bold text-gray-900">Filter Data Kinerja</h3>
                <p class="text-xs text-gray-500 mt-0.5">Terapkan filter pencarian, bidang, dan periode waktu</p>
            </div>
            <div class="flex items-center space-x-3">
                <!-- Tombol Reset Filter -->
                <a href="{{ route('admin.indeks-kinerja') }}" title="Reset Filter"
                    class="w-10 h-10 shrink-0 bg-white hover:bg-slate-50 border border-gray-200 rounded-xl text-gray-500 hover:text-gray-700 shadow-2xs transition flex items-center justify-center cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                </a>
            </div>
        </div>

        <form id="filterKinerjaForm" action="{{ route('admin.indeks-kinerja') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 mt-4">
            <!-- 1. Search Nama -->
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau NIP..." class="w-full h-10 pl-10 pr-4 text-xs sm:text-sm bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#0D2240]/20 focus:border-[#0D2240] text-gray-700 placeholder-gray-400 transition" onchange="document.getElementById('filterKinerjaForm').submit()">
            </div>

            <!-- 2. Dropdown Bidang -->
            <div class="relative">
                <select name="bidang" class="w-full h-10 px-3.5 pr-8 text-xs sm:text-sm bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#0D2240]/20 focus:border-[#0D2240] text-gray-700 transition cursor-pointer appearance-none" onchange="document.getElementById('filterKinerjaForm').submit()">
                    <option value="Semua Bidang" {{ request('bidang') == 'Semua Bidang' ? 'selected' : '' }}>Semua Bidang</option>
                    <option value="Perindustrian" {{ request('bidang') == 'Perindustrian' ? 'selected' : '' }}>Perindustrian</option>
                    <option value="Perdagangan" {{ request('bidang') == 'Perdagangan' ? 'selected' : '' }}>Perdagangan</option>
                    <option value="Sekretariat" {{ request('bidang') == 'Sekretariat' ? 'selected' : '' }}>Sekretariat</option>
                    <option value="Perlindungan Konsumen" {{ request('bidang') == 'Perlindungan Konsumen' ? 'selected' : '' }}>Perlindungan Konsumen</option>
                </select>
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </div>
            </div>

            <!-- 3. Dropdown Periode (Bulan-Tahun) -->
            <div class="relative">
                <input type="month" name="period" value="{{ request('period', $currentPeriod) }}" class="w-full h-10 px-3.5 pr-8 text-xs sm:text-sm bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#0D2240]/20 focus:border-[#0D2240] text-gray-700 transition cursor-pointer appearance-none" onchange="document.getElementById('filterKinerjaForm').submit()">
            </div>
            
            <div class="relative flex items-center">
                <!-- Spacing block for grid -->
            </div>
        </form>
    </div>

    <!-- 2 GRAFIK CHART.JS (SEPERTI DI PANEL PEGAWAI) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-4">

        <!-- Chart 1: Radar 3 Indikator SKPD -->
        <div class="bg-white p-5 sm:p-6 rounded-2xl border border-gray-200 shadow-2xs">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-base font-bold text-gray-900">Evaluasi 3 Aspek Kinerja (IKP)</h3>
                    <p class="text-xs text-gray-500">Bobot Penilaian: Kehadiran 60%, Produktivitas 25%, Kualitas 15%</p>
                </div>
            </div>
            <div class="h-64 sm:h-72 w-full relative">
                <canvas id="chartAdminRadarKinerja"></canvas>
            </div>
        </div>

        <!-- Chart 2: Tren Disiplin 6 Bulan Terakhir -->
        <div class="bg-white p-5 sm:p-6 rounded-2xl border border-gray-200 shadow-2xs">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-base font-bold text-gray-900">Tren Kinerja Rata-Rata SKPD</h3>
                    <p class="text-xs text-gray-500">Pergerakan indeks kinerja 6 bulan berjalan</p>
                </div>
                <span
                    class="px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-xs font-bold">Tren
                    Positif &uarr;</span>
            </div>
            <div class="h-64 sm:h-72 w-full relative">
                <canvas id="chartAdminTrenKinerja"></canvas>
            </div>
        </div>

    </div>

    <!-- Ranking Kinerja Pegawai -->
    <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-2xs">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <div>
                <h2 class="text-lg font-bold text-gray-900">Ranking Kinerja Pegawai PPPK</h2>
                <p class="text-xs text-gray-500">Rentang indeks 0–100 berdasarkan akumulasi seluruh
                    parameter kehadiran dan kinerja</p>
            </div>
            <span class="text-xs font-bold px-3 py-1.5 bg-slate-100 rounded-xl text-gray-700">Periode:
                September 2026</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs sm:text-sm">
                <thead class="bg-slate-50 text-gray-600 font-semibold border-b border-gray-200">
                    <tr>
                        <th class="py-3 px-3 text-center">Rank</th>
                        <th class="py-3 px-3">Pegawai</th>
                        <th class="py-3 px-3 text-center">Indeks Akhir</th>
                        <th class="py-3 px-3 text-center">Skor Kehadiran</th>
                        <th class="py-3 px-3 text-center">Skor Laporan</th>
                        <th class="py-3 px-3">Kategori</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-gray-700">
                    @forelse($scores ?? [] as $idx => $ps)
                    <tr class="hover:bg-slate-50/70 transition">
                        <td class="py-3.5 px-3 text-center font-bold text-gray-700">
                            @if($idx === 0) 🥇 1
                            @elseif($idx === 1) 🥈 2
                            @elseif($idx === 2) 🥉 3
                            @else {{ $idx + 1 }}
                            @endif
                        </td>
                        <td class="py-3.5 px-3">
                            <p class="font-bold text-gray-900">{{ $ps->pegawai->nama ?? '-' }}</p>
                            <span class="text-[11px] text-gray-400">NIP {{ $ps->pegawai->nip ?? '-' }} • {{ $ps->pegawai->bidang ?? '-' }}</span>
                        </td>
                        <td class="py-3.5 px-3 text-center font-black {{ ($ps->nilai_akhir ?? 0) >= 80 ? 'text-emerald-700' : (($ps->nilai_akhir ?? 0) >= 70 ? 'text-blue-700' : 'text-rose-600') }} text-base">
                            {{ number_format($ps->nilai_akhir ?? 0, 1) }}
                        </td>
                        <td class="py-3.5 px-3 text-center">{{ number_format($ps->nilai_kehadiran ?? 0, 1) }}</td>
                        <td class="py-3.5 px-3 text-center font-bold text-gray-600">
                            {{ number_format((($ps->nilai_produktivitas ?? 0) + ($ps->nilai_kualitas ?? 0)) / 2, 1) }}
                        </td>
                        <td class="py-3.5 px-3">
                            <span class="px-2.5 py-1 rounded-full {{ ($ps->kategori ?? '') === 'Sangat Baik' ? 'bg-emerald-100 text-emerald-800' : (($ps->kategori ?? '') === 'Baik' ? 'bg-blue-100 text-blue-800' : (($ps->kategori ?? '') === 'Cukup' ? 'bg-amber-100 text-amber-800' : 'bg-rose-100 text-rose-800')) }} text-xs font-bold">
                                {{ $ps->kategori ?? '-' }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-12 px-4 text-center text-gray-500">
                            <div class="flex flex-col items-center justify-center space-y-2">
                                <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 01-.982-3.82V7.5a3.75 3.75 0 00-7.5 0v4.055c0 1.348-.358 2.628-.982 3.82m12.464 0a7.482 7.482 0 01-1.464 3.05" />
                                    </svg>
                                </div>
                                <p class="text-sm font-bold text-gray-700">Belum Ada Rekapitulasi IKP Periode Ini</p>
                                <p class="text-xs text-gray-400">Skor Indeks Kinerja Pegawai dihitung secara bulanan dari Kehadiran, Produktivitas, dan Kualitas.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const chartData = {!! $chartData ?? 'null' !!};
        
        if (chartData) {
            // Radar Chart
            const ctxRadar = document.getElementById('chartAdminRadarKinerja').getContext('2d');
            new Chart(ctxRadar, {
                type: 'radar',
                data: {
                    labels: ['Kehadiran', 'Produktivitas', 'Kualitas'],
                    datasets: [{
                        label: 'Skor Rata-Rata',
                        data: chartData.radar,
                        backgroundColor: 'rgba(13, 34, 64, 0.2)',
                        borderColor: 'rgba(13, 34, 64, 1)',
                        pointBackgroundColor: 'rgba(13, 34, 64, 1)',
                        pointBorderColor: '#fff',
                        pointHoverBackgroundColor: '#fff',
                        pointHoverBorderColor: 'rgba(13, 34, 64, 1)'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        r: {
                            angleLines: { display: false },
                            suggestedMin: 0,
                            suggestedMax: 100
                        }
                    }
                }
            });

            // Line Chart
            const ctxLine = document.getElementById('chartAdminTrenKinerja').getContext('2d');
            new Chart(ctxLine, {
                type: 'line',
                data: {
                    labels: chartData.trend_labels,
                    datasets: [{
                        label: 'Indeks Kinerja Akhir',
                        data: chartData.trend_data,
                        fill: true,
                        backgroundColor: 'rgba(16, 185, 129, 0.1)', // emerald-500
                        borderColor: 'rgba(16, 185, 129, 1)',
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            suggestedMin: 0,
                            suggestedMax: 100
                        }
                    }
                }
            });
        }
    });
</script>
@endpush
@endsection
