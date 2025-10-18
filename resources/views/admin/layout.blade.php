@extends('layouts.admin_master') {{-- PERBAIKAN: Menggunakan layout induk minimal --}}

@section('title')
    Admin - @yield('admin_title') {{-- PERBAIKAN: Title diletakkan di section sendiri --}}
@endsection

@section('content')
<div class="container-fluid">
    <div class="row min-vh-100">
        {{-- Sidebar Admin --}}
        <div class="col-md-3 col-lg-2 bg-dark text-white p-3 shadow-lg" data-aos="fade-right">
            <h4 class="text-white fw-bolder mb-4 border-bottom border-secondary pb-2">Admin Panel</h4>
            <div class="list-group list-group-flush">
                {{-- Navigasi Sidebar --}}
                <a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action bg-dark text-white border-0 {{ Request::is('admin') ? 'active bg-primary-dark fw-bold' : '' }}">
                    <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                </a>
                <a href="{{ route('admin.menu') }}" class="list-group-item list-group-item-action bg-dark text-white border-0 {{ Request::is('admin/menu') ? 'active bg-primary-dark fw-bold' : '' }}">
                    <i class="fas fa-coffee me-2"></i> Kelola Menu
                </a>
                <a href="{{ route('admin.reservasi') }}" class="list-group-item list-group-item-action bg-dark text-white border-0 {{ Request::is('admin/reservasi') ? 'active bg-primary-dark fw-bold' : '' }}">
                    <i class="fas fa-calendar-check me-2"></i> Kelola Reservasi
                </a>
                <a href="{{ url('/') }}" class="list-group-item list-group-item-action bg-dark text-warning border-0 mt-3">
                    <i class="fas fa-sign-out-alt me-2"></i> Ke Halaman Pelanggan
                </a>
            </div>
        </div>

        {{-- Konten Utama (Diisi oleh view child) --}}
        <div class="col-md-9 col-lg-10 p-4 bg-light" data-aos="fade-left">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="p-3 bg-white rounded-3 shadow-sm">
                @yield('admin_content') {{-- Tempat Konten Utama --}}
            </div>
        </div>
    </div>
</div>
@endsection