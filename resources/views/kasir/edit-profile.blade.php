@extends('kasir.layouts.app')

@push('styles')
    <style>
        .edit-profile-container {
            max-width: 800px;
            margin: 0 auto;
        }

        .form-section {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 0.75rem;
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .form-section h4 {
            margin-bottom: 1.5rem;
            font-weight: 600;
            color: var(--text-color);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .avatar-upload {
            display: flex;
            align-items: center;
            gap: 2rem;
            margin-bottom: 2rem;
            padding: 1.5rem;
            background-color: var(--sidebar-bg);
            border-radius: 0.75rem;
            border: 1px solid var(--border-color);
        }

        .current-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--border-color);
        }

        .avatar-info h5 {
            margin-bottom: 0.5rem;
            color: var(--text-color);
        }

        .avatar-info p {
            color: var(--text-muted-color);
            font-size: 0.875rem;
            margin-bottom: 1rem;
        }

        .form-label {
            font-weight: 600;
            color: var(--text-color);
            margin-bottom: 0.5rem;
        }

        .form-text {
            color: var(--text-muted-color);
            font-size: 0.875rem;
        }

        .btn-save {
            background-color: var(--accent-color);
            border: none;
            color: white;
            padding: 0.75rem 2rem;
            font-weight: 600;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }

        .btn-save:hover {
            background-color: #d16a2f;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(232, 123, 62, 0.3);
        }

        .btn-cancel {
            background-color: var(--sidebar-bg);
            border: 1px solid var(--border-color);
            color: var(--text-color);
            padding: 0.75rem 2rem;
            font-weight: 600;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }

        .btn-cancel:hover {
            background-color: var(--card-bg);
            border-color: var(--accent-color);
        }

        .input-group-text {
            background-color: var(--sidebar-bg);
            border-color: var(--border-color);
            color: var(--text-muted-color);
        }
    </style>
@endpush

@section('content')
    <main class="content">
        <div class="header">
            <h1>Edit Profil</h1>
            <p>Perbarui informasi profil Anda</p>
        </div>

        <div class="edit-profile-container">
            {{-- Flash Messages --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('kasir.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Avatar Upload Section --}}
                <div class="form-section">
                    <h4><i class="bi bi-person-circle"></i> Foto Profil</h4>
                    <div class="avatar-upload">
                        <img src="{{ $user['foto'] }}" alt="Avatar" class="current-avatar" id="avatar-preview">
                        <div class="avatar-info">
                            <h5>Upload Foto Baru</h5>
                            <p>JPG, PNG atau GIF. Maksimal 2MB</p>
                            <input type="file" class="form-control" name="foto" accept="image/*" id="foto-input">
                        </div>
                    </div>
                </div>

                {{-- Personal Information Section --}}
                <div class="form-section">
                    <h4><i class="bi bi-person-badge"></i> Informasi Pribadi</h4>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nama" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nama" name="nama" value="{{ $user['nama'] }}"
                                required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="username" name="username"
                                value="{{ $user['username'] }}" required>
                            <div class="form-text">Username digunakan untuk login</div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                            <input type="email" class="form-control" id="email" name="email" value="{{ $user['email'] }}"
                                required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="telepon" class="form-label">Nomor Telepon <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                            <input type="tel" class="form-control" id="telepon" name="telepon"
                                value="{{ $user['telepon'] }}" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat<span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                            <input type="text" class="form-control" id="alamat" name="alamat"
                                value="{{ $user['alamat'] }}" required>
                        </div>
                    </div>
                </div>

                {{-- Security Section --}}
                <div class="form-section">
                    <h4><i class="bi bi-shield-lock"></i> Keamanan</h4>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password Baru</label>
                        <input type="password" class="form-control" id="password" name="password">
                        <div class="form-text">Kosongkan jika tidak ingin mengubah password</div>
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="d-flex gap-2 justify-content-end">
                    <a href="{{ route('kasir.profile') }}" class="btn btn-cancel">
                        <i class="bi bi-x-circle me-1"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-save">
                        <i class="bi bi-check-circle me-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </main>
@endsection

@push('scripts')
    <script>
        // Preview avatar before upload
        document.getElementById('foto-input').addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById('avatar-preview').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
@endpush