<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Pembayaran;
use App\Models\DetailPembayaran;
use App\Models\Menu;
use App\Models\User;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('menu')->with('error', 'Keranjang Anda kosong.');
        }

        $user = Auth::user() ?? User::find(7);

        $total = 0;
        foreach ($cart as $id => $details) {
            $total += $details['price'] * $details['quantity'];
        }

        return view('customers.layouts.checkout', compact('cart', 'total', 'user'));
    }

    public function store(Request $request)
    {
        $user = Auth::user() ?? User::find(7);
        $cart = session()->get('cart', []);
        $total = 0;

        foreach ($cart as $details) {
            $total += $details['price'] * $details['quantity'];
        }

        $order = Pembayaran::create([
            'user_id' => $user->id,
            'status_id' => 1, 
            'payment_method_id' => $request->payment_method_id,
            'order_type_id' => $request->order_type_id,
            'order_date' => now(),
            'total_price' => $total, 
        ]);

        foreach ($cart as $id => $details) {
            DetailPembayaran::create([
                'pembayaran_id' => $order->id,
                'menu_id' => $id,
                'quantity' => $details['quantity'],
                'price_per_item' => $details['price'],
                'item_notes' => $request->notes[$id] ?? null,
            ]);
        }

        session()->forget('cart');

        return redirect()->route('cart.index')
            ->with('success', 'Pesanan berhasil dibuat! Silakan tunggu konfirmasi.');

    }
}