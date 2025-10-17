<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Path view diubah ke 'customers.home'
        return view('customers.home');
    }
}