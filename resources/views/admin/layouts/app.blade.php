<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - @yield('admin_page_title', 'Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;700;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --vintage-cream: #F5F1E8;
            --vintage-beige: #E8DCC4;
            --vintage-brown: #8B6F47;
            --vintage-dark-brown: #5C4033;
            --vintage-sepia: #704214;
            --gold: #D4AF37;
            --copper: #B87333;
            --text-dark: #2C2416;
            --bg-paper: #FAF8F3;
        }
        
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body { 
            font-family: 'Inter', sans-serif; 
            background: var(--bg-paper);
            color: var(--text-dark);
            overflow-x: hidden;
            position: relative;
        }
        
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image:
                repeating-linear-gradient(0deg, rgba(0,0,0,.03) 0px, transparent 1px, transparent 2px, rgba(0,0,0,.03) 3px),
                repeating-linear-gradient(90deg, rgba(0,0,0,.03) 0px, transparent 1px, transparent 2px, rgba(0,0,0,.03) 3px);
            pointer-events: none !important;
            z-index: -1;
            opacity: 0.4;
        }
        
        main, .content-wrapper, #page-content-wrapper {
            position: relative;
            z-index: auto;
        }
        
        #sidebar-wrapper {
            min-height: 100vh;
            width: 280px;
            background: linear-gradient(to bottom, var(--vintage-beige), var(--vintage-cream));
            border-right: 3px solid var(--gold);
            box-shadow: 4px 0 15px rgba(92, 64, 51, 0.15);
            position: fixed;
            left: 0;
            top: 0;
            transition: all 0.3s ease;
            z-index: 100;
        }
        
        #sidebar-wrapper.toggled { margin-left: -280px; }
        
        .sidebar-heading {
            padding: 28px 20px;
            background: linear-gradient(135deg, var(--vintage-brown), var(--vintage-sepia));
            border-bottom: 2px solid var(--gold);
        }
        
        .sidebar-heading h4 {
            color: var(--vintage-cream);
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            font-size: 22px;
            margin: 0;
            letter-spacing: 1.2px;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .sidebar-heading h4 i { 
            font-size: 28px; 
            color: var(--gold);
        }
        
        .nav-item {
            margin: 6px 12px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        
        .nav-item a {
            color: var(--vintage-sepia);
            padding: 14px 18px;
            display: flex;
            align-items: center;
            gap: 14px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.3s ease;
            border: 1px solid transparent;
        }
        
        .nav-item a i { 
            font-size: 18px; 
            width: 22px;
            color: var(--vintage-brown);
        }
        
        .nav-item a:hover {
            background: linear-gradient(135deg, var(--vintage-brown), var(--vintage-sepia));
            color: var(--vintage-cream);
            border: 1px solid var(--gold);
            transform: translateX(5px);
            box-shadow: 0 2px 8px rgba(92, 64, 51, 0.2);
        }
        
        .nav-item a:hover i {
            color: var(--gold);
        }
        
        .nav-item a.active {
            background: linear-gradient(135deg, var(--vintage-brown), var(--vintage-sepia));
            color: var(--vintage-cream);
            border: 2px solid var(--gold);
            box-shadow: 0 4px 12px rgba(112, 66, 20, 0.3);
        }
        
        .nav-item a.active i {
            color: var(--gold);
        }
        
        #page-content-wrapper {
            margin-left: 280px;
            transition: all 0.3s ease;
            min-height: 100vh;
            position: relative;
            z-index: auto;
        }
        
        #page-content-wrapper.toggled { margin-left: 0; }
        
        .topbar {
            background: linear-gradient(to bottom, var(--vintage-cream), var(--vintage-beige));
            padding: 18px 30px;
            box-shadow: 0 2px 10px rgba(92, 64, 51, 0.15);
            border-bottom: 2px solid var(--gold);
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        
        .topbar h5 { 
            margin: 0; 
            color: var(--vintage-sepia); 
            font-family: 'Playfair Display', serif;
            font-weight: 700; 
            font-size: 26px;
            letter-spacing: 0.5px;
        }
        
        .topbar-right { display: flex; align-items: center; gap: 20px; }
        
        .toggle-btn {
            background: linear-gradient(135deg, var(--vintage-brown), var(--vintage-sepia));
            color: var(--vintage-cream);
            border: 2px solid var(--gold);
            padding: 10px 16px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 18px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(112, 66, 20, 0.2);
        }
        
        .toggle-btn:hover { 
            background: linear-gradient(135deg, var(--vintage-sepia), var(--vintage-dark-brown));
            transform: translateY(-2px); 
            box-shadow: 0 4px 12px rgba(112, 66, 20, 0.3); 
        }
        
        .admin-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 8px 16px;
            background: rgba(139, 111, 71, 0.1);
            border-radius: 25px;
            border: 1px solid var(--gold);
        }
        
        .admin-profile img {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            border: 2px solid var(--gold);
        }
        
        .admin-profile-info { display: flex; flex-direction: column; }
        .admin-profile-info span { font-size: 12px; color: var(--vintage-brown); }
        .admin-profile-info strong { font-size: 15px; color: var(--vintage-sepia); font-weight: 700; }
        
        .logout-btn {
            background: linear-gradient(135deg, var(--copper), var(--vintage-sepia));
            color: var(--vintage-cream);
            border: 2px solid var(--gold);
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 14px;
            box-shadow: 0 2px 8px rgba(112, 66, 20, 0.2);
        }
        
        .logout-btn:hover { 
            background: linear-gradient(135deg, var(--vintage-sepia), var(--vintage-dark-brown));
            transform: translateY(-2px); 
            box-shadow: 0 4px 12px rgba(112, 66, 20, 0.3);
        }
        
        .content-wrapper { padding: 30px; }
        
        .ornament {
            text-align: center;
            color: var(--gold);
            font-size: 14px;
            margin: 10px 0;
        }
        
        .card {
            border: 2px solid var(--gold);
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(92, 64, 51, 0.15);
            background: var(--vintage-cream);
            overflow: hidden;
        }
        
        .card-header {
            background: linear-gradient(135deg, var(--vintage-brown), var(--vintage-sepia));
            border-bottom: 2px solid var(--gold);
            padding: 18px 24px;
        }
        
        .card-header h6 {
            color: var(--vintage-cream);
            font-weight: 700;
            font-size: 18px;
            margin: 0;
            letter-spacing: 0.5px;
        }
        
        .card-body {
            padding: 24px;
            background: var(--vintage-cream);
        }
        
        .table {
            border: 1px solid var(--gold);
            border-radius: 8px;
            overflow: hidden;
            background: white;
        }
        
        .table thead {
            background: linear-gradient(135deg, var(--vintage-brown), var(--vintage-sepia));
            border-bottom: 2px solid var(--gold);
        }
        
        .table thead th {
            color: white !important;
            font-weight: 700;
            font-size: 14px;
            padding: 14px 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: none;
        }
        
        .table tbody tr {
            border-bottom: 1px solid rgba(212, 175, 55, 0.2);
            transition: all 0.3s ease;
        }
        
        .table tbody tr:hover {
            background: rgba(139, 111, 71, 0.08);
            transform: scale(1.01);
        }
        
        .table tbody td {
            padding: 12px;
            color: var(--text-dark);
            font-size: 14px;
            vertical-align: middle;
        }
        
        .table-striped tbody tr:nth-of-type(odd) {
            background: rgba(245, 241, 232, 0.5);
        }
        
        .btn {
            border-radius: 6px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: 1px solid transparent;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--vintage-brown), var(--vintage-sepia));
            border: 2px solid var(--gold);
            color: var(--vintage-cream);
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, var(--vintage-sepia), var(--vintage-dark-brown));
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(112, 66, 20, 0.3);
        }
        
        .btn-warning {
            background: linear-gradient(135deg, var(--gold), var(--copper));
            border: 1px solid var(--vintage-brown);
            color: var(--text-dark);
        }
        
        .btn-warning:hover {
            background: linear-gradient(135deg, var(--copper), var(--vintage-brown));
            color: var(--vintage-cream);
            transform: translateY(-2px);
        }
        
        .btn-danger {
            background: linear-gradient(135deg, #c0392b, #8e2a1f);
            border: 1px solid var(--vintage-brown);
            color: var(--vintage-cream);
        }
        
        .btn-danger:hover {
            background: linear-gradient(135deg, #8e2a1f, #6b1f17);
            transform: translateY(-2px);
        }
        
        .btn-info {
            background: linear-gradient(135deg, var(--vintage-brown), var(--vintage-sepia));
            border: 1px solid var(--gold);
            color: var(--vintage-cream);
        }
        
        .btn-info:hover {
            background: linear-gradient(135deg, var(--vintage-sepia), var(--vintage-dark-brown));
            transform: translateY(-2px);
        }
        
        .btn-success {
            background: linear-gradient(135deg, #27ae60, #1e8449);
            border: 1px solid var(--vintage-brown);
            color: var(--vintage-cream);
        }
        
        .btn-success:hover {
            background: linear-gradient(135deg, #1e8449, #186a3b);
            transform: translateY(-2px);
        }
        
        .badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 12px;
            letter-spacing: 0.3px;
            border: 1px solid transparent;
        }
        
        .badge.bg-success {
            background: linear-gradient(135deg, #27ae60, #1e8449) !important;
            border: 1px solid #1e8449;
        }
        
        .badge.bg-danger {
            background: linear-gradient(135deg, #c0392b, #8e2a1f) !important;
            border: 1px solid #8e2a1f;
        }
        
        .badge.bg-secondary {
            background: linear-gradient(135deg, var(--vintage-brown), var(--vintage-sepia)) !important;
            border: 1px solid var(--gold);
        }
        
        .alert {
            border-radius: 8px;
            border: 2px solid;
            padding: 16px 20px;
            font-weight: 500;
        }
        
        .alert-success {
            background: rgba(39, 174, 96, 0.1);
            border-color: #27ae60;
            color: #1e8449;
        }
        
        .alert-danger {
            background: rgba(192, 57, 43, 0.1);
            border-color: #c0392b;
            color: #8e2a1f;
        }
        
        .form-control, .form-select {
            border: 2px solid rgba(139, 111, 71, 0.3);
            border-radius: 6px;
            padding: 10px 14px;
            transition: all 0.3s ease;
            background: white;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 0.2rem rgba(212, 175, 55, 0.25);
        }
        
        .modal {
            z-index: 9999 !important;
        }
        
        .modal-backdrop {
            z-index: 9998 !important;
            background-color: rgba(44, 36, 22, 0.5) !important;
        }
        
        .modal-dialog {
            z-index: 10000 !important;
            position: relative;
        }
        
        .modal-content {
            border: 2px solid var(--gold);
            border-radius: 12px;
            background: white !important;
            position: relative;
            z-index: 10001 !important;
        }
        
        .modal-header {
            background: linear-gradient(135deg, var(--vintage-brown), var(--vintage-sepia));
            border-bottom: 2px solid var(--gold);
            color: var(--vintage-cream);
            position: relative;
            z-index: 10002 !important;
        }
        
        .modal-header .btn-close {
            filter: brightness(0) invert(1);
            pointer-events: auto !important;
        }
        
        .modal-title {
            font-weight: 700;
            letter-spacing: 0.5px;
        }
        
        .modal-body {
            background: white !important;
            padding: 24px;
            position: relative;
            z-index: 10002 !important;
        }
        
        .modal-body *,
        .modal-body input,
        .modal-body select,
        .modal-body textarea,
        .modal-body button,
        .modal-body label {
            position: relative;
            pointer-events: auto !important;
            z-index: auto !important;
        }
        
        .modal-footer {
            border-top: 1px solid rgba(212, 175, 55, 0.3);
            background: rgba(245, 241, 232, 0.3);
            position: relative;
            z-index: 10002 !important;
        }
        
        .modal-footer button {
            position: relative;
            pointer-events: auto !important;
        }
        
        @media (max-width: 768px) {
            #sidebar-wrapper { margin-left: -280px; }
            #sidebar-wrapper.toggled { margin-left: 0; }
            #page-content-wrapper { margin-left: 0; }
        }
    </style>
    @stack('styles')
</head>

<body>
    <div id="sidebar-wrapper">
        <div class="sidebar-heading">
            <h4><i class="fas fa-horse"></i> TapalKuda Admin</h4>
        </div>
        
        <div class="ornament mt-3">❦</div>
        
        <div class="mt-3">
            <div class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('admin.menu') }}" class="{{ request()->routeIs('admin.menu') ? 'active' : '' }}">
                    <i class="fas fa-coffee"></i> Daftar Menu
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('admin.users') }}" class="{{ request()->routeIs('admin.users') ? 'active' : '' }}">
                    <i class="fas fa-users"></i> Pengguna
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('admin.orders') }}" class="{{ request()->routeIs('admin.orders') ? 'active' : '' }}">
                    <i class="fas fa-receipt"></i> Riwayat Penjualan
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('admin.reservations') }}" class="{{ request()->routeIs('admin.reservations') ? 'active' : '' }}">
                    <i class="fas fa-calendar-alt"></i> Reservasi
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('admin.ratings') }}" class="{{ request()->routeIs('admin.ratings') ? 'active' : '' }}">
                    <i class="fas fa-star"></i> Rating & Ulasan
                </a>
            </div>
        </div>
        
        <div class="ornament mt-4">❦</div>
    </div>

    <div id="page-content-wrapper">
        <div class="topbar">
            <div class="d-flex align-items-center gap-3">
                <button class="toggle-btn" id="menu-toggle">
                    <i class="fas fa-bars"></i>
                </button>
                <h5>@yield('admin_page_title', 'Dashboard')</h5>
            </div>
            <div class="topbar-right">
                <div class="admin-profile">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->nama ?? 'Admin') }}&background=8B6F47&color=F5F1E8&bold=true" alt="Admin">
                    <div class="admin-profile-info">
                        <span>Selamat datang,</span>
                        <strong>{{ Auth::user()->nama ?? 'Admin' }}</strong>
                    </div>
                </div>
                <button class="logout-btn" onclick="window.location.href='/logout'">
                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                </button>
            </div>
        </div>
        
        <div class="content-wrapper">
            @yield('admin_content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('menu-toggle').addEventListener('click', function() {
            document.getElementById('sidebar-wrapper').classList.toggle('toggled');
            document.getElementById('page-content-wrapper').classList.toggle('toggled');
        });
    </script>
    @stack('scripts')
</body>

</html>