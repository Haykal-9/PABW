@extends('layouts.app')

@section('title', 'TapalKuda - Buat Reservasi')

{{-- Menghapus push('styles') karena kita hanya akan menggunakan kelas Bootstrap --}}

@section('content')
<div class="container py-5 my-md-5">
    <div class="row g-5 align-items-center">

        {{-- KOLOM KIRI: FORMULIR RESERVASI --}}
        <div class="col-lg-6 order-lg-1 order-2" data-aos="fade-right">
            
            <h1 class="display-5 fw-bold text-primary-dark mb-3">Buat Reservasi</h1>
            <p class="lead text-muted mb-4">
                Nikmati seni menyeduh kami. Isi detail reservasi Anda di bawah ini untuk memastikan tempat Anda tersedia.
            </p>

            <form method="POST" action="#">
                @csrf
                <div class="row g-4">
                    
                    {{-- Baris 1: Nama & Telepon (Pre-filled Data) --}}
                    <div class="col-md-6">
                        <label for="name" class="form-label fw-semibold small">NAMA LENGKAP</label>
                        <input name="name" type="text" class="form-control form-control-lg rounded-0 border-dark" id="name" required value="{{ $user->nama ?? '' }}" placeholder="Nama Anda">
                    </div>
                    <div class="col-md-6">
                        <label for="phone" class="form-label fw-semibold small">TELEPON</label>
                        <input name="phone" type="text" class="form-control form-control-lg rounded-0 border-dark" id="phone" required value="{{ $user->no_telp ?? '' }}" placeholder="+62...">
                    </div>
                    
                    {{-- Baris 2: Email --}}
                    <div class="col-12">
                        <label for="email" class="form-label fw-semibold small">EMAIL</label>
                        <input name="email" type="email" class="form-control form-control-lg rounded-0 border-dark" id="email" required value="{{ $user->email ?? '' }}" placeholder="email@contoh.com">
                    </div>
                    
                    {{-- Baris 3: Jumlah Orang --}}
                    <div class="col-md-4">
                        <label for="number_of_people" class="form-label fw-semibold small">JUMLAH ORANG</label>
                        <input name="number_of_people" type="number" class="form-control form-control-lg rounded-0 border-dark" id="number_of_people" min="1" required placeholder="Contoh: 4">
                    </div>
                    
                    {{-- Baris 4: Tanggal --}}
                    <div class="col-md-4">
                        <label for="date" class="form-label fw-semibold small">TANGGAL</label>
                        <input name="date" type="date" class="form-control form-control-lg rounded-0 border-dark" id="date" required>
                    </div>
                    
                    {{-- Baris 5: Jam --}}
                    <div class="col-md-4">
                        <label for="hour" class="form-label fw-semibold small">JAM</label>
                        <input name="hour" type="time" class="form-control form-control-lg rounded-0 border-dark" id="hour" required>
                    </div>
                    
                    {{-- Baris 6: Pesan Tambahan --}}
                    <div class="col-12">
                        <label for="message" class="form-label fw-semibold small">PESAN (Opsional)</label>
                        <textarea name="message" class="form-control form-control-lg rounded-0 border-dark" id="message" rows="3" placeholder="Contoh: Butuh meja di dekat jendela..."></textarea>
                    </div>
                    
                    {{-- Tombol Submit --}}
                    <div class="col-12 mt-4">
                        {{-- Menggunakan warna tema Anda dan ukuran yang besar --}}
                        <button type="submit" class="btn btn-primary-dark btn-lg w-100 px-5 py-3 fw-bold shadow-sm rounded-0">
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
    {{-- AOS.init() sudah dipanggil di layout utama, cukup pastikan ini berada di sana --}}
    {{-- <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script> --}}
    {{-- <script> AOS.init(); </script> --}}
@endpush