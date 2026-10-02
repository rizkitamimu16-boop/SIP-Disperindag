@extends('layouts.pegawai')

@section('title', 'Profil - Panel Pegawai')

@section('header_title', 'Profil Pegawai')
@section('header_subtitle', 'Informasi kepegawaian dan pengaturan akun')

@section('content')
<div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-xs mb-6">
    <h2 class="text-lg font-bold text-gray-900">Profil & Data Diri Pegawai PPPK</h2>
    <p class="text-xs text-gray-500 mt-0.5">Informasi kepegawaian resmi, instansi unit kerja, dan
        pengaturan akun</p>
</div>

@if(session('success'))
<div class="p-4 mb-6 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-900 flex items-start space-x-3 shadow-xs animate-in fade-in duration-200">
    <svg class="w-5 h-5 text-emerald-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
    </svg>
    <div class="flex-1 text-xs">
        <h4 class="font-bold text-sm text-emerald-950">Berhasil</h4>
        <p class="mt-0.5">{{ session('success') }}</p>
    </div>
</div>
@endif

@if($errors->any())
<div class="p-4 mb-6 rounded-2xl bg-red-50 border border-red-200 text-red-900 flex items-start space-x-3 shadow-xs animate-in fade-in duration-200">
    <svg class="w-5 h-5 text-red-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
    </svg>
    <div class="flex-1 text-xs">
        <h4 class="font-bold text-sm text-red-950">Gagal Memperbarui Profil</h4>
        <ul class="list-disc list-inside mt-1 space-y-0.5">
            @foreach($errors->all() as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
</div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <!-- Kartu Identitas (1 Kolom) -->
    <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-xs text-center space-y-4">
        <div class="relative w-24 h-24 mx-auto">
            <div
                class="w-24 h-24 rounded-full bg-[#0D2240] text-white font-extrabold text-2xl flex items-center justify-center border-4 border-slate-100 shadow-md">
                {{ strtoupper(substr($employee->full_name ?? auth()->user()->name ?? 'RA', 0, 2)) }}
            </div>
            <span
                class="absolute bottom-1 right-1 w-5 h-5 bg-emerald-500 border-2 border-white rounded-full"></span>
        </div>

        <div>
            <h3 class="text-base font-bold text-gray-900">{{ $employee->full_name ?? auth()->user()->name ?? 'Pegawai PPPK' }}</h3>
            <p class="text-xs font-semibold text-[#0D2240]">{{ $employee->position ?? 'Pegawai DISPERDAGIN' }}</p>
            <p class="text-[11px] text-gray-500 mt-0.5">{{ !empty($employee->nip) ? 'NIP PPPK: ' . $employee->nip : 'NIP Belum Diisi' }}</p>
        </div>

        <div class="pt-3 border-t border-gray-100 space-y-2 text-xs text-left">
            <div>
                <span class="text-gray-400 block text-[10px] uppercase font-bold">Instansi</span>
                <span class="font-semibold text-gray-800">{{ $officeSettings->agency_name ?? 'Dinas Perdagangan dan Perindustrian' }}</span>
            </div>
            <div>
                <span class="text-gray-400 block text-[10px] uppercase font-bold">Unit / Bidang</span>
                <span class="font-semibold text-gray-800">{{ $employee->department ?? 'Perdagangan' }}</span>
            </div>
            <div>
                <span class="text-gray-400 block text-[10px] uppercase font-bold">Masa Kontrak Kerja</span>
                <span class="font-semibold text-emerald-700">{{ $employee->contract_period ?? 'Periode Aktif' }}</span>
            </div>
        </div>
    </div>

    <!-- Form Ubah Biodata & Password (2 Kolom) -->
    <form action="{{ route('pegawai.profil.update') }}" method="POST" class="lg:col-span-2 bg-white rounded-2xl border border-gray-200 p-6 shadow-xs space-y-6">
        @csrf
        <div>
            <h3 class="text-sm font-bold text-gray-900 pb-2 border-b border-gray-100">Informasi Kontak</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-3">
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Email Kedinasan</label>
                    <input type="email" value="{{ auth()->user()->email ?? '' }}"
                        class="w-full text-xs bg-gray-50 border border-gray-300 rounded-xl p-2.5 text-gray-800">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Nomor WhatsApp / HP</label>
                    <input type="tel" name="no_hp" value="{{ $employee->phone ?? '' }}" class="w-full text-xs bg-gray-50 border border-gray-300 rounded-xl p-2.5 text-gray-800">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-gray-700 mb-1">Alamat Domisili</label>
                    <input type="text" name="alamat" value="{{ $employee->address ?? '' }}" class="w-full text-xs bg-gray-50 border border-gray-300 rounded-xl p-2.5 text-gray-800"></div></div></div><div><h3 class="text-sm font-bold text-gray-900 pb-2 border-b border-gray-100">Ubah Kata Sandi
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-3">
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Kata Sandi Baru</label>
                    <div class="relative">
                        <input type="password" name="password" id="profilPassword" placeholder="Minimal 8 karakter"
                            class="w-full text-xs bg-gray-50 border border-gray-300 rounded-xl p-2.5 text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#0D2240] focus:bg-white">
                        <button type="button" onclick="togglePasswordVisibility('profilPassword', this)" class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-400 hover:text-gray-600 cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        </button>
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Konfirmasi Kata Sandi</label>
                    <div class="relative">
                        <input type="password" name="password_confirmation" id="profilPasswordConfirm" placeholder="Ulangi kata sandi baru"
                            class="w-full text-xs bg-gray-50 border border-gray-300 rounded-xl p-2.5 text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#0D2240] focus:bg-white">
                        <button type="button" onclick="togglePasswordVisibility('profilPasswordConfirm', this)" class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-400 hover:text-gray-600 cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-2">
            <button type="submit"
                class="py-2.5 px-5 rounded-xl bg-[#0D2240] hover:bg-[#163660] text-white text-xs sm:text-sm font-bold shadow-sm transition active:scale-98 cursor-pointer">
                Simpan Perubahan Profil
            </button>
        </div>
    </form>

</div>
@push('scripts')
<script>
    function togglePasswordVisibility(inputId, btn) {
        const input = document.getElementById(inputId);
        if (input.type === 'password') {
            input.type = 'text';
            btn.innerHTML = '<svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.29 3.29m0 0a9.97 9.97 0 015.71-2.29c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" /></svg>';
        } else {
            input.type = 'password';
            btn.innerHTML = '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>';
        }
    }
</script>
@endpush
@endsection
