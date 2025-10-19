@extends('layouts.kasir')
@section('title', 'Tapal Kuda | Reservasi Kasir')

@push('styles')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

@endpush


@section('content')

    <div class="container" role="main">

        <main>
            <header>
                <h1>Reservasi Kasir</h1>
                <p>Daftar semua reservasi yang telah dikonfirmasi</p>
            </header>
            <section class="reservasi-section" aria-label="Reservation List">
                <div class="reservasi-container">
                    
                        <div class="reservasi-grid">
                            @forelse ($reservasi as $r)
                                <div class="reservasi-card">
                                <h3>Kode Reservasi: {{ $r['kode'] }}</h3>
                                <p style="color: white;"><strong>Nama:</strong> {{ $r['nama'] }}</p>
                                <p style="color: white;"><strong>Email:</strong> {{ $r['email'] }}</p>
                                <p style="color: white;"><strong>No. Telepon:</strong> {{ $r['no_telp'] }}</p>
                                <p style="color: white;"><strong>Jumlah Orang:</strong> {{ $r['jumlah_orang'] }}</p>
                                <p style="color: white;"><strong>Tanggal:</strong> {{ $r['tanggal'] }}</p>
                                <p style="color: white;"><strong>Pesan:</strong> {{ $r['pesan'] }}</p>
                                <p class="status status-dikonfirmasi" style="color: white;"><>Status: Dikonfirmasi</p>
                                </div>
                            @empty
                                <p class="no-reservasi" style="color: white;">Tidak ada reservasi yang tersedia.</p>
                            @endforelse
                    
                </div>
            </section>
        </main>
    </div>

@endsection

