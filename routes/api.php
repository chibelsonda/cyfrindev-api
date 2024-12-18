<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;

Route::post('/signup', [UserController::class, 'signup']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/confirm-email', [UserController::class, 'confirmEmail']);

Route::group(['middleware' => ['auth:sanctum']], function () {

    // user
    Route::post('/users', [UserController::class, 'update']);
    Route::get('/users', [UserController::class, 'getUsers']);
    Route::get('/users/{id}', [UserController::class, 'getUser']);


    Route::post('/logout', [AuthController::class, 'logout']);
});

