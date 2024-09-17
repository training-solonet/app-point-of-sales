<?php

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth'], function ($router) {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
});

Route::middleware(['auth:api'])->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);

    Route::get('product', [ApiController::class, 'product']);
    Route::get('category', [ApiController::class, 'category']);
    Route::get('customer', [ApiController::class, 'customer']);
    Route::get('best-seller-product', [ApiController::class, 'bestSeller']);

    Route::post('/order', [ApiController::class, 'order']);
});
