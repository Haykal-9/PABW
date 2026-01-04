<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use App\Models\Menu;
use App\Models\Favorite;

class MenuController extends Controller
{
    public function menu(Request $request)
    {
        $query = Menu::with('type')
            ->withAvg('reviews', 'rating')
            ->where('status_id', 1); // Only show available menus (tersedia)

        if ($request->has('category') && $request->category != 'all') {
            if ($request->category == 'favorite') {
                // Favorite filter requires authentication
                if (!Auth::check()) {
                    return redirect()->route('login')->with('error', 'Silakan login untuk melihat menu favorit.');
                }
                
                $favoriteMenuIds = Favorite::where('user_id', Auth::id())
                    ->pluck('menu_id')
                    ->toArray();
                $query->whereIn('id', $favoriteMenuIds);
            } else {
                $query->whereHas('type', function ($q) use ($request) {
                    $q->where('type_name', $request->category);
                });
            }
        }

        if ($request->has('search') && $request->search != null) {
            $searchTerm = $request->search;
            $query->where('nama', 'like', "%{$searchTerm}%");
        }

        $menus = $query->get();

        // Mark favorites only if user is logged in
        foreach ($menus as $menu) {
            $menu->is_favorited = Auth::check() && Favorite::where('user_id', Auth::id())
                ->where('menu_id', $menu->id)
                ->exists();
        }

        return view('customers.menu', compact('menus'));
    }

    public function favorite($id)
    {
        // Validate id parameter
        if (!is_numeric($id) || $id <= 0) {
            return redirect()->back()->with('error', 'ID menu tidak valid');
        }

        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login untuk menambahkan favorit.');
        }

        // Validate menu exists
        $menu = Menu::findOrFail($id);

        $exists = Favorite::where('user_id', Auth::id())
            ->where('menu_id', $id)
            ->exists();

        if ($exists) {
            Favorite::where('user_id', Auth::id())
                ->where('menu_id', $id)
                ->delete();

            return redirect()->back()->with('success', 'Menu dihapus dari favorit');
        } else {
            Favorite::create([
                'user_id' => Auth::id(),
                'menu_id' => $id
            ]);

            return redirect()->back()->with('success', 'Menu ditambahkan ke favorit');
        }
    }

    public function show($id)
    {
        // Validate id parameter
        if (!is_numeric($id) || $id <= 0) {
            return redirect()->route('menu')->with('error', 'ID menu tidak valid');
        }

        $menu = Menu::with(['type', 'reviews.user'])->withAvg('reviews', 'rating')->findOrFail($id);

        // Check if menu is available
        if ($menu->status_id != 1) {
            return redirect()->route('menu')->with('error', 'Menu tidak tersedia saat ini.');
        }

        // Check if menu is favorited (only if user is logged in)
        $menu->is_favorited = Auth::check() && Favorite::where('user_id', Auth::id())
            ->where('menu_id', $id)
            ->exists();

        return view('customers.detail', compact('menu'));
    }

    public function addToCart($id)
    {
        // Validate id parameter
        if (!is_numeric($id) || $id <= 0) {
            return redirect()->back()->with('error', 'ID menu tidak valid');
        }

        // Validate menu exists and is available
        $menu = Menu::findOrFail($id);

        // Check if menu is available (status_id = 1 means 'tersedia')
        if ($menu->status_id != 1) {
            return redirect()->back()->with('error', 'Menu tidak tersedia saat ini.');
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "name" => $menu->nama,
                "quantity" => 1,
                "price" => $menu->price,
                "photo" => $menu->url_foto
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Menu berhasil ditambahkan ke keranjang!');
    }
}