<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;

Route::get('/barang', [ApiController::class, 'barang']);
Route::get('/kategori', [ApiController::class, 'kategori']);
Route::get('/customer', [ApiController::class, 'customer']);
