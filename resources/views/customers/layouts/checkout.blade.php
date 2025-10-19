@extends('customers.layouts.app')

@section('title', 'Checkout')

@push('styles')
    <style>
        .checkout-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 32px;
            background: #222b3a;
            border-radius: 12px;
            color: #fff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .checkout-preview {
            background: rgba(255, 255, 255, 0.1);
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .checkout-preview-item {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .checkout-totals {
            margin-top: 20px;
            padding-top: 15px;
            border-top: 2px solid rgba(255, 255, 255, 0.2);
        }

        #qrisImageContainer {
            display: none;
            text-align: center;
            background: #ffffff;
            padding: 20px;
            border-radius: 10px;
            margin: 15px 0;
        }

        #qrisImageContainer img {
            max-width: 250px;
            margin: 10px auto;
            border-radius: 10px;
        }

        .qris-text {
            color: #333;
        }
    </style>
@endpush

@section('content')
    <div class="checkout-container">
        <form class="checkout-form" action="#" method="post">
            @csrf
            <h2 class="text-center mb-4">Pembayaran</h2>

            <div id="checkoutPreview" class="checkout-preview">
                {{-- Data dummy --}}
                <div class="checkout-preview-item">
                    <div>Kopi Tubruk Robusta x 2</div>
                    <div>Rp 30.000</div>
                </div>
                <div class="checkout-totals">
                    <div class="checkout-preview-item">
                        <div>Subtotal</div>
                        <div>Rp 30.000</div>
                    </div>
                    <div class="checkout-preview-item">
                        <div>Pajak (10%)</div>
                        <div>Rp 3.000</div>
                    </div>
                    <div class="checkout-preview-item" style="border-bottom: none;">
                        <div><strong>Total</strong></div>
                        <div><strong>Rp 33.000</strong></div>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="customer_name" class="form-label">Nama Customer:</label>
                <input type="text" name="customer_name" class="form-control" id="customer_name" required
                    placeholder="Masukkan nama Anda">
            </div>

            <div class="mb-3">
                <label class="form-label">Jenis Pesanan:</label>
                <div>
                    @foreach ($order_types as $type)
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="jenis_order" id="order_type_{{ $loop->index }}"
                                value="{{ $type['type_name'] }}" {{ $loop->first ? 'checked' : '' }}>
                            <label class="form-check-label" for="order_type_{{ $loop->index }}">{{ $type['type_name'] }}</label>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="mb-3">
                <label for="paymentMethodSelect" class="form-label">Metode Pembayaran:</label>
                <select name="payment_method" id="paymentMethodSelect" class="form-select" required>
                    @foreach ($payment_methods as $method)
                        <option value="{{ $method['method_name'] }}">{{ $method['method_name'] }}</option>
                    @endforeach
                </select>
            </div>

            <div id="qrisImageContainer">
                <img id="qrisImg" src="{{ asset('asset/pembayaran/qr.jpg') }}" alt="QRIS" />
                <div class="qris-text">Scan QRIS untuk pembayaran</div>
            </div>

            <button type="submit" class="btn btn-primary btn-lg w-100">Bayar & Cetak Struk</button>
            <a href="{{ url('/menu') }}" class="btn btn-outline-secondary w-100 mt-2">Kembali ke Menu</a>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('paymentMethodSelect').addEventListener('change', function () {
            document.getElementById('qrisImageContainer').style.display = this.value === 'QRIS' ? 'block' : 'none';
        });
    </script>
@endpush