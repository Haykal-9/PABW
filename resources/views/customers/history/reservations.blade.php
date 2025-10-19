@extends('customers.layouts.app')

@section('title', 'Riwayat Reservasi')

@push('styles')
    <link href="{{ asset('css/riwayat.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="riwayat-header">
        <i class='bx bx-calendar'></i> Riwayat Reservasi
    </div>
    <div class="container my-5">
        <a href="{{ url('/profil') }}" class="btn btn-outline-secondary mb-4">
            <i class='bx bx-user'></i> Kembali ke Profil
        </a>

        <div class="list-group">
            @forelse ($reservations as $reservation)
                <div class="list-group-item list-group-item-action flex-column align-items-start">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">Kode: {{ $reservation->kode_reservasi }}</h5>
                        <small>{{ date('d M Y', strtotime($reservation->tanggal_reservasi)) }}</small>
                    </div>
                    <p class="mb-1">Jadwal: {{ date('H:i', strtotime($reservation->tanggal_reservasi)) }} untuk {{
                $reservation->jumlah_orang }} orang.</p>
                    <small>Status: <span
                            class="badge {{ $reservation->reservation_status_name == 'Dikonfirmasi' ? 'bg-success' : 'bg-danger' }}">{{
                $reservation->reservation_status_name }}</span></small>
                </div>
            @empty
                <p class="text-center">Belum ada riwayat reservasi.</p>
            @endforelse
        </div>
    </div>
@endsection