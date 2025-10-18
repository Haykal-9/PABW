<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Data dummy untuk Statistik Dashboard
    private function getDummyStats()
    {
        return [
            'total_menu' => 12,
            'total_reservasi' => 5,
            'pendapatan_hari_ini' => 450000,
            'reservasi_pending' => 2,
        ];
    }

    // Data dummy untuk Kelola Menu
    private function getDummyMenus()
    {
        return [
            ['id' => 1, 'nama' => 'Arabika', 'kategori' => 'Kopi', 'harga' => 35000],
            ['id' => 2, 'nama' => 'Matcha Premium', 'kategori' => 'Non-Kopi', 'harga' => 40000],
            ['id' => 3, 'nama' => 'Kentang Sosis', 'kategori' => 'Cemilan', 'harga' => 25000],
            ['id' => 4, 'nama' => 'Nasi Ayam Teriyaki', 'kategori' => 'Makanan', 'harga' => 45000],
            ['id' => 5, 'nama' => 'Espresso', 'kategori' => 'Kopi', 'harga' => 28000],
            ['id' => 6, 'nama' => 'Japanese V60', 'kategori' => 'Kopi', 'harga' => 48000],
        ];
    }

    // Data dummy untuk Kelola Reservasi
    private function getDummyReservations()
    {
        return [
            ['id' => 1, 'nama' => 'Haykal', 'tanggal' => '2025-11-01', 'waktu' => '19:00', 'orang' => 4, 'status' => 'Dikonfirmasi'],
            ['id' => 2, 'nama' => 'Fadli', 'tanggal' => '2025-11-02', 'waktu' => '20:30', 'orang' => 2, 'status' => 'Pending'],
            ['id' => 3, 'nama' => 'Santi', 'tanggal' => '2025-11-03', 'waktu' => '18:00', 'orang' => 6, 'status' => 'Dibatalkan'],
        ];
    }

    public function index()
    {
        $stats = $this->getDummyStats();
        return view('admin.dashboard', compact('stats'));
    }

    public function menu()
    {
        $menus = $this->getDummyMenus();
        return view('admin.menu', compact('menus'));
    }

    public function reservations()
    {
        $reservations = $this->getDummyReservations();
        return view('admin.reservations', compact('reservations'));
    }
}