@extends('customers.layouts.app')

@section('title', 'Daftar Menu Lengkap')

@section('content')

{{-- Alert Pesan Sukses (Jika berhasil tambah/hapus favorit) --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show fixed-top m-3" role="alert" style="z-index: 1050; width: fit-content; left: 50%; transform: translateX(-50%);">
        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<section class="menu-list py-5" id="menu-section">
    <div class="container-fluid">
        <div class="text-center mb-5" data-aos="fade-down">
            <h1 class="display-5 fw-bold text-primary-dark">Daftar Menu Kami</h1>
            <p class="lead text-muted">Eksplorasi seluruh inovasi rasa dari biji kopi hingga sajian ringan.</p>
        </div>

        <div class="row g-5">
            
            {{-- KOLOM KIRI: SIDEBAR KATEGORI --}}
            <div class="col-lg-2" data-aos="fade-right">
                
                <h5 class="fw-bold text-uppercase text-primary-dark mb-4 border-bottom pb-2">Kategori</h5>
                
                <nav class="nav flex-column gap-2" id="menu-pills-tab" role="tablist">
                    
                    {{-- Link Semua --}}
                    <a href="{{ route('menu') }}?category=all" 
                       class="btn btn-outline-dark text-start fw-bold w-100 py-2 rounded-pill shadow-sm {{ request('category', 'all') == 'all' ? 'btn-primary-dark text-white active' : '' }}">
                        <i class="fas fa-list me-2"></i>Semua Menu
                    </a>
                    
                    {{-- Link Kopi --}}
                    <a href="{{ route('menu') }}?category=kopi" 
                       class="btn btn-outline-dark text-start fw-bold w-100 py-2 rounded-pill shadow-sm {{ request('category') == 'kopi' ? 'btn-primary-dark text-white active' : '' }}">
                        <i class="fas fa-mug-hot me-2"></i>Kopi
                    </a>
                    
                    {{-- Link Minuman (Non-Kopi) --}}
                    <a href="{{ route('menu') }}?category=minuman" 
                       class="btn btn-outline-dark text-start fw-bold w-100 py-2 rounded-pill shadow-sm {{ request('category') == 'minuman' ? 'btn-primary-dark text-white active' : '' }}">
                        <i class="fas fa-tint me-2"></i>Non-Kopi
                    </a>
                    
                    {{-- Link Cemilan --}}
                    <a href="{{ route('menu') }}?category=cemilan" 
                       class="btn btn-outline-dark text-start fw-bold w-100 py-2 rounded-pill shadow-sm {{ request('category') == 'cemilan' ? 'btn-primary-dark text-white active' : '' }}">
                        <i class="fas fa-cookie-bite me-2"></i>Cemilan
                    </a>

                    {{-- Link Makanan Berat --}}
                    <a href="{{ route('menu') }}?category=makanan_berat"
                       class="btn btn-outline-dark text-start fw-bold w-100 py-2 rounded-pill shadow-sm {{ request('category') == 'makanan_berat' ? 'btn-primary-dark text-white active' : '' }}">
                        <i class="fas fa-hamburger me-2"></i>Makanan
                    </a>

                    {{-- Link Favorite --}}
                    <a href="{{ route('menu') }}?category=favorite"
                       class="btn btn-outline-dark text-start fw-bold w-100 py-2 rounded-pill shadow-sm {{ request('category') == 'favorite' ? 'btn-primary-dark text-white active' : '' }}">
                        <i class="fas fa-heart me-2"></i>Favorite
                    </a>

                </nav>
            </div> 

            
            {{-- KOLOM KANAN: DAFTAR MENU CARDS --}}
            <div class="col-lg-10" data-aos="fade-left">
                <div class="row g-4" id="menu-cards-container">
                    
                    @forelse($menus as $menu)
                        {{-- Card menu --}}
                        <div class="col-6 col-md-4 col-lg-3">
                            
                            <div class="card border-0 shadow-sm h-100 bg-white position-relative overflow-hidden">
                                
                                {{-- FORM FAVORIT (Tanpa AJAX - Pojok Kanan Atas) --}}
                                <form action="{{ route('menu.favorite', $menu->id) }}" method="POST" 
                                      class="position-absolute top-0 end-0 m-2" style="z-index: 10;">
                                    @csrf
                                    <button type="submit" class="btn btn-light btn-sm rounded-circle shadow-sm" 
                                            style="width: 35px; height: 35px; padding: 0; display: flex; align-items: center; justify-content: center;"
                                            title="{{ $menu->is_favorited ? 'Hapus dari Favorit' : 'Tambah ke Favorit' }}">
                                        {{-- Ikon berubah warna sesuai status --}}
                                        <i class="{{ $menu->is_favorited ? 'fas text-danger' : 'far text-muted' }} fa-heart fs-5"></i>
                                    </button>
                                </form>

                                {{-- Gambar Menu --}}
                                <div class="image-wrap bg-light d-flex align-items-center justify-content-center" style="height: 200px; overflow: hidden;">
                                    {{-- Gunakan asset() dengan path folder 'foto' --}}
                                    <img src="{{ asset('foto/' . $menu->url_foto) }}" 
                                         class="card-img-top w-100 h-100" 
                                         style="object-fit: cover;" 
                                         alt="{{ $menu->nama }}"
                                         onerror="this.onerror=null; this.src='https://via.placeholder.com/200?text=No+Image';">
                                </div>

                                <div class="card-body d-flex flex-column">
                                    <div class="mb-2">
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-10 rounded-pill px-2 py-1 small">
                                            {{ $menu->type->type_name ?? 'Umum' }}
                                        </span>
                                    </div>

                                    <h5 class="card-title fw-bold text-dark mb-1 text-truncate" title="{{ $menu->nama }}">{{ $menu->nama }}</h5>
                                    
                                    {{-- Potong deskripsi biar tidak terlalu panjang --}}
                                    <p class="card-text text-secondary small flex-grow-1 mb-3" style="min-height: 40px;">
                                        {{ Str::limit($menu->deskripsi, 50) }}
                                    </p>
                                    
                                    <div class="d-flex justify-content-between align-items-center mt-auto">
                                        <p class="fw-bold text-primary-dark mb-0 fs-5">Rp {{ number_format($menu->price, 0, ',', '.') }}</p>
                                        <a href="{{ url('/menu/'.$menu->id) }}" class="btn btn-outline-primary btn-sm rounded-pill px-3">Detail</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5">
                            <i class="fas fa-{{ request('category') == 'favorite' ? 'heart' : 'search' }} fa-3x text-muted mb-3"></i>
                            <h4 class="text-muted">
                                @if(request('category') == 'favorite')
                                    Belum ada menu favorit.
                                @else
                                    Belum ada menu di kategori ini.
                                @endif
                            </h4>
                            @if(request('category') && request('category') != 'all')
                                <a href="{{ route('menu') }}" class="btn btn-primary mt-3">Lihat Semua Menu</a>
                            @endif
                        </div>
                    @endforelse

                </div>
            </div>

        </div>
    </div>
</section>

@endsection
