@extends('kasir.layouts.app')

@push('styles')
    <style>
        .table-container {
            background-color: var(--card-bg);
            padding: 1.5rem;
            border-radius: 0.75rem;
            border: 1px solid var(--border-color);
        }

        .table-controls {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .form-control,
        .form-select {
            background-color: var(--sidebar-bg);
            color: var(--text-color);
            border: 1px solid var(--border-color);
        }

        .form-control::placeholder {
            color: var(--text-muted-color);
        }

        .form-control:focus,
        .form-select:focus {
            background-color: var(--sidebar-bg);
            color: var(--text-color);
            border-color: var(--accent-color);
            box-shadow: 0 0 0 0.25rem rgba(232, 123, 62, 0.25);
        }

        .table {
            --bs-table-bg: transparent;
            --bs-table-border-color: var(--border-color);
            --bs-table-striped-bg: rgba(255, 255, 255, 0.05);
            --bs-table-hover-bg: rgba(255, 255, 255, 0.075);
        }

        .table td,
        .table th {
            color: var(--text-color);
            vertical-align: middle;
        }

        .table thead th {
            color: var(--text-muted-color);
        }

        .menu-image {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 0.5rem;
            border: 2px solid var(--border-color);
        }

        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            font-weight: 600;
        }

        .status-tersedia {
            background-color: rgba(40, 167, 69, 0.2);
            color: #28a745;
        }

        .status-habis {
            background-color: rgba(220, 53, 69, 0.2);
            color: #dc3545;
        }

        .modal-content {
            background-color: var(--card-bg);
            color: var(--text-color);
        }

        .modal-header {
            border-bottom-color: var(--border-color);
        }

        .modal-footer {
            border-top-color: var(--border-color);
        }

        .btn-close {
            filter: invert(1);
        }

        @media (max-width: 992px) {
            .table-controls {
                flex-direction: column;
                gap: 1rem;
                align-items: stretch;
            }
        }
    </style>
@endpush

@section('content')
    <main class="content">
        <div class="header">
            <h1>Manajemen Menu</h1>
            <p>Kelola daftar menu: tambah, edit, hapus, dan ubah status.</p>
        </div>

        {{-- Flash Messages --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Add Menu Button --}}
        <div class="d-flex justify-content-end mb-3">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#menuModal" id="btn-create-menu">
                <i class="bi bi-plus-circle me-1"></i> Tambah Menu Baru
            </button>
        </div>

        {{-- Menu Table --}}
        <div class="table-container">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Gambar</th>
                            <th>Nama Menu</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Deskripsi</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($menus as $menu)
                            <tr data-id="{{ $menu['id'] }}" data-nama="{{ $menu['nama'] }}"
                                data-kategori="{{ $menu['type_id'] }}" data-harga="{{ $menu['harga'] }}"
                                data-status="{{ $menu['status_id'] }}" data-image-path="{{ $menu['image_path'] }}"
                                data-deskripsi="{{ $menu['deskripsi'] }}">
                                <td>{{ $menu['id'] }}</td>
                                <td>
                                    @if($menu['image_path'])
                                        <img src="{{ asset($menu['image_path']) }}" alt="{{ $menu['nama'] }}" class="menu-image">
                                    @else
                                        <div class="menu-image d-flex align-items-center justify-content-center"
                                            style="background-color: var(--sidebar-bg);">
                                            <i class="bi bi-image text-muted"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>{{ $menu['nama'] }}</td>
                                <td>{{ $menu['kategori'] }}</td>
                                <td>Rp {{ number_format($menu['harga'], 0, ',', '.') }}</td>
                                <td><small>{{ Str::limit($menu['deskripsi'], 30) }}</small></td>
                                <td>
                                    <span class="status-badge status-{{ strtolower($menu['status']) }}">
                                        {{ $menu['status'] }}
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-warning btn-edit" data-bs-toggle="modal"
                                        data-bs-target="#menuModal">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger btn-delete" data-id="{{ $menu['id'] }}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">Tidak ada menu tersedia.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    {{-- Modal Add/Edit Menu --}}
    <div class="modal fade" id="menuModal" tabindex="-1" aria-labelledby="menuModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="menuModalLabel">Tambah/Edit Menu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="menuForm" method="POST" action="{{ route('kasir.menu.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="menu-id" name="id">

                        <div class="mb-3">
                            <label for="menu-nama" class="form-label">Nama Menu <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="menu-nama" name="nama" required>
                        </div>

                        <div class="mb-3">
                            <label for="menu-kategori" class="form-label">Kategori <span
                                    class="text-danger">*</span></label>
                            <select class="form-control" id="menu-kategori" name="kategori" required>
                                <option value="">Pilih Kategori</option>
                                <option value="1">Kopi</option>
                                <option value="2">Minuman Non-Kopi</option>
                                <option value="3">Makanan Berat</option>
                                <option value="4">Cemilan</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="menu-deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="menu-deskripsi" name="deskripsi" rows="3"></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="menu-harga" class="form-label">Harga (Rp) <span
                                        class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="menu-harga" name="harga" required min="0">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="menu-status" class="form-label">Status <span
                                        class="text-danger">*</span></label>
                                <select class="form-control" id="menu-status" name="status" required>
                                    <option value="1">Tersedia</option>
                                    <option value="2">Habis</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3" id="current-photo-group">
                            <label class="form-label">Foto Saat Ini</label>
                            <div>
                                <img src="" id="edit-current-photo"
                                    style="max-width: 150px; height: auto; display: none; border-radius: 0.5rem;"
                                    class="mb-2">
                                <p id="no-photo-text" class="text-muted small"></p>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="foto_upload_input" class="form-label">Upload Foto Menu Baru</label>
                            <input type="file" class="form-control" id="foto_upload_input" name="foto_upload"
                                accept="image/*">
                            <small class="text-muted">Kosongkan jika tidak ingin mengganti foto.</small>
                        </div>

                        <input type="hidden" id="menu-gambar-path-lama" name="image_path_old">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" id="modal-save-btn">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const menuModalEl = document.getElementById('menuModal');
            const modalTitle = document.getElementById('menuModalLabel');
            const form = document.getElementById('menuForm');
            const modal = new bootstrap.Modal(menuModalEl);

            const currentPhoto = document.getElementById('edit-current-photo');
            const noPhotoText = document.getElementById('no-photo-text');

            // Event listener for 'Add Menu' button
            document.getElementById('btn-create-menu').addEventListener('click', function () {
                modalTitle.textContent = 'Tambah Menu Baru';
                form.reset();
                form.action = '{{ route('kasir.menu.store') }}';
                document.getElementById('menu-id').value = '';
                document.getElementById('menu-kategori').value = '';
                document.getElementById('menu-status').value = '1';

                currentPhoto.style.display = 'none';
                noPhotoText.textContent = '';

                const methodField = document.querySelector('#menuForm input[name="_method"][value="PUT"]');
                if (methodField) {
                    methodField.remove();
                }
            });

            // Event listener for 'Edit' buttons
            document.querySelectorAll('.btn-edit').forEach(button => {
                button.addEventListener('click', function () {
                    modalTitle.textContent = 'Edit Menu';

                    const row = this.closest('tr');
                    const imagePath = row.dataset.imagePath;

                    if (imagePath && imagePath !== 'null') {
                        currentPhoto.src = '{{ asset("") }}' + imagePath;
                        currentPhoto.style.display = 'block';
                        noPhotoText.textContent = '';
                    } else {
                        currentPhoto.style.display = 'none';
                        noPhotoText.textContent = 'Tidak ada foto terpasang.';
                    }

                    form.action = '{{ url("/kasir/menu") }}/' + row.dataset.id;

                    document.getElementById('menu-id').value = row.dataset.id;
                    document.getElementById('menu-nama').value = row.dataset.nama;
                    document.getElementById('menu-kategori').value = row.dataset.kategori;
                    document.getElementById('menu-harga').value = row.dataset.harga;
                    document.getElementById('menu-status').value = row.dataset.status;
                    document.getElementById('menu-deskripsi').value = row.dataset.deskripsi;

                    let methodField = document.querySelector('#menuForm input[name="_method"][value="PUT"]');
                    if (!methodField) {
                        methodField = document.createElement('input');
                        methodField.setAttribute('type', 'hidden');
                        methodField.setAttribute('name', '_method');
                        methodField.setAttribute('value', 'PUT');
                        form.appendChild(methodField);
                    }
                });
            });

            // Delete functionality
            document.querySelectorAll('.btn-delete').forEach(button => {
                button.addEventListener('click', async function () {
                    const menuId = this.dataset.id;
                    const menuName = this.closest('tr').dataset.nama;

                    if (!confirm(`Hapus menu "${menuName}"?`)) {
                        return;
                    }

                    const url = `{{ url('/kasir/menu') }}/${menuId}`;

                    try {
                        const response = await fetch(url, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        });

                        if (response.ok) {
                            window.location.reload();
                        } else {
                            alert('Gagal menghapus menu.');
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat menghapus menu.');
                    }
                });
            });

            // Form submit for CREATE/UPDATE
            form.addEventListener('submit', function (e) {
                const isEdit = document.getElementById('menu-id').value !== '';

                if (isEdit) {
                    e.preventDefault();

                    const menuId = document.getElementById('menu-id').value;
                    const url = `{{ url('/kasir/menu') }}/${menuId}`;

                    const formData = new FormData(form);

                    fetch(url, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                    })
                        .then(response => {
                            if (response.ok) {
                                modal.hide();
                                window.location.reload();
                            } else {
                                alert('Gagal memproses menu. Pastikan semua field terisi dengan benar.');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Terjadi kesalahan saat memproses menu.');
                        });
                }
            });
        });
    </script>
@endpush