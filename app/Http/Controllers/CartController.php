<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        // Data dummy untuk keranjang
        $cartItems = [
            (object) ['id' => 1, 'name' => 'Arabika', 'price' => 35000, 'qty' => 2, 'image_url' => 'foto/arabika.jpg'],
            (object) ['id' => 3, 'name' => 'Classic Croissant', 'price' => 25000, 'qty' => 1, 'image_url' => 'foto/kentangSosis.jpg'],
        ];

        $subtotal = array_reduce($cartItems, function($carry, $item) {
            return $carry + ($item->price * $item->qty);
        }, 0);

        return view('customers.cart', compact('cartItems', 'subtotal'));
    }
}
