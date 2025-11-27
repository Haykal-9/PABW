<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\reservasi;
use Illuminate\Support\Facades\Auth; 

class ReservasiController extends Controller
{
    // Method untuk menampilkan form reservasi
    public function create()
    {
        // 1. Ambil data user yang sedang login untuk pre-fill
        $user = Auth::user(); 
        
        // Asumsi kolom no_telp ada di model User
        
        // 2. Kirim data user ke view
        return view('customers.Reservasi', compact('user'));
    }

    // Method untuk memproses dan menyimpan data reservasi
    public function store(Request $request)
    {
        // 1. VALIDASI DATA (Menggunakan nama field dari form yang sudah dikoreksi)
        $request->validate([
            'nama_pemesan' => 'required|string|max:100', // Dari name="nama_pemesan"
            'email_pemesan' => 'required|email|max:100', // Dari name="email_pemesan"
            'no_telp' => 'required|string|max:15',       // Dari name="no_telp"
            
            'tanggal_reservasi' => 'required|date_format:Y-m-d', // Dari name="tanggal_reservasi"
            'jam_reservasi' => 'required|date_format:H:i',       // Dari name="jam_reservasi"
            'jumlah_orang' => 'required|integer|min:1|max:20',    // Dari name="jumlah_orang"
            'message' => 'nullable|string|max:500',
        ]);
        
        // Gabungkan tanggal dan jam menjadi format datetime (kolom di DB: tanggal_reservasi)
        $dateTimeReservasi = $request->tanggal_reservasi . ' ' . $request->jam_reservasi . ':00';
        
        // Tentukan USER_ID
        $userId = Auth::check() ? Auth::id() : null; 

        // GENERATE KODE RESERVASI UNIK
        $kodeReservasi = 'RSV' . date('Ymd') . strtoupper(bin2hex(random_bytes(3)));

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
        
        // Cek dan simpan detail pemesan jika user tidak login (PENTING: kolom ini harus ada di tabel reservasi)
        // Karena kita tidak bisa menambahkan kolom ke tabel reservasi saat ini, 
        // kita berasumsi admin akan melihat detail dari kolom users jika user_id ada.
        // Jika Anda ingin menyimpan detail nama/email pemesan anonim, Anda HARUS menambah kolom di tabel reservasi.
        
        // SIMPAN KE DATABASE
        reservasi::create($dataReservasi);

        // REDIRECT DAN PESAN SUKSES
        return redirect()->route('home')->with('success', 'Reservasi Anda dengan kode ' . $kodeReservasi . ' berhasil dikirim. Menunggu konfirmasi Admin.');
    }
}