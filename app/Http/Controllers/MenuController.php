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
        $userId = Auth::id() ?? 7;

        $query = Menu::with('type')->withAvg('reviews', 'rating');

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

        if ($request->has('search') && $request->search != null) {
            $searchTerm = $request->search;
            $query->where('nama', 'like', "%{$searchTerm}%");
        }

        $menus = $query->get();

        foreach ($menus as $menu) {
            $menu->is_favorited = Favorite::where('user_id', $userId)
                ->where('menu_id', $menu->id)
                ->exists();
        }

        return view('customers.menu', compact('menus'));
    }

    public function favorite($id)
    {
        $userId = auth()->id() ?? 7; 

        $exists = Favorite::where('user_id', $userId)
            ->where('menu_id', $id)
            ->exists();

        if ($exists) {
            Favorite::where('user_id', $userId)
                ->where('menu_id', $id)
                ->delete();

            return redirect()->back()->with('success', 'Menu dihapus dari favorit');
        } else {
            Favorite::create([
                'user_id' => $userId,
                'menu_id' => $id
            ]);

            return redirect()->back()->with('success', 'Menu ditambahkan ke favorit');
        }
    }

    public function show($id)
    {
        $menu = Menu::with('type')->withAvg('reviews', 'rating')->findOrFail($id);

        $userId = Auth::id() ?? 7;

        $menu->is_favorited = Favorite::where('user_id', $userId)
            ->where('menu_id', $id)
            ->exists();

        return view('customers.detail', compact('menu'));
    }

    public function addToCart($id)
    {
        $menu = Menu::find($id);

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