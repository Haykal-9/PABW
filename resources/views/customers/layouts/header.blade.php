<header class="navbar navbar-expand-lg navbar-white bg-white shadow-sm py-3">
    <div class="container">
        {{-- BRAND NAME: Bold dan menggunakan warna tema --}}
        <a class="navbar-brand fw-bolder fs-3 text-primary-dark" href="{{ url('/') }}">
            TapalKuda
        </a>
        
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            {{-- Navigasi utama ditarik ke kanan (ms-auto) --}}
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

                {{-- Link Profil yang selalu tampil (bisa menuju data dummy jika belum login) --}}
                <li class="nav-item me-3">
                    <a class="nav-link fw-semibold text-dark" href="{{ url('/profil') }}">Profil</a>
                </li>
                
                {{-- Tombol Login yang menonjol --}}
                <li class="nav-item ms-lg-2">
                    <a class="btn btn-primary-dark px-4 py-2 fw-bold shadow-sm" href="{{ url('/login') }}">
                        Login
                    </a>
                </li>
            </ul>
        </div>
    </div>
</header>