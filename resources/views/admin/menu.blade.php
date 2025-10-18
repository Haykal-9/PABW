@extends('layouts.admin_master') {{-- MENGGUNAKAN NAMA FILE BARU --}}

@section('admin_title', 'Kelola Menu')

@section('admin_content')
    <h1 class="mb-4 text-primary-dark">Kelola Daftar Menu</h1>
    <p class="lead text-muted">Data ini berasal dari data dummy yang tidak tersimpan.</p>

    <a href="#" class="btn btn-primary-dark mb-3"><i class="fas fa-plus me-2"></i> Tambah Menu Baru (Simulasi)</a>

    <div class="table-responsive">
        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Menu</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($menus as $menu)
                <tr>
                    <td>{{ $menu['id'] }}</td>
                    <td>{{ $menu['nama'] }}</td>
                    <td><span class="badge bg-secondary">{{ $menu['kategori'] }}</span></td>
                    <td>Rp {{ number_format($menu['harga'], 0, ',', '.') }}</td>
                    <td>
                        <a href="#" class="btn btn-sm btn-info text-white me-2">Edit</a>
                        <form action="{{ route('admin.menu.delete', $menu['id']) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus menu {{ $menu['nama'] }}? (Simulasi)');">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection