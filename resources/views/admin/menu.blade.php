@extends('admin.layouts.app')

@section('admin_page_title', 'Daftar Menu')

@section('admin_content')

{{-- Tambahkan notifikasi flash message di atas tabel --}}
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
                        <th>Deskripsi</th> {{-- <<< BARU: KOLOM DESKRIPSI --}}
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
                        data-image-path="{{ $menu['image_path'] }}"
                        data-deskripsi="{{ $menu['deskripsi'] }}"> {{-- <<< BARU: DATA DESKRIPSI --}}
                        <td>{{ $menu['id'] }}</td>
                        <td>
                            <img src="{{ asset($menu['image_path']) }}" 
                                 alt="{{ $menu['nama'] }}" 
                                 style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                        </td>
                        <td>{{ $menu['nama'] }}</td>
                        <td>{{ $menu['kategori'] }}</td>
                        <td>Rp {{ number_format($menu['harga'], 0, ',', '.') }}</td>
                        <td><small>{{ Str::limit($menu['deskripsi'], 30) }}</small></td> {{-- <<< BARU: TAMPILKAN DESKRIPSI --}}
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
            <form id="menuForm" method="POST" action="{{ route('admin.menu.store') }}">
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
                        <label for="menu-deskripsi" class="form-label">Deskripsi</label> {{-- <<< BARU: LABEL DESKRIPSI --}}
                        <textarea class="form-control" id="menu-deskripsi" name="deskripsi" rows="3"></textarea> {{-- <<< BARU: INPUT DESKRIPSI --}}
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
            // Atur default value dan action
            form.action = '{{ route('admin.menu.store') }}';
            document.getElementById('menu-id').value = '';
            document.getElementById('menu-kategori').value = '';
            document.getElementById('menu-status').value = 'Tersedia';
            document.getElementById('menu-gambar').value = 'foto/'; 
            // Hapus field _method PUT jika ada
            const methodField = document.querySelector('#menuForm input[name="_method"][value="PUT"]');
            if (methodField) {
                methodField.remove();
            }
        });

        // Event listener untuk tombol 'Edit'
        document.querySelectorAll('.btn-edit').forEach(button => {
            button.addEventListener('click', function() {
                modalTitle.textContent = 'Edit Menu';
                
                const row = this.closest('tr');
                // Set action untuk update (akan di override oleh JS submit handler)
                form.action = '{{ url("/admin/menu") }}/' + row.dataset.id;
                
                document.getElementById('menu-id').value = row.dataset.id;
                document.getElementById('menu-nama').value = row.dataset.nama;
                document.getElementById('menu-kategori').value = row.dataset.kategori;
                document.getElementById('menu-harga').value = row.dataset.harga;
                document.getElementById('menu-stok').value = row.dataset.stok;
                document.getElementById('menu-status').value = row.dataset.status;
                document.getElementById('menu-gambar').value = row.dataset.imagePath;
                document.getElementById('menu-deskripsi').value = row.dataset.deskripsi; // <<< BARU: Isi deskripsi saat edit
                
                // Tambahkan field tersembunyi untuk method PUT
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

        // Fungsionalitas DELETE (tetap menggunakan fetch untuk kemudahan)
        document.querySelectorAll('.btn-delete').forEach(button => {
            button.addEventListener('click', async function() {
                const menuId = this.dataset.id;
                if (!confirm(`Hapus Menu ID ${menuId}?`)) {
                    return;
                }
                
                const url = `{{ url('/admin/menu') }}/${menuId}`;

                try {
                    const response = await fetch(url, {
                        method: 'DELETE', 
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}' 
                        }
                    });

                    // Cek status response saja (204 No Content adalah sukses)
                    if (response.ok) {
                        window.location.reload(); 
                    } else {
                        alert('Gagal menghapus.');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat menghapus.');
                }
            });
        });
        
        // Fungsionalitas CREATE/UPDATE (Menggunakan form submit standar)
        // Kita hanya perlu memastikan form disubmit, laravel akan menangani redirect.
        form.addEventListener('submit', function(e) {
            // Jika kita menggunakan method PUT, kita perlu mencegah submit normal
            // dan menggunakan fetch, karena browser tidak mendukung PUT/DELETE secara langsung
            const isEdit = document.getElementById('menu-id').value !== '';
            
            if (isEdit) {
                e.preventDefault(); // Cegah form submit normal jika edit
                
                const menuId = document.getElementById('menu-id').value;
                const url = `{{ url('/admin/menu') }}/${menuId}`;

                const bodyParams = new URLSearchParams(new FormData(form));

                // Eksekusi PUT menggunakan Fetch API
                fetch(url, {
                    method: 'POST', // Kirim sebagai POST, tapi _method=PUT sudah ada di form data
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: bodyParams.toString()
                })
                .then(response => {
                    if (response.ok) {
                        // Jika sukses (redirect/204), reload halaman
                        modal.hide();
                        window.location.reload(); 
                    } else {
                        alert('Gagal memproses menu. Pastikan semua field terisi.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat memproses menu.');
                });
            } 
            // Jika tidak edit (Create), biarkan form submit secara normal (POST)
            // Controller akan menangani redirect dengan pesan sukses.
        });
    });
</script>
@endpush