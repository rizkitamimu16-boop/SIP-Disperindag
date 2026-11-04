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

    <!-- Global Responsive Table & Mobile Enhancements -->
    <style>
        /* Smooth momentum scrolling on iOS and Android */
        .overflow-x-auto {
            -webkit-overflow-scrolling: touch;
            overscroll-behavior-x: contain;
        }
        @media (max-width: 768px) {
            .overflow-x-auto::-webkit-scrollbar {
                height: 5px;
            }
            .overflow-x-auto::-webkit-scrollbar-track {
                background: #f1f5f9;
                border-radius: 4px;
            }
            .overflow-x-auto::-webkit-scrollbar-thumb {
                background: #94a3b8;
                border-radius: 4px;
            }
        }
    </style>

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
