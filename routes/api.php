<?php

use App\Http\Controllers\Api\ApiController;
use Illuminate\Support\Facades\Route;

Route::get('/barang', [ApiController::class, 'barang']);
Route::get('/kategori', [ApiController::class, 'kategori']);
Route::get('/customer', [ApiController::class, 'customer']);
