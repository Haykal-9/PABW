<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;

        foreach($cart as $id => $details) {
            $total += $details['price'] * $details['quantity'];
        }

        return view('customers.cart', compact('cart', 'total'));
    }

    public function addToCart($id)
    {
        $menu = Menu::find($id);

        $cart = session()->get('cart', []);

        if(isset($cart[$id])) {
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

    public function updateCart(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:menu,id',
            'quantity' => 'required|integer|min:1|max:100'
        ]);

        $cart = session()->get('cart');
        
        if(isset($cart[$request->id])){
            $cart[$request->id]["quantity"] = $request->quantity;
            
            session()->put('cart', $cart);
            
            return redirect()->back()->with('success', 'Keranjang berhasil diperbarui');
        }
        
        return redirect()->back()->with('error', 'Item tidak ditemukan di keranjang');
    }

    public function removeCart(Request $request)
    {
        $request->validate([
            'id' => 'required|integer'
        ]);

        $cart = session()->get('cart');
        
        if(isset($cart[$request->id])) {
            unset($cart[$request->id]);
            session()->put('cart', $cart);
            
            return redirect()->back()->with('success', 'Menu dihapus dari keranjang');
        }
        
        return redirect()->back()->with('error', 'Item tidak ditemukan di keranjang');
    }

    public function updateNote(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:menu,id',
            'note' => 'nullable|string|max:500'
        ]);

        $cart = session()->get('cart');
        
        if(isset($cart[$request->id])){
            $cart[$request->id]["note"] = $request->note;
            
            session()->put('cart', $cart);
            
            return redirect()->back()->with('success', 'Catatan berhasil disimpan');
        }
        
        return redirect()->back()->with('error', 'Item tidak ditemukan di keranjang');
    }
}