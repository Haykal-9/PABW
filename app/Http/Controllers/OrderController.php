<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of user's orders.
     */
    public function index()
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Get all orders for the authenticated user
        $orders = Pembayaran::with([
            'details.menu',
            'paymentMethod',
            'orderType',
            'status'
        ])
            ->where('user_id', Auth::id())
            ->orderBy('order_date', 'desc')
            ->paginate(10);

        // Calculate total for each order
        foreach ($orders as $order) {
            $order->total = $order->details->sum(function ($detail) {
                return $detail->quantity * $detail->price_per_item;
            });
        }

        return view('customers.orders.index', compact('orders'));
    }

    /**
     * Display the specified order detail.
     */
    public function show($id)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Get order with authorization check
        $order = Pembayaran::with([
            'details.menu',
            'paymentMethod',
            'orderType',
            'status',
            'user'
        ])
            ->where('user_id', Auth::id()) // Authorization: only owner can view
            ->findOrFail($id);

        // Calculate totals
        $subtotal = 0;
        foreach ($order->details as $detail) {
            $detail->total = $detail->quantity * $detail->price_per_item;
            $subtotal += $detail->total;
        }

        // You can add tax or service charge here if needed
        $tax = 0; // 0% for now
        $total = $subtotal + $tax;

        return view('customers.orders.show', compact('order', 'subtotal', 'tax', 'total'));
    }

    /**
     * Cancel an order (optional feature)
     */
    public function cancel(Request $request, $id)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Get order with authorization check
        $order = Pembayaran::where('user_id', Auth::id())
            ->findOrFail($id);

        // Only allow cancellation if order is still pending (status_id = 2 based on PaymentStatusSeeder)
        if ($order->status_id != 2) {
            return redirect()->back()->with('error', 'Pesanan tidak dapat dibatalkan. Status: ' . $order->status->status_name);
        }

        // Update status to cancelled (status_id = 3 based on PaymentStatusSeeder)
        $order->status_id = 3;
        $order->save();

        return redirect()->route('orders.index')
            ->with('success', 'Pesanan berhasil dibatalkan.');
    }
}
