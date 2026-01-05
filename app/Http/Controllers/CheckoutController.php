<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Pembayaran;
use App\Models\DetailPembayaran;
use App\Models\Menu;
use App\Models\User;
use App\Models\Notification;

class CheckoutController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login untuk melakukan checkout.');
        }

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('menu')->with('error', 'Keranjang Anda kosong.');
        }

        $user = Auth::user();

        $total = 0;
        foreach ($cart as $id => $details) {
            $total += $details['price'] * $details['quantity'];
        }

        return view('customers.layouts.checkout', compact('cart', 'total', 'user'));
    }

    public function store(Request $request)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login untuk melakukan checkout.');
        }

        // Validate request
        $request->validate([
            'payment_method_id' => 'required|integer|exists:payment_methods,id',
            'order_type_id' => 'required|integer|exists:order_types,id',
        ], [
            'payment_method_id.required' => 'Metode pembayaran harus dipilih',
            'payment_method_id.exists' => 'Metode pembayaran tidak valid',
            'order_type_id.required' => 'Tipe pesanan harus dipilih',
            'order_type_id.exists' => 'Tipe pesanan tidak valid'
        ]);

        $cart = session()->get('cart', []);

        // Check if cart is empty
        if (empty($cart)) {
            return redirect()->route('menu')->with('error', 'Keranjang Anda kosong.');
        }

        $user = Auth::user();
        $total = 0;

        foreach ($cart as $details) {
            $total += $details['price'] * $details['quantity'];
        }

        $order = Pembayaran::create([
            'user_id' => $user->id,
            'status_id' => 2, // 2 = pending (based on PaymentStatusSeeder)
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

        // Buat notifikasi untuk customer
        Notification::create([
            'user_id' => $user->id,
            'type' => 'order_pending',
            'title' => 'Pesanan Dibuat',
            'message' => 'Pesanan Anda dengan invoice #INV-' . str_pad($order->id, 4, '0', STR_PAD_LEFT) . ' sedang diproses.',
            'link' => '/profile/order/' . $user->id . '/' . $order->id,
            'is_read' => false
        ]);

        session()->forget('cart');

        return redirect()->route('profile.order.show', ['userId' => Auth::id(), 'orderId' => $order->id])
            ->with('success', 'Pesanan berhasil dibuat! Invoice #INV-' . str_pad($order->id, 4, '0', STR_PAD_LEFT));

    }
}