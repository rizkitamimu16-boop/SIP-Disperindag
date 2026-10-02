<header class="bg-white border-b border-gray-200 sticky top-0 z-30 px-4 sm:px-8 py-3.5 shadow-2xs">
    <div class="flex items-center justify-between">

        <!-- Heading & Subheading Dinamis -->
        <div class="flex items-center space-x-3">
            <button id="openSidebarBtn"
                class="lg:hidden p-2 rounded-lg text-gray-600 hover:bg-gray-100 focus:outline-none cursor-pointer"
                aria-label="Buka Menu">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
            <div>
                <h1 id="pageHeading" class="text-xl sm:text-2xl font-bold text-gray-900 leading-tight">@yield('header_title', 'Selamat pagi')</h1>
                <p id="pageSubHeading" class="text-xs sm:text-sm text-gray-500 mt-0.5">@yield('header_subtitle', 'Ringkasan Anda hari ini')</p>
            </div>
        </div>

        <!-- Bagian Kanan Header -->
        <div class="flex items-center space-x-3 sm:space-x-5">
            @yield('header_right')
        </div>

    </div>
</header>
