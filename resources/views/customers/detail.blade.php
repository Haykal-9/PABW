@extends('customers.layouts.app')

{{-- Pastikan variabel $menu sudah ada dan memiliki properti name --}}
@section('title', 'Detail Menu - ' . $menu->name ?? 'Menu Item')

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
                {{-- Gunakan $menu->image_url atau $menu->photo_path --}}
                <img src="{{ asset($menu->image_url ?? 'assets/img/placeholder.jpg') }}" 
                     class="img-fluid rounded-3 shadow-lg w-100" 
                     style="max-height: 550px; object-fit: cover;" 
                     alt="Foto {{ $menu->name ?? 'Menu TapalKuda' }}">
            </div>
            
            {{-- KOLOM KANAN: DETAIL PRODUK --}}
            <div class="col-md-6 pt-4 pt-md-0" data-aos="fade-left">
                
                <span class="badge bg-primary-dark text-white text-uppercase mb-2">{{ $menu->category ?? 'Kopi' }}</span>
                <h1 class="display-4 fw-bold text-primary-dark mb-3">{{ $menu->name ?? 'Menu Tidak Ditemukan' }}</h1>
                
                {{-- Harga --}}
                <h2 class="display-5 fw-bolder mb-4">Rp {{ number_format($menu->price ?? 0, 0, ',', '.') }}</h2>
                
                <p class="lead text-muted">{{ $menu->description_long ?? 'Deskripsi detail belum tersedia untuk menu ini.' }}</p>

                <hr class="my-4">

                <h5 class="fw-bold text-primary-dark">Detail Produk:</h5>
                <ul class="list-unstyled detail-list">
                    {{-- Detail Spesifik Kopi --}}
                    @if(isset($menu->notes))
                    <li class="mb-2"><i class="fas fa-seedling text-primary-dark me-2"></i> Flavor Notes: **{{ $menu->notes }}**</li>
                    @endif
                    @if(isset($menu->origin))
                    <li class="mb-2"><i class="fas fa-map-pin text-primary-dark me-2"></i> Origin: **{{ $menu->origin }}**</li>
                    @endif
                    @if(isset($menu->serving_type))
                    <li class="mb-2"><i class="fas fa-temperature-low text-primary-dark me-2"></i> Penyajian: **{{ $menu->serving_type }}**</li>
                    @endif
                </ul>

                {{-- CTA Utama --}}
                <a href="{{ url('/order/' . $menu->slug ?? '') }}" class="btn btn-primary-dark btn-lg mt-3 px-5 py-3 shadow">
                    Pesan Sekarang <i class="fas fa-shopping-cart ms-2"></i>
                </a>
            </div>
        </div>
    </div>
</section>

@endsection