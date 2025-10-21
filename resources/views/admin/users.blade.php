@extends('admin.layouts.app')

@section('title', 'Daftar User')

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
                        <th>Aksi</th> {{-- KOLOM BARU --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr data-id="{{ $user['id'] }}" data-nama="{{ $user['nama'] }}" data-role="{{ $user['role'] }}">
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
                            <button class="btn btn-sm btn-warning btn-edit-user" data-bs-toggle="modal" data-bs-target="#userModal">
                                <i class="fas fa-edit"></i> Edit Role
                            </button>
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

{{-- Modal Edit User Role --}}
<div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalLabel">Edit Peran Pengguna</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="userForm">
                <div class="modal-body">
                    <input type="hidden" id="user-id" name="id">
                    <p>Mengedit peran untuk: <strong id="user-nama-display"></strong></p>
                    
                    <div class="mb-3">
                        <label for="user-role" class="form-label">Pilih Peran Baru</label>
                        <select class="form-control" id="user-role" name="role" required>
                            <option value="Customer">Customer</option>
                            <option value="Kasir">Kasir</option>
                            <option value="Admin">Admin</option>
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
        const userModalEl = document.getElementById('userModal');
        const userForm = document.getElementById('userForm');
        const modal = new bootstrap.Modal(userModalEl);

        // Edit Button Handler
        document.querySelectorAll('.btn-edit-user').forEach(button => {
            button.addEventListener('click', function() {
                const row = this.closest('tr');
                const userId = row.dataset.id;
                const userName = row.dataset.nama;
                const currentRole = row.dataset.role;

                document.getElementById('user-id').value = userId;
                document.getElementById('user-nama-display').textContent = userName;
                document.getElementById('user-role').value = currentRole;
            });
        });

        // Submit Form Handler (Update Role)
        userForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            const userId = document.getElementById('user-id').value;
            const newRole = document.getElementById('user-role').value;
            const url = `{{ url('/admin/users') }}/${userId}`;
            
            const body = {
                _token: '{{ csrf_token() }}',
                role: newRole
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
                    alert('Gagal memperbarui peran.');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat memproses peran.');
            }
        });

        // Delete Button Handler
        document.querySelectorAll('.btn-delete-user').forEach(button => {
            button.addEventListener('click', async function() {
                const userId = this.dataset.id;
                if (!confirm(`Hapus Pengguna ID ${userId}?`)) {
                    return;
                }
                
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