@extends('admin.layouts.app')

@section('title', 'Data Reservasi')

@section('admin_content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Reservasi yang Masuk</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Kode Reservasi</th>
                        <th>Tanggal</th>
                        <th>Jam</th>
                        <th>Jml Orang</th>
                        <th>Nama Pemesan</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reservations as $res)
                    <tr>
                        <td>{{ $res['kode'] }}</td>
                        <td>{{ $res['tanggal'] }}</td>
                        <td>{{ $res['jam'] }}</td>
                        <td>{{ $res['orang'] }}</td>
                        <td>{{ $res['nama'] }}</td>
                        <td>
                            <span class="badge bg-{{ $res['status'] == 'Dikonfirmasi' ? 'success' : ($res['status'] == 'Selesai' ? 'primary' : 'warning') }}">
                                {{ $res['status'] }}
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