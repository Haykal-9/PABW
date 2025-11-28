@extends('customers.layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h4 class="mb-0">Edit Profil Saya</h4>
                    </div>
                    <div class="card-body">

                        {{-- Alert Sukses --}}
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        <form action="{{ route('profile.update', ['id' => $user->id]) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT') {{-- Menggunakan method PUT untuk update --}}

                            <div class="text-center mb-4">
                                {{-- Tampilkan Foto Saat Ini --}}
                                @if($user->profile_picture)
                                    <img src="{{ asset('uploads/profile/' . $user->profile_picture) }}"
                                        class="rounded-circle img-thumbnail"
                                        style="width: 150px; height: 150px; object-fit: cover;">
                                @else
                                    <img src="https://via.placeholder.com/150" class="rounded-circle img-thumbnail">
                                @endif
                                <div class="mt-2">
                                    <label class="btn btn-sm btn-outline-primary">
                                        Ganti Foto
                                        <input type="file" name="profile_picture" class="d-none"
                                            onchange="this.form.submit()">
                                    </label>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" name="nama" class="form-control" value="{{ old('nama', $user->nama) }}">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control"
                                    value="{{ old('email', $user->email) }}">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">No. Telepon</label>
                                <input type="text" name="no_telp" class="form-control"
                                    value="{{ old('no_telp', $user->no_telp) }}">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Jenis Kelamin</label>
                                <select name="gender_id" class="form-select">
                                    @foreach($genders as $gender)
                                        <option value="{{ $gender->id }}" {{ $user->gender_id == $gender->id ? 'selected' : '' }}>
                                            {{ $gender->gender_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Alamat</label>
                                <textarea name="alamat" class="form-control"
                                    rows="3">{{ old('alamat', $user->alamat) }}</textarea>
                            </div>

                            <hr>

                            <div class="mb-3">
                                <label class="form-label">Password Baru <small class="text-muted">(Kosongkan jika tidak
                                        ingin mengganti)</small></label>
                                <input type="password" name="password" class="form-control">
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection