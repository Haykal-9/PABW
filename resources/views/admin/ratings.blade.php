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
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ratings as $rating)
                    <tr>
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
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection