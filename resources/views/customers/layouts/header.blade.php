<header class="navbar navbar-expand-lg navbar-light bg-white shadow-sm py-3">
    <div class="container">
        <a class="navbar-brand fw-bolder fs-3 text-primary-dark" href="{{ url('/') }}">
            TapalKuda
        </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">

                <li class="nav-item me-3">
                    <a class="nav-link fw-semibold text-dark" href="{{ url('/home') }}">Home</a>
                </li>

                <li class="nav-item me-3">
                    <a class="nav-link fw-semibold text-dark" href="{{ url('/menu') }}">Menu</a>
                </li>

                <li class="nav-item me-3">
                    <a class="nav-link fw-semibold text-dark" href="{{ url('/reservasi') }}">Reservasi</a>
                </li>

                <li class="nav-item me-3">
                <li class="nav-item me-3">
                    <a class="nav-link fw-semibold text-dark" href="{{ url('/profil/7') }}">
                        Profil
                    </a>
                </li>
                </li>

                <li class="nav-item me-3">
                    <a class="nav-link position-relative text-dark" href="{{ url('/cart') }}">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="ms-2">Keranjang</span>

                        @if(session('cart') && count(session('cart')) > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{ count(session('cart')) }}
                            </span>
                        @endif
                    </a>
                </li>

                <li class="nav-item ms-lg-2">
                    <a class="btn btn-login" href="{{ url('/login') }}">
                        Login
                    </a>
                </li>
            </ul>
        </div>
    </div>
</header>