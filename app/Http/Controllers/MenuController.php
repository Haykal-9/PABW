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

        // 1. Mulai Query (Belum dieksekusi / get)
        $query = Menu::with('type');

        // 2. Logika Filter Server-Side
        // Jika ada parameter 'category' di URL dan isinya bukan 'all'
        if ($request->has('category') && $request->category != 'all') {
            if ($request->category == 'favorite') {
                // Filter menu favorit - ambil ID menu yang difavoritkan user
                $favoriteMenuIds = Favorite::where('user_id', $userId)
                    ->pluck('menu_id')
                    ->toArray();
                $query->whereIn('id', $favoriteMenuIds);
            } else {
                // Filter berdasarkan tipe menu
                $query->whereHas('type', function ($q) use ($request) {
                    $q->where('type_name', $request->category);
                });
            }
        }

        // 3. Eksekusi Query
        $menus = $query->get();

        // 4. Cek Favorit (Sama seperti sebelumnya)
        foreach ($menus as $menu) {
            $menu->is_favorited = Favorite::where('user_id', $userId)
                ->where('menu_id', $menu->id)
                ->exists();
        }

        return view('customers.menu', compact('menus'));
    }

    // --- LOGIKA UTAMA: TAMBAH / HAPUS FAVORIT ---
// --- FUNGSI FAVORIT (FIXED) ---
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
        $product = Menu::with('type')->find($id);

        if (!$product) {
            abort(404, 'Menu tidak ditemukan');
        }

        // Cek status favorit juga untuk halaman detail
        $userId = Auth::id() ?? 7;
        $isFavorited = Favorite::where('user_id', $userId)
            ->where('menu_id', $id)
            ->exists();

        // Format data object standard
        $menu = (object) [
            'id' => $product->id,
            'name' => $product->nama,
            'price' => $product->price,
            'description_long' => $product->deskripsi,
            'image_url' => 'foto/' . $product->url_foto,
            'category' => $product->type->type_name ?? 'Umum',
            'is_favorited' => $isFavorited // Kirim status ke view detail
        ];

        return view('customers.detail', compact('menu'));
    }
}