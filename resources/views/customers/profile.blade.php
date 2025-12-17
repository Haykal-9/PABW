@extends('customers.layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            
            {{-- Header Profil --}}
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body d-flex align-items-center p-4">
                    <div class="me-4">
                        @if($user->profile_picture)
                            <img src="{{ asset('uploads/profile/' . $user->profile_picture) }}" 
                                 class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover;">
                        @else
                            <img src="https://via.placeholder.com/80" class="rounded-circle">
                        @endif
                    </div>
                    <div>
                        <h4 class="mb-1 fw-bold">{{ $user->nama }}</h4>
                        <p class="text-muted mb-0">{{ $user->email }}</p>
                    </div>
                    <div class="ms-auto">
                        <a href="{{ route('profile.edit', ['id' => $user->id]) }}" class="btn btn-outline-primary btn-sm me-2">
                            <i class="fas fa-edit me-1"></i> Edit Profil
                        </a>
                        <a href="/logout" class="btn btn-outline-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin logout?')">
                            <i class="fas fa-sign-out-alt me-1"></i> Logout
                        </a>
                    </div>
                </div>
            </div>

            {{-- Navigasi Tabs --}}
            <ul class="nav nav-tabs nav-fill mb-4" id="profileTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active fw-bold" id="detail-tab" data-bs-toggle="tab" data-bs-target="#detail" type="button" role="tab">
                        <i class="fas fa-user me-2"></i>Detail Profil
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-bold" id="orders-tab" data-bs-toggle="tab" data-bs-target="#orders" type="button" role="tab">
                        <i class="fas fa-shopping-bag me-2"></i>Riwayat Pesanan
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-bold" id="reservations-tab" data-bs-toggle="tab" data-bs-target="#reservations" type="button" role="tab">
                        <i class="fas fa-calendar-alt me-2"></i>Reservasi
                    </button>
                </li>
            </ul>

            {{-- Isi Tabs --}}
            <div class="tab-content" id="profileTabsContent">
                
                {{-- TAB 1: Detail Profil --}}
                <div class="tab-pane fade show active" id="detail" role="tabpanel">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h5 class="card-title mb-4">Informasi Pribadi</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="text-muted small fw-bold">Username</label>
                                    <p class="fs-5">{{ $user->username }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="text-muted small fw-bold">No. Telepon</label>
                                    <p class="fs-5">{{ $user->no_telp }}</p>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="text-muted small fw-bold">Alamat</label>
                                    <p class="fs-5">{{ $user->alamat }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="text-muted small fw-bold">Bergabung Sejak</label>
                                    <p class="fs-5">{{ $user->created_at ? $user->created_at->format('d M Y') : '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- TAB 2: Riwayat Pesanan --}}
                <div class="tab-pane fade" id="orders" role="tabpanel">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            @if($riwayatPesanan->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th>ID Order</th>
                                                <th>Tanggal</th>
                                                <th>Total</th>
                                                <th>Status</th>
                                                <th>Metode</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($riwayatPesanan as $order)
                                            <tr>
                                                <td>#{{ $order->id }}</td>
                                                <td>{{ \Carbon\Carbon::parse($order->order_date)->format('d M Y H:i') }}</td>
                                                <td class="fw-bold text-primary">
                                                    Rp {{ number_format($order->details->sum(function($detail) {
                                                        return $detail->price_per_item * $detail->quantity;
                                                    }), 0, ',', '.') }}
                                                </td>
                                                <td>
                                                    <span class="badge bg-{{ $order->status_id == 1 ? 'success' : ($order->status_id == 2 ? 'warning' : 'danger') }}">
                                                        {{ $order->status->status_name ?? '-' }}
                                                    </span>
                                                </td>
                                                <td>{{ $order->paymentMethod->method_name ?? 'Cash' }}</td>
                                                <td>
                                                    <a href="{{ route('profile.order.show', ['userId' => Auth::id(), 'orderId' => $order->id]) }}" 
                                                       class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-eye me-1"></i> Detail
                                                    </a>
                                                    @if($order->status_id == 2)
                                                        <form action="{{ route('profile.order.cancel', ['userId' => Auth::id(), 'orderId' => $order->id]) }}" 
                                                              method="POST" 
                                                              class="d-inline"
                                                              onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?')">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                                <i class="fas fa-times me-1"></i> Batal
                                                            </button>
                                                        </form>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-5">
                                    <p class="text-muted">Belum ada riwayat pesanan.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- TAB 3: Reservasi (Split: Ongoing & History) --}}
                <div class="tab-pane fade" id="reservations" role="tabpanel">
                    
                    {{-- Section 1: Reservasi Akan Datang  --}}
                    <div class="card shadow-sm border-0 mb-4 bg-primary-subtle">
                        <div class="card-header bg-primary text-white">
                            <h6 class="mb-0"><i class="fas fa-clock me-2"></i>Reservasi Akan Datang (Ongoing)</h6>
                        </div>
                        <div class="card-body">
                            @if($reservasiOngoing->count() > 0)
                                <div class="row">
                                    @foreach($reservasiOngoing as $res)
                                    <div class="col-md-6 mb-3">
                                        <div class="card border-primary h-100">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between mb-2">
                                                    <span class="badge bg-primary">{{ $res->kode_reservasi }}</span>
                                                    <span class="badge bg-warning text-dark">{{ $res->status->status_name ?? 'Pending' }}</span>
                                                </div>
                                                <h5 class="card-title text-primary">
                                                    {{ \Carbon\Carbon::parse($res->tanggal_reservasi)->format('d M Y, H:i') }} WIB
                                                </h5>
                                                <p class="card-text mb-1"><i class="fas fa-users me-2"></i> {{ $res->jumlah_orang }} Orang</p>
                                                <p class="card-text small text-muted">Note: {{ $res->message }}</p>
                                                
                                                {{-- Tombol Batalkan Reservasi --}}
                                                @if($res->status_id != 3)
                                                    <form method="POST" action="{{ route('profile.reservation.cancel', ['userId' => $user->id, 'reservationId' => $res->id]) }}" 
                                                          class="mt-3" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan reservasi ini?');">
                                                        @csrf
                                                        <button type="submit" class="btn btn-danger btn-sm w-100">
                                                            <i class="fas fa-times-circle me-1"></i> Batalkan Reservasi
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-muted mb-0">Tidak ada reservasi yang sedang berjalan.</p>
                            @endif
                        </div>
                    </div>

                    {{-- Section 2: Riwayat Reservasi --}}
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white">
                            <h6 class="mb-0">Riwayat Reservasi Sebelumnya</h6>
                        </div>
                        <div class="card-body">
                            @if($reservasiRiwayat->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-sm table-hover">
                                        <thead>
                                            <tr>
                                                <th>Kode</th>
                                                <th>Tanggal</th>
                                                <th>Jml Orang</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($reservasiRiwayat as $res)
                                            <tr>
                                                <td>{{ $res->kode_reservasi }}</td>
                                                <td>{{ \Carbon\Carbon::parse($res->tanggal_reservasi)->format('d M Y') }}</td>
                                                <td>{{ $res->jumlah_orang }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $res->status_id == 2 ? 'success' : 'secondary' }}">
                                                        {{ $res->status->status_name ?? '-' }}
                                                    </span>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-muted text-center py-3">Belum ada riwayat reservasi.</p>
                            @endif
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

@endsection