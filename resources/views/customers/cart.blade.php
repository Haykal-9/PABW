@extends('customers.layouts.app')

@section('title', 'Shopping Cart')

@section('content')
    <div class="min-vh-100 py-5"
        style="background: radial-gradient(circle at top right, #1f1a18, #0f0c0b); padding-top: 100px !important;">
        <div class="container">
            {{-- Header --}}
            <div class="mb-5 border-bottom border-white border-opacity-10 pb-3">
                <h1 class="font-serif text-light display-6 fw-bold mb-1">My Cart</h1>
                <p class="text-dim small mb-0">Review your selected items before checkout</p>
            </div>

            @if(session('success'))
                <div class="alert alert-success bg-success bg-opacity-10 text-success border-0 mb-4 rounded-0">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('cart') && count(session('cart')) > 0)
                <div class="row g-4">

                    <!-- LEFT COLUMN: ITEMS LIST -->
                    <div class="col-lg-8">
                        <div class="glass-card overflow-hidden mb-4">
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-borderless align-middle mb-0 custom-glass-table">
                                        <thead style="background: rgba(212, 175, 55, 0.1);">
                                            <tr class="text-gold x-small fw-bold text-uppercase ls-1">
                                                <th scope="col" class="py-3 ps-4">Menu</th>
                                                <th scope="col" class="py-3 text-center">Price</th>
                                                <th scope="col" class="py-3 text-center">Qty</th>
                                                <th scope="col" class="py-3 text-center">Subtotal</th>
                                                <th scope="col" class="py-3 ps-4" style="width: 200px;">Note</th>
                                                <th scope="col" class="py-3 text-end pe-4">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach(session('cart') as $id => $details)
                                                <tr class="border-bottom border-white border-opacity-5 hover-bg-glass">
                                                    <td class="ps-4 py-4">
                                                        <div class="d-flex align-items-center">
                                                            <div class="position-relative flex-shrink-0">
                                                                <img src="{{ asset('foto/' . $details['photo']) }}"
                                                                    alt="{{ $details['name'] }}"
                                                                    class="rounded shadow-sm object-fit-cover"
                                                                    style="width: 60px; height: 60px;">
                                                            </div>
                                                            <div class="ms-3">
                                                                <h6 class="mb-0 fw-bold text-light text-nowrap">
                                                                    {{ $details['name'] }}</h6>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="text-center text-dim">Rp
                                                        {{ number_format($details['price'], 0, ',', '.') }}</td>
                                                    <td style="width: 140px;">
                                                        <div
                                                            class="input-group input-group-sm bg-transparent border border-white border-opacity-10 rounded">
                                                            <form action="{{ route('cart.update') }}" method="POST"
                                                                class="d-contents">
                                                                @csrf
                                                                @method('PATCH')
                                                                <input type="hidden" name="id" value="{{ $id }}">
                                                                <input type="hidden" name="quantity"
                                                                    value="{{ $details['quantity'] - 1 }}">
                                                                <button type="submit"
                                                                    class="btn btn-link text-dim text-decoration-none px-2 py-1 hover-text-white"
                                                                    {{ $details['quantity'] <= 1 ? 'disabled' : '' }}>
                                                                    <i class="fas fa-minus x-small"></i>
                                                                </button>
                                                            </form>

                                                            <input type="text"
                                                                class="form-control form-control-sm bg-transparent border-0 text-center text-light p-0"
                                                                value="{{ $details['quantity'] }}" readonly style="height: 30px;">

                                                            <form action="{{ route('cart.update') }}" method="POST"
                                                                class="d-contents">
                                                                @csrf
                                                                @method('PATCH')
                                                                <input type="hidden" name="id" value="{{ $id }}">
                                                                <input type="hidden" name="quantity"
                                                                    value="{{ $details['quantity'] + 1 }}">
                                                                <button type="submit"
                                                                    class="btn btn-link text-dim text-decoration-none px-2 py-1 hover-text-white">
                                                                    <i class="fas fa-plus x-small"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                    <td class="text-center fw-bold text-light">
                                                        Rp
                                                        {{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }}
                                                    </td>
                                                    <td class="ps-4">
                                                        <form action="{{ route('cart.update.note') }}" method="POST">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="id" value="{{ $id }}">
                                                            <div class="input-group input-group-sm">
                                                                <input type="text" name="note"
                                                                    class="form-control form-control-sm bg-transparent border-secondary text-light placeholder-dim"
                                                                    placeholder="Add note..." value="{{ $details['note'] ?? '' }}"
                                                                    style="border-color: rgba(255,255,255,0.1);">
                                                                <button type="submit" class="btn btn-sm btn-outline-glass"
                                                                    title="Save Note">
                                                                    <i class="fas fa-check"></i>
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </td>
                                                    <td class="text-end pe-4">
                                                        <form action="{{ route('cart.remove') }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <input type="hidden" name="id" value="{{ $id }}">
                                                            <button type="submit"
                                                                class="btn btn-sm btn-link text-danger opacity-75 hover-opacity-100 p-0"
                                                                title="Remove Item">
                                                                <i class="fas fa-trash-alt"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <a href="{{ url('/menu') }}" class="text-decoration-none text-dim hover-text-gold transition-all">
                            <i class="fas fa-arrow-left me-2"></i> Continue Shopping
                        </a>
                    </div>

                    <!-- RIGHT COLUMN: SUMMARY -->
                    <div class="col-lg-4">
                        <div class="glass-card position-sticky" style="top: 100px;">
                            <div class="card-header bg-transparent py-4 border-bottom border-white border-opacity-10">
                                <h5 class="mb-0 fw-bold text-light font-serif">Order Summary</h5>
                            </div>
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between mb-3 text-dim small">
                                    <span>Total Items</span>
                                    <span>{{ count(session('cart')) }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-4 align-items-center">
                                    <span class="text-light">Total Amount</span>
                                    <span class="fw-bold fs-4 text-gold font-serif">Rp
                                        {{ number_format($total, 0, ',', '.') }}</span>
                                </div>
                                <hr class="border-white border-opacity-10 mb-4">
                                <a href="{{ url('/checkout') }}"
                                    class="btn btn-gold w-100 py-3 fw-bold text-uppercase ls-1 shimmer-effect">
                                    Checkout Now <i class="fas fa-arrow-right ms-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            @else
                <div class="glass-card p-5 text-center my-5 mx-auto" style="max-width: 600px;">
                    <div class="mb-4">
                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle border border-gold border-opacity-25 p-4"
                            style="width: 100px; height: 100px; background: rgba(212, 175, 55, 0.05);">
                            <i class="fas fa-shopping-basket fa-3x text-gold opacity-75"></i>
                        </div>
                    </div>
                    <h3 class="text-light fw-bold font-serif mb-2">Your Cart is Empty</h3>
                    <p class="text-dim mb-4">Looks like you haven't added anything to your cart yet.</p>
                    <a href="{{ url('/menu') }}" class="btn btn-outline-glass px-4 py-2 rounded-pill">
                        Start Ordering
                    </a>
                </div>
            @endif
        </div>
    </div>

    <style>
        .glass-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .custom-glass-table {
            background: transparent !important;
        }

        .custom-glass-table th,
        .custom-glass-table td {
            background: transparent !important;
            color: #fff !important;
        }

        .custom-glass-table .text-dim {
            color: rgba(255, 255, 255, 0.5) !important;
        }

        .hover-bg-glass:hover td {
            background: rgba(255, 255, 255, 0.02) !important;
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

        .w-20 {
            width: 20px;
            text-align: center;
        }

        .btn-outline-glass {
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: rgba(255, 255, 255, 0.7);
            background: transparent;
        }

        .btn-outline-glass:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            border-color: rgba(255, 255, 255, 0.4);
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

        /* Shimmer Effect */
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

        .hover-text-gold:hover {
            color: var(--accent-gold) !important;
        }

        .hover-text-white:hover {
            color: #fff !important;
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.3);
        }

        .placeholder-dim::placeholder {
            color: rgba(255, 255, 255, 0.2);
        }
    </style>
@endsection