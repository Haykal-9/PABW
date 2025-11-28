@extends('customers.layouts.app')

{{-- Gunakan data dari database untuk judul halaman --}}
@section('title', 'Detail Menu - ' . $menu->nama ?? 'Menu Item')

@section('content')

<section class="menu-detail-section py-5 bg-white">
    <div class="container">
        
        <div class="row mb-4">
            {{-- Tombol Kembali --}}
            <div class="col-12" data-aos="fade-down">
                <a href="{{ url('/menu') }}" class="text-primary-dark text-decoration-none fw-bold">
                    <i class="fas fa-chevron-left me-2"></i> Kembali ke Daftar Menu
                </a>
            </div>
        </div>

        <div class="row">
            {{-- KOLOM KIRI: GAMBAR BESAR --}}
            <div class="col-md-6" data-aos="fade-right">
                {{-- Menggunakan kolom url_foto dari database --}}
                <img src="{{ asset('foto/' . $menu->url_foto) }}" 
                     class="img-fluid rounded-3 shadow-lg w-100" 
                     style="max-height: 550px; object-fit: cover;" 
                     alt="Foto {{ $menu->nama }}">
            </div>
            
            {{-- KOLOM KANAN: DETAIL PRODUK --}}
            <div class="col-md-6 pt-4 pt-md-0" data-aos="fade-left">
                
                {{-- Ambil nama kategori dari relasi 'type' --}}
                <span class="badge bg-primary-dark text-white text-uppercase mb-2">{{ $menu->type->type_name ?? 'Kategori Lain' }}</span>
                <h1 class="display-4 fw-bold text-primary-dark mb-1">{{ $menu->nama }}</h1>
                
                {{-- Bagian Rating Ringkas (BARU DENGAN BOOTSTRAP) --}}
                <div class="mb-3 d-flex align-items-center">
                    @if (isset($averageRating) && $averageRating > 0)
                        <span class="text-warning h4 mb-0 me-2">
                            {{-- Bintang Terisi --}}
                            @for ($i = 0; $i < round($averageRating); $i++)
                                <i class="fas fa-star"></i>
                            @endfor
                            {{-- Bintang Kosong --}}
                            @for ($i = 0; $i < 5 - round($averageRating); $i++)
                                <i class="far fa-star text-muted"></i>
                            @endfor
                        </span>
                        <span class="text-muted fw-bold">({{ number_format($averageRating, 1) }} dari 5.0)</span>
                    @else
                         <span class="text-muted">Belum ada ulasan</span>
                    @endif
                </div>
                
                {{-- Harga --}}
                <h2 class="display-5 fw-bolder mb-4">Rp {{ number_format($menu->price, 0, ',', '.') }}</h2>
                
                {{-- Deskripsi Penuh dari kolom 'deskripsi' di database --}}
                <p class="lead text-muted">{{ $menu->deskripsi }}</p>

                <hr class="my-4">

                <h5 class="fw-bold text-primary-dark">Informasi Tambahan:</h5>
                <ul class="list-unstyled detail-list">
                    
                    {{-- Status Ketersediaan (dari relasi 'status') --}}
                    <li class="mb-2">
                        <i class="fas fa-box-open text-primary-dark me-2"></i> Status: 
                        <span class="fw-bold text-{{ $menu->status->status_name == 'tersedia' ? 'success' : 'danger' }}">
                            {{ ucwords($menu->status->status_name ?? 'Tidak Diketahui') }}
                        </span>
                    </li>
                    
                    {{-- Detail lainnya jika ada (contoh dummy yang bisa diisi dari kolom baru di DB) --}}
                    <li class="mb-2"><i class="fas fa-tags text-primary-dark me-2"></i> ID Menu: {{ $menu->id }}</li>
                    
                </ul>

                {{-- CTA Utama --}}
                {{-- Catatan: Anda perlu mengganti URL /order/{id} dengan rute yang sesuai untuk menambahkan ke keranjang --}}
                <a href="{{ url('/cart/add/' . $menu->id) }}" class="btn btn-primary-dark btn-lg mt-3 px-5 py-3 shadow">
                    Pesan Sekarang <i class="fas fa-shopping-cart ms-2"></i>
                </a>
            </div>
        </div>
    </div>
</section>

{{-- SECTION BARU: ULASAN DAN RATING (PURE BOOTSTRAP) --}}
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="fw-bold text-dark mb-4">Ulasan Produk</h2>
        
        {{-- Display Success/Error Messages --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                Harap perbaiki kesalahan berikut sebelum mengirim ulasan.
            </div>
        @endif

        {{-- BAGIAN SUBMIT ULASAN (Hanya untuk pengguna yang sudah login) --}}
        @auth
        <div class="card shadow-sm mb-5 border-0">
            <div class="card-header bg-white border-0">
                <h5 class="mb-0 text-dark">{{ $userReview ? 'Edit Ulasan Anda' : 'Tulis Ulasan Anda' }}</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('review.store') }}" method="POST">
                    @csrf
                    {{-- Kirim ID Menu yang sedang dilihat --}}
                    <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark">Peringkat Anda</label>
                        {{-- Menggunakan Bootstrap Button Group untuk Rating Input --}}
                        <div class="btn-group" role="group" aria-label="Rating">
                            @for ($i = 5; $i >= 1; $i--)
                                <input type="radio" class="btn-check" id="rating-{{ $i }}" name="rating" value="{{ $i }}" autocomplete="off"
                                    {{ old('rating', $userReview->rating ?? 0) == $i ? 'checked' : '' }} required/>
                                
                                <label class="btn btn-outline-warning" for="rating-{{ $i }}" title="{{ $i }} bintang">
                                    <i class="fas fa-star me-1"></i> {{ $i }}
                                </label>
                            @endfor
                        </div>
                        @error('rating') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="comment" class="form-label fw-bold text-dark">Komentar</label>
                        <textarea class="form-control" id="comment" name="comment" rows="3" 
                                  placeholder="Bagaimana pendapat Anda tentang menu ini? (Opsional)">{{ old('comment', $userReview->comment ?? '') }}</textarea>
                        @error('comment') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>
                    
                    <button type="submit" class="btn btn-primary shadow-sm">{{ $userReview ? 'Perbarui Ulasan' : 'Kirim Ulasan' }}</button>
                </form>
            </div>
        </div>
        @else
        <div class="alert alert-info text-center border-0" role="alert">
            <a href="{{ url('/login') }}" class="alert-link fw-bold">Login</a> untuk memberikan ulasan dan rating pada menu ini.
        </div>
        @endauth


        {{-- DAFTAR SEMUA ULASAN --}}
        <h4 class="fw-bold text-dark mb-4 mt-5">Semua Ulasan ({{ $reviews->count() ?? 0 }})</h4>
        
        @forelse ($reviews as $review)
        <div class="card shadow-sm mb-3 border-0">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div>
                        <h6 class="fw-bold mb-0 text-dark">{{ $review->user->nama ?? 'Pengguna Dihapus' }}</h6>
                        <span class="text-warning small">
                            {{-- Menampilkan bintang terisi --}}
                            @for ($i = 0; $i < $review->rating; $i++)
                                <i class="fas fa-star"></i>
                            @endfor
                            {{-- Menampilkan bintang kosong --}}
                            @for ($i = 0; $i < 5 - $review->rating; $i++)
                                <i class="far fa-star text-muted"></i>
                            @endfor
                        </span>
                    </div>
                    <small class="text-muted">{{ $review->created_at->format('d M Y') }}</small>
                </div>
                <p class="card-text text-secondary">{{ $review->comment ?? 'Tidak ada komentar.' }}</p>
            </div>
        </div>
        @empty
            <div class="alert alert-light text-center" role="alert">
                Belum ada ulasan untuk menu ini. Jadilah yang pertama!
            </div>
        @endforelse

    </div>
</section>

@endsection