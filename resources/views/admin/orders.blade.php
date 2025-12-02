@extends('admin.layouts.app')

@section('admin_page_title', 'Riwayat Penjualan')

@section('admin_content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data Pesanan yang Terjual</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID Pesanan</th>
                        <th>Tanggal</th>
                        <th>Customer</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Metode Bayar</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order) {{-- PERBAIKAN: Menggunakan @forelse --}}
                    
                    {{-- Baris Utama Pesanan --}}
                    <tr class="align-middle">
                        <td>#{{ $order['id'] }}</td>
                        <td>{{ $order['tanggal'] }}</td>
                        <td>{{ $order['customer'] }}</td>
                        {{-- Menggunakan $order['total'] dari perhitungan Controller --}}
                        <td class="fw-bold">Rp {{ number_format($order['total'], 0, ',', '.') }}</td>
                        <td>
                             <span class="badge bg-{{ $order['status'] == 'Completed' ? 'success' : ($order['status'] == 'Cancelled' ? 'danger' : 'secondary') }}">
                                 {{ $order['status'] }}
                             </span>
                        </td>
                        <td>{{ $order['metode'] }}</td>
                        <td class="text-center">
                             {{-- Tombol untuk membuka rincian --}}
                            <button class="btn btn-sm btn-info text-white" type="button" data-bs-toggle="collapse" data-bs-target="#detail-{{ $order['id'] }}" aria-expanded="false" aria-controls="detail-{{ $order['id'] }}">
                                Rincian
                            </button>
                        </td>
                    </tr>
                    
                    {{-- Baris Rincian Pesanan (Akan Muncul saat di-klik) --}}
                    <tr>
                        <td colspan="7" class="p-0 border-0">
                            <div class="collapse" id="detail-{{ $order['id'] }}">
                                <div class="card card-body bg-light">
                                    <h6 class="fw-bold text-primary">Rincian Pesanan #{{ $order['id'] }}</h6>
                                    
                                    {{-- Tabel Rincian Item --}}
                                    <table class="table table-sm table-borderless mb-3">
                                        <thead class="border-bottom">
                                            <tr>
                                                <th style="width: 50px;"></th>
                                                <th>Nama Menu</th>
                                                <th class="text-center">Qty</th>
                                                <th class="text-end">Harga Satuan</th>
                                                <th class="text-end">Subtotal Item</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $subtotal_items = 0; @endphp
                                            {{-- PERBAIKAN: Menggunakan $order['items'] (aman jika null) --}}
                                            @foreach ($order['items'] ?? [] as $item)
                                                @php
                                                    $subtotal_item = $item['qty'] * $item['price'];
                                                    $subtotal_items += $subtotal_item;
                                                @endphp
                                                <tr>
                                                    <td>
                                                        {{-- Perlu penyesuaian path gambar (asumsi sudah diperbaiki di Controller) --}}
                                                        <img src="{{ asset($item['image_path'] ?? 'images/default.png') }}" alt="{{ $item['name'] }}" style="width: 40px; height: 40px; object-fit: cover; border-radius: 4px;">
                                                    </td>
                                                    <td>{{ $item['name'] }}</td>
                                                    <td class="text-center">{{ $item['qty'] }}</td>
                                                    <td class="text-end">Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
                                                    <td class="text-end">Rp {{ number_format($subtotal_item, 0, ',', '.') }}</td>
                                                </tr>
                                            @endforeach
                                            @if(empty($order['items'] ?? []))
                                                <tr>
                                                    <td colspan="5" class="text-center text-muted py-3">Tidak ada item pada pesanan ini.</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                    
                                    {{-- Ringkasan Total --}}
                                    <div class="row justify-content-end">
                                        <div class="col-md-5">
                                            <dl class="row small">
                                                {{-- PERBAIKAN: Menggunakan $order['subtotal'] dari Controller --}}
                                                <dt class="col-6 text-end">Subtotal Pesanan:</dt>
                                                <dd class="col-6 text-end">Rp {{ number_format($order['subtotal'], 0, ',', '.') }}</dd>
                                                
                                                {{-- PERBAIKAN: Menggunakan $order['tax'] dari Controller --}}
                                                <dt class="col-6 text-end border-top pt-1">Pajak (10%):</dt>
                                                <dd class="col-6 text-end border-top pt-1">Rp {{ number_format($order['tax'], 0, ',', '.') }}</dd>
                                                
                                                {{-- Menggunakan $order['total'] dari Controller --}}
                                                <dt class="col-6 text-end border-top pt-1 text-danger">TOTAL AKHIR:</dt>
                                                <dd class="col-6 text-end border-top pt-1 fw-bold text-danger">Rp {{ number_format($order['total'], 0, ',', '.') }}</dd>
                                            </dl>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </td>
                    </tr>
                    
                    @empty {{-- KETIKA DATA $orders KOSONG --}}
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada riwayat penjualan yang ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection