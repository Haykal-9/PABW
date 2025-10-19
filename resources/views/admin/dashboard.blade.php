@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('admin_content')
    <div class="row">
        <div class="col-12 mb-4">
            <h2>Ringkasan Operasional</h2>
        </div>

        {{-- Card 1: Pendapatan Hari Ini --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2 border-3 border-success">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col me-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Pendapatan Penjualan Hari Ini
                            </div>
                            <div class="h5 mb-0 fw-bold text-gray-800">Rp
                                {{ number_format($data['pendapatanHariIni'], 0, ',', '.') }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-coins fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card 2: Menu Terjual Hari Ini --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2 border-3 border-primary">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col me-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Menu Terjual Hari Ini
                            </div>
                            <div class="h5 mb-0 fw-bold text-gray-800">{{ $data['menuTerjualHariIni'] }} Item</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-mug-hot fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card 3: Total Pendapatan Penjualan (Total) --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2 border-3 border-info">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col me-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Pendapatan Penjualan
                            </div>
                            <div class="h5 mb-0 fw-bold text-gray-800">Rp
                                {{ number_format($data['totalPendapatan'], 0, ',', '.') }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card 4: Jumlah Reservasi Terlaksana (Total) --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2 border-3 border-warning">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col me-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Reservasi Terlaksana (Total)
                            </div>
                            <div class="h5 mb-0 fw-bold text-gray-800">{{ $data['reservasiTerlaksana'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    

@endsection