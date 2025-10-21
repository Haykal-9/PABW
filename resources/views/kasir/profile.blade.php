@extends('kasir.layouts.app')

@push('styles')
<style>
    .profile-container {
        max-width: 500px;
        margin: 2rem auto;
    }
    .profile-card {
        background-color: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 0.75rem;
        padding: 2rem;
        text-align: center;
    }
    .profile-img {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        margin-bottom: 1.5rem;
        border: 3px solid var(--border-color);
    }
    .profile-card h3 {
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
    .profile-card p {
        color: var(--text-muted-color);
        margin-bottom: 1.5rem;
    }
    .btn-logout {
        background-color: #dc3545;
        border-color: #dc3545;
        color: white;
        width: 100%;
        padding: 0.75rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    .btn-logout:hover {
        background-color: #c82333;
        border-color: #bd2130;
    }
</style>
@endpush

@section('content')
<main class="content">
    <div class="header">
        <h1>Profil Pengguna</h1>
        <p>Lihat dan kelola detail profil Anda di sini.</p>
    </div>

    <div class="profile-container">
        <div class="profile-card">
            <img src="{{ $user['foto'] }}" alt="Foto Profil" class="profile-img">
            <h3>{{ $user['nama'] }}</h3>
            <p>{{ $user['email'] }} <br> {{ $user['telepon'] }}</p>

            <a href="{{ route('logout') }}" class="btn btn-logout">
                <i class="bi bi-box-arrow-right"></i> Log Out
            </a>
        </div>
    </div>
</main>
@endsection
