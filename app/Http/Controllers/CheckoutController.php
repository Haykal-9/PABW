<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Pembayaran;
use App\Models\DetailPembayaran;
use App\Models\Menu;

class CheckoutController extends Controller
{
    // 1. Tampilkan Halaman Checkout
    public function index()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('menu')->with('error', 'Keranjang Anda kosong.');
        }

        $user = Auth::user() ?? \App\Models\User::find(7); // Hybrid Auth (User 7 untuk testing)

        $total = 0;
        foreach ($cart as $id => $details) {
            $total += $details['price'] * $details['quantity'];
        }

        return view('customers.layouts.checkout', compact('cart', 'total', 'user'));
    }

    // 2. PROSES CHECKOUT (SIMPAN KE DATABASE)
    public function store(Request $request)
    {
        // A. Validasi Input
        $request->validate([
            'payment_method_id' => 'required|exists:payment_methods,id',
            'order_type_id' => 'required|exists:order_types,id',
            // 'alamat' => 'required', // Opsional, bisa ambil dari user profile
        ]);

        $user = Auth::user() ?? \App\Models\User::find(7); // Hybrid User 7
        $cart = session()->get('cart', []);
        $total = 0;

        // Hitung ulang total untuk keamanan (jangan hanya percaya input hidden)
        foreach ($cart as $details) {
            $total += $details['price'] * $details['quantity'];
        }

        // B. Gunakan Transaction agar data aman (Atomicity)
        DB::beginTransaction();

        try {
            // 1. Simpan Data Order Utama (Tabel Pembayaran)
            $order = Pembayaran::create([
                'user_id' => $user->id,
                'status_id' => 1, // Default: 1 (Pending/Menunggu Pembayaran)
                'payment_method_id' => $request->payment_method_id,
                'order_type_id' => $request->order_type_id,
                'order_date' => now(),
                'total_price' => $total, // Pastikan ada kolom ini di tabel pembayaran, jika tidak hapus baris ini
            ]);

            // 2. Simpan Detail Item (Tabel Detail Pembayaran)
            foreach ($cart as $id => $details) {
                DetailPembayaran::create([
                    'pembayaran_id' => $order->id,
                    'menu_id' => $id,
                    'quantity' => $details['quantity'],
                    'price_per_item' => $details['price'],
                    'item_notes' => $request->notes[$id] ?? null, 
                ]);
            }

            // 3. Hapus Keranjang dari Session
            session()->forget('cart');

            DB::commit();

            // 4. Redirect ke Halaman Keranjang
            return redirect()->route('cart.index')
                ->with('success', 'Pesanan berhasil dibuat! Silakan tunggu konfirmasi.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}