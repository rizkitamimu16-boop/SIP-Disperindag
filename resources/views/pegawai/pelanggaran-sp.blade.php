@extends('layouts.pegawai')

@section('title', 'Surat Peringatan - Panel Pegawai')

@section('header_title', 'Status Disiplin & SP')
@section('header_subtitle', 'Pantau akumulasi pelanggaran dan sanksi')

@section('content')
<!-- Status Disiplin Utama -->
<div
    class="bg-white rounded-2xl border border-gray-200 p-6 shadow-xs flex flex-col md:flex-row md:items-center md:justify-between gap-6 mb-6">
    <div class="flex items-center space-x-4">
        <div
            class="w-14 h-14 rounded-2xl {{ ($spCount ?? 0) > 0 ? 'bg-amber-50 border-amber-200 text-amber-600' : 'bg-emerald-50 border-emerald-200 text-emerald-600' }} border flex items-center justify-center shrink-0">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
            </svg>
        </div>
        <div>
            @if(($spCount ?? 0) > 0)
                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-800">
                    TERDAPAT SANKSI AKTIF
                </span>
                <h2 class="text-xl font-bold text-gray-900 mt-1">Peringatan Disiplin Diterbitkan</h2>
                <p class="text-xs text-gray-500 mt-0.5">Anda memiliki {{ $spCount ?? 0 }} catatan Surat Peringatan aktif</p>
            @else
                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800">
                    STATUS AMAN &amp; BEBAS SANKSI
                </span>
                <h2 class="text-xl font-bold text-gray-900 mt-1">Tidak Ada Catatan Pelanggaran Disiplin</h2>
                <p class="text-xs text-gray-500 mt-0.5">Anda tidak memiliki riwayat Surat Peringatan (SP 1, SP 2, atau SP 3)</p>
            @endif
        </div>
    </div>

    <div class="bg-slate-50 p-4 rounded-xl border border-gray-200 text-right">
        <span class="text-xs font-semibold text-gray-500">Status Surat Peringatan (SP):</span>
        <p class="text-2xl font-extrabold {{ ($spCount ?? 0) > 0 ? 'text-amber-700' : 'text-emerald-700' }}">{{ ($spCount ?? 0) > 0 ? ($spCount . ' / TERBIT') : '0 / KOSONG' }}</p>
    </div>
</div>

<!-- Monitoring Ambang Batas Toleransi SP -->
<div class="mb-6">
    <div class="flex items-center justify-between mb-3">
        <h3 class="text-sm font-bold text-gray-800">Monitoring Akumulasi Alpha &amp; Siklus SP</h3>
        <span class="text-[11px] font-semibold {{ ($spCount ?? 0) > 0 ? 'text-amber-700 bg-amber-50 border-amber-200' : 'text-emerald-700 bg-emerald-50 border-emerald-200' }} px-2.5 py-1 rounded-full border">
            {{ ($spCount ?? 0) > 0 ? 'Siklus SP Aktif: Berjalan' : 'Siklus SP Aktif: Periode Bersih' }}
        </span>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <!-- Ambang Alpha -->
        <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-xs space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-gray-700">Akumulasi Alpha (Dasar Formal SP)</span>
                <span
                    class="text-xs font-bold {{ ($alphaCount ?? 0) > 0 ? 'text-amber-700 bg-amber-50' : 'text-emerald-700 bg-emerald-50' }} px-2 py-0.5 rounded-full">{{ $alphaCount ?? 0 }} Hari</span>
            </div>
            <div class="w-full bg-gray-100 h-2 rounded-full overflow-hidden">
                <div class="{{ ($alphaCount ?? 0) >= 3 ? 'bg-red-500' : 'bg-emerald-500' }} h-full rounded-full" style="width: {{ min(100, (($alphaCount ?? 0) / 9) * 100) }}%"></div>
            </div>
            <div class="flex items-center justify-between text-[11px] text-gray-500">
                <span>Saat ini: {{ $alphaCount ?? 0 }} Alpha</span>
                <span class="text-amber-600 font-semibold">Ambang SP 1: 3 Hari Alpha</span>
            </div>
        </div>

        <!-- Status Kedisiplinan Waktu (IKP) -->
        <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-xs space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-gray-700">Ketepatan Waktu Masuk / Pulang</span>
                <span class="text-xs font-bold text-blue-700 bg-blue-50 px-2 py-0.5 rounded-full">{{ $ketepatanWaktu ?? 100 }}% Tepat Waktu</span>
            </div>
            <div class="w-full bg-gray-100 h-2 rounded-full overflow-hidden">
                <div class="bg-blue-500 h-full rounded-full" style="width: {{ min(100, $ketepatanWaktu ?? 100) }}%"></div>
            </div>
            <div class="flex items-center justify-between text-[11px] text-gray-500">
                <span>Keterlambatan: {{ $terlambatMenit ?? 0 }} Menit ({{ $terlambatCount ?? 0 }}x)</span>
                <span class="text-gray-500 italic">Mempengaruhi Skor IKP Kehadiran (60%)</span>
            </div>
        </div>
    </div>
</div>

<!-- Riwayat Surat Peringatan (SP) -->
<div class="mb-6">
    <h3 class="text-sm font-bold text-gray-800 mb-3">Riwayat Surat Peringatan Anda</h3>
    <div class="bg-white rounded-2xl border border-gray-200 shadow-xs overflow-hidden">
        <table class="w-full text-left text-xs sm:text-sm">
            <thead class="bg-slate-50 text-gray-600 font-semibold border-b border-gray-200">
                <tr>
                    <th class="py-3 px-4">Tanggal SP</th>
                    <th class="py-3 px-4">Tingkat SP</th>
                    <th class="py-3 px-4">Nomor Surat</th>
                    <th class="py-3 px-4">Alasan Pelanggaran</th>
                    <th class="py-3 px-4 text-center">Status Berkas</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-gray-700">
                @forelse($spLetters ?? [] as $sp)
                    <tr>
                        <td class="py-3 px-4 font-semibold">{{ \Carbon\Carbon::parse($sp->date_issued ?? now())->locale('id')->isoFormat('DD MMMM Y') }}</td>
                        <td class="py-3 px-4">
                            <span class="px-2.5 py-1 rounded text-xs font-bold {{ ($sp->sp_level ?? '') == 'sp3' ? 'bg-red-100 text-red-800' : (($sp->sp_level ?? '') == 'sp2' ? 'bg-orange-100 text-orange-800' : 'bg-amber-100 text-amber-800') }}">
                                {{ strtoupper($sp->sp_level ?? 'SP 1') }}
                            </span>
                        </td>
                        <td class="py-3 px-4 font-mono text-xs">{{ $sp->letter_number ?? '-' }}</td>
                        <td class="py-3 px-4">{{ $sp->violation_reason ?? 'Akumulasi kehadiran tidak memenuhi ketentuan' }}</td>
                        <td class="py-3 px-4 text-center">
                            @if(!empty($sp->file_path))
                                <a href="{{ asset($sp->file_path) }}" target="_blank" class="text-blue-600 hover:underline text-xs font-bold">Unduh PDF</a>
                            @else
                                <span class="text-xs text-gray-400">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-8 px-4 text-center text-gray-500 italic">
                            Belum ada riwayat Surat Peringatan (Kosong).
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Kebijakan Tingkatan Sanksi -->
<div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-xs space-y-4">
    <div class="flex items-center justify-between pb-3 border-b border-gray-100">
        <div>
            <h3 class="text-sm font-bold text-gray-900">Ketentuan Surat Peringatan DISPERDAGIN</h3>
            <p class="text-xs text-gray-500">Alpha merupakan data pelanggaran formal dan satu-satunya dasar penerbitan SP</p>
        </div>
        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-700">Konsep Siklus SP</span>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-xs">
        <div class="p-3.5 rounded-xl border border-amber-200 bg-amber-50/40">
            <div class="flex items-center justify-between mb-1.5">
                <span class="font-bold text-amber-900">SP Pertama (SP 1)</span>
                <span class="px-2 py-0.5 rounded bg-amber-200/60 text-amber-900 font-bold text-[10px]">3 Alpha</span>
            </div>
            <p class="text-gray-600 leading-relaxed">Diterbitkan apabila pegawai mengumpulkan <strong>3 hari Alpha</strong> tanpa keterangan sah. Berupa teguran dan pembinaan disiplin.</p>
        </div>
        <div class="p-3.5 rounded-xl border border-orange-200 bg-orange-50/40">
            <div class="flex items-center justify-between mb-1.5">
                <span class="font-bold text-orange-900">SP Kedua (SP 2)</span>
                <span class="px-2 py-0.5 rounded bg-orange-200/60 text-orange-900 font-bold text-[10px]">6 Alpha</span>
            </div>
            <p class="text-gray-600 leading-relaxed">Diterbitkan apabila pelanggaran berlanjut hingga akumulasi <strong>6 hari Alpha</strong>. Penundaan rekomendasi perpanjangan perjanjian kerja.</p>
        </div>
        <div class="p-3.5 rounded-xl border border-red-200 bg-red-50/40">
            <div class="flex items-center justify-between mb-1.5">
                <span class="font-bold text-red-900">SP Ketiga (SP 3)</span>
                <span class="px-2 py-0.5 rounded bg-red-200/60 text-red-900 font-bold text-[10px]">9 Alpha</span>
            </div>
            <p class="text-gray-600 leading-relaxed">Diterbitkan apabila mencapai batas kritis <strong>9 hari Alpha</strong>. Menjadi dasar rekomendasi pemutusan hubungan perjanjian kerja PPPK.</p>
        </div>
    </div>

    <div class="p-3 rounded-xl bg-slate-50 border border-slate-200 text-xs text-slate-700 flex items-start space-x-2.5">
        <svg class="w-4 h-4 text-blue-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <div class="leading-relaxed">
            <strong>Aturan Siklus SP:</strong> Jika pegawai memperoleh SP 1 kemudian pada satu periode berikutnya bersih dari Alpha, maka siklus SP di-reset kembali ke awal. Namun jika pelanggaran berlanjut tanpa perbaikan, sistem akan memicu tahapan SP selanjutnya (SP 1, SP 2, hingga SP 3).
        </div>
    </div>
</div>
@endsection
