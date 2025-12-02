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
        // Ambil data user dengan ID 7 (hardcoded untuk sementara)
        $user = User::find(10);

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
        $userId = 10; // Hardcode User 7 untuk sementara

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
}