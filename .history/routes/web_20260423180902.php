<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\TransactionController;

Route::get('/', [TransactionController::class, 'index'])->name('home');
Route::post('/store', [TransactionController::class, 'store'])->name('store');
Route::get('/laporan', [TransactionController::class, 'report'])->name('laporan');

use App\Http\Controllers\AuthController;

// Landing Page (Halaman Utama)
Route::get('/', function () {
    return view('landing');
})->name('landing');

// Halaman Login & Register
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Halaman yang BUTUH LOGIN (Gunakan Middleware Auth)
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [TransactionController::class, 'index'])->name('home');
    Route::get('/laporan', [TransactionController::class, 'report'])->name('laporan');
    Route::post('/store', [TransactionController::class, 'store'])->name('store');
});
