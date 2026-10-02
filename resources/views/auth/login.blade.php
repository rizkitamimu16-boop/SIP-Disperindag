@extends('layouts.auth')

@section('title', 'Masuk - Absensi Pegawai PPPK DISPERDAGIN')

@section('content')
<div class="min-h-screen grid grid-cols-1 lg:grid-cols-2">

    <!-- Kolom Kiri: Informasi Sistem (Tampil pada Desktop) -->
    <div class="hidden lg:flex flex-col justify-between bg-[#0D2240] text-white p-12 relative overflow-hidden">
        
        <!-- Header Kolom Kiri -->
        <div class="flex items-center space-x-4">
            <img src="{{ asset('assets/img/logo-kota-gorontalo.png') }}" alt="Logo Kota Gorontalo" class="w-12 h-14 object-contain shrink-0">
            <div>
                <h1 class="text-xl font-bold leading-tight">Absensi Pegawai PPPK</h1>
                <p class="text-sm text-slate-300">Dinas Perindustrian dan Perdagangan</p>
            </div>
        </div>

        <!-- Konten Utama Kolom Kiri -->
        <div class="max-w-lg my-auto py-8">
            <h2 class="text-3xl font-extrabold leading-snug mb-4">
                Kehadiran pegawai tercatat tepat waktu, tepat lokasi.
            </h2>
            <p class="text-slate-300 text-base leading-relaxed mb-8">
                Satu portal untuk absen masuk dan pulang, pengajuan izin, serta pemantauan kehadiran seluruh pegawai PPPK di lingkungan kantor DISPERDAGIN.
            </p>

            <!-- Daftar Fitur -->
            <div class="space-y-4">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-full bg-slate-800/80 border border-sky-400/20 flex items-center justify-center text-sky-400 shrink-0">
                        <!-- Icon Lokasi -->
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/>
                            <circle cx="12" cy="9" r="2.5"/>
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-slate-100">Validasi GPS radius 50 m</span>
                </div>

                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-full bg-slate-800/80 border border-sky-400/20 flex items-center justify-center text-sky-400 shrink-0">
                        <!-- Icon Jam -->
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/>
                            <polyline points="12 6 12 12 16 14"/>
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-slate-100">Jam kerja 08:00–16:00 WITA</span>
                </div>

                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-full bg-slate-800/80 border border-sky-400/20 flex items-center justify-center text-sky-400 shrink-0">
                        <!-- Icon Rekap Otomatis -->
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-slate-100">Rekap kehadiran otomatis</span>
                </div>
            </div>
        </div>

        <!-- Footer Kolom Kiri -->
        <div class="text-xs text-slate-400 border-t border-slate-700/60 pt-4">
            © 2026 Sekretariat DISPERDAGIN • Sekretariat
        </div>
    </div>

    <!-- Kolom Kanan: Card Login -->
    <div class="flex flex-col justify-center items-center p-4 sm:p-8 lg:p-12">
        
        <!-- Header Ringkas Mobile (Hanya tampil di layar HP) -->
        <div class="w-full max-w-md lg:hidden flex items-center space-x-3 bg-[#0D2240] text-white p-4 rounded-xl mb-6 shadow-sm">
            <img src="{{ asset('assets/img/logo-kota-gorontalo.png') }}" alt="Logo Kota Gorontalo" class="w-10 h-12 object-contain shrink-0">
            <div>
                <h2 class="text-base font-bold leading-tight">Absensi Pegawai PPPK</h2>
                <p class="text-xs text-slate-300">Dinas Perindustrian dan Perdagangan</p>
            </div>
        </div>

        <!-- Card Formulir Login -->
        <div class="w-full max-w-md bg-white p-6 sm:p-8 rounded-2xl shadow-sm border border-gray-200">
            
            <!-- Judul & Deskripsi Login -->
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-gray-900">Masuk ke akun Anda</h2>
                <p class="text-sm text-gray-500 mt-1">Gunakan kredensial resmi terdaftar di database untuk masuk ke sistem.</p>
            </div>

            <!-- Notifikasi Error / Sukses -->
            @if($errors->any())
            <div class="p-3.5 mb-5 rounded-xl bg-red-50 border border-red-200 text-xs text-red-700 flex items-start space-x-2.5">
                <svg class="w-4 h-4 text-red-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="8" x2="12" y2="12"></line>
                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                </svg>
                <div class="space-y-0.5">
                    @foreach($errors->all() as $err)
                        <p class="font-semibold">{{ $err }}</p>
                    @endforeach
                </div>
            </div>
            @endif

            @if(session('success'))
            <div class="p-3.5 mb-5 rounded-xl bg-emerald-50 border border-emerald-200 text-xs text-emerald-700 flex items-center space-x-2">
                <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
                <p class="font-semibold">{{ session('success') }}</p>
            </div>
            @endif

            <!-- Pilihan Role (Tab Selector) -->
            @php $currentRole = old('role', 'pegawai'); @endphp
            <div class="bg-gray-100 p-1 rounded-full flex mb-6">
                <button type="button" id="rolePegawai" class="flex-1 py-2 text-sm rounded-full shadow-sm transition cursor-pointer {{ $currentRole === 'pegawai' ? 'bg-white text-gray-900 font-semibold' : 'text-gray-600 font-medium' }}">
                    Pegawai
                </button>
                <button type="button" id="roleAdmin" class="flex-1 py-2 text-sm rounded-full shadow-sm transition cursor-pointer {{ $currentRole === 'admin' ? 'bg-white text-gray-900 font-semibold' : 'text-gray-600 font-medium' }}">
                    Administrator
                </button>
            </div>

            <!-- Form Login -->
            <form id="loginForm" method="POST" action="{{ route('login.post') }}" class="space-y-4">
                @csrf
                <input type="hidden" id="selectedRole" name="role" value="{{ $currentRole }}">

                <!-- Input Username -->
                <div>
                    <label for="username" class="block text-sm font-semibold text-gray-800 mb-1">
                        Username / Email
                    </label>
                    <input 
                        type="text" 
                        id="username" 
                        name="username" 
                        value="{{ old('username') }}"
                        placeholder="Contoh: admin atau rani.ayu" 
                        class="w-full h-11 px-3.5 bg-white border border-gray-300 rounded-lg text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#0D2240] focus:border-transparent transition"
                        required
                        autofocus
                    >
                </div>

                <!-- Input Password -->
                <div>
                    <div class="flex justify-between items-center mb-1">
                        <label for="password" class="text-sm font-semibold text-gray-800">
                            Kata Sandi
                        </label>
                        <a href="#" onclick="alert('Silakan hubungi Administrator personalia untuk reset kata sandi Anda.'); return false;" class="text-xs font-medium text-blue-600 hover:underline">
                            Lupa kata sandi?
                        </a>
                    </div>
                    <div class="relative">
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            placeholder="Masukkan kata sandi akun" 
                            class="w-full h-11 pl-3.5 pr-10 bg-white border border-gray-300 rounded-lg text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#0D2240] focus:border-transparent transition"
                            required
                        >
                        <button 
                            type="button" 
                            id="togglePassword" 
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 cursor-pointer"
                            aria-label="Lihat kata sandi"
                        >
                            <!-- Eye Icon -->
                            <svg id="eyeIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <!-- Eye Off Icon -->
                            <svg id="eyeOffIcon" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Checkbox Ingat Perangkat -->
                <div class="flex items-center">
                    <input 
                        type="checkbox" 
                        id="remember" 
                        name="remember" 
                        class="w-4 h-4 text-[#0D2240] border-gray-300 rounded focus:ring-[#0D2240]"
                    >
                    <label for="remember" class="ml-2 text-sm text-gray-600 select-none">
                        Ingat perangkat ini
                    </label>
                </div>

                <!-- Tombol Masuk -->
                <button 
                    type="submit" 
                    id="btnSubmit" 
                    class="w-full h-11 bg-[#0D2240] hover:bg-[#163660] active:bg-[#08172c] text-white text-sm font-semibold rounded-lg shadow-sm transition duration-150 flex items-center justify-center cursor-pointer"
                >
                    Masuk ke Sistem
                </button>
            </form>

        </div>

        <!-- Footer Mobile -->
        <p class="mt-6 text-xs text-gray-400 text-center lg:hidden">
            © 2026 Sekretariat DISPERDAGIN
        </p>

    </div>

</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');
        const eyeOffIcon = document.getElementById('eyeOffIcon');
        
        const rolePegawai = document.getElementById('rolePegawai');
        const roleAdmin = document.getElementById('roleAdmin');
        const selectedRole = document.getElementById('selectedRole');
        const loginForm = document.getElementById('loginForm');

        // Toggle visibility password
        if (togglePassword) {
            togglePassword.addEventListener('click', () => {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                
                eyeIcon.classList.toggle('hidden');
                eyeOffIcon.classList.toggle('hidden');
            });
        }

        // Toggle Role Selector (Pegawai vs Admin)
        if (rolePegawai && roleAdmin) {
            rolePegawai.addEventListener('click', () => {
                rolePegawai.classList.add('bg-white', 'text-gray-900', 'shadow-sm', 'font-semibold');
                rolePegawai.classList.remove('text-gray-600', 'font-medium');
                
                roleAdmin.classList.remove('bg-white', 'text-gray-900', 'shadow-sm', 'font-semibold');
                roleAdmin.classList.add('text-gray-600', 'font-medium');
                
                selectedRole.value = 'pegawai';
            });

            roleAdmin.addEventListener('click', () => {
                roleAdmin.classList.add('bg-white', 'text-gray-900', 'shadow-sm', 'font-semibold');
                roleAdmin.classList.remove('text-gray-600', 'font-medium');
                
                rolePegawai.classList.remove('bg-white', 'text-gray-900', 'shadow-sm', 'font-semibold');
                rolePegawai.classList.add('text-gray-600', 'font-medium');
                
                selectedRole.value = 'admin';
            });
        }

        // Handle Submit Real (Tampilkan indikator loading saat submit ke backend)
        if (loginForm) {
            loginForm.addEventListener('submit', () => {
                const btnSubmit = document.getElementById('btnSubmit');
                btnSubmit.innerHTML = `
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Memverifikasi...
                `;
                btnSubmit.classList.add('opacity-80', 'cursor-not-allowed');
            });
        }
    });
</script>
@endpush
@endsection
