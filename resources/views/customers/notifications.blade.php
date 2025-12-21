@extends('customers.layouts.app')

@section('content')
    <div class="min-vh-100 py-5"
        style="background: radial-gradient(circle at top right, #1f1a18, #0f0c0b); padding-top: 100px !important;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">

                    {{-- Header --}}
                    <div
                        class="d-flex justify-content-between align-items-end mb-5 border-bottom border-white border-opacity-10 pb-3">
                        <div>
                            <h1 class="font-serif text-light display-6 fw-bold mb-1">Notifications</h1>
                            <p class="text-dim small mb-0">Stay updated with your latest activities</p>
                        </div>
                        @if($unreadCount > 0)
                            <form method="POST" action="{{ route('notifications.readAll') }}">
                                @csrf
                                <button type="submit"
                                    class="btn btn-link text-gold text-decoration-none x-small fw-bold text-uppercase ls-1 hover-text-light transition-all">
                                    <i class="fas fa-check-double me-1"></i> Mark All as Read
                                </button>
                            </form>
                        @endif
                    </div>

                    {{-- Notifications List --}}
                    <div class="d-flex flex-column gap-3">
                        @if($notifications->count() > 0)
                            @foreach($notifications as $notification)
                                <div
                                    class="glass-card p-4 position-relative overflow-hidden transition-all hover-scale 
                                                        {{ !$notification->is_read ? 'border-gold-left bg-glass-highlight' : 'bg-glass-dim' }}">

                                    {{-- Unread Indicator Dot --}}
                                    @if(!$notification->is_read)
                                        <div class="position-absolute top-0 end-0 mt-3 me-3">
                                            <span class="d-inline-block rounded-circle bg-gold"
                                                style="width: 8px; height: 8px; box-shadow: 0 0 10px var(--accent-gold);"></span>
                                        </div>
                                    @endif

                                    <div class="d-flex gap-4 align-items-start">
                                        {{-- Icon Box --}}
                                        <div class="flex-shrink-0">
                                            <div class="rounded-circle d-flex align-items-center justify-content-center border border-white border-opacity-10"
                                                style="width: 50px; height: 50px; background: rgba(255,255,255,0.03);">
                                                @if($notification->type == 'reservation_cancelled' || $notification->type == 'order_cancelled')
                                                    <i class="fas fa-times text-danger fs-5"></i>
                                                @elseif($notification->type == 'reservation_confirmed')
                                                    <i class="fas fa-check text-success fs-5"></i>
                                                @elseif($notification->type == 'order_pending')
                                                    <i class="fas fa-clock text-warning fs-5"></i>
                                                @else
                                                    <i class="fas fa-bell text-gold fs-5"></i>
                                                @endif
                                            </div>
                                        </div>

                                        {{-- Content --}}
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between align-items-start mb-1">
                                                <h6
                                                    class="text-light fw-bold mb-0 {{ !$notification->is_read ? 'text-gold' : '' }}">
                                                    {{ $notification->title }}
                                                </h6>
                                                <small class="text-dim x-small text-nowrap ms-3">
                                                    {{ $notification->created_at->diffForHumans() }}
                                                </small>
                                            </div>

                                            <p class="text-dim small mb-3 lh-sm">{{ $notification->message }}</p>

                                            @if($notification->link)
                                                <form method="POST" action="{{ route('notifications.read', $notification->id) }}">
                                                    @csrf
                                                    <button type="submit"
                                                        class="btn btn-sm btn-outline-glass rounded-pill px-3 x-small">
                                                        View Details <i class="fas fa-arrow-right ms-1"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            {{-- Pagination --}}
                            <div class="mt-4 d-flex justify-content-center">
                                {{ $notifications->links() }}
                            </div>

                        @else
                            <div class="glass-card p-5 text-center">
                                <div class="mb-3">
                                    <i class="fas fa-bell-slash text-dim fs-1 opacity-25"></i>
                                </div>
                                <h5 class="text-light font-serif">Empty here</h5>
                                <p class="text-dim small">You have no notifications at the moment.</p>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>

    <style>
        .glass-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 12px;
        }

        .bg-glass-highlight {
            background: linear-gradient(145deg, rgba(212, 175, 55, 0.1) 0%, rgba(0, 0, 0, 0) 100%);
            border: 1px solid rgba(212, 175, 55, 0.3);
        }

        .bg-glass-dim {
            background: rgba(255, 255, 255, 0.01);
            opacity: 0.8;
        }

        .border-gold-left {
            border-left: 3px solid var(--accent-gold) !important;
        }

        .text-dim {
            color: rgba(255, 255, 255, 0.5);
        }

        .x-small {
            font-size: 0.75rem;
        }

        .ls-1 {
            letter-spacing: 1px;
        }

        .hover-scale:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .transition-all {
            transition: all 0.3s ease;
        }

        .hover-text-light:hover {
            color: #fff !important;
        }

        .btn-outline-glass {
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: rgba(255, 255, 255, 0.7);
            background: transparent;
        }

        .btn-outline-glass:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            border-color: rgba(255, 255, 255, 0.4);
        }

        /* Pagination Customization Override */
        .pagination .page-item .page-link {
            background: transparent;
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.7);
        }

        .pagination .page-item.active .page-link {
            background: var(--accent-gold);
            border-color: var(--accent-gold);
            color: #000;
        }
    </style>
@endsection