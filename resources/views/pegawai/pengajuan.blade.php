@extends('layouts.pegawai')

@section('title', 'Pengajuan - Panel Pegawai')

@section('header_title', 'Pengajuan Izin & Cuti')
@section('header_subtitle', 'Layanan pengajuan permohonan dispensasi terpadu pegawai')

@section('content')
<div class="space-y-6">

    <!-- Flash Message Notifikasi -->
    @if(session('success'))
    <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-900 flex items-start space-x-3 shadow-xs animate-in fade-in duration-200">
        <svg class="w-5 h-5 text-emerald-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <div class="flex-1 text-xs">
            <h4 class="font-bold text-sm text-emerald-950">Permohonan Berhasil Dikirim</h4>
            <p class="mt-0.5">{{ session('success') }}</p>
        </div>
    </div>
    @endif

    @if($errors->any())
    <div class="p-4 rounded-2xl bg-red-50 border border-red-200 text-red-900 flex items-start space-x-3 shadow-xs animate-in fade-in duration-200">
        <svg class="w-5 h-5 text-red-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
        </svg>
        <div class="flex-1 text-xs">
            <h4 class="font-bold text-sm text-red-950">Gagal Mengirim Permohonan</h4>
            <ul class="list-disc list-inside mt-1 space-y-0.5">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

    <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-xs">
        <div class="inline-flex items-center space-x-2 px-2.5 py-0.5 rounded-full bg-blue-50 text-blue-700 text-xs font-semibold mb-1 border border-blue-200">
            <span class="w-1.5 h-1.5 rounded-full bg-blue-600"></span>
            <span>Layanan Pengajuan Terpadu Pegawai</span>
        </div>
        <h2 class="text-lg font-bold text-gray-900">Pengajuan Izin, Cuti Tahunan &amp; Penugasan Dinas Luar</h2>
        <p class="text-xs text-gray-500 mt-0.5">Permohonan resmi dispensasi izin/sakit, cuti tahunan, dan penugasan dinas luar (SPT) ke pimpinan SKPD</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Form Pengajuan Baru: Izin, Cuti, dan Dinas Luar (Terhubung ke Database) -->
        <div id="formPengajuanCard" class="lg:col-span-2 bg-white rounded-2xl border border-gray-200 p-6 shadow-xs space-y-4">
            <h3 class="text-base font-bold text-gray-900 pb-2 border-b border-gray-100">Buat Permohonan Pengajuan Baru</h3>

            <form action="{{ route('pegawai.pengajuan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf

                <!-- Pilihan Radio: 3 JENIS (IZIN, CUTI & DINAS LUAR) -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-2">Pilih Jenis Pengajuan <span class="text-red-500">*</span></label>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <!-- Opsi 1: Izin / Sakit -->
                        <label class="p-3.5 border-2 border-amber-300 bg-amber-50/30 rounded-xl flex items-center space-x-3 cursor-pointer hover:border-amber-500 transition">
                            <input type="radio" name="jenis" value="Izin" class="w-4 h-4 text-amber-600 focus:ring-amber-500">
                            <div>
                                <span class="text-xs font-bold text-gray-900 block">Izin / Sakit</span>
                                <span class="text-[11px] text-gray-500">Dispensasi surat keterangan</span>
                            </div>
                        </label>

                        <!-- Opsi 2: Cuti Tahunan -->
                        <label class="p-3.5 border-2 border-emerald-400 bg-emerald-50/30 rounded-xl flex items-center space-x-3 cursor-pointer hover:border-emerald-600 transition">
                            <input type="radio" name="jenis" value="Cuti" checked class="w-4 h-4 text-emerald-600 focus:ring-emerald-500">
                            <div>
                                <span class="text-xs font-bold text-gray-900 block">Cuti Tahunan</span>
                                <span class="text-[11px] text-gray-500">Hak cuti resmi tahunan</span>
                            </div>
                        </label>

                        <!-- Opsi 3: Dinas Luar (SPT) -->
                        <label class="p-3.5 border-2 border-blue-400 bg-blue-50/40 rounded-xl flex items-center space-x-3 cursor-pointer hover:border-blue-600 transition">
                            <input type="radio" name="jenis" value="Dinas Luar" class="w-4 h-4 text-blue-600 focus:ring-blue-500">
                            <div>
                                <span class="text-xs font-bold text-blue-950 block">Dinas Luar (SPT)</span>
                                <span class="text-[11px] text-blue-700">Surat perintah penugasan</span>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Mulai Tanggal <span class="text-red-500">*</span></label>
                        <input type="date" name="tanggal_mulai" value="{{ date('Y-m-d') }}" required
                            class="w-full text-xs bg-gray-50 border border-gray-300 rounded-xl p-2.5 text-gray-800 focus:ring-2 focus:ring-[#0D2240] focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Sampai Tanggal <span class="text-red-500">*</span></label>
                        <input type="date" name="tanggal_selesai" value="{{ date('Y-m-d') }}" required
                            class="w-full text-xs bg-gray-50 border border-gray-300 rounded-xl p-2.5 text-gray-800 focus:ring-2 focus:ring-[#0D2240] focus:outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Keterangan / Alasan / Nomor Surat Perintah Tugas <span class="text-red-500">*</span></label>
                    <textarea name="alasan" rows="3" required
                        placeholder="Jika Izin/Sakit: Tuliskan alasan izin atau diagnosa dokter&#10;Jika Cuti: Tuliskan keperluan cuti tahunan&#10;Jika Dinas Luar: Masukkan nomor SPT resmi dan lokasi tujuan dinas..."
                        class="w-full text-xs bg-gray-50 border border-gray-300 rounded-xl p-2.5 text-gray-800 focus:ring-2 focus:ring-[#0D2240] focus:outline-none"></textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Upload Berkas Pendukung (Surat Dokter / Formulir Cuti / SPT)</label>
                    <input type="file" name="dokumen" accept=".pdf,.jpg,.jpeg,.png"
                        class="w-full text-xs text-gray-600 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-[#0D2240] file:text-white hover:file:bg-[#163660] cursor-pointer">
                    <span class="text-[10px] text-gray-400">Format: PDF atau Gambar (Maks 5MB)</span>
                </div>

                <div class="pt-2">
                    <button type="submit"
                        class="w-full py-3 px-4 rounded-xl bg-[#0D2240] hover:bg-[#163660] text-white text-xs sm:text-sm font-bold shadow-sm transition active:scale-98 cursor-pointer flex items-center justify-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                        </svg>
                        <span>Kirim Permohonan ke Database</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Riwayat Pengajuan Terdaftar dari Database -->
        <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-xs space-y-4">
            <h3 class="text-sm font-bold text-gray-900 pb-2 border-b border-gray-100">Riwayat Pengajuan Terdaftar</h3>

            <div class="space-y-3">
                @forelse($leaveRequests ?? [] as $req)
                    <div class="p-3.5 rounded-xl border border-gray-200 bg-slate-50/50 hover:border-gray-300 transition">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-gray-900 flex items-center space-x-1.5">
                                <span class="w-2 h-2 rounded-full {{ ($req->jenis ?? '') == 'Dinas Luar' ? 'bg-blue-600' : (($req->jenis ?? '') == 'Cuti' ? 'bg-emerald-500' : 'bg-amber-500') }}"></span>
                                <span>{{ $req->jenis }}</span>
                            </span>
                            @if(($req->status ?? '') == 'Disetujui')
                                <span class="whitespace-nowrap text-[10px] font-semibold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded border border-emerald-200">Disetujui</span>
                            @elseif(($req->status ?? '') == 'Menunggu Review')
                                <span class="whitespace-nowrap text-[10px] font-semibold text-amber-700 bg-amber-50 px-2 py-0.5 rounded border border-amber-200">Menunggu Review</span>
                            @elseif(($req->status ?? '') == 'Ditolak')
                                <span class="whitespace-nowrap text-[10px] font-semibold text-red-700 bg-red-50 px-2 py-0.5 rounded border border-red-200">Ditolak</span>
                            @else
                                <span class="whitespace-nowrap text-[10px] font-semibold text-slate-700 bg-slate-100 px-2 py-0.5 rounded border border-slate-200">{{ $req->status }}</span>
                            @endif
                        </div>
                        <p class="text-xs text-gray-700 mt-1 font-semibold">
                            {{ \Carbon\Carbon::parse($req->tanggal_mulai)->locale('id')->isoFormat('DD MMM Y') }}
                            @if(!empty($req->tanggal_selesai) && $req->tanggal_selesai != $req->tanggal_mulai)
                                - {{ \Carbon\Carbon::parse($req->tanggal_selesai)->locale('id')->isoFormat('DD MMM Y') }}
                            @endif
                        </p>
                        <p class="text-[11px] text-gray-500 mt-0.5">{{ $req->alasan }}</p>
                        @if(!empty($req->catatan_admin))
                            <p class="text-[11px] text-blue-600 bg-blue-50 p-1.5 rounded-md mt-1.5 font-medium">Catatan Admin: {{ $req->catatan_admin }}</p>
                        @endif
                    </div>
                @empty
                    <div class="py-10 text-center text-gray-400">
                        <svg class="w-10 h-10 mx-auto text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <p class="text-xs font-medium text-gray-500">Belum ada riwayat permohonan</p>
                        <p class="text-[11px] text-gray-400 mt-0.5">Permohonan izin, cuti, atau dinas luar akan tersimpan di sini.</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</div>
@endsection
