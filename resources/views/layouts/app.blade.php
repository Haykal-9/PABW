<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- PERBAIKAN: Gunakan @yield('title') secara langsung --}}
    <title>Tapal Kuda - @yield('title', 'Selamat Datang')</title> 
    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    @stack('styles')
</head>
<body>

    {{-- PERBAIKAN: Sembunyikan Header di halaman Admin --}}
    @if(! request()->is('admin*'))
        @include('layouts.header')
    @endif

    <main>
        {{-- Konten Utama Customer --}}
        @yield('content')
        
        {{-- Konten Utama Admin (Dipindahkan dari @yield('content') ke @yield('admin_layout')) --}}
        @yield('admin_layout') 
    </main>

    {{-- PERBAIKAN: Sembunyikan Footer di halaman Admin --}}
    @if(! request()->is('admin*'))
        @include('layouts.footer')
    @endif

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true
        });
    </script>
    @stack('scripts')
    
</body>
</html>