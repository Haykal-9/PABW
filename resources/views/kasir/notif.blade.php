@extends('kasir.layouts.app')

@push('styles')
    <style>
        .notif-list {
            margin-top: 2rem;
        }

        .notif-item {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 0.75rem;
            padding: 1.5rem;
            margin-bottom: 1rem;
            position: relative;
            border-left: 4px solid transparent;
        }

        /* Color coding based on notification type */
        .notif-item.completed {
            border-left-color: #28a745;
        }

        .notif-item.cancelled {
            border-left-color: #ffc107;
        }

        .notif-item.reservation {
            border-left-color: #17a2b8;
        }

        .notif-item.low_stock {
            border-left-color: #dc3545;
        }

        .notif-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.5rem;
        }

        .notif-title {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .notif-icon {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
        }

        .notif-icon.completed {
            background-color: rgba(40, 167, 69, 0.2);
            color: #28a745;
        }

        .notif-icon.cancelled {
            background-color: rgba(255, 193, 7, 0.2);
            color: #ffc107;
        }

        .notif-icon.reservation {
            background-color: rgba(23, 162, 184, 0.2);
            color: #17a2b8;
        }

        .notif-icon.low_stock {
            background-color: rgba(220, 53, 69, 0.2);
            color: #dc3545;
        }

        .notif-header h5 {
            font-weight: 600;
            margin: 0;
        }

        .notif-header .time {
            font-size: 0.85rem;
            color: var(--text-muted-color);
        }

        .notif-body {
            font-size: 0.95rem;
            color: var(--text-muted-color);
            margin-left: 3rem;
        }
    </style>
@endpush

@section('content')
    <main class="content">
        <div class="header">
            <h1>Notifikasi</h1>
            <p>Semua pemberitahuan dan pembaruan penting ada di sini.</p>
        </div>

        <div class="notif-list">
            @forelse ($notifikasi as $item)
                <div class="notif-item {{ $item['type'] }}">
                    <div class="notif-header">
                        <div class="notif-title">
                            <div class="notif-icon {{ $item['type'] }}">
                                @if($item['type'] == 'completed')
                                    <i class="bi bi-check-circle-fill"></i>
                                @elseif($item['type'] == 'cancelled')
                                    <i class="bi bi-x-circle-fill"></i>
                                @elseif($item['type'] == 'reservation')
                                    <i class="bi bi-calendar-check-fill"></i>
                                @elseif($item['type'] == 'low_stock')
                                    <i class="bi bi-exclamation-triangle-fill"></i>
                                @endif
                            </div>
                            <h5>{{ $item['judul'] }}</h5>
                        </div>
                        <span class="time">{{ $item['waktu'] }}</span>
                    </div>
                    <div class="notif-body">
                        <p>{{ $item['isi'] }}</p>
                    </div>
                </div>
            @empty
                <p class="text-center text-muted">Tidak ada notifikasi baru.</p>
            @endforelse
        </div>
    </main>
@endsection