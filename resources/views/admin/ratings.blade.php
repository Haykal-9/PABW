@extends('admin.layouts.app')

@section('admin_page_title', 'Rating & Ulasan')

@section('admin_content')
<div class="mb-4">
    <h4 class="fw-bold mb-1">Ulasan Pelanggan</h4>
    <p class="text-muted small mb-0">Umpan balik dari pelanggan mengenai menu dan layanan Anda.</p>
</div>

<div class="row g-4">
    @forelse ($ratings as $review)
    <div class="col-md-6 col-lg-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($review['user']) }}&background=F2E8D5&color=6D4C41" 
                         class="rounded-circle me-3" width="45">
                    <div>
                        <h6 class="mb-0 fw-bold">{{ $review['user'] }}</h6>
                        <small class="text-muted">{{ $review['tanggal'] }}</small>
                    </div>
                </div>
                <div class="mb-2 text-warning">
                    @for ($i = 1; $i <= 5; $i++)
                        <i class="{{ $i <= $review['rating'] ? 'fas' : 'far' }} fa-star"></i>
                    @endfor
                    <span class="ms-1 text-dark fw-bold small">({{ $review['rating'] }}/5)</span>
                </div>
                <p class="card-text text-secondary small mb-3">
                    "{{ $review['ulasan'] ?? 'Tidak ada komentar.' }}"
                </p>
                <div class="d-flex justify-content-between align-items-center mt-auto pt-3 border-top">
                    <span class="badge bg-light text-muted border small">
                        <i class="fas fa-tag me-1"></i> {{ $review['menu'] }}
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
        <p class="text-muted">Belum ada ulasan dari pelanggan.</p>
    </div>
    @endforelse
@endsection