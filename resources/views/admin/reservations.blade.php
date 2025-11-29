@extends('admin.layouts.app')

@section('admin_page_title', 'Data Reservasi')

@section('admin_content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Reservasi yang Masuk</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Tanggal/Jam</th>
                        <th>Nama Pemesan</th>
                        <th>Email</th> 
                        <th>No. Telepon</th>        
                        <th>Jml Orang</th>
                        <th>Catatan</th>            
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reservations as $res)
                    <tr data-id="{{ $res['id'] }}" data-kode="{{ $res['kode'] }}" data-status="{{ $res['status'] }}">
                        <td>{{ $res['kode'] }}</td>
                        <td>
                            {{ $res['tanggal'] }}
                            <br><small class="text-muted">({{ $res['jam'] }})</small>
                        </td>
                        <td>{{ $res['nama'] }}</td>
                        <td>{{ $res['email'] }}</td>         
                        <td>{{ $res['phone'] }}</td>         
                        <td>{{ $res['orang'] }}</td>
                        <td><small>{{ $res['note'] }}</small></td> 
                        <td id="res-status-{{ $res['id'] }}">
                            <span class="badge bg-{{ $res['status'] == 'Dikonfirmasi' ? 'success' : ($res['status'] == 'Selesai' ? 'primary' : 'warning') }}">
                                {{ $res['status'] }}
                            </span>
                        </td>
                        <td>
                            {{-- Hanya menyisakan tombol Hapus --}}
                            <button class="btn btn-sm btn-danger btn-delete-res" data-id="{{ $res['id'] }}">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Modal Edit Reservation Status telah dihapus sesuai permintaan --}}

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        
        // HANYA menyisakan handler untuk tombol Delete (Hapus)
        document.querySelectorAll('.btn-delete-res').forEach(button => {
            button.addEventListener('click', async function() {
                const resId = this.dataset.id;
                if (!confirm(`Hapus Reservasi ID ${resId}?`)) {
                    return;
                }
                
                // Perhatian: Pastikan route '/admin/reservations/{id}' dengan method DELETE
                // sudah terdaftar di routes/web.php dan memiliki fungsi di controller
                const url = `{{ url('/admin/reservations') }}/${resId}`;

                try {
                    const response = await fetch(url, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}' 
                        }
                    });

                    if (response.ok) {
                        window.location.reload(); 
                    } else {
                        alert('Gagal menghapus reservasi.');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat menghapus.');
                }
            });
        });
    });
</script>
@endpush