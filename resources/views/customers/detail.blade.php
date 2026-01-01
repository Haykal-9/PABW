@extends('customers.layouts.app')

@section('title', 'Detail Menu - ' . $menu->nama)

@section('content')

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show fixed-top m-3 shadow" role="alert"
            style="z-index: 1050; width: fit-content; left: 50%; transform: translateX(-50%);">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <section class="detail-section min-vh-100 position-relative d-flex align-items-center py-5"
        style="background: radial-gradient(circle at top right, #1f1a18, #0f0c0b); margin-top: 0px;">

        <div class="container">
            <div class="row g-0 rounded-4 overflow-hidden shadow-2xl"
                style="background: rgba(255, 255, 255, 0.02); border: 1px solid rgba(255, 255, 255, 0.05);">

                {{-- LEFT COLUMN: IMMERSIVE IMAGE --}}
                <div class="col-lg-6 position-relative min-vh-50 d-none d-lg-block">
                    <div class="h-100 w-100 position-absolute top-0 start-0">
                        <img src="{{ asset('foto/' . $menu->url_foto) }}" class="w-100 h-100 object-fit-cover"
                            alt="{{ $menu->nama }}">
                        <div class="position-absolute top-0 start-0 w-100 h-100"
                            style="background: linear-gradient(to right, rgba(0,0,0,0.2), rgba(15,12,11,1));"></div>
                    </div>
                </div>

                {{-- MOBILE IMAGE (Visible only on smaller screens) --}}
                <div class="col-12 d-lg-none position-relative">
                    <img src="{{ asset('foto/' . $menu->url_foto) }}" class="w-100 object-fit-cover" style="height: 300px;"
                        alt="{{ $menu->nama }}">
                    <div class="position-absolute bottom-0 start-0 w-100 h-50"
                        style="background: linear-gradient(to top, #0f0c0b, transparent);"></div>
                </div>

                {{-- RIGHT COLUMN: DETAILS & ACTIONS --}}
                <div class="col-lg-6 d-flex flex-column p-4 p-md-5">

                    {{-- Breadcrumb / Back --}}
                    <div class="mb-4">
                        <a href="{{ route('menu') }}"
                            class="text-gold text-decoration-none small fw-bold text-uppercase ls-1 hover-opacity">
                            <i class="fas fa-arrow-left me-2"></i> Kembali ke Menu
                        </a>
                    </div>

                    {{-- Header Information --}}
                    <div class="mb-4">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <span class="badge bg-gold text-dark rounded-pill fw-bold px-3">
                                {{ $menu->type->type_name ?? 'Umum' }}
                            </span>
                            <div class="d-flex align-items-center text-gold small">
                                <i class="fas fa-star me-1"></i>
                                <span class="fw-bold">{{ number_format($menu->reviews_avg_rating ?? 0, 1) }}</span>
                                <span class="text-dim ms-1">({{ $menu->reviews->count() }} Ulasan)</span>
                            </div>
                        </div>

                        <h1 class="display-4 fw-bold font-serif text-light mb-2">{{ $menu->nama }}</h1>
                        <h2 class="text-gold font-monospace">Rp {{ number_format($menu->price, 0, ',', '.') }}</h2>
                    </div>

                    {{-- Description --}}
                    <div class="mb-5">
                        <p class="text-dim leading-relaxed">
                            {{ $menu->deskripsi }}
                        </p>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="d-flex gap-3 mb-5 border-bottom border-secondary border-opacity-25 pb-5">
                        @auth
                            <form action="{{ route('cart.add', ['id' => $menu->id]) }}" method="POST" class="flex-grow-1">
                                @csrf
                                <button type="submit"
                                    class="btn btn-gold w-100 py-3 rounded-pill fw-bold shadow-lg hover-scale transition-all d-flex align-items-center justify-content-center gap-2">
                                    <i class="fas fa-shopping-bag"></i> Tambah Pesanan
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}"
                                class="btn btn-gold w-100 py-3 rounded-pill fw-bold shadow-lg hover-scale transition-all d-flex align-items-center justify-content-center gap-2 flex-grow-1">
                                <i class="fas fa-sign-in-alt"></i> Login untuk Memesan
                            </a>
                        @endauth

                        @auth
                            <form action="{{ route('menu.favorite', $menu->id) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="btn btn-glass w-100 h-100 px-4 rounded-pill d-flex align-items-center justify-content-center"
                                    title="{{ $menu->is_favorited ? 'Hapus dari Favorit' : 'Simpan ke Favorit' }}">
                                    <i
                                        class="{{ $menu->is_favorited ? 'fas text-danger' : 'far text-light' }} fa-heart fa-lg"></i>
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}"
                                class="btn btn-glass w-100 h-100 px-4 rounded-pill d-flex align-items-center justify-content-center"
                                title="Login untuk Favorit">
                                <i class="far text-light fa-heart fa-lg"></i>
                            </a>
                        @endauth
                    </div>

                    {{-- Reviews Section (Compact) --}}
                    <div>
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="text-light font-serif mb-0">Ulasan Pelanggan</h4>
                            <button class="btn btn-sm btn-outline-glass text-gold" type="button" data-bs-toggle="collapse"
                                data-bs-target="#reviewForm">
                                <i class="fas fa-pen me-2"></i> Tulis Ulasan
                            </button>
                        </div>

                        {{-- Collapsible Review Form --}}
                        <div class="collapse mb-4" id="reviewForm">
                            <div class="glass-card p-4 rounded-3 border-0">
                                @if ($errors->any())
                                    <div class="alert alert-danger bg-danger bg-opacity-10 text-danger border-0 mb-3 rounded-2">
                                        <div class="small">
                                            @foreach ($errors->all() as $error)
                                                <div><i class="fas fa-exclamation-circle me-1"></i> {{ $error }}</div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                                <form action="{{ route('menu.review.store', $menu->id) }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="text-light small fw-bold mb-2">Rating</label>
                                        <div class="rating-css">
                                            <div class="star-icon">
                                                <input type="radio" value="5" name="rating" id="rating5" required><label
                                                    for="rating5" class="fa fa-star"></label>
                                                <input type="radio" value="4" name="rating" id="rating4"><label
                                                    for="rating4" class="fa fa-star"></label>
                                                <input type="radio" value="3" name="rating" id="rating3"><label
                                                    for="rating3" class="fa fa-star"></label>
                                                <input type="radio" value="2" name="rating" id="rating2"><label
                                                    for="rating2" class="fa fa-star"></label>
                                                <input type="radio" value="1" name="rating" id="rating1"><label
                                                    for="rating1" class="fa fa-star"></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <textarea name="comment" class="form-control form-control-glass text-light @error('comment') is-invalid @enderror" rows="3"
                                            placeholder="Bagaimana rasanya?">{{ old('comment') }}</textarea>
                                        @error('comment')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-gold btn-sm w-100 rounded-pill">Kirim</button>
                                </form>
                            </div>
                        </div>

                        {{-- Reviews List (Scrollable) --}}
                        <div class="reviews-scroll pe-2" style="max-height: 400px; overflow-y: auto;">
                            @forelse($menu->reviews->sortByDesc('created_at') as $review)
                                <div class="review-item mb-4 pb-4 border-bottom border-secondary border-opacity-10">
                                    <div class="d-flex align-items-center mb-2">
                                        <img src="{{ $review->user && $review->user->profile_picture ? asset('uploads/profile/' . $review->user->profile_picture) : 'https://ui-avatars.com/api/?name=' . ($review->user->nama ?? 'User') }}"
                                            class="rounded-circle me-3 border border-secondary"
                                            style="width: 40px; height: 40px; object-fit: cover;">
                                        <div>
                                            <h6 class="text-light mb-0 x-small fw-bold">{{ $review->user->nama ?? 'Pengguna' }}
                                            </h6>
                                            <div class="d-flex">
                                                @foreach(range(1, 5) as $i)
                                                    <i
                                                        class="fas fa-star x-small {{ $i <= $review->rating ? 'text-gold' : 'text-muted opacity-25' }}"></i>
                                                @endforeach
                                            </div>
                                        </div>
                                        <small
                                            class="text-dim ms-auto x-small">{{ $review->created_at->diffForHumans() }}</small>
                                    </div>
                                    <p class="text-dim small mb-0 ps-5">{{ $review->comment }}</p>
                                </div>
                            @empty
                                <div class="text-center py-4">
                                    <p class="text-dim small fst-italic">Belum ada ulasan.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <style>
        .shadow-2xl {
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        .hover-opacity:hover {
            opacity: 0.7;
        }

        .hover-scale:hover {
            transform: scale(1.02);
        }

        .bg-gold {
            background-color: var(--accent-gold) !important;
        }

        .text-gold {
            color: var(--accent-gold) !important;
        }

        .text-dim {
            color: rgba(255, 255, 255, 0.6) !important;
        }

        .btn-glass {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: white;
            transition: all 0.3s ease;
        }

        .btn-glass:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: var(--accent-gold);
        }

        .btn-outline-glass {
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: var(--text-dim);
            background: transparent;
        }

        .btn-outline-glass:hover {
            border-color: var(--accent-gold);
            color: var(--accent-gold);
        }

        .form-control-glass {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: white;
        }

        .form-control-glass:focus {
            background: rgba(255, 255, 255, 0.1);
            border-color: var(--accent-gold);
            color: white;
            box-shadow: none;
        }

        /* Custom Scrollbar for Reviews */
        .reviews-scroll::-webkit-scrollbar {
            width: 4px;
        }

        .reviews-scroll::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.02);
        }

        .reviews-scroll::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 4px;
        }

        .reviews-scroll::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        /* Rating Stars */
        .rating-css div {
            color: #ffe400;
            font-size: 10px;
            font-family: sans-serif;
            font-weight: 800;
            text-align: left;
            text-transform: uppercase;
            padding: 0;
        }

        .rating-css input {
            display: none;
        }

        .rating-css input+label {
            font-size: 20px;
            text-shadow: 1px 1px 0 #ffe400;
            cursor: pointer;
            color: #444;
        }

        .rating-css input:checked+label~label {
            color: #444;
        }

        .rating-css input:checked+label,
        .rating-css input:not(:checked)+label:hover,
        .rating-css input:not(:checked)+label:hover~label {
            color: #ffe400;
        }

        .star-icon {
            display: flex;
            flex-direction: row-reverse;
            justify-content: flex-end;
            gap: 5px;
        }

        .x-small {
            font-size: 0.85rem;
        }
    </style>
@endsection