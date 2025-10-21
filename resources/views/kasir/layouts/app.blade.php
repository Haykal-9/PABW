<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Aplikasi Kasir' }}</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    {{-- CSS Global untuk semua halaman --}}
    <style>
        :root {
            --bg-color: #1a1d21;
            --sidebar-bg: #22262b;
            --card-bg: #2c3138;
            --text-color: #f0f0f0;
            --text-muted-color: #8a919e;
            --accent-color: #e87b3e;
            --border-color: #3a414a;
        }
        body {
            background-color: var(--bg-color);
            color: var(--text-color);
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
        }
        .main-container {
            display: grid;
            grid-template-columns: 80px 1fr;
            height: 100vh;
        }
        .content {
            padding: 2rem;
            overflow-y: auto;
        }
        .header h1 { font-weight: 700; }
        .header p { color: var(--text-muted-color); }

        /* Shared Form/Modal Styles */
        .form-control, .form-select {
            background-color: var(--sidebar-bg);
            color: var(--text-color);
            border: 1px solid var(--border-color);
        }
        .form-control:focus, .form-select:focus {
            background-color: var(--sidebar-bg);
            color: var(--text-color);
            border-color: var(--accent-color);
            box-shadow: 0 0 0 0.25rem rgba(232, 123, 62, 0.25);
        }
        .modal-content {
            background-color: var(--card-bg);
            color: var(--text-color);
            border: 1px solid var(--border-color);
            border-radius: 1rem;
        }
        .modal-header, .modal-footer { border-color: var(--border-color); }
        .btn-close-white { filter: invert(1) grayscale(100%) brightness(200%); }

        /* Responsive */
        @media (max-width: 992px) {
            .main-container { grid-template-columns: 1fr; grid-template-rows: auto 1fr; height: auto; }
            .content { padding-bottom: 90px; }
        }
    </style>
    {{-- Stack untuk CSS spesifik per halaman --}}
    @stack('styles')
</head>
<body>

    <div class="main-container">
        {{-- Memasukkan file sidebar --}}
        @include('kasir.layouts.partials.sidebar')

        {{-- Konten utama yang akan diisi oleh view anak --}}
        @yield('content')
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    {{-- Stack untuk JavaScript spesifik per halaman --}}
    @stack('scripts')
</body>
</html>
