@extends('admin.layouts.app')

@section('admin_page_title', 'Manajemen Menu')

@section('admin_content')

{{-- Notifikasi Flash Message --}}
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Daftar Menu</h4>
        <p class="text-muted small mb-0">Kelola item makanan dan minuman di sistem Anda.</p>
    </div>
    <button type="button" class="btn btn-primary shadow-sm px-4" data-bs-toggle="modal" data-bs-target="#menuModal" id="btn-create-menu">
        <i class="fas fa-plus me-2"></i> Tambah Menu Baru
    </button>
</div>

<div class="card border-0 shadow-sm overflow-hidden">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead class="bg-light">
                <tr>
                    <th class="ps-4 py-3 text-uppercase small fw-bold text-muted" style="letter-spacing: 1px;">Info Menu</th>
                    <th class="py-3 text-uppercase small fw-bold text-muted" style="letter-spacing: 1px;">Kategori</th>
                    <th class="py-3 text-uppercase small fw-bold text-muted" style="letter-spacing: 1px;">Harga</th>
                    <th class="py-3 text-uppercase small fw-bold text-muted" style="letter-spacing: 1px;">Status</th>
                    <th class="py-3 text-uppercase small fw-bold text-muted text-end pe-4" style="letter-spacing: 1px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($menus as $menu)
                <tr id="menu-row-{{ $menu['id'] }}" 
                    data-id="{{ $menu['id'] }}" 
                    data-nama="{{ $menu['nama'] }}" 
                    data-kategori-id="{{ $menu['kategori_id'] }}"
                    data-harga="{{ $menu['harga'] }}" 
                    data-status="{{ $menu['status'] }}" 
                    data-image-path="{{ $menu['image_path'] }}"
                    data-deskripsi="{{ $menu['deskripsi'] }}">
                    <td class="ps-4">
                        <div class="d-flex align-items-center">
                            <img src="{{ asset($menu['image_path']) }}" 
                                 alt="{{ $menu['nama'] }}" 
                                 class="rounded-3 me-3"
                                 style="width: 50px; height: 50px; object-fit: cover;">
                            <div>
                                <h6 class="mb-0 fw-bold">{{ $menu['nama'] }}</h6>
                                <small class="text-muted">{{ Str::limit($menu['deskripsi'], 35) }}</small>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="badge bg-light text-dark border px-3 py-2 fw-medium">{{ $menu['kategori'] }}</span>
                    </td>
                    <td>
                        <span class="fw-bold text-dark">Rp {{ number_format($menu['harga'], 0, ',', '.') }}</span>
                    </td>
                    <td>
                        @if($menu['status'] == 'Tersedia')
                            <span class="badge bg-success-subtle text-success border border-success px-3 py-2">Tersedia</span>
                        @else
                            <span class="badge bg-danger-subtle text-danger border border-danger px-3 py-2">Habis</span>
                        @endif
                    </td>
                    <td class="text-end pe-4">
                        <button class="btn btn-sm btn-light border btn-edit me-1" data-bs-toggle="modal" data-bs-target="#menuModal">
                            <i class="fas fa-edit text-primary"></i>
                        </button>
                        <button class="btn btn-sm btn-light border btn-delete" data-id="{{ $menu['id'] }}">
                            <i class="fas fa-trash text-danger"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- Modal Tambah/Edit Menu --}}
<div class="modal fade" id="menuModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold" id="menuModalLabel">Detail Menu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="menuForm" method="POST" action="{{ route('admin.menu.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body py-4">
                    <input type="hidden" id="menu-id">
                    
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nama Menu</label>
                        <input type="text" class="form-control bg-light border-0" id="nama" name="nama" required placeholder="Contoh: Espresso">
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Kategori</label>
                            <select class="form-select bg-light border-0" id="kategori" name="kategori" required>
                                <option value="">Pilih Kategori</option>
                                <option value="1">Kopi</option>
                                <option value="2">Minuman</option>
                                <option value="3">Makanan</option>
                                <option value="4">Cemilan</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Harga (Rp)</label>
                            <input type="number" class="form-control bg-light border-0" id="harga" name="harga" required min="0">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Deskripsi</label>
                        <textarea class="form-control bg-light border-0" id="deskripsi" name="deskripsi" rows="3" placeholder="Ceritakan tentang menu ini..."></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Status Ketersediaan</label>
                        <select class="form-select bg-light border-0" id="status" name="status" required>
                            <option value="1">Tersedia</option>
                            <option value="2">Habis</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Foto Menu</label>
                        <div id="current-photo-group" class="mb-2" style="display: none;">
                            <img src="" id="edit-current-photo" class="rounded-3 shadow-sm border mb-2" style="max-width: 120px; height: auto;">
                        </div>
                        <input type="file" class="form-control bg-light border-0" id="foto_upload" name="foto_upload" accept="image/*">
                        <small class="text-muted mt-1 d-block">Gunakan format JPG/PNG berkualitas tinggi.</small>
                    </div>
                </div>
                <div class="modal-footer border-top-0 pt-0">
                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('menuForm');
        const modalTitle = document.getElementById('menuModalLabel');
        const currentPhotoGroup = document.getElementById('current-photo-group');
        const currentPhoto = document.getElementById('edit-current-photo');
        
        // Reset form untuk tambah baru
        document.getElementById('btn-create-menu').addEventListener('click', function() {
            modalTitle.textContent = 'Tambah Menu Baru';
            form.reset();
            form.action = '{{ route('admin.menu.store') }}';
            currentPhotoGroup.style.display = 'none';
            
            const methodField = form.querySelector('input[name="_method"]');
            if (methodField) methodField.remove();
        });

        // Edit menu
        document.querySelectorAll('.btn-edit').forEach(button => {
            button.addEventListener('click', function() {
                modalTitle.textContent = 'Edit Data Menu';
                const row = this.closest('tr');
                
                form.action = '{{ url("/admin/menu") }}/' + row.dataset.id;
                document.getElementById('nama').value = row.dataset.nama;
                document.getElementById('kategori').value = row.dataset.kategoriId;
                document.getElementById('harga').value = row.dataset.harga;
                document.getElementById('status').value = row.dataset.status === 'Tersedia' ? 1 : 2;
                document.getElementById('deskripsi').value = row.dataset.deskripsi;
                
                if (row.dataset.imagePath) {
                    currentPhoto.src = '{{ asset("") }}' + row.dataset.imagePath;
                    currentPhotoGroup.style.display = 'block';
                }

                let methodField = form.querySelector('input[name="_method"]');
                if (!methodField) {
                    methodField = document.createElement('input');
                    methodField.type = 'hidden';
                    methodField.name = '_method';
                    methodField.value = 'PUT';
                    form.appendChild(methodField);
                }
            });
        });

        // Delete menu
        document.querySelectorAll('.btn-delete').forEach(button => {
            button.addEventListener('click', async function() {
                const menuId = this.dataset.id;
                if (!confirm('Anda yakin ingin menghapus menu ini?')) return;
                
                try {
                    const response = await fetch('{{ url("/admin/menu") }}/' + menuId, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    });
                    
                    if (response.ok) {
                        location.reload();
                    } else {
                        alert('Gagal menghapus menu.');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan jaringan.');
                }
            });
        });
    });
</script>
@endpush