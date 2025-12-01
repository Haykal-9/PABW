<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Untuk cek user login
use App\Models\Menu;
use App\Models\Favorite;

class MenuController extends Controller
{
    public function menu(Request $request)
    {
        $userId = Auth::id() ?? 7;

        // 1. Mulai Query
        $query = Menu::with('type')->withAvg('reviews', 'rating');

        // 2. Logika Filter Kategori (Server-Side)
        if ($request->has('category') && $request->category != 'all') {
            if ($request->category == 'favorite') {
                $favoriteMenuIds = Favorite::where('user_id', $userId)
                    ->pluck('menu_id')
                    ->toArray();
                $query->whereIn('id', $favoriteMenuIds);
            } else {
                $query->whereHas('type', function ($q) use ($request) {
                    $q->where('type_name', $request->category);
                });
            }
        }

        // --- 3. LOGIKA BARU: SEARCH BAR ---
        if ($request->has('search') && $request->search != null) {
            $searchTerm = $request->search;
            // Cari berdasarkan nama menu yang mengandung kata kunci (Case Insensitive)
            $query->where('nama', 'like', "%{$searchTerm}%");
        }

        // 4. Eksekusi Query
        $menus = $query->get();

        // 5. Cek Favorit
        foreach ($menus as $menu) {
            $menu->is_favorited = Favorite::where('user_id', $userId)
                ->where('menu_id', $menu->id)
                ->exists();
        }

        return view('customers.menu', compact('menus'));
    }
    public function favorite($id)
    {
        $userId = auth()->id() ?? 7; // Hybrid Auth

        // Cek apakah data sudah ada menggunakan exists() agar lebih efisien
        $exists = Favorite::where('user_id', $userId)
            ->where('menu_id', $id)
            ->exists();

        if ($exists) {
            // KASUS 1: HAPUS (UNLIKE)
            // Kita gunakan where() -> delete() langsung. 
            // Ini aman karena tidak membutuhkan Primary Key di Model.
            Favorite::where('user_id', $userId)
                ->where('menu_id', $id)
                ->delete();

            return redirect()->back()->with('success', 'Menu dihapus dari favorit');
        } else {
            // KASUS 2: BUAT BARU (LIKE)
            Favorite::create([
                'user_id' => $userId,
                'menu_id' => $id
            ]);

            return redirect()->back()->with('success', 'Menu ditambahkan ke favorit');
        }
    }

    public function show($id)
    {
        // 1. Ambil data menu berdasarkan ID, sekalian load relasi type dan rating
        // Gunakan findOrFail agar jika ID ngawur (misal /menu/999) otomatis 404 Not Found
        $menu = Menu::with('type')->withAvg('reviews', 'rating')->findOrFail($id);

        // 2. Cek status favorit user terhadap menu ini
        $userId = Auth::id() ?? 7; // Hybrid Auth
        $menu->is_favorited = Favorite::where('user_id', $userId)
            ->where('menu_id', $id)
            ->exists();

        // 3. Kirim data ke view
        return view('customers.detail', compact('menu'));
    }

    public function addToCart($id)
    {
        // 1. Cari menu berdasarkan ID
        $menu = Menu::find($id);

        if (!$menu) {
            return redirect()->back()->with('error', 'Menu tidak ditemukan');
        }

        // 2. Ambil keranjang yang sudah ada di session (atau array kosong jika belum ada)
        $cart = session()->get('cart', []);

        // 3. Cek apakah menu ini sudah ada di keranjang?
        if (isset($cart[$id])) {
            // Jika sudah ada, tambahkan jumlahnya (Quantity + 1)
            $cart[$id]['quantity']++;
        } else {
            // Jika belum ada, masukkan data baru
            $cart[$id] = [
                "name" => $menu->nama,
                "quantity" => 1,
                "price" => $menu->price,
                "photo" => $menu->url_foto
            ];
        }

        // 4. Simpan kembali keranjang ke session
        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Menu berhasil ditambahkan ke keranjang!');
    }
}