<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Informasi Absensi & Kinerja DISPERDAGIN')</title>

    <!-- Tailwind CSS (Build Lokal) -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Chart.js Library untuk Visualisasi Kinerja & Presensi -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- SweetAlert2 untuk Notifikasi -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @stack('styles')
</head>

<body class="bg-[#F8FAFC] text-gray-900 min-h-screen flex flex-col">

    <!-- Mobile Backdrop Overlay -->
    <div id="sidebarOverlay" class="fixed inset-0 bg-slate-900/50 z-40 hidden lg:hidden transition-opacity"></div>

    <!-- SIDEBAR -->
    @yield('sidebar')

    <!-- AREA UTAMA KONTEN -->
    <div class="lg:pl-64 flex flex-col min-h-screen">

        <!-- Header -->
        @include('components.header')

        <!-- Container Konten Halaman -->
        <main class="flex-1 p-4 sm:p-6 lg:p-8 max-w-7xl w-full mx-auto">
            @yield('content')
        </main>

    </div>

    @stack('modals')
    @stack('scripts')
</body>

</html>
