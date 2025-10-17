@extends('layouts.app')

@section('title', 'Menu')

@push('styles')
    <link href="{{ asset('css/menu.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="container-banner">
    <div class="overlay"></div>
    <h1 class="judul">Menu</h1>
</div>

<div class="container my-5">
    <div class="row">
        {{-- Sidebar Kategori --}}
        <div class="col-md-3">
            <h4 class="kategori">KATEGORI PRODUK</h4>
            <ul class="nav flex-column nav-pills">
                <li class="nav-item mb-2">
                    <a class="nav-link d-flex justify-content-between align-items-center" href="#">
                        All <span>({{ $totalAllMenus }})</span>
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link d-flex justify-content-between align-items-center" href="#">
                        Coffee <span>({{ $menuCounts['Kopi'] ?? 0 }})</span>
                    </a>
                </li>
                {{-- Tambahkan kategori lainnya di sini --}}
            </ul>
        </div>

        {{-- Grid Menu --}}
        <div class="col-md-9">
            <div class="row row-cols-1 row-cols-md-3 g-4">
                @forelse ($menus as $menu)
                    <div class="col">
                        <div class="card h-100">
                            <div class="image-wrapper">
                                <img src="{{ asset('asset/' . $menu['url_foto']) }}" class="card-img-top" alt="{{ $menu['nama'] }}">
                                <div class="btn-overlay">
                                    <a class="btn-icon-round" href="{{ url('/menu/' . $menu['id']) }}" title="Lihat Detail">
                                        <i class="fas fa-search"></i>
                                    </a>
                                    <button class="btn-icon-round add-to-cart-btn" title="Tambah ke Keranjang">
                                        <i class="fas fa-shopping-cart"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body text-center">
                                <h5 class="card-title">{{ $menu['nama'] }}</h5>
                                <p class="card-text">Rp {{ number_format($menu['price'], 0, ',', '.') }}</p>
                                <span class="badge {{ $menu['status_name'] == 'Tersedia' ? 'bg-success' : 'bg-danger' }}">
                                    {{ $menu['status_name'] }}
                                </span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-center">Menu tidak tersedia.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection