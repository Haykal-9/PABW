<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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

    public function report(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $status = $request->input('status');
        
        $query = pembayaran::with([
            'user',
            'paymentMethod', 
            'status',
            'orderType',
            'details.menu'
        ]);

        // Filter berdasarkan tanggal
        if ($startDate && $endDate) {
            $query->whereBetween('order_date', [
                Carbon::parse($startDate)->startOfDay(),
                Carbon::parse($endDate)->endOfDay()
            ]);
        } elseif ($startDate) {
            $query->whereDate('order_date', '>=', Carbon::parse($startDate)->startOfDay());
        } elseif ($endDate) {
            $query->whereDate('order_date', '<=', Carbon::parse($endDate)->endOfDay());
        }

        // Filter berdasarkan status
        if ($status) {
            $query->where('status_id', $status);
        }

        $orders = $query->orderBy('order_date', 'desc')->get();

        // Hitung total penjualan
        $totalPenjualan = 0;
        $totalTransaksi = $orders->count();
        $totalItem = 0;

        $ordersData = $orders->map(function($order) use (&$totalPenjualan, &$totalItem) {
            $subtotal = $order->details->sum(function($detail) {
                return $detail->quantity * $detail->price_per_item;
            });
            
            $totalPenjualan += $subtotal;
            $totalItem += $order->details->sum('quantity');
            
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
                    ];
                })->toArray(),
                'total' => $subtotal,
            ];
        });

        $summary = [
            'total_penjualan' => $totalPenjualan,
            'total_transaksi' => $totalTransaksi,
            'total_item' => $totalItem,
            'start_date' => $startDate,
            'end_date' => $endDate,
        ];

        \Log::info('Laporan penjualan digenerate oleh ' . Auth::user()->nama . ' (ID: ' . Auth::id() . ')');

        return view('admin.orders-report', compact('ordersData', 'summary'));
    }
}