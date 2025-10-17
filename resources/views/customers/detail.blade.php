@extends('layouts.app')

@section('title', $product->nama)

@push('styles')
    <link href="{{ asset('css/detail.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="container my-5">
        <div class="row">
            <div class="col-md-5">
                <img src="{{ asset('asset/' . $product->url_foto) }}" class="img-fluid rounded shadow"
                    alt="{{ $product->nama }}">
            </div>
            <div class="col-md-7">
                <h2>{{ $product->nama }}</h2>
                <p class="text-muted">{{ $product->type_name }}</p>
                <h3>Rp {{ number_format($product->price, 0, ',', '.') }}</h3>
                <p>{{ $product->deskripsi }}</p>
                <button class="btn btn-primary btn-lg add-to-cart-btn">
                    <i class="fas fa-shopping-cart"></i> Tambah ke Keranjang
                </button>
            </div>
        </div>

        <hr class="my-5">

        {{-- Bagian Komentar --}}
        <div class="row">
            <div class="col-12">
                <h3>Ulasan Produk</h3>
                @forelse ($reviews as $review)
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                                <img src="{{ asset('asset/user_picture/' . $review['profile_picture']) }}"
                                    class="rounded-circle" width="40" height="40" alt="Avatar">
                                <div class="ms-3">
                                    <h5 class="card-title mb-0">{{ $review['username'] }}</h5>
                                    <div class="text-warning">
                                        @for ($i = 0; $i < $review['rating']; $i++) <i class="fas fa-star"></i> @endfor
                                    </div>
                                </div>
                            </div>
                            <p class="card-text">{{ $review['comment'] }}</p>
                            <p class="card-text"><small class="text-muted">{{ $review['created_at'] }}</small></p>
                        </div>
                    </div>
                @empty
                    <p>Belum ada ulasan untuk produk ini.</p>
                @endforelse
            </div>
        </div>

        <hr class="my-5">

        {{-- Bagian Rekomendasi --}}
        <div class="row">
            <div class="col-12">
                <h3>Rekomendasi Lainnya</h3>
                <div class="row row-cols-1 row-cols-md-4 g-4">
                    @foreach ($recommendations as $item)
                        <div class="col">
                            <div class="card h-100">
                                <img src="{{ asset('asset/' . $item['url_foto']) }}" class="card-img-top"
                                    alt="{{ $item['nama'] }}">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $item['nama'] }}</h5>
                                    <a href="{{ url('/menu/' . $item['id']) }}"
                                        class="btn btn-outline-primary stretched-link">Lihat</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection