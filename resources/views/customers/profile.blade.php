@extends('customers.layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="card-title mb-3">Profil Pengguna</h3>

                    <table class="table table-borderless">
                        <tr>
                            <th>Nama</th>
                            <td>{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <th>Telp</th>
                            <td>{{ $user->phone }}</td>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <td>{{ $user->address }}</td>
                        </tr>
                    </table>

                    <div class="mt-4">
                        <a href="{{ url('/profil/pesanan') }}" class="btn btn-outline-primary me-2">Riwayat Pesanan</a>
                        <a href="{{ url('/profil/reservasi') }}" class="btn btn-outline-secondary">Riwayat Reservasi</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
