<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AdminMenuApiController;
use App\Http\Controllers\Api\AdminRatingApiController;
use App\Http\Controllers\Api\AdminReservationApiController;
use App\Http\Controllers\Api\AdminUserApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Public Routes
Route::post('/login', [AuthController::class, 'login']);

// Protected Routes (Require Authentication)
Route::middleware('auth:sanctum')->group(function () {
    
    // Auth Routes
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    
    // Admin Routes (Require role:admin)
    Route::middleware('role:admin')->prefix('admin')->group(function () {
        
        // Menu CRUD
        Route::apiResource('menus', AdminMenuApiController::class);
        // Ratings CRUD
        Route::apiResource('ratings', AdminRatingApiController::class)->only(['index', 'destroy']);
        // Reservations CRUD
        Route::apiResource('reservations', AdminReservationApiController::class)->only(['index', 'destroy']);
        // Users CRUD
        Route::apiResource('users', AdminUserApiController::class)->only(['index', 'destroy']);
    });
});

