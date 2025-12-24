@extends('admin.layouts.app')

@section('admin_page_title', 'Rating & Ulasan')

@section('admin_content')

<div class="mb-4">
    <h4 class="fw-bold mb-1">Ulasan Pelanggan</h4>
    <p class="text-muted small mb-0">Umpan balik dari pelanggan mengenai menu dan layanan Anda.</p>
    <form method="GET" class="mt-3">
        <div class="row g-2 align-items-end bg-white bg-opacity-90 rounded-4 shadow-sm px-3 py-3" style="max-width:600px; min-width:220px;">
            <div class="col-md-8 col-12">
                <label for="menu_filter" class="form-label mb-1 small">Menu</label>
                <select name="menu" id="menu_filter" class="form-select form-select-sm">
                    <option value="">Semua Menu</option>
                    @foreach ($menus as $menu)
                        <option value="{{ $menu }}" {{ request('menu') == $menu ? 'selected' : '' }}>{{ $menu }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 col-12 d-flex gap-2 mt-md-0 mt-2">
                <button type="submit" class="btn btn-primary btn-sm w-100"><i class="fas fa-filter me-1"></i> Filter</button>
                <a href="{{ route('admin.ratings') }}" class="btn btn-light border btn-sm w-100"><i class="fas fa-undo me-1"></i> Reset</a>
            </div>
        </div>
    </form>
</div>

<div class="row g-4">
    @forelse ($reviews as $review)
    <div class="col-md-6 col-lg-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(optional($review->user)->nama ?? 'User Dihapus') }}&background=F2E8D5&color=6D4C41" 
                         class="rounded-circle me-3" width="45">
                    <div>
                        <h6 class="mb-0 fw-bold">{{ optional($review->user)->nama ?? 'User Dihapus' }}</h6>
                        <small class="text-muted">{{ $review->created_at ? $review->created_at->format('Y-m-d') : 'N/A' }}</small>
                    </div>
                </div>
                <div class="mb-2 text-warning">
                    @for ($i = 1; $i <= 5; $i++)
                        <i class="{{ $i <= $review->rating ? 'fas' : 'far' }} fa-star"></i>
                    @endfor
                    <span class="ms-1 text-dark fw-bold small">({{ $review->rating }}/5)</span>
                </div>
                <p class="card-text text-secondary small mb-3">
                    "{{ $review->comment ?? 'Tidak ada komentar.' }}"
                </p>
                <div class="d-flex justify-content-between align-items-center mt-auto pt-3 border-top">
                    <span class="badge bg-light text-muted border small">
                        <i class="fas fa-tag me-1"></i>
                        {{ optional($review->menu_item)->nama ?? 'Menu Dihapus' }}
                    </span>
                    <button class="btn btn-sm btn-link text-danger p-0 text-decoration-none small">
                        <i class="fas fa-trash-alt"></i> Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="text-center py-5">
        <i class="fas fa-comment-slash fa-3x text-muted opacity-25 mb-3"></i>
        <p class="text-muted">
            @if(request('menu'))
                Belum ada ulasan untuk menu <b>{{ request('menu') }}</b>.
            @else
                Belum ada ulasan dari pelanggan.
            @endif
        </p>
    </div>
    @endforelse
@endsection