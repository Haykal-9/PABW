<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Auth Controllers
use App\Http\Controllers\Api\AuthController;

// Admin Controllers
use App\Http\Controllers\Api\AdminMenuApiController;
use App\Http\Controllers\Api\AdminRatingApiController;
use App\Http\Controllers\Api\AdminReservationApiController;
use App\Http\Controllers\Api\AdminUserApiController;

// Kasir Controllers
use App\Http\Controllers\Api\KasirApiController;
use App\Http\Controllers\Api\KasirMenuApiController;
use App\Http\Controllers\Api\KasirReservasiApiController;
use App\Http\Controllers\Api\KasirRiwayatApiController;
use App\Http\Controllers\Api\KasirProfileApiController;

// Customer Controllers
use App\Http\Controllers\Api\MenuApiController;
use App\Http\Controllers\Api\CheckoutApiController;
use App\Http\Controllers\Api\ReservasiApiController;
use App\Http\Controllers\Api\ProfileApiController;
use App\Http\Controllers\Api\ReviewApiController;
use App\Http\Controllers\Api\NotificationApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// ============================================
// PUBLIC ROUTES (No Authentication Required)
// ============================================

// Auth
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Menu (Public)
Route::get('/menus', [MenuApiController::class, 'index']);
Route::get('/menus/{id}', [MenuApiController::class, 'show']);

// ============================================
// PROTECTED ROUTES (Authentication Required)
// ============================================

Route::middleware('auth:sanctum')->group(function () {

    // --- AUTH ROUTES ---
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    // --- MENU (Authenticated Features) ---
    Route::post('/menus/{id}/favorite', [MenuApiController::class, 'toggleFavorite']);
    Route::get('/favorites', [MenuApiController::class, 'favorites']);

    // --- REVIEWS ---
    Route::post('/menus/{id}/review', [ReviewApiController::class, 'store']);
    Route::put('/menus/{id}/review', [ReviewApiController::class, 'update']);
    Route::delete('/menus/{id}/review', [ReviewApiController::class, 'destroy']);

    // --- CHECKOUT ---
    Route::post('/checkout', [CheckoutApiController::class, 'store']);

    // --- RESERVATIONS (Customer) ---
    Route::get('/reservations', [ReservasiApiController::class, 'index']);
    Route::get('/reservations/{id}', [ReservasiApiController::class, 'show']);
    Route::post('/reservations', [ReservasiApiController::class, 'store']);
    Route::post('/reservations/{id}/cancel', [ReservasiApiController::class, 'cancel']);

    // --- PROFILE ---
    Route::get('/profile', [ProfileApiController::class, 'show']);
    Route::put('/profile', [ProfileApiController::class, 'update']);
    Route::post('/profile', [ProfileApiController::class, 'update']); // For multipart/form-data
    Route::get('/profile/orders', [ProfileApiController::class, 'orders']);
    Route::get('/profile/orders/{orderId}', [ProfileApiController::class, 'orderDetail']);
    Route::post('/profile/orders/{orderId}/cancel', [ProfileApiController::class, 'cancelOrder']);

    // --- NOTIFICATIONS ---
    Route::get('/notifications', [NotificationApiController::class, 'index']);
    Route::get('/notifications/unread-count', [NotificationApiController::class, 'unreadCount']);
    Route::post('/notifications/{id}/read', [NotificationApiController::class, 'markAsRead']);
    Route::post('/notifications/read-all', [NotificationApiController::class, 'markAllAsRead']);
    Route::delete('/notifications/{id}', [NotificationApiController::class, 'destroy']);

    // ============================================
    // KASIR ROUTES (Require role:kasir)
    // ============================================

    Route::middleware('role:kasir')->prefix('kasir')->group(function () {

        // Main Kasir Operations
        Route::get('/menu', [KasirApiController::class, 'getMenu']);
        Route::post('/payment', [KasirApiController::class, 'processPayment']);

        // Menu Management
        Route::get('/menus', [KasirMenuApiController::class, 'index']);
        Route::get('/menus/{id}', [KasirMenuApiController::class, 'show']);
        Route::post('/menus', [KasirMenuApiController::class, 'store']);
        Route::put('/menus/{id}', [KasirMenuApiController::class, 'update']);
        Route::post('/menus/{id}', [KasirMenuApiController::class, 'update']); // For multipart/form-data
        Route::delete('/menus/{id}', [KasirMenuApiController::class, 'destroy']);

        // Reservations Management
        Route::get('/reservations', [KasirReservasiApiController::class, 'index']);
        Route::get('/reservations/all', [KasirReservasiApiController::class, 'all']);
        Route::post('/reservations/{id}/approve', [KasirReservasiApiController::class, 'approve']);
        Route::post('/reservations/{id}/reject', [KasirReservasiApiController::class, 'reject']);

        // Order History
        Route::get('/orders', [KasirRiwayatApiController::class, 'index']);
        Route::get('/orders/{id}', [KasirRiwayatApiController::class, 'show']);

        // Order Status Management
        Route::get('/statuses', [KasirRiwayatApiController::class, 'getStatuses']);
        Route::get('/orders/pending', [KasirRiwayatApiController::class, 'getPending']);
        Route::post('/orders/{id}/approve', [KasirRiwayatApiController::class, 'approve']);
        Route::post('/orders/{id}/reject', [KasirRiwayatApiController::class, 'reject']);
        Route::post('/orders/{id}/complete', [KasirRiwayatApiController::class, 'complete']);
        Route::put('/orders/{id}/status', [KasirRiwayatApiController::class, 'updateStatus']);

        // Profile
        Route::get('/profile', [KasirProfileApiController::class, 'show']);
        Route::put('/profile', [KasirProfileApiController::class, 'update']);
        Route::post('/profile', [KasirProfileApiController::class, 'update']); // For multipart/form-data
    });

    // ============================================
    // ADMIN ROUTES (Require role:admin)
    // ============================================

    Route::middleware('role:admin')->prefix('admin')->group(function () {
        // Menu CRUD
        Route::get('/menus', [AdminMenuApiController::class, 'index']);
        Route::get('/menus/{id}', [AdminMenuApiController::class, 'show']);
        Route::post('/menus', [AdminMenuApiController::class, 'store']);
        Route::put('/menus/{id}', [AdminMenuApiController::class, 'update']);
        Route::post('/menus/{id}', [AdminMenuApiController::class, 'update']); // For multipart/form-data
        Route::delete('/menus/{id}', [AdminMenuApiController::class, 'destroy']);

        // Ratings CRUD (hanya index & destroy)
        Route::get('/ratings', [AdminRatingApiController::class, 'index']);
        Route::delete('/ratings/{id}', [AdminRatingApiController::class, 'destroy']);

        // Reservations CRUD (hanya index & destroy)
        Route::get('/reservations', [AdminReservationApiController::class, 'index']);
        Route::delete('/reservations/{id}', [AdminReservationApiController::class, 'destroy']);

        // Users CRUD (hanya index & destroy)
        Route::get('/users', [AdminUserApiController::class, 'index']);
        Route::delete('/users/{id}', [AdminUserApiController::class, 'destroy']);
    });
});
