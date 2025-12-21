@extends('customers.layouts.app')

@section('content')
    <div class="min-vh-100 py-5 d-flex align-items-center justify-content-center"
        style="background: radial-gradient(circle at top right, #1f1a18, #0f0c0b); margin-top:-0px; padding-top: 100px !important;">

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">

                    {{-- Back Button --}}
                    <div class="mb-4">
                        <a href="{{ route('profile.show', ['id' => $user->id]) }}"
                            class="text-decoration-none text-dim hover-text-gold transition-all">
                            <i class="fas fa-arrow-left me-2"></i> Back to Profile
                        </a>
                    </div>

                    <div class="glass-card position-relative border-0 shadow-2xl overflow-hidden"
                        style="background: linear-gradient(145deg, rgba(255,255,255,0.03) 0%, rgba(255,255,255,0.01) 100%);">

                        {{-- Top Gold Line --}}
                        <div class="position-absolute top-0 start-0 w-100 h-1 bg-gradient-gold opacity-50"></div>

                        <div class="card-body p-4 p-md-5">

                            <div class="text-center mb-5">
                                <h3 class="font-serif text-light mb-1">Edit Profile</h3>
                                <p class="text-dim small">Update your personal information</p>
                            </div>

                            {{-- Alert Sukses/Error --}}
                            @if(session('success'))
                                <div class="alert alert-success bg-success bg-opacity-10 text-success border-0 mb-4 rounded-0">
                                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                                </div>
                            @endif
                            @if(session('error'))
                                <div class="alert alert-danger bg-danger bg-opacity-10 text-danger border-0 mb-4 rounded-0">
                                    <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                                </div>
                            @endif

                            <form action="{{ route('profile.update', ['id' => $user->id]) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                {{-- Avatar Section --}}
                                <div class="text-center mb-5">
                                    <div class="position-relative d-inline-block">
                                        <div class="ratio ratio-1x1 rounded-circle shadow-lg position-relative overflow-hidden mb-3 mx-auto"
                                            style="width: 120px;">
                                            @if($user->profile_picture)
                                                <img src="{{ asset('uploads/profile/' . $user->profile_picture) }}"
                                                    class="w-100 h-100 object-fit-cover" id="avatarPreview">
                                            @else
                                                <div
                                                    class="w-100 h-100 bg-dark d-flex align-items-center justify-content-center">
                                                    <i class="fas fa-user text-gold fs-1 opacity-50"></i>
                                                </div>
                                            @endif
                                        </div>

                                        {{-- Custom File Input --}}
                                        <label for="profile_picture"
                                            class="btn btn-sm btn-outline-glass rounded-pill px-3 position-relative z-2">
                                            <i class="fas fa-camera me-1"></i> Change Photo
                                        </label>
                                        <input type="file" id="profile_picture" name="profile_picture" class="d-none"
                                            accept="image/*" onchange="previewImage(this)">
                                    </div>
                                </div>

                                <div class="row g-4">
                                    {{-- Nama --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="text-gold x-small fw-bold text-uppercase mb-2 ls-1">Full
                                                Name</label>
                                            <input type="text" name="nama" class="form-control form-control-glass rounded-0"
                                                value="{{ old('nama', $user->nama) }}" placeholder="Enter your full name">
                                        </div>
                                    </div>

                                    {{-- Email --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="text-gold x-small fw-bold text-uppercase mb-2 ls-1">Email
                                                Address</label>
                                            <input type="email" name="email"
                                                class="form-control form-control-glass rounded-0"
                                                value="{{ old('email', $user->email) }}" placeholder="name@example.com">
                                        </div>
                                    </div>

                                    {{-- No Telp --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="text-gold x-small fw-bold text-uppercase mb-2 ls-1">Phone
                                                Number</label>
                                            <input type="text" name="no_telp"
                                                class="form-control form-control-glass rounded-0"
                                                value="{{ old('no_telp', $user->no_telp) }}">
                                        </div>
                                    </div>

                                    {{-- Gender --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="text-gold x-small fw-bold text-uppercase mb-2 ls-1">Gender</label>
                                            <select name="gender_id"
                                                class="form-select form-control-glass rounded-0 text-light bg-dark">
                                                @foreach($genders as $gender)
                                                    <option value="{{ $gender->id }}" {{ $user->gender_id == $gender->id ? 'selected' : '' }}>
                                                        {{ $gender->gender_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    {{-- Alamat --}}
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="text-gold x-small fw-bold text-uppercase mb-2 ls-1">Shipping
                                                Address</label>
                                            <textarea name="alamat" class="form-control form-control-glass rounded-0"
                                                rows="3">{{ old('alamat', $user->alamat) }}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-12 my-2">
                                        <hr class="border-white opacity-10">
                                    </div>

                                    {{-- Password --}}
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="text-gold x-small fw-bold text-uppercase mb-2 ls-1">New
                                                Password</label>
                                            <input type="password" name="password"
                                                class="form-control form-control-glass rounded-0"
                                                placeholder="Leave blank to keep current password">
                                            <small class="text-dim x-small mt-1 d-block"><i
                                                    class="fas fa-info-circle me-1"></i> Only fill this if you want to
                                                change your password.</small>
                                        </div>
                                    </div>

                                    {{-- Button --}}
                                    <div class="col-12 mt-5">
                                        <button type="submit"
                                            class="btn btn-gold w-100 rounded-0 py-3 fw-bold ls-1 text-uppercase shimmer-effect">
                                            Save Changes
                                        </button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Shared Glass Theme Utility Classes (Should ideally be in main css) */
        .glass-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .shadow-2xl {
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        .text-dim {
            color: rgba(255, 255, 255, 0.5);
        }

        .x-small {
            font-size: 0.75rem;
        }

        .ls-1 {
            letter-spacing: 1px;
        }

        .bg-gradient-gold {
            background: linear-gradient(90deg, var(--accent-gold), transparent);
        }

        /* Form Controls */
        .form-control-glass {
            background: rgba(255, 255, 255, 0.02) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            color: #fff !important;
            transition: all 0.3s ease;
        }

        .form-control-glass:focus {
            background: rgba(255, 255, 255, 0.05) !important;
            border-color: var(--accent-gold) !important;
            box-shadow: 0 0 0 0.25rem rgba(212, 175, 55, 0.1) !important;
        }

        .form-control-glass::placeholder {
            color: rgba(255, 255, 255, 0.2);
        }

        /* Buttons */
        .btn-outline-glass {
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: rgba(255, 255, 255, 0.8);
            background: transparent;
        }

        .btn-outline-glass:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            border-color: rgba(255, 255, 255, 0.4);
        }

        .btn-gold {
            background: linear-gradient(45deg, #d4af37, #f2d06b);
            color: #000;
            border: none;
            position: relative;
            overflow: hidden;
        }

        .btn-gold:hover {
            background: linear-gradient(45deg, #c5a028, #e1c05b);
            color: #000;
            transform: translateY(-1px);
        }

        /* Shimmer Effect */
        .shimmer-effect::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 50%;
            height: 100%;
            background: linear-gradient(to right, transparent, rgba(255, 255, 255, 0.3), transparent);
            transform: skewX(-25deg);
            animation: shimmer 3s infinite;
        }

        @keyframes shimmer {
            100% {
                left: 200%;
            }
        }

        .hover-text-gold:hover {
            color: var(--accent-gold) !important;
        }

        /* Select styling override */
        select.form-control-glass option {
            background-color: #1a1a1a;
            color: #fff;
        }
    </style>

    <script>
        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    // Update preview if it exists, or crate if not
                    let img = document.getElementById('avatarPreview');
                    if (img) {
                        img.src = e.target.result;
                    }
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection