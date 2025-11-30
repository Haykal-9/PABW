<style>
    /* CSS khusus untuk Sidebar */
    .sidebar {
        background-color: var(--sidebar-bg);
        padding: 1.5rem 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        border-right: 1px solid var(--border-color);
        grid-row: 1 / -1;
        /* Make sidebar span all rows */
    }

    .sidebar .nav-link {
        color: var(--text-muted-color);
        font-size: 1.5rem;
        padding: 0.75rem;
        border-radius: 0.5rem;
        transition: all 0.3s ease;
    }

    .sidebar .nav-link:hover,
    .sidebar .nav-link.active {
        color: var(--accent-color);
        background-color: rgba(232, 123, 62, 0.1);
    }

    .sidebar .logo {
        color: var(--accent-color);
        font-size: 2rem;
        margin-bottom: 1rem;
    }

    .sidebar .nav {
        gap: 1.5rem;
    }

    .sidebar .profile-link {
        margin-top: auto;
    }

    /* Responsive Sidebar */
    @media (max-width: 992px) {
        .sidebar {
            flex-direction: row;
            justify-content: space-around;
            height: 70px;
            width: 100%;
            padding: 0 1rem;
            position: fixed;
            bottom: 0;
            z-index: 1000;
            border-top: 1px solid var(--border-color);
            border-right: none;
        }

        .sidebar .logo,
        .sidebar .profile-link {
            display: none;
        }
    }
</style>

<nav class="sidebar">
    <a href="{{ route('kasir.index') }}" class="nav-link logo"><i class="bi bi-cup-hot-fill"></i></a>
    <ul class="nav flex-column">
        {{-- Logika untuk menandai link aktif --}}
        <li class="nav-item"><a href="{{ route('kasir.index') }}"
                class="nav-link @if($activePage == 'kasir') active @endif" title="Kasir"><i
                    class="bi bi-grid-fill"></i></a></li>
        <li class="nav-item"><a href="{{ route('kasir.menu') }}"
                class="nav-link @if($activePage == 'menu') active @endif" title="Menu"><i
                    class="bi bi-card-list"></i></a></li>
        <li class="nav-item"><a href="{{ route('kasir.reservasi') }}"
                class="nav-link @if($activePage == 'reservasi') active @endif" title="Reservasi"><i
                    class="bi bi-calendar-check"></i></a></li>
        <li class="nav-item"><a href="{{ route('kasir.riwayat') }}"
                class="nav-link @if($activePage == 'riwayat') active @endif" title="Riwayat"><i
                    class="bi bi-clock-history"></i></a></li>
        <li class="nav-item"><a href="{{ route('kasir.notif') }}"
                class="nav-link @if($activePage == 'notifikasi') active @endif" title="Notifikasi"><i
                    class="bi bi-bell-fill"></i></a></li>
    </ul>
    <a href="{{ route('kasir.profile') }}" class="nav-link profile-link" title="Profile"><i
            class="bi bi-person-circle"></i></a>
</nav>