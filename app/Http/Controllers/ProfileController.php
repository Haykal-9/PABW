<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show()
    {
        // Data dummy
        $user = (object) [
            'nama' => 'John Doe',
            'role_name' => 'Member',
            'profile_picture' => 'default-avatar.png'
        ];

        // Path view diubah ke 'customers.profile'
        return view('customers.profile', compact('user'));
    }

    public function orderHistory()
    {
        // Data dummy...
        $orders = [
            (object) ['id' => 1, 'order_date' => '2024-10-26 10:00', /* ... */],
        ];

        // Path view diubah ke 'customers.history.orders'
        return view('customers.history.orders', compact('orders'));
    }

    public function reservationHistory()
    {
        // Data dummy...
        $reservations = [
            (object) ['kode_reservasi' => 'RSV20241026001', /* ... */],
        ];

        // Path view diubah ke 'customers.history.reservations'
        return view('customers.history.reservations', compact('reservations'));
    }
}