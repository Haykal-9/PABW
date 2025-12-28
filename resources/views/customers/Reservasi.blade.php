@extends('customers.layouts.app')

@section('title', 'Buat Reservasi')

@section('content')
    <section class="reservation-section min-vh-100 position-relative d-flex align-items-center py-5"
        style="background: radial-gradient(circle at top right, #1f1a18, #0f0c0b); margin-top: 0px;">

        <div class="container">
            <div class="row g-0 rounded-4 overflow-hidden shadow-2xl"
                style="background: rgba(255, 255, 255, 0.02); border: 1px solid rgba(255, 255, 255, 0.05);">

                {{-- LEFT COLUMN: ATMOSPHERIC VISUAL --}}
                <div class="col-lg-5 position-relative min-vh-50 d-none d-lg-block">
                    <div class="h-100 w-100 position-absolute top-0 start-0">
                        <img src="{{ asset('tapalkuda/image.png') }}" class="w-100 h-100 object-fit-cover"
                            alt="Interior Tapal Kuda">
                        <div class="position-absolute top-0 start-0 w-100 h-100"
                            style="background: linear-gradient(to right, rgba(0,0,0,0.3), rgba(15,12,11,1));"></div>

                        <div class="position-absolute bottom-0 start-0 p-5 text-shadow-lg">
                            <h2 class="display-6 font-serif text-gold fw-bold mb-2">Book Your Table</h2>
                            <p class="text-light opacity-75 mb-0">Rasakan pengalaman kopi premium dengan suasana yang tak
                                terlupakan.</p>
                        </div>
                    </div>
                </div>

                {{-- MOBILE IMAGE --}}
                <div class="col-12 d-lg-none position-relative">
                    <img src="{{ asset('tapalkuda/image.png') }}" class="w-100 object-fit-cover" style="height: 250px;"
                        alt="Interior">
                    <div class="position-absolute bottom-0 start-0 w-100 h-100"
                        style="background: linear-gradient(to top, #0f0c0b, transparent);"></div>
                </div>

                {{-- RIGHT COLUMN: FORM --}}
                <div class="col-lg-7 p-4 p-md-5 d-flex flex-column justify-content-center">

                    <h1 class="font-serif text-light mb-4">Reservasi Tempat</h1>

                    {{-- Validasi / Alert --}}
                    @if(session('success'))
                        <div
                            class="alert alert-success border-0 bg-success bg-opacity-10 text-success mb-4 d-flex align-items-center">
                            <i class="fas fa-check-circle me-2"></i>
                            <div>{{ session('success') }}</div>
                        </div>
                    @endif
                    @if(session('error'))
                        <div
                            class="alert alert-danger border-0 bg-danger bg-opacity-10 text-danger mb-4 d-flex align-items-center">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <div>{{ session('error') }}</div>
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger border-0 bg-danger bg-opacity-10 text-danger mb-4">
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                <strong>Terdapat kesalahan input:</strong>
                            </div>
                            <ul class="mb-0 ps-4">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('reservasi.store') }}">
                        @csrf
                        <div class="row g-4">

                            {{-- Hidden User Data (Auto-filled from Auth) --}}
                            {{-- We assume user must be logged in so we don't need inputs for name/phone if we use what's in
                            DB,
                            BUT the original controller stores specific input fields.
                            Since the user IS logged in, we can pre-fill comfortably. --}}

                            {{-- Nama & Telepon (Pre-filled, Editable) --}}
                            <div class="col-md-6">
                                <label class="text-gold small fw-bold mb-2 text-uppercase ls-1">Nama Pemesan</label>
                                <input name="nama_pemesan" type="text" class="form-control form-control-glass text-light @error('nama_pemesan') is-invalid @enderror"
                                    required value="{{ old('nama_pemesan', $user->nama) }}">
                                @error('nama_pemesan')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="text-gold small fw-bold mb-2 text-uppercase ls-1">Telepon</label>
                                <input name="no_telp" type="text" class="form-control form-control-glass text-light @error('no_telp') is-invalid @enderror"
                                    required value="{{ old('no_telp', $user->no_telp) }}">
                                @error('no_telp')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div class="col-12">
                                <label class="text-gold small fw-bold mb-2 text-uppercase ls-1">Email Konfirmasi</label>
                                <input name="email_pemesan" type="email" class="form-control form-control-glass text-light @error('email_pemesan') is-invalid @enderror"
                                    required value="{{ old('email_pemesan', $user->email) }}">
                                @error('email_pemesan')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Tanggal, Jam, Jumlah --}}
                            <div class="col-md-4">
                                <label class="text-gold small fw-bold mb-2 text-uppercase ls-1">Tanggal</label>
                                <input name="tanggal_reservasi" type="date"
                                    class="form-control form-control-glass text-light @error('tanggal_reservasi') is-invalid @enderror" required
                                    value="{{ old('tanggal_reservasi') }}">
                                @error('tanggal_reservasi')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="text-gold small fw-bold mb-2 text-uppercase ls-1">Jam</label>
                                <input name="jam_reservasi" type="time" class="form-control form-control-glass text-light @error('jam_reservasi') is-invalid @enderror"
                                    required value="{{ old('jam_reservasi') }}">
                                @error('jam_reservasi')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="text-gold small fw-bold mb-2 text-uppercase ls-1">Jml. Orang</label>
                                <input name="jumlah_orang" type="number" min="1"
                                    class="form-control form-control-glass text-light @error('jumlah_orang') is-invalid @enderror" required
                                    value="{{ old('jumlah_orang') }}" placeholder="Ex: 2">
                                @error('jumlah_orang')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Pesan --}}
                            <div class="col-12">
                                <label class="text-gold small fw-bold mb-2 text-uppercase ls-1">Catatan Khusus
                                    (Opsional)</label>
                                <textarea name="message" class="form-control form-control-glass text-light" rows="3"
                                    placeholder="Contoh: Meja dekat jendela, High chair untuk bayi...">{{ old('message') }}</textarea>
                            </div>

                            <div class="col-12 mt-4">
                                <button type="submit"
                                    class="btn btn-gold w-100 py-3 rounded-0 fw-bold shadow-lg hover-scale transition-all text-uppercase ls-1">
                                    Konfirmasi Reservasi
                                </button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <style>
        .shadow-2xl {
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        .text-shadow-lg {
            text-shadow: 0 4px 6px rgba(0, 0, 0, 0.5);
        }

        .ls-1 {
            letter-spacing: 1px;
        }

        .form-control-glass {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: white;
            padding: 12px 16px;
        }

        .form-control-glass:focus {
            background: rgba(255, 255, 255, 0.05);
            border-color: var(--accent-gold);
            color: white;
            box-shadow: none;
        }

        /* Fix Date/Time Input Color in Dark Mode */
        input[type="date"]::-webkit-calendar-picker-indicator,
        input[type="time"]::-webkit-calendar-picker-indicator {
            filter: invert(1);
            cursor: pointer;
        }
    </style>
@endsection

@push('scripts')
    {{-- Scripts di sini --}}
@endpush