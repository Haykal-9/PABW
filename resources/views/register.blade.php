@extends('customers.layouts.app')

@section('title', 'TapalKuda - Daftar Akun')

@section('content')

    {{-- REGISTER SECTION - Premium Split Glass --}}
    <section class="register-page d-flex align-items-center justify-content-center min-vh-100 position-relative"
        style="background: radial-gradient(circle at top right, #2c2420, #0f0c0b); padding-top: 100px; padding-bottom: 50px;">

        {{-- Darker Overlay for consistent feel --}}
        <div class="position-absolute top-0 start-0 w-100 h-100"
            style="background: radial-gradient(circle at center, rgba(0,0,0,0.5), #0f0c0b); backdrop-filter: blur(5px);">
        </div>

        <div class="container position-relative" style="z-index: 10;">
            <div class="row justify-content-center">
                <div class="col-xl-11 col-lg-12">
                    <div class="glass-card overflow-hidden border-0 shadow-lg" style="border-radius: 24px;">
                        <div class="row g-0">

                            {{-- Left Side: Brand Visual (Sticky) --}}
                            <div class="col-lg-5 d-none d-lg-block position-relative">
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
                                    <h2 class="font-serif fw-bold text-gold display-6 mb-3">Gabung Bersama Kami</h2>
                                    <p class="text-light lead fw-light mb-0 fst-italic">"Nikmati keistimewaan dan penawaran
                                        eksklusif dengan menjadi member TapalKuda."</p>
                                    <div class="mt-5">
                                        <span
                                            class="d-inline-block px-3 py-1 border border-warning rounded-pill text-gold small text-uppercase ls-1">Exclusive
                                            Member</span>
                                    </div>
                                </div>
                            </div>

                            {{-- Right Side: Register Form --}}
                            <div class="col-lg-7">
                                <div class="p-5">
                                    <div class="text-center mb-4 mt-2">
                                        <h3 class="font-serif fw-bold text-light mb-1">Buat Akun Baru</h3>
                                        <p class="text-dim">Isi formulir di bawah ini untuk mendaftar</p>
                                    </div>

                                    {{-- Validation Errors --}}
                                    @if ($errors->any())
                                        <div class="alert alert-danger bg-opacity-10 border-danger text-danger border-0 mb-4">
                                            <ul class="mb-0 small">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <form action="/register" method="POST" enctype="multipart/form-data">
                                        @csrf

                                        {{-- Nama Lengkap --}}
                                        <div class="mb-4">
                                            <label class="form-label text-gold small fw-bold text-uppercase ls-1 mb-2">Nama
                                                Lengkap</label>
                                            <div class="input-group">
                                                <span
                                                    class="input-group-text bg-transparent border-glass text-gold ps-3 pe-2"><i
                                                        class="fas fa-id-card"></i></span>
                                                <input type="text" name="nama"
                                                    class="form-control form-control-glass border-start-0 ps-2 text-light"
                                                    placeholder="Nama Lengkap Anda" required style="height: 50px;">
                                            </div>
                                        </div>

                                        <div class="row">
                                            {{-- Username --}}
                                            <div class="col-md-6 mb-4">
                                                <label
                                                    class="form-label text-gold small fw-bold text-uppercase ls-1 mb-2">Username</label>
                                                <div class="input-group">
                                                    <span
                                                        class="input-group-text bg-transparent border-glass text-gold ps-3 pe-2"><i
                                                            class="fas fa-user"></i></span>
                                                    <input type="text" name="username"
                                                        class="form-control form-control-glass border-start-0 ps-2 text-light"
                                                        placeholder="Username" required style="height: 50px;">
                                                </div>
                                            </div>

                                            {{-- Password --}}
                                            <div class="col-md-6 mb-4">
                                                <label
                                                    class="form-label text-gold small fw-bold text-uppercase ls-1 mb-2">Password</label>
                                                <div class="input-group">
                                                    <span
                                                        class="input-group-text bg-transparent border-glass text-gold ps-3 pe-2"><i
                                                            class="fas fa-lock"></i></span>
                                                    <input type="password" name="password"
                                                        class="form-control form-control-glass border-start-0 ps-2 text-light"
                                                        placeholder="Password" required style="height: 50px;">
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Email --}}
                                        <div class="mb-4">
                                            <label
                                                class="form-label text-gold small fw-bold text-uppercase ls-1 mb-2">Email</label>
                                            <div class="input-group">
                                                <span
                                                    class="input-group-text bg-transparent border-glass text-gold ps-3 pe-2"><i
                                                        class="fas fa-envelope"></i></span>
                                                <input type="email" name="email"
                                                    class="form-control form-control-glass border-start-0 ps-2 text-light"
                                                    placeholder="email@contoh.com" required style="height: 50px;">
                                            </div>
                                        </div>

                                        <div class="row">
                                            {{-- No Telepon --}}
                                            <div class="col-md-6 mb-4">
                                                <label
                                                    class="form-label text-gold small fw-bold text-uppercase ls-1 mb-2">No.
                                                    Telepon</label>
                                                <div class="input-group">
                                                    <span
                                                        class="input-group-text bg-transparent border-glass text-gold ps-3 pe-2"><i
                                                            class="fas fa-phone"></i></span>
                                                    <input type="text" name="no_telp"
                                                        class="form-control form-control-glass border-start-0 ps-2 text-light"
                                                        placeholder="08xxxxxxxxxx" required style="height: 50px;">
                                                </div>
                                            </div>

                                            {{-- Jenis Kelamin --}}
                                            <div class="col-md-6 mb-4">
                                                <label
                                                    class="form-label text-gold small fw-bold text-uppercase ls-1 mb-2">Jenis
                                                    Kelamin</label>
                                                <div class="d-flex gap-2">
                                                    @foreach ($genders as $g)
                                                        <div class="flex-fill">
                                                            <input type="radio" class="btn-check"
                                                                name="gender_id" id="gender_{{ $g->id }}"
                                                                value="{{ $g->id }}" required>
                                                            <label class="btn btn-outline-glass w-100 h-100 d-flex align-items-center justify-content-center py-2"
                                                                for="gender_{{ $g->id }}">
                                                                <!-- Use simple text label or icons if mapped -->
                                                                {{ $g->gender_name }}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Alamat --}}
                                        <div class="mb-4">
                                            <label
                                                class="form-label text-gold small fw-bold text-uppercase ls-1 mb-2">Alamat
                                                Lengkap</label>
                                            <div class="input-group">
                                                <span
                                                    class="input-group-text bg-transparent border-glass text-gold ps-3 pe-2"><i
                                                        class="fas fa-map-marker-alt"></i></span>
                                                <textarea name="alamat"
                                                    class="form-control form-control-glass border-start-0 ps-2 text-light"
                                                    rows="2" placeholder="Masukkan alamat lengkap Anda" required></textarea>
                                            </div>
                                        </div>

                                        {{-- Foto Profil --}}
                                        <div class="mb-4">
                                            <label class="form-label text-gold small fw-bold text-uppercase ls-1 mb-2">Foto
                                                Profil</label>
                                            <div class="upload-zone p-4 border-dashed rounded-3 text-center position-relative transition-all hover-glow">
                                                <i class="fas fa-camera text-gold fa-2x mb-2"></i>
                                                <p class="text-light small fw-bold mb-1">Klik untuk upload foto</p>
                                                <p class="text-dim x-small mb-0" id="filename-preview">Format JPG/PNG, Maks 2MB</p>
                                                <input type="file" name="profile_picture"
                                                    class="position-absolute top-0 start-0 w-100 h-100 opacity-0 cursor-pointer"
                                                    required onchange="updateFileName(this)">
                                            </div>
                                        </div>

                                        <button type="submit"
                                            class="btn btn-gold w-100 py-3 rounded-pill fw-bold shadow-lg mb-4 hover:scale-105 transition-all">
                                            DAFTAR SEKARANG
                                        </button>

                                        <div class="text-center">
                                            <p class="text-dim small mb-0">Sudah punya akun? <a href="{{ url('/login') }}"
                                                    class="text-gold fw-bold text-decoration-none ms-1">Login Disini</a></p>
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
        }

        .form-control-glass:focus+.input-group-text,
        .input-group:focus-within .input-group-text {
            border-color: var(--accent-gold) !important;
            color: var(--accent-gold) !important;
        }

        .input-group:focus-within .form-control-glass {
            border-color: var(--accent-gold) !important;
        }

        /* Fix Autocomplete */
        input:-webkit-autofill,
        input:-webkit-autofill:hover, 
        input:-webkit-autofill:focus, 
        input:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0 30px #1a1412 inset !important;
            -webkit-text-fill-color: white !important;
            transition: background-color 5000s ease-in-out 0s;
        }

        /* Dashed Border for Upload */
        .border-dashed {
            border: 2px dashed rgba(212, 175, 55, 0.3) !important;
            background: rgba(255, 255, 255, 0.02);
            transition: all 0.3s ease;
        }
        .upload-zone:hover, .upload-zone.dragover {
            border-color: var(--accent-gold) !important;
            background: rgba(212, 175, 55, 0.05);
        }
        .cursor-pointer { cursor: pointer; }

        /* Glass Outline Button (Radio) */
        .btn-outline-glass {
            border: 1px solid rgba(255, 255, 255, 0.15);
            color: var(--text-dim);
            background: transparent;
            transition: all 0.3s ease;
            font-weight: 500;
        }
        .btn-check:checked + .btn-outline-glass {
            background: rgba(212, 175, 55, 0.15);
            border-color: var(--accent-gold);
            color: var(--accent-gold);
            box-shadow: 0 0 15px rgba(212, 175, 55, 0.2);
        }
        .btn-outline-glass:hover {
            border-color: rgba(212, 175, 55, 0.5);
            color: var(--text-light);
        }
        
        .x-small { font-size: 0.75rem; }
    </style>

    <script>
        function updateFileName(input) {
            const fileName = input.files[0]?.name;
            const preview = document.getElementById('filename-preview');
            if (fileName) {
                preview.textContent = fileName;
                preview.classList.add('text-gold');
                preview.classList.remove('text-dim');
            } else {
                preview.textContent = 'Format JPG/PNG, Maks 2MB';
                preview.classList.add('text-dim');
                preview.classList.remove('text-gold');
            }
        }
    </script>

@endsection