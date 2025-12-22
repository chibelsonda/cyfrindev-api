<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CourseController;

use App\Http\Controllers\Api\UserController;


Route::get('/test', function () {
    return 'Site is running...';
});

// API v1 routes
Route::prefix('v1')->group(function () {

    // Public routes
    Route::post('/signup', [UserController::class, 'signup'])->name('api.signup');
    Route::post('/login', [AuthController::class, 'login'])->name('api.login');
    Route::post('/email/verify', [UserController::class, 'verifyEmail'])->name('api.email.verify');

    // Protected routes
    Route::middleware('auth:sanctum')->group(function () {

        // User routes
        Route::prefix('users')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('api.users.index');
            Route::get('/{user:uuid}', [UserController::class, 'show'])->name('api.users.show');
            Route::put('/{user:uuid}', [UserController::class, 'update'])->name('api.users.update');
        });

        // Course routes
        Route::prefix('courses')->group(function () {
            Route::get('/', [CourseController::class, 'index'])->name('api.courses.index');
            Route::get('/{course:uuid}', [CourseController::class, 'show'])->name('api.courses.show');
            Route::post('/', [CourseController::class, 'store'])->name('api.courses.store');
            Route::delete('/{course:uuid}', [CourseController::class, 'destroy'])->name('api.courses.destroy');
        });

        // Auth logout
        Route::post('/logout', [AuthController::class, 'logout'])->name('api.logout');
    });
});

