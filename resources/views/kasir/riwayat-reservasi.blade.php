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

        .form-control,
        .form-select {
            background-color: var(--sidebar-bg);
            color: var(--text-color);
            border: 1px solid var(--border-color);
        }

        .form-control::placeholder {
            color: var(--text-muted-color);
        }

        .form-control:focus,
        .form-select:focus {
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

        .table td,
        .table th {
            color: var(--text-color);
        }

        .table thead th {
            color: var(--text-muted-color);
        }

        .status-badge {
            padding: 0.3em 0.6em;
            border-radius: 0.25rem;
            font-size: 0.8em;
            font-weight: 600;
        }

        .status-dikonfirmasi {
            background-color: rgba(40, 167, 69, 0.2);
            color: #28a745;
        }

        .status-dibatalkan {
            background-color: rgba(220, 53, 69, 0.2);
            color: #dc3545;
        }

        .status-pending {
            background-color: rgba(255, 193, 7, 0.2);
            color: #ffc107;
        }

        /* Style untuk grup input pencarian */
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

        /* Filter Tabs */
        .filter-tabs {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }

        .filter-tab {
            padding: 0.5rem 1rem;
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            background-color: var(--sidebar-bg);
            color: var(--text-muted-color);
            cursor: pointer;
            transition: all 0.2s;
        }

        .filter-tab:hover {
            background-color: var(--card-bg);
            color: var(--text-color);
        }

        .filter-tab.active {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
            color: white;
        }

        /* Alert Styles */
        .alert {
            padding: 1rem 1.5rem;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
            font-weight: 500;
        }

        .alert-success {
            background-color: #d1fae5;
            color: #065f46;
            border: 1px solid #6ee7b7;
        }

        .alert-error {
            background-color: #fee2e2;
            color: #991b1b;
            border: 1px solid #fca5a5;
        }

        /* Status Dropdown */
        .status-select {
            padding: 0.25rem 0.5rem;
            font-size: 0.85rem;
            border-radius: 0.25rem;
            min-width: 130px;
        }

        @media (max-width: 992px) {
            .table-controls {
                flex-direction: column;
                gap: 1rem;
                align-items: stretch;
            }

            .table-controls .form-control,
            .table-controls .form-select,
            .input-group {
                max-width: 100%;
            }
        }
    </style>
@endpush

@section('content')
    <main class="content">
        <div class="header">
            <h1>Riwayat Reservasi</h1>
            <p>Lihat dan kelola semua reservasi yang telah dikonfirmasi atau dibatalkan.</p>
        </div>

        {{-- Alert Notifikasi --}}
        @if(session('success'))
            <div class="alert alert-success">
                ✓ {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                ✗ {{ session('error') }}
            </div>
        @endif

        <div class="table-container mt-4">
            <!-- Filter Tabs -->
            <div class="filter-tabs">
                <button class="filter-tab active" data-filter="semua">Semua</button>
                <button class="filter-tab" data-filter="dikonfirmasi">Dikonfirmasi</button>
                <button class="filter-tab" data-filter="dibatalkan">Dibatalkan</button>
            </div>

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

                <div class="input-group input-group-sm">
                    <input type="search" class="form-control" id="search-input" placeholder="Cari...">
                    <button class="btn" type="button" id="search-btn"><i class="bi bi-search"></i></button>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Tanggal Reservasi</th>
                            <th>Nama</th>
                            <th>Jumlah Orang</th>
                            <th>Status</th>
                            <th>Ubah Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="reservasi-table-body">
                        {{-- Baris tabel akan dirender oleh JavaScript --}}
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    {{-- Modal Detail Reservasi --}}
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel">Detail Reservasi</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body" id="detailModalBody"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Hidden Forms for Status Update --}}
    <form id="status-update-form" method="POST" style="display: none;">
        @csrf
        @method('PATCH')
        <input type="hidden" name="status_id" id="status-id-input">
    </form>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Data dari Controller
            const reservasiData = {!! json_encode($riwayatReservasi) !!};

            // DOM Elements
            const tableBody = document.getElementById('reservasi-table-body');
            const searchInput = document.getElementById('search-input');
            const searchBtn = document.getElementById('search-btn');
            const entriesSelect = document.getElementById('entries-select');
            const filterTabs = document.querySelectorAll('.filter-tab');
            const detailModal = new bootstrap.Modal(document.getElementById('detailModal'));
            const detailModalBody = document.getElementById('detailModalBody');
            const statusForm = document.getElementById('status-update-form');
            const statusIdInput = document.getElementById('status-id-input');

            let currentFilter = 'semua';

            const getStatusInfo = (status) => {
                switch(status) {
                    case 'dikonfirmasi':
                        return { class: 'status-dikonfirmasi', text: 'Dikonfirmasi', id: 2 };
                    case 'dibatalkan':
                        return { class: 'status-dibatalkan', text: 'Dibatalkan', id: 3 };
                    default:
                        return { class: 'status-pending', text: 'Pending', id: 1 };
                }
            };

            const renderTable = () => {
                const searchTerm = searchInput.value.toLowerCase();
                const entries = parseInt(entriesSelect.value);

                let filteredData = reservasiData.filter(item => {
                    // Filter by status
                    if (currentFilter !== 'semua' && item.status !== currentFilter) {
                        return false;
                    }
                    // Filter by search term
                    return item.kode.toLowerCase().includes(searchTerm) ||
                        item.nama.toLowerCase().includes(searchTerm) ||
                        item.no_telp.toLowerCase().includes(searchTerm);
                }).slice(0, entries);

                tableBody.innerHTML = '';
                if (filteredData.length === 0) {
                    tableBody.innerHTML = '<tr><td colspan="7" class="text-center">Data tidak ditemukan.</td></tr>';
                    return;
                }

                filteredData.forEach(item => {
                    const statusInfo = getStatusInfo(item.status);
                    const currentStatusId = statusInfo.id;
                    
                    tableBody.innerHTML += `
                    <tr>
                        <td>${item.kode}</td>
                        <td>${item.tanggal}</td>
                        <td>${item.nama}</td>
                        <td>${item.jumlah_orang} orang</td>
                        <td><span class="status-badge ${statusInfo.class}">${statusInfo.text}</span></td>
                        <td>
                            <select class="form-select form-select-sm status-select" data-id="${item.id}" data-current="${currentStatusId}">
                                <option value="1" ${currentStatusId === 1 ? 'selected' : ''}>Pending</option>
                                <option value="2" ${currentStatusId === 2 ? 'selected' : ''}>Dikonfirmasi</option>
                                <option value="3" ${currentStatusId === 3 ? 'selected' : ''}>Dibatalkan</option>
                            </select>
                        </td>
                        <td><button class="btn btn-sm btn-outline-light detail-btn" data-id="${item.id}"><i class="bi bi-eye"></i> Detail</button></td>
                    </tr>
                `;
                });

                // Add event listeners to status dropdowns
                document.querySelectorAll('.status-select').forEach(select => {
                    select.addEventListener('change', handleStatusChange);
                });
            };

            const handleStatusChange = (e) => {
                const select = e.target;
                const reservasiId = select.dataset.id;
                const currentStatus = select.dataset.current;
                const newStatus = select.value;

                if (newStatus === currentStatus) {
                    return;
                }

                const statusNames = {
                    '1': 'Pending',
                    '2': 'Dikonfirmasi',
                    '3': 'Dibatalkan'
                };

                if (confirm(`Apakah Anda yakin ingin mengubah status menjadi "${statusNames[newStatus]}"?`)) {
                    // Submit form
                    statusForm.action = `/kasir/riwayat-reservasi/${reservasiId}/update-status`;
                    statusIdInput.value = newStatus;
                    statusForm.submit();
                } else {
                    // Reset to current value
                    select.value = currentStatus;
                }
            };

            const showDetailModal = (id) => {
                const item = reservasiData.find(r => r.id === id);
                if (!item) return;

                const statusInfo = getStatusInfo(item.status);

                let alasanHtml = '';
                if (item.status === 'dibatalkan' && item.alasan_ditolak) {
                    alasanHtml = `
                    <hr class="border-secondary">
                    <h6 class="text-danger">Alasan Penolakan:</h6>
                    <p class="mb-1">${item.alasan_ditolak}</p>
                    <small class="text-muted">Ditolak oleh: ${item.ditolak_oleh || '-'}</small>
                `;
                }

                detailModalBody.innerHTML = `
                <p><strong>Kode Reservasi:</strong> ${item.kode}</p>
                <p><strong>Status:</strong> <span class="status-badge ${statusInfo.class}">${statusInfo.text}</span></p>
                <hr class="border-secondary">
                <h6>Informasi Pelanggan:</h6>
                <p class="mb-1"><strong>Nama:</strong> ${item.nama}</p>
                <p class="mb-1"><strong>Email:</strong> ${item.email}</p>
                <p class="mb-1"><strong>No. Telepon:</strong> ${item.no_telp}</p>
                <hr class="border-secondary">
                <h6>Detail Reservasi:</h6>
                <p class="mb-1"><strong>Tanggal:</strong> ${item.tanggal}</p>
                <p class="mb-1"><strong>Jumlah Orang:</strong> ${item.jumlah_orang} orang</p>
                <p class="mb-1"><strong>Pesan:</strong> ${item.pesan}</p>
                ${alasanHtml}
            `;
                detailModal.show();
            };

            // Event Listeners
            searchInput.addEventListener('input', renderTable);
            searchBtn.addEventListener('click', renderTable);
            entriesSelect.addEventListener('change', renderTable);

            // Filter tabs
            filterTabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    filterTabs.forEach(t => t.classList.remove('active'));
                    tab.classList.add('active');
                    currentFilter = tab.dataset.filter;
                    renderTable();
                });
            });

            tableBody.addEventListener('click', (e) => {
                const detailButton = e.target.closest('.detail-btn');
                if (detailButton) {
                    showDetailModal(parseInt(detailButton.dataset.id));
                }
            });

            // Initial Render
            renderTable();
        });
    </script>
@endpush