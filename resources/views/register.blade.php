@extends('customers.layouts.app')

@section('title', 'TapalKuda - Daftar Akun')

@section('content')

{{-- Background dengan overlay --}}
<section class="register-page d-flex align-items-center justify-content-center min-vh-100 text-white" 
         style="background-image: url('{{ asset('logo/biji.jpg') }}'); 
                background-size: cover; 
                background-position: center;
                background-attachment: fixed;
                position: relative;">
    
    {{-- Overlay gelap untuk kontras teks --}}
    <div class="bg-dark position-absolute top-0 start-0 w-100 h-100 opacity-75" style="z-index: 1;"></div>

    <div class="container" style="z-index: 2;">
        <div class="row justify-content-center">
            <div class="col-md-8" data-aos="fade-up">
                
                <div class="card border-0 shadow-lg p-4 p-md-5">
                    <div class="card-body">
                        <h2 class="text-center fw-bold mb-4 text-primary-dark">Daftar Akun Baru</h2>
                        
                        {{-- Tampilkan Error Validasi --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="/register" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Nama Lengkap</label>
                                <input type="text" name="nama" class="form-control" placeholder="Masukkan nama lengkap" required>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Username</label>
                                    <input type="text" name="username" class="form-control" placeholder="Masukkan username" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Password</label>
                                    <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Email</label>
                                <input type="email" name="email" class="form-control" placeholder="Masukkan email" required>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">No. Telepon</label>
                                    <input type="text" name="no_telp" class="form-control" placeholder="Masukkan no. telepon" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Jenis Kelamin</label>
                                    <select name="gender_id" class="form-select" required>
                                        <option value="">Pilih Gender</option>
                                        @foreach($genders as $g)
                                            <option value="{{ $g->id }}">{{ $g->gender_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Alamat</label>
                                <textarea name="alamat" class="form-control" rows="3" placeholder="Masukkan alamat lengkap" required></textarea>
                            </div>

                            {{-- Input File Upload --}}
                            <div class="mb-4">
                                <label class="form-label fw-bold">Foto Profil</label>
                                <input type="file" name="profile_picture" class="form-control" required>
                                <small class="text-muted">Format: JPG, PNG. Maks: 2MB</small>
                            </div>

                            <button type="submit" class="btn btn-primary-dark btn-lg w-100 shadow-sm">
                                DAFTAR SEKARANG
                            </button>
                        </form>
                        
                        <hr class="my-4">
                        
                        <p class="text-center text-muted small">
                            Sudah punya akun? <a href="{{ url('/login') }}" class="text-primary-dark text-decoration-none fw-bold">Login di sini</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection