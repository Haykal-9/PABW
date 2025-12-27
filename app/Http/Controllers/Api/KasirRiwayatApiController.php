<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\pembayaran;
use App\Models\paymentStatus;

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

        // Optional status filter
        if ($request->has('status_id')) {
            $query->where('status_id', $request->status_id);
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
                'status_id' => $pembayaran->status_id,
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
                'status_id' => $pembayaran->status_id,
                'payment_method' => $pembayaran->payment_method->payment_name ?? 'N/A',
                'order_type' => $pembayaran->order_type->type_name ?? 'N/A',
                'items' => $items,
                'subtotal' => $subtotal,
                'tax' => $tax,
                'total' => $total,
            ]
        ]);
    }

    /**
     * Get all available statuses
     */
    public function getStatuses()
    {
        $statuses = paymentStatus::all();

        return response()->json([
            'success' => true,
            'data' => $statuses
        ]);
    }

    /**
     * Get pending orders
     */
    public function getPending()
    {
        $pembayaranData = pembayaran::with([
            'user',
            'details.menu',
            'payment_method',
            'order_type',
            'status'
        ])
            ->where('status_id', 2) // pending
            ->orderBy('order_date', 'desc')
            ->get();

        $pesanan = $pembayaranData->map(function ($item) {
            $total = $item->details->sum(function ($detail) {
                return $detail->quantity * $detail->price_per_item;
            });

            $items = $item->details->map(function ($detail) {
                return [
                    'menu_id' => $detail->menu_id,
                    'nama' => $detail->menu->nama ?? 'Unknown',
                    'quantity' => $detail->quantity,
                    'harga' => $detail->price_per_item,
                    'subtotal' => $detail->quantity * $detail->price_per_item,
                ];
            });

            return [
                'id' => $item->id,
                'kode' => 'INV-' . str_pad($item->id, 4, '0', STR_PAD_LEFT),
                'pelanggan' => $item->user->nama ?? 'Guest',
                'email' => $item->user->email ?? 'N/A',
                'no_telp' => $item->user->no_telp ?? 'N/A',
                'tanggal' => date('Y-m-d H:i:s', strtotime($item->order_date)),
                'order_type' => $item->order_type->type_name ?? 'N/A',
                'payment_method' => $item->payment_method->payment_name ?? 'N/A',
                'items' => $items,
                'total' => $total,
                'status' => $item->status->status_name ?? 'pending',
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $pesanan
        ]);
    }

    /**
     * Approve order (change status to processing)
     */
    public function approve($id)
    {
        try {
            $pesanan = pembayaran::find($id);

            if (!$pesanan) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pesanan tidak ditemukan'
                ], 404);
            }

            $pesanan->status_id = 4; // processing
            $pesanan->save();

            return response()->json([
                'success' => true,
                'message' => 'Pesanan berhasil diterima dan sedang diproses',
                'data' => [
                    'id' => $pesanan->id,
                    'status' => 'processing',
                    'status_id' => 4
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menerima pesanan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Reject order (change status to cancelled)
     */
    public function reject(Request $request, $id)
    {
        try {
            $pesanan = pembayaran::find($id);

            if (!$pesanan) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pesanan tidak ditemukan'
                ], 404);
            }

            $pesanan->status_id = 3; // cancelled
            $pesanan->save();

            return response()->json([
                'success' => true,
                'message' => 'Pesanan berhasil ditolak',
                'data' => [
                    'id' => $pesanan->id,
                    'status' => 'cancelled',
                    'status_id' => 3,
                    'alasan' => $request->alasan ?? null
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menolak pesanan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Complete order (change status to completed)
     */
    public function complete($id)
    {
        try {
            $pesanan = pembayaran::find($id);

            if (!$pesanan) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pesanan tidak ditemukan'
                ], 404);
            }

            $pesanan->status_id = 1; // completed
            $pesanan->save();

            return response()->json([
                'success' => true,
                'message' => 'Pesanan berhasil diselesaikan',
                'data' => [
                    'id' => $pesanan->id,
                    'status' => 'completed',
                    'status_id' => 1
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyelesaikan pesanan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update order status directly
     */
    public function updateStatus(Request $request, $id)
    {
        try {
            $request->validate([
                'status_id' => 'required|integer|exists:payment_status,id'
            ]);

            $pesanan = pembayaran::find($id);

            if (!$pesanan) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pesanan tidak ditemukan'
                ], 404);
            }

            $pesanan->status_id = $request->status_id;
            $pesanan->save();

            $pesanan->load('status');

            return response()->json([
                'success' => true,
                'message' => 'Status pesanan berhasil diperbarui',
                'data' => [
                    'id' => $pesanan->id,
                    'status' => $pesanan->status->status_name,
                    'status_id' => $pesanan->status_id
                ]
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui status: ' . $e->getMessage()
            ], 500);
        }
    }
}

