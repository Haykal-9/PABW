@extends('layouts.app')

@section('title', 'Reservasi')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/reservasi.css') }}">
@endpush

@section('content')
<div class="container my-5">
    <div class="row g-5">
        <div class="col-lg-6" data-aos="fade-right">
            <h1>BUAT RESERVASI</h1>
            <p>
                "Selamat datang di halaman reservasi Tapal Kuda Kedai Kopi!
                Nikmati pengalaman ngopi terbaik dengan pemandangan yang memukau.
                Silakan isi detail reservasi Anda di bawah ini untuk memastikan tempat Anda tersedia."
            </p>

            <form method="POST" action="#">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Nama</label>
                        <input name="name" type="text" class="form-control" id="name" required value="{{ $user->nama }}">
                    </div>
                    <div class="col-md-6">
                        <label for="phone" class="form-label">Telepon</label>
                        <input name="phone" type="text" class="form-control" id="phone" required value="{{ $user->no_telp }}">
                    </div>
                    <div class="col-12">
                        <label for="email" class="form-label">Email</label>
                        <input name="email" type="email" class="form-control" id="email" required value="{{ $user->email }}">
                    </div>
                    <div class="col-md-6">
                        <label for="number_of_people" class="form-label">Jumlah Orang</label>
                        <input name="number_of_people" type="number" class="form-control" id="number_of_people" min="1" required>
                    </div>
                    <div class="col-md-6">
                        <label for="date" class="form-label">Tanggal</label>
                        <input name="date" type="date" class="form-control" id="date" required>
                    </div>
                    <div class="col-md-6">
                        <label for="hour" class="form-label">Jam</label>
                        <input name="hour" type="time" class="form-control" id="hour" required>
                    </div>
                    <div class="col-12">
                        <label for="message" class="form-label">Pesan</label>
                        <textarea name="message" class="form-control" id="message" rows="4"></textarea>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary w-100">RESERVE A TABLE</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-lg-6" data-aos="fade-left">
            <img src="{{ asset('asset/bg/kopi.jpg') }}" class="img-fluid rounded" alt="Kedai Kopi Tapal Kuda">
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
@endpush