<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReservasiController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/home', [HomeController::class, 'index']);

Route::get('/reservasi', [ReservasiController::class, 'create']);


Route::get('/menu', [MenuController::class, 'index']);

Route::get('/menu/{id}', [MenuController::class, 'show']);

Route::get('/checkout', [CheckoutController::class, 'create']);

Route::get('/profil/pesanan', [ProfileController::class, 'orderHistory']);

Route::get('/profil/reservasi', [ProfileController::class, 'reservationHistory']);