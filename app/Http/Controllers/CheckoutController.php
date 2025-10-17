<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function create()
    {
        // Data dummy...
        $order_types = [['type_name' => 'Dine In'], /* ... */];
        $payment_methods = [['method_name' => 'Cash'], /* ... */];

        // Path view diubah ke 'customers.checkout'
        return view('customers.checkout', compact('order_types', 'payment_methods'));
    }
}