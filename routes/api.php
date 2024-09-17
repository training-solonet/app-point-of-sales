<?php

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api');
Route::post('refresh', [AuthController::class, 'refresh'])->middleware('auth:api');

Route::middleware(['auth.jwt'])->group(function () {
    Route::get('/product', [ApiController::class, 'product']);
    Route::get('/category', [ApiController::class, 'category']);
    Route::get('/customer', [ApiController::class, 'customer']);
    Route::get('/best-seller-product', [ApiController::class, 'bestSeller']);
    Route::post('/order', [ApiController::class, 'order']);
});
