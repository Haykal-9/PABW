@extends('customers.layouts.app')

@section('title', 'TapalKuda - Masuk Akun')

@section('content')

    {{-- LOGIN SECTION - Premium Split Glass --}}
    <section class="login-page d-flex align-items-center justify-content-center min-vh-100 position-relative" style="background: radial-gradient(circle at top right, #2c2420, #0f0c0b);">

        {{-- Darker Overlay for better contrast --}}
        <div class="position-absolute top-0 start-0 w-100 h-100"
            style="background: radial-gradient(circle at center, rgba(0,0,0,0.5), #0f0c0b); backdrop-filter: blur(5px);">
        </div>

        <div class="container position-relative" style="z-index: 10;">
            <div class="row justify-content-center">
                <div class="col-xl-10 col-lg-12">
                    <div class="glass-card overflow-hidden border-0 shadow-lg" style="border-radius: 24px;">
                        <div class="row g-0">

                            {{-- Left Side: Brand Visual --}}
                            <div class="col-lg-6 d-none d-lg-block position-relative">
                                <div class="h-100 w-100 position-absolute top-0 start-0"
                                    style="background-image: url('{{ asset('foto/Latte.jpg') }}'); background-size: cover; background-position: center; filter: brightness(0.7);">
                                </div>
                                <div class="position-relative h-100 d-flex flex-column justify-content-center align-items-center text-center p-5"
                                    style="background: rgba(26, 20, 18, 0.7); backdrop-filter: blur(3px);">
                                    <div class="mb-4">
                                        <div class="d-inline-block">
                                            <img src="{{ asset('logo/123.png') }}" alt="Logo" class="rounded-circle"
                                                style="width: 140px; height: 140px; object-fit: cover;">
                                        </div>
                                    </div>
                                    <h2 class="font-serif fw-bold text-gold display-6 mb-3">Seni Menyeduh</h2>
                                    <p class="text-light lead fw-light mb-0 fst-italic">"Nikmati setiap detik ketenangan
                                        dalam secangkir kopi berkualitas."</p>
                                    <div class="mt-5">
                                        <span
                                            class="d-inline-block px-3 py-1 border border-warning rounded-pill text-gold small text-uppercase ls-1">Premium
                                            Coffee</span>
                                    </div>
                                </div>
                            </div>

                            {{-- Right Side: Login Form --}}
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center mb-5 mt-2">
                                        <h3 class="font-serif fw-bold text-light mb-1">Selamat Datang</h3>
                                        <p class="text-dim">Masuk untuk melanjutkan pesanan Anda</p>
                                    </div>

                                    {{-- Alerts --}}
                                    @if(session('error'))
                                        <div class="alert alert-danger bg-opacity-10 border-danger text-danger border-0 d-flex align-items-center"
                                            role="alert">
                                            <i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}
                                            <button type="button" class="btn-close btn-close-white ms-auto"
                                                data-bs-dismiss="alert"></button>
                                        </div>
                                    @endif
                                    @if(session('success'))
                                        <div class="alert alert-success bg-opacity-10 border-success text-success border-0 d-flex align-items-center"
                                            role="alert">
                                            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                                            <button type="button" class="btn-close btn-close-white ms-auto"
                                                data-bs-dismiss="alert"></button>
                                        </div>
                                    @endif

                                    <form action="{{ url('/login') }}" method="POST">
                                        @csrf

                                        {{-- Username Input --}}
                                        <div class="mb-4">
                                            <label for="username"
                                                class="form-label text-gold small fw-bold text-uppercase ls-1 mb-2">Username</label>
                                            <div class="input-group">
                                                <span
                                                    class="input-group-text bg-transparent border-glass text-gold ps-3 pe-2">
                                                    <i class="fas fa-user"></i>
                                                </span>
                                                <input type="text"
                                                    class="form-control form-control-glass border-start-0 ps-2 text-light"
                                                    id="username" name="username" placeholder="Masukkan username anda"
                                                    required style="height: 50px;">
                                            </div>
                                        </div>

                                        {{-- Password Input --}}
                                        <div class="mb-4">
                                            <label for="password"
                                                class="form-label text-gold small fw-bold text-uppercase ls-1 mb-2">Password</label>
                                            <div class="input-group">
                                                <span
                                                    class="input-group-text bg-transparent border-glass text-gold ps-3 pe-2">
                                                    <i class="fas fa-lock"></i>
                                                </span>
                                                <input type="password"
                                                    class="form-control form-control-glass border-start-0 ps-2 text-light"
                                                    id="password" name="password" placeholder="Masukkan password anda"
                                                    required style="height: 50px;">
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center mb-4">
                                            <div class="form-check">
                                                <input class="form-check-input bg-transparent border-secondary"
                                                    type="checkbox" id="remember">
                                                <label class="form-check-label text-dim small" for="remember">Ingat
                                                    Saya</label>
                                            </div>
                                            <a href="#" class="text-gold small text-decoration-none hover-underline">Lupa
                                                Password?</a>
                                        </div>

                                        <button type="submit"
                                            class="btn btn-gold w-100 py-3 rounded-pill fw-bold shadow-lg mb-4 hover:scale-105 transition-all">
                                            MASUK SEKARANG
                                        </button>

                                        <div class="text-center">
                                            <p class="text-dim small mb-0">Belum memiliki akun? <a
                                                    href="{{ url('/register') }}"
                                                    class="text-gold fw-bold text-decoration-none ms-1">Daftar Member</a>
                                            </p>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .ls-1 {
            letter-spacing: 1px;
        }

        .border-glass {
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            border-right: none !important;
        }

        .form-control-glass {
            background: rgba(255, 255, 255, 0.05) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            color: #fff !important;
        }

        .form-control-glass:focus {
            background: rgba(255, 255, 255, 0.1) !important;
            border-color: var(--accent-gold) !important;
            box-shadow: none !important;
            /* Remove default shadow */
        }

        /* Focus state for the parent group wrapper if we wanted specific group focus styles, 
               but here we handle input focus directly. We might want to highlight the icon too on focus. */
        .form-control-glass:focus+.input-group-text,
        .input-group:focus-within .input-group-text {
            border-color: var(--accent-gold) !important;
            color: var(--accent-gold) !important;
        }

        .input-group:focus-within .form-control-glass {
            border-color: var(--accent-gold) !important;
        }

        /* Fix Autocomplete/Autofill Background */
        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus,
        input:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0 30px #1a1412 inset !important;
            -webkit-text-fill-color: white !important;
            transition: background-color 5000s ease-in-out 0s;
        }

        .hover-underline:hover {
            text-decoration: underline !important;
        }
    </style>

@endsection