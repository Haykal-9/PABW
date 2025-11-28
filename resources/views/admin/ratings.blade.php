@extends('admin.layouts.app')

@section('title', 'Rating & Ulasan')

@section('admin_content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data Ulasan Pelanggan</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Menu</th>
                        <th>User</th>
                        <th>Rating</th>
                        <th>Ulasan</th>
                        <th>Tanggal</th>
                        <th>Aksi</th> {{-- KOLOM BARU --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ratings as $rating)
                    <tr data-id="{{ $rating['id'] }}">
                        <td>{{ $rating['id'] }}</td>
                        <td>{{ $rating['menu'] }}</td>
                        <td>{{ $rating['user'] }}</td>
                        <td>
                            <span class="text-warning">
                                @for ($i = 0; $i < $rating['rating']; $i++)
                                    <i class="fas fa-star"></i>
                                @endfor
                                ({{ $rating['rating'] }})
                            </span>
                        </td>
                        <td>{{ $rating['ulasan'] }}</td>
                        <td>{{ $rating['tanggal'] }}</td>
                        <td>
                             <button class="btn btn-sm btn-danger btn-delete-rating" data-id="{{ $rating['id'] }}">
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
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Delete Button Handler (Hanya memverifikasi status, tanpa JSON)
        document.querySelectorAll('.btn-delete-rating').forEach(button => {
            button.addEventListener('click', async function() {
                const ratingId = this.dataset.id;
                if (!confirm(`Hapus Ulasan ID ${ratingId}?`)) {
                    return;
                }
                
                const url = `{{ url('/admin/ratings') }}/${ratingId}`;

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
                        alert('Gagal menghapus ulasan.');
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