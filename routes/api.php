<?php

use App\Http\Controllers\Api\ApiController;
use Illuminate\Support\Facades\Route;

Route::get('/product', [ApiController::class, 'product']);
Route::get('/category', [ApiController::class, 'category']);
Route::get('/customer', [ApiController::class, 'customer']);
Route::get('/best-seller-product', [ApiController::class, 'bestSeller']);
