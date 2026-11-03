<!-- Komponen Lonceng Notifikasi Interaktif -->
<div class="relative" id="notifDropdownContainer">
    <!-- Tombol Lonceng -->
    <button type="button" 
        id="notifBellBtn"
        onclick="toggleNotifDropdown(event)"
        aria-label="Notifikasi"
        class="relative p-2 rounded-2xl text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition-all focus:outline-none cursor-pointer flex items-center justify-center">
        
        <!-- Icon Lonceng (Bell) -->
        <svg class="w-6 h-6 text-slate-700 hover:text-[#0D2240] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
        </svg>

        <!-- Badge Merah Counter Notifikasi -->
        @if(($notifCount ?? 0) > 0)
            <span class="absolute -top-1 -right-1 flex h-5 min-w-5 px-1.5 items-center justify-center rounded-full bg-rose-500 text-[10px] font-extrabold text-white ring-2 ring-white shadow-xs animate-pulse">
                {{ $notifCount > 9 ? '9+' : $notifCount }}
            </span>
        @endif
    </button>

    <!-- Popup Dropdown Notifikasi -->
    <div id="notifDropdownMenu" 
        style="width: 390px; max-width: calc(100vw - 2rem); box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);"
        class="hidden absolute right-0 mt-2.5 bg-white rounded-2xl border border-slate-200/80 z-50 overflow-hidden transform transition-all duration-200 origin-top-right">
        
        <!-- Header Popup -->
        <div class="px-4 py-3 bg-gradient-to-r from-slate-50 to-slate-100/60 border-b border-slate-100 flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <span class="w-2 h-2 rounded-full {{ ($notifCount ?? 0) > 0 ? 'bg-rose-500 animate-ping' : 'bg-slate-300' }}"></span>
                <h3 class="text-sm font-bold text-slate-900 tracking-tight">Notifikasi Sistem</h3>
            </div>
            @if(($notifCount ?? 0) > 0)
                <span class="px-2.5 py-0.5 rounded-full bg-rose-50 text-rose-600 border border-rose-200 text-[10px] font-bold">
                    {{ $notifCount }} Perlu Tindakan
                </span>
            @endif
        </div>

        <!-- Daftar Notifikasi -->
        <div class="overflow-y-auto divide-y divide-slate-100" style="max-height: 22rem;">
            @forelse(($notifItems ?? []) as $item)
                <a href="{{ $item['url'] }}" 
                   class="block px-4 py-3 hover:bg-slate-50/80 transition-colors group">
                    <div class="flex items-start space-x-3">
                        <!-- Icon Bulat Berwarna Sesuai Jenis -->
                        <div class="w-8 h-8 rounded-xl shrink-0 flex items-center justify-center text-xs
                            {{ ($item['color'] ?? 'blue') === 'emerald' ? 'bg-emerald-50 text-emerald-600 border border-emerald-200/60' : '' }}
                            {{ ($item['color'] ?? 'blue') === 'blue' ? 'bg-blue-50 text-blue-600 border border-blue-200/60' : '' }}
                            {{ ($item['color'] ?? 'blue') === 'amber' ? 'bg-amber-50 text-amber-600 border border-amber-200/60' : '' }}
                            {{ ($item['color'] ?? 'blue') === 'rose' || ($item['color'] ?? 'blue') === 'red' ? 'bg-rose-50 text-rose-600 border border-rose-200/60' : '' }}">
                            
                            @if(($item['icon'] ?? '') === 'calendar')
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            @elseif(($item['icon'] ?? '') === 'clipboard')
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            @elseif(($item['icon'] ?? '') === 'alert')
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            @elseif(($item['icon'] ?? '') === 'check')
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                            @else
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            @endif
                        </div>

                        <!-- Deskripsi -->
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-bold text-slate-800 group-hover:text-blue-600 transition-colors leading-tight">
                                {{ $item['title'] }}
                            </p>
                            <p class="text-[11px] text-slate-600 mt-0.5 line-clamp-2 leading-relaxed">
                                {{ $item['desc'] }}
                            </p>
                            <span class="inline-block text-[10px] text-slate-400 mt-1 font-medium">
                                {{ $item['time'] }}
                            </span>
                        </div>
                    </div>
                </a>
            @empty
                <!-- Tampilan Kosong -->
                <div class="py-8 px-6 text-center">
                    <div class="w-10 h-10 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-2">
                        <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <p class="text-xs sm:text-sm font-bold text-slate-700">Tidak ada notifikasi baru</p>
                    <p class="text-[11px] sm:text-xs text-slate-400 mt-1 leading-relaxed">Semua pengajuan dan aktivitas sudah selesai ditinjau.</p>
                </div>
            @endforelse
        </div>

        <!-- Footer Popup -->
        <div class="px-4 py-2.5 bg-slate-50/80 border-t border-slate-100 text-center">
            <span class="text-[11px] text-slate-400 font-medium">
                Pembaruan otomatis dari sistem DISPERDAGIN
            </span>
        </div>
    </div>
</div>

<script>
    function toggleNotifDropdown(event) {
        event.stopPropagation();
        const menu = document.getElementById('notifDropdownMenu');
        if (menu) {
            menu.classList.toggle('hidden');
        }
    }

    // Menutup dropdown jika klik di luar elemen
    document.addEventListener('click', function(event) {
        const container = document.getElementById('notifDropdownContainer');
        const menu = document.getElementById('notifDropdownMenu');
        if (container && menu && !container.contains(event.target)) {
            menu.classList.add('hidden');
        }
    });

    // Menutup dengan tombol Escape
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            const menu = document.getElementById('notifDropdownMenu');
            if (menu) menu.classList.add('hidden');
        }
    });
</script>

