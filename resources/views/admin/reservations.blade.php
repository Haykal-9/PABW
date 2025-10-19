@extends('admin.layouts.app')

@section('admin_page_title', 'Data Reservasi')

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
                        <th>Kode</th>
                        <th>Tanggal/Jam</th>
                        <th>Nama Pemesan</th>
                        <th>Email</th>              {{-- KOLOM BARU --}}
                        <th>No. Telepon</th>        {{-- KOLOM BARU --}}
                        <th>Jml Orang</th>
                        <th>Catatan</th>            {{-- KOLOM BARU --}}
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reservations as $res)
                    <tr>
                        <td>{{ $res['kode'] }}</td>
                        <td>
                            {{ $res['tanggal'] }}
                            <br><small class="text-muted">({{ $res['jam'] }})</small>
                        </td>
                        <td>{{ $res['nama'] }}</td>
                        <td>{{ $res['email'] }}</td>         {{-- DATA BARU --}}
                        <td>{{ $res['phone'] }}</td>         {{-- DATA BARU --}}
                        <td>{{ $res['orang'] }}</td>
                        <td><small>{{ $res['note'] }}</small></td> {{-- DATA BARU --}}
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