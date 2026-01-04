@extends('customers.layouts.app')

@section('content')
    <div class="min-vh-100 py-5" 
         style="background: radial-gradient(circle at top right, #1f1a18, #0f0c0b); padding-top: 100px !important;">
        <div class="container">
            {{-- Back Button --}}
            <div class="mb-4 no-print">
                <a href="{{ route('profile.show', ['id' => Auth::id()]) }}#orders" class="text-decoration-none text-dim hover-text-gold transition-all">
                    <i class="fas fa-arrow-left me-2"></i> Back to Orders
                </a>
            </div>

            <div class="glass-card position-relative border-0 shadow-2xl overflow-hidden print-clean" 
                 style="background: linear-gradient(145deg, rgba(255,255,255,0.03) 0%, rgba(255,255,255,0.01) 100%);">
                
                {{-- Top Gold Line --}}
                <div class="position-absolute top-0 start-0 w-100 h-1 bg-gradient-gold opacity-50 no-print"></div>

                <div class="card-body p-4 p-md-5">
                    
                    {{-- HEADER --}}
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-start mb-5 border-bottom border-white border-opacity-10 pb-4">
                        <div>
                            <h1 class="font-serif text-light fw-bold display-6 mb-1">INVOICE</h1>
                            <p class="text-gold font-monospace small ls-1 text-uppercase">Tapal Kuda Restaurant & Cafe</p>
                        </div>
                        <div class="text-md-end mt-4 mt-md-0">
                            <h4 class="font-monospace text-light mb-1">#INV-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</h4>
                            <p class="text-dim small mb-2">{{ \Carbon\Carbon::parse($order->order_date)->format('d F Y, H:i') }}</p>
                            
                            @php
                                $statusClass = match($order->status_id) {
                                    1 => 'bg-success text-success',
                                    2 => 'bg-warning text-warning',
                                    3 => 'bg-danger text-danger',
                                    default => 'bg-secondary text-secondary'
                                };
                            @endphp
                            <span class="badge {{ $statusClass }} bg-opacity-10 border border-opacity-25 rounded-pill px-3 py-2 small fw-normal">
                                {{ $order->status->status_name ?? 'Unknown' }}
                            </span>
                        </div>
                    </div>

                    {{-- INFO GRID --}}
                    <div class="row g-5 mb-5">
                        {{-- Customer Info --}}
                        <div class="col-md-6">
                            <div class="p-4 rounded-3" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05);">
                                <h6 class="text-gold x-small fw-bold text-uppercase ls-1 mb-3 border-bottom border-white border-opacity-10 pb-2">Billed To</h6>
                                <h5 class="text-light font-serif mb-2">{{ $order->user->nama }}</h5>
                                <div class="text-dim small">
                                    <p class="mb-1"><i class="fas fa-envelope me-2 opacity-50 w-20"></i> {{ $order->user->email }}</p>
                                    @if($order->user->no_telp)
                                        <p class="mb-1"><i class="fas fa-phone me-2 opacity-50 w-20"></i> {{ $order->user->no_telp }}</p>
                                    @endif
                                    @if($order->user->alamat)
                                        <p class="mb-0"><i class="fas fa-map-marker-alt me-2 opacity-50 w-20"></i> {{ $order->user->alamat }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Order Details --}}
                        <div class="col-md-6">
                            <div class="p-4 rounded-3 h-100" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05);">
                                <h6 class="text-gold x-small fw-bold text-uppercase ls-1 mb-3 border-bottom border-white border-opacity-10 pb-2">Transaction Details</h6>
                                <div class="row g-0">
                                    <div class="col-6 mb-2 text-dim small">Order Type</div>
                                    <div class="col-6 mb-2 text-light text-end">{{ $order->orderType->type_name ?? '-' }}</div>
                                    
                                    <div class="col-6 mb-2 text-dim small">Payment Method</div>
                                    <div class="col-6 mb-2 text-light text-end">{{ $order->paymentMethod->method_name ?? '-' }}</div>
                                    
                                    <div class="col-6 mb-2 text-dim small">Order Date</div>
                                    <div class="col-6 mb-2 text-light text-end">{{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- TABLE --}}
                    <div class="table-responsive mb-5 rounded-3 overflow-hidden" style="border: 1px solid rgba(255,255,255,0.05);">
                        <table class="table table-borderless text-light align-middle mb-0 custom-glass-table">
                            <thead style="background: rgba(212, 175, 55, 0.1);">
                                <tr class="text-gold x-small fw-bold text-uppercase ls-1">
                                    <th class="py-3 ps-4">Item Description</th>
                                    <th class="py-3 text-center">Price</th>
                                    <th class="py-3 text-center">Qty</th>
                                    <th class="py-3 text-end pe-4">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->details as $detail)
                                    <tr class="border-bottom border-white border-opacity-5 hover-bg-glass">
                                        <td class="py-4 ps-4">
                                            <div class="d-flex align-items-center gap-3">
                                                @if($detail->menu && $detail->menu->url_foto)
                                                    <img src="{{ asset('foto/' . $detail->menu->url_foto) }}" 
                                                         class="rounded bg-dark object-fit-cover d-none d-sm-block shadow-sm" 
                                                         style="width: 48px; height: 48px;">
                                                @endif
                                                <div>
                                                    <div class="fw-medium text-light">{{ $detail->menu->nama ?? 'Unknown Item' }}</div>
                                                    @if($detail->item_notes)
                                                        <div class="x-small text-dim fst-italic mt-1">Note: {{ $detail->item_notes }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-4 text-center text-dim bg-transparent">Rp {{ number_format($detail->price_per_item, 0, ',', '.') }}</td>
                                        <td class="py-4 text-center bg-transparent">
                                            <span class="badge bg-white bg-opacity-5 text-light border border-white border-opacity-10 rounded-pill px-2">
                                                {{ $detail->quantity }}
                                            </span>
                                        </td>
                                        <td class="py-4 text-end pe-4 fw-bold bg-transparent">Rp {{ number_format($detail->total, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- SUMMARY --}}
                    <div class="row justify-content-end">
                        <div class="col-md-5 col-lg-4">
                            <div class="glass-summary p-4 rounded-3 shadow-lg position-relative overflow-hidden">
                                <div class="position-absolute top-0 end-0 p-5 bg-gradient-gold opacity-10 rounded-circle filter-blur"></div>
                                
                                <div class="d-flex justify-content-between mb-2 text-dim small position-relative z-1">
                                    <span>Subtotal</span>
                                    <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                                </div>
                                @if($tax > 0)
                                    <div class="d-flex justify-content-between mb-2 text-dim small position-relative z-1">
                                        <span>Tax</span>
                                        <span>Rp {{ number_format($tax, 0, ',', '.') }}</span>
                                    </div>
                                @endif
                                <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top border-white border-opacity-20 position-relative z-1">
                                    <span class="text-light fw-bold text-uppercase ls-1">Total</span>
                                    <span class="text-gold font-serif fs-3">Rp {{ number_format($total, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- FOOTER / ACTIONS --}}
                    <div class="mt-5 pt-5 text-center no-print">
                        <div class="d-flex justify-content-center gap-3 flex-wrap">
                            @if($order->status_id == 2)
                                <form action="{{ route('profile.order.cancel', ['userId' => Auth::id(), 'orderId' => $order->id]) }}" method="POST"
                                      onsubmit="return confirm('Are you sure you want to cancel this order?')">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger rounded-pill px-4">
                                        <i class="fas fa-times me-2"></i> Cancel Order
                                    </button>
                                </form>
                            @endif

                            @if($order->status_id == 1)
                                <a href="{{ route('menu') }}" class="btn btn-gold rounded-pill px-4 fw-bold">
                                    <i class="fas fa-redo me-2"></i> Order Again
                                </a>
                            @endif
                        </div>
                        <p class="text-dim x-small mt-4 mb-0 opacity-50">Thank you for dining with Tapal Kuda Restaurant & Cafe.</p>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- STYLES (Inline to keep single file structure) --}}
    <style>
        .glass-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .shadow-2xl { box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5); }
        .text-dim { color: rgba(255,255,255, 0.5); }
        .x-small { font-size: 0.75rem; }
        .ls-1 { letter-spacing: 1px; }
        .bg-gradient-gold { background: linear-gradient(90deg, var(--accent-gold), transparent); }
        .w-20 { width: 20px; text-align: center; }

        /* Table Specific Fixes */
        .custom-glass-table tbody tr td, 
        .custom-glass-table thead tr th {
            background-color: transparent !important;
            color: #fff !important;
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }
        .custom-glass-table .text-dim {
            color: rgba(255,255,255,0.6) !important;
        }
        .hover-bg-glass:hover td {
            background-color: rgba(255,255,255,0.03) !important;
        }

        .glass-summary {
            background: rgba(0,0,0,0.3);
            border: 1px solid rgba(212, 175, 55, 0.2);
            backdrop-filter: blur(20px);
        }

        .filter-blur { filter: blur(40px); }

        .btn-outline-glass {
            border: 1px solid rgba(255,255,255,0.2);
            color: rgba(255,255,255,0.8);
            background: transparent;
        }
        .btn-outline-glass:hover {
            background: rgba(255,255,255,0.1);
            color: #fff;
            border-color: rgba(255,255,255,0.4);
        }
        
        .btn-gold {
            background: linear-gradient(45deg, #d4af37, #f2d06b);
            color: #000;
            border: none;
        }
        .btn-gold:hover {
            background: linear-gradient(45deg, #c5a028, #e1c05b);
            color: #000;
            transform: translateY(-1px);
        }
        .hover-text-gold:hover { color: var(--accent-gold) !important; }

        /* Print Styling */
        @media print {
            body { background: #fff !important; color: #000 !important; }
            .no-print { display: none !important; }
            .print-clean { 
                background: none !important; 
                border: none !important; 
                box-shadow: none !important; 
                color: #000 !important;
            }
            .text-light { color: #000 !important; }
            .text-gold { color: #000 !important; font-weight: bold; }
            .text-dim { color: #555 !important; }
            .border-white { border-color: #ddd !important; }
            .badge { border: 1px solid #000 !important; color: #000 !important; }
            .glass-card { backdrop-filter: none !important; border: none !important; }
            .custom-glass-table tbody tr td { color: #000 !important; border-bottom: 1px solid #ddd; }
            .glass-summary { background: transparent !important; border: 1px solid #ddd !important; }
        }
    </style>
@endsection
