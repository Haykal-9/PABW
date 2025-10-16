<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReservasiController extends Controller
{
    public function create()
    {
        // Data dummy untuk user yang login
        $user = (object) [
            'nama' => 'Dummy User',
            'email' => 'dummy@example.com',
            'no_telp' => '081234567890'
        ];

        // Jika Anda menggunakan sistem autentikasi Laravel, Anda bisa menggantinya dengan:
        // $user = Auth::user();

        return view('reservasi', compact('user'));
    }
}