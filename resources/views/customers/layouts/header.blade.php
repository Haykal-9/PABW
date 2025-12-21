<header class="navbar navbar-expand-lg py-3 sticky-top navbar-glass">
    <div class="container">
        <!-- Brand Logo -->
        <a class="navbar-brand d-flex align-items-center gap-2" href="{{ url('/') }}">
            <i class="fas fa-coffee text-gold fs-4"></i>
            <span class="font-serif fw-bold text-gold fs-4 tracking-wider">TapalKuda</span>
        </a>

        <button class="navbar-toggler border-0 text-gold" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars fs-3"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center gap-2">

                <li class="nav-item">
                    <a class="nav-link px-3 d-flex align-items-center" href="{{ url('/home') }}">
                        <i class="fas fa-home me-2 text-gold opacity-75"></i> Home
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link px-3 d-flex align-items-center" href="{{ url('/menu') }}">
                        <i class="fas fa-book-open me-2 text-gold opacity-75"></i> Menu
                    </a>
                </li>

                @auth
                    <li class="nav-item">
                        <a class="nav-link px-3 d-flex align-items-center" href="{{ route('reservasi.create') }}">
                            <i class="fas fa-calendar-alt me-2 text-gold opacity-75"></i> Reservasi
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link px-3 d-flex align-items-center" href="{{ url('/profil/' . Auth::id()) }}">
                            <i class="fas fa-user me-2 text-gold opacity-75"></i> Profile
                        </a>
                    </li>

                    <!-- Notifications -->
                    <li class="nav-item">
                        <a class="nav-link px-3 d-flex align-items-center position-relative"
                            href="{{ route('notifications.index') }}" id="notificationBell">
                            <i class="fas fa-bell text-gold opacity-75"></i>
                            <span class="d-lg-none ms-2">Notifikasi</span>

                            @php
                                $unreadCount = Auth::check() ? \App\Models\Notification::where('user_id', Auth::id())->where('is_read', false)->count() : 0;
                            @endphp

                            @if($unreadCount > 0)
                                <span
                                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-dark"
                                    id="notificationBadge">
                                    {{ $unreadCount }}
                                </span>
                            @endif
                        </a>
                    </li>

                    <!-- Cart -->
                    <li class="nav-item">
                        <a class="nav-link px-3 d-flex align-items-center position-relative" href="{{ url('/cart') }}">
                            <i class="fas fa-shopping-cart text-gold opacity-75"></i>
                            <span class="d-lg-none ms-2">Keranjang</span>

                            @if(session('cart') && count(session('cart')) > 0)
                                <span
                                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-gold text-dark border border-dark">
                                    {{ count(session('cart')) }}
                                </span>
                            @endif
                        </a>
                    </li>
                @endauth

                <!-- Login Button -->
                @guest
                    <li class="nav-item ms-lg-3">
                        <a class="btn btn-gold px-4 py-2" href="{{ url('/login') }}">
                            Login
                        </a>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</header>

<!-- Ornamental Divider (Glass Style) -->
<div
    style="width: 100%; height: 1px; background: linear-gradient(to right, transparent, rgba(212, 175, 55, 0.5), transparent); position: relative;">
    <div class="position-absolute top-50 start-50 translate-middle bg-dark text-gold px-2 fs-6">
        ✦
    </div>
</div>

<style>
    /* Custom Badge for Header */
    .bg-gold {
        background-color: var(--accent-gold);
        color: #000;
    }

    /* Animation for Bell */
    @keyframes bellRing {

        0%,
        100% {
            transform: rotate(0deg);
        }

        10%,
        30% {
            transform: rotate(-10deg);
        }

        20%,
        40% {
            transform: rotate(10deg);
        }
    }

    #notificationBell:hover .fa-bell {
        animation: bellRing 0.5s ease-in-out;
    }
</style>

@auth
    <script>
        // Auto-update notification count
        setInterval(function () {
            fetch('{{ route("notifications.unreadCount") }}')
                .then(response => response.json())
                .then(data => {
                    const badge = document.getElementById('notificationBadge');
                    const bell = document.getElementById('notificationBell');

                    if (data.count > 0) {
                        if (!badge) {
                            const newBadge = document.createElement('span');
                            newBadge.id = 'notificationBadge';
                            newBadge.className = 'position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-dark';
                            newBadge.textContent = data.count;
                            bell.appendChild(newBadge);
                        } else {
                            badge.textContent = data.count;
                        }
                    } else {
                        if (badge) badge.remove();
                    }
                })
                .catch(error => console.error('Error fetching notification count:', error));
        }, 30000);
    </script>
@endauth