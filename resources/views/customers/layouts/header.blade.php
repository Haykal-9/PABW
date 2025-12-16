<header class="navbar navbar-expand-lg py-3"
    style="background: linear-gradient(to bottom, #F5F1E8, #E8DCC4); border-bottom: 3px solid #D4AF37; box-shadow: 0 2px 10px rgba(92, 64, 51, 0.15);">
    <div class="container">
        <!-- Brand Logo dengan Ornamental -->
        <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}"
            style="font-family: 'Playfair Display', serif; color: #704214; font-weight: 700; letter-spacing: 1.5px; font-size: 1.8rem;">
            TapalKuda
        </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation" style="color: #704214;">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center gap-1">

                <li class="nav-item">
                    <a class="nav-link fw-semibold px-3 py-2" href="{{ url('/home') }}"
                        style="color: #704214; transition: all 0.3s ease; position: relative;">
                        Home
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link fw-semibold px-3 py-2" href="{{ url('/menu') }}"
                        style="color: #704214; transition: all 0.3s ease; position: relative;">
                        Menu
                    </a>
                </li>

                @auth
                    <li class="nav-item">
                        <a class="nav-link fw-semibold px-3 py-2" href="{{ route('reservasi.create') }}"
                            style="color: #704214; transition: all 0.3s ease; position: relative;">
                            <i class="fas fa-calendar-alt" style="color: #8B6F47;"></i>
                            <span class="ms-2">Reservasi</span>
                        </a>
                    </li>
                @endauth

                @auth
                    <li class="nav-item">
                        <a class="nav-link fw-semibold px-3 py-2" href="{{ url('/profil/' . Auth::id()) }}"
                            style="color: #704214; transition: all 0.3s ease; position: relative;">
                            <i class="fas fa-user" style="color: #8B6F47;"></i>
                            <span class="ms-2">Profile</span>
                        </a>
                    </li>
                @endauth

                <!-- Cart with Badge -->
                <!-- Cart with Badge -->
                @auth
                    <li class="nav-item">
                        <a class="nav-link position-relative px-3 py-2 d-flex align-items-center" href="{{ url('/cart') }}"
                            style="color: #704214; transition: all 0.3s ease;">
                            <i class="fas fa-shopping-cart" style="color: #8B6F47;"></i>
                            <span class="ms-2">Keranjang</span>

                            @if(session('cart') && count(session('cart')) > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill"
                                    style="background: linear-gradient(135deg, #D4AF37, #CFB53B); color: #2C2416; font-weight: 700; border: 1px solid #8B6F47;">
                                    {{ count(session('cart')) }}
                                </span>
                            @endif
                        </a>
                    </li>
                @endauth

                <!-- Login Button with Vintage Style (Only for Guests) -->
                @guest
                    <li class="nav-item ms-lg-2">
                        <a class="btn px-4 py-2 fw-bold" href="{{ url('/login') }}" style="background: linear-gradient(135deg, #8B6F47, #704214); 
                                                  color: #F5F1E8; 
                                                  border: 2px solid #D4AF37; 
                                                  letter-spacing: 0.5px;
                                                  transition: all 0.3s ease;
                                                  box-shadow: 0 2px 8px rgba(112, 66, 20, 0.2);">
                            Login
                        </a>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</header>

<!-- Ornamental Divider -->
<div
    style="width: 100%; height: 1px; background: linear-gradient(to right, transparent, #D4AF37, transparent); position: relative;">
    <div
        style="position: absolute; left: 50%; transform: translateX(-50%) translateY(-50%); background: #F5F1E8; padding: 0 15px; color: #D4AF37; font-size: 12px;">
        ❦
    </div>
</div>

<style>
    /* Hover effects for nav links */
    .nav-link::after {
        content: '';
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 0;
        height: 2px;
        background: #D4AF37;
        transition: width 0.3s ease;
    }

    .nav-link:hover::after {
        width: 70%;
    }

    .nav-link:hover {
        color: #8B6F47 !important;
    }

    /* Login button hover */
    .btn:hover {
        background: linear-gradient(135deg, #704214, #5C4033) !important;
        color: #D4AF37 !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(112, 66, 20, 0.3) !important;
    }

    /* Navbar brand hover */
    .navbar-brand:hover {
        color: #8B6F47 !important;
        transform: scale(1.02);
        transition: all 0.3s ease;
    }
</style>