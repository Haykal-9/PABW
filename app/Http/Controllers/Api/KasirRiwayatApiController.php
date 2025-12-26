<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\pembayaran;

class KasirRiwayatApiController extends Controller
{
    /**
     * Get order history
     */
    public function index(Request $request)
    {
        $query = pembayaran::with([
            'user',
            'details.menu',
            'payment_method',
            'order_type',
            'status'
        ])->orderBy('order_date', 'desc');

        // Optional date filter
        if ($request->has('date_from')) {
            $query->whereDate('order_date', '>=', $request->date_from);
        }
        if ($request->has('date_to')) {
            $query->whereDate('order_date', '<=', $request->date_to);
        }

        $pembayaranData = $query->get();

        $riwayat = $pembayaranData->map(function ($pembayaran) {
            $total = $pembayaran->details->sum(function ($detail) {
                return $detail->quantity * $detail->price_per_item;
            });

            return [
                'id' => $pembayaran->id,
                'kode' => 'INV-' . str_pad($pembayaran->id, 4, '0', STR_PAD_LEFT),
                'tanggal' => date('Y-m-d H:i:s', strtotime($pembayaran->order_date)),
                'pelanggan' => $pembayaran->user->nama ?? 'Guest',
                'total' => $total,
                'status' => $pembayaran->status->status_name ?? 'pending',
                'payment_method' => $pembayaran->payment_method->payment_name ?? 'N/A',
                'order_type' => $pembayaran->order_type->type_name ?? 'N/A',
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $riwayat
        ]);
    }

    /**
     * Get order detail
     */
    public function show($id)
    {
        $pembayaran = pembayaran::with([
            'user',
            'details.menu',
            'payment_method',
            'order_type',
            'status'
        ])->find($id);

        if (!$pembayaran) {
            return response()->json([
                'success' => false,
                'message' => 'Pesanan tidak ditemukan'
            ], 404);
        }

        $items = $pembayaran->details->map(function ($detail) {
            return [
                'menu_id' => $detail->menu_id,
                'nama' => $detail->menu->nama ?? 'Unknown',
                'quantity' => $detail->quantity,
                'harga' => $detail->price_per_item,
                'subtotal' => $detail->quantity * $detail->price_per_item,
                'catatan' => $detail->item_notes,
            ];
        });

        $subtotal = $pembayaran->details->sum(function ($detail) {
            return $detail->quantity * $detail->price_per_item;
        });
        $tax = $subtotal * 0.10;
        $total = $subtotal + $tax;

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $pembayaran->id,
                'kode' => 'INV-' . str_pad($pembayaran->id, 4, '0', STR_PAD_LEFT),
                'tanggal' => date('Y-m-d H:i:s', strtotime($pembayaran->order_date)),
                'pelanggan' => $pembayaran->user->nama ?? 'Guest',
                'email' => $pembayaran->user->email ?? null,
                'status' => $pembayaran->status->status_name ?? 'pending',
                'payment_method' => $pembayaran->payment_method->payment_name ?? 'N/A',
                'order_type' => $pembayaran->order_type->type_name ?? 'N/A',
                'items' => $items,
                'subtotal' => $subtotal,
                'tax' => $tax,
                'total' => $total,
            ]
        ]);
    }
}
