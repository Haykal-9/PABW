@extends('layouts.kasir')
@section('title', 'Riwayat Pesanan Kasir')

@push('styles')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <style>
    /* Halaman riwayat tidak punya panel kanan */
    .kasir-page main{ margin-right:0 !important; overflow:visible !important; }
    .kasir-page .orders-panel{ display:none !important; }

    /* Tabel di tema gelap */
    .kasir-page .card{
      background:#2a3345; border-radius:12px; padding:16px 20px; color:#e5e7eb;
    }
    .kasir-page table{ width:100%; background:#1f2937; color:#e5e7eb; border-radius:8px; overflow:hidden; }
    .kasir-page thead th{ background:#111827; color:#cbd5e1; font-weight:600; }
    .kasir-page tbody tr + tr{ border-top:1px solid rgba(255,255,255,.06); }
    .kasir-page td, .kasir-page th{ padding:12px 14px; vertical-align:middle; }
    .kasir-page .badge{ display:inline-block; padding:.35rem .6rem; border-radius:10rem; font-weight:600; }
    .kasir-page .badge-success{ background:#16a34a; color:#fff; }
    .kasir-page .badge-danger{ background:#dc2626; color:#fff; }
  </style>
@endpush

@section('content')
<div class="kasir-page">
  <main>
    <header style="margin-bottom: 16px;">
      <h1>Riwayat Pesanan</h1>
      <p class="text-muted">Daftar semua pesanan yang telah diselesaikan oleh kasir.</p>
    </header>

    <section class="card">
      <div style="font-weight:600; margin-bottom:12px;">
        <i class="fas fa-table me-1"></i> Data Riwayat Pesanan
      </div>

      <div class="table-responsive">
        <table class="table table-striped table-hover table-sm align-middle">
          <thead class="table-dark">
            <tr>
              <th scope="col">No</th>
              <th scope="col">ID Pesanan</th>
              <th scope="col">Pembeli</th>
              <th scope="col">Tanggal</th>
              <th scope="col">Total</th>
              <th scope="col">Status</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($riwayat as $i => $r)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $r['kode'] }}</td>
                <td>{{ $r['pelanggan'] }}</td>
                <td>{{ $r['tanggal'] }}</td>
                <td>Rp{{ number_format($r['total'], 0, ',', '.') }}</td>
                <td>
                  @php
                    $ok = strtolower($r['status']) === 'selesai';
                  @endphp
                  <span style="color: black;" class="badge {{ $ok ? 'badge-success' : 'badge-danger' }}">
                    {{ ucfirst($r['status']) }}
                  </span>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="6" class="text-center">Belum ada riwayat pesanan.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </section>
  </main>
</div>
@endsection
