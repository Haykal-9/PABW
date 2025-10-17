<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function create()
    {
        // Data dummy untuk jenis pesanan dan metode pembayaran
        $order_types = [
            ['type_name' => 'Dine In'],
            ['type_name' => 'Take Away'],
            ['type_name' => 'Delivery']
        ];

        $payment_methods = [
            ['method_name' => 'Cash'],
            ['method_name' => 'E-Wallet'],
            ['method_name' => 'QRIS']
        ];

        return view('checkout', compact('order_types', 'payment_methods'));
    }
}