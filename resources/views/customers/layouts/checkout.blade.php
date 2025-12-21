@extends('customers.layouts.app')

@section('content')
    <div class="min-vh-100 py-5"
        style="background: radial-gradient(circle at top right, #1f1a18, #0f0c0b); padding-top: 100px !important;">
        <div class="container">

            {{-- Header --}}
            <div class="mb-5 border-bottom border-white border-opacity-10 pb-3">
                <h1 class="font-serif text-light display-6 fw-bold mb-1">Checkout</h1>
                <p class="text-dim small mb-0">Finalize your order details</p>
            </div>

            <form action="{{ route('checkout.store') }}" method="POST">
                @csrf

                <div class="row g-5">
                    {{-- LEFT COLUMN: FORM --}}
                    <div class="col-lg-8">

                        {{-- Customer Details --}}
                        <div class="glass-card p-4 p-md-5 mb-4">
                            <h5 class="text-gold font-serif mb-4"><i class="fas fa-user-circle me-2"></i>Customer Details
                            </h5>
                            <div class="mb-3">
                                <label class="form-label text-dim small text-uppercase ls-1 fw-bold">Name</label>
                                <input type="text" class="form-control form-control-glass" value="{{ $user->nama }}"
                                    readonly>
                            </div>
                        </div>

                        {{-- Order Method --}}
                        <div class="glass-card p-4 p-md-5 mb-4">
                            <h5 class="text-gold font-serif mb-4"><i class="fas fa-utensils me-2"></i>Order Method</h5>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="custom-radio-card h-100">
                                        <input type="radio" name="order_type_id" value="1" checked required>
                                        <div class="card-content">
                                            <i class="fas fa-chair mb-3 fs-3"></i>
                                            <h6>Dine In</h6>
                                            <span class="small opacity-50">Enjoy your meal at our place</span>
                                        </div>
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <label class="custom-radio-card h-100">
                                        <input type="radio" name="order_type_id" value="2" required>
                                        <div class="card-content">
                                            <i class="fas fa-walking mb-3 fs-3"></i>
                                            <h6>Take Away</h6>
                                            <span class="small opacity-50">Pack it up and go</span>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>

                        {{-- Payment Method --}}
                        <div class="glass-card p-4 p-md-5 mb-4">
                            <h5 class="text-gold font-serif mb-4"><i class="fas fa-wallet me-2"></i>Payment Method</h5>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="custom-radio-card h-100">
                                        <input type="radio" name="payment_method_id" value="1" checked required>
                                        <div class="card-content">
                                            <i class="fas fa-money-bill-wave mb-3 fs-3"></i>
                                            <h6>Cash</h6>
                                        </div>
                                    </label>
                                </div>
                                <div class="col-md-4">
                                    <label class="custom-radio-card h-100">
                                        <input type="radio" name="payment_method_id" value="3" required>
                                        <div class="card-content">
                                            <i class="fas fa-qrcode mb-3 fs-3"></i>
                                            <h6>QRIS / E-Wallet</h6>
                                        </div>
                                    </label>
                                </div>
                                <div class="col-md-4">
                                    <label class="custom-radio-card h-100">
                                        <input type="radio" name="payment_method_id" value="2" required>
                                        <div class="card-content">
                                            <i class="fas fa-university mb-3 fs-3"></i>
                                            <h6>Bank Transfer</h6>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>

                    </div>

                    {{-- RIGHT COLUMN: SUMMARY --}}
                    <div class="col-lg-4">
                        <div class="glass-card position-sticky" style="top: 100px;">
                            <div class="card-header bg-transparent py-4 border-bottom border-white border-opacity-10">
                                <h5 class="mb-0 fw-bold text-light font-serif">Order Summary</h5>
                            </div>
                            <div class="card-body p-0">
                                <div class="list-group list-group-flush custom-list-group">
                                    @foreach($cart as $details)
                                        <div
                                            class="list-group-item bg-transparent border-bottom border-white border-opacity-5 py-3 px-4">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <h6 class="text-light mb-1">{{ $details['name'] }}</h6>
                                                    <small class="text-dim">x {{ $details['quantity'] }}</small>
                                                </div>
                                                <span class="text-light">Rp
                                                    {{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="p-4 bg-white bg-opacity-5">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-light x-small fw-bold text-uppercase ls-1">Total Amount</span>
                                        <span class="fw-bold fs-4 text-gold font-serif">Rp
                                            {{ number_format($total, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                                <div class="p-4 pt-0">
                                    <hr class="border-white border-opacity-10 mb-4 mt-0">
                                    <button type="submit"
                                        class="btn btn-gold w-100 py-3 fw-bold text-uppercase ls-1 shimmer-effect">
                                        Place Order <i class="fas fa-check-circle ms-2"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <style>
        .glass-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
        }

        .text-dim {
            color: rgba(255, 255, 255, 0.5);
        }

        .x-small {
            font-size: 0.75rem;
        }

        .ls-1 {
            letter-spacing: 1px;
        }

        .form-control-glass {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #fff;
        }

        .form-control-glass:focus {
            background: rgba(255, 255, 255, 0.1);
            border-color: var(--accent-gold);
            color: #fff;
            box-shadow: none;
        }

        /* Custom Radio Cards */
        .custom-radio-card {
            display: block;
            cursor: pointer;
            position: relative;
        }

        .custom-radio-card input {
            position: absolute;
            opacity: 0;
        }

        .custom-radio-card .card-content {
            padding: 1.5rem;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            text-align: center;
            transition: all 0.3s ease;
            color: rgba(255, 255, 255, 0.6);
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .custom-radio-card:hover .card-content {
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
        }

        .custom-radio-card input:checked+.card-content {
            background: linear-gradient(145deg, rgba(212, 175, 55, 0.15) 0%, rgba(0, 0, 0, 0) 100%);
            border-color: var(--accent-gold);
            color: #fff;
            box-shadow: 0 0 15px rgba(212, 175, 55, 0.2);
        }

        .custom-radio-card input:checked+.card-content i {
            color: var(--accent-gold);
        }

        .btn-gold {
            background: linear-gradient(45deg, #d4af37, #f2d06b);
            color: #000;
            border: none;
            position: relative;
            overflow: hidden;
        }

        .btn-gold:hover {
            background: linear-gradient(45deg, #c5a028, #e1c05b);
            color: #000;
            transform: translateY(-1px);
        }

        .shimmer-effect::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 50%;
            height: 100%;
            background: linear-gradient(to right, transparent, rgba(255, 255, 255, 0.3), transparent);
            transform: skewX(-25deg);
            animation: shimmer 3s infinite;
        }

        @keyframes shimmer {
            100% {
                left: 200%;
            }
        }
    </style>
@endsection