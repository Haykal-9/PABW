@extends('customers.layouts.app')

@section('title', 'Detail Menu - ' . $menu->nama)

@section('content')

{{-- Alert Pesan Sukses --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show container mt-4" role="alert">
        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<section class="detail-section py-5">
    <div class="container">
        
        {{-- Tombol Kembali --}}
        <div class="mb-4">
            <a href="{{ route('menu') }}" class="text-decoration-none text-muted fw-bold">
                <i class="fas fa-arrow-left me-2"></i> Kembali ke Menu
            </a>
        </div>

        {{-- KARTU DETAIL PRODUK --}}
        <div class="card border-0 shadow-sm overflow-hidden mb-5">
            <div class="row g-0">
                
                {{-- KOLOM KIRI: GAMBAR --}}
                <div class="col-md-5 bg-light d-flex align-items-center justify-content-center" style="min-height: 400px;">
                    <img src="{{ asset('foto/' . $menu->url_foto) }}" 
                         class="img-fluid" 
                         style="max-height: 400px; width: 100%; object-fit: cover;" 
                         alt="{{ $menu->nama }}"
                         onerror="this.onerror=null; this.src='https://via.placeholder.com/400?text=No+Image';">
                </div>

                {{-- KOLOM KANAN: INFO PRODUK --}}
                <div class="col-md-7">
                    <div class="card-body p-4 p-lg-5 d-flex flex-column h-100">
                        
                        {{-- Header: Kategori & Rating --}}
                        <div class="mb-3 d-flex justify-content-between align-items-start">
                            <span class="badge bg-primary-dark text-white rounded-pill px-3 py-2">
                                {{ $menu->type->type_name ?? 'Umum' }}
                            </span>
                            
                            {{-- Rating Rata-rata --}}
                            <div class="d-flex align-items-center bg-light px-3 py-1 rounded-pill">
                                <i class="fas fa-star text-warning me-2"></i>
                                <span class="fw-bold">{{ number_format($menu->reviews_avg_rating ?? 0, 1) }}</span>
                                <span class="text-muted small ms-1">/ 5.0</span>
                            </div>
                        </div>

                        {{-- Nama Menu --}}
                        <h2 class="fw-bold text-dark mb-2">{{ $menu->nama }}</h2>
                        
                        {{-- Harga --}}
                        <h3 class="fw-bold text-primary-dark mb-4">
                            Rp {{ number_format($menu->price, 0, ',', '.') }}
                        </h3>

                        {{-- Deskripsi --}}
                        <div class="mb-4">
                            <h6 class="fw-bold text-muted text-uppercase small ls-1">Deskripsi</h6>
                            <p class="text-secondary leading-relaxed">
                                {{ $menu->deskripsi }}
                            </p>
                        </div>

                        <hr class="my-4 opacity-10">

                        {{-- ACTION BUTTONS --}}
                        <div class="d-flex gap-3 mt-auto">
                            
                            {{-- Tombol Beli --}}
                            <form action="{{ route('cart.add', ['id' => $menu->id]) }}" method="POST" class="flex-grow-1">
                                @csrf
                                <button type="submit" class="btn btn-primary-dark w-100 py-3 fw-bold rounded-pill shadow-sm transition-all hover-scale">
                                    <i class="fas fa-cart-plus me-2"></i> Tambah ke Keranjang
                                </button>
                            </form>

                            {{-- Tombol Favorit --}}
                            <form action="{{ route('menu.favorite', $menu->id) }}" method="POST">
                                @csrf
                                <button type="submit" 
                                        class="btn btn-outline-secondary py-3 px-4 rounded-pill shadow-sm" 
                                        title="{{ $menu->is_favorited ? 'Hapus dari Favorit' : 'Simpan ke Favorit' }}">
                                    <i class="{{ $menu->is_favorited ? 'fas text-danger' : 'far' }} fa-heart fs-5"></i>
                                </button>
                            </form>

                        </div>

                    </div>
                </div>

            </div>
        </div>

        {{-- SECTION REVIEW & KOMENTAR --}}
        <div class="row">
            <div class="col-md-8 mx-auto">
                
                {{-- FORM INPUT REVIEW --}}
                <div class="card shadow-sm border-0 mb-5">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold"><i class="fas fa-star text-warning me-2"></i>Berikan Ulasan Anda</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('menu.review.store', $menu->id) }}" method="POST">
                            @csrf
                            
                            {{-- Input Rating (Bintang) --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">Rating</label>
                                <div class="rating-css">
                                    <div class="star-icon">
                                        {{-- Urutan Input DIBALIK (5 ke 1) untuk CSS Flex Reverse --}}
                                        <input type="radio" value="5" name="rating" id="rating5" required>
                                        <label for="rating5" class="fa fa-star"></label>
                                        
                                        <input type="radio" value="4" name="rating" id="rating4">
                                        <label for="rating4" class="fa fa-star"></label>
                                        
                                        <input type="radio" value="3" name="rating" id="rating3">
                                        <label for="rating3" class="fa fa-star"></label>
                                        
                                        <input type="radio" value="2" name="rating" id="rating2">
                                        <label for="rating2" class="fa fa-star"></label>
                                        
                                        <input type="radio" value="1" name="rating" id="rating1">
                                        <label for="rating1" class="fa fa-star"></label>
                                    </div>
                                </div>
                            </div>

                            {{-- Input Komentar --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">Komentar</label>
                                <textarea name="comment" class="form-control" rows="3" placeholder="Ceritakan pengalamanmu menikmati menu ini..." required></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary-dark w-100 fw-bold">Kirim Ulasan</button>
                        </form>
                    </div>
                </div>

                {{-- DAFTAR REVIEW --}}
                <h4 class="fw-bold mb-4">Ulasan Pelanggan ({{ $menu->reviews->count() }})</h4>

                @forelse($menu->reviews->sortByDesc('created_at') as $review)
                    <div class="card border-0 shadow-sm mb-3">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                                {{-- Avatar User (Gunakan Placeholder jika kosong) --}}
                                <img src="{{ $review->user && $review->user->profile_picture ? asset('uploads/profile/'.$review->user->profile_picture) : 'https://ui-avatars.com/api/?name='.($review->user->nama ?? 'User') }}" 
                                     class="rounded-circle me-3" style="width: 40px; height: 40px; object-fit: cover;">
                                
                                <div>
                                    <h6 class="fw-bold mb-0">{{ $review->user->nama ?? 'Pengguna' }}</h6>
                                    <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                                </div>
                            </div>

                            {{-- Bintang Review --}}
                            <div class="mb-2">
                                @foreach(range(1, 5) as $i)
                                    <i class="fa-star small {{ $i <= $review->rating ? 'fas text-warning' : 'far text-muted opacity-25' }}"></i>
                                @endforeach
                            </div>

                            <p class="mb-0 text-secondary">{{ $review->comment }}</p>
                        </div>
                    </div>
                @empty
                    <div class="alert alert-light text-center border-0 shadow-sm py-4">
                        <i class="far fa-comment-dots fa-3x text-muted mb-3 opacity-50"></i>
                        <p class="text-muted mb-0">Belum ada ulasan. Jadilah yang pertama memberikan ulasan!</p>
                    </div>
                @endforelse

            </div>
        </div>
    </div>
</section>

{{-- STYLE CSS KHUSUS HALAMAN INI --}}
<style>
    /* Tema Warna */
    .bg-primary-dark { background-color: #2c3e50 !important; }
    .text-primary-dark { color: #2c3e50 !important; }
    
    /* Animasi Hover Tombol */
    .hover-scale:hover { transform: translateY(-2px); }
    .transition-all { transition: all 0.3s ease; }

    /* CSS Rating Input (Bintang Interaktif) */
    .rating-css div {
        color: #ffe400;
        font-size: 20px;
        font-family: sans-serif;
        font-weight: 800;
        text-align: left;
        text-transform: uppercase;
        padding: 10px 0;
    }
    .rating-css input {
        display: none; /* Sembunyikan radio button asli */
    }
    .rating-css input + label {
        font-size: 30px;
        text-shadow: 1px 1px 0 #ffe400;
        cursor: pointer;
        color: #ccc; /* Warna default mati */
    }
    .rating-css input:checked + label ~ label {
        color: #ccc;
    }
    /* Saat dipilih atau di-hover, warnanya kuning */
    .rating-css input:checked + label,
    .rating-css input:not(:checked) + label:hover,
    .rating-css input:not(:checked) + label:hover ~ label {
        color: #ffe400;
    }
    
    .star-icon {
        display: flex;
        flex-direction: row-reverse; /* Balik urutan agar seleksi CSS 'next sibling' (~) bekerja */
        justify-content: flex-end;
        gap: 10px;
    }
</style>
@endsection