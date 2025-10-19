@extends('layouts.app')

@section('title', 'Riwayat Pesanan')

@push('styles')
    <link href="{{ asset('css/riwayat.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="riwayat-header">
        <i class='bx bx-receipt'></i> Riwayat Pesanan
    </div>
    <div class="container my-5">
        <a href="{{ url('/profil') }}" class="btn btn-outline-secondary mb-4">
            <i class='bx bx-user'></i> Kembali ke Profil
        </a>

        @forelse ($orders as $order)
            <div class="card riwayat-item mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title riwayat-title">#{{ $order->id }} -
                                {{ date('d M Y H:i', strtotime($order->order_date)) }}</h5>
                            <small class="text-muted">{{ $order->order_type_name }} | {{ $order->payment_method_name }}</small>
                        </div>
                        <div class="text-end">
                            <span class="riwayat-total">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span><br>
                            <span class="badge bg-success riwayat-status">{{ $order->order_status_name }}</span>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center">Belum ada riwayat pesanan.</p>
        @endforelse
    </div>
@endsection