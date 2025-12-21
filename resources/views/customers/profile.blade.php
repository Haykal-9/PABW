@extends('customers.layouts.app')

@section('content')
    <div class="min-vh-100 py-5" 
         style="background: radial-gradient(circle at top right, #1f1a18, #0f0c0b); margin-top:-0px; padding-top: 100px !important;">
        <div class="container">
            <div class="row g-4">
                
                {{-- LEFT COLUMN: STICKY MEMBER SIDEBAR --}}
                <div class="col-lg-4 col-xl-3">
                    <div class="sticky-top" style="top: 100px; z-index: 10;">
                        
                        {{-- Member Card --}}
                        <div class="glass-card mb-4 overflow-hidden position-relative border-0 shadow-2xl" 
                             style="background: linear-gradient(145deg, rgba(255,255,255,0.05) 0%, rgba(255,255,255,0.01) 100%);">
                            {{-- Gold Glow --}}
                            <div class="position-absolute top-0 end-0 w-75 h-75 rounded-circle" 
                                 style="background: radial-gradient(circle, rgba(212, 175, 55, 0.15), transparent 70%); transform: translate(30%, -30%);"></div>

                            <div class="card-body p-4 text-center position-relative">
                                {{-- Avatar with Gold Ring --}}
                                <div class="ratio ratio-1x1 mx-auto mb-3 rounded-circle shadow-lg position-relative" style="width: 100px;">
                                   <div class="position-absolute top-0 start-0 w-100 h-100 rounded-circle border border-2 border-gold p-1">
                                        @if($user->profile_picture)
                                            <img src="{{ asset('uploads/profile/' . $user->profile_picture) }}" 
                                                 class="w-100 h-100 rounded-circle object-fit-cover bg-dark">
                                        @else
                                            <div class="w-100 h-100 rounded-circle bg-dark d-flex align-items-center justify-content-center">
                                                <i class="fas fa-user text-gold fs-1 opacity-50"></i>
                                            </div>
                                        @endif
                                   </div>
                                </div>

                                <h4 class="fw-bold text-light font-serif mb-1">{{ $user->nama }}</h4>
                                <p class="text-gold font-monospace small mb-3 opacity-75">{{ $user->email }}</p>
                                


                                <div class="d-grid gap-2">
                                    <a href="{{ route('profile.edit', ['id' => $user->id]) }}" 
                                       class="btn btn-outline-glass btn-sm rounded-pill">
                                        edit profile
                                    </a>
                                    <a href="/logout" onclick="return confirm('Logout?')" 
                                       class="btn btn-outline-danger btn-sm rounded-pill opacity-75 hover-opacity-100">
                                        sign out
                                    </a>
                                </div>
                            </div>
                        </div>

                        {{-- Vertical Navigation --}}
                        <div class="glass-card p-0 border-0 overflow-hidden">
                            <ul class="nav nav-pills flex-column" id="profileTabs" role="tablist">
                                <li class="nav-item">
                                    <button class="nav-link active d-flex align-items-center gap-3 px-4 py-3 rounded-0 text-start w-100 transition-all" 
                                            id="detail-tab" data-bs-toggle="tab" data-bs-target="#detail" type="button">
                                        <div class="icon-box rounded-circle bg-white bg-opacity-10 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                            <i class="fas fa-user small"></i>
                                        </div>
                                        <span class="fw-medium small text-uppercase ls-1">My Profile</span>
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link d-flex align-items-center gap-3 px-4 py-3 rounded-0 text-start w-100 transition-all" 
                                            id="orders-tab" data-bs-toggle="tab" data-bs-target="#orders" type="button">
                                        <div class="icon-box rounded-circle bg-white bg-opacity-10 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                            <i class="fas fa-shopping-bag small"></i>
                                        </div>
                                        <span class="fw-medium small text-uppercase ls-1">Orders</span>
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link d-flex align-items-center gap-3 px-4 py-3 rounded-0 text-start w-100 transition-all" 
                                            id="reservations-tab" data-bs-toggle="tab" data-bs-target="#reservations" type="button">
                                        <div class="icon-box rounded-circle bg-white bg-opacity-10 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                            <i class="fas fa-calendar-alt small"></i>
                                        </div>
                                        <span class="fw-medium small text-uppercase ls-1">Reservations</span>
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- RIGHT COLUMN: CONTENT AREA --}}
                <div class="col-lg-8 col-xl-9">
                    <div class="tab-content" id="profileTabsContent">
                        
                        {{-- 1. Profile Details --}}
                        <div class="tab-pane fade show active" id="detail" role="tabpanel">
                            <div class="glass-card p-4 p-md-5 border-0 position-relative overflow-hidden">
                                <h3 class="font-serif text-light border-bottom border-white border-opacity-10 pb-3 mb-4">Personal Information</h3>
                                
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="p-3 rounded-3" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05);">
                                            <label class="text-gold x-small fw-bold text-uppercase mb-1">Username</label>
                                            <div class="text-light fs-5">{{ $user->username }}</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="p-3 rounded-3" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05);">
                                            <label class="text-gold x-small fw-bold text-uppercase mb-1">Mobile Phone</label>
                                            <div class="text-light fs-5">{{ $user->no_telp }}</div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="p-3 rounded-3" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05);">
                                            <label class="text-gold x-small fw-bold text-uppercase mb-1">Shipping Address</label>
                                            <div class="text-light fs-5">{{ $user->alamat }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- 2. Orders (Receipt Cards Grid) --}}
                        <div class="tab-pane fade" id="orders" role="tabpanel">
                            
                            @php
                                $pendingOrders = $riwayatPesanan->where('status_id', 2);
                                $pastOrders = $riwayatPesanan->where('status_id', '!=', 2);
                            @endphp

                            {{-- PENDING ORDERS --}}
                            @if($pendingOrders->count() > 0)
                                <div class="glass-card p-4 border-0 mb-4 bg-transparent shadow-none">
                                    <h6 class="text-warning x-small fw-bold text-uppercase ls-1 mb-3 mt-1 d-inline-block pb-1 border-bottom border-warning border-opacity-25">
                                        <i class="fas fa-clock me-2"></i>Waiting for Confirmation
                                    </h6>
                                    <div class="row g-4">
                                        @foreach($pendingOrders as $order)
                                            <div class="col-md-6">
                                                <div class="glass-card p-4 h-100 position-relative border-0 shadow-lg hover-scale transition-all" 
                                                     style="background: linear-gradient(145deg, rgba(255,193,7,0.05) 0%, rgba(255,255,255,0.01) 100%); border-left: 4px solid #ffc107 !important;">
                                                    
                                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                                        <div>
                                                            <div class="text-gold font-monospace small">#{{ $order->id }}</div>
                                                            <div class="text-dim x-small">{{ \Carbon\Carbon::parse($order->order_date)->format('d F Y, H:i') }}</div>
                                                        </div>
                                                        <span class="badge bg-warning text-warning bg-opacity-10 border border-opacity-25 rounded-pill px-2 py-1 x-small fw-normal">
                                                            Pending
                                                        </span>
                                                    </div>

                                                    <div class="d-flex align-items-center justify-content-between mb-4">
                                                        <span class="text-light small">Total Amount</span>
                                                        <span class="text-gold font-serif fs-4">
                                                            Rp {{ number_format($order->details->sum(fn($d) => $d->price_per_item * $d->quantity), 0, ',', '.') }}
                                                        </span>
                                                    </div>

                                                    <div class="d-grid gap-2">
                                                        <a href="{{ route('profile.order.show', ['userId' => Auth::id(), 'orderId' => $order->id]) }}" 
                                                           class="btn btn-sm btn-outline-glass w-100 rounded-0">
                                                            View Details
                                                        </a>
                                                        <form action="{{ route('profile.order.cancel', ['userId' => Auth::id(), 'orderId' => $order->id]) }}" method="POST" class="d-grid">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-outline-danger w-100 rounded-0" onclick="return confirm('Cancel this order?')">
                                                                Cancel Order
                                                            </button>
                                                        </form>
                                                    </div>

                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            {{-- PAST ORDERS --}}
                            <div class="glass-card p-4 border-0 bg-transparent shadow-none">
                                <h3 class="font-serif text-light border-bottom border-white border-opacity-10 pb-3 mb-4">Order History</h3>
                                 @if($pastOrders->count() > 0)
                                    <div class="row g-4">
                                        @foreach($pastOrders as $order)
                                            <div class="col-md-6">
                                                <div class="glass-card p-4 h-100 position-relative border-0 shadow-lg hover-scale transition-all" 
                                                     style="background: linear-gradient(145deg, rgba(255,255,255,0.03) 0%, rgba(255,255,255,0.01) 100%);">
                                                    
                                                    {{-- Status Line --}}
                                                    <div class="position-absolute top-0 start-0 w-100 h-1 bg-gradient-gold opacity-50"></div>

                                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                                        <div>
                                                            <div class="text-gold font-monospace small">#{{ $order->id }}</div>
                                                            <div class="text-dim x-small">{{ \Carbon\Carbon::parse($order->order_date)->format('d F Y, H:i') }}</div>
                                                        </div>
                                                        @php
                                                            $statusClass = match($order->status_id) {
                                                                1 => 'bg-success text-success',
                                                                3 => 'bg-danger text-danger',
                                                                default => 'bg-secondary text-secondary'
                                                            };
                                                        @endphp
                                                        <span class="badge {{ $statusClass }} bg-opacity-10 border border-opacity-25 rounded-pill px-2 py-1 x-small fw-normal">
                                                            {{ $order->status->status_name ?? '-' }}
                                                        </span>
                                                    </div>

                                                    <div class="d-flex align-items-center justify-content-between mb-4">
                                                        <span class="text-light small">Total Amount</span>
                                                        <span class="text-gold font-serif fs-4">
                                                            Rp {{ number_format($order->details->sum(fn($d) => $d->price_per_item * $d->quantity), 0, ',', '.') }}
                                                        </span>
                                                    </div>

                                                    <div class="d-grid gap-2">
                                                        <a href="{{ route('profile.order.show', ['userId' => Auth::id(), 'orderId' => $order->id]) }}" 
                                                           class="btn btn-sm btn-outline-glass w-100 rounded-0">
                                                            View Receipt
                                                        </a>
                                                    </div>

                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @elseif($pendingOrders->count() == 0)
                                    <div class="text-center py-5 opacity-50">
                                        <i class="fas fa-receipt fs-1 mb-3"></i>
                                        <p>No orders found yet.</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- 3. Reservations (Timeline & Cards) --}}
                        <div class="tab-pane fade" id="reservations" role="tabpanel">
                            
                            {{-- Ongoing Grid --}}
                            @if($reservasiOngoing->count() > 0)
                                <div class="glass-card p-4 border-0 mb-4 bg-transparent shadow-none">
                                    <h6 class="text-gold x-small fw-bold text-uppercase ls-1 mb-3 mt-1 underline-gold d-inline-block pb-1">Upcoming</h6>
                                    <div class="row g-3">
                                        @foreach($reservasiOngoing as $res)
                                            <div class="col-md-6">
                                                <div class="glass-card p-0 h-100 border-0 overflow-hidden d-flex flex-column group-hover-gold">
                                                    <div class="position-relative h-100 p-4" style="background: rgba(255,255,255,0.02);">
                                                        <div class="d-flex justify-content-between mb-3">
                                                            @php
                                                                $resStatusClass = match($res->status_id) {
                                                                    1 => 'bg-warning text-warning',
                                                                    2 => 'bg-success text-success',
                                                                    3 => 'bg-danger text-danger',
                                                                    default => 'bg-secondary text-secondary'
                                                                };
                                                            @endphp
                                                            <div class="badge {{ $resStatusClass }} bg-opacity-10 border border-opacity-25 rounded-0 px-2 py-1 small text-uppercase">
                                                                {{ $res->status->status_name ?? 'Unknown' }}
                                                            </div>
                                                            <span class="font-monospace text-dim small">#{{ $res->kode_reservasi }}</span>
                                                        </div>
                                                        
                                                        <h3 class="font-serif text-light mb-1">{{ \Carbon\Carbon::parse($res->tanggal_reservasi)->format('d') }}</h3>
                                                        <div class="text-uppercase text-gold small fw-bold ls-1 mb-3">{{ \Carbon\Carbon::parse($res->tanggal_reservasi)->format('F Y') }}</div>
                                                        
                                                        <div class="d-flex align-items-center text-dim small mb-4">
                                                            <i class="fas fa-clock fs-6 me-2 text-gold"></i> {{ \Carbon\Carbon::parse($res->tanggal_reservasi)->format('H:i') }} WIB
                                                            <span class="mx-2">|</span>
                                                            <i class="fas fa-user-friends fs-6 me-2 text-gold"></i> {{ $res->jumlah_orang }} Guest(s)
                                                        </div>

                                                        @if($res->status_id != 3)
                                                             <form method="POST" action="{{ route('profile.reservation.cancel', ['userId' => $user->id, 'reservationId' => $res->id]) }}">
                                                                @csrf
                                                                <button type="submit" class="btn btn-sm btn-outline-danger w-100 rounded-0" onclick="return confirm('Cancel reservation?')">
                                                                    Cancel Booking
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            {{-- History Timeline --}}
                            <div class="glass-card p-4 border-0 bg-transparent shadow-none">
                                <h6 class="text-gold x-small fw-bold text-uppercase ls-1 mb-4 border-bottom border-white border-opacity-10 pb-3">History Timeline</h6>
                                @if($reservasiRiwayat->count() > 0)
                                    <div class="timeline-container">
                                        @foreach($reservasiRiwayat as $res)
                                            <div class="d-flex gap-4 mb-4 position-relative timeline-item">
                                                {{-- Date Box --}}
                                                <div class="text-center rounded-3 p-2 d-flex flex-column justify-content-center align-items-center flex-shrink-0 border border-white border-opacity-10" 
                                                     style="width: 70px; height: 70px; background: rgba(255,255,255,0.02);">
                                                    <span class="d-block fw-bold text-light fs-5 lh-1">{{ \Carbon\Carbon::parse($res->tanggal_reservasi)->format('d') }}</span>
                                                    <span class="d-block x-small text-gold text-uppercase ls-1">{{ \Carbon\Carbon::parse($res->tanggal_reservasi)->format('M') }}</span>
                                                </div>

                                                <div class="flex-grow-1 py-1">
                                                    <div class="d-flex justify-content-between align-items-start mb-1">
                                                        <span class="font-monospace text-dim small">#{{ $res->kode_reservasi }}</span>
                                                        <span class="badge {{ $res->status_id == 2 ? 'bg-success bg-opacity-10 text-success' : 'bg-secondary bg-opacity-10 text-secondary' }} rounded-pill border border-opacity-25 x-small">
                                                            {{ $res->status->status_name ?? '-' }}
                                                        </span>
                                                    </div>
                                                    <div class="text-light small">Table for {{ $res->jumlah_orang }} people</div>
                                                    <div class="text-dim x-small mt-1">{{ \Carbon\Carbon::parse($res->tanggal_reservasi)->format('l, Y') }}</div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-dim text-center py-4 mb-0 small">No previous reservations.</p>
                                @endif
                            </div>

                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <style>
        /* Side Navigation Styles */
        .nav-pills .nav-link {
            color: rgba(255,255,255,0.6);
            background: transparent;
            border: 1px solid transparent;
        }
        .nav-pills .nav-link:hover {
            color: #fff;
            background: rgba(255,255,255,0.05);
        }
        .nav-pills .nav-link.active {
            background: linear-gradient(90deg, rgba(212, 175, 55, 0.1), transparent);
            border-left: 3px solid var(--accent-gold);
            color: var(--accent-gold);
            border-radius: 0 !important;
        }
        .nav-pills .nav-link.active .icon-box {
            background: var(--accent-gold) !important;
            color: #000;
            box-shadow: 0 0 10px rgba(212, 175, 55, 0.5);
        }
        
        .shadow-2xl { box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5); }
        .text-dim { color: rgba(255,255,255, 0.5); }
        .x-small { font-size: 0.75rem; }
        .ls-1 { letter-spacing: 1px; }

        .btn-outline-glass {
            border: 1px solid rgba(255,255,255,0.2);
            color: rgba(255,255,255,0.8);
        }
        .btn-outline-glass:hover {
            background: rgba(255,255,255,0.1);
            color: #fff;
            border-color: rgba(255,255,255,0.4);
        }

        /* NEW STYLES for History Redesign */
        .hover-scale:hover { transform: translateY(-5px); }
        .bg-gradient-gold { background: linear-gradient(90deg, var(--accent-gold), transparent); }
        
        .timeline-item {
            position: relative;
        }
        .timeline-item:not(:last-child)::before {
            content: '';
            position: absolute;
            left: 35px;
            top: 70px;
            bottom: -24px;
            width: 1px;
            background: rgba(255,255,255,0.1);
            z-index: 0;
        }
        
        .group-hover-gold:hover .badge {
            background: var(--accent-gold) !important;
            color: #000 !important;
        }
        
    </style>
@endsection