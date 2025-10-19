<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        // Data dummy terstruktur untuk ditampilkan dinamis di view
        $menus = [
            ['id' => 1, 'name' => 'Arabika', 'image_url' => 'foto/arabika.jpg', 'price' => 35000, 'category' => 'coffee', 'description_short' => 'Espresso, Fresh Milk, Sirup Vanila.'],
            ['id' => 2, 'name' => 'Matcha Premium', 'image_url' => 'foto/red.jpg', 'price' => 40000, 'category' => 'non-coffee', 'description_short' => 'Bubuk matcha Jepang dan susu segar.'],
            ['id' => 3, 'name' => 'Classic Croissant', 'image_url' => 'foto/kentangSosis.jpg', 'price' => 25000, 'category' => 'cemilan', 'description_short' => 'Roti lapis mentega Prancis.'],
            ['id' => 4, 'name' => 'Americano Dingin', 'image_url' => 'foto/AyamTeriyaki.jpg', 'price' => 20000, 'category' => 'makanan', 'description_short' => 'House blend TapalKuda dengan air dingin.'],
            ['id' => 5, 'name' => 'Snack Balabala', 'image_url' => 'foto/balabala.jpg', 'price' => 20000, 'category' => 'cemilan', 'description_short' => 'Cemilan renyah.'],
            ['id' => 6, 'name' => 'Cuanki', 'image_url' => 'foto/cuanki.png', 'price' => 20000, 'category' => 'makanan', 'description_short' => 'Cuanki gurih.'],
            ['id' => 7, 'name' => 'Espresso', 'image_url' => 'foto/ESPRESSO.jpg', 'price' => 20000, 'category' => 'coffee', 'description_short' => 'Espresso pekat.'],
            ['id' => 8, 'name' => 'Japan Special', 'image_url' => 'foto/JAPAN.jpg', 'price' => 20000, 'category' => 'coffee', 'description_short' => 'Varian Jepang.'],
            ['id' => 9, 'name' => 'Taro', 'image_url' => 'foto/taro.jpg', 'price' => 20000, 'category' => 'non-coffee', 'description_short' => 'Minuman taro manis.'],
            ['id' => 10, 'name' => 'Teh Manis', 'image_url' => 'foto/TehManis.jpg', 'price' => 20000, 'category' => 'non-coffee', 'description_short' => 'Teh manis tradisional.'],
            ['id' => 11, 'name' => 'Wedang', 'image_url' => 'foto/wedang.jpg', 'price' => 20000, 'category' => 'non-coffee', 'description_short' => 'Minuman hangat tradisional.'],
            ['id' => 12, 'name' => 'Nasi Tutug', 'image_url' => 'foto/nasiTutug.webp', 'price' => 20000, 'category' => 'makanan', 'description_short' => 'Nasi tutug enak.'],
        ];

        // Simple counts for sidebar (demo)
        $menuCounts = [
            'coffee' => 4,
            'non-coffee' => 4,
            'cemilan' => 2,
            'makanan' => 2,
        ];

        $totalAllMenus = count($menus);

        // Path view diubah ke 'customers.menu'
        return view('customers.menu', compact('menus', 'menuCounts', 'totalAllMenus'));
    }

    public function show($id)
    {
        // Data dummy untuk detail menu
        $product = (object) [
            'id' => $id,
            'name' => 'Kopi Tubruk Robusta',
            'price' => 15000,
            'description_long' => 'Kopi tubruk klasik dengan karakter robusta yang pekat.',
            'image_url' => 'foto/KOPITUBRUKROBUSTA.jpg',
            'category' => 'Kopi',
            'slug' => 'kopi-tubruk-robusta'
        ];

        $reviews = [];
        $recommendations = [];

        // Sesuaikan nama variabel agar view 'customers.detail' menerima $menu
        $menu = $product;

        return view('customers.detail', compact('menu', 'reviews', 'recommendations'));
    }
}