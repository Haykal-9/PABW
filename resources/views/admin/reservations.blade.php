@extends('admin') {{-- MENGGUNAKAN NAMA FILE BARU --}}

@section('admin_title', 'Kelola Reservasi')

@section('admin_content')
    <h1 class="mb-4 text-primary-dark">Kelola Reservasi Pelanggan</h1>

    <div class="table-responsive">
        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Pelanggan</th>
                    <th>Tanggal/Waktu</th>
                    <th>Orang</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reservations as $r)
                <tr>
                    <td>{{ $r['id'] }}</td>
                    <td>{{ $r['nama'] }}</td>
                    <td>{{ date('d M Y', strtotime($r['tanggal'])) }} / {{ $r['waktu'] }}</td>
                    <td>{{ $r['orang'] }}</td>
                    <td>
                        <span class="badge {{ $r['status'] == 'Dikonfirmasi' ? 'bg-success' : ($r['status'] == 'Pending' ? 'bg-warning text-dark' : 'bg-danger') }}">
                            {{ $r['status'] }}
                        </span>
                    </td>
                    <td>
                        <a href="#" class="btn btn-sm btn-primary-dark">Konfirmasi</a>
                        <a href="#" class="btn btn-sm btn-secondary">Batal</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection