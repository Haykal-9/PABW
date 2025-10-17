<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        // Data dummy...
        $menus = [
            ['id' => 1, 'nama' => 'Kopi Tubruk Robusta', 'url_foto' => 'KOPITUBRUKROBUSTA.jpg', 'price' => 15000, 'type_name' => 'Kopi', 'status_name' => 'Tersedia'],
            // ... menu lainnya
        ];
        $menuCounts = ['Kopi' => 1, /* ... */];
        $totalAllMenus = 5;

        // Path view diubah ke 'customers.menu'
        return view('customers.menu', compact('menus', 'menuCounts', 'totalAllMenus'));
    }

    public function show($id)
    {
        // Data dummy...
        $product = (object) ['id' => $id, 'nama' => 'Kopi Tubruk Robusta', /* ... */];
        $reviews = [/* ... */];
        $recommendations = [/* ... */];

        // Path view diubah ke 'customers.detail'
        return view('customers.detail', compact('product', 'reviews', 'recommendations'));
    }
}