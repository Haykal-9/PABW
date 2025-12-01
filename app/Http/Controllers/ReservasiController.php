<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reservasi;
use Carbon\Carbon;

class ReservasiController extends Controller
{
    public function index()
    {
        // Tampilkan form reservasi
        return view('customers.reservasi');
    }

    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'tanggal_reservasi' => 'required|date|after:today',
            'jam_reservasi' => 'required',
            'jumlah_orang' => 'required|integer|min:1',
            'message' => 'nullable|string'
        ]);

        // 2. Setup Data
        $userId = Auth::id() ?? 7; // Hardcode User 7
        
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

        return redirect()->route('profile.show', $userId)->with('success', 'Reservasi berhasil dibuat! Tunggu konfirmasi dari admin/kasir.');
    }
}