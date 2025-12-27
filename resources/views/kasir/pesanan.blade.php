@extends('kasir.layouts.app')

@push('styles')
    <style>
        .pesanan-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
        }

        .pesanan-card {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 0.75rem;
            padding: 1.5rem;
            position: relative;
        }

        .pesanan-card h5 {
            font-weight: 600;
            color: var(--accent-color);
            margin-bottom: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .pesanan-card .badge {
            font-size: 0.75rem;
            padding: 0.35rem 0.75rem;
            border-radius: 1rem;
        }

        .badge-pending {
            background-color: #f59e0b;
            color: #1a1d21;
        }

        .pesanan-card p {
            margin-bottom: 0.5rem;
            color: var(--text-muted-color);
            font-size: 0.9rem;
        }

        .pesanan-card p strong {
            color: var(--text-color);
            min-width: 110px;
            display: inline-block;
        }

        .items-list {
            background-color: var(--sidebar-bg);
            border-radius: 0.5rem;
            padding: 0.75rem;
            margin: 1rem 0;
            max-height: 150px;
            overflow-y: auto;
        }

        .item-row {
            display: flex;
            justify-content: space-between;
            padding: 0.5rem 0;
            border-bottom: 1px solid var(--border-color);
            font-size: 0.85rem;
        }

        .item-row:last-child {
            border-bottom: none;
        }

        .item-name {
            color: var(--text-color);
        }

        .item-qty {
            color: var(--text-muted-color);
        }

        .item-price {
            color: var(--accent-color);
            font-weight: 500;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            padding-top: 0.75rem;
            margin-top: 0.5rem;
            border-top: 2px solid var(--border-color);
            font-weight: 600;
        }

        .total-row .value {
            color: var(--accent-color);
            font-size: 1.1rem;
        }

        .action-buttons {
            display: flex;
            gap: 0.75rem;
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid var(--border-color);
        }

        .btn-approve {
            flex: 1;
            padding: 0.6rem 1rem;
            background-color: #10b981;
            color: white;
            border: none;
            border-radius: 0.5rem;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .btn-approve:hover {
            background-color: #059669;
        }

        .btn-reject {
            flex: 1;
            padding: 0.6rem 1rem;
            background-color: #ef4444;
            color: white;
            border: none;
            border-radius: 0.5rem;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .btn-reject:hover {
            background-color: #dc2626;
        }

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

        /* Modal Styles */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.6);
            z-index: 9998;
            animation: fadeIn 0.2s ease-out;
        }

        .modal-overlay.active {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background-color: var(--card-bg, white);
            border-radius: 1rem;
            padding: 2rem;
            max-width: 500px;
            width: 90%;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            animation: slideUp 0.3s ease-out;
            z-index: 9999;
        }

        .modal-header {
            margin-bottom: 1.5rem;
        }

        .modal-header h3 {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--text-color, #1f2937);
            margin: 0;
        }

        .modal-body {
            margin-bottom: 1.5rem;
        }

        .modal-body label {
            display: block;
            font-weight: 500;
            margin-bottom: 0.5rem;
            color: var(--text-color, #374151);
        }

        .modal-body textarea {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid var(--border-color, #d1d5db);
            border-radius: 0.5rem;
            font-size: 0.95rem;
            font-family: inherit;
            resize: vertical;
            min-height: 120px;
            background-color: var(--sidebar-bg);
            color: var(--text-color);
        }

        .modal-body textarea:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .modal-footer {
            display: flex;
            gap: 0.75rem;
            justify-content: flex-end;
        }

        .modal-btn {
            padding: 0.6rem 1.5rem;
            border: none;
            border-radius: 0.5rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
        }

        .modal-btn-cancel {
            background-color: #4b5563;
            color: white;
        }

        .modal-btn-cancel:hover {
            background-color: #374151;
        }

        .modal-btn-submit {
            background-color: #ef4444;
            color: white;
        }

        .modal-btn-submit:hover {
            background-color: #dc2626;
        }

        .empty-state {
            text-align: center;
            padding: 3rem;
            color: var(--text-muted-color);
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
@endpush

@section('content')
    <main class="content">
        <div class="header">
            <h1>Pesanan Masuk</h1>
            <p>Kelola pesanan yang menunggu konfirmasi dari pelanggan.</p>
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

        <div class="pesanan-grid">
            @forelse ($pesanan as $item)
                <div class="pesanan-card">
                    <h5>
                        {{ $item['kode'] }}
                        <span class="badge badge-pending">{{ $item['status'] }}</span>
                    </h5>
                    <p><strong>Pelanggan</strong>: {{ $item['nama'] }}</p>
                    <p><strong>Email</strong>: {{ $item['email'] }}</p>
                    <p><strong>No. Telepon</strong>: {{ $item['no_telp'] }}</p>
                    <p><strong>Tanggal</strong>: {{ $item['tanggal'] }}</p>
                    <p><strong>Tipe</strong>: {{ $item['order_type'] }}</p>
                    <p><strong>Pembayaran</strong>: {{ $item['payment_method'] }}</p>

                    {{-- Items List --}}
                    <div class="items-list">
                        @foreach ($item['items'] as $orderItem)
                            <div class="item-row">
                                <span class="item-name">{{ $orderItem['nama'] }}</span>
                                <span class="item-qty">x{{ $orderItem['quantity'] }}</span>
                                <span class="item-price">Rp {{ number_format($orderItem['subtotal'], 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                        <div class="total-row">
                            <span>Total</span>
                            <span class="value">Rp {{ number_format($item['total'], 0, ',', '.') }}</span>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="action-buttons">
                        {{-- Form Approve --}}
                        <form action="{{ route('kasir.pesanan.approve', $item['id']) }}" method="POST" style="flex: 1;">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn-approve" style="width: 100%;">
                                ✓ Terima
                            </button>
                        </form>

                        {{-- Button Reject (opens modal) --}}
                        <button type="button" class="btn-reject"
                            onclick="openRejectModal({{ $item['id'] }}, '{{ $item['kode'] }}')">
                            ✗ Tolak
                        </button>
                    </div>
                </div>
            @empty
                <div class="empty-state" style="grid-column: 1/-1;">
                    <i class="bi bi-bag-check"></i>
                    <h4>Tidak ada pesanan pending</h4>
                    <p>Semua pesanan sudah diproses.</p>
                </div>
            @endforelse
        </div>
    </main>

    {{-- Reject Modal --}}
    <div id="rejectModal" class="modal-overlay">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Tolak Pesanan</h3>
            </div>
            <form id="rejectForm" method="POST">
                @csrf
                <div class="modal-body">
                    <p style="margin-bottom: 1rem; color: var(--text-muted-color, #6b7280);">
                        Anda akan menolak pesanan: <strong id="rejectKode"></strong>
                    </p>
                    <label for="alasan">Alasan Penolakan <span style="color: #ef4444;">*</span></label>
                    <textarea name="alasan" id="alasan" placeholder="Contoh: Stok menu habis, restoran penuh..."
                        required></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="modal-btn modal-btn-cancel" onclick="closeRejectModal()">
                        Batal
                    </button>
                    <button type="submit" class="modal-btn modal-btn-submit">
                        Tolak Pesanan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const modal = document.getElementById('rejectModal');
        const rejectForm = document.getElementById('rejectForm');
        const rejectKode = document.getElementById('rejectKode');
        const alasanInput = document.getElementById('alasan');

        function openRejectModal(pesananId, kode) {
            // Set form action URL
            rejectForm.action = `/kasir/pesanan/${pesananId}/reject`;

            // Set kode pesanan in modal
            rejectKode.textContent = kode;

            // Clear previous input
            alasanInput.value = '';

            // Show modal
            modal.classList.add('active');

            // Focus on textarea
            setTimeout(() => alasanInput.focus(), 100);
        }

        function closeRejectModal() {
            modal.classList.remove('active');
            alasanInput.value = '';
        }

        // Close modal when clicking outside
        modal.addEventListener('click', function (e) {
            if (e.target === modal) {
                closeRejectModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && modal.classList.contains('active')) {
                closeRejectModal();
            }
        });
    </script>
@endpush