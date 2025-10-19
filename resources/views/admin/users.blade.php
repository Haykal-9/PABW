@extends('admin.layouts.app')

@section('title', 'Daftar User')

@section('admin_content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data Pengguna Sistem</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Tanggal Terdaftar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <td>{{ $user['id'] }}</td>
                        <td>{{ $user['nama'] }}</td>
                        <td>{{ $user['email'] }}</td>
                        <td>
                             <span class="badge bg-{{ $user['role'] == 'Admin' ? 'info' : 'secondary' }}">
                                {{ $user['role'] }}
                            </span>
                        </td>
                        <td>{{ $user['terdaftar'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection