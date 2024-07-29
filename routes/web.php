<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\SatuanController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('layouts.template');
});

Route::group(['prefix' => 'master', 'as' => 'master.'], function () {
    Route::resource('barang', BarangController::class);
    Route::resource('customer', CustomerController::class);
    Route::resource('satuan', SatuanController::class);
    Route::resource('kategori', KategoriController::class);
});
