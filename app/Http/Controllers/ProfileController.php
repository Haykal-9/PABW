<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    // Menampilkan halaman profil; jika belum ada session/auth, tampilkan data dummy
    public function show()
    {
        // Cek apakah user terautentikasi
        if (auth()->check()) {
            $user = auth()->user();
        } else {
            // Data dummy sementara
            $user = (object) [
                'name' => 'Pengguna Demo',
                'email' => 'demo@example.com',
                'phone' => '081234567890',
                'address' => 'Jl. Contoh No.123, Kota'
            ];
        }

        return view('customers.profile', compact('user'));
    }

    public function orderHistory()
    {
        // Data dummy untuk riwayat pesanan
        $orders = [
            (object) ['id' => 1, 'order_date' => '2024-10-26 10:00', 'total_amount' => 33000, 'order_status_name' => 'Completed', 'order_type_name' => 'Dine In', 'payment_method_name' => 'Cash'],
            (object) ['id' => 2, 'order_date' => '2024-10-25 15:30', 'total_amount' => 20000, 'order_status_name' => 'Completed', 'order_type_name' => 'Take Away', 'payment_method_name' => 'QRIS']
        ];
    return view('customers.history.orders', compact('orders'));
    }

    public function reservationHistory()
    {
        // Data dummy untuk riwayat reservasi
        $reservations = [
            (object) ['kode_reservasi' => 'RSV20241026001', 'tanggal_reservasi' => '2024-11-01 19:00', 'jumlah_orang' => 4, 'reservation_status_name' => 'Dikonfirmasi'],
            (object) ['kode_reservasi' => 'RSV20241020001', 'tanggal_reservasi' => '2024-10-22 18:00', 'jumlah_orang' => 2, 'reservation_status_name' => 'Dibatalkan']
        ];
    return view('customers.history.reservations', compact('reservations'));
    }
}