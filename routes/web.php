<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ReservasiController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\KasirController;

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

// Route untuk Keranjang (dummy)
Route::get('/cart', [CartController::class, 'index']);

Route::get('/reservasi', [ReservasiController::class, 'create']);

Route::get('/checkout', [CheckoutController::class, 'create']);

Route::get('/profil', [ProfileController::class, 'show']);
Route::get('/profil/pesanan', [ProfileController::class, 'orderHistory']);
Route::get('/profil/reservasi', [ProfileController::class, 'reservationHistory']);

// Routes untuk Admin
Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::get('/admin/menu', [AdminController::class, 'menu'])->name('admin.menu');
Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
Route::get('/admin/orders', [AdminController::class, 'orders'])->name('admin.orders');
Route::get('/admin/reservations', [AdminController::class, 'reservations'])->name('admin.reservations');
Route::get('/admin/ratings', [AdminController::class, 'ratings'])->name('admin.ratings');

Route::get('/kasir',      [KasirController::class, 'index'])->name('kasir.index');
Route::get('/reservasi-kasir',  [KasirController::class, 'reservasi'])->name('kasir.reservasi');
Route::get('/notif',      [KasirController::class, 'notif'])->name('kasir.notif');
Route::get('/profile',    [KasirController::class, 'profile'])->name('kasir.profile');
Route::get('/riwayat',    [KasirController::class, 'riwayat'])->name('kasir.riwayat');
