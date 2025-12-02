@extends('kasir.layouts.app')

@push('styles')
    <style>
        .reservasi-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
        }

        .reservasi-card {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 0.75rem;
            padding: 1.5rem;
            position: relative;
        }

        .reservasi-card h5 {
            font-weight: 600;
            color: var(--accent-color);
            margin-bottom: 1rem;
        }

        .reservasi-card p {
            margin-bottom: 0.5rem;
            color: var(--text-muted-color);
            font-size: 0.9rem;
        }

        .reservasi-card p strong {
            color: var(--text-color);
            min-width: 110px;
            display: inline-block;
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
            background-color: #e5e7eb;
            color: #374151;
        }

        .modal-btn-cancel:hover {
            background-color: #d1d5db;
        }

        .modal-btn-submit {
            background-color: #ef4444;
            color: white;
        }

        .modal-btn-submit:hover {
            background-color: #dc2626;
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
            <h1>Daftar Reservasi Pending</h1>
            <p>Kelola reservasi yang menunggu persetujuan dari pelanggan.</p>
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

        <div class="reservasi-grid">
            @forelse ($reservasi as $item)
                <div class="reservasi-card">
                    <h5>{{ $item['kode'] }}</h5>
                    <p><strong>Nama</strong>: {{ $item['nama'] }}</p>
                    <p><strong>Email</strong>: {{ $item['email'] }}</p>
                    <p><strong>No. Telepon</strong>: {{ $item['no_telp'] }}</p>
                    <p><strong>Jumlah Orang</strong>: {{ $item['jumlah_orang'] }} orang</p>
                    <p><strong>Tanggal</strong>: {{ $item['tanggal'] }}</p>
                    <p><strong>Pesan</strong>: {{ $item['pesan'] }}</p>

                    {{-- Action Buttons --}}
                    <div class="action-buttons">
                        {{-- Form Approve --}}
                        <form action="{{ route('kasir.reservasi.approve', $item['id']) }}" method="POST" style="flex: 1;">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn-approve"
                                onclick="return confirm('Apakah Anda yakin ingin menerima reservasi ini?')">
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
                <p class="text-center text-muted" style="grid-column: 1/-1;">Tidak ada reservasi yang menunggu persetujuan.</p>
            @endforelse
        </div>
    </main>

    {{-- Reject Modal --}}
    <div id="rejectModal" class="modal-overlay">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Tolak Reservasi</h3>
            </div>
            <form id="rejectForm" method="POST">
                @csrf
                <div class="modal-body">
                    <p style="margin-bottom: 1rem; color: var(--text-muted-color, #6b7280);">
                        Anda akan menolak reservasi: <strong id="rejectKode"></strong>
                    </p>
                    <label for="alasan">Alasan Penolakan <span style="color: #ef4444;">*</span></label>
                    <textarea name="alasan" id="alasan" placeholder="Contoh: Reservasi penuh untuk tanggal tersebut..."
                        required></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="modal-btn modal-btn-cancel" onclick="closeRejectModal()">
                        Batal
                    </button>
                    <button type="submit" class="modal-btn modal-btn-submit">
                        Tolak Reservasi
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

        function openRejectModal(reservasiId, kode) {
            // Set form action URL
            rejectForm.action = `/kasir/reservasi/${reservasiId}/reject`;

            // Set kode reservasi in modal
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