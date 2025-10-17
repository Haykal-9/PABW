<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReservasiController extends Controller
{
    public function create()
    {
        // Data dummy...
        $user = (object) [
            'nama' => 'Dummy User',
            'email' => 'dummy@example.com',
            'no_telp' => '081234567890'
        ];

        // Path view diubah ke 'customers.reservasi'
        return view('customers.reservasi', compact('user'));
    }
}