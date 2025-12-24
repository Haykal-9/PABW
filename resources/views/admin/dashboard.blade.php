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
<div class="row mt-5">
    <div class="col-12 mb-4">
        <div class="card border-0 shadow-lg p-5 bg-white bg-opacity-80 rounded-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold text-brown mb-0" style="letter-spacing:1px;">Grafik Pendapatan Bulanan</h3>
                <form method="GET" action="" class="d-flex align-items-center gap-2">
                    <label for="year" class="mb-0 text-brown fw-semibold">Tahun:</label>
                    <select name="year" id="year" class="form-select form-select-sm rounded-pill px-3 py-2 border-brown" style="min-width:100px;" onchange="this.form.submit()">
                        @for($y = date('Y')-4; $y <= date('Y'); $y++)
                            <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </form>
            </div>
            <div class="bg-brown bg-opacity-10 rounded-4 p-3 mb-2">
                <canvas id="incomeChart" height="120"></canvas>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card border-0 shadow-lg p-5 bg-white bg-opacity-80 rounded-4">
            <h3 class="fw-bold text-brown mb-4" style="letter-spacing:1px;">Grafik Menu Terlaris</h3>
            <div class="bg-brown bg-opacity-10 rounded-4 p-3 mb-2">
                <canvas id="menuSalesChart" height="120"></canvas>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Grafik Pendapatan Harian
        const incomeCtx = document.getElementById('incomeChart').getContext('2d');
        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        const incomeData = @json(array_values($monthlyIncome));
        // Gradasi area dan shadow
        const brownGradient = incomeCtx.createLinearGradient(0, 0, 0, 400);
        brownGradient.addColorStop(0, '#a0522d');
        brownGradient.addColorStop(0.5, '#c19a6b');
        brownGradient.addColorStop(1, '#fff8f0');
        new Chart(incomeCtx, {
            type: 'line',
            data: {
                labels: months,
                datasets: [{
                    label: 'Pendapatan (Rp)',
                    data: incomeData,
                    fill: true,
                    backgroundColor: brownGradient,
                    borderColor: '#a0522d',
                    borderWidth: 4,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#a0522d',
                    pointRadius: 9,
                    pointHoverRadius: 13,
                    pointStyle: 'circle',
                    tension: 0.4,
                }]
            },
            options: {
                responsive: true,
                animation: {
                    duration: 1400,
                    easing: 'easeInOutQuart'
                },
                plugins: {
                    legend: { display: false },
                    title: {
                        display: true,
                        text: 'Grafik Pendapatan Bulanan Tahun ' + @json($year),
                        font: { size: 26, weight: 'bold', family: 'inherit' },
                        color: '#a0522d',
                        padding: { top: 10, bottom: 20 }
                    },
                    tooltip: {
                        backgroundColor: '#fff8f0',
                        titleColor: '#a0522d',
                        bodyColor: '#333',
                        borderColor: '#a0522d',
                        borderWidth: 2,
                        padding: 16,
                        cornerRadius: 12,
                        titleFont: { size: 18, weight: 'bold' },
                        bodyFont: { size: 16 },
                        callbacks: {
                            label: function(context) {
                                return `Rp ${context.parsed.y.toLocaleString('id-ID')}`;
                            }
                        }
                    },
                    datalabels: {
                        anchor: 'end',
                        align: 'top',
                        color: '#a0522d',
                        font: { weight: 'bold', size: 17, family: 'inherit' },
                        formatter: function(value) { return 'Rp ' + value.toLocaleString('id-ID'); }
                    }
                },
                scales: {
                    x: {
                        grid: { color: 'rgba(160,82,45,0.08)', borderDash: [4,4] },
                        ticks: { color: '#a0522d', font: { size: 16, weight: 'bold', family: 'inherit' }, padding: 8 }
                    },
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(160,82,45,0.08)', borderDash: [4,4] },
                        ticks: {
                            color: '#a0522d',
                            font: { size: 16, weight: 'bold', family: 'inherit' },
                            callback: function(value) { return 'Rp ' + value.toLocaleString('id-ID'); },
                            padding: 8
                        }
                    }
                }
            },
            plugins: [ChartDataLabels]
        });

        // Grafik Penjualan Menu Terbanyak
        const ctx = document.getElementById('menuSalesChart').getContext('2d');
        let menuLabels = @json($menuSales->pluck('menu.nama'));
        let menuData = @json($menuSales->pluck('total_order'));
        if(menuLabels.length > 5) {
            menuLabels = menuLabels.slice(0,5);
            menuData = menuData.slice(0,5);
        }
        const brownGradient2 = ctx.createLinearGradient(0, 0, 0, 400);
        brownGradient2.addColorStop(0, '#a0522d');
        brownGradient2.addColorStop(0.5, '#c19a6b');
        brownGradient2.addColorStop(1, '#fff8f0');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: menuLabels,
                datasets: [{
                    label: 'Jumlah Order',
                    data: menuData,
                    backgroundColor: brownGradient2,
                    borderColor: '#a0522d',
                    borderWidth: 4,
                    borderRadius: 12,
                    maxBarThickness: 48,
                }]
            },
            options: {
                responsive: true,
                animation: {
                    duration: 1400,
                    easing: 'easeInOutQuart'
                },
                plugins: {
                    legend: { display: false },
                    title: {
                        display: true,
                        text: 'Top 5 Menu Paling Banyak Diorder',
                        font: { size: 26, weight: 'bold', family: 'inherit' },
                        color: '#a0522d',
                        padding: { top: 10, bottom: 20 }
                    },
                    tooltip: {
                        backgroundColor: '#fff8f0',
                        titleColor: '#a0522d',
                        bodyColor: '#333',
                        borderColor: '#a0522d',
                        borderWidth: 2,
                        padding: 16,
                        cornerRadius: 12,
                        titleFont: { size: 18, weight: 'bold' },
                        bodyFont: { size: 16 },
                        callbacks: {
                            label: function(context) {
                                return `Jumlah Order: ${context.parsed.y}`;
                            }
                        }
                    },
                    datalabels: {
                        anchor: 'end',
                        align: 'end',
                        color: '#a0522d',
                        font: { weight: 'bold', size: 17, family: 'inherit' },
                        formatter: function(value) { return value; }
                    }
                },
                scales: {
                    x: {
                        grid: { color: 'rgba(160,82,45,0.08)', borderDash: [4,4] },
                        ticks: { color: '#a0522d', font: { size: 16, weight: 'bold', family: 'inherit' }, padding: 8 }
                    },
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(160,82,45,0.08)', borderDash: [4,4] },
                        ticks: {
                            color: '#a0522d',
                            font: { size: 16, weight: 'bold', family: 'inherit' },
                            callback: function(value) { return Math.round(value); },
                            stepSize: 1,
                            padding: 8
                        }
                    }
                }
            },
            plugins: [ChartDataLabels]
        });
    });
</script>
@endpush
@endsection