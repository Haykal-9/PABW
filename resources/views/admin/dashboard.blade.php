@extends('layouts.admin_master') {{-- PERBAIKAN: Mengacu ke resources/views/admin/admin.blade.php --}}

@section('admin_title', 'Dashboard Utama')

@section('admin_content')
    <h1 class="mb-4 text-primary-dark">Dashboard TapalKuda</h1>
    <p class="lead text-muted">Selamat datang di Panel Administrasi. Data di bawah ini bersifat simulasi (dummy).</p>

    <div class="row g-4 mt-3">
        <div class="col-md-6 col-lg-3">
            <div class="card bg-primary-dark text-white shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-utensils me-2"></i> Total Menu</h5>
                    <p class="display-4 fw-bold">{{ $stats['total_menu'] }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card bg-success text-white shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-users me-2"></i> Reservasi Pending</h5>
                    <p class="display-4 fw-bold">{{ $stats['reservasi_pending'] }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card bg-info text-white shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-dollar-sign me-2"></i> Pendapatan Hari Ini (Simulasi)</h5>
                    <p class="fs-2 fw-bold">Rp {{ number_format($stats['pendapatan_hari_ini'], 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card bg-warning text-dark shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-calendar-alt me-2"></i> Total Reservasi</h5>
                    <p class="display-4 fw-bold">{{ $stats['total_reservasi'] }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection