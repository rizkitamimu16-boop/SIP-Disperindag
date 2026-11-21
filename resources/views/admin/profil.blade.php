@extends('layouts.admin')

@section('title', 'Profil Pengguna - Panel Administrator')

@section('header_title', 'Profil Saya')
@section('header_subtitle', 'Informasi akun dinas, bidang penugasan, dan pengaturan profil')

@section('content')
<div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-xs mb-6">
    <div class="flex items-center space-x-3">
        <div class="w-10 h-10 rounded-xl bg-[#0D2240] text-white flex items-center justify-center font-bold text-sm shadow-xs">
            {{ strtoupper(substr($user->nama ?? 'AD', 0, 2)) }}
        </div>
        <div>
            <h2 class="text-base sm:text-lg font-bold text-gray-900">Profil &amp; Informasi Akun Kedinasan</h2>
            <p class="text-xs text-gray-500 mt-0.5">Kelola identitas resmi, penugasan unit kerja, dan kredensial akses sistem</p>
        </div>
    </div>
</div>

@if(session('success'))
<div class="p-4 mb-6 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-900 flex items-start space-x-3 shadow-xs animate-in fade-in duration-200">
    <svg class="w-5 h-5 text-emerald-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
    </svg>
    <div class="flex-1 text-xs">
        <h4 class="font-bold text-sm text-emerald-950">Berhasil Disimpan</h4>
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
            @if($user->avatar_url)
                <img src="{{ $user->avatar_url }}" alt="{{ $user->nama }}" class="w-24 h-24 rounded-full object-cover border-4 border-slate-100 shadow-md mx-auto">
            @else
                <div class="w-24 h-24 rounded-full bg-[#0D2240] text-white font-extrabold text-2xl flex items-center justify-center border-4 border-slate-100 shadow-md mx-auto">
                    {{ strtoupper(substr($user->nama ?? 'AD', 0, 2)) }}
                </div>
            @endif
            <span class="absolute bottom-1 right-1 w-5 h-5 bg-emerald-500 border-2 border-white rounded-full" title="Akun Aktif"></span>
        </div>

        <div>
            <h3 class="text-base font-bold text-gray-900">{{ $user->nama }}</h3>
            <p class="text-xs font-semibold text-[#0D2240]">{{ $user->department }}</p>
            <p class="text-[11px] text-gray-500 font-mono mt-0.5">Username: &#64;{{ $user->username }}</p>
        </div>

        <div class="pt-3 border-t border-gray-100 space-y-2.5 text-xs text-left">
            <div>
                <span class="text-gray-400 block text-[10px] uppercase font-bold">Instansi</span>
                <span class="font-semibold text-gray-800">{{ $officeSettings->nama_skpd ?? 'Dinas Perdagangan dan Perindustrian Kota Gorontalo' }}</span>
            </div>
            <div>
                <span class="text-gray-400 block text-[10px] uppercase font-bold">Unit / Bidang Penugasan</span>
                <span class="font-semibold text-gray-800">{{ $user->bidang ? 'Bidang ' . $user->bidang : 'Semua Bidang (Global SKPD)' }}</span>
            </div>
            <div>
                <span class="text-gray-400 block text-[10px] uppercase font-bold">Peran Akses</span>
                <span class="inline-block mt-0.5 px-2.5 py-0.5 rounded-md {{ $user->isKabid() ? 'bg-purple-100 text-purple-800 font-bold' : ($user->isSuperAdmin() ? 'bg-emerald-100 text-emerald-800 font-bold' : 'bg-blue-100 text-blue-800 font-bold') }}">
                    {{ $user->department }}
                </span>
            </div>
            <div>
                <span class="text-gray-400 block text-[10px] uppercase font-bold">Nomor Kontak</span>
                <span class="font-semibold text-gray-800">{{ $user->no_hp ?? '-' }}</span>
            </div>
        </div>
    </div>

    <!-- Form Ubah Biodata & Password (2 Kolom) -->
    <form action="{{ route('admin.profil.update') }}" method="POST" enctype="multipart/form-data" class="lg:col-span-2 bg-white rounded-2xl border border-gray-200 p-6 shadow-xs space-y-6">
        @csrf
        <div>
            <h3 class="text-sm font-bold text-gray-900 pb-2 border-b border-gray-100">Informasi Akun &amp; Kontak</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-3">
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" name="nama" value="{{ old('nama', $user->nama) }}" required
                        class="w-full text-xs bg-slate-50 border border-gray-300 rounded-xl p-2.5 text-gray-800 focus:bg-white focus:outline-none focus:ring-1 focus:ring-[#0D2240]">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Username Login</label>
                    <input type="text" value="{{ $user->username }}" disabled
                        class="w-full text-xs bg-gray-100 border border-gray-200 rounded-xl p-2.5 text-gray-500 cursor-not-allowed font-mono">
                    <span class="text-[10px] text-gray-400 mt-0.5 block">Username login dikelola oleh Administrator Utama</span>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Email Kedinasan <span class="text-red-500">*</span></label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                        class="w-full text-xs bg-slate-50 border border-gray-300 rounded-xl p-2.5 text-gray-800 focus:bg-white focus:outline-none focus:ring-1 focus:ring-[#0D2240]">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Nomor WhatsApp / HP</label>
                    <input type="tel" name="no_hp" value="{{ old('no_hp', $user->no_hp) }}" placeholder="Contoh: 081234567890"
                        class="w-full text-xs bg-slate-50 border border-gray-300 rounded-xl p-2.5 text-gray-800 focus:bg-white focus:outline-none focus:ring-1 focus:ring-[#0D2240]">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-gray-700 mb-1">Foto Profil Baru (Opsional)</label>
                    <input type="file" name="foto" accept="image/*"
                        class="w-full text-xs bg-slate-50 border border-gray-300 rounded-xl p-2 text-gray-700 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-[#0D2240] file:text-white hover:file:bg-[#163660] cursor-pointer">
                    <span class="text-[10px] text-gray-400 mt-1 block">Format diperbolehkan: JPG, PNG, WEBP. Maksimal ukuran file: 2 MB.</span>
                </div>
            </div>
        </div>

        <div>
            <h3 class="text-sm font-bold text-gray-900 pb-2 border-b border-gray-100">Ubah Kata Sandi (Opsional)</h3>
            <p class="text-xs text-gray-500 mt-1">Kosongkan kolom berikut jika tidak bermaksud mengubah kata sandi akun login.</p>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-3">
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Kata Sandi Baru</label>
                    <input type="password" name="password" placeholder="Minimal 6 karakter"
                        class="w-full text-xs bg-slate-50 border border-gray-300 rounded-xl p-2.5 text-gray-800 focus:bg-white focus:outline-none focus:ring-1 focus:ring-[#0D2240]">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Konfirmasi Kata Sandi Baru</label>
                    <input type="password" name="password_confirmation" placeholder="Ulangi kata sandi baru"
                        class="w-full text-xs bg-slate-50 border border-gray-300 rounded-xl p-2.5 text-gray-800 focus:bg-white focus:outline-none focus:ring-1 focus:ring-[#0D2240]">
                </div>
            </div>
        </div>

        <div class="flex justify-end pt-3 border-t border-gray-100">
            <button type="submit"
                class="px-6 py-2.5 bg-[#0D2240] hover:bg-[#163660] text-white rounded-xl text-xs font-bold shadow-xs transition flex items-center space-x-2 cursor-pointer">
                <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
                <span>Simpan Perubahan Profil</span>
            </button>
        </div>
    </form>

</div>
@endsection
