@extends('admin.layouts.app')

@section('admin_page_title', 'Riwayat Penjualan')

@section('admin_content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Riwayat Penjualan</h4>
        <p class="text-muted small mb-0">Pantau semua transaksi masuk dan status pembayaran pelanggan.</p>
    </div>
    <div class="w-100">
        <form method="GET" action="" class="row g-2 align-items-end">
            <div class="col-md-2 col-6">
                <label class="form-label mb-1 small">Dari</label>
                <input type="date" name="start_date" class="form-control form-control-sm" value="{{ request('start_date') }}">
            </div>
            <div class="col-md-2 col-6">
                <label class="form-label mb-1 small">Sampai</label>
                <input type="date" name="end_date" class="form-control form-control-sm" value="{{ request('end_date') }}">
            </div>
            <div class="col-md-2 col-6">
                <label class="form-label mb-1 small">Status</label>
                <select name="status" class="form-select form-select-sm">
                    <option value="">Semua</option>
                    @if(isset($statuses))
                        @foreach($statuses as $status)
                            <option value="{{ $status->id }}" {{ request('status') == $status->id ? 'selected' : '' }}>{{ $status->status_name }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="col-md-2 col-6">
                <label class="form-label mb-1 small">Metode</label>
                <select name="payment_method" class="form-select form-select-sm">
                    <option value="">Semua</option>
                    @if(isset($paymentMethods))
                        @foreach($paymentMethods as $method)
                            <option value="{{ $method->id }}" {{ request('payment_method') == $method->id ? 'selected' : '' }}>{{ $method->method_name }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="col-md-2 col-6">
                <label class="form-label mb-1 small">Tipe Order</label>
                <select name="order_type" class="form-select form-select-sm">
                    <option value="">Semua</option>
                    @if(isset($orderTypes))
                        @foreach($orderTypes as $type)
                            <option value="{{ $type->id }}" {{ request('order_type') == $type->id ? 'selected' : '' }}>{{ $type->type_name }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="col-md-2 col-12 d-flex gap-2">
                <button type="submit" class="btn btn-primary btn-sm w-100"><i class="fas fa-filter me-1"></i> Filter</button>
                <a href="{{ route('admin.orders') }}" class="btn btn-light border btn-sm w-100"><i class="fas fa-undo me-1"></i> Reset</a>
            </div>
        </form>
    </div>
</div>

{{-- Statistik Ringkas Penjualan --}}
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm p-3">
            <div class="d-flex align-items-center">
                <div class="bg-primary bg-opacity-10 p-3 rounded-circle text-primary me-3">
                    <i class="fas fa-shopping-bag fa-lg"></i>
                </div>
                <div>
                    <small class="text-muted fw-bold d-block">TOTAL TRANSAKSI</small>
                    <h5 class="mb-0 fw-bold">{{ $orders->count() }}</h5>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm p-3">
            <div class="d-flex align-items-center">
                <div class="bg-warning bg-opacity-10 p-3 rounded-circle text-warning me-3">
                    <i class="fas fa-clock fa-lg"></i>
                </div>
                <div>
                    <small class="text-muted fw-bold d-block">MENUNGGU</small>
                    <h5 class="mb-0 fw-bold">
                        {{ $orders->where('status', 'pending')->count() }}
                    </h5>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm p-3">
            <div class="d-flex align-items-center">
                <div class="bg-info bg-opacity-10 p-3 rounded-circle text-info me-3">
                    <i class="fas fa-spinner fa-lg"></i>
                </div>
                <div>
                    <small class="text-muted fw-bold d-block">DIPROSES</small>
                    <h5 class="mb-0 fw-bold">
                        {{ $orders->where('status', 'processing')->count() }}
                    </h5>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm p-3">
            <div class="d-flex align-items-center">
                <div class="bg-success bg-opacity-10 p-3 rounded-circle text-success me-3">
                    <i class="fas fa-check-double fa-lg"></i>
                </div>
                <div>
                    <small class="text-muted fw-bold d-block">SELESAI</small>
                    <h5 class="mb-0 fw-bold">
                        {{ $orders->where('status', 'completed')->count() }}
                    </h5>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm overflow-hidden">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead class="bg-light">
                <tr>
                    <th class="ps-4 py-3 text-uppercase small fw-bold text-muted">ID Order</th>
                    <th class="py-3 text-uppercase small fw-bold text-muted">Pelanggan</th>
                    <th class="py-3 text-uppercase small fw-bold text-muted">Tanggal</th>
                    <th class="py-3 text-uppercase small fw-bold text-muted">Total Bayar</th>
                    <th class="py-3 text-uppercase small fw-bold text-muted">Metode</th>
                    <th class="py-3 text-uppercase small fw-bold text-muted">Status</th>
                    <th class="py-3 text-uppercase small fw-bold text-muted text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                <tr>
                    <td class="ps-4 fw-bold text-primary">#ORD-{{ $order['id'] }}</td>
                    <td>
                        <div class="fw-bold">{{ $order['customer'] }}</div>
                    </td>
                    <td>
                        <div class="small text-dark">{{ $order['tanggal'] }}</div>
                    </td>
                    <td>
                        <span class="fw-bold text-dark">Rp {{ number_format($order['total'], 0, ',', '.') }}</span>
                    </td>
                    <td>
                        <span class="badge bg-light text-dark border px-2 py-1 fw-medium">
                            {{ $order['metode'] }}
                        </span>
                    </td>
                    <td>
                        @if(strtolower($order['status']) == 'completed')
                            <span class="badge bg-success-subtle text-success border border-success px-3 py-2">
                                <i class="fas fa-check-circle me-1"></i> Selesai
                            </span>
                        @elseif(strtolower($order['status']) == 'processing')
                            <span class="badge bg-info-subtle text-info border border-info px-3 py-2">
                                <i class="fas fa-spinner me-1"></i> Diproses
                            </span>
                        @elseif(strtolower($order['status']) == 'pending')
                            <span class="badge bg-warning-subtle text-warning border border-warning px-3 py-2">
                                <i class="fas fa-clock me-1"></i> Menunggu
                            </span>
                        @elseif(strtolower($order['status']) == 'cancelled')
                            <span class="badge bg-danger-subtle text-danger border border-danger px-3 py-2">
                                <i class="fas fa-times-circle me-1"></i> Dibatalkan
                            </span>
                        @else
                            <span class="badge bg-secondary-subtle text-secondary border border-secondary px-3 py-2">
                                <i class="fas fa-question-circle me-1"></i> {{ ucfirst($order['status']) }}
                            </span>
                        @endif
                    </td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-light border btn-detail" 
                                data-bs-toggle="modal" 
                                data-bs-target="#orderDetailModal"
                                data-id="{{ $order['id'] }}"
                                data-items='@json($order["items"])'>
                            <i class="fas fa-eye text-muted me-1"></i> Detail
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- Modal Detail Pesanan --}}
<div class="modal fade" id="orderDetailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-light">
                <h5 class="modal-title fw-bold">Rincian Item <span id="modal-order-id"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4" id="modal-item-list">
                {{-- Diisi via JS --}}
            </div>
            <div class="modal-footer border-0 bg-light">
                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const detailButtons = document.querySelectorAll('.btn-detail');
        const itemListContainer = document.getElementById('modal-item-list');
        
        detailButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                const orderId = this.dataset.id;
                const items = JSON.parse(this.dataset.items);
                document.getElementById('modal-order-id').textContent = '#' + orderId;
                
                let html = '<ul class="list-group list-group-flush">';
                items.forEach(item => {
                    html += `
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <div>
                                <div class="fw-bold">${item.nama}</div>
                                <small class="text-muted">${item.quantity} x Rp ${new Intl.NumberFormat('id-ID').format(item.price)}</small>
                            </div>
                            <span class="fw-bold">Rp ${new Intl.NumberFormat('id-ID').format(item.subtotal)}</span>
                        </li>`;
                });
                html += '</ul>';
                itemListContainer.innerHTML = html;
            });
        });
    });
</script>
@endpush