<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JurnalHarianController;
use App\Http\Controllers\JurnalPiutangController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ReportPembayaranPiutangController;
use App\Http\Controllers\ReportPenjualanController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\StokBarangController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('layouts.template');
});

Route::group(['prefix' => 'menu', 'as' => 'menu.'], function () {
    Route::resource('dashboard', DashboardController::class);
    Route::resource('jurnal-piutang', JurnalPiutangController::class);
    Route::resource('jurnal-harian', JurnalHarianController::class);
    Route::resource('barang-masuk', BarangMasukController::class);
});

Route::group(['prefix' => 'report', 'as' => 'report.'], function () {
    Route::resource('penjualan', ReportPenjualanController::class);
    Route::resource('pembayaran-piutang', ReportPembayaranPiutangController::class);
    Route::resource('stok-barang', StokBarangController::class);
});

Route::group(['prefix' => 'master', 'as' => 'master.'], function () {
    Route::resource('barang', BarangController::class);
    Route::resource('customer', CustomerController::class);
    Route::resource('satuan', SatuanController::class);
    Route::resource('kategori', KategoriController::class);
});
