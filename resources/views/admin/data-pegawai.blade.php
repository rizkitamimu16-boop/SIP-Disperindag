@extends('layouts.admin')

@section('title', 'Data Pegawai - Panel Administrator')

@section('header_title', 'Data Pegawai PPPK')
@section('header_subtitle', 'Kelola biodata, NIP, bidang kerja resmi, dan akun akses sistem')

@section('header_right')
    <div class="flex items-center space-x-3 bg-[#EEF2FF] px-3.5 py-1.5 rounded-2xl border border-emerald-100/80 shadow-2xs">
        <div class="flex flex-col text-right">
            <span class="text-xs font-bold text-[#1E1B4B] leading-tight">{{ auth()->user()->nama ?? 'Administrator' }}</span>
            <span class="text-[11px] text-emerald-600 font-medium">Sekretariat</span>
        </div>
        <div class="w-8 h-8 rounded-full bg-[#4F46E5] text-white font-bold text-xs flex items-center justify-center shadow-xs">
            {{ strtoupper(substr(auth()->user()->nama ?? 'AD', 0, 2)) }}
        </div>
    </div>
@endsection

@section('content')
<div class="space-y-6">

    <!-- Flash Message Notifikasi Database -->
    @if(session('success'))
    <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-900 flex items-start space-x-3 shadow-xs animate-in fade-in duration-200">
        <svg class="w-5 h-5 text-emerald-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <div class="flex-1 text-xs">
            <h4 class="font-bold text-sm text-emerald-950">Berhasil Disimpan</h4>
            <p class="mt-0.5">{{ session('success') }}</p>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="p-4 rounded-2xl bg-red-50 border border-red-200 text-red-900 flex items-start space-x-3 shadow-xs animate-in fade-in duration-200">
        <svg class="w-5 h-5 text-red-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <div class="flex-1 text-xs">
            <h4 class="font-bold text-sm text-red-950">Terjadi Kesalahan</h4>
            <p class="mt-0.5">{{ session('error') }}</p>
        </div>
    </div>
    @endif

    @if($errors->any())
    <div class="p-4 rounded-2xl bg-red-50 border border-red-200 text-red-900 flex items-start space-x-3 shadow-xs animate-in fade-in duration-200">
        <svg class="w-5 h-5 text-red-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
        </svg>
        <div class="flex-1 text-xs">
            <h4 class="font-bold text-sm text-red-950">Gagal Menyimpan Data</h4>
            <ul class="list-disc list-inside mt-1 space-y-0.5">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

    <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-2xs">

        <!-- Header Section & Quick Add Button -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <div>
                <h2 class="text-lg sm:text-xl font-bold text-gray-900">Data Pegawai PPPK</h2>
                <p class="text-xs text-gray-500">Kelola informasi biodata, NIP, 4 bidang resmi instansi, dan akun akses sistem</p>
            </div>
            <div class="flex items-center space-x-2">
                <button type="button" onclick="openModal('modalTambahPegawai')"
                    class="h-10 px-4 bg-[#0D2240] hover:bg-[#163660] text-white rounded-xl text-xs font-bold shadow-xs transition flex items-center space-x-2 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>Tambah Pegawai Baru</span>
                </button>
            </div>
        </div>

        <!-- Filter & Pencarian Cepat (GET Form) -->
        <form method="GET" action="{{ route('admin.data-pegawai') }}" class="flex flex-wrap gap-3 mb-5">
            <div class="flex-1 min-w-[240px] relative">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, NIP, atau jabatan..."
                    class="w-full h-10 pl-9 pr-3 text-xs bg-slate-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-1 focus:ring-[#0D2240] focus:bg-white">
                <svg class="w-4 h-4 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24" stroke-width="2">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
            </div>
            <select name="bidang" onchange="this.form.submit()"
                class="h-10 px-3 text-xs bg-slate-50 border border-gray-200 rounded-xl text-gray-700 outline-none focus:bg-white">
                <option value="">Semua Bidang</option>
                <option value="Sekretariat" {{ request('bidang') == 'Sekretariat' ? 'selected' : '' }}>Sekretariat</option>
                <option value="Perdagangan" {{ request('bidang') == 'Perdagangan' ? 'selected' : '' }}>Perdagangan</option>
                <option value="Perindustrian" {{ request('bidang') == 'Perindustrian' ? 'selected' : '' }}>Perindustrian</option>
                <option value="Perlindungan Konsumen" {{ request('bidang') == 'Perlindungan Konsumen' ? 'selected' : '' }}>Perlindungan Konsumen</option>
            </select>
            <select name="status" onchange="this.form.submit()"
                class="h-10 px-3 text-xs bg-slate-50 border border-gray-200 rounded-xl text-gray-700 outline-none focus:bg-white">
                <option value="">Semua Status</option>
                <option value="Aktif" {{ request('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="Cuti" {{ request('status') == 'Cuti' ? 'selected' : '' }}>Cuti</option>
            </select>
            @if(request('search') || request('bidang') || request('status'))
                <a href="{{ route('admin.data-pegawai') }}" class="h-10 px-3 bg-slate-100 hover:bg-slate-200 text-gray-600 rounded-xl text-xs font-semibold flex items-center">
                    Reset Filter
                </a>
            @endif
        </form>

        <!-- Tabel Data Pegawai dari Database Real -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs sm:text-sm">
                <thead class="bg-slate-50 text-gray-600 font-semibold border-b border-gray-200">
                    <tr>
                        <th class="py-3 px-3 whitespace-nowrap">Pegawai</th>
                        <th class="py-3 px-3 whitespace-nowrap">NIP</th>
                        <th class="py-3 px-3 whitespace-nowrap">Jabatan</th>
                        <th class="py-3 px-3 whitespace-nowrap">Bidang</th>
                        <th class="py-3 px-3 whitespace-nowrap">Akun Login</th>
                        <th class="py-3 px-3 whitespace-nowrap">Status</th>
                        <th class="py-3 px-3 text-center whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-gray-700" id="tabelPegawaiBody">
                    @forelse($employees ?? [] as $emp)
                    <tr class="hover:bg-slate-50/70 transition">
                        <td class="py-3.5 px-3">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 rounded-full bg-slate-100 text-slate-700 font-bold text-xs flex items-center justify-center shrink-0">
                                    {{ strtoupper(substr($emp->nama ?? 'P', 0, 2)) }}
                                </div>
                                <div>
                                    <p class="font-bold text-gray-900">{{ $emp->nama }}</p>
                                    <span class="text-[11px] text-gray-400 font-mono">{{ $emp->user->email ?? $emp->no_hp ?? '-' }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="py-3.5 px-3 font-mono text-gray-600 whitespace-nowrap">{{ $emp->nip }}</td>
                        <td class="py-3.5 px-3 font-medium">{{ $emp->jabatan }}</td>
                        <td class="py-3.5 px-3 whitespace-nowrap text-gray-700 font-medium">
                            {{ $emp->bidang }}
                        </td>
                        <td class="py-3.5 px-3 font-mono text-xs text-gray-600 whitespace-nowrap">
                            {{ $emp->user->username ?? '-' }}
                        </td>
                        <td class="py-3.5 px-3 whitespace-nowrap">
                            <span class="px-2.5 py-1 rounded-full {{ ($emp->status ?? 'Aktif') === 'Aktif' ? 'bg-emerald-100 text-emerald-800' : 'bg-gray-100 text-gray-800' }} text-xs font-semibold">
                                {{ $emp->status ?? 'Aktif' }}
                            </span>
                        </td>
                        <td class="py-3.5 px-3 text-center whitespace-nowrap">
                            <div class="inline-flex items-center justify-center space-x-1.5">
                                <!-- Icon 1: Detail Pegawai (Mata) -->
                                <button type="button"
                                    data-nama="{{ $emp->nama }}"
                                    data-nip="{{ $emp->nip }}"
                                    data-jabatan="{{ $emp->jabatan }}"
                                    data-bidang="{{ $emp->bidang }}"
                                    data-email="{{ $emp->user->email ?? '-' }}"
                                    data-status="{{ $emp->status ?? 'Aktif' }}"
                                    data-nohp="{{ $emp->no_hp ?? '-' }}"
                                    data-alamat="{{ $emp->alamat ?? '-' }}"
                                    onclick="bukaDetailPegawaiDariTombol(this)"
                                    title="Lihat Detail Pegawai"
                                    class="w-8 h-8 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 hover:text-slate-900 transition flex items-center justify-center cursor-pointer shadow-2xs group">
                                    <svg class="w-4 h-4 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>

                                <!-- Icon 1.5: Edit Pegawai (Pensil) -->
                                <button type="button" 
                                    onclick="bukaModalEditPegawai({{ $emp->id }}, '{{ addslashes($emp->nama) }}', '{{ $emp->nip }}', '{{ addslashes($emp->jabatan) }}', '{{ $emp->bidang }}', '{{ $emp->user->email ?? '' }}', '{{ $emp->status ?? 'Aktif' }}', '{{ $emp->no_hp ?? '' }}', '{{ addslashes(preg_replace('/\r|\n/', ' ', $emp->alamat ?? '')) }}')"
                                    title="Edit Pegawai"
                                    class="w-8 h-8 rounded-xl bg-blue-50 hover:bg-blue-100 text-blue-600 hover:text-blue-800 transition flex items-center justify-center cursor-pointer shadow-2xs border border-blue-200/60 group">
                                    <svg class="w-4 h-4 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>

                                <!-- Icon 2: Reset Kata Sandi (Kunci) -->
                                <button type="button" 
                                    onclick="bukaModalResetSandi({{ $emp->id }}, '{{ addslashes($emp->nama) }}')"
                                    title="Reset Kata Sandi"
                                    class="w-8 h-8 rounded-xl bg-amber-50 hover:bg-amber-100 text-amber-600 hover:text-amber-800 transition flex items-center justify-center cursor-pointer shadow-2xs border border-amber-200/60 group">
                                    <svg class="w-4 h-4 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                    </svg>
                                </button>

                                <!-- Icon 3: Hapus Pegawai (Tempat Sampah) -->
                                <button type="button" 
                                    onclick="bukaModalHapusPegawai({{ $emp->id }}, '{{ addslashes($emp->nama) }}')"
                                    title="Hapus Pegawai"
                                    class="w-8 h-8 rounded-xl bg-red-50 hover:bg-red-100 text-red-600 hover:text-red-800 transition flex items-center justify-center cursor-pointer shadow-2xs border border-red-200/60 group">
                                    <svg class="w-4 h-4 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-12 px-4 text-center text-gray-500">
                            <div class="flex flex-col items-center justify-center space-y-2">
                                <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                                <p class="text-sm font-bold text-gray-700">Belum Ada Data Pegawai</p>
                                <p class="text-xs text-gray-400">Silakan gunakan tombol "Tambah Pegawai Baru" untuk mendaftarkan data pegawai PPPK ke database.</p>
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
<script>
function bukaDetailPegawaiDariTombol(btn) {
    const nama = btn.getAttribute('data-nama');
    const nip = btn.getAttribute('data-nip');
    const jabatan = btn.getAttribute('data-jabatan');
    const bidang = btn.getAttribute('data-bidang');
    const email = btn.getAttribute('data-email');
    const status = btn.getAttribute('data-status');
    const noHp = btn.getAttribute('data-nohp');
    const alamat = btn.getAttribute('data-alamat');

    if (typeof window.openDetailPegawaiModal === 'function') {
        window.openDetailPegawaiModal(nama, nip, nip, jabatan, bidang, email, status, noHp, alamat);
    } else {
        const setSafe = (elemId, text) => {
            const el = document.getElementById(elemId);
            if (el) el.textContent = text || '-';
        };
        setSafe('detailNama', nama);
        setSafe('detailId', nip);
        setSafe('detailNip', nip);
        setSafe('detailJabatan', jabatan);
        setSafe('detailBidang', bidang);
        setSafe('detailEmail', email);
        setSafe('detailStatus', status || 'Aktif');
        setSafe('detailNoHp', noHp);
        setSafe('detailAlamat', alamat);
        openModal('modalDetailPegawai');
    }
}

function bukaModalEditPegawai(id, nama, nip, jabatan, bidang, email, status, noHp, alamat) {
    document.getElementById('formEditPegawai').action = `{{ url('admin/pegawai') }}/${id}`;
    
    document.getElementById('edit_nama').value = nama;
    document.getElementById('edit_nip').value = nip;
    document.getElementById('edit_jabatan').value = jabatan;
    document.getElementById('edit_bidang').value = bidang;
    document.getElementById('edit_email').value = email;
    document.getElementById('edit_status').value = status;
    document.getElementById('edit_no_hp').value = noHp;
    document.getElementById('edit_alamat').value = alamat;
    
    openModal('modalEditPegawai');
}

function bukaModalResetSandi(id, nama) {
    document.getElementById('resetPegawaiNama').textContent = nama;
    document.getElementById('formResetSandiPegawai').action = `{{ url('admin/pegawai') }}/${id}/reset-password`;
    openModal('modalResetSandiPegawai');
}

function bukaModalHapusPegawai(id, nama) {
    document.getElementById('hapusPegawaiNama').textContent = nama;
    document.getElementById('formHapusPegawai').action = `{{ url('admin/pegawai') }}/${id}`;
    openModal('modalHapusPegawai');
}
</script>
@endpush
@endsection
