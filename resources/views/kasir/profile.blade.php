@extends('kasir.layouts.app')

@push('styles')
    <style>
        .profile-container {
            max-width: 900px;
            margin: 0 auto;
        }

        .profile-header {
            background: linear-gradient(135deg, var(--accent-color) 0%, #c96632 100%);
            border-radius: 1rem;
            padding: 2rem;
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
        }

        .profile-header::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            transform: translate(30%, -30%);
        }

        .profile-info {
            display: flex;
            align-items: center;
            gap: 2rem;
            position: relative;
            z-index: 1;
        }

        .profile-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .profile-details h2 {
            color: white;
            margin-bottom: 0.5rem;
            font-weight: 700;
        }

        .profile-role {
            display: inline-block;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 2rem;
            font-size: 0.875rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .profile-meta {
            color: rgba(255, 255, 255, 0.9);
            font-size: 0.9rem;
        }

        .profile-meta i {
            margin-right: 0.25rem;
        }

        .info-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .info-card {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 0.75rem;
            padding: 1.5rem;
        }

        .info-card-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1rem;
        }

        .info-card-icon {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, var(--accent-color), #c96632);
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
        }

        .info-card-title {
            font-size: 0.875rem;
            color: var(--text-muted-color);
            margin: 0;
        }

        .info-card-value {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--text-color);
            margin: 0;
        }

        .detail-section {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 0.75rem;
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .detail-section h4 {
            margin-bottom: 1.5rem;
            font-weight: 600;
            color: var(--text-color);
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 1rem 0;
            border-bottom: 1px solid var(--border-color);
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            color: var(--text-muted-color);
            font-weight: 500;
        }

        .detail-value {
            color: var(--text-color);
            font-weight: 600;
        }

        .action-buttons {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        .btn-action {
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            border: none;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-edit-profile {
            background-color: var(--accent-color);
            color: white;
        }

        .btn-edit-profile:hover {
            background-color: #d16a2f;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(232, 123, 62, 0.3);
        }

        .btn-logout {
            background-color: #dc3545;
            color: white;
        }

        .btn-logout:hover {
            background-color: #c82333;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(220, 53, 69, 0.3);
        }

        @media (max-width: 768px) {
            .profile-info {
                flex-direction: column;
                text-align: center;
            }

            .info-cards {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush

@section('content')
    <main class="content">
        <div class="header">
            <h1>Profil Pengguna</h1>
            <p>Informasi akun dan aktivitas Anda</p>
        </div>

        <div class="profile-container">
            {{-- Profile Header Card --}}
            <div class="profile-header">
                <div class="profile-info">
                    <img src="{{ $user['foto'] }}" alt="Foto Profil" class="profile-avatar">
                    <div class="profile-details">
                        <span class="profile-role"><i class="bi bi-person-badge"></i> {{ $user['role'] }}</span>
                        <h2>{{ $user['nama'] }}</h2>
                        <div class="profile-meta">
                            <i class="bi bi-envelope-fill"></i> {{ $user['email'] }}
                            <span class="mx-2">•</span>
                            <i class="bi bi-telephone-fill"></i> {{ $user['telepon'] }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- Statistics Cards --}}
            <div class="info-cards">
                <div class="info-card">
                    <div class="info-card-header">
                        <div class="info-card-icon">
                            <i class="bi bi-receipt"></i>
                        </div>
                        <div>
                            <p class="info-card-title">Total Transaksi</p>
                            <h3 class="info-card-value">{{ $user['total_transaksi'] }}</h3>
                        </div>
                    </div>
                </div>

                <div class="info-card">
                    <div class="info-card-header">
                        <div class="info-card-icon">
                            <i class="bi bi-calendar-check"></i>
                        </div>
                        <div>
                            <p class="info-card-title">Hari Kerja</p>
                            <h3 class="info-card-value">{{ $user['hari_kerja'] }}</h3>
                        </div>
                    </div>
                </div>

                <div class="info-card">
                    <div class="info-card-header">
                        <div class="info-card-icon">
                            <i class="bi bi-clock-history"></i>
                        </div>
                        <div>
                            <p class="info-card-title">Shift Hari Ini</p>
                            <h3 class="info-card-value">{{ $user['shift'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Detail Information --}}
            <div class="detail-section">
                <h4><i class="bi bi-info-circle me-2"></i>Informasi Detail</h4>
                <div class="detail-row">
                    <span class="detail-label">Username</span>
                    <span class="detail-value">{{ $user['username'] }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Role</span>
                    <span class="detail-value">{{ $user['role'] }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Tanggal Bergabung</span>
                    <span class="detail-value">{{ $user['tanggal_bergabung'] }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Status Akun</span>
                    <span class="detail-value">
                        <span class="badge" style="background-color: #28a745;">{{ $user['status'] }}</span>
                    </span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Last Login</span>
                    <span class="detail-value">{{ $user['last_login'] }}</span>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="action-buttons">
                <a href="{{ route('kasir.profile.edit') }}" class="btn btn-action btn-edit-profile">
                    <i class="bi bi-pencil-square"></i>
                    Edit Profil
                </a>
                <a href="{{ route('logout') }}" class="btn btn-action btn-logout">
                    <i class="bi bi-box-arrow-right"></i>
                    Log Out
                </a>
            </div>
        </div>
    </main>
@endsection