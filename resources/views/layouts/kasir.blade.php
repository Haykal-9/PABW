@php
    $title = $title ?? 'Tapal Kuda';
@endphp
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <!-- Custom CSS -->
    <link href="{{ asset('css/kasir.css') }}" rel="stylesheet">
    @stack('head')



</head>
<body class="min-vh-100">
    <div class="container-fluid p-0 d-flex" style="min-height:100vh;">
        @include('components.sidebar', ['activePage' => $activePage ?? null])
        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
