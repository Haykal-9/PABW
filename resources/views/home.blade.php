@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <section class="home" id="home">
        <div class="home-content">
            <div class="subtitle" data-aos="zoom-in">
                <h3>Welcome to</h3>
                <h1>Tapal<span>Kuda</span></h1>
                <p>
                    Nikmati kenikmatan kopi Tapal Kuda yang diambil dari biji kopi asli dan suasana yang asri.
                </p>
                <a href="{{ url('/menu') }}" class="btn btn-primary">Order Now</a>
            </div>
        </div>
    </section>

    <section class="new-menu container my-5">
        <div class="text-center" data-aos="fade-down">
            <h1 class="title-new-menu">New <span>Menu</span></h1>
        </div>
        <div class="container-new-menu">
            <div class="new-menu-item" data-aos="fade-right">
                <img src="https://placehold.co/300x300" class="img-fluid" alt="New Menu Item">
                <div class="new-menu-item-content">
                    <h3>RED AND BLACK MOCKTAIL COFFEE</h3>
                    <p>Minuman mocktail yang menyegarkan ini memadukan kopi dengan sentuhan rasa manis dan asam dari
                        buah beri.</p>
                </div>
            </div>
             {{-- Tambahkan item menu baru lainnya di sini dengan struktur yang sama --}}
        </div>
    </section>

    <section class="menu-section bg-light py-5">
        <div class="container">
            <div class="header-menu text-center" data-aos="fade-down">
                <h1>Our <span>Category</span></h1>
                <p>Discover the flavors crafted to perfection, just for you.</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4" data-aos="flip-down">
                    <div class="card menu-item h-100">
                        <img src="https://placehold.co/300x200" class="card-img-top" alt="Coffee">
                        <div class="card-body menu-info">
                            <h3 class="card-title">Coffee</h3>
                            <p class="card-text">Dari minunan tradisional berbasis espresso sampai berbagai minuman racikan kopi terkini.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" data-aos="flip-down">
                    <div class="card menu-item h-100">
                        <img src="https://placehold.co/300x200" class="card-img-top" alt="Non-Coffee">
                        <div class="card-body menu-info">
                            <h3 class="card-title">Non-Coffee</h3>
                            <p class="card-text">Kami juga memiliki menu non-coffee untuk kamu yang ingin pilihan lain selain kopi dan untuk anak - anak.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" data-aos="flip-down">
                     <div class="card menu-item h-100">
                        <img src="https://placehold.co/300x200" class="card-img-top" alt="Food & Snack">
                        <div class="card-body menu-info">
                            <h3 class="card-title">Food & Snack</h3>
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