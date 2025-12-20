@extends('admin.layouts.app')

@section('admin_page_title', 'Data Pengguna')

@section('admin_content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Data Pengguna Sistem</h4>
        <p class="text-muted small mb-0">Kelola seluruh akun pengguna aplikasi.</p>
    </div>
    <div class="d-flex gap-2">
        <button class="btn btn-primary shadow-sm px-3" data-bs-toggle="modal" data-bs-target="#modalAddUser">
            <i class="fas fa-plus me-1"></i> Tambah User
        </button>
    </div>
</div>

<div class="card border-0 shadow-sm overflow-hidden">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead class="bg-light">
                <tr>
                    <!-- <th class="ps-4 py-3 text-uppercase small fw-bold text-muted">ID</th> -->
                    <th class="py-3 text-uppercase small fw-bold text-muted">Nama</th>
                    <th class="py-3 text-uppercase small fw-bold text-muted">Email</th>
                    <th class="py-3 text-uppercase small fw-bold text-muted">Role</th>
                    <th class="py-3 text-uppercase small fw-bold text-muted">Tanggal Terdaftar</th>
                    <th class="py-3 text-uppercase small fw-bold text-muted text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr data-id="{{ $user['id'] }}">
                    <!-- ID tidak ditampilkan -->
                    <td>
                        <div class="fw-bold">{{ $user['nama'] }}</div>
                    </td>
                    <td>
                        <div class="small text-dark">{{ $user['email'] }}</div>
                    </td>
                    <td>
                        <span class="badge bg-{{ $user['role'] == 'Admin' ? 'info' : ($user['role'] == 'Kasir' ? 'warning' : 'secondary') }} px-3 py-2">
                            {{ $user['role'] }}
                        </span>
                    </td>
                    <td>
                        <span class="small text-muted">{{ $user['terdaftar'] }}</span>
                    </td>
                    <td class="text-center">
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

{{-- Modal Tambah User Baru --}}
<div class="modal fade" id="modalAddUser" tabindex="-1" aria-labelledby="modalAddUserLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAddUserLabel">Tambah User Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="role_id" class="form-label">Role <span class="text-danger">*</span></label>
                            <select class="form-select" id="role_id" name="role_id" required>
                                <option value="">Pilih Role</option>
                                <option value="1">Admin</option>
                                <option value="2">Kasir</option>
                                <option value="3">Member/Customer</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="username" name="username" maxlength="50" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="password" name="password" minlength="8" required>
                            <small class="text-muted">Minimal 8 karakter</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" minlength="8" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nama" name="nama" maxlength="100" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="email" name="email" maxlength="100" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="no_telp" class="form-label">No. Telepon</label>
                            <input type="text" class="form-control" id="no_telp" name="no_telp" maxlength="20">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="gender_id" class="form-label">Gender</label>
                            <select class="form-select" id="gender_id" name="gender_id">
                                <option value="">Pilih Gender</option>
                                <option value="1">Laki-laki</option>
                                <option value="2">Perempuan</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="3"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="profile_picture" class="form-label">Foto Profil</label>
                        <input type="file" class="form-control" id="profile_picture" name="profile_picture" accept="image/*">
                        <small class="text-muted">Format: JPG, PNG, JPEG. Max 2MB</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan User</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        
        // Handler untuk tombol Delete (Hapus)
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
                    } else if (response.status === 403) {
                        alert('Tidak dapat menghapus akun sendiri!');
                    } else {
                        alert('Gagal menghapus pengguna.');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat menghapus.');
                }
            });
        });

        // Validasi password confirmation
        const passwordForm = document.querySelector('#modalAddUser form');
        if (passwordForm) {
            passwordForm.addEventListener('submit', function(e) {
                const password = document.getElementById('password').value;
                const confirmation = document.getElementById('password_confirmation').value;
                
                if (password !== confirmation) {
                    e.preventDefault();
                    alert('Password dan Konfirmasi Password tidak sama!');
                    return false;
                }
            });
        }
    });
</script>
@endpush