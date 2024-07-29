<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\KategoriController;

Route::get('/', function () {
    return view('layouts.template');
});

Route::group(['prefix' => 'master', 'as' => 'master.'], function () {
    Route::resource('barang', BarangController::class);
    Route::resource('customer', CustomerController::class);
    Route::resource('satuan', SatuanController::class);
    Route::resource('kategori', KategoriController::class);
});