@extends('layouts.app')

@section('title', 'TapalKuda - Masuk Akun')

@section('content')

<section class="login-page d-flex align-items-center justify-content-center min-vh-100 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5" data-aos="fade-up">
                
                <div class="card border-0 shadow-lg p-4 p-md-5">
                    <div class="card-body">
                        <h2 class="text-center fw-bold mb-4 text-primary-dark">Masuk ke Akun Anda</h2>
                        <p class="text-center text-muted mb-4">Silakan masukkan kredensial Anda untuk melanjutkan.</p>

                        {{-- Form Login --}}
                        <form id="loginForm">
                            @csrf
                            
                            {{-- Input Username --}}
                            <div class="mb-3">
                                <label for="username" class="form-label fw-bold">Username</label>
                                <input type="text" 
                                       class="form-control" 
                                       id="username" 
                                       name="username" 
                                       placeholder="Masukkan username Anda">
                            </div>
                            
                            {{-- Input Password --}}
                            <div class="mb-4">
                                <label for="password" class="form-label fw-bold">Password</label>
                                <input type="password" 
                                       class="form-control" 
                                       id="password" 
                                       name="password" 
                                       placeholder="Masukkan password Anda">
                            </div>

                            {{-- Pesan Sukses (Akan tampil setelah submit) --}}
                            <div id="loginMessage" class="alert d-none" role="alert"></div>

                            {{-- Tombol Login --}}
                            <button type="submit" 
                                    class="btn btn-primary-dark btn-lg w-100 shadow-sm">
                                LOGIN
                            </button>
                        </form>
                        
                        <hr class="my-4">
                        
                        <p class="text-center text-muted small">
                            Belum punya akun? <a href="{{ url('/register') }}" class="text-primary-dark text-decoration-none fw-bold">Daftar di sini</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

{{-- JAVASCRIPT LOGIC (Selalu Sukses) --}}
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('loginForm');
        const messageBox = document.getElementById('loginMessage');

        // URL tujuan setelah login berhasil
        const SUCCESS_REDIRECT = '{{ url('/') }}'; 

        form.addEventListener('submit', function(event) {
            event.preventDefault(); // Mencegah form submit default

            // 1. Tampilkan status loading/sukses
            messageBox.classList.remove('d-none', 'alert-danger');
            messageBox.classList.add('alert-success');

            // Menggunakan pesan yang umum digunakan saat autentikasi berhasil
            messageBox.innerHTML = 'Autentikasi Berhasil. Mengalihkan Anda ke halaman utama...';
            
            // 2. Lakukan pengalihan
            setTimeout(() => {
                window.location.href = SUCCESS_REDIRECT;
            }, 500); // Jeda singkat (0.5 detik)
        });
    });
</script>
@endpush