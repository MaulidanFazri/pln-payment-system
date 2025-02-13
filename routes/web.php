<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PemakaianController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/pemakaian/{id}/cetak', [PemakaianController::class, 'cetak'])->name('pemakaian.cetak');
