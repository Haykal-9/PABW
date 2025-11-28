@extends('customers.layouts.app')

@section('title', 'Buat Reservasi')

@section('content')

<div class="container py-5 my-md-5">
    <div class="row g-5 align-items-center">

        {{-- KOLOM KIRI: FORMULIR RESERVASI --}}
        <div class="col-lg-6 order-lg-1 order-2" data-aos="fade-right">
            
            <h1 class="display-5 fw-bold text-primary-dark mb-3">Buat Reservasi</h1>
            <p class="lead text-muted mb-4">
                Nikmati seni menyeduh kami. Isi detail reservasi Anda di bawah ini untuk memastikan tempat Anda tersedia.
            </p>

            {{-- Cek Status Login (Menggunakan Session) --}}
            @php
                $isLoggedIn = session()->has('user_id');
            @endphp
            
            {{-- Status Messages (Sukses/Error dari Controller) --}}
            @if(session('success'))
                <div class="alert alert-success fw-bold">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger fw-bold">{{ session('error') }}</div>
            @endif

            {{-- Pesan Peringatan Jika Belum Login --}}
            @if (!$isLoggedIn)
                <div class="alert alert-warning text-center">
                    Anda harus **<a href="{{ url('/login') }}" class="alert-link fw-bold">LOGIN</a>** untuk membuat reservasi.
                </div>
            @endif
            
            {{-- Menampilkan Pesan Validasi Global --}}
            @if ($errors->any() && $isLoggedIn)
                <div class="alert alert-danger">
                    Mohon periksa kembali input Anda.
                </div>
            @endif


            <form method="POST" action="{{ route('reservasi.store') }}">
                @csrf
                <div class="row g-4">
                    
                    {{-- Baris 1: Nama & Telepon --}}
                    <div class="col-md-6">
                        <label for="name" class="form-label fw-semibold small">NAMA LENGKAP</label>
                        {{-- Field Nama Pemesan --}}
                        <input name="nama_pemesan" type="text" class="form-control form-control-lg rounded-0 border-dark" id="name" required value="{{ old('nama_pemesan', $user->nama ?? '') }}" placeholder="Nama Anda" {{!$isLoggedIn ? 'disabled' : ''}}>
                        @error('nama_pemesan') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="phone" class="form-label fw-semibold small">TELEPON</label>
                        {{-- Field Nomor Telepon --}}
                        <input name="no_telp" type="text" class="form-control form-control-lg rounded-0 border-dark" id="phone" required value="{{ old('no_telp', $user->no_telp ?? '') }}" placeholder="+62..." {{!$isLoggedIn ? 'disabled' : ''}}>
                        @error('no_telp') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>
                    
                    {{-- Baris 2: Email --}}
                    <div class="col-12">
                        <label for="email" class="form-label fw-semibold small">EMAIL</label>
                        {{-- Field Email Pemesan --}}
                        <input name="email_pemesan" type="email" class="form-control form-control-lg rounded-0 border-dark" id="email" required value="{{ old('email_pemesan', $user->email ?? '') }}" placeholder="email@contoh.com" {{!$isLoggedIn ? 'disabled' : ''}}>
                        @error('email_pemesan') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>
                    
                    {{-- Baris 3: Jumlah Orang --}}
                    <div class="col-md-4">
                        <label for="number_of_people" class="form-label fw-semibold small">JUMLAH ORANG</label>
                        {{-- Field Jumlah Orang --}}
                        <input name="jumlah_orang" type="number" class="form-control form-control-lg rounded-0 border-dark" id="number_of_people" min="1" required placeholder="Contoh: 4" value="{{ old('jumlah_orang') }}" {{!$isLoggedIn ? 'disabled' : ''}}>
                        @error('jumlah_orang') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>
                    
                    {{-- Baris 4: Tanggal --}}
                    <div class="col-md-4">
                        <label for="date" class="form-label fw-semibold small">TANGGAL</label>
                        {{-- Field Tanggal Reservasi --}}
                        <input name="tanggal_reservasi" type="date" class="form-control form-control-lg rounded-0 border-dark" id="date" required value="{{ old('tanggal_reservasi') }}" {{!$isLoggedIn ? 'disabled' : ''}}>
                        @error('tanggal_reservasi') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>
                    
                    {{-- Baris 5: Jam --}}
                    <div class="col-md-4">
                        <label for="hour" class="form-label fw-semibold small">JAM</label>
                        {{-- Field Jam Reservasi --}}
                        <input name="jam_reservasi" type="time" class="form-control form-control-lg rounded-0 border-dark" id="hour" required value="{{ old('jam_reservasi') }}" {{!$isLoggedIn ? 'disabled' : ''}}>
                        @error('jam_reservasi') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>
                    
                    {{-- Baris 6: Pesan Tambahan --}}
                    <div class="col-12">
                        <label for="message" class="form-label fw-semibold small">PESAN (Opsional)</label>
                        <textarea name="message" class="form-control form-control-lg rounded-0 border-dark" id="message" rows="3" placeholder="Contoh: Butuh meja di dekat jendela..." {{!$isLoggedIn ? 'disabled' : ''}}>{{ old('message') }}</textarea>
                        @error('message') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>
                    
                    {{-- Tombol Submit --}}
                    <div class="col-12 mt-4">
                        <button type="submit" class="btn btn-primary-dark btn-lg w-100 px-5 py-3 fw-bold shadow-sm rounded-0" {{!$isLoggedIn ? 'disabled' : ''}}>
                            RESERVE A TABLE
                        </button>
                    </div>
                </div>
            </form>
        </div>

        {{-- KOLOM KANAN: VISUAL & INFORMASI TAMBAHAN --}}
        <div class="col-lg-6 order-lg-2 order-1" data-aos="fade-left">
            <div class="bg-light p-4 rounded-3 shadow">
                {{-- Gambar Besar --}}
                {{-- Asumsi path asset/bg/kopi.jpg ada di public --}}
                <img src="{{ asset('asset/bg/kopi.jpg') }}" class="img-fluid rounded mb-4 shadow-sm" alt="Kedai Kopi Tapal Kuda">
                
                {{-- Info Bantuan --}}
                <h4 class="fw-bold text-primary-dark mb-3">Informasi Penting</h4>
                <ul class="list-unstyled small text-muted">
                    <li><i class="fas fa-clock text-primary-dark me-2"></i> Jam Operasional Reservasi: 09:00 - 20:00 WIB.</li>
                    <li><i class="fas fa-users text-primary-dark me-2"></i> Reservasi hanya untuk 4 orang atau lebih.</li>
                    <li><i class="fas fa-calendar-check text-primary-dark me-2"></i> Konfirmasi akan dikirim ke email Anda dalam 1 jam.</li>
                </ul>
                <a href="{{ url('/contact') }}" class="btn btn-outline-primary-dark btn-sm rounded-0">Hubungi Kami</a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    {{-- Scripts di sini --}}
@endpush