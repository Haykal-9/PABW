<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Pembayaran;
use App\Models\Reservasi;

class ProfileApiController extends Controller
{
    /**
     * Get user profile
     */
    public function show()
    {
        $user = Auth::user();
        $user->load('role', 'gender');

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $user->id,
                'nama' => $user->nama,
                'username' => $user->username,
                'email' => $user->email,
                'no_telp' => $user->no_telp,
                'alamat' => $user->alamat,
                'role' => $user->role->role_name ?? null,
                'gender' => $user->gender->gender_name ?? null,
                'gender_id' => $user->gender_id,
                'profile_picture' => $user->profile_picture
                    ? asset('uploads/avatars/' . $user->profile_picture)
                    : null,
                'created_at' => $user->created_at->format('Y-m-d'),
            ]
        ]);
    }

    /**
     * Update user profile
     */
    public function update(Request $request)
    {
        try {
            $userId = Auth::id();
            $user = User::findOrFail($userId);

            $request->validate([
                'nama' => 'required|string|max:100',
                'username' => 'required|string|max:50|unique:users,username,' . $userId,
                'email' => 'required|email|max:100|unique:users,email,' . $userId,
                'no_telp' => 'nullable|string|max:20',
                'alamat' => 'nullable|string',
                'gender_id' => 'nullable|exists:gender_types,id',
                'password' => 'nullable|min:6|confirmed',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $user->nama = $request->nama;
            $user->username = $request->username;
            $user->email = $request->email;
            $user->no_telp = $request->no_telp;
            $user->alamat = $request->alamat;

            if ($request->has('gender_id')) {
                $user->gender_id = $request->gender_id;
            }

            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }

            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $namaFile = 'profile_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/avatars'), $namaFile);

                // Delete old file
                if ($user->profile_picture && $user->profile_picture !== 'default-avatar.png') {
                    $oldFile = public_path('uploads/avatars/' . $user->profile_picture);
                    if (file_exists($oldFile)) {
                        unlink($oldFile);
                    }
                }

                $user->profile_picture = $namaFile;
            }

            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Profil berhasil diperbarui',
                'data' => [
                    'id' => $user->id,
                    'nama' => $user->nama,
                    'username' => $user->username,
                    'email' => $user->email,
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
                'message' => 'Gagal memperbarui profil: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get user's order history
     */
    public function orders()
    {
        $orders = Pembayaran::with(['status', 'payment_method', 'order_type'])
            ->where('user_id', Auth::id())
            ->orderBy('order_date', 'desc')
            ->get();

        $data = $orders->map(function ($order) {
            $total = $order->details->sum(function ($detail) {
                return $detail->quantity * $detail->price_per_item;
            });

            return [
                'id' => $order->id,
                'invoice' => 'INV-' . str_pad($order->id, 4, '0', STR_PAD_LEFT),
                'tanggal' => $order->order_date->format('Y-m-d H:i:s'),
                'total' => $total,
                'status' => $order->status->status_name ?? 'pending',
                'payment_method' => $order->payment_method->payment_name ?? null,
                'order_type' => $order->order_type->type_name ?? null,
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    /**
     * Get order detail
     */
    public function orderDetail($orderId)
    {
        $order = Pembayaran::with(['details.menu', 'status', 'payment_method', 'order_type'])
            ->where('user_id', Auth::id())
            ->find($orderId);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Pesanan tidak ditemukan'
            ], 404);
        }

        $items = $order->details->map(function ($detail) {
            return [
                'menu_id' => $detail->menu_id,
                'nama' => $detail->menu->nama ?? 'Unknown',
                'quantity' => $detail->quantity,
                'harga' => $detail->price_per_item,
                'subtotal' => $detail->quantity * $detail->price_per_item,
                'catatan' => $detail->item_notes,
            ];
        });

        $total = $order->details->sum(function ($detail) {
            return $detail->quantity * $detail->price_per_item;
        });

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $order->id,
                'invoice' => 'INV-' . str_pad($order->id, 4, '0', STR_PAD_LEFT),
                'tanggal' => $order->order_date->format('Y-m-d H:i:s'),
                'status' => $order->status->status_name ?? 'pending',
                'payment_method' => $order->payment_method->payment_name ?? null,
                'order_type' => $order->order_type->type_name ?? null,
                'items' => $items,
                'total' => $total,
            ]
        ]);
    }

    /**
     * Cancel order
     */
    public function cancelOrder($orderId)
    {
        try {
            $order = Pembayaran::where('user_id', Auth::id())->find($orderId);

            if (!$order) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pesanan tidak ditemukan'
                ], 404);
            }

            // Only pending orders can be cancelled
            if ($order->status_id != 2) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pesanan tidak dapat dibatalkan'
                ], 400);
            }

            $order->status_id = 3; // cancelled
            $order->save();

            return response()->json([
                'success' => true,
                'message' => 'Pesanan berhasil dibatalkan'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal membatalkan pesanan: ' . $e->getMessage()
            ], 500);
        }
    }
}
