<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - @yield('admin_page_title', 'Dashboard')</title>
    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    @stack('styles')
</head>

<body>
    <div class="d-flex" id="wrapper">
        {{-- Sidebar --}}
        <div class="bg-dark border-right" id="sidebar-wrapper" style="min-height: 100vh; width: 250px;">
            <div class="sidebar-heading bg-dark text-white p-3 border-bottom border-secondary fw-bold">
                <i class="fas fa-cog me-2"></i> TapalKuda Admin
            </div>
            <div class="list-group list-group-flush">
                {{-- Menu Sidebar yang sudah ada --}}
                <a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action bg-dark text-white border-bottom border-secondary">
                    <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                </a>
                <a href="{{ route('admin.menu') }}" class="list-group-item list-group-item-action bg-dark text-white border-bottom border-secondary">
                    <i class="fas fa-coffee me-2"></i> Daftar Menu
                </a>
                <a href="{{ route('admin.users') }}" class="list-group-item list-group-item-action bg-dark text-white border-bottom border-secondary">
                    <i class="fas fa-users me-2"></i> Pengguna
                </a>
                <a href="{{ route('admin.orders') }}" class="list-group-item list-group-item-action bg-dark text-white border-bottom border-secondary">
                    <i class="fas fa-receipt me-2"></i> Riwayat Penjualan
                </a>
                <a href="{{ route('admin.reservations') }}" class="list-group-item list-group-item-action bg-dark text-white border-bottom border-secondary">
                    <i class="fas fa-calendar-alt me-2"></i> Reservasi
                </a>
                <a href="{{ route('admin.ratings') }}" class="list-group-item list-group-item-action bg-dark text-white border-bottom border-secondary">
                    <i class="fas fa-star me-2"></i> Rating & Ulasan
                </a>
            </div>
        </div>

        {{-- Konten Utama --}}
        <div id="page-content-wrapper" class="flex-grow-1 p-4">
            <div class="container-fluid">
                <h1 class="mt-4 mb-3">@yield('admin_page_title')</h1>
                <hr>
                @yield('admin_content')
            </div>
        </div>
    </div>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>