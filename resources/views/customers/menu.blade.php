@extends('customers.layouts.app')

@section('title', 'Daftar Menu Lengkap')

@section('content')

    {{-- Alert Pesan Sukses --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show fixed-top m-3 shadow" role="alert"
            style="z-index: 1050; width: fit-content; left: 50%; transform: translateX(-50%);">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- MENU HERO --}}
    <section class="menu-hero py-5 position-relative overflow-hidden" style="margin-top: 80px;">
        <div class="container text-center text-white position-relative" style="z-index: 10;">
            <h1 class="display-4 fw-bold font-serif mb-2 aos-init aos-animate" data-aos="fade-down">
                Daftar <span class="text-gold">Menu</span>
            </h1>
            <p class="lead text-dim fw-light mb-5" data-aos="fade-up" data-aos-delay="100">
                Eksplorasi seluruh inovasi rasa dari biji kopi hingga sajian ringan.
            </p>
        </div>

        {{-- Background radial gradient is already in body, but we can add a subtle glow here if needed --}}
        <div class="position-absolute top-50 start-50 translate-middle w-50 h-50 rounded-circle"
            style="background: radial-gradient(circle, rgba(212,175,55,0.15) 0%, transparent 70%); filter: blur(50px); z-index: 1;">
        </div>
    </section>


    <section class="menu-list pb-5 position-relative" id="menu-section">
        <div class="container-fluid px-4 px-lg-5">
            <div class="row g-5">

                {{-- KOLOM KIRI: SIDEBAR FILTER & SEARCH --}}
                <div class="col-lg-3" data-aos="fade-right">
                    <div class="glass-card p-4 h-100 border-0" style="border-radius: 16px;">
                        <div class="sticky-top" style="top: 100px; z-index: 90;">
                            {{-- SEARCH BAR --}}
                            <h5 class="text-light fw-bold mb-4 font-serif">
                                <i class="fas fa-search me-2 text-gold"></i>Pencarian
                            </h5>
                            <form action="{{ route('menu') }}" method="GET" class="mb-5">
                                @if(request('category'))
                                    <input type="hidden" name="category" value="{{ request('category') }}">
                                @endif
                                <div class="position-relative">
                                    <input type="text" name="search"
                                        class="form-control form-control-glass ps-4 pe-5 w-100 text-light"
                                        placeholder="Cari menu..." value="{{ request('search') }}" autocomplete="off"
                                        style="border-radius: 12px; height: 50px;">
                                    <button class="btn position-absolute end-0 top-0 h-100 px-3 text-gold" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </form>

                            {{-- FILTER KATEGORI --}}
                            <h5 class="text-light fw-bold mb-4 pb-2 border-bottom border-secondary font-serif">
                                <i class="fas fa-filter me-2 text-gold"></i>Kategori
                            </h5>
                            <nav class="nav flex-column gap-2">
                                @php
                                    $currentCat = request('category', 'all');
                                    $searchQuery = request('search') ? '&search=' . request('search') : '';
                                    $categories = [
                                        ['id' => 'all', 'name' => 'Semua Menu', 'icon' => 'fas fa-list'],
                                        ['id' => 'kopi', 'name' => 'Kopi', 'icon' => 'fas fa-mug-hot'],
                                        ['id' => 'minuman', 'name' => 'Non-Kopi', 'icon' => 'fas fa-tint'],
                                        ['id' => 'cemilan', 'name' => 'Cemilan', 'icon' => 'fas fa-cookie-bite'],
                                        ['id' => 'makanan_berat', 'name' => 'Makanan', 'icon' => 'fas fa-hamburger'],
                                        ['id' => 'favorite', 'name' => 'Favorite', 'icon' => 'fas fa-heart']
                                    ];
                                @endphp

                                @foreach ($categories as $cat)
                                    <a href="{{ route('menu') }}?category={{ $cat['id'] }}{{ $searchQuery }}"
                                        class="d-flex align-items-center justify-content-between p-3 rounded-pill text-decoration-none transition-all {{ $currentCat == $cat['id'] ? 'bg-gold text-dark fw-bold' : 'text-dim hover-glass' }}">
                                        <span class="d-flex align-items-center">
                                            <i class="{{ $cat['icon'] }} me-3 {{ $currentCat == $cat['id'] ? 'text-dark' : 'text-gold' }}"
                                                style="width: 20px;"></i>
                                            {{ $cat['name'] }}
                                        </span>
                                        @if($currentCat != $cat['id'])
                                            <i class="fas fa-chevron-right small opacity-50"></i>
                                        @endif
                                    </a>
                                @endforeach
                            </nav>
                        </div>
                    </div>
                </div>

                {{-- KOLOM KANAN: DAFTAR MENU --}}
                <div class="col-lg-9" data-aos="fade-left">
                    <div class="row g-4">

                        @forelse($menus as $menu)
                            <div class="col-md-6 col-lg-4 col-xl-3">
                                <div class="glass-card h-100 d-flex flex-column border-0 hover-scale overflow-hidden"
                                    style="border-radius: 16px;">

                                    {{-- Tombol Favorit (Pojok Kanan Atas) --}}
                                    {{-- Tombol Favorit (Pojok Kanan Atas) --}}
                                    @auth
                                        <form action="{{ route('menu.favorite', $menu->id) }}" method="POST"
                                            class="position-absolute top-0 end-0 m-3" style="z-index: 10;">
                                            @csrf
                                            <button type="submit"
                                                class="btn btn-sm btn-glass rounded-circle shadow-sm p-2 d-flex align-items-center justify-content-center"
                                                style="width: 36px; height: 36px; {{ $menu->is_favorited ? 'background: rgba(220, 53, 69, 0.2); border-color: #dc3545;' : '' }}"
                                                title="{{ $menu->is_favorited ? 'Hapus dari Favorit' : 'Tambah ke Favorit' }}">
                                                <i
                                                    class="{{ $menu->is_favorited ? 'fas text-danger' : 'far text-white' }} fa-heart"></i>
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ route('login') }}" class="btn btn-sm btn-glass rounded-circle shadow-sm p-2 d-flex align-items-center justify-content-center position-absolute top-0 end-0 m-3"
                                            style="width: 36px; height: 36px; z-index: 10;" title="Login untuk Favorit">
                                            <i class="far text-white fa-heart"></i>
                                        </a>
                                    @endauth

                                    {{-- Gambar --}}
                                    <div class="position-relative overflow-hidden" style="height: 220px;">
                                        <img src="{{ asset('foto/' . $menu->url_foto) }}"
                                            class="w-100 h-100 object-fit-cover transition-transform" alt="{{ $menu->nama }}">
                                        <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center opacity-0 hover-opacity transition-all"
                                            style="background: rgba(0,0,0,0.5); backdrop-filter: blur(2px);">
                                            <a href="{{ route('menu.detail', $menu->id) }}"
                                                class="btn btn-gold btn-sm px-4 rounded-pill fw-bold">
                                                Lihat Detail
                                            </a>
                                        </div>
                                    </div>

                                    <div class="p-4 d-flex flex-column flex-grow-1">
                                        <div class="mb-2 d-flex justify-content-center">
                                            <span
                                                class="badge bg-transparent border border-secondary text-dim rounded-pill x-small px-2">
                                                {{ ucfirst($menu->kategori) }}
                                            </span>
                                        </div>

                                        <h5 class="fw-bold text-center text-light mb-2 text-truncate font-serif"
                                            title="{{ $menu->nama }}">
                                            {{ $menu->nama }}
                                        </h5>

                                        {{-- Rating Bintang --}}
                                        <div class="mb-3 d-flex align-items-center justify-content-center">
                                            @php $rating = $menu->reviews_avg_rating ?? 0; @endphp
                                            @foreach(range(1, 5) as $i)
                                                @if($rating >= $i)
                                                    <i class="fas fa-star text-gold small"></i>
                                                @elseif($rating >= $i - 0.5)
                                                    <i class="fas fa-star-half-alt text-gold small"></i>
                                                @else
                                                    <i class="far fa-star text-muted opacity-25 small"></i>
                                                @endif
                                            @endforeach
                                            <span class="text-dim x-small ms-1">({{ number_format($rating, 1) }})</span>
                                        </div>



                                        <div
                                            class="mt-auto pt-3 border-top border-secondary border-opacity-25 d-flex justify-content-between align-items-center">
                                            <p class="text-gold fw-bold mb-0 font-monospace">Rp
                                                {{ number_format($menu->price, 0, ',', '.') }}
                                            </p>

                                            {{-- Tombol Beli --}}
                                            @auth
                                                <form action="{{ route('cart.add', ['id' => $menu->id]) }}" method="POST">
                                                    @csrf
                                                    <button type="submit"
                                                        class="btn btn-outline-glass btn-sm rounded-pill px-3 d-flex align-items-center gap-2 text-light hover-gold-bg"
                                                        title="Beli Sekarang">
                                                        <i class="fas fa-cart-plus"></i> Beli
                                                    </button>
                                                </form>
                                            @else
                                                <a href="{{ route('login') }}"
                                                    class="btn btn-outline-glass btn-sm rounded-pill px-3 d-flex align-items-center gap-2 text-light hover-gold-bg"
                                                    title="Login untuk Beli">
                                                    <i class="fas fa-sign-in-alt"></i> Beli
                                                </a>
                                            @endauth
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-center py-5">
                                <div class="glass-card p-5 border-0 rounded-4">
                                    <i class="fas fa-mug-hot fa-3x text-dim mb-3 opacity-50"></i>
                                    <h4 class="text-light fw-bold mb-2">Belum ada menu.</h4>
                                    <p class="text-dim">Silakan cek kembali nanti atau ganti filter pencarian.</p>
                                    <a href="{{ route('menu') }}" class="btn btn-gold rounded-pill px-4 mt-3">Lihat Semua
                                        Menu</a>
                                </div>
                            </div>
                        @endforelse

                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .hover-glass:hover {
            background: rgba(255, 255, 255, 0.05);
            color: var(--text-light) !important;
        }

        .bg-gold {
            background-color: var(--accent-gold) !important;
        }

        .text-dark {
            color: var(--primary-dark) !important;
        }

        .hover-scale:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        }

        .hover-scale {
            transition: all 0.3s ease;
        }

        .object-fit-cover {
            object-fit: cover;
        }

        .hover-opacity:hover {
            opacity: 1 !important;
        }

        .hover-gold-bg:hover {
            background-color: var(--accent-gold) !important;
            border-color: var(--accent-gold) !important;
            color: var(--primary-dark) !important;
        }

        .x-small {
            font-size: 0.75rem;
        }
    </style>

@endsection