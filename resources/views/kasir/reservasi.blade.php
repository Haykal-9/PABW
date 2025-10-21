@extends('kasir.layouts.app')

@push('styles')
<style>
    .reservasi-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 1.5rem;
        margin-top: 2rem;
    }
    .reservasi-card {
        background-color: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 0.75rem;
        padding: 1.5rem;
    }
    .reservasi-card h5 {
        font-weight: 600;
        color: var(--accent-color);
        margin-bottom: 1rem;
    }
    .reservasi-card p {
        margin-bottom: 0.5rem;
        color: var(--text-muted-color);
        font-size: 0.9rem;
    }
    .reservasi-card p strong {
        color: var(--text-color);
        min-width: 110px;
        display: inline-block;
    }
</style>
@endpush

@section('content')
<main class="content">
    <div class="header">
        <h1>Daftar Reservasi</h1>
        <p>Daftar semua reservasi yang telah dikonfirmasi oleh pelanggan.</p>
    </div>
    
    <div class="reservasi-grid">
        @forelse ($reservasi as $item)
            <div class="reservasi-card">
                <h5>Kode Reservasi: {{ $item['kode'] }}</h5>
                <p><strong>Nama</strong>: {{ $item['nama'] }}</p>
                <p><strong>Email</strong>: {{ $item['email'] }}</p>
                <p><strong>No. Telepon</strong>: {{ $item['no_telp'] }}</p>
                <p><strong>Jumlah Orang</strong>: {{ $item['jumlah_orang'] }}</p>
                <p><strong>Tanggal</strong>: {{ $item['tanggal'] }}</p>
                <p><strong>Pesan</strong>: {{ $item['pesan'] }}</p>
            </div>
        @empty
            <p class="text-center text-muted">Tidak ada data reservasi.</p>
        @endforelse
    </div>
</main>
@endsection
