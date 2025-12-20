@extends('admin.layouts.app')
@section('admin_page_title', 'Ringkasan Bisnis')

@section('admin_content')
<div class="row g-4">
    <div class="col-xl-3 col-md-6">
        <div class="card p-3 border-0">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <p class="text-muted small fw-bold mb-1">PENDAPATAN HARI INI</p>
                    <h4 class="mb-0 fw-bold">Rp {{ number_format($data['pendapatanHariIni'], 0, ',', '.') }}</h4>
                </div>
                <div class="bg-success bg-opacity-10 p-3 rounded-circle text-success">
                    <i class="fas fa-wallet fa-lg"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card p-3 border-0">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <p class="text-muted small fw-bold mb-1">MENU TERJUAL</p>
                    <h4 class="mb-0 fw-bold">{{ $data['menuTerjualHariIni'] }} <span class="small fw-normal text-muted">Item</span></h4>
                </div>
                <div class="bg-primary bg-opacity-10 p-3 rounded-circle text-primary">
                    <i class="fas fa-mug-hot fa-lg"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card p-3 border-0">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <p class="text-muted small fw-bold mb-1">TOTAL PENDAPATAN</p>
                    <h4 class="mb-0 fw-bold">Rp {{ number_format($data['totalPendapatan'], 0, ',', '.') }}</h4>
                </div>
                <div class="bg-info bg-opacity-10 p-3 rounded-circle text-info">
                    <i class="fas fa-chart-line fa-lg"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card p-3 border-0">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <p class="text-muted small fw-bold mb-1">RESERVASI BERHASIL</p>
                    <h4 class="mb-0 fw-bold">{{ $data['reservasiTerlaksana'] }}</h4>
                </div>
                <div class="bg-warning bg-opacity-10 p-3 rounded-circle text-warning">
                    <i class="fas fa-calendar-check fa-lg"></i>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection