<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pembayaran;
use App\Models\DetailPembayaran;
use App\Models\Menu;
use App\Models\Notification;

class CheckoutApiController extends Controller
{
    /**
     * Process checkout - receives cart items from client
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'items' => 'required|array|min:1',
                'items.*.menu_id' => 'required|integer|exists:menu,id',
                'items.*.quantity' => 'required|integer|min:1',
                'items.*.note' => 'nullable|string|max:255',
                'payment_method_id' => 'required|exists:payment_methods,id',
                'order_type_id' => 'required|exists:order_types,id',
            ]);

            $user = Auth::user();
            $total = 0;
            $itemsData = [];

            // Validate items and calculate total
            foreach ($request->items as $item) {
                $menu = Menu::find($item['menu_id']);

                if (!$menu) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Menu dengan ID ' . $item['menu_id'] . ' tidak ditemukan'
                    ], 404);
                }

                if ($menu->status_id != 1) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Menu "' . $menu->nama . '" tidak tersedia'
                    ], 400);
                }

                $subtotal = $menu->price * $item['quantity'];
                $total += $subtotal;

                $itemsData[] = [
                    'menu' => $menu,
                    'quantity' => $item['quantity'],
                    'note' => $item['note'] ?? null,
                    'price' => $menu->price,
                ];
            }

            // Create order
            $order = Pembayaran::create([
                'user_id' => $user->id,
                'status_id' => 2, // pending
                'payment_method_id' => $request->payment_method_id,
                'order_type_id' => $request->order_type_id,
                'order_date' => now(),
                'total_price' => $total,
            ]);

            // Create order details
            foreach ($itemsData as $itemData) {
                DetailPembayaran::create([
                    'pembayaran_id' => $order->id,
                    'menu_id' => $itemData['menu']->id,
                    'quantity' => $itemData['quantity'],
                    'price_per_item' => $itemData['price'],
                    'item_notes' => $itemData['note'],
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

            // Load relationships for response
            $order->load(['details.menu', 'payment_method', 'order_type']);

            $orderItems = $order->details->map(function ($detail) {
                return [
                    'menu_id' => $detail->menu_id,
                    'nama' => $detail->menu->nama ?? 'Unknown',
                    'quantity' => $detail->quantity,
                    'harga' => $detail->price_per_item,
                    'subtotal' => $detail->quantity * $detail->price_per_item,
                    'catatan' => $detail->item_notes,
                ];
            });

            return response()->json([
                'success' => true,
                'message' => 'Pesanan berhasil dibuat',
                'data' => [
                    'order_id' => $order->id,
                    'invoice_number' => 'INV-' . str_pad($order->id, 4, '0', STR_PAD_LEFT),
                    'order_date' => $order->order_date->format('Y-m-d H:i:s'),
                    'payment_method' => $order->payment_method->payment_name ?? null,
                    'order_type' => $order->order_type->type_name ?? null,
                    'items' => $orderItems,
                    'total' => $total,
                    'status' => 'pending',
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
                'message' => 'Gagal membuat pesanan: ' . $e->getMessage()
            ], 500);
        }
    }
}
