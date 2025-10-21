@extends('kasir.layouts.app')

@push('styles')
<style>
    .table-container {
        background-color: var(--card-bg);
        padding: 1.5rem;
        border-radius: 0.75rem;
        border: 1px solid var(--border-color);
    }
    .table-controls {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }
    .form-control, .form-select {
        background-color: var(--sidebar-bg);
        color: var(--text-color);
        border: 1px solid var(--border-color);
    }
    .form-control::placeholder {
        color: var(--text-muted-color);
    }
    .form-control:focus, .form-select:focus {
        background-color: var(--sidebar-bg);
        color: var(--text-color);
        border-color: var(--accent-color);
        box-shadow: 0 0 0 0.25rem rgba(232, 123, 62, 0.25);
    }
    
    .table {
        --bs-table-bg: transparent;
        --bs-table-border-color: var(--border-color);
        --bs-table-striped-bg: rgba(255, 255, 255, 0.05);
        --bs-table-hover-bg: rgba(255, 255, 255, 0.075);
    }
    .table td, .table th {
        color: var(--text-color);
    }
    .table thead th {
        color: var(--text-muted-color);
    }

    .status-badge { padding: 0.3em 0.6em; border-radius: 0.25rem; font-size: 0.8em; font-weight: 600; }
    .status-selesai { background-color: rgba(40, 167, 69, 0.2); color: #28a745; }
    .status-batal { background-color: rgba(220, 53, 69, 0.2); color: #dc3545; }
    
    /* Style baru untuk grup input pencarian */
    .input-group {
        max-width: 240px;
    }
    .input-group .btn {
        background-color: var(--sidebar-bg);
        border: 1px solid var(--border-color);
        color: var(--text-muted-color);
    }
    .input-group .btn:hover {
        background-color: var(--card-bg);
        color: var(--text-color);
    }
    .input-group .form-control:focus {
        z-index: 3;
    }

    @media (max-width: 992px) {
        .table-controls { flex-direction: column; gap: 1rem; align-items: stretch; }
        .table-controls .form-control, .table-controls .form-select, .input-group { max-width: 100%; }
    }
</style>
@endpush

@section('content')
<main class="content">
    <div class="header">
        <h1>Riwayat Pesanan</h1>
        <p>Lihat dan kelola semua transaksi yang telah selesai.</p>
    </div>
    
    <div class="table-container mt-4">
        <div class="table-controls">
            <div class="d-flex align-items-center gap-2">
                <span>Tampilkan</span>
                <select class="form-select form-select-sm" id="entries-select" style="width: auto;">
                    <option value="5">5</option>
                    <option value="10" selected>10</option>
                    <option value="25">25</option>
                </select>
                <span>data</span>
            </div>
            
            <!-- Perubahan: Menggunakan Bootstrap Input Group -->
            <div class="input-group input-group-sm">
                <input type="search" class="form-control" id="search-input" placeholder="Cari...">
                <button class="btn" type="button" id="search-btn"><i class="bi bi-search"></i></button>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Kode</th><th>Tanggal</th><th>Pelanggan</th><th>Total</th><th>Status</th><th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="history-table-body">
                    {{-- Baris tabel akan dirender oleh JavaScript --}}
                </tbody>
            </table>
        </div>
    </div>
</main>

{{-- Modal Detail Pesanan --}}
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="detailModalLabel">Detail Pesanan</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="detailModalBody"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Data dari Controller
    const riwayatData = {!! json_encode($riwayat) !!};
    const detailData = {!! json_encode($detailStruk) !!};

    // DOM Elements
    const tableBody = document.getElementById('history-table-body');
    const searchInput = document.getElementById('search-input');
    const searchBtn = document.getElementById('search-btn'); // Tombol cari
    const entriesSelect = document.getElementById('entries-select');
    const detailModal = new bootstrap.Modal(document.getElementById('detailModal'));
    const detailModalBody = document.getElementById('detailModalBody');

    const formatRupiah = (number) => new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(number);

    const renderTable = () => {
        const searchTerm = searchInput.value.toLowerCase();
        const entries = parseInt(entriesSelect.value);
        const filteredData = riwayatData.filter(item => 
            item.kode.toLowerCase().includes(searchTerm) || item.pelanggan.toLowerCase().includes(searchTerm)
        ).slice(0, entries);

        tableBody.innerHTML = '';
        if (filteredData.length === 0) {
            tableBody.innerHTML = '<tr><td colspan="6" class="text-center">Data tidak ditemukan.</td></tr>';
            return;
        }

        filteredData.forEach(item => {
            const statusClass = item.status === 'Selesai' ? 'status-selesai' : 'status-batal';
            tableBody.innerHTML += `
                <tr>
                    <td>${item.kode}</td>
                    <td>${item.tanggal}</td>
                    <td>${item.pelanggan}</td>
                    <td>${formatRupiah(item.total)}</td>
                    <td><span class="status-badge ${statusClass}">${item.status}</span></td>
                    <td><button class="btn btn-sm btn-outline-light detail-btn" data-kode="${item.kode}"><i class="bi bi-eye"></i> Detail</button></td>
                </tr>
            `;
        });
    };

    const showDetailModal = (kode) => {
        const order = riwayatData.find(item => item.kode === kode);
        const detail = detailData[kode];
        if (!order || !detail) return;
        let itemsHtml = detail.items.map(item => `<div class="d-flex justify-content-between"><span>${item.nama} (x${item.qty})</span><span>${formatRupiah(item.qty * item.harga)}</span></div>`).join('');
        const subtotal = detail.items.reduce((sum, item) => sum + (item.qty * item.harga), 0);
        const pajakVal = subtotal * detail.pajak;
        const total = subtotal + pajakVal - detail.diskon;

        detailModalBody.innerHTML = `
            <p><strong>Kode:</strong> ${order.kode}</p><p><strong>Tanggal:</strong> ${order.tanggal}</p>
            <p><strong>Pelanggan:</strong> ${order.pelanggan}</p><p><strong>Kasir:</strong> ${detail.kasir}</p>
            <hr class="border-secondary"><h6>Rincian Item:</h6>${itemsHtml}<hr class="border-secondary">
            <div class="d-flex justify-content-between"><span>Subtotal:</span> <span>${formatRupiah(subtotal)}</span></div>
            <div class="d-flex justify-content-between"><span>Pajak (10%):</span> <span>${formatRupiah(pajakVal)}</span></div>
            <div class="d-flex justify-content-between mt-2 fw-bold"><span>Total:</span> <span>${formatRupiah(total)}</span></div>
        `;
        detailModal.show();
    };

    // Event Listeners
    searchInput.addEventListener('input', renderTable);
    searchBtn.addEventListener('click', renderTable); // Menambahkan event listener untuk tombol
    entriesSelect.addEventListener('change', renderTable);
    tableBody.addEventListener('click', (e) => {
        const detailButton = e.target.closest('.detail-btn');
        if (detailButton) {
            showDetailModal(detailButton.dataset.kode);
        }
    });
    
    // Initial Render
    renderTable();
});
</script>
@endpush

