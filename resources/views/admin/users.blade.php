@extends('admin.layouts.app')

@section('admin_page_title', 'Data Pengguna')

@section('admin_content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data Pengguna Sistem</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Tanggal Terdaftar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    {{-- Data role dan nama dihapus dari data-* karena tidak lagi dibutuhkan --}}
                    <tr data-id="{{ $user['id'] }}">
                        <td>{{ $user['id'] }}</td>
                        <td>{{ $user['nama'] }}</td>
                        <td>{{ $user['email'] }}</td>
                        <td id="user-role-{{ $user['id'] }}">
                             <span class="badge bg-{{ $user['role'] == 'Admin' ? 'info' : ($user['role'] == 'Kasir' ? 'warning' : 'secondary') }}">
                                 {{ $user['role'] }}
                             </span>
                        </td>
                        <td>{{ $user['terdaftar'] }}</td>
                        <td>
                            {{-- Hanya menyisakan tombol Hapus --}}
                            <button class="btn btn-sm btn-danger btn-delete-user" data-id="{{ $user['id'] }}">
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

{{-- Modal Edit User Role telah dihapus sesuai permintaan --}}

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        
        // HANYA menyisakan handler untuk tombol Delete (Hapus)
        document.querySelectorAll('.btn-delete-user').forEach(button => {
            button.addEventListener('click', async function() {
                const userId = this.dataset.id;
                if (!confirm(`Hapus Pengguna ID ${userId}?`)) {
                    return;
                }
                
                // Route yang dipanggil adalah /admin/users/{id} dengan method DELETE
                const url = `{{ url('/admin/users') }}/${userId}`;

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
                        alert('Gagal menghapus pengguna.');
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