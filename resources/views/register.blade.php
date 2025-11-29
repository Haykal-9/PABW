<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Pelanggan - Tapal Kuda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">Registrasi Pelanggan Baru</div>
                    <div class="card-body">
                        {{-- Tampilkan Error Validasi --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="/register" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="mb-3">
                                <label>Nama Lengkap</label>
                                <input type="text" name="nama" class="form-control" required>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Username</label>
                                    <input type="text" name="username" class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Password</label>
                                    <input type="password" name="password" class="form-control" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>No. Telepon</label>
                                    <input type="text" name="no_telp" class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Jenis Kelamin</label>
                                    <select name="gender_id" class="form-select" required>
                                        <option value="">Pilih Gender</option>
                                        @foreach($genders as $g)
                                            <option value="{{ $g->id }}">{{ $g->gender_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label>Alamat</label>
                                <textarea name="alamat" class="form-control" rows="3" required></textarea>
                            </div>

                            {{-- Input File Upload --}}
                            <div class="mb-3">
                                <label>Foto Profil</label>
                                <input type="file" name="profile_picture" class="form-control" required>
                                <small class="text-muted">Format: JPG, PNG. Maks: 2MB</small>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Daftar Sekarang</button>
                        </form>
                        <div class="mt-3 text-center">
                            Sudah punya akun? <a href="/login">Login disini</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>