@extends('customers.layouts.app')

@section('title', 'Keranjang Saya')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Keranjang Belanja</h1>

    @if(count($cartItems) === 0)
        <div class="alert alert-info">Keranjang kosong.</div>
    @else
        <div class="row">
            <div class="col-lg-8">
                <div class="list-group">
                    @foreach($cartItems as $item)
                        <div class="list-group-item d-flex align-items-center">
                            <img src="{{ asset($item->image_url) }}" alt="{{ $item->name }}" width="80" class="me-3 rounded">
                            <div class="flex-grow-1">
                                <h5 class="mb-1">{{ $item->name }}</h5>
                                <small class="text-muted">Rp {{ number_format($item->price,0,',','.') }} x {{ $item->qty }}</small>
                            </div>
                            <div class="fw-bold">Rp {{ number_format($item->price * $item->qty,0,',','.') }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5>Ringkasan</h5>
                        <p class="mb-1">Subtotal: <strong>Rp {{ number_format($subtotal,0,',','.') }}</strong></p>
                        <a href="{{ url('/checkout') }}" class="btn btn-primary-dark w-100">Lanjut ke Pembayaran</a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

@endsection
