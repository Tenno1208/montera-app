<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\TransactionController;

Route::get('/', [TransactionController::class, 'index'])->name('home');
Route::post('/store', [TransactionController::class, 'store'])->name('store');
Route::get('/laporan', [TransactionController::class, 'report'])->name('laporan');
