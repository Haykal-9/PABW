@extends('layouts.kasir')
@section('title', 'Tapal Kuda | Notifikasi Reservasi')

@push('styles')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <style>
    /* Halaman notifikasi tidak punya panel kanan */
    .kasir-page main{ margin-right:0 !important; overflow:visible !important; }
    .kasir-page .orders-panel{ display:none !important; }
    /* Styling kartu sederhana; bisa dipindah ke CSS file */
    .kasir-page .notification-list{ display:flex; flex-direction:column; gap:16px; }
    .kasir-page .notification-card{
      background:#2a3345; border-radius:12px; padding:16px 20px; color:#cbd5e1;
      display:flex; justify-content:space-between; align-items:flex-start; gap:16px;
    }
    .kasir-page .notification-card h3{ color:#fff; font-size:16px; margin:0 0 6px 0; }
    .kasir-page .notification-card .time{ font-size:12px; color:#9ca3af; margin:0 0 8px 0; }
    .kasir-page .notification-card .body{ margin:0; }
    .kasir-page .actions{ display:flex; gap:8px; }
    .kasir-page .btn-confirm{ background:#22c55e; color:#0b1; color:#0a1a12; color:#0a1a12; }
    .kasir-page .btn-confirm,
    .kasir-page .btn-cancel{
      border:none; border-radius:8px; padding:8px 14px; font-weight:600; cursor:pointer;
    }
    .kasir-page .btn-confirm{ background:#10b981; color:#fff; }
    .kasir-page .btn-cancel{ background:#dc3545; color:#fff; }
  </style>
@endpush

@section('content')
<div class="kasir-page">
  <main>
    <header>
      <h1>Notifikasi Reservasi</h1>
      <p>Daftar reservasi baru yang perlu dikonfirmasi</p>
    </header>

    <section class="notification-section" aria-label="Reservation Notifications">
      <div class="notification-container">
        <div class="notification-list">
          @forelse ($notifikasi as $n)
            <article class="notification-card">
              <div class="notification-info">
                <h3>{{ $n['judul'] }}</h3>
                <p class="time">{{ $n['waktu'] }}</p>
                <p class="body">{{ $n['isi'] }}</p>
              </div>

              {{-- Tombol contoh (opsional). Saat sudah pakai route Laravel, ganti action-nya. --}}
              <div class="actions">
                <button class="btn-confirm" type="button">Konfirmasi</button>
                <button class="btn-cancel"  type="button">Batalkan</button>
              </div>
            </article>
          @empty
            <p class="text-muted" style="color:#cbd5e1">Belum ada notifikasi.</p>
          @endforelse
        </div>
      </div>
    </section>
  </main>
</div>
@endsection
