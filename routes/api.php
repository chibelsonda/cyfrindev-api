<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;


Route::get('/test', function () {
    return 'Site is running...';
});

Route::post('/signup', [UserController::class, 'signup']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/email/confirm', [UserController::class, 'confirmEmail']);

Route::group(['middleware' => ['auth:sanctum']], function () {

    // user
    Route::prefix('/users')->group(function () {
        Route::post('/', [UserController::class, 'update']);
        Route::get('/', [UserController::class, 'getUsers']);
        Route::get('/{user_id}', [UserController::class, 'getUser']);
    });


    Route::post('/logout', [AuthController::class, 'logout']);
});

