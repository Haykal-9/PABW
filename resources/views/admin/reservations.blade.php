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
                        <th>Aksi</th> {{-- KOLOM BARU --}}
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
                            <button class="btn btn-sm btn-info btn-edit-res" data-bs-toggle="modal" data-bs-target="#resModal">
                                <i class="fas fa-sync"></i> Ubah Status
                            </button>
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

{{-- Modal Edit Reservation Status --}}
<div class="modal fade" id="resModal" tabindex="-1" aria-labelledby="resModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="resModalLabel">Ubah Status Reservasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="resForm">
                <div class="modal-body">
                    <input type="hidden" id="res-id" name="id">
                    <p>Mengubah status untuk kode: <strong id="res-kode-display"></strong></p>
                    
                    <div class="mb-3">
                        <label for="res-status" class="form-label">Pilih Status Baru</label>
                        <select class="form-control" id="res-status" name="status" required>
                            <option value="Menunggu Konfirmasi">Menunggu Konfirmasi</option>
                            <option value="Dikonfirmasi">Dikonfirmasi</option>
                            <option value="Selesai">Selesai</option>
                            <option value="Dibatalkan">Dibatalkan</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const resModalEl = document.getElementById('resModal');
        const resForm = document.getElementById('resForm');
        const modal = new bootstrap.Modal(resModalEl);

        // Edit Status Button Handler
        document.querySelectorAll('.btn-edit-res').forEach(button => {
            button.addEventListener('click', function() {
                const row = this.closest('tr');
                const resId = row.dataset.id;
                const resKode = row.dataset.kode;
                const currentStatus = row.dataset.status;

                document.getElementById('res-id').value = resId;
                document.getElementById('res-kode-display').textContent = resKode;
                document.getElementById('res-status').value = currentStatus;
            });
        });

        // Submit Form Handler (Update Status)
        resForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            const resId = document.getElementById('res-id').value;
            const newStatus = document.getElementById('res-status').value;
            const url = `{{ url('/admin/reservations') }}/${resId}`;
            
            const body = {
                _token: '{{ csrf_token() }}',
                status: newStatus
            };

            try {
                const response = await fetch(url, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(body)
                });

                if (response.ok) {
                    modal.hide();
                    window.location.reload(); 
                } else {
                    alert('Gagal memperbarui status reservasi.');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat memproses status reservasi.');
            }
        });

        // Delete Button Handler
        document.querySelectorAll('.btn-delete-res').forEach(button => {
            button.addEventListener('click', async function() {
                const resId = this.dataset.id;
                if (!confirm(`Hapus Reservasi ID ${resId}?`)) {
                    return;
                }
                
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