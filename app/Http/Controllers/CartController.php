<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;

class CartController extends Controller
{
    // 1. READ: Tampilkan Halaman Keranjang
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;

        // Hitung Total Belanja
        foreach($cart as $id => $details) {
            $total += $details['price'] * $details['quantity'];
        }

        return view('customers.cart', compact('cart', 'total'));
    }

    // 2. CREATE: Tambah ke Keranjang (Sudah dibuat sebelumnya)
    public function addToCart($id)
    {
        $menu = Menu::find($id);

        if(!$menu) {
            return redirect()->back()->with('error', 'Menu tidak ditemukan');
        }

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

    // 3. UPDATE: Ubah Jumlah Item
    public function updateCart(Request $request)
    {
        if($request->id && $request->quantity){
            $cart = session()->get('cart');
            
            // Update quantity di session
            $cart[$request->id]["quantity"] = $request->quantity;
            
            session()->put('cart', $cart);
            
            return redirect()->back()->with('success', 'Keranjang berhasil diperbarui');
        }
    }

    // 4. DELETE: Hapus Item dari Keranjang
    public function removeCart(Request $request)
    {
        if($request->id) {
            $cart = session()->get('cart');
            
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]); // Hapus item spesifik
                session()->put('cart', $cart);
            }
            
            return redirect()->back()->with('success', 'Menu dihapus dari keranjang');
        }
    }

    // 5. UPDATE NOTE: Tambah/Ubah Catatan Item
    public function updateNote(Request $request)
    {
        if($request->id){
            $cart = session()->get('cart');
            
            // Update note di session
            $cart[$request->id]["note"] = $request->note;
            
            session()->put('cart', $cart);
            
            return redirect()->back()->with('success', 'Catatan berhasil disimpan');
        }
    }
}