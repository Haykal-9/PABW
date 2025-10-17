<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Menampilkan halaman daftar menu.
     */
    public function index()
    {
        // Data dummy untuk menu
        $menus = [
            ['id' => 1, 'nama' => 'Kopi Tubruk Robusta', 'url_foto' => 'KOPITUBRUKROBUSTA.jpg', 'price' => 15000, 'type_name' => 'Kopi', 'status_name' => 'Tersedia'],
            ['id' => 2, 'nama' => 'V60', 'url_foto' => 'V60.jpg', 'price' => 18000, 'type_name' => 'Kopi', 'status_name' => 'Tersedia'],
            ['id' => 3, 'nama' => 'Indomie Goreng', 'url_foto' => 'indomieGoreng.jpg', 'price' => 12000, 'type_name' => 'Makanan_Berat', 'status_name' => 'Tersedia'],
            ['id' => 4, 'nama' => 'Bala-Bala', 'url_foto' => 'balabala.jpg', 'price' => 5000, 'type_name' => 'Cemilan', 'status_name' => 'Habis'],
            ['id' => 5, 'nama' => 'Es Teh Manis', 'url_foto' => 'TehManis.jpg', 'price' => 8000, 'type_name' => 'Minuman', 'status_name' => 'Tersedia'],
        ];

        // Data dummy untuk jumlah item per kategori
        $menuCounts = [
            'Kopi' => 2,
            'Minuman' => 1,
            'Makanan_Berat' => 1,
            'Cemilan' => 1,
        ];
        
        $totalAllMenus = 5;

        return view('menu', compact('menus', 'menuCounts', 'totalAllMenus'));
    }

    /**
     * Menampilkan halaman detail satu menu.
     */
    public function show($id)
    {
        // Data dummy untuk detail produk
        $product = (object) [
            'id' => $id,
            'nama' => 'Kopi Tubruk Robusta',
            'url_foto' => 'KOPITUBRUKROBUSTA.jpg',
            'price' => 15000,
            'deskripsi' => 'Kopi hitam klasik yang dibuat dengan menyeduh bubuk kopi robusta langsung di dalam cangkir.',
            'type_name' => 'Kopi',
            'status_name' => 'Tersedia'
        ];

        // Data dummy untuk komentar/review
        $reviews = [
            ['username' => 'Budi', 'rating' => 5, 'comment' => 'Kopinya mantap!', 'created_at' => '2025-10-16', 'profile_picture' => 'user_5_1749625414.png'],
            ['username' => 'Ani', 'rating' => 4, 'comment' => 'Suasananya enak.', 'created_at' => '2025-10-15', 'profile_picture' => 'default-avatar.png']
        ];

        // Data dummy untuk rekomendasi
        $recommendations = [
            ['id' => 2, 'nama' => 'V60', 'url_foto' => 'V60.jpg'],
            ['id' => 3, 'nama' => 'Indomie Goreng', 'url_foto' => 'indomieGoreng.jpg'],
        ];

        return view('detail', compact('product', 'reviews', 'recommendations'));
    }
}