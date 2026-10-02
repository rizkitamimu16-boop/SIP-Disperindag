<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Masuk - Absensi Pegawai PPPK DISPERDAGIN')</title>
    
    <!-- Tailwind CSS (Build Lokal) -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    @stack('styles')
</head>
<body class="bg-slate-50 text-gray-900 min-h-screen">
    @yield('content')
    
    @stack('scripts')
</body>
</html>
