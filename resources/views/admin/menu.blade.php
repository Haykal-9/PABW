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
                        <th>Deskripsi</th>
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
                        data-deskripsi="{{ $menu['deskripsi'] }}">
                        <td>{{ $menu['id'] }}</td>
                        <td>
                            <img src="{{ asset($menu['image_path']) }}" 
                                 alt="{{ $menu['nama'] }}" 
                                 style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                        </td>
                        <td>{{ $menu['nama'] }}</td>
                        <td>{{ $menu['kategori'] }}</td>
                        <td>Rp {{ number_format($menu['harga'], 0, ',', '.') }}</td>
                        <td><small>{{ Str::limit($menu['deskripsi'], 30) }}</small></td>
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
            {{-- PENTING: Tambahkan enctype="multipart/form-data" --}}
            <form id="menuForm" method="POST" action="{{ route('admin.menu.store') }}" enctype="multipart/form-data">
                @csrf
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
                            <option value="1">Kopi</option>
                            <option value="2">Non-Kopi</option>
                            <option value="3">Makanan</option>
                            <option value="4">Cemilan</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="menu-deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="menu-deskripsi" name="deskripsi" rows="3"></textarea>
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
                            <option value="1">Tersedia</option>
                            <option value="2">Habis</option>
                        </select>
                    </div>
                    
                    {{-- GANTI INPUT URL/PATH menjadi INPUT FILE --}}
                    <div class="mb-3" id="current-photo-group">
                        <label class="form-label">Foto Saat Ini</label>
                        <img src="" id="edit-current-photo" style="max-width: 150px; height: auto; display: none;" class="mb-2">
                        <p id="no-photo-text" class="text-muted small"></p>
                    </div>

                    <div class="mb-3">
                        <label for="foto_upload_input" class="form-label">Upload Foto Menu Baru</label>
                        {{-- PENTING: Nama input harus 'foto_upload' agar sesuai Controller --}}
                        <input type="file" class="form-control" id="foto_upload_input" name="foto_upload" accept="image/*">
                        <small class="text-muted">Kosongkan jika tidak ingin mengganti foto.</small>
                    </div>

                    <input type="hidden" id="menu-gambar-path-lama" name="image_path_old">
                    {{-- Input image_path (URL/Path) yang lama dihapus agar tidak konflik dengan input type=file --}}
                    
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
        
        // Elemen untuk preview foto
        const currentPhoto = document.getElementById('edit-current-photo');
        const noPhotoText = document.getElementById('no-photo-text');

        // Event listener untuk tombol 'Tambah Menu Baru'
        document.getElementById('btn-create-menu').addEventListener('click', function() {
            modalTitle.textContent = 'Tambah Menu Baru';
            form.reset(); 
            // Atur default value dan action
            form.action = '{{ route('admin.menu.store') }}';
            document.getElementById('menu-id').value = '';
            document.getElementById('menu-kategori').value = '1'; // Default ID Kopi
            document.getElementById('menu-status').value = '1'; // Default ID Tersedia
            
            // Sembunyikan preview foto lama
            currentPhoto.style.display = 'none';
            noPhotoText.textContent = '';
            
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
                const imagePath = row.dataset.imagePath;

                // Tampilkan preview foto saat ini
                if (imagePath && imagePath !== 'null' && imagePath !== 'default.jpg') {
                    // Gunakan asset() di JS hanya jika path-nya lengkap, jika tidak, tambahkan 'foto/'
                    currentPhoto.src = '{{ asset("") }}' + imagePath;
                    currentPhoto.style.display = 'block';
                    noPhotoText.textContent = '';
                } else {
                    currentPhoto.style.display = 'none';
                    noPhotoText.textContent = 'Tidak ada foto terpasang.';
                }

                // Set action untuk update
                form.action = '{{ url("/admin/menu") }}/' + row.dataset.id;
                
                // Isi field data
                document.getElementById('menu-id').value = row.dataset.id;
                document.getElementById('menu-nama').value = row.dataset.nama;
                
                // Perlu memetakan kembali nama kategori ke ID (jika form kategori menggunakan ID 1, 2, 3...)
                // Karena kita menggunakan ID di Controller, kita butuh nilai ID-nya di sini
                // Untuk kesederhanaan, kita asumsikan urutan di select sama dengan data.
                document.getElementById('menu-kategori').value = row.dataset.kategori; 
                document.getElementById('menu-harga').value = row.dataset.harga;
                document.getElementById('menu-stok').value = row.dataset.stok;
                document.getElementById('menu-status').value = row.dataset.status === 'Tersedia' ? 1 : 2; // Map status string ke ID 1/2
                document.getElementById('menu-deskripsi').value = row.dataset.deskripsi;
                
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
        
        // Fungsionalitas CREATE/UPDATE (Diperbarui untuk mendukung FILE UPLOAD)
        form.addEventListener('submit', function(e) {
            const isEdit = document.getElementById('menu-id').value !== '';
            
            if (isEdit) {
                e.preventDefault(); // Cegah form submit normal jika edit
                
                const menuId = document.getElementById('menu-id').value;
                const url = `{{ url('/admin/menu') }}/${menuId}`;

                // PENTING: Gunakan FormData untuk mengirim file biner
                const formData = new FormData(form);

                fetch(url, {
                    method: 'POST', // Menggunakan POST karena method PUT disisipkan di FormData
                    body: formData, // Kirim FormData langsung
                    // TIDAK PERLU SET HEADERS Content-Type, browser akan atur otomatis
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                })
                .then(response => {
                    if (response.ok) {
                        modal.hide();
                        window.location.reload(); 
                    } else {
                        alert('Gagal memproses menu. Pastikan semua field terisi dan format foto benar.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat memproses menu.');
                });
            } 
            // Jika tidak edit (Create), biarkan form submit secara normal (POST)
            // yang juga mendukung file upload karena ada enctype="multipart/form-data"
        });
    });
</script>
@endpush