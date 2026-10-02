@extends('layouts.pegawai')

@section('title', 'Kinerja - Panel Pegawai')

@section('header_title', 'Indeks Kedisiplinan & Kinerja')
@section('header_subtitle', 'Evaluasi disiplin dan produktivitas pegawai')

@section('content')
<!-- Banner Nilai & Rekomendasi Kontrak -->
<div class="bg-[#0D2240] text-white rounded-2xl p-6 sm:p-8 shadow-sm mb-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
        <div>
            <span
                class="px-3 py-1 rounded-full {{ ($ikpScore ?? 94.1) >= 80 ? 'bg-emerald-500/20 text-emerald-300 border-emerald-400/30' : 'bg-amber-500/20 text-amber-300 border-amber-400/30' }} text-xs font-bold border">
                Predikat: {{ $predikatKinerja ?? 'Disiplin Sangat Baik (A)' }}
            </span>
            <div class="mt-3 flex items-baseline space-x-3">
                <span class="text-4xl sm:text-6xl font-extrabold tracking-tight">{{ number_format($ikpScore ?? 94.1, 1) }}</span>
                <span class="text-xl sm:text-2xl font-bold text-slate-300">/ 100</span>
            </div>
            <p class="text-sm font-semibold text-sky-200 mt-1">Total Indeks Kinerja Akumulatif Pegawai PPPK</p>
        </div>

        <div class="bg-white/10 p-5 rounded-2xl border border-white/15 max-w-md">
            <span
                class="text-xs font-bold {{ ($ikpScore ?? 94.1) >= 80 ? 'text-emerald-400' : 'text-amber-400' }} uppercase tracking-wider flex items-center space-x-1.5">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd" />
                </svg>
                <span>Status Evaluasi Kontrak PPPK</span>
            </span>
            <p class="text-xs text-slate-200 mt-1.5 leading-relaxed font-medium">
                @if(($ikpScore ?? 94.1) >= 80)
                    Memenuhi syarat rekomendasi prioritas perpanjangan kontrak kerja tahunan. Nilai Anda
                    berada di atas ambang batas minimum kelulusan SKPD (&ge; 80.00).
                @else
                    Perlu peningkatan kehadiran dan pelaporan kegiatan untuk memenuhi ambang batas rekomendasi kontrak tahunan (&ge; 80.00).
                @endif
            </p>
        </div>
    </div>
</div>

<!-- 3 Kartu Rincian Indikator -->
<div class="mb-6">
    <h3 class="text-sm font-bold text-gray-800 mb-3">Rincian Nilai 3 Indikator IKP</h3>
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
        <!-- Indikator 1: Kehadiran -->
        <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-xs">
            <span class="text-[11px] font-bold text-gray-500 uppercase">1. Kehadiran ({{ floatval($pengaturan->bobot_kehadiran ?? 60) }}%)</span>
            <div class="mt-2 flex items-baseline justify-between">
                <span class="text-2xl font-extrabold text-gray-900">{{ number_format($kehadiranScore ?? 96.0, 1) }}</span>
                <span class="text-sm font-bold text-emerald-600">{{ number_format($kehadiranPoint ?? 57.6, 1) }} Poin</span>
            </div>
            <div class="w-full bg-gray-100 h-2 rounded-full mt-3 overflow-hidden">
                <div class="bg-emerald-500 h-full rounded-full" style="width: {{ min(100, $kehadiranScore ?? 96) }}%"></div>
            </div>
            <p class="text-xs text-gray-400 mt-2">{{ $kehadiranKeterangan ?? 'Berdasarkan rekapitulasi absensi' }}</p>
        </div>

        <!-- Indikator 2: Produktivitas -->
        <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-xs">
            <span class="text-[11px] font-bold text-gray-500 uppercase">2. Produktivitas ({{ floatval($pengaturan->bobot_produktivitas ?? 25) }}%)</span>
            <div class="mt-2 flex items-baseline justify-between">
                <span class="text-2xl font-extrabold text-gray-900">{{ number_format($produktivitasScore ?? 95.0, 1) }}</span>
                <span class="text-sm font-bold text-sky-600">{{ number_format($produktivitasPoint ?? 23.8, 1) }} Poin</span>
            </div>
            <div class="w-full bg-gray-100 h-2 rounded-full mt-3 overflow-hidden">
                <div class="bg-sky-500 h-full rounded-full" style="width: {{ min(100, $produktivitasScore ?? 95) }}%"></div>
            </div>
            <p class="text-xs text-gray-400 mt-2">{{ $produktivitasKeterangan ?? 'Laporan harian terverifikasi' }}</p>
        </div>

        <!-- Indikator 3: Kualitas -->
        <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-xs">
            <span class="text-[11px] font-bold text-gray-500 uppercase">3. Kualitas ({{ floatval($pengaturan->bobot_kualitas ?? 15) }}%)</span>
            <div class="mt-2 flex items-baseline justify-between">
                <span class="text-2xl font-extrabold text-gray-900">{{ number_format($kualitasScore ?? 88.0, 1) }}</span>
                <span class="text-sm font-bold text-emerald-600">{{ number_format($kualitasPoint ?? 13.2, 1) }} Poin</span>
            </div>
            <div class="w-full bg-gray-100 h-2 rounded-full mt-3 overflow-hidden">
                <div class="bg-emerald-500 h-full rounded-full" style="width: {{ min(100, $kualitasScore ?? 88) }}%"></div>
            </div>
            <p class="text-xs text-gray-400 mt-2">{{ $kualitasKeterangan ?? 'Evaluasi pimpinan & atasan' }}</p>
        </div>
    </div>
</div>

<!-- Grafik Pengukuran Kedisiplinan -->
<div>
    <h3 class="text-sm font-bold text-gray-800 mb-3">Visualisasi Grafik Kinerja &amp; Evaluasi</h3>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Grafik 1: Radar Chart 3 Indikator IKP -->
        <div class="bg-white rounded-2xl border border-gray-200 shadow-xs p-5 sm:p-6">
            <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                <div>
                    <h3 class="text-sm font-bold text-gray-900">3 Indikator IKP</h3>
                    <p class="text-xs text-gray-500">Formula bobot akumulasi IKP</p>
                </div>
                <span
                    class="text-xs font-bold px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200">
                    {{ number_format($ikpScore ?? 94.1, 1) }} / 100
                </span>
            </div>
            <div class="relative h-64 sm:h-72 mt-3">
                <canvas id="chartRadarKinerja"></canvas>
            </div>
        </div>

        <!-- Grafik 2: Tren Nilai Kinerja 6 Bulan Terakhir -->
        <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-200 shadow-xs p-5 sm:p-6">
            <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                <div>
                    <h3 class="text-sm font-bold text-gray-900">Tren Indeks Kinerja (6 Bulan)</h3>
                    <p class="text-xs text-gray-500">Evaluasi kelayakan rekomendasi perpanjangan kontrak
                        PPPK</p>
                </div>
                <span class="text-xs font-semibold text-gray-500">Target SKPD: &ge; 80.0</span>
            </div>
            <div class="relative h-64 sm:h-72 mt-3">
                <canvas id="chartTrenKinerja"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection
