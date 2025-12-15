@extends('customers.layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-6xl">
    {{-- Header --}}
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Riwayat Pesanan</h1>
                <p class="text-gray-600">Lihat semua pesanan Anda di sini</p>
            </div>
            <a href="/menu" class="bg-amber-600 hover:bg-amber-700 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                <i class="fas fa-plus mr-2"></i>Pesan Lagi
            </a>
        </div>
    </div>

    {{-- Alert Messages --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center">
            <i class="fas fa-check-circle mr-3"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6 flex items-center">
            <i class="fas fa-exclamation-circle mr-3"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    {{-- Orders List --}}
    @if($orders->isEmpty())
        <div class="bg-white rounded-lg shadow-md p-12 text-center">
            <div class="mb-4">
                <i class="fas fa-shopping-bag text-gray-300 text-6xl"></i>
            </div>
            <h3 class="text-xl font-semibold text-gray-700 mb-2">Belum Ada Pesanan</h3>
            <p class="text-gray-500 mb-6">Anda belum melakukan pemesanan apapun</p>
            <a href="/menu" class="bg-amber-600 hover:bg-amber-700 text-white px-8 py-3 rounded-lg font-medium inline-block transition-colors">
                Mulai Pesan
            </a>
        </div>
    @else
        <div class="space-y-4">
            @foreach($orders as $order)
                <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow">
                    <div class="p-6">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4 gap-4">
                            <div>
                                <div class="flex items-center gap-3 mb-2">
                                    <h3 class="text-lg font-bold text-gray-800">
                                        Order #INV-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}
                                    </h3>
                                    @php
                                        // Status based on PaymentStatusSeeder: 1=completed, 2=pending, 3=cancelled
                                        $statusColors = [
                                            1 => 'bg-green-100 text-green-800',   // completed
                                            2 => 'bg-yellow-100 text-yellow-800', // pending
                                            3 => 'bg-red-100 text-red-800',       // cancelled
                                        ];
                                        $statusColor = $statusColors[$order->status_id] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusColor }}">
                                        {{ $order->status->status_name ?? 'Unknown' }}
                                    </span>
                                </div>
                                <div class="flex items-center gap-4 text-sm text-gray-600">
                                    <span>
                                        <i class="far fa-calendar mr-1"></i>
                                        {{ \Carbon\Carbon::parse($order->order_date)->format('d M Y, H:i') }}
                                    </span>
                                    <span>
                                        <i class="fas fa-utensils mr-1"></i>
                                        {{ $order->orderType->type_name ?? 'N/A' }}
                                    </span>
                                    <span>
                                        <i class="fas fa-credit-card mr-1"></i>
                                        {{ $order->paymentMethod->method_name ?? 'N/A' }}
                                    </span>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm text-gray-500 mb-1">Total Pembayaran</p>
                                <p class="text-2xl font-bold text-amber-600">
                                    Rp {{ number_format($order->total, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>

                        {{-- Order Items Preview --}}
                        <div class="border-t border-gray-200 pt-4 mb-4">
                            <p class="text-sm text-gray-600 mb-2">
                                <i class="fas fa-shopping-cart mr-1"></i>
                                {{ $order->details->count() }} item(s)
                            </p>
                            <div class="flex flex-wrap gap-2">
                                @foreach($order->details->take(3) as $detail)
                                    <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm">
                                        {{ $detail->menu->nama ?? 'Unknown' }} ({{ $detail->quantity }}x)
                                    </span>
                                @endforeach
                                @if($order->details->count() > 3)
                                    <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm">
                                        +{{ $order->details->count() - 3 }} lainnya
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="flex flex-wrap gap-2">
                            <a href="{{ route('orders.show', $order->id) }}" 
                               class="bg-amber-600 hover:bg-amber-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                <i class="fas fa-eye mr-1"></i>Lihat Detail
                            </a>
                            
                            @if($order->status_id == 2)
                                <form action="{{ route('orders.cancel', $order->id) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')">
                                    @csrf
                                    <button type="submit" 
                                            class="bg-red-100 hover:bg-red-200 text-red-700 px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                        <i class="fas fa-times mr-1"></i>Batalkan Pesanan
                                    </button>
                                </form>
                            @endif

                            @if($order->status_id == 1)
                                <a href="/menu" 
                                   class="bg-green-100 hover:bg-green-200 text-green-700 px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                    <i class="fas fa-redo mr-1"></i>Pesan Lagi
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-8">
            {{ $orders->links() }}
        </div>
    @endif
</div>

<style>
    /* Custom pagination styling */
    .pagination {
        display: flex;
        justify-content: center;
        gap: 0.5rem;
    }
    .pagination .page-link {
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        color: #d97706;
        border: 1px solid #d1d5db;
    }
    .pagination .page-link:hover {
        background-color: #fef3c7;
    }
    .pagination .active .page-link {
        background-color: #d97706;
        color: white;
        border-color: #d97706;
    }
</style>
@endsection
