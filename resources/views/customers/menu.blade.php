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

<section class="menu-list py-5" id="menu-section">
    <div class="container-fluid">
        
        {{-- Header Title --}}
        <div class="text-center mb-5" data-aos="fade-down">
            <h1 class="display-5 fw-bold text-primary-dark">Daftar Menu Kami</h1>
            <p class="lead text-muted">Eksplorasi seluruh inovasi rasa dari biji kopi hingga sajian ringan.</p>
        </div>

        <div class="row g-5">
            
            {{-- KOLOM KIRI: SIDEBAR FILTER & SEARCH --}}
            <div class="col-lg-2" data-aos="fade-right">
                
                {{-- SEARCH BAR --}}
                <h5 class="fw-bold text-uppercase text-primary-dark mb-3">Pencarian</h5>
                <form action="{{ route('menu') }}" method="GET" class="mb-4">
                    @if(request('category'))
                        <input type="hidden" name="category" value="{{ request('category') }}">
                    @endif
                    <div class="input-group shadow-sm rounded-pill overflow-hidden border">
                        <input type="text" name="search" class="form-control border-0 bg-white ps-3" 
                               placeholder="Cari..." value="{{ request('search') }}" autocomplete="off">
                        <button class="btn btn-white bg-white text-primary-dark border-0 pe-3" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
                
                {{-- FILTER KATEGORI --}}
                <h5 class="fw-bold text-uppercase text-primary-dark mb-4 border-bottom pb-2">Kategori</h5>
                <nav class="nav flex-column gap-2">
                    @php
                        $currentCat = request('category', 'all');
                        $searchQuery = request('search') ? '&search='.request('search') : '';
                    @endphp

                    <a href="{{ route('menu') }}?category=all{{ $searchQuery }}" 
                       class="btn text-start w-100 py-2 rounded-pill shadow-sm {{ $currentCat == 'all' ? 'btn-primary-dark text-white fw-bold' : 'btn-outline-dark text-dark bg-transparent' }}">
                        <i class="fas fa-list me-2"></i>Semua Menu
                    </a>
                    
                    <a href="{{ route('menu') }}?category=kopi{{ $searchQuery }}" 
                       class="btn text-start w-100 py-2 rounded-pill shadow-sm {{ $currentCat == 'kopi' ? 'btn-primary-dark text-white fw-bold' : 'btn-outline-dark text-dark bg-transparent' }}">
                        <i class="fas fa-mug-hot me-2"></i>Kopi
                    </a>
                    
                    <a href="{{ route('menu') }}?category=minuman{{ $searchQuery }}" 
                       class="btn text-start w-100 py-2 rounded-pill shadow-sm {{ $currentCat == 'minuman' ? 'btn-primary-dark text-white fw-bold' : 'btn-outline-dark text-dark bg-transparent' }}">
                        <i class="fas fa-tint me-2"></i>Non-Kopi
                    </a>
                    
                    <a href="{{ route('menu') }}?category=cemilan{{ $searchQuery }}" 
                       class="btn text-start w-100 py-2 rounded-pill shadow-sm {{ $currentCat == 'cemilan' ? 'btn-primary-dark text-white fw-bold' : 'btn-outline-dark text-dark bg-transparent' }}">
                        <i class="fas fa-cookie-bite me-2"></i>Cemilan
                    </a>

                    <a href="{{ route('menu') }}?category=makanan_berat{{ $searchQuery }}"
                       class="btn text-start w-100 py-2 rounded-pill shadow-sm {{ $currentCat == 'makanan_berat' ? 'btn-primary-dark text-white fw-bold' : 'btn-outline-dark text-dark bg-transparent' }}">
                        <i class="fas fa-hamburger me-2"></i>Makanan
                    </a>

                    <a href="{{ route('menu') }}?category=favorite{{ $searchQuery }}"
                       class="btn text-start w-100 py-2 rounded-pill shadow-sm {{ $currentCat == 'favorite' ? 'btn-primary-dark text-white fw-bold' : 'btn-outline-dark text-dark bg-transparent' }}">
                        <i class="fas fa-heart me-2"></i>Favorite
                    </a>
                </nav>
            </div> 

            {{-- KOLOM KANAN: DAFTAR MENU --}}
            <div class="col-lg-10" data-aos="fade-left">
                <div class="row g-4">
                    
                    @forelse($menus as $menu)
                        <div class="col-6 col-md-4 col-lg-3">
                            <div class="card border-0 shadow-sm h-100 bg-white position-relative overflow-hidden">
                                
                                {{-- Tombol Favorit (Pojok Kanan Atas) --}}
                                <form action="{{ route('menu.favorite', $menu->id) }}" method="POST" 
                                      class="position-absolute top-0 end-0 m-2" style="z-index: 10;">
                                    @csrf
                                    <button type="submit" class="btn btn-light btn-sm rounded-circle shadow-sm" 
                                            style="width: 35px; height: 35px; padding: 0; display: flex; align-items: center; justify-content: center;"
                                            title="{{ $menu->is_favorited ? 'Hapus dari Favorit' : 'Tambah ke Favorit' }}">
                                        <i class="{{ $menu->is_favorited ? 'fas text-danger' : 'far text-muted' }} fa-heart fs-5"></i>
                                    </button>
                                </form>

                                {{-- Gambar --}}
                                <div class="image-wrap bg-light d-flex align-items-center justify-content-center" style="height: 200px; overflow: hidden;">
                                    <img src="{{ asset('foto/' . $menu->url_foto) }}" 
                                         class="card-img-top w-100 h-100" style="object-fit: cover;" 
                                         alt="{{ $menu->nama }}"">
                                </div>

                                <div class="card-body d-flex flex-column">
                                    <div class="mb-2">
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-10 rounded-pill px-2 py-1 small">
                                            {{ $menu->type->type_name ?? 'Umum' }}
                                        </span>
                                    </div>

                                    <h5 class="card-title fw-bold text-dark mb-1 text-truncate" title="{{ $menu->nama }}">{{ $menu->nama }}</h5>
                                    
                                    {{-- Rating Bintang --}}
                                    <div class="mb-2 d-flex align-items-center">
                                        @php $rating = $menu->reviews_avg_rating ?? 0; @endphp
                                        @foreach(range(1, 5) as $i)
                                            @if($rating >= $i)
                                                <i class="fas fa-star text-warning small" style="font-size: 0.8rem;"></i>
                                            @elseif($rating >= $i - 0.5)
                                                <i class="fas fa-star-half-alt text-warning small" style="font-size: 0.8rem;"></i>
                                            @else
                                                <i class="far fa-star text-muted opacity-25 small" style="font-size: 0.8rem;"></i>
                                            @endif
                                        @endforeach
                                    </div>

                                    <p class="card-text text-secondary small flex-grow-1 mb-3">
                                        {{ $menu->deskripsi }}
                                    </p>
                                    
                                    <div class="d-flex justify-content-between align-items-center mt-auto">
                                        <p class="fw-bold text-primary-dark mb-0 fs-5">Rp {{ number_format($menu->price, 0, ',', '.') }}</p>
                                        
                                        <div class="d-flex gap-2">
                                            {{-- Tombol Beli --}}
                                            <form action="{{ route('cart.add', ['id' => $menu->id]) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-primary-dark btn-sm rounded-circle shadow-sm d-flex align-items-center justify-content-center" 
                                                        style="width: 35px; height: 35px;" title="Beli Sekarang">
                                                    <i class="fas fa-cart-plus text-white"></i>
                                                </button>
                                            </form>
                                            {{-- Tombol Detail --}}
                                            <a href="{{ route('menu.detail', $menu->id) }}" class="btn btn-outline-primary btn-sm rounded-pill px-3 d-flex align-items-center">Detail</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5">
                            <i class="fas fa-search fa-3x text-muted mb-3 opacity-50"></i>
                            <h4 class="text-muted">Tidak ada menu yang ditemukan.</h4>
                            <a href="{{ route('menu') }}" class="btn btn-primary mt-3">Lihat Semua Menu</a>
                        </div>
                    @endforelse

                </div>
            </div>
        </div>
    </div>
</section>
@endsection