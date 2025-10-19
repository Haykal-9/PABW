@extends('admin.layouts.app')

@section('admin_page_title', 'Daftar Menu')

@section('admin_content')
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
                        <th>Gambar</th> {{-- Kolom Gambar Baru --}}
                        <th>Nama Menu</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($menus as $menu)
                    <tr>
                        <td>{{ $menu['id'] }}</td>
                        <td>
                            {{-- Menampilkan Gambar Menu --}}
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
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection