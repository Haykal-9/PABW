@extends('layouts.app')

@section('title', 'Home')

@section('content')
    {{-- BAGIAN 1: HERO SECTION - Dibuat lebih tinggi (min-vh-100) dan menggunakan cover image --}}
    <section class="home min-vh-100 d-flex align-items-center text-center text-white" id="home">
        <div class="container">
            <div class="home-content p-5 rounded bg-dark bg-opacity-50" data-aos="zoom-in">
                <div class="subtitle">
                    <h3 class="display-6 fw-normal mb-1">Selamat Datang di</h3>
                    <h1 class="display-1 fw-bold mb-3">Tapal<span class="text-warning">Kuda</span></h1>
                    <p class="lead mb-4 mx-auto" style="max-width: 600px;">
                        Nikmati kenikmatan kopi Tapal Kuda yang diambil dari biji kopi asli dan suasana yang asri.
                    </p>
                    <a href="{{ url('/menu') }}" class="btn btn-warning btn-lg shadow-sm">Pesan Sekarang</a>
                </div>
            </div>
        </div>
    </section>

    {{-- BAGIAN 2: NEW MENU - Dibuat lebih menonjol dengan Shado --}}
    <section class="new-menu container my-5 py-5">
        <div class="text-center mb-5" data-aos="fade-down">
            <h1 class="title-new-menu display-4 fw-bold">Menu <span class="text-primary">Terbaru</span></h1>
        </div>

        <div class="row g-4 justify-content-center">
            <div class="col-md-4" data-aos="fade-left">
                <div class="card h-100 border-0 shadow-lg p-3">
                    <img src="https://placehold.co/300x300" class="card-img-top rounded" alt="New Menu Item">
                    <div class="card-body text-center">
                        <h3 class="card-title fw-bold">NAMA MENU 1</h3>
                        <p class="card-text text-muted">Deskripsi menu 1...</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4" data-aos="fade-left" data-aos-delay="100">
                <div class="card h-100 border-0 shadow-lg p-3">
                    <img src="https://placehold.co/300x300" class="card-img-top rounded" alt="New Menu Item 2">
                    <div class="card-body text-center">
                        <h3 class="card-title fw-bold">NAMA MENU 2</h3>
                        <p class="card-text text-muted">Deskripsi menu 2...</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4" data-aos="fade-left" data-aos-delay="200">
                <div class="card h-100 border-0 shadow-lg p-3">
                    <img src="https://placehold.co/300x300" class="card-img-top rounded" alt="New Menu Item 3">
                    <div class="card-body text-center">
                        <h3 class="card-title fw-bold">NAMA MENU 3</h3>
                        <p class="card-text text-muted">Deskripsi menu 3...</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- BAGIAN 3: CATEGORY - Menggunakan latar belakang gelap (dark) dan ikon jika ada --}}
    <section class="menu-section bg-dark py-5 text-white">
        <div class="container">
            <div class="header-menu text-center mb-5" data-aos="fade-down">
                <h1 class="display-4 fw-bold">Pilihan <span class="text-warning">Kategori</span> Kami</h1>
                <p class="lead text-muted">Temukan rasa yang dibuat dengan sempurna, khusus untuk Anda.</p>
            </div>
            <div class="row g-4">
                {{-- Card 1: Coffee --}}
                <div class="col-md-4" data-aos="flip-up">
                    <div class="card menu-item h-100 text-center bg-secondary border-0 shadow">
                        <img src="https://placehold.co/300x200" class="card-img-top" alt="Coffee">
                        <div class="card-body menu-info">
                            <h3 class="card-title fw-bold text-warning">Coffee</h3>
                            <p class="card-text">Dari minuman tradisional berbasis espresso sampai berbagai minuman racikan kopi terkini.</p>
                        </div>
                    </div>
                </div>
                {{-- Card 2: Non-Coffee --}}
                <div class="col-md-4" data-aos="flip-up" data-aos-delay="100">
                    <div class="card menu-item h-100 text-center bg-secondary border-0 shadow">
                        <img src="https://placehold.co/300x200" class="card-img-top" alt="Non-Coffee">
                        <div class="card-body menu-info">
                            <h3 class="card-title fw-bold text-warning">Non-Coffee</h3>
                            <p class="card-text">Kami juga memiliki menu non-coffee untuk kamu yang ingin pilihan lain selain kopi dan untuk anak - anak.</p>
                        </div>
                    </div>
                </div>
                {{-- Card 3: Food & Snack --}}
                <div class="col-md-4" data-aos="flip-up" data-aos-delay="200">
                     <div class="card menu-item h-100 text-center bg-secondary border-0 shadow">
                        <img src="https://placehold.co/300x200" class="card-img-top" alt="Food & Snack">
                        <div class="card-body menu-info">
                            <h3 class="card-title fw-bold text-warning">Food & Snack</h3>
                            <p class="card-text">Berbagai macam makanan ringan sampai makanan utama siap menemani secangkir kopimu.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
@endpush