@extends('admin.layouts.app')

@section('admin_page_title', 'Daftar Menu')

@section('admin_content')

{{-- Tombol Tambah Menu --}}
<div class="d-flex justify-content-end mb-3">
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#menuModal" id="btn-create-menu">
        <i class="fas fa-plus me-1"></i> Tambah Menu Baru
    </button>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data Daftar Menu</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Gambar</th>
                        <th>Nama Menu</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($menus as $menu)
                    <tr id="menu-row-{{ $menu['id'] }}" 
                        data-id="{{ $menu['id'] }}" 
                        data-nama="{{ $menu['nama'] }}" 
                        data-kategori="{{ $menu['kategori'] }}" 
                        data-harga="{{ $menu['harga'] }}" 
                        data-stok="{{ $menu['stok'] }}" 
                        data-status="{{ $menu['status'] }}" 
                        data-image-path="{{ $menu['image_path'] }}">
                        <td>{{ $menu['id'] }}</td>
                        <td>
                            <img src="{{ asset($menu['image_path']) }}" 
                                 alt="{{ $menu['nama'] }}" 
                                 style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                        </td>
                        <td>{{ $menu['nama'] }}</td>
                        <td>{{ $menu['kategori'] }}</td>
                        <td>Rp {{ number_format($menu['harga'], 0, ',', '.') }}</td>
                        <td>{{ $menu['stok'] }}</td>
                        <td>
                            <span class="badge bg-{{ $menu['status'] == 'Tersedia' ? 'success' : 'danger' }}">
                                {{ $menu['status'] }}
                            </span>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-warning btn-edit" data-bs-toggle="modal" data-bs-target="#menuModal">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="btn btn-sm btn-danger btn-delete" data-id="{{ $menu['id'] }}">
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

{{-- Modal Tambah/Edit Menu --}}
<div class="modal fade" id="menuModal" tabindex="-1" aria-labelledby="menuModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="menuModalLabel">Tambah/Edit Menu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="menuForm" method="POST">
                <div class="modal-body">
                    <input type="hidden" id="menu-id" name="id">
                    
                    <div class="mb-3">
                        <label for="menu-nama" class="form-label">Nama Menu</label>
                        <input type="text" class="form-control" id="menu-nama" name="nama" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="menu-kategori" class="form-label">Kategori</label>
                        <select class="form-control" id="menu-kategori" name="kategori" required>
                            <option value="">Pilih Kategori</option>
                            <option value="Kopi">Kopi</option>
                            <option value="Non-Kopi">Non-Kopi</option>
                            <option value="Makanan">Makanan</option>
                            <option value="Cemilan">Cemilan</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="menu-harga" class="form-label">Harga (Rp)</label>
                        <input type="number" class="form-control" id="menu-harga" name="harga" required min="0">
                    </div>
                    
                    <div class="mb-3">
                        <label for="menu-stok" class="form-label">Stok</label>
                        <input type="number" class="form-control" id="menu-stok" name="stok" required min="0">
                    </div>
                    
                    <div class="mb-3">
                        <label for="menu-status" class="form-label">Status</label>
                        <select class="form-control" id="menu-status" name="status" required>
                            <option value="Tersedia">Tersedia</option>
                            <option value="Habis">Habis</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="menu-gambar" class="form-label">Gambar URL/Path</label>
                        <input type="text" class="form-control" id="menu-gambar" name="image_path" placeholder="e.g. foto/nama_file.jpg" required>
                    </div>
                    
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
    document.addEventListener('DOMContentLoaded', function() {
        const menuModalEl = document.getElementById('menuModal');
        const modalTitle = document.getElementById('menuModalLabel');
        const form = document.getElementById('menuForm');
        const modal = new bootstrap.Modal(menuModalEl);

        // Event listener untuk tombol 'Tambah Menu Baru'
        document.getElementById('btn-create-menu').addEventListener('click', function() {
            modalTitle.textContent = 'Tambah Menu Baru';
            form.reset(); 
            document.getElementById('menu-id').value = '';
            document.getElementById('menu-kategori').value = '';
            document.getElementById('menu-status').value = 'Tersedia';
            document.getElementById('menu-gambar').value = 'foto/'; 
        });

        // Event listener untuk tombol 'Edit'
        document.querySelectorAll('.btn-edit').forEach(button => {
            button.addEventListener('click', function() {
                modalTitle.textContent = 'Edit Menu';
                
                const row = this.closest('tr');
                document.getElementById('menu-id').value = row.dataset.id;
                document.getElementById('menu-nama').value = row.dataset.nama;
                document.getElementById('menu-kategori').value = row.dataset.kategori;
                document.getElementById('menu-harga').value = row.dataset.harga;
                document.getElementById('menu-stok').value = row.dataset.stok;
                document.getElementById('menu-status').value = row.dataset.status;
                document.getElementById('menu-gambar').value = row.dataset.imagePath;
            });
        });

        // Fungsionalitas DELETE (menggunakan fetch dengan method DELETE)
        document.querySelectorAll('.btn-delete').forEach(button => {
            button.addEventListener('click', async function() {
                const menuId = this.dataset.id;
                // Hanya gunakan konfirmasi, tanpa alert setelahnya
                if (!confirm(`Hapus Menu ID ${menuId}?`)) {
                    return;
                }
                
                const url = `{{ url('/admin/menu') }}/${menuId}`;

                try {
                    const response = await fetch(url, {
                        method: 'DELETE', 
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}' 
                        }
                    });

                    // Cek status response saja, tidak perlu memproses data.json jika tidak diperlukan
                    if (response.ok) {
                        // HANYA RELOAD SETELAH SUKSES
                        window.location.reload(); 
                    } else {
                        // Jika gagal, tampilkan pesan error minimal
                        alert('Gagal menghapus.');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat menghapus.');
                }
            });
        });

        // Fungsionalitas CREATE/UPDATE (menggunakan fetch)
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            const menuId = document.getElementById('menu-id').value;
            const isEdit = menuId !== '';
            
            let url;
            let method;

            if (isEdit) {
                url = `{{ url('/admin/menu') }}/${menuId}`;
                method = 'PUT'; 
            } else {
                url = '{{ route('admin.menu.store') }}';
                method = 'POST';
            }
            
            const formData = new FormData(form);
            
            // Konversi FormData ke objek JSON
            const body = {};
            formData.forEach((value, key) => {
                if (key !== '_method') { 
                    body[key] = value;
                }
            });

            body._token = '{{ csrf_token() }}';
            if (isEdit) {
                body.id = parseInt(menuId);
            }

            try {
                const response = await fetch(url, {
                    method: method, 
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(body)
                });
                
                // Cek status response saja
                if (response.ok) {
                    modal.hide();
                    // HANYA RELOAD SETELAH SUKSES
                    window.location.reload(); 
                } else {
                    // Jika gagal, tampilkan pesan error minimal
                    alert('Gagal memproses menu.');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat memproses menu.');
            }
        });
    });
</script>
@endpush