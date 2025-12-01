@extends('customers.layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-8">
            <h4 class="mb-3">Detail Pengiriman</h4>
            
            <form action="{{ route('checkout.store') }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label class="form-label">Nama Pemesan</label>
                    <input type="text" class="form-control" value="{{ $user->nama }}" readonly>
                </div>
                <hr class="my-4">

                <h4 class="mb-3">Metode Pemesanan</h4>

                <div class="my-3">
                    <div class="form-check">
                        <input id="dinein" name="order_type_id" type="radio" class="form-check-input" value="1" checked required>
                        <label class="form-check-label" for="dinein">Makan di Tempat (Dine In)</label>
                    </div>
                    <div class="form-check">
                        <input id="takeaway" name="order_type_id" type="radio" class="form-check-input" value="2" required>
                        <label class="form-check-label" for="takeaway">Bawa Pulang (Take Away)</label>
                    </div>
                </div>

                <h4 class="mb-3">Metode Pembayaran</h4>

                <div class="my-3">
                    <div class="form-check">
                        <input id="cash" name="payment_method_id" type="radio" class="form-check-input" value="1" checked required>
                        <label class="form-check-label" for="cash">Tunai (Cash)</label>
                    </div>
                    <div class="form-check">
                        <input id="qris" name="payment_method_id" type="radio" class="form-check-input" value="3" required>
                        <label class="form-check-label" for="qris">QRIS / E-Wallet</label>
                    </div>
                    <div class="form-check">
                        <input id="transfer" name="payment_method_id" type="radio" class="form-check-input" value="2" required>
                        <label class="form-check-label" for="transfer">Transfer Bank</label>
                    </div>
                </div>

                <hr class="my-4">

                <button class="btn btn-primary-dark w-100 btn-lg" type="submit">Buat Pesanan</button>
            </form>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Ringkasan Pesanan</h5>
                </div>
                <ul class="list-group list-group-flush">
                    @foreach($cart as $details)
                    <li class="list-group-item d-flex justify-content-between lh-sm">
                        <div>
                            <h6 class="my-0">{{ $details['name'] }}</h6>
                            <small class="text-muted">x {{ $details['quantity'] }}</small>
                        </div>
                        <span class="text-muted">Rp {{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }}</span>
                    </li>
                    @endforeach
                    <li class="list-group-item d-flex justify-content-between bg-light">
                        <span class="fw-bold">Total (IDR)</span>
                        <strong class="text-primary-dark">Rp {{ number_format($total, 0, ',', '.') }}</strong>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection