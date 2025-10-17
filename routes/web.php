<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ReservasiController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProfileController;

// Route Halaman Utama
Route::get('/', [HomeController::class, 'index']);
Route::get('/home', [HomeController::class, 'index']);

// Routes untuk Autentikasi (jika belum ada controller khusus)
Route::get('/login', function () {
    return view('login'); 
});

Route::get('/register', function () {
    return view('register');
});


// Routes untuk Pengguna (Customer)
Route::get('/menu', [MenuController::class, 'index']);
Route::get('/menu/{id}', [MenuController::class, 'show']);

Route::get('/reservasi', [ReservasiController::class, 'create']);

Route::get('/checkout', [CheckoutController::class, 'create']);

Route::get('/profil', [ProfileController::class, 'show']);
Route::get('/profil/pesanan', [ProfileController::class, 'orderHistory']);
Route::get('/profil/reservasi', [ProfileController::class, 'reservationHistory']);


