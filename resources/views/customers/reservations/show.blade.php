@extends('customers.layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-4xl">
    {{-- Back Button --}}
    <div class="mb-6">
        <a href="{{ route('reservations.index') }}" class="text-amber-600 hover:text-amber-700 font-medium">
            <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar Reservasi
        </a>
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

    {{-- Reservation Detail Card --}}
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        @php
            $statusColors = [
                1 => ['bg' => 'bg-yellow-600', 'light' => 'bg-yellow-100', 'text' => 'text-yellow-800'],
                2 => ['bg' => 'bg-green-600', 'light' => 'bg-green-100', 'text' => 'text-green-800'],
                3 => ['bg' => 'bg-red-600', 'light' => 'bg-red-100', 'text' => 'text-red-800'],
            ];
            $color = $statusColors[$reservasi->status_id] ?? ['bg' => 'bg-gray-600', 'light' => 'bg-gray-100', 'text' => 'text-gray-800'];
            
            $reservationDate = \Carbon\Carbon::parse($reservasi->tanggal_reservasi);
            $isPast = $reservationDate->isPast();
            $isUpcoming = $reservationDate->isFuture() && $reservasi->status_id != 3;
        @endphp

        {{-- Header --}}
        <div class="p-8 {{ $color['bg'] }} text-white">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-3xl font-bold mb-2">Detail Reservasi</h1>
                    <p class="text-white/90">{{ $reservasi->kode_reservasi }}</p>
                </div>
                <div class="mt-4 md:mt-0">
                    <span class="inline-block px-6 py-2 bg-white/20 backdrop-blur-sm rounded-full text-lg font-semibold">
                        {{ ucfirst($reservasi->status->status_name ?? 'Unknown') }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Content --}}
        <div class="p-8">
            {{-- Status Message --}}
            <div class="mb-8 p-4 {{ $color['light'] }} rounded-lg">
                <p class="{{ $color['text'] }} font-medium">
                    <i class="fas fa-info-circle mr-2"></i>
                    {{ $reservasi->status->description ?? 'Status tidak diketahui' }}
                </p>
            </div>

            {{-- Reservation Details --}}
            <div class="grid md:grid-cols-2 gap-8 mb-8">
                {{-- Date & Time --}}
                <div>
                    <h3 class="text-sm font-semibold text-gray-500 uppercase mb-4">Waktu Reservasi</h3>
                    <div class="space-y-3">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 {{ $color['light'] }} rounded-lg flex items-center justify-center">
                                <i class="far fa-calendar text-xl {{ $color['text'] }}"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Tanggal</p>
                                <p class="font-semibold text-gray-800">{{ $reservationDate->format('d F Y') }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 {{ $color['light'] }} rounded-lg flex items-center justify-center">
                                <i class="far fa-clock text-xl {{ $color['text'] }}"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Waktu</p>
                                <p class="font-semibold text-gray-800">{{ $reservationDate->format('H:i') }} WIB</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 {{ $color['light'] }} rounded-lg flex items-center justify-center">
                                <i class="fas fa-users text-xl {{ $color['text'] }}"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Jumlah Tamu</p>
                                <p class="font-semibold text-gray-800">{{ $reservasi->jumlah_orang }} Orang</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Timeline Status --}}
                <div>
                    <h3 class="text-sm font-semibold text-gray-500 uppercase mb-4">Status Timeline</h3>
                    <div class="space-y-4">
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-check text-green-600 text-sm"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-800">Reservasi Dibuat</p>
                                <p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($reservasi->created_at)->format('d M Y, H:i') }}</p>
                            </div>
                        </div>

                        @if($reservasi->status_id == 2)
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-check text-green-600 text-sm"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800">Dikonfirmasi</p>
                                    <p class="text-sm text-gray-500">Reservasi telah dikonfirmasi oleh staff</p>
                                </div>
                            </div>
                        @elseif($reservasi->status_id == 3)
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-times text-red-600 text-sm"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800">Dibatalkan</p>
                                    <p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($reservasi->updated_at)->format('d M Y, H:i') }}</p>
                                </div>
                            </div>
                        @else
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center flex-shrink-0 animate-pulse">
                                    <i class="fas fa-clock text-yellow-600 text-sm"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800">Menunggu Konfirmasi</p>
                                    <p class="text-sm text-gray-500">Staff akan mengkonfirmasi segera</p>
                                </div>
                            </div>
                        @endif

                        @if($isUpcoming && $reservasi->status_id == 2)
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-calendar-check text-blue-600 text-sm"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800">Upcoming</p>
                                    <p class="text-sm text-gray-500">Jangan lupa datang tepat waktu!</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Customer Message --}}
            @if($reservasi->message)
                <div class="mb-8">
                    <h3 class="text-sm font-semibold text-gray-500 uppercase mb-3">Catatan Reservasi</h3>
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <p class="text-gray-700">{{ $reservasi->message }}</p>
                    </div>
                </div>
            @endif

            {{-- Important Notice for Upcoming Reservations --}}
            @if($isUpcoming && $reservasi->status_id == 2)
                @php
                    $hoursUntil = now()->diffInHours($reservationDate, false);
                    $daysUntil = now()->diffInDays($reservationDate, false);
                @endphp
                
                <div class="mb-8 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <div class="flex items-start gap-3">
                        <i class="fas fa-info-circle text-blue-600 text-xl"></i>
                        <div>
                            <p class="font-semibold text-blue-800 mb-1">Pengingat</p>
                            <p class="text-blue-700 text-sm">
                                @if($daysUntil == 0)
                                    Reservasi Anda hari ini! Pastikan datang {{ $hoursUntil }} jam lagi.
                                @elseif($daysUntil == 1)
                                    Reservasi Anda besok. Jangan lupa!
                                @else
                                    Reservasi Anda {{ $daysUntil }} hari lagi.
                                @endif
                            </p>
                            <p class="text-blue-600 text-sm mt-2">
                                Jika berhalangan hadir, harap batalkan minimal 2 jam sebelum waktu reservasi.
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Action Buttons --}}
            <div class="flex flex-wrap gap-3 pt-6 border-t border-gray-200">
                @if(($reservasi->status_id == 1 || $reservasi->status_id == 2) && !$isPast)
                    @php
                        $hoursUntil = now()->diffInHours($reservationDate, false);
                    @endphp
                    
                    @if($hoursUntil >= 2)
                        <form action="{{ route('reservations.cancel', $reservasi->id) }}" method="POST" class="inline"
                              onsubmit="return confirm('Apakah Anda yakin ingin membatalkan reservasi ini? Tindakan ini tidak dapat dibatalkan.')">
                            @csrf
                            <button type="submit" 
                                    class="bg-red-100 hover:bg-red-200 text-red-700 px-6 py-3 rounded-lg font-medium transition-colors">
                                <i class="fas fa-times mr-2"></i>Batalkan Reservasi
                            </button>
                        </form>
                    @else
                        <div class="bg-gray-100 text-gray-500 px-6 py-3 rounded-lg font-medium">
                            <i class="fas fa-ban mr-2"></i>Tidak dapat dibatalkan (kurang dari 2 jam)
                        </div>
                        <p class="text-sm text-gray-600 w-full">
                            Untuk pembatalan mendesak, silakan hubungi restoran langsung.
                        </p>
                    @endif
                @endif

                <a href="{{ route('reservasi.create') }}" 
                   class="bg-amber-600 hover:bg-amber-700 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                    <i class="fas fa-plus mr-2"></i>Buat Reservasi Baru
                </a>
            </div>

            {{-- Contact Information --}}
            <div class="mt-8 pt-6 border-t border-gray-200">
                <p class="text-sm text-gray-500 text-center">
                    Ada pertanyaan tentang reservasi Anda?<br>
                    Hubungi kami di <strong>+62 XXX-XXXX-XXXX</strong> atau kunjungi restoran kami.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
