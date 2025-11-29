@extends('customers.layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            
            {{-- Alert Sukses --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card shadow-sm border-0">
                <div class="card-body text-center pt-5 pb-4">
                    
                    {{-- Foto Profil --}}
                    <div class="mb-4 position-relative d-inline-block">
                        @if($user->profile_picture)
                            <img src="{{ asset('uploads/profile/' . $user->profile_picture) }}" 
                                 class="rounded-circle shadow-sm" 
                                 style="width: 150px; height: 150px; object-fit: cover; border: 4px solid #fff;">
                        @else
                            <img src="https://via.placeholder.com/150" 
                                 class="rounded-circle shadow-sm"
                                 style="width: 150px; height: 150px; object-fit: cover; border: 4px solid #fff;">
                        @endif
                    </div>

                    <h3 class="fw-bold mb-1">{{ $user->nama }}</h3>
                    <p class="text-muted mb-4">{{ $user->email }}</p>

                    <div class="row text-start px-md-5">
                        <div class="col-12 mb-3">
                            <label class="small text-muted fw-bold text-uppercase">No. Telepon</label>
                            <div class="fs-6">{{ $user->no_telp }}</div>
                        </div>
                        
                        <div class="col-12 mb-3">
                            <label class="small text-muted fw-bold text-uppercase">Alamat</label>
                            <div class="fs-6">{{ $user->alamat }}</div>
                        </div>

                        <div class="col-12 mb-4">
                            <label class="small text-muted fw-bold text-uppercase">Bergabung Sejak</label>
                            <div class="fs-6">{{ $user->created_at ? $user->created_at->format('d M Y') : '-' }}</div>
                        </div>
                    </div>

                    {{-- Tombol Menuju Edit --}}
                    <div class="d-grid gap-2 col-md-8 mx-auto">
                        <a href="{{ route('profile.edit', ['id' => $user->id]) }}" class="btn btn-outline-primary">
                            <i class="fas fa-edit me-2"></i> Edit Profil
                        </a>
                        <a href="/logout" class="btn btn-outline-danger mt-2">
                            Logout
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection