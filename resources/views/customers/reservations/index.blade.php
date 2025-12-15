@extends('customers.layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-6xl">
    {{-- Header --}}
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Reservasi Saya</h1>
                <p class="text-gray-600">Kelola semua reservasi Anda di sini</p>
            </div>
            <a href="{{ route('reservasi.create') }}" class="bg-amber-600 hover:bg-amber-700 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                <i class="fas fa-plus mr-2"></i>Buat Reservasi Baru
            </a>
        </div>
    </div>

    {{-- Alert Messages --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center">
            <i class="fas fa-check-circle mr-3"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6 flex items-center">
            <i class="fas fa-exclamation-circle mr-3"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    {{-- Filter Tabs --}}
    <div class="mb-6 border-b border-gray-200">
        <nav class="flex space-x-4" id="reservation-tabs">
            <button class="tab-button active px-4 py-3 font-medium text-amber-600 border-b-2 border-amber-600 transition-colors" data-filter="all">
                Semua ({{ $reservations->total() }})
            </button>
            <button class="tab-button px-4 py-3 font-medium text-gray-500 hover:text-gray-700 border-b-2 border-transparent transition-colors" data-filter="pending">
                Pending ({{ $reservations->where('status_id', 1)->count() }})
            </button>
            <button class="tab-button px-4 py-3 font-medium text-gray-500 hover:text-gray-700 border-b-2 border-transparent transition-colors" data-filter="confirmed">
                Dikonfirmasi ({{ $reservations->where('status_id', 2)->count() }})
            </button>
            <button class="tab-button px-4 py-3 font-medium text-gray-500 hover:text-gray-700 border-b-2 border-transparent transition-colors" data-filter="cancelled">
                Dibatalkan ({{ $reservations->where('status_id', 3)->count() }})
            </button>
        </nav>
    </div>

    {{-- Reservations List --}}
    @if($reservations->isEmpty())
        <div class="bg-white rounded-lg shadow-md p-12 text-center">
            <div class="mb-4">
                <i class="fas fa-calendar-alt text-gray-300 text-6xl"></i>
            </div>
            <h3 class="text-xl font-semibold text-gray-700 mb-2">Belum Ada Reservasi</h3>
            <p class="text-gray-500 mb-6">Anda belum membuat reservasi apapun</p>
            <a href="{{ route('reservasi.create') }}" class="bg-amber-600 hover:bg-amber-700 text-white px-8 py-3 rounded-lg font-medium inline-block transition-colors">
                Buat Reservasi
            </a>
        </div>
    @else
        <div class="space-y-4">
            @foreach($reservations as $reservasi)
                @php
                    $statusColors = [
                        1 => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800', 'border' => 'border-yellow-300'],
                        2 => ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'border' => 'border-green-300'],
                        3 => ['bg' => 'bg-red-100', 'text' => 'text-red-800', 'border' => 'border-red-300'],
                    ];
                    $color = $statusColors[$reservasi->status_id] ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-800', 'border' => 'border-gray-300'];
                    
                    $reservationDate = \Carbon\Carbon::parse($reservasi->tanggal_reservasi);
                    $isPast = $reservationDate->isPast();
                    $isUpcoming = $reservationDate->isFuture() && $reservasi->status_id != 3;
                @endphp
                
                <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow border-l-4 {{ $color['border'] }}" data-status="{{ $reservasi->status_id }}">
                    <div class="p-6">
                        <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-3">
                                    <h3 class="text-lg font-bold text-gray-800">
                                        {{ $reservasi->kode_reservasi }}
                                    </h3>
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $color['bg'] }} {{ $color['text'] }}">
                                        {{ ucfirst($reservasi->status->status_name ?? 'Unknown') }}
                                    </span>
                                    @if($isUpcoming && $reservasi->status_id == 2)
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                                            <i class="fas fa-clock mr-1"></i>Upcoming
                                        </span>
                                    @endif
                                </div>
                                
                                <div class="grid md:grid-cols-2 gap-3 text-sm text-gray-600">
                                    <div class="flex items-center">
                                        <i class="far fa-calendar text-amber-600 w-5 mr-2"></i>
                                        <span class="font-medium">{{ $reservationDate->format('d F Y') }}</span>
                                    </div>
                                    <div class="flex items-center">
                                        <i class="far fa-clock text-amber-600 w-5 mr-2"></i>
                                        <span class="font-medium">{{ $reservationDate->format('H:i') }} WIB</span>
                                    </div>
                                    <div class="flex items-center">
                                        <i class="fas fa-users text-amber-600 w-5 mr-2"></i>
                                        <span>{{ $reservasi->jumlah_orang }} Orang</span>
                                    </div>
                                    <div class="flex items-center">
                                        <i class="fas fa-info-circle text-amber-600 w-5 mr-2"></i>
                                        <span>{{ $reservasi->status->description ?? 'N/A' }}</span>
                                    </div>
                                </div>

                                @if($reservasi->message)
                                    <div class="mt-3 p-3 bg-gray-50 rounded-lg text-sm">
                                        <p class="text-gray-700"><strong>Catatan:</strong> {{ $reservasi->message }}</p>
                                    </div>
                                @endif
                            </div>

                            <div class="flex flex-col gap-2 md:text-right">
                                <a href="{{ route('reservations.show', $reservasi->id) }}" 
                                   class="bg-amber-600 hover:bg-amber-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors text-center">
                                    <i class="fas fa-eye mr-1"></i>Lihat Detail
                                </a>
                                
                                @if(($reservasi->status_id == 1 || $reservasi->status_id == 2) && !$isPast)
                                    @php
                                        $hoursUntil = now()->diffInHours($reservationDate, false);
                                    @endphp
                                    
                                    @if($hoursUntil >= 2)
                                        <form action="{{ route('reservations.cancel', $reservasi->id) }}" method="POST" 
                                              onsubmit="return confirm('Apakah Anda yakin ingin membatalkan reservasi ini?')">
                                            @csrf
                                            <button type="submit" 
                                                    class="w-full bg-red-100 hover:bg-red-200 text-red-700 px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                                <i class="fas fa-times mr-1"></i>Batalkan
                                            </button>
                                        </form>
                                    @else
                                        <button class="w-full bg-gray-200 text-gray-500 px-4 py-2 rounded-lg text-sm font-medium cursor-not-allowed"
                                                disabled
                                                title="Tidak dapat dibatalkan kurang dari 2 jam sebelum waktu reservasi">
                                            <i class="fas fa-ban mr-1"></i>Tidak Bisa Dibatalkan
                                        </button>
                                    @endif
                                @endif

                                @if($isPast && $reservasi->status_id == 2)
                                    <span class="text-xs text-gray-500">
                                        <i class="fas fa-check-circle mr-1"></i>Sudah Selesai
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-8">
            {{ $reservations->links() }}
        </div>
    @endif
</div>

<script>
    // Tab filtering
    document.querySelectorAll('.tab-button').forEach(button => {
        button.addEventListener('click', function() {
            const filter = this.getAttribute('data-filter');
            
            // Update active tab
            document.querySelectorAll('.tab-button').forEach(btn => {
                btn.classList.remove('active', 'text-amber-600', 'border-amber-600');
                btn.classList.add('text-gray-500', 'border-transparent');
            });
            this.classList.add('active', 'text-amber-600', 'border-amber-600');
            this.classList.remove('text-gray-500', 'border-transparent');
            
            // Filter reservations
            document.querySelectorAll('[data-status]').forEach(card => {
                if (filter === 'all') {
                    card.style.display = 'block';
                } else {
                    const statusMap = {
                        'pending': '1',
                        'confirmed': '2',
                        'cancelled': '3'
                    };
                    if (card.getAttribute('data-status') === statusMap[filter]) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                }
            });
        });
    });
</script>

<style>
    .pagination {
        display: flex;
        justify-content: center;
        gap: 0.5rem;
    }
    .pagination .page-link {
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        color: #d97706;
        border: 1px solid #d1d5db;
    }
    .pagination .page-link:hover {
        background-color: #fef3c7;
    }
    .pagination .active .page-link {
        background-color: #d97706;
        color: white;
        border-color: #d97706;
    }
</style>
@endsection
