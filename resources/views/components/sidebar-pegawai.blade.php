<!-- ===================================================================
     SIDEBAR PEGAWAI (8 Menu Navigasi Pegawai)
     =================================================================== -->
<aside id="sidebar"
    class="fixed inset-y-0 left-0 w-64 bg-[#0D2240] text-white flex flex-col justify-between z-50 transform -translate-x-full lg:translate-x-0 transition-transform duration-200 ease-in-out">

    <!-- Bagian Atas Sidebar -->
    <div class="flex flex-col flex-1 overflow-y-auto">

        <!-- Header Sidebar (Logo & Nama Sistem) -->
        <div class="h-16 px-5 flex items-center justify-between border-b border-slate-700/60 shrink-0">
            <div class="flex items-center space-x-3">
                <img src="{{ asset('assets/img/logo-kota-gorontalo.png') }}" alt="Logo Kota Gorontalo"
                    class="w-8 h-9 object-contain shrink-0">
                <div>
                    <h1 class="text-sm font-bold leading-tight text-white">Sistem Absensi</h1>
                    <p class="text-[11px] text-slate-300">DISPERDAGIN • Pegawai</p>
                </div>
            </div>
            <button id="closeSidebarBtn"
                class="lg:hidden text-slate-300 hover:text-white p-1 rounded focus:outline-none cursor-pointer"
                aria-label="Tutup Menu">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- 7 Menu Utama Pegawai -->
        <nav class="p-3 space-y-1 text-sm font-medium" id="pegawaiNavMenu">

            <!-- 1. Dashboard -->
            <a href="{{ url('pegawai/dashboard') }}" 
                class="pegawai-nav-item {{ request()->is('pegawai/dashboard') ? 'active bg-white/10 text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }} flex items-center space-x-3 px-3.5 py-2.5 rounded-xl transition">
                <svg class="w-4.5 h-4.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <span>Dashboard</span>
            </a>

            <!-- 2. Riwayat Absensi -->
            <a href="{{ url('pegawai/riwayat-absensi') }}" 
                class="pegawai-nav-item {{ request()->is('pegawai/riwayat-absensi*', 'pegawai/absensi*') ? 'active bg-white/10 text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }} flex items-center space-x-3 px-3.5 py-2.5 rounded-xl transition">
                <svg class="w-4.5 h-4.5 shrink-0" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span>Riwayat Absensi</span>
            </a>

            <!-- 3. Kegiatan -->
            <a href="{{ url('pegawai/kegiatan') }}" 
                class="pegawai-nav-item {{ request()->is('pegawai/kegiatan*') ? 'active bg-white/10 text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }} flex items-center space-x-3 px-3.5 py-2.5 rounded-xl transition">
                <svg class="w-4.5 h-4.5 shrink-0" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <span>Kegiatan</span>
            </a>

            <!-- 4. Pengajuan -->
            <a href="{{ url('pegawai/pengajuan') }}" 
                class="pegawai-nav-item {{ request()->is('pegawai/pengajuan*') ? 'active bg-white/10 text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }} flex items-center space-x-3 px-3.5 py-2.5 rounded-xl transition">
                <svg class="w-4.5 h-4.5 shrink-0" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                </svg>
                <span>Pengajuan</span>
            </a>

            <!-- 5. Kinerja -->
            <a href="{{ url('pegawai/kinerja') }}" 
                class="pegawai-nav-item {{ request()->is('pegawai/kinerja*') ? 'active bg-white/10 text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }} flex items-center space-x-3 px-3.5 py-2.5 rounded-xl transition">
                <svg class="w-4.5 h-4.5 shrink-0" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
                <span>Kinerja</span>
            </a>

            <!-- 6. Pelanggaran / SP -->
            <a href="{{ url('pegawai/pelanggaran-sp') }}" 
                class="pegawai-nav-item {{ request()->is('pegawai/pelanggaran-sp*', 'pegawai/sp*') ? 'active bg-white/10 text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }} flex items-center space-x-3 px-3.5 py-2.5 rounded-xl transition">
                <svg class="w-4.5 h-4.5 shrink-0 {{ request()->is('pegawai/pelanggaran-sp*', 'pegawai/sp*') ? '' : 'text-amber-400' }}" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <span>Pelanggaran / SP</span>
            </a>

            <!-- 7. Profil -->
            <a href="{{ url('pegawai/profil') }}" 
                class="pegawai-nav-item {{ request()->is('pegawai/profil') ? 'active bg-white/10 text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }} flex items-center space-x-3 px-3.5 py-2.5 rounded-xl transition">
                <svg class="w-4.5 h-4.5 shrink-0" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                <span>Profil</span>
            </a>

        </nav>
    </div>

    <!-- Bagian Bawah Sidebar (Profil Pegawai & Logout) -->
    <div class="p-3 border-t border-slate-700/60 bg-slate-900/40">
        <div class="flex items-center justify-between p-2 rounded-lg">
            <div class="flex items-center space-x-3">
                <div
                    class="w-9 h-9 rounded-full bg-[#163660] border border-white/20 flex items-center justify-center font-bold text-white text-xs shrink-0">
                    {{ strtoupper(substr(auth()->user()->name ?? 'Pegawai', 0, 2)) }}
                </div>
                <div class="overflow-hidden">
                    <p class="text-xs font-semibold text-white truncate">{{ auth()->user()->name ?? 'Pegawai PPPK' }}</p>
                    <p class="text-[11px] text-slate-400 truncate">{{ auth()->user()->role ?? 'Staf PPPK' }} • DISPERDAGIN</p>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" title="Keluar Akun" class="p-1.5 text-slate-400 hover:text-red-400 rounded transition cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                </button>
            </form>
        </div>
    </div>

</aside>
