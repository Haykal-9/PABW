@extends('admin.layouts.app')

@section('admin_page_title', 'Notifikasi')

@section('admin_content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Notifikasi</h4>
        <form method="GET" class="d-flex gap-2 align-items-center">
            <label class="mb-0">Tampilkan:</label>
            <select name="filter" class="form-select form-select-sm w-auto" onchange="this.form.submit()">
                <option value="all" {{ request('filter', 'all') == 'all' ? 'selected' : '' }}>Semua</option>
                <option value="unread" {{ request('filter') == 'unread' ? 'selected' : '' }}>Belum Dibaca</option>
                <option value="read" {{ request('filter') == 'read' ? 'selected' : '' }}>Sudah Dibaca</option>
            </select>
        </form>
    </div>
    <div class="row g-3">
        @forelse ($notifications as $notif)
            <div class="col-12">
                <div class="card border-0 shadow-sm {{ !$notif->is_read ? 'bg-light' : '' }}">
                    <div class="card-body d-flex align-items-center justify-content-between py-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width:44px;height:44px;">
                                <i class="fas fa-bell text-primary fa-lg"></i>
                            </div>
                            <div>
                                <div class="fw-bold mb-1">{{ $notif->title }}</div>
                                <div class="text-muted small mb-1">{{ $notif->message }}</div>
                                <div class="text-muted small"><i class="far fa-clock me-1"></i>{{ $notif->created_at->diffForHumans() }}</div>
                            </div>
                        </div>
                        <div class="text-end">
                            @if(!$notif->is_read)
                                <form method="POST" action="{{ route('admin.notifications.read', $notif->id) }}" style="display:inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-primary">Tandai Sudah Dibaca</button>
                                </form>
                            @else
                                <span class="badge bg-success">Sudah dibaca</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card border-0 shadow-sm text-center text-muted py-5">
                    <i class="fas fa-bell-slash fa-2x mb-2"></i>
                    <div>Tidak ada notifikasi.</div>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection
