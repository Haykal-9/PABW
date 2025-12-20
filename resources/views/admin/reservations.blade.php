@extends('admin.layouts.app')

@section('admin_page_title', 'Daftar Reservasi')

@section('admin_content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Manajemen Reservasi</h4>
        <p class="text-muted small mb-0">Lihat dan kelola jadwal reservasi meja pelanggan.</p>
    </div>
</div>

<div class="card border-0 shadow-sm overflow-hidden">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead class="bg-light">
                <tr>
                    <th class="ps-4 py-3 text-uppercase small fw-bold text-muted">Pelanggan</th>
                    <th class="py-3 text-uppercase small fw-bold text-muted">Jadwal</th>
                    <th class="py-3 text-uppercase small fw-bold text-muted text-center">Jumlah Orang</th>
                    <th class="py-3 text-uppercase small fw-bold text-muted">Status</th>
                    <th class="py-3 text-uppercase small fw-bold text-muted text-end pe-4">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reservations as $res)
                <tr>
                    <td class="ps-4">
                        <div class="fw-bold">{{ $res['nama'] }}</div>
                        <small class="text-muted">{{ $res['phone'] }}</small>
                    </td>
                    <td>
                        <div class="small fw-bold text-dark">{{ \Carbon\Carbon::parse($res['tanggal'])->format('d M Y') }}</div>
                        <div class="text-muted small">{{ $res['jam'] }} WIB</div>
                    </td>
                    <td class="text-center">
                        <span class="badge bg-light text-dark border px-3">{{ $res['orang'] }} Orang</span>
                    </td>
                    <td>
                        @php
                            $statusClass = [
                                'Disetujui' => 'bg-success-subtle text-success border-success',
                                'Menunggu' => 'bg-warning-subtle text-warning border-warning',
                                'Dibatalkan' => 'bg-danger-subtle text-danger border-danger',
                                'Selesai' => 'bg-info-subtle text-info border-info'
                            ][$res['status'] ?? 'Menunggu'] ?? 'bg-secondary-subtle text-secondary';
                        @endphp
                        <span class="badge {{ $statusClass }} border px-3 py-2">
                            {{ $res['status'] ?? 'Menunggu' }}
                        </span>
                    </td>
                    <td class="text-end pe-4">
                        <div class="btn-group">
                            <button class="btn btn-sm btn-light border dropdown-toggle" data-bs-toggle="dropdown">
                                <i class="fas fa-cog me-1"></i> Update
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                                <li><a class="dropdown-item" href="#"><i class="fas fa-check text-success me-2"></i>Setujui</a></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-times text-danger me-2"></i>Tolak</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-muted" href="#"><i class="fas fa-trash me-2"></i>Hapus</a></li>
                            </ul>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection