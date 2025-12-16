<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reservasi;
use App\Models\User;
use Carbon\Carbon;

class ReservasiController extends Controller
{
    public function index()
    {
        // Tampilkan form reservasi
        return view('customers.reservasi');
    }

    public function create()
    {
        // Ambil data user yang sedang login
        $user = Auth::user();

        // Tampilkan form reservasi dengan data user
        return view('customers.Reservasi', compact('user'));
    }

    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'tanggal_reservasi' => 'required|date|after_or_equal:today',
            'jam_reservasi' => 'required',
            'jumlah_orang' => 'required|integer|min:1',
            'message' => 'nullable|string'
        ]);

        // 2. Setup Data
        $userId = Auth::id();

        // Gabungkan Tanggal dan Jam
        $waktuFix = Carbon::parse($request->tanggal_reservasi . ' ' . $request->jam_reservasi);

        // Generate Kode Unik (Misal: RSV-20251201-007)
        $kode = 'RSV-' . now()->format('Ymd') . '-' . rand(100, 999);

        // 3. Simpan ke Database
        Reservasi::create([
            'user_id' => $userId,
            'kode_reservasi' => $kode,
            'tanggal_reservasi' => $waktuFix,
            'jumlah_orang' => $request->jumlah_orang,
            'message' => $request->message,
            'status_id' => 1, // ID 1 = PENDING (Menunggu Konfirmasi Kasir)
        ]);

        return redirect()->route('reservasi.create')->with('success', 'Reservasi berhasil dibuat! Kode reservasi Anda: ' . $kode . '. Tunggu konfirmasi dari kasir.');
    }

    public function cancel($id)
    {
        // Check authentication
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Get reservation with authorization check
        $reservasi = Reservasi::where('user_id', Auth::id())
            ->findOrFail($id);

        // Check if reservation can be cancelled
        // Only pending (1) or confirmed (2) reservations can be cancelled
        if ($reservasi->status_id == 3) {
            return redirect()->back()->with('error', 'Reservasi ini sudah dibatalkan sebelumnya.');
        }

        // Check if reservation date is not in the past
        if (Carbon::parse($reservasi->tanggal_reservasi)->isPast()) {
            return redirect()->back()->with('error', 'Tidak dapat membatalkan reservasi yang sudah lewat.');
        }

        // Check if reservation is less than 2 hours away (optional business rule)
        $reservationTime = Carbon::parse($reservasi->tanggal_reservasi);
        $hoursUntilReservation = now()->diffInHours($reservationTime, false);
        
        if ($hoursUntilReservation < 2 && $hoursUntilReservation > 0) {
            return redirect()->back()->with('error', 'Tidak dapat membatalkan reservasi kurang dari 2 jam sebelum waktu reservasi. Silakan hubungi restoran.');
        }

        // Update status to cancelled (status_id = 3)
        $reservasi->status_id = 3;
        $reservasi->save();

        return redirect()->back()->with('success', 'Reservasi berhasil dibatalkan.');
    }
}