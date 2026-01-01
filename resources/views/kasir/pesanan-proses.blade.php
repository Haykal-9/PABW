@extends('kasir.layouts.app')

@push('styles')
    <style>
        .pesanan-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
        }

        .pesanan-card {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 0.75rem;
            padding: 1.5rem;
            position: relative;
        }

        .pesanan-card h5 {
            font-weight: 600;
            color: var(--accent-color);
            margin-bottom: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .pesanan-card .badge {
            font-size: 0.75rem;
            padding: 0.35rem 0.75rem;
            border-radius: 1rem;
        }

        .badge-processing {
            background-color: #3b82f6;
            color: white;
        }

        .pesanan-card p {
            margin-bottom: 0.5rem;
            color: var(--text-muted-color);
            font-size: 0.9rem;
        }

        .pesanan-card p strong {
            color: var(--text-color);
            min-width: 110px;
            display: inline-block;
        }

        .items-list {
            background-color: var(--sidebar-bg);
            border-radius: 0.5rem;
            padding: 0.75rem;
            margin: 1rem 0;
            max-height: 150px;
            overflow-y: auto;
        }

        .item-row {
            display: flex;
            justify-content: space-between;
            padding: 0.5rem 0;
            border-bottom: 1px solid var(--border-color);
            font-size: 0.85rem;
        }

        .item-row:last-child {
            border-bottom: none;
        }

        .item-name {
            color: var(--text-color);
        }

        .item-qty {
            color: var(--text-muted-color);
        }

        .item-price {
            color: var(--accent-color);
            font-weight: 500;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            padding-top: 0.75rem;
            margin-top: 0.5rem;
            border-top: 2px solid var(--border-color);
            font-weight: 600;
        }

        .total-row .value {
            color: var(--accent-color);
            font-size: 1.1rem;
        }

        .action-buttons {
            display: flex;
            gap: 0.75rem;
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid var(--border-color);
        }

        .btn-complete {
            flex: 1;
            padding: 0.6rem 1rem;
            background-color: #10b981;
            color: white;
            border: none;
            border-radius: 0.5rem;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .btn-complete:hover {
            background-color: #059669;
        }

        .alert {
            padding: 1rem 1.5rem;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
            font-weight: 500;
        }

        .alert-success {
            background-color: #d1fae5;
            color: #065f46;
            border: 1px solid #6ee7b7;
        }

        .alert-error {
            background-color: #fee2e2;
            color: #991b1b;
            border: 1px solid #fca5a5;
        }

        .empty-state {
            text-align: center;
            padding: 3rem;
            color: var(--text-muted-color);
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }
    </style>
@endpush

@section('content')
    <main class="content">
        <div class="header">
            <h1>Pesanan Diproses</h1>
            <p>Pesanan yang sedang diproses dan siap untuk diselesaikan.</p>
        </div>

        {{-- Alert Notifikasi --}}
        @if(session('success'))
            <div class="alert alert-success">
                ✓ {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                ✗ {{ session('error') }}
            </div>
        @endif

        <div class="pesanan-grid">
            @forelse ($pesanan as $item)
                <div class="pesanan-card">
                    <h5>
                        {{ $item['kode'] }}
                        <span class="badge badge-processing">Diproses</span>
                    </h5>
                    <p><strong>Pelanggan</strong>: {{ $item['nama'] }}</p>
                    <p><strong>Tanggal</strong>: {{ $item['tanggal'] }}</p>
                    <p><strong>Tipe</strong>: {{ $item['order_type'] }}</p>

                    {{-- Items List --}}
                    <div class="items-list">
                        @foreach ($item['items'] as $orderItem)
                            <div class="item-row">
                                <span class="item-name">{{ $orderItem['nama'] }}</span>
                                <span class="item-qty">x{{ $orderItem['quantity'] }}</span>
                                <span class="item-price">Rp {{ number_format($orderItem['subtotal'], 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                        <div class="total-row">
                            <span>Total</span>
                            <span class="value">Rp {{ number_format($item['total'], 0, ',', '.') }}</span>
                        </div>
                    </div>

                    {{-- Action Button --}}
                    <div class="action-buttons">
                        <form action="{{ route('kasir.pesanan.complete', $item['id']) }}" method="POST" style="flex: 1;">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn-complete" style="width: 100%;">
                                ✓ Selesai
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="empty-state" style="grid-column: 1/-1;">
                    <i class="bi bi-hourglass"></i>
                    <h4>Tidak ada pesanan diproses</h4>
                    <p>Semua pesanan sudah selesai atau belum ada yang diterima.</p>
                </div>
            @endforelse
        </div>
    </main>
@endsection