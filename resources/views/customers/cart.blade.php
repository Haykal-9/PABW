@extends('customers.layouts.app')

@section('title', 'Keranjang Belanja')

@section('content')

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show container mt-3" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <section class="cart-section py-5">
        <div class="container">
            <h2 class="fw-bold text-primary-dark mb-4"><i class="fas fa-shopping-cart me-2"></i>Keranjang Saya</h2>

            @if(session('cart') && count(session('cart')) > 0)
                <div class="row">

                    <!-- KOLOM KIRI: DAFTAR ITEM -->
                    <div class="col-lg-8">
                        <div class="card shadow-sm border-0 mb-4">
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead class="bg-light">
                                            <tr>
                                                <th scope="col" class="py-3 ps-4">Menu</th>
                                                <th scope="col" class="py-3">Harga</th>
                                                <th scope="col" class="py-3">Jumlah</th>
                                                <th scope="col" class="py-3">Subtotal</th>
                                                <th scope="col" class="py-3">Catatan</th>
                                                <th scope="col" class="py-3 text-end pe-4">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach(session('cart') as $id => $details)
                                                <tr>
                                                    <td class="ps-4">
                                                        <div class="d-flex align-items-center">
                                                            <img src="{{ asset('foto/' . $details['photo']) }}"
                                                                alt="{{ $details['name'] }}" class="rounded me-3"
                                                                style="width: 60px; height: 60px; object-fit: cover;">
                                                            <div>
                                                                <h6 class="mb-0 fw-bold">{{ $details['name'] }}</h6>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>Rp {{ number_format($details['price'], 0, ',', '.') }}</td>
                                                    <td style="width: 150px;">
                                                        <div class="input-group input-group-sm">

                                                            <form action="{{ route('cart.update') }}" method="POST"
                                                                class="d-inline">
                                                                @csrf
                                                                @method('PATCH')
                                                                <input type="hidden" name="id" value="{{ $id }}">
                                                                <input type="hidden" name="quantity"
                                                                    value="{{ $details['quantity'] - 1 }}">
                                                                <button type="submit" class="btn btn-outline-secondary" {{ $details['quantity'] <= 1 ? 'disabled' : '' }}>-</button>
                                                            </form>

                                                            <input type="text" class="form-control text-center bg-white"
                                                                value="{{ $details['quantity'] }}" readonly>

                                                            <form action="{{ route('cart.update') }}" method="POST"
                                                                class="d-inline">
                                                                @csrf
                                                                @method('PATCH')
                                                                <input type="hidden" name="id" value="{{ $id }}">
                                                                <input type="hidden" name="quantity"
                                                                    value="{{ $details['quantity'] + 1 }}">
                                                                <button type="submit" class="btn btn-outline-secondary">+</button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                    <td class="fw-bold text-primary-dark">
                                                        Rp
                                                        {{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }}
                                                    </td>
                                                    <td style="min-width: 150px;">
                                                        <form action="{{ route('cart.update.note') }}" method="POST">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="id" value="{{ $id }}">
                                                            <div class="input-group input-group-sm">
                                                                <input type="text" 
                                                                       name="note" 
                                                                       class="form-control form-control-sm" 
                                                                       placeholder="Tambah catatan..."
                                                                       value="{{ $details['note'] ?? '' }}">
                                                                <button type="submit" class="btn btn-sm btn-outline-secondary" title="Simpan Catatan">
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
                                                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                                                title="Hapus">
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

                        <a href="{{ url('/menu') }}" class="btn btn-outline-dark">
                            <i class="fas fa-arrow-left me-2"></i> Lanjut Belanja
                        </a>
                    </div>

                    <!-- KOLOM KANAN: RINGKASAN BELANJA -->
                    <div class="col-lg-4">
                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-white py-3">
                                <h5 class="mb-0 fw-bold">Ringkasan Pesanan</h5>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Total Item</span>
                                    <span class="fw-bold">{{ count(session('cart')) }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-4">
                                    <span class="text-muted">Total Harga</span>
                                    <span class="fw-bold fs-5 text-primary-dark">Rp
                                        {{ number_format($total, 0, ',', '.') }}</span>
                                </div>
                                <hr>
                                <a href="{{ url('/checkout') }}" class="btn btn-primary-dark w-100 py-2 fw-bold">
                                    Checkout Sekarang <i class="fas fa-arrow-right ms-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            @else
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-shopping-basket fa-5x text-muted opacity-25"></i>
                    </div>
                    <h3 class="text-muted fw-bold">Keranjang Anda Kosong</h3>
                    <p class="text-muted mb-4">Sepertinya Anda belum memesan menu apapun.</p>
                    <a href="{{ url('/menu') }}" class="btn btn-primary-dark px-4 py-2 rounded-pill">
                        Mulai Pesan Menu
                    </a>
                </div>
            @endif
        </div>
    </section>

@endsection