@extends('kasir.layouts.app')

@push('styles')
<style>
    .notif-list {
        margin-top: 2rem;
    }
    .notif-item {
        background-color: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 0.75rem;
        padding: 1.5rem;
        margin-bottom: 1rem;
    }
    .notif-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.5rem;
    }
    .notif-header h5 { font-weight: 600; margin: 0; }
    .notif-header .time { font-size: 0.85rem; color: var(--text-muted-color); }
    .notif-body { font-size: 0.95rem; color: var(--text-muted-color); }
</style>
@endpush

@section('content')
<main class="content">
    <div class="header">
        <h1>Notifikasi</h1>
        <p>Semua pemberitahuan dan pembaruan penting ada di sini.</p>
    </div>
    
    <div class="notif-list">
        @forelse ($notifikasi as $item)
            <div class="notif-item">
                <div class="notif-header">
                    <h5>{{ $item['judul'] }}</h5>
                    <span class="time">{{ $item['waktu'] }}</span>
                </div>
                <div class="notif-body">
                    <p>{{ $item['isi'] }}</p>
                </div>
            </div>
        @empty
             <p class="text-center text-muted">Tidak ada notifikasi baru.</p>
        @endforelse
    </div>
</main>
@endsection
