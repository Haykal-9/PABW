@extends('customers.layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            
            {{-- Header --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold mb-0">
                    <i class="fas fa-bell me-2 text-primary"></i>Notifikasi
                </h2>
                @if($unreadCount > 0)
                    <form method="POST" action="{{ route('notifications.readAll') }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-check-double me-1"></i>Tandai Semua Dibaca
                        </button>
                    </form>
                @endif
            </div>

            {{-- Alert Messages --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Notifications List --}}
            <div class="card shadow-sm border-0">
                <div class="card-body p-0">
                    @if($notifications->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($notifications as $notification)
                                <div class="list-group-item list-group-item-action {{ !$notification->is_read ? 'bg-light' : '' }}">
                                    <div class="d-flex w-100 justify-content-between align-items-start">
                                        <div class="flex-grow-1">
                                            <div class="d-flex align-items-center mb-2">
                                                {{-- Icon based on type --}}
                                                @if($notification->type == 'reservation_cancelled')
                                                    <span class="badge bg-warning text-dark me-2">
                                                        <i class="fas fa-calendar-times"></i>
                                                    </span>
                                                @elseif($notification->type == 'order_cancelled')
                                                    <span class="badge bg-danger me-2">
                                                        <i class="fas fa-shopping-bag"></i>
                                                    </span>
                                                @elseif($notification->type == 'reservation_confirmed')
                                                    <span class="badge bg-success me-2">
                                                        <i class="fas fa-calendar-check"></i>
                                                    </span>
                                                @else
                                                    <span class="badge bg-info me-2">
                                                        <i class="fas fa-info-circle"></i>
                                                    </span>
                                                @endif

                                                <h6 class="mb-0 fw-bold">{{ $notification->title }}</h6>
                                                
                                                @if(!$notification->is_read)
                                                    <span class="badge bg-primary ms-2">Baru</span>
                                                @endif
                                            </div>
                                            
                                            <p class="mb-1 text-muted">{{ $notification->message }}</p>
                                            <small class="text-muted">
                                                <i class="fas fa-clock me-1"></i>
                                                {{ $notification->created_at->diffForHumans() }}
                                            </small>
                                        </div>
                                        
                                        <div class="ms-3">
                                            @if($notification->link)
                                                <form method="POST" action="{{ route('notifications.read', $notification->id) }}" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-eye me-1"></i>Lihat
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Pagination --}}
                        <div class="p-3">
                            {{ $notifications->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-bell-slash fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Belum ada notifikasi.</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
