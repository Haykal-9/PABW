@extends('layouts.kasir')
@section('title', 'Tapal Kuda | Profile')

@push('styles')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <style>
    /* Halaman profile tidak pakai panel kanan */
    .kasir-page main{ margin-right:0 !important; overflow:visible !important; }
    .kasir-page .orders-panel{ display:none !important; }

    /* Styling sederhana (opsional, bisa pindah ke CSS file) */
    .kasir-page .profile-container{
      max-width: 720px; margin: 0 auto; color: #e5e7eb;
      background:#2a3345; border-radius:16px; padding:24px 28px;
    }
    .kasir-page .profile-header{
      display:flex; align-items:center; gap:16px; margin-bottom:18px;
    }
    .kasir-page .profile-photo{
      width:96px; height:96px; border-radius:50%; object-fit:cover; background:#111827;
      border:2px solid rgba(255,255,255,.12);
    }
    .kasir-page .profile-header h1{ margin:0; font-size:20px; color:#fff; }
    .kasir-page .profile-header p{ margin:2px 0 0; color:#9ca3af; }

    .kasir-page .profile-info{ display:grid; grid-template-columns: 160px 1fr; row-gap:10px; }
    .kasir-page .info-label{ color:#9ca3af; }
    .kasir-page .info-value{ color:#fff; }

    .kasir-page .edit-button{
      margin-top:20px; display:inline-flex; align-items:center; gap:8px;
      background:#10b981; color:#fff; padding:10px 14px; border-radius:10px; text-decoration:none; font-weight:600;
    }
    .kasir-page .edit-button:hover{ filter:brightness(.95); }
  </style>
@endpush

@section('content')
<div class="kasir-page">
  <main>
    <header>
      <h1>Profil Kasir</h1>
      <p>Informasi akun kasir Tapal Kuda</p>
    </header>

    <section class="profile-container" aria-label="Profile">
      <div class="profile-header">
        {{-- Foto bisa berupa URL penuh dari controller, fallback ke placeholder --}}
        <img src="{{ $user['foto'] ?? 'https://placehold.co/140x140?text=User' }}"
             alt="Foto Profil" class="profile-photo">
        <div>
          <h1>{{ $user['nama'] ?? 'Nama tidak tersedia' }}</h1>
          <p>{{ $user['email'] ?? '—' }}</p>
        </div>
      </div>

      <div class="profile-info">
        <span class="info-label" style="color: white;">Name</span><br>
        <span class="info-value" style="color: white;">{{ $user['nama'] ?? '—' }}</span><br>

        <span class="info-label" style="color: white;">Email</span><br>
        <span class="info-value" style="color: white;">{{ $user['email'] ?? '—' }}</span><br>

        <span class="info-label" style="color: white;">Phone</span><br>
        <span class="info-value" style="color: white;">{{ $user['telepon'] ?? '—' }}</span><br>

        <span class="info-label" style="color: white;">Gender</span><br>
        <span class="info-value" style="color: white;">{{ $user['gender'] ?? '—' }}</span><br>

        <span class="info-label" style="color: white;">Address</span><br>
        <span class="info-value" style="color: white;">{{ $user['alamat'] ?? '—' }}</span><br>
      </div>

      {{-- Ganti route di bawah jika punya halaman edit profil --}}
      <a href="{{ route('kasir.profile') }}#"
         class="edit-button">
        <button><i class="fas fa-pencil-alt"></i> Edit Profile</button>
      </a>
    </section>
  </main>
</div>
@endsection
