<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Data Dummy untuk Dashboard
        $data = [
            'pendapatanHariIni' => 450000,
            'menuTerjualHariIni' => 35,
            'totalPendapatan' => 98500000,
            'reservasiTerlaksana' => 150,
        ];

        return view('admin.dashboard', compact('data'));
    }

    public function menu()
    {
        // Data Dummy untuk Daftar Menu (DENGAN image_path BARU)
        $menus = [
            ['id' => 1, 'nama' => 'Kopi Tubruk Robusta', 'kategori' => 'Kopi', 'harga' => 15000, 'stok' => 99, 'status' => 'Tersedia', 'image_path' => 'foto/KOPITUBRUKROBUSTA.jpg'],
            ['id' => 2, 'nama' => 'Cappucino', 'kategori' => 'Kopi', 'harga' => 30000, 'stok' => 50, 'status' => 'Tersedia', 'image_path' => 'foto/CAPPUCINO.jpg'],
            ['id' => 3, 'nama' => 'Matcha Premium', 'kategori' => 'Non-Kopi', 'harga' => 40000, 'stok' => 30, 'status' => 'Tersedia', 'image_path' => 'foto/red.jpg'],
            ['id' => 4, 'nama' => 'Nasi Ayam Teriyaki', 'kategori' => 'Makanan', 'harga' => 35000, 'stok' => 15, 'status' => 'Tersedia', 'image_path' => 'foto/AyamTeriyaki.jpg'],
            ['id' => 5, 'nama' => 'Tempe Mendoan', 'kategori' => 'Cemilan', 'harga' => 18000, 'stok' => 25, 'status' => 'Habis', 'image_path' => 'foto/tempeMendoan.jpg'],
            ['id' => 6, 'nama' => 'Balabala', 'kategori' => 'Cemilan', 'harga' => 10000, 'stok' => 40, 'status' => 'Tersedia', 'image_path' => 'foto/balabala.jpg'],
        ];

        return view('admin.menu', compact('menus'));
    }

    public function users()
    {
        // Data Dummy untuk User
        $users = [
            ['id' => 1, 'nama' => 'Rina S.', 'email' => 'rina@example.com', 'role' => 'Customer', 'terdaftar' => '2024-09-01'],
            ['id' => 2, 'nama' => 'Andi K.', 'email' => 'andi@example.com', 'role' => 'Customer', 'terdaftar' => '2024-09-15'],
            ['id' => 3, 'nama' => 'Admin Utama', 'email' => 'admin@tapalkuda.com', 'role' => 'Admin', 'terdaftar' => '2024-08-01'],
            ['id' => 4, 'nama' => 'Santi W.', 'email' => 'santi@example.com', 'role' => 'Customer', 'terdaftar' => '2024-10-05'],
        ];

        return view('admin.users', compact('users'));
    }

    public function orders()
    {
        // Data Dummy untuk Riwayat Penjualan/Pesanan dengan Rincian Item
        $orders = [
            [
                'id' => 101, 
                'tanggal' => '2025-10-18 14:00', 
                'customer' => 'Rina S.', 
                'status' => 'Selesai', 
                'metode' => 'QRIS',
                'subtotal' => 40000,    // Total harga barang sebelum pajak
                'tax' => 4000,          // Pajak 10%
                'total' => 44000,       // Total akhir (subtotal + tax)
                'items' => [
                    ['name' => 'Kopi Tubruk Robusta', 'qty' => 1, 'price' => 15000, 'image_path' => 'foto/KOPITUBRUKROBUSTA.jpg'],
                    ['name' => 'Matcha Premium', 'qty' => 1, 'price' => 25000, 'image_path' => 'foto/red.jpg'],
                ]
            ],
            [
                'id' => 102, 
                'tanggal' => '2025-10-18 12:30', 
                'customer' => 'Anonim', 
                'status' => 'Selesai', 
                'metode' => 'Cash',
                'subtotal' => 77000,
                'tax' => 7700,
                'total' => 84700,
                'items' => [
                    ['name' => 'Nasi Ayam Teriyaki', 'qty' => 2, 'price' => 35000, 'image_path' => 'foto/AyamTeriyaki.jpg'],
                    ['name' => 'Teh Manis Dingin', 'qty' => 1, 'price' => 7000, 'image_path' => 'foto/TehManis.jpg'],
                ]
            ],
            [
                'id' => 103, 
                'tanggal' => '2025-10-17 20:15', 
                'customer' => 'Andi K.', 
                'status' => 'Batal', 
                'metode' => 'QRIS',
                'subtotal' => 30000,
                'tax' => 3000,
                'total' => 33000,
                'items' => [
                    ['name' => 'Cappucino', 'qty' => 1, 'price' => 30000, 'image_path' => 'foto/CAPPUCINO.jpg'],
                ]
            ],
        ];

        return view('admin.orders', compact('orders'));
    }

    public function reservations()
    {
        // Data Dummy untuk Reservasi (DENGAN EMAIL, TELEPON, DAN CATATAN BARU)
        $reservations = [
            [
                'kode' => 'RSV2025101901', 
                'tanggal' => '2025-10-25', 
                'jam' => '19:00', 
                'orang' => 4, 
                'nama' => 'Dummy User', 
                'email' => 'dummy@mail.com',      // BARU
                'phone' => '081234567890',         // BARU
                'status' => 'Dikonfirmasi',
                'note' => 'Butuh meja dekat jendela, ada anak kecil.', // BARU
            ],
            [
                'kode' => 'RSV2025101902', 
                'tanggal' => '2025-10-20', 
                'jam' => '15:30', 
                'orang' => 2, 
                'nama' => 'Joko Susanto', 
                'email' => 'joko@mail.com',
                'phone' => '085711223344',
                'status' => 'Menunggu Konfirmasi',
                'note' => 'Tidak ada catatan khusus.',
            ],
            [
                'kode' => 'RSV2025101801', 
                'tanggal' => '2025-10-18', 
                'jam' => '18:00', 
                'orang' => 5, 
                'nama' => 'Ani Mardiana', 
                'email' => 'ani@mail.com',
                'phone' => '081998877665',
                'status' => 'Selesai',
                'note' => 'Ulang tahun, mohon hiasan sederhana di meja.',
            ],
        ];

        return view('admin.reservations', compact('reservations'));
    }
    
    public function ratings()
    {
        // Data Dummy untuk Rating/Ulasan
        $ratings = [
            ['id' => 1, 'menu' => 'Iced TapalKuda Latte', 'user' => 'Rina S.', 'rating' => 5, 'ulasan' => 'Kopi terbaik di kota! Rasa creamy-nya pas.', 'tanggal' => '2025-10-18'],
            ['id' => 2, 'menu' => 'Nasi Ayam Teriyaki', 'user' => 'Andi K.', 'rating' => 4, 'ulasan' => 'Ayamnya enak, tapi porsinya sedikit kecil.', 'tanggal' => '2025-10-17'],
            ['id' => 3, 'menu' => 'Filter Coffee (V60)', 'user' => 'Santi W.', 'rating' => 5, 'ulasan' => 'Perfect brew, aroma sangat kuat.', 'tanggal' => '2025-10-15'],
        ];

        return view('admin.ratings', compact('ratings'));
    }
}