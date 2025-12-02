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

    <section class="menu-list py-5 position-relative" id="menu-section" style="background-color: var(--bg-paper);">
        {{-- Decorative Background Elements --}}
        <div class="vintage-decoration-bg">
            <span class="bg-bean-1">☕</span>
            <span class="bg-bean-2">☕</span>
        </div>

        <div class="container-fluid px-4 px-lg-5">

            {{-- Header Title --}}
            <div class="text-center mb-5" data-aos="fade-down">
                <div class="vintage-section-ornament mb-3">
                    <span class="ornament-left">◆</span>
                    <span class="ornament-coffee">☕</span>
                    <span class="ornament-right">◆</span>
                </div>
                <h1 class="vintage-section-title display-5 fw-bold text-primary-dark mb-3">Daftar Menu Kami</h1>
                <div class="vintage-divider-small mx-auto mb-3"></div>
                <p class="lead text-muted">Eksplorasi seluruh inovasi rasa dari biji kopi hingga sajian ringan.</p>
            </div>

            <div class="row g-5">

                {{-- KOLOM KIRI: SIDEBAR FILTER & SEARCH --}}
                <div class="col-lg-3" data-aos="fade-right">
                    <div class="vintage-sidebar p-4 h-100">
                        <div class="sticky-top" style="top: 100px; z-index: 90;">
                            {{-- SEARCH BAR --}}
                            <h5 class="vintage-sidebar-title mb-4">
                                <i class="fas fa-search me-2 text-gold"></i>Pencarian
                            </h5>
                            <form action="{{ route('menu') }}" method="GET" class="mb-5">
                                @if(request('category'))
                                    <input type="hidden" name="category" value="{{ request('category') }}">
                                @endif
                                <div class="vintage-search-group position-relative">
                                    <input type="text" name="search" class="form-control vintage-search-input ps-4 pe-5"
                                        placeholder="Cari menu..." value="{{ request('search') }}" autocomplete="off">
                                    <button class="btn vintage-search-btn position-absolute end-0 top-0 h-100 px-3"
                                        type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </form>

                            {{-- FILTER KATEGORI --}}
                            <h5 class="vintage-sidebar-title mb-4 pb-2 border-bottom border-secondary">
                                <i class="fas fa-filter me-2 text-gold"></i>Kategori
                            </h5>
                            <nav class="nav flex-column gap-2 vintage-category-nav">
                                @php
                                    $currentCat = request('category', 'all');
                                    $searchQuery = request('search') ? '&search=' . request('search') : '';
                                @endphp

                                <a href="{{ route('menu') }}?category=all{{ $searchQuery }}"
                                    class="vintage-cat-link {{ $currentCat == 'all' ? 'active' : '' }}">
                                    <span class="cat-icon"><i class="fas fa-list"></i></span>
                                    <span class="cat-text">Semua Menu</span>
                                    <span class="cat-arrow">›</span>
                                </a>

                                <a href="{{ route('menu') }}?category=kopi{{ $searchQuery }}"
                                    class="vintage-cat-link {{ $currentCat == 'kopi' ? 'active' : '' }}">
                                    <span class="cat-icon"><i class="fas fa-mug-hot"></i></span>
                                    <span class="cat-text">Kopi</span>
                                    <span class="cat-arrow">›</span>
                                </a>

                                <a href="{{ route('menu') }}?category=minuman{{ $searchQuery }}"
                                    class="vintage-cat-link {{ $currentCat == 'minuman' ? 'active' : '' }}">
                                    <span class="cat-icon"><i class="fas fa-tint"></i></span>
                                    <span class="cat-text">Non-Kopi</span>
                                    <span class="cat-arrow">›</span>
                                </a>

                                <a href="{{ route('menu') }}?category=cemilan{{ $searchQuery }}"
                                    class="vintage-cat-link {{ $currentCat == 'cemilan' ? 'active' : '' }}">
                                    <span class="cat-icon"><i class="fas fa-cookie-bite"></i></span>
                                    <span class="cat-text">Cemilan</span>
                                    <span class="cat-arrow">›</span>
                                </a>

                                <a href="{{ route('menu') }}?category=makanan_berat{{ $searchQuery }}"
                                    class="vintage-cat-link {{ $currentCat == 'makanan_berat' ? 'active' : '' }}">
                                    <span class="cat-icon"><i class="fas fa-hamburger"></i></span>
                                    <span class="cat-text">Makanan</span>
                                    <span class="cat-arrow">›</span>
                                </a>

                                <a href="{{ route('menu') }}?category=favorite{{ $searchQuery }}"
                                    class="vintage-cat-link {{ $currentCat == 'favorite' ? 'active' : '' }}">
                                    <span class="cat-icon"><i class="fas fa-heart"></i></span>
                                    <span class="cat-text">Favorite</span>
                                    <span class="cat-arrow">›</span>
                                </a>
                            </nav>
                        </div>
                    </div>
                </div>

                {{-- KOLOM KANAN: DAFTAR MENU --}}
                <div class="col-lg-9" data-aos="fade-left">
                    <div class="row g-4">

                        @forelse($menus as $menu)
                            <div class="col-md-6 col-lg-4 col-xl-4">
                                <div class="vintage-menu-card h-100 d-flex flex-column">

                                    {{-- Tombol Favorit (Pojok Kanan Atas) --}}
                                    <form action="{{ route('menu.favorite', $menu->id) }}" method="POST"
                                        class="position-absolute top-0 end-0 m-3" style="z-index: 10;">
                                        @csrf
                                        <button type="submit" class="btn btn-vintage-icon rounded-circle shadow-sm"
                                            title="{{ $menu->is_favorited ? 'Hapus dari Favorit' : 'Tambah ke Favorit' }}">
                                            <i class="{{ $menu->is_favorited ? 'fas text-danger' : 'far' }} fa-heart"></i>
                                        </button>
                                    </form>

                                    {{-- Gambar --}}
                                    <div class="vintage-card-image-wrapper" style="height: 220px;">
                                        <img src="{{ asset('foto/' . $menu->url_foto) }}" class="vintage-card-image w-100 h-100"
                                            alt="{{ $menu->nama }}">
                                        <div class="vintage-card-overlay">
                                            <a href="{{ route('menu.detail', $menu->id) }}"
                                                class="btn btn-vintage-gold btn-sm px-3">
                                                Lihat Detail
                                            </a>
                                        </div>
                                    </div>

                                    <div class="vintage-card-body d-flex flex-column flex-grow-1 p-4">
                                        <div class="card-ornament-top text-center mb-2">◆</div>

                                        <h5 class="vintage-card-title fw-bold text-center mb-2 text-truncate"
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
                                        </div>

                                        <p class="vintage-card-subtitle text-center small flex-grow-1 mb-4 line-clamp-2">
                                            {{ $menu->deskripsi }}
                                        </p>

                                        <div
                                            class="vintage-card-footer mt-auto pt-3 border-top border-secondary border-opacity-25 d-flex justify-content-between align-items-center">
                                            <p class="vintage-price mb-0">Rp {{ number_format($menu->price, 0, ',', '.') }}</p>

                                            {{-- Tombol Beli --}}
                                            <form action="{{ route('cart.add', ['id' => $menu->id]) }}" method="POST">
                                                @csrf
                                                <button type="submit"
                                                    class="btn btn-vintage-primary btn-sm rounded-pill px-3 shadow-sm d-flex align-items-center gap-2"
                                                    title="Beli Sekarang">
                                                    <i class="fas fa-cart-plus"></i> Beli
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-center py-5">
                                <div class="vintage-empty-state p-5 border border-2 border-secondary border-opacity-25 rounded">
                                    <i class="fas fa-search fa-3x text-muted mb-3 opacity-50"></i>
                                    <h4 class="text-muted vintage-font">Tidak ada menu yang ditemukan.</h4>
                                    <a href="{{ route('menu') }}" class="btn btn-vintage-outline mt-3">Lihat Semua Menu</a>
                                </div>
                            </div>
                        @endforelse

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection