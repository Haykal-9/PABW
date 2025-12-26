<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\menu;
use App\Models\pembayaran;
use App\Models\detailPembayaran;

class KasirApiController extends Controller
{
    /**
     * Get available menu for kasir POS
     */
    public function getMenu()
    {
        $menuData = menu::where('status_id', 1)
            ->orderBy('type_id')
            ->orderBy('nama')
            ->get();

        $menu = $menuData->map(function ($item) {
            return [
                'id' => $item->id,
                'nama' => $item->nama,
                'harga' => $item->price,
                'kategori' => $item->type->type_name ?? null,
                'image_url' => $item->url_foto
                    ? asset('foto/' . $item->url_foto)
                    : null
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $menu
        ]);
    }

    /**
     * Process payment and save transaction
     */
    public function processPayment(Request $request)
    {
        try {
            $request->validate([
                'customer_name' => 'nullable|string|max:100',
                'order_type' => 'required|string|in:Dine In,Take Away',
                'payment_method' => 'required|string|in:Cash,E-Wallet,QRIS',
                'items' => 'required|array|min:1',
                'items.*.id' => 'required|integer|exists:menu,id',
                'items.*.quantity' => 'required|integer|min:1',
                'items.*.price' => 'required|numeric|min:0',
            ]);

            $paymentMethodMap = [
                'Cash' => 1,
                'E-Wallet' => 2,
                'QRIS' => 3,
            ];

            $orderTypeMap = [
                'Dine In' => 1,
                'Take Away' => 2,
            ];

            // Calculate totals
            $subtotal = 0;
            foreach ($request->items as $item) {
                $subtotal += $item['price'] * $item['quantity'];
            }
            $tax = $subtotal * 0.10;
            $total = $subtotal + $tax;

            // Create payment record
            $payment = pembayaran::create([
                'user_id' => Auth::id(),
                'order_date' => now(),
                'status_id' => 1, // completed
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
                    'subtotal' => $subtotal,
                    'tax' => $tax,
                    'total' => $total,
                ]
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
