@extends('layouts.admin')

@section('title', 'Surat Peringatan - Panel Administrator')

@section('header_title', 'Pengelolaan Surat Peringatan (SP)')
@section('header_subtitle', 'Sistem penerbitan SP otomatis berdasarkan akumulasi Alpha')

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

        <!-- Header & Action -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <div>
                <h2 class="text-lg font-bold text-gray-900">Pengelolaan Surat Peringatan (SP)</h2>
                <p class="text-xs text-gray-500">Ambang Batas Pelanggaran: 3 Alpha (SP 1), 6 Alpha (SP 2), 9 Alpha (SP 3)</p>
            </div>
            <button type="button" onclick="openModal('modalTemplateSP')"
                class="px-4 py-2.5 bg-white border border-gray-300 hover:border-[#0D2240] text-[#0D2240] hover:bg-slate-50 text-xs font-bold rounded-xl flex items-center space-x-2 shadow-2xs transition cursor-pointer">
                <svg class="w-4 h-4 text-[#0D2240]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <span>Kelola Master Template SP</span>
            </button>
        </div>

        <!-- Filter & Search Bar -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-5 pb-4 border-b border-gray-100">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 w-full">
                <!-- 1. Search -->
                <div class="relative w-full">
                    <input type="text" id="searchSPInput" placeholder="Cari nama, NIP, atau ID..."
                        class="w-full h-10 pl-9 pr-3 text-xs bg-slate-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-1 focus:ring-[#0D2240]">
                    <svg class="w-4 h-4 text-gray-400 absolute left-3 top-3 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </div>
                <!-- 2. Dropdown Tingkat SP -->
                <select class="w-full h-10 px-3 text-xs bg-slate-50 border border-gray-200 rounded-xl text-gray-700 cursor-pointer focus:outline-none focus:ring-1 focus:ring-[#0D2240] appearance-none">
                    <option value="">Semua Tingkat SP</option>
                    <option value="SP1">SP 1 (3 Alpha)</option>
                    <option value="SP2">SP 2 (6 Alpha)</option>
                    <option value="SP3">SP 3 (9 Alpha)</option>
                </select>
                <!-- 3. Dropdown Status & Reset Button -->
                <div class="flex items-center gap-2">
                    <select class="flex-1 h-10 px-3 text-xs bg-slate-50 border border-gray-200 rounded-xl text-gray-700 cursor-pointer focus:outline-none focus:ring-1 focus:ring-[#0D2240] appearance-none">
                        <option value="">Semua Status</option>
                        <option value="Pending Review">Pending Review</option>
                        <option value="Terbit">Sudah Terbit</option>
                    </select>
                    <!-- Tombol Reset Filter -->
                    <button type="button" onclick="alert('Filter di-reset')" title="Reset Filter" class="w-10 h-10 shrink-0 bg-white hover:bg-slate-50 border border-gray-200 rounded-xl text-gray-500 hover:text-gray-700 shadow-2xs transition flex items-center justify-center cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Tabel Data SP -->
        <div class="overflow-x-auto rounded-xl border border-gray-200">
            <table class="w-full text-left text-xs sm:text-sm">
                <thead class="bg-slate-50 text-gray-600 font-semibold border-b border-gray-200">
                    <tr>
                        <th class="py-3 px-3.5">Pegawai</th>
                        <th class="py-3 px-3 text-center">Akumulasi Alpha</th>
                        <th class="py-3 px-3 text-center">Tingkat SP</th>
                        <th class="py-3 px-3.5">Nomor Surat</th>
                        <th class="py-3 px-3">Tanggal Terbit</th>
                        <th class="py-3 px-3 text-center">Status</th>
                        <th class="py-3 px-3.5 text-center">Aksi Dokumen</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-gray-700">
                    @forelse($spLetters ?? [] as $sp)
                    <tr class="hover:bg-slate-50/70 transition">
                        <td class="py-3.5 px-3.5">
                            <div class="font-bold text-gray-900">{{ $sp->pegawai->nama ?? '-' }}</div>
                            <div class="text-[11px] text-gray-400">NIP: {{ $sp->pegawai->nip ?? '-' }} &bull; {{ $sp->pegawai->bidang ?? '-' }}</div>
                        </td>
                        <td class="py-3.5 px-3 text-center font-bold text-red-600">{{ $sp->alpha_count ?? 3 }} Alpha</td>
                        <td class="py-3.5 px-3 text-center">
                            <span class="px-2.5 py-1 rounded-md {{ $sp->tingkat_sp === 'SP1' ? 'bg-amber-100 text-amber-800' : 'bg-red-100 text-red-800' }} font-bold text-xs">
                                {{ strtoupper($sp->tingkat_sp) }}
                            </span>
                        </td>
                        <td class="py-3.5 px-3.5 font-mono text-xs {{ $sp->nomor_surat ? 'text-gray-800 font-semibold' : 'text-gray-400 italic' }}">
                            {{ $sp->nomor_surat ?? '(Belum diterbitkan)' }}
                        </td>
                        <td class="py-3.5 px-3 text-gray-500">{{ $sp->tanggal_terbit ? date('d M Y', strtotime($sp->tanggal_terbit)) : '-' }}</td>
                        <td class="py-3.5 px-3 text-center">
                            <span class="px-2.5 py-1 rounded-full {{ (($sp->status ?? '') === 'Selesai' || ($sp->status ?? '') === 'Terbit') ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }} text-xs font-bold">
                                {{ (($sp->status ?? '') === 'Selesai' || ($sp->status ?? '') === 'Terbit') ? 'Terbit' : 'Pending Review' }}
                            </span>
                        </td>
                        <td class="py-3.5 px-3.5 text-center space-x-1.5">
                            @if(($sp->status ?? '') === 'Selesai' || ($sp->status ?? '') === 'Terbit')
                            <a href="{{ route('admin.surat-peringatan.pdf', $sp->id) }}" target="_blank"
                                class="px-3 py-1.5 bg-[#0D2240] hover:bg-[#163660] text-white rounded-lg text-xs font-bold transition cursor-pointer shadow-2xs inline-flex items-center space-x-1.5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                </svg>
                                <span>Cetak SP (PDF)</span>
                            </a>
                            @else
                            <button type="button"
                                onclick="openTerbitkanSPModal({{ $sp->id }}, '{{ addslashes($sp->pegawai->nama ?? '-') }}', '{{ addslashes($sp->pegawai->nip ?? '-') }}', '{{ addslashes($sp->pegawai->jabatan ?? '-') }}', '{{ $sp->tingkat_sp ?? 'SP 1' }}', 'Akumulasi {{ $sp->alpha_count ?? 3 }} Hari Alpha Tanpa Keterangan')"
                                class="px-3 py-1.5 bg-[#0D2240] hover:bg-[#163660] text-white rounded-lg text-xs font-bold shadow-2xs transition cursor-pointer">
                                Terbitkan SP
                            </button>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-12 px-4 text-center text-gray-500">
                            <div class="flex flex-col items-center justify-center space-y-2">
                                <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                </div>
                                <p class="text-sm font-bold text-gray-700">Tidak Ada Pelanggaran / Peringatan (Kosong)</p>
                                <p class="text-xs text-gray-400">Seluruh pegawai berada dalam status disiplin aman dan belum mencapai ambang batas SP (3 Alpha).</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- =======================================================
     MODAL 1: KELOLA MASTER TEMPLATE SP (.DOCX)
     ======================================================= -->
<div id="modalTemplateSP" class="fixed inset-0 bg-slate-900/60 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-xl w-full p-6 shadow-2xl relative animate-in fade-in zoom-in duration-150">
        <div class="flex items-center justify-between pb-3 border-b border-gray-100">
            <div class="flex items-center space-x-2.5">
                <div class="w-8 h-8 rounded-xl bg-blue-50 text-[#0D2240] flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-gray-900">Master Template Dokumen SP</h3>
                    <p class="text-xs text-gray-500">Unggah berkas Word (.docx) lengkap dengan kop dinas & tanda tangan</p>
                </div>
            </div>
            <button onclick="closeModal('modalTemplateSP')" class="text-gray-400 hover:text-gray-600 p-1.5 rounded-lg cursor-pointer">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div class="mt-4 space-y-4">
            <!-- Status File Aktif Saat Ini -->
            <div class="p-3.5 bg-slate-50 rounded-xl border border-gray-200 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-9 h-9 rounded-lg bg-blue-100 text-blue-800 font-bold text-xs flex items-center justify-center">
                        DOCX
                    </div>
                    <div>
                        <div class="text-xs font-bold text-gray-900" id="currentTemplateName">Template_SP_DISPERINDAG_2026.docx</div>
                        <div class="text-[11px] text-gray-500">Status: <span class="text-emerald-600 font-semibold">Aktif & Digunakan Sistem</span></div>
                    </div>
                </div>
                <button type="button" onclick="alert('Mengunduh Master Template SP aktif (.docx)...')" class="text-xs text-[#0D2240] hover:underline font-semibold cursor-pointer">
                    Unduh Master
                </button>
            </div>

            <!-- Upload Area (Fixed: Clean Dropzone with invisible input covering entire box) -->
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1.5">Unggah Template Baru (.docx)</label>
                <div class="relative flex flex-col items-center justify-center p-6 border-2 border-dashed border-gray-300 hover:border-[#0D2240] rounded-2xl bg-slate-50/50 hover:bg-slate-50 transition cursor-pointer group text-center">
                    <input type="file" id="inputTemplateDocx" accept=".docx" class="absolute inset-0 opacity-0 w-full h-full cursor-pointer z-10" onchange="handleTemplateUploadChange(this)">
                    <svg class="w-10 h-10 text-gray-400 group-hover:text-[#0D2240] transition mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                    </svg>
                    <p class="text-xs font-semibold text-gray-700" id="uploadPromptText">
                        <span class="text-[#0D2240] underline underline-offset-2">Pilih file .docx</span> atau seret file ke area ini
                    </p>
                    <p class="text-[10px] text-gray-400 mt-1">Maksimal ukuran berkas: 5MB</p>
                </div>
            </div>

            <!-- Panduan Tag Variabel -->
            <div class="bg-blue-50/60 p-3.5 rounded-xl border border-blue-100">
                <div class="text-xs font-bold text-blue-900 mb-1.5">Variabel Otomatis dalam Dokumen:</div>
                <p class="text-[11px] text-blue-800/80 mb-2 leading-relaxed">
                    Sisipkan tag berikut pada dokumen Word Anda. Sistem akan otomatis menggantinya dengan data pegawai terkait:
                </p>
                <ul class="grid grid-cols-1 sm:grid-cols-2 gap-y-1.5 gap-x-2 text-[11px] font-mono text-blue-900 font-semibold pl-2">
                    <li class="flex items-center space-x-2"><span class="w-1.5 h-1.5 rounded-full bg-blue-400 shrink-0"></span><span>{nomor_surat}</span></li>
                    <li class="flex items-center space-x-2"><span class="w-1.5 h-1.5 rounded-full bg-blue-400 shrink-0"></span><span>{nama_pegawai}</span></li>
                    <li class="flex items-center space-x-2"><span class="w-1.5 h-1.5 rounded-full bg-blue-400 shrink-0"></span><span>{nip}</span></li>
                    <li class="flex items-center space-x-2"><span class="w-1.5 h-1.5 rounded-full bg-blue-400 shrink-0"></span><span>{jabatan}</span></li>
                    <li class="flex items-center space-x-2"><span class="w-1.5 h-1.5 rounded-full bg-blue-400 shrink-0"></span><span>{tingkat_sp}</span></li>
                    <li class="flex items-center space-x-2"><span class="w-1.5 h-1.5 rounded-full bg-blue-400 shrink-0"></span><span>{tanggal_dikeluarkan}</span></li>
                    <li class="flex items-center space-x-2"><span class="w-1.5 h-1.5 rounded-full bg-blue-400 shrink-0"></span><span>{masa_berlaku}</span></li>
                    <li class="flex items-center space-x-2"><span class="w-1.5 h-1.5 rounded-full bg-blue-400 shrink-0"></span><span>{alasan_pelanggaran}</span></li>
                </ul>
            </div>

            <!-- Footer Buttons -->
            <div class="flex justify-end space-x-2.5 pt-3 border-t border-gray-100">
                <button type="button" onclick="closeModal('modalTemplateSP')" class="px-4 py-2 bg-slate-100 text-gray-700 text-xs font-semibold rounded-xl hover:bg-slate-200 cursor-pointer transition">
                    Tutup
                </button>
                <button type="button" onclick="saveTemplateMaster()" class="px-4 py-2 bg-[#0D2240] hover:bg-[#163660] text-white text-xs font-bold rounded-xl shadow-xs cursor-pointer transition">
                    Simpan Template
                </button>
            </div>
        </div>
    </div>
</div>

<!-- =======================================================
     MODAL 2: TERBITKAN SURAT PERINGATAN (NOMOR SURAT)
     ======================================================= -->
<div id="modalTerbitkanSP" class="fixed inset-0 bg-slate-900/60 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl relative animate-in fade-in zoom-in duration-150">
        <div class="flex items-center justify-between pb-3 border-b border-gray-100">
            <div class="flex items-center space-x-2.5">
                <div class="w-8 h-8 rounded-xl bg-amber-50 text-amber-700 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-gray-900">Terbitkan Surat Peringatan</h3>
                    <p class="text-xs text-gray-500">Isi nomor surat resmi agenda dinas untuk menerbitkan dokumen</p>
                </div>
            </div>
            <button onclick="closeModal('modalTerbitkanSP')" class="text-gray-400 hover:text-gray-600 p-1.5 rounded-lg cursor-pointer">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <form id="formTerbitkanSP" method="POST" action="" class="mt-4 space-y-4">
            @csrf
            <!-- Data Pegawai Terkait (Otomatis dari Sistem) -->
            <div class="bg-slate-50 p-3.5 rounded-xl border border-gray-200 text-xs space-y-1.5">
                <div class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">Data Pelanggaran (Otomatis)</div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Nama Pegawai:</span>
                    <span class="font-bold text-gray-900" id="modalPegawaiNama">-</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">NIP / Jabatan:</span>
                    <span class="font-medium text-gray-700" id="modalPegawaiNipJabatan">-</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-500">Tingkat Surat:</span>
                    <span class="px-2 py-0.5 bg-amber-100 text-amber-800 rounded font-bold" id="modalPegawaiTingkatSP">-</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Alasan / Bentuk:</span>
                    <span class="font-medium text-red-600" id="modalPegawaiAlasan">-</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Tanggal Dikeluarkan:</span>
                    <span class="font-medium text-gray-800" id="modalTanggalDikeluarkan">-</span>
                </div>
            </div>

            <!-- Input Utama: Nomor Surat Resmi -->
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">
                    Nomor Surat Resmi <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <input type="text" id="inputNomorSuratResmi" name="nomor_surat" required
                        placeholder="Contoh: 800/015/DISPERINDAG/2026"
                        class="w-full h-10 px-3.5 font-mono text-xs border border-gray-300 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-[#0D2240] focus:border-transparent text-gray-900 font-semibold">
                </div>
                <p class="text-[10px] text-gray-400 mt-1">Sesuai penomoran pada Buku Agenda Surat Keluar Dinas Perindag.</p>
            </div>

            <!-- Input Pendukung: Masa Berlaku SP -->
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Masa Berlaku Surat</label>
                <select id="inputMasaBerlakuSP" class="w-full h-10 px-3 text-xs border border-gray-200 rounded-xl bg-white focus:outline-none focus:ring-1 focus:ring-[#0D2240] text-gray-700 cursor-pointer">
                    <option value="1 Bulan">1 Bulan</option>
                    <option value="3 Bulan">3 Bulan</option>
                    <option value="6 Bulan" selected>6 Bulan (Standar Kedisiplinan)</option>
                    <option value="1 Tahun">1 Tahun</option>
                </select>
            </div>

            <!-- Info template otomatis -->
            <div class="p-3 bg-amber-50/70 border border-amber-200/80 rounded-xl text-[11px] text-amber-900 leading-relaxed">
                Nomor surat yang Anda isi di atas beserta data otomatis pegawai akan digabungkan ke dalam <strong>Master Template Word (.docx)</strong> dan langsung siap diunduh.
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end space-x-2 pt-2 border-t border-gray-100">
                <button type="button" onclick="closeModal('modalTerbitkanSP')"
                    class="px-4 py-2 bg-slate-100 text-gray-700 rounded-xl text-xs font-semibold hover:bg-slate-200 cursor-pointer transition">
                    Batal
                </button>
                <button type="submit"
                    class="px-4 py-2 bg-[#0D2240] hover:bg-[#163660] text-white rounded-xl text-xs font-bold shadow-xs cursor-pointer transition flex items-center space-x-1.5">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>Terbitkan &amp; Unduh Dokumen</span>
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    let currentTargetRowId = null;

    function handleTemplateUploadChange(input) {
        if (input.files && input.files[0]) {
            const fileName = input.files[0].name;
            document.getElementById('uploadPromptText').innerHTML = `<span class="text-emerald-700 font-bold">File terpilih:</span> ${fileName}`;
        }
    }

    function saveTemplateMaster() {
        const fileInput = document.getElementById('inputTemplateDocx');
        if (fileInput.files && fileInput.files[0]) {
            document.getElementById('currentTemplateName').textContent = fileInput.files[0].name;
        }
        alert('Master Template Dokumen SP berhasil diperbarui & disimpan ke sistem!');
        closeModal('modalTemplateSP');
    }

    function openTerbitkanSPModal(id, nama, nip, jabatan, tingkat, alasan) {
        document.getElementById('modalPegawaiNama').textContent = nama;
        document.getElementById('modalPegawaiNipJabatan').textContent = `${nip} • ${jabatan}`;
        document.getElementById('modalPegawaiTingkatSP').textContent = tingkat;
        document.getElementById('modalPegawaiAlasan').textContent = alasan;
        
        // Tanggal hari ini
        const now = new Date();
        const options = { day: '2-digit', month: 'short', year: 'numeric' };
        document.getElementById('modalTanggalDikeluarkan').textContent = now.toLocaleDateString('id-ID', options);

        // Pre-fill contoh nomor surat
        document.getElementById('inputNomorSuratResmi').value = '800/015/DISPERINDAG/' + now.getFullYear();

        // Update form action
        const form = document.getElementById('formTerbitkanSP');
        form.action = `/surat-peringatan/${id}/terbitkan`;

        openModal('modalTerbitkanSP');
    }

    const searchSP = document.getElementById('searchSPInput');
    if (searchSP) {
        searchSP.addEventListener('keyup', function () {
            const val = this.value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr');
            rows.forEach(r => {
                const text = r.textContent.toLowerCase();
                r.style.display = text.includes(val) ? '' : 'none';
            });
        });
    }
</script>
@endpush

@endsection
