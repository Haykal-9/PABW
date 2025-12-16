<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\menu;
use App\Models\pembayaran;
use App\Models\detailPembayaran;

class KasirController extends Controller
{
    /**
     * Menampilkan halaman utama kasir.
     */
    public function index()
    {
        // Ambil data menu dari database (hanya yang tersedia)
        $menuData = menu::where('status_id', 1) // status_id = 1 untuk 'tersedia'
            ->orderBy('type_id')
            ->orderBy('nama')
            ->get();

        // Format data menu untuk JavaScript
        $menu = $menuData->map(function ($item) {
            return [
                'id' => $item->id,
                'nama' => $item->nama,
                'harga' => $item->price,
                'img' => $item->url_foto
                    ? asset('foto/' . $item->url_foto)
                    : 'https://placehold.co/250x160/3b2e26/ffffff?text=' . urlencode($item->nama)
            ];
        })->toArray();

        // Data keranjang awal kosong (bisa disesuaikan sesuai kebutuhan)
        $order_items = [];

        return view('kasir.kasir', [
            'title' => 'Tapal Kuda | Kasir',
            'activePage' => 'kasir',
            'menu' => $menu,
            'order_items' => $order_items,
        ]);
    }

    /**
     * Process payment and save transaction
     */
    public function processPayment(Request $request)
    {
        try {
            // Validate request
            $request->validate([
                'customer_name' => 'nullable|string|max:100',
                'order_type' => 'required|string',
                'payment_method' => 'required|string',
                'items' => 'required|array|min:1',
                'subtotal' => 'required|numeric',
                'tax' => 'required|numeric',
                'total' => 'required|numeric',
            ]);

            // Map payment method to ID
            $paymentMethodMap = [
                'Cash' => 1,
                'E-Wallet' => 2,
                'QRIS' => 3,
            ];

            // Map order type to ID
            $orderTypeMap = [
                'Dine In' => 1,
                'Take Away' => 2,
            ];

            // Create payment record
            $payment = pembayaran::create([
                'user_id' => Auth::id(),
                'order_date' => now(),
                'status_id' => 1,
                'payment_method_id' => $paymentMethodMap[$request->payment_method] ?? 1,
                'order_type_id' => $orderTypeMap[$request->order_type] ?? 1,
            ]);

            // Create payment details
            foreach ($request->items as $item) {
                detailPembayaran::create([
                    'pembayaran_id' => $payment->id,
                    'menu_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'price_per_item' => $item['price'],
                    'item_notes' => $request->customer_name ?? null,
                ]);
            }

            // Return success response with transaction data
            return response()->json([
                'success' => true,
                'message' => 'Pembayaran berhasil diproses',
                'data' => [
                    'transaction_id' => $payment->id,
                    'invoice_number' => 'INV-' . str_pad($payment->id, 5, '0', STR_PAD_LEFT),
                    'customer_name' => $request->customer_name ?? 'Guest',
                    'order_date' => $payment->order_date->format('d-m-Y H:i:s'),
                    'order_type' => $request->order_type,
                    'payment_method' => $request->payment_method,
                    'items' => $request->items,
                    'subtotal' => $request->subtotal,
                    'tax' => $request->tax,
                    'total' => $request->total,
                    'kasir' => 'Kasir Tapal Kuda',
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
