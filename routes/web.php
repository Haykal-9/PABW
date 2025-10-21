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

// --- ROUTES CRUD MENU ---
Route::post('/admin/menu', [AdminController::class, 'storeMenu'])->name('admin.menu.store');
Route::put('/admin/menu/{id}', [AdminController::class, 'updateMenu'])->name('admin.menu.update');
Route::delete('/admin/menu/{id}', [AdminController::class, 'destroyMenu'])->name('admin.menu.destroy');

// --- ROUTES CRUD USERS ---
Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
Route::put('/admin/users/{id}', [AdminController::class, 'updateUserRole'])->name('admin.users.update'); // Update Role
Route::delete('/admin/users/{id}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy'); // Delete User

// --- ROUTES CRUD RESERVATIONS ---
Route::get('/admin/reservations', [AdminController::class, 'reservations'])->name('admin.reservations');
Route::put('/admin/reservations/{id}', [AdminController::class, 'updateReservationStatus'])->name('admin.reservations.update'); // Update Status
Route::delete('/admin/reservations/{id}', [AdminController::class, 'destroyReservation'])->name('admin.reservations.destroy'); // Delete Reservation

// --- ROUTES CRUD RATINGS (HANYA DELETE) ---
Route::get('/admin/ratings', [AdminController::class, 'ratings'])->name('admin.ratings');
Route::delete('/admin/ratings/{id}', [AdminController::class, 'destroyRating'])->name('admin.ratings.destroy'); // Delete Rating

// --- RIWAYAT PENJUALAN (READ ONLY) ---
Route::get('/admin/orders', [AdminController::class, 'orders'])->name('admin.orders');

// --- KASIR ROUTES ---
Route::get('/kasir/kasir',      [KasirController::class, 'index'])->name('kasir.index');
Route::get('/kasir/reservasi', [KasirController::class, 'reservasikasir'])->name('kasir.reservasi');
Route::get('/kasir/riwayat', [KasirController::class, 'riwayat'])->name('kasir.riwayat');
Route::get('/kasir/notifikasi', [KasirController::class, 'notif'])->name('kasir.notif');
Route::get('/kasir/profile', [KasirController::class, 'profile'])->name('kasir.profile');
Route::get('/kasir/logout', function() {
    return redirect()->route('kasir');
})->name('logout');