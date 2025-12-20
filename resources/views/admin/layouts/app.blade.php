<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - @yield('admin_page_title', 'Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&family=Playfair+Display:wght@700;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --vintage-dark: #2D241E;
            --vintage-brown: #5D4037;
            --gold-accent: #C5A059;
            --bg-light: #F8F9FA;
            --text-muted: #6C757D;
        }
        
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background: var(--bg-light);
            color: #333;
        }

        /* Sidebar Modern */
        #sidebar-wrapper {
            min-height: 100vh;
            width: 260px;
            background: var(--vintage-dark);
            position: fixed;
            transition: all 0.3s;
            z-index: 1000;
        }
        
        .sidebar-heading {
            padding: 2rem 1.5rem;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }

        .sidebar-heading h4 {
            color: white;
            font-family: 'Playfair Display', serif;
            font-size: 1.25rem;
            margin: 0;
            letter-spacing: 1px;
        }

        .nav-item { margin: 0.25rem 1rem; }
        
        .nav-item a {
            color: rgba(255,255,255,0.6);
            padding: 0.8rem 1rem;
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 500;
            transition: 0.2s;
        }

        .nav-item a:hover, .nav-item a.active {
            background: rgba(197, 160, 89, 0.15);
            color: var(--gold-accent);
        }

        /* Main Content */
        #page-content-wrapper {
            margin-left: 260px;
            width: calc(100% - 260px);
            transition: all 0.3s;
        }

        .topbar {
            background: white;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.02);
            border-bottom: 1px solid #EEE;
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            margin-bottom: 1.5rem;
        }

        .btn-primary {
            background: var(--vintage-brown);
            border: none;
            padding: 0.6rem 1.2rem;
        }

        .btn-primary:hover { background: var(--vintage-dark); }

        .table thead th {
            background: #F8F9FA;
            color: var(--text-muted);
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-top: none;
        }

        @media (max-width: 768px) {
            #sidebar-wrapper { margin-left: -260px; }
            #sidebar-wrapper.toggled { margin-left: 0; }
            #page-content-wrapper { margin-left: 0; width: 100%; }
        }
    </style>
    @stack('styles')
</head>
<body>
    <div id="sidebar-wrapper">
        <div class="sidebar-heading">
            <h4><i class="fas fa-horse me-2 text-warning"></i>TapalKuda</h4>
        </div>
        <div class="mt-4">
            <div class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-grid-2"></i> Dashboard
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('admin.menu') }}" class="{{ request()->routeIs('admin.menu') ? 'active' : '' }}">
                    <i class="fas fa-mug-hot"></i> Menu
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('admin.users') }}" class="{{ request()->routeIs('admin.users') ? 'active' : '' }}">
                    <i class="fas fa-users"></i> Pengguna
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('admin.orders') }}" class="{{ request()->routeIs('admin.orders') ? 'active' : '' }}">
                    <i class="fas fa-receipt"></i> Penjualan
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('admin.reservations') }}" class="{{ request()->routeIs('admin.reservations') ? 'active' : '' }}">
                    <i class="fas fa-calendar"></i> Reservasi
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('admin.ratings') }}" class="{{ request()->routeIs('admin.ratings') ? 'active' : '' }}">
                    <i class="fas fa-star"></i> Review
                </a>
            </div>
        </div>
    </div>

    <div id="page-content-wrapper">
        <nav class="topbar">
            <div class="d-flex align-items-center">
                <button class="btn border-0 p-0 me-3" id="menu-toggle">
                    <i class="fas fa-bars fs-4"></i>
                </button>
                <h5 class="mb-0 fw-bold">@yield('admin_page_title')</h5>
            </div>
            <div class="dropdown">
                <div class="d-flex align-items-center gap-2" style="cursor: pointer" data-bs-toggle="dropdown">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->nama ?? 'A') }}&background=C5A059&color=fff" class="rounded-circle" width="35">
                    <span class="fw-semibold small">{{ Auth::user()->nama ?? 'Admin' }}</span>
                </div>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                    <li><a class="dropdown-item" href="/logout"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                </ul>
            </div>
        </nav>
        
        <div class="container-fluid p-4">
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