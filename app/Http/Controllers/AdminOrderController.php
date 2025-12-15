<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminOrderController extends Controller
{
    public function index()
    {
        $orders = pembayaran::with([
            'user',
            'paymentMethod', 
            'status',
            'orderType',
            'details.menu'
        ])
        ->orderBy('order_date', 'desc')
        ->get()
        ->map(function($order) {
            $subtotal = $order->details->sum(function($detail) {
                return $detail->quantity * $detail->price_per_item;
            });
            
            return [
                'id' => $order->id,
                'tanggal' => $order->order_date ? date('Y-m-d H:i', strtotime($order->order_date)) : 'N/A',
                'customer' => $order->user->nama ?? 'Guest',
                'order_type' => $order->orderType->type_name ?? 'N/A',
                'metode' => $order->paymentMethod->method_name ?? 'N/A',
                'status' => $order->status->status_name ?? 'Pending',
                'items' => $order->details->map(function($detail) {
                    return [
                        'nama' => $detail->menu->nama ?? 'Item dihapus',
                        'quantity' => $detail->quantity,
                        'price' => $detail->price_per_item,
                        'subtotal' => $detail->quantity * $detail->price_per_item,
                        'image_path' => $detail->menu->url_foto ? 'foto/' . $detail->menu->url_foto : 'images/default.png',
                    ];
                })->toArray(),
                'total' => $subtotal,
            ];
        });
        
        return view('admin.orders', compact('orders'));
    }
}
