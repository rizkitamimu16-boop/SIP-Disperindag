@extends('layouts.admin')

@section('title', 'Persetujuan Izin & Cuti - Panel Administrator')

@section('header_title', 'Persetujuan Izin & Cuti')
@section('header_subtitle', 'Pengajuan yang disetujui otomatis menjadi pengecualian resmi')

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

        <!-- Top Header & Filter Tab -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <div>
                <h2 class="text-lg font-bold text-gray-900">Persetujuan Izin, Cuti, Sakit, &amp; Dinas Luar</h2>
                <p class="text-xs text-gray-500 mt-0.5">Pengajuan yang disetujui otomatis menjadi pengecualian resmi presensi (tidak dihitung Alpha)</p>
            </div>
            <div class="flex gap-1.5 p-1 bg-slate-100 rounded-xl">
                <button type="button" onclick="filterPengajuan('all', this)"
                    class="pengajuan-tab-btn px-3 py-1.5 bg-white text-[#0D2240] font-bold rounded-lg text-xs shadow-2xs transition cursor-pointer">
                    Semua (5)
                </button>
                <button type="button" onclick="filterPengajuan('pending', this)"
                    class="pengajuan-tab-btn px-3 py-1.5 text-gray-600 font-medium rounded-lg text-xs hover:text-gray-900 transition cursor-pointer">
                    Pending (2)
                </button>
                <button type="button" onclick="filterPengajuan('approved', this)"
                    class="pengajuan-tab-btn px-3 py-1.5 text-gray-600 font-medium rounded-lg text-xs hover:text-gray-900 transition cursor-pointer">
                    Disetujui (3)
                </button>
            </div>
        </div>

        <div class="overflow-x-auto mt-4">
            <table class="w-full text-left text-xs sm:text-sm">
                <thead class="bg-slate-50 text-gray-600 font-semibold border-b border-gray-200">
                    <tr>
                        <th class="py-3 px-3">Pegawai</th>
                        <th class="py-3 px-3">Jenis</th>
                        <th class="py-3 px-3">Waktu Pelaksanaan</th>
                        <th class="py-3 px-3">Keterangan / Alasan</th>
                        <th class="py-3 px-3 text-center">Lampiran</th>
                        <th class="py-3 px-3">Status</th>
                        <th class="py-3 px-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-gray-700">
                    @forelse($leaveRequests ?? [] as $req)
                    <tr class="hover:bg-slate-50/70 transition">
                        <td class="py-3.5 px-3">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 rounded-full bg-slate-100 text-slate-700 font-bold text-xs flex items-center justify-center shrink-0">
                                    {{ strtoupper(substr($req->pegawai->nama ?? $req->employee->name ?? 'P', 0, 2)) }}
                                </div>
                                <div>
                                    <p class="font-bold text-gray-900">{{ $req->pegawai->nama ?? $req->employee->name ?? '-' }}</p>
                                    <span class="text-[11px] text-gray-400 font-mono">{{ $req->pegawai->bidang ?? '-' }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="py-3.5 px-3">
                            <span class="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-800 text-xs font-semibold">
                                {{ $req->jenis ?? $req->type }}
                            </span>
                        </td>
                        <td class="py-3.5 px-3 font-mono text-xs text-gray-700">
                            {{ \Carbon\Carbon::parse($req->tanggal_mulai ?? $req->start_date)->format('d/m/Y') }}
                            @if(!empty($req->tanggal_selesai) && $req->tanggal_selesai != $req->tanggal_mulai)
                                - {{ \Carbon\Carbon::parse($req->tanggal_selesai)->format('d/m/Y') }}
                            @endif
                        </td>
                        <td class="py-3.5 px-3 max-w-xs">
                            <p class="text-xs text-gray-900 font-medium truncate">{{ $req->alasan ?? $req->reason }}</p>
                        </td>
                        <td class="py-3.5 px-3 text-center">
                            @if(!empty($req->lampiran) || !empty($req->attachment) || true)
                            <a href="#" onclick="alert('Membuka lampiran dokumen...')" class="inline-flex items-center space-x-1 text-xs font-bold text-sky-600 hover:text-sky-800 transition">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                </svg>
                                <span>Lihat</span>
                            </a>
                            @else
                            <span class="text-xs text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="py-3.5 px-3">
                            <span class="whitespace-nowrap px-2.5 py-1 rounded-full {{ ($req->status ?? '') === 'Disetujui' ? 'bg-emerald-100 text-emerald-800 border-emerald-200' : (($req->status ?? '') === 'Ditolak' ? 'bg-red-100 text-red-800 border-red-200' : 'bg-amber-100 text-amber-800 border-amber-200') }} text-xs font-bold border">
                                {{ $req->status ?? 'Menunggu Review' }}
                            </span>
                        </td>
                        <td class="py-3.5 px-3 text-center">
                            @if(($req->status ?? 'Menunggu Review') === 'Menunggu Review')
                            <button type="button"
                                onclick="bukaModalReviewPengajuan({{ $req->id ?? 0 }}, '{{ addslashes($req->pegawai->nama ?? $req->employee->name ?? '-') }}', '{{ $req->jenis ?? $req->type }}', '{{ \Carbon\Carbon::parse($req->tanggal_mulai ?? $req->start_date ?? now())->format('d M Y') }}', '{{ addslashes($req->alasan ?? $req->reason ?? '') }}')"
                                class="whitespace-nowrap px-3 py-1.5 bg-[#0D2240] text-white rounded-xl text-xs font-bold hover:bg-[#163660] transition shadow-2xs cursor-pointer inline-flex items-center space-x-1">
                                <span>Review &amp; Setujui</span>
                            </button>
                            @else
                            <span class="whitespace-nowrap inline-flex items-center space-x-1 text-xs text-gray-600 font-medium bg-slate-50 px-2.5 py-1 rounded-lg border border-gray-200">
                                <span>Selesai</span>
                            </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-12 px-4 text-center text-gray-500">
                            <div class="flex flex-col items-center justify-center space-y-2">
                                <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <p class="text-sm font-bold text-gray-700">Belum Ada Pengajuan Izin / Cuti</p>
                                <p class="text-xs text-gray-400">Pengajuan izin, sakit, cuti, atau perjalanan dinas dari pegawai akan tercatat di sini.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function bukaModalReviewPengajuan(id, nama, jenis, waktu, alasan) {
    document.getElementById('reviewModalNama').textContent = nama;
    document.getElementById('reviewModalJenis').textContent = jenis;
    document.getElementById('reviewModalWaktu').textContent = waktu;
    document.getElementById('reviewModalAlasan').textContent = alasan;
    document.getElementById('formReviewPengajuan').action = `{{ url('admin/pengajuan') }}/${id}/status`;
    openModal('modalReviewPengajuan');
}
</script>
@endsection
