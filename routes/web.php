<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ReservasiController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NotificationController;

// Kasir Controllers
use App\Http\Controllers\KasirController;
use App\Http\Controllers\KasirReservasiController;
use App\Http\Controllers\KasirNotifikasiController;
use App\Http\Controllers\KasirProfileController;
use App\Http\Controllers\KasirMenuController;

// Admin Controllers
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminMenuController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminReservationController;
use App\Http\Controllers\AdminRatingController;
use App\Http\Controllers\AdminOrderController;


// Route Halaman Utama
Route::get('/', [HomeController::class, 'index']);
Route::get('/home', [HomeController::class, 'index']);

// Routes untuk Autentikasi
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'processLogin']);
Route::get('/logout', [AuthController::class, 'processLogout']);

// Route untuk Registrasi
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'processRegister']);

// Routes untuk Pengguna (Customer) - Public Routes
Route::get('/menu', [MenuController::class, 'menu'])->name('menu');
Route::get('/menu/{id}', [MenuController::class, 'show'])->name('menu.detail');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');
Route::patch('/cart/update', [CartController::class, 'updateCart'])->name('cart.update');
Route::patch('/cart/update-note', [CartController::class, 'updateNote'])->name('cart.update.note');
Route::delete('/cart/remove', [CartController::class, 'removeCart'])->name('cart.remove');

// Routes untuk Pengguna (Customer) - Requires Authentication
Route::middleware(['auth'])->group(function () {
    // Favorite
    Route::post('/menu/{id}/favorite', [MenuController::class, 'favorite'])->name('menu.favorite');
    
    // Review
    Route::post('/menu/{id}/review', [ReviewController::class, 'store'])->name('menu.review.store');
    
    // Reservasi
    Route::get('/reservasi', [ReservasiController::class, 'create'])->name('reservasi.create');
    Route::post('/reservasi', [ReservasiController::class, 'store'])->name('reservasi.store');
    
    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    
    // Profile (with authorization check in controller)
    Route::get('/profil/{id}', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profil/{id}/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profil/{id}', [ProfileController::class, 'update'])->name('profile.update');
    
    // Order History & Detail (in Profile)
    Route::get('/profil/{userId}/pesanan/{orderId}', [ProfileController::class, 'showOrder'])->name('profile.order.show');
    Route::post('/profil/{userId}/pesanan/{orderId}/cancel', [ProfileController::class, 'cancelOrder'])->name('profile.order.cancel');
    
    // Reservation Cancellation (in Profile)
    Route::post('/profil/{userId}/reservasi/{reservationId}/cancel', [ProfileController::class, 'cancelReservation'])->name('profile.reservation.cancel');
    
    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.readAll');
    Route::get('/notifications/unread-count', [NotificationController::class, 'getUnreadCount'])->name('notifications.unreadCount');
});


// Routes untuk Admin via Middleware CheckRole
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    
    // --- ROUTES CRUD MENU ---
    Route::get('/admin/menu', [AdminMenuController::class, 'index'])->name('admin.menu');
    Route::post('/admin/menu', [AdminMenuController::class, 'store'])->name('admin.menu.store');
    Route::put('/admin/menu/{id}', [AdminMenuController::class, 'update'])->name('admin.menu.update');
    Route::delete('/admin/menu/{id}', [AdminMenuController::class, 'destroy'])->name('admin.menu.destroy');

    // --- ROUTES CRUD USERS ---
    Route::get('/admin/users', [AdminUserController::class, 'index'])->name('admin.users');
    Route::post('/admin/users', [AdminUserController::class, 'store'])->name('admin.users.store');
    Route::put('/admin/users/{id}', [AdminController::class, 'updateUserRole'])->name('admin.users.update');
    Route::delete('/admin/users/{id}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');

    // --- ROUTES CRUD RESERVATIONS ---
    Route::get('/admin/reservations', [AdminReservationController::class, 'index'])->name('admin.reservations');
    Route::put('/admin/reservations/{id}', [AdminController::class, 'updateReservationStatus'])->name('admin.reservations.update');
    Route::delete('/admin/reservations/{id}', [AdminReservationController::class, 'destroy'])->name('admin.reservations.destroy');

    // --- ROUTES CRUD RATINGS (HANYA DELETE) ---
    Route::get('/admin/ratings', [AdminRatingController::class, 'index'])->name('admin.ratings');
    Route::delete('/admin/ratings/{id}', [AdminRatingController::class, 'destroy'])->name('admin.ratings.destroy');

    // --- RIWAYAT PENJUALAN (READ ONLY) ---
    Route::get('/admin/orders', [AdminOrderController::class, 'index'])->name('admin.orders');
});

// --- KASIR ROUTES ---
Route::middleware(['auth', 'role:kasir'])->group(function () {
    // Main Kasir (KasirController)
    Route::get('/kasir/kasir', [KasirController::class, 'index'])->name('kasir.index');
    Route::post('/kasir/process-payment', [KasirController::class, 'processPayment'])->name('kasir.processPayment');
    Route::get('/kasir/riwayat', [KasirController::class, 'riwayat'])->name('kasir.riwayat');

    // Reservasi Management (KasirReservasiController)
    Route::get('/kasir/reservasi', [KasirReservasiController::class, 'index'])->name('kasir.reservasi');
    Route::patch('/kasir/reservasi/{id}/approve', [KasirReservasiController::class, 'approve'])->name('kasir.reservasi.approve');
    Route::post('/kasir/reservasi/{id}/reject', [KasirReservasiController::class, 'reject'])->name('kasir.reservasi.reject');

    // Notifikasi (KasirNotifikasiController)
    Route::get('/kasir/notifikasi', [KasirNotifikasiController::class, 'index'])->name('kasir.notif');

    // Profile (KasirProfileController)
    Route::get('/kasir/profile', [KasirProfileController::class, 'index'])->name('kasir.profile');
    Route::get('/kasir/profile/edit', [KasirProfileController::class, 'edit'])->name('kasir.profile.edit');
    Route::put('/kasir/profile', [KasirProfileController::class, 'update'])->name('kasir.profile.update');

    // Menu Management (KasirMenuController)
    Route::get('/kasir/menu', [KasirMenuController::class, 'index'])->name('kasir.menu');
    Route::post('/kasir/menu', [KasirMenuController::class, 'store'])->name('kasir.menu.store');
    Route::put('/kasir/menu/{id}', [KasirMenuController::class, 'update'])->name('kasir.menu.update');
    Route::delete('/kasir/menu/{id}', [KasirMenuController::class, 'destroy'])->name('kasir.menu.destroy');
});

Route::get('/kasir/logout', function () {
    \Illuminate\Support\Facades\Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login')->with('success', 'Anda telah logout.');
})->name('kasir.logout');