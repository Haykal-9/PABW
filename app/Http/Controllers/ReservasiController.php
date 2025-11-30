<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\reservasi;
use App\Models\User; // Ditambahkan untuk mengambil data user di create
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Redirect; // <-- Ditambahkan
use Illuminate\Support\Str; // <-- Ditambahkan

class ReservasiController extends Controller
{
    // Method untuk menampilkan form reservasi
    public function create()
    {
        // 1. Ambil data user yang sedang login untuk pre-fill
        $user = Auth::user(); 
        
        // 2. Kirim data user ke view
        return view('customers.Reservasi', compact('user'));
    }

    // Method untuk memproses dan menyimpan data reservasi
    public function store(Request $request)
    {
        // 1. VALIDASI DATA
        $request->validate([
            'nama_pemesan' => 'required|string|max:100',
            'email_pemesan' => 'required|email|max:100',
            'no_telp' => 'required|string|max:15',
            
            'tanggal_reservasi' => 'required|date_format:Y-m-d', // Validasi format date
            'jam_reservasi' => 'required|date_format:H:i',       // Validasi format time
            'jumlah_orang' => 'required|integer|min:1|max:20',
            'message' => 'nullable|string|max:500',
        ]);
        
        // Gabungkan tanggal dan jam
        $dateTimeReservasi = $request->tanggal_reservasi . ' ' . $request->jam_reservasi . ':00';
        
        // 2. Cek Manual Waktu (harus di masa depan)
        if (strtotime($dateTimeReservasi) <= time()) {
             // *** PENTING: MENGGUNAKAN KEY UNIK 'reservasi_waktu_error' UNTUK MENGHINDARI BUG ***
             return Redirect::back()->withInput()->withErrors([
                 'reservasi_waktu_error' => 'Tanggal dan waktu reservasi harus di masa depan.'
             ]);
        }
        
        // Tentukan USER_ID
        $userId = Auth::check() ? Auth::id() : null; 

        // GENERATE KODE RESERVASI UNIK
        // Menggunakan Str::random() untuk keamanan yang lebih baik
        $kodeReservasi = 'RSV-' . Str::upper(Str::random(6));

        // SIAPKAN DATA UNTUK DISIMPAN
        $dataReservasi = [
            'user_id' => $userId,
            'kode_reservasi' => $kodeReservasi,
            // ID 1 = 'Menunggu Konfirmasi'
            'status_id' => 1, 
            'tanggal_reservasi' => $dateTimeReservasi,
            'jumlah_orang' => $request->jumlah_orang,
            'message' => $request->message,
        ];
        
        try {
            // SIMPAN KE DATABASE
            reservasi::create($dataReservasi);
        } catch (\Exception $e) {
            \Log::error('Reservasi gagal: ' . $e->getMessage());
            return Redirect::back()->withInput()->with('error', 'Gagal menyimpan reservasi. Silakan coba lagi.');
        }

        // REDIRECT DAN PESAN SUKSES
        return redirect()->route('home')->with('success', 'Reservasi Anda dengan kode ' . $kodeReservasi . ' berhasil dikirim. Menunggu konfirmasi Admin.');
    }
}