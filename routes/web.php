<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\PemakaianController;

Route::get('/', function () {
    return view('front.index');
});

Route::get('/pemakaian/{id}/cetak', [PemakaianController::class, 'cetak'])->name('pemakaian.cetak');

Route::match(['GET', 'POST'], '/', [App\Http\Controllers\FrontController::class, 'index'])->name('pemakaian.index');
