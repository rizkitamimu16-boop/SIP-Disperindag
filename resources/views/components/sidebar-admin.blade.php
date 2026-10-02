<!-- ===================================================================
     SIDEBAR ADMIN (11 Menu Panel Administrator)
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
                    <p class="text-[11px] text-slate-300">DISPERDAGIN • Admin</p>
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

        <!-- 11 Menu Utama Administrator -->
        <nav class="p-3 space-y-1 text-sm font-medium" id="adminNavMenu">

            <!-- 1. Dashboard -->
            <a href="{{ url('admin/dashboard') }}" data-section="sec-dashboard" aria-current="{{ request()->is('admin/dashboard') ? 'page' : 'false' }}"
                class="admin-nav-item {{ request()->is('admin/dashboard') ? 'active text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }} flex items-center space-x-3 px-3.5 py-2.5 rounded-xl transition">
                <svg class="w-4.5 h-4.5 {{ request()->is('admin/dashboard') ? 'text-white' : 'text-slate-400' }} shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <span>Dashboard</span>
            </a>

            <!-- 2. Data Pegawai -->
            <a href="{{ url('admin/data-pegawai') }}" data-section="sec-pegawai"
                class="admin-nav-item {{ request()->is('admin/data-pegawai*', 'admin/pegawai*') ? 'active text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }} flex items-center space-x-3 px-3.5 py-2.5 rounded-xl transition">
                <svg class="w-4.5 h-4.5 {{ request()->is('admin/data-pegawai*', 'admin/pegawai*') ? 'text-white' : 'text-slate-400' }} shrink-0" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <span>Data Pegawai</span>
            </a>

            <!-- 3. Monitoring Absensi -->
            <a href="{{ url('admin/monitoring-absensi') }}" data-section="sec-absensi"
                class="admin-nav-item {{ request()->is('admin/monitoring-absensi*', 'admin/absensi*') ? 'active text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }} flex items-center space-x-3 px-3.5 py-2.5 rounded-xl transition">
                <svg class="w-4.5 h-4.5 {{ request()->is('admin/monitoring-absensi*', 'admin/absensi*') ? 'text-white' : 'text-slate-400' }} shrink-0" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24" stroke-width="2">
                    <circle cx="12" cy="12" r="10" />
                    <polyline points="12 6 12 12 16 14" />
                </svg>
                <span>Monitoring Absensi</span>
            </a>

            <!-- 4. Laporan Kegiatan -->
            <a href="{{ url('admin/laporan-kegiatan') }}" data-section="sec-kegiatan"
                class="admin-nav-item {{ request()->is('admin/laporan-kegiatan*', 'admin/kegiatan*') ? 'active text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }} flex items-center space-x-3 px-3.5 py-2.5 rounded-xl transition">
                <svg class="w-4.5 h-4.5 {{ request()->is('admin/laporan-kegiatan*', 'admin/kegiatan*') ? 'text-white' : 'text-slate-400' }} shrink-0" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <span>Laporan Kegiatan</span>
            </a>

            <!-- 5. Persetujuan Izin & Cuti -->
            <a href="{{ url('admin/persetujuan-izin-cuti') }}" data-section="sec-pengajuan"
                class="admin-nav-item {{ request()->is('admin/persetujuan-izin-cuti*', 'admin/pengajuan*') ? 'active text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }} flex items-center space-x-3 px-3.5 py-2.5 rounded-xl transition">
                <svg class="w-4.5 h-4.5 {{ request()->is('admin/persetujuan-izin-cuti*', 'admin/pengajuan*') ? 'text-white' : 'text-slate-400' }} shrink-0" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                </svg>
                <span>Persetujuan Izin &amp; Cuti</span>
            </a>

            <!-- 6. Indeks Kinerja -->
            <a href="{{ url('admin/indeks-kinerja') }}" data-section="sec-kinerja"
                class="admin-nav-item {{ request()->is('admin/indeks-kinerja*', 'admin/kinerja*') ? 'active text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }} flex items-center space-x-3 px-3.5 py-2.5 rounded-xl transition">
                <svg class="w-4.5 h-4.5 {{ request()->is('admin/indeks-kinerja*', 'admin/kinerja*') ? 'text-white' : 'text-slate-400' }} shrink-0" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
                <span>Indeks Kinerja</span>
            </a>

            <!-- 7. Surat Peringatan (SP) -->
            <a href="{{ url('admin/surat-peringatan') }}" data-section="sec-sp"
                class="admin-nav-item {{ request()->is('admin/surat-peringatan*', 'admin/sp*') ? 'active text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }} flex items-center space-x-3 px-3.5 py-2.5 rounded-xl transition">
                <svg class="w-4.5 h-4.5 {{ request()->is('admin/surat-peringatan*', 'admin/sp*') ? 'text-white' : 'text-red-400' }} shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <span>Surat Peringatan (SP)</span>
            </a>

            <!-- 8. Pusat Laporan -->
            <a href="{{ url('admin/pusat-laporan') }}" data-section="sec-laporan"
                class="admin-nav-item {{ request()->is('admin/pusat-laporan*') ? 'active text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }} flex items-center space-x-3 px-3.5 py-2.5 rounded-xl transition">
                <svg class="w-4.5 h-4.5 {{ request()->is('admin/pusat-laporan*') ? 'text-white' : 'text-slate-400' }} shrink-0" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                <span>Pusat Laporan</span>
            </a>

            <!-- 9. Pengaturan Sistem -->
            <a href="{{ url('admin/pengaturan-sistem') }}" data-section="sec-pengaturan"
                class="admin-nav-item {{ request()->is('admin/pengaturan-sistem*', 'admin/pengaturan*') ? 'active text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }} flex items-center space-x-3 px-3.5 py-2.5 rounded-xl transition">
                <svg class="w-4.5 h-4.5 {{ request()->is('admin/pengaturan-sistem*', 'admin/pengaturan*') ? 'text-white' : 'text-slate-400' }} shrink-0" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <circle cx="12" cy="12" r="3" />
                </svg>
                <span>Pengaturan Sistem</span>
            </a>

        </nav>
    </div>

    <!-- Footer Sidebar (Profil Administrator & Logout) -->
    <div class="p-3 border-t border-slate-700/60 bg-slate-900/40">
        <div class="flex items-center justify-between p-2 rounded-lg">
            <div class="flex items-center space-x-3">
                <div
                    class="w-9 h-9 rounded-full bg-[#163660] border border-white/20 flex items-center justify-center font-bold text-white text-xs shrink-0">
                    {{ strtoupper(substr(auth()->user()->name ?? 'AD', 0, 2)) }}
                </div>
                <div class="overflow-hidden">
                    <p class="text-xs font-semibold text-white truncate">{{ auth()->user()->name ?? 'Administrator' }}</p>
                    <p class="text-[11px] text-slate-400 truncate">{{ auth()->user()->department ?? 'Sekretariat' }}</p>
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
