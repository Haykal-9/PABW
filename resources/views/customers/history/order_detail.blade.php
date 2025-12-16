@extends('customers.layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-4xl">
    {{-- Back Button --}}
    <div class="mb-6">
        <a href="{{ route('profile.show', ['id' => Auth::id()]) }}#orders" class="text-amber-600 hover:text-amber-700 font-medium">
            <i class="fas fa-arrow-left mr-2"></i>Kembali ke Riwayat Pesanan
        </a>
    </div>

    {{-- Invoice Card --}}
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        {{-- Header --}}
        <div class="bg-gradient-to-r from-amber-600 to-amber-700 text-white p-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-3xl font-bold mb-2">INVOICE</h1>
                    <p class="text-amber-100">Tapal Kuda Restaurant & Cafe</p>
                </div>
                <div class="mt-4 md:mt-0 text-right">
                    <p class="text-xl font-bold">#INV-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</p>
                    <p class="text-amber-100">{{ \Carbon\Carbon::parse($order->order_date)->format('d F Y, H:i') }}</p>
                </div>
            </div>
        </div>

        {{-- Order Info --}}
        <div class="p-8">
            <div class="grid md:grid-cols-2 gap-8 mb-8">
                {{-- Customer Info --}}
                <div>
                    <h3 class="text-sm font-semibold text-gray-500 uppercase mb-3">Informasi Pelanggan</h3>
                    <div class="space-y-2">
                        <p class="font-semibold text-gray-800">{{ $order->user->nama }}</p>
                        <p class="text-gray-600 text-sm">
                            <i class="fas fa-envelope mr-2 text-gray-400"></i>{{ $order->user->email }}
                        </p>
                        @if($order->user->no_telp)
                            <p class="text-gray-600 text-sm">
                                <i class="fas fa-phone mr-2 text-gray-400"></i>{{ $order->user->no_telp }}
                            </p>
                        @endif
                        @if($order->user->alamat)
                            <p class="text-gray-600 text-sm">
                                <i class="fas fa-map-marker-alt mr-2 text-gray-400"></i>{{ $order->user->alamat }}
                            </p>
                        @endif
                    </div>
                </div>

                {{-- Order Details --}}
                <div>
                    <h3 class="text-sm font-semibold text-gray-500 uppercase mb-3">Detail Pesanan</h3>
                    <div class="space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Status:</span>
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
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Tipe Order:</span>
                            <span class="font-medium text-gray-800">{{ $order->orderType->type_name ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Metode Pembayaran:</span>
                            <span class="font-medium text-gray-800">{{ $order->paymentMethod->method_name ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Tanggal Order:</span>
                            <span class="font-medium text-gray-800">{{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y H:i') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Order Items Table --}}
            <div class="mb-8">
                <h3 class="text-sm font-semibold text-gray-500 uppercase mb-4">Item Pesanan</h3>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b-2 border-gray-200">
                                <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Item</th>
                                <th class="text-center py-3 px-4 text-sm font-semibold text-gray-700">Harga</th>
                                <th class="text-center py-3 px-4 text-sm font-semibold text-gray-700">Qty</th>
                                <th class="text-right py-3 px-4 text-sm font-semibold text-gray-700">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($order->details as $detail)
                                <tr class="hover:bg-gray-50">
                                    <td class="py-4 px-4">
                                        <div class="flex items-center gap-3">
                                            @if($detail->menu && $detail->menu->url_foto)
                                                <img src="{{ asset('foto/' . $detail->menu->url_foto) }}" 
                                                     alt="{{ $detail->menu->nama }}"
                                                     class="w-12 h-12 rounded object-cover">
                                            @else
                                                <div class="w-12 h-12 rounded bg-gray-200 flex items-center justify-center">
                                                    <i class="fas fa-utensils text-gray-400"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <p class="font-medium text-gray-800">{{ $detail->menu->nama ?? 'Unknown Item' }}</p>
                                                @if($detail->item_notes)
                                                    <p class="text-xs text-gray-500 italic">Catatan: {{ $detail->item_notes }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 px-4 text-center text-gray-700">
                                        Rp {{ number_format($detail->price_per_item, 0, ',', '.') }}
                                    </td>
                                    <td class="py-4 px-4 text-center">
                                        <span class="bg-gray-100 px-3 py-1 rounded-full text-sm font-medium text-gray-700">
                                            {{ $detail->quantity }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-4 text-right font-medium text-gray-800">
                                        Rp {{ number_format($detail->total, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Total Calculation --}}
            <div class="border-t-2 border-gray-200 pt-6">
                <div class="max-w-sm ml-auto space-y-3">
                    <div class="flex justify-between text-gray-700">
                        <span>Subtotal:</span>
                        <span class="font-medium">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    @if($tax > 0)
                        <div class="flex justify-between text-gray-700">
                            <span>Pajak/Service:</span>
                            <span class="font-medium">Rp {{ number_format($tax, 0, ',', '.') }}</span>
                        </div>
                    @endif
                    <div class="flex justify-between text-xl font-bold text-gray-900 pt-3 border-t border-gray-300">
                        <span>Total:</span>
                        <span class="text-amber-600">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="mt-8 pt-6 border-t border-gray-200 flex flex-wrap gap-3 no-print">
                <button onclick="window.print()" 
                        class="bg-amber-600 hover:bg-amber-700 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                    <i class="fas fa-print mr-2"></i>Cetak Invoice
                </button>

                @if($order->status_id == 2)
                    <form action="{{ route('profile.order.cancel', ['userId' => Auth::id(), 'orderId' => $order->id]) }}" method="POST" class="inline"
                          onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')">
                        @csrf
                        <button type="submit" 
                                class="bg-red-100 hover:bg-red-200 text-red-700 px-6 py-3 rounded-lg font-medium transition-colors">
                            <i class="fas fa-times mr-2"></i>Batalkan Pesanan
                        </button>
                    </form>
                @endif

                @if($order->status_id == 1)
                    <a href="/menu" 
                       class="bg-green-100 hover:bg-green-200 text-green-700 px-6 py-3 rounded-lg font-medium transition-colors">
                        <i class="fas fa-redo mr-2"></i>Pesan Lagi
                    </a>
                @endif
            </div>

            {{-- Footer Note --}}
            <div class="mt-8 pt-6 border-t border-gray-200">
                <p class="text-sm text-gray-500 text-center">
                    Terima kasih telah memesan di Tapal Kuda Restaurant & Cafe!<br>
                    Untuk pertanyaan, hubungi kami atau kunjungi restoran kami.
                </p>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        body * {
            visibility: hidden;
        }
        .container, .container * {
            visibility: visible;
        }
        .container {
            position: absolute;
            left: 0;
            top: 0;
        }
        .no-print {
            display: none !important;
        }
    }
</style>
@endsection
