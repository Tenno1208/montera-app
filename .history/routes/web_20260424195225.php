<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\SavingsGoalController; 

Route::get('/', function () {
    return view('welcome');
});


Route::middleware(['auth'])->group(function () {
Route::get('/', [TransactionController::class, 'index'])->name('home');
Route::post('/store', [TransactionController::class, 'store'])->name('store');
Route::get('/laporan', [TransactionController::class, 'report'])->name('laporan');
Route::get('/profil', [AuthController::class, 'showProfil'])->name('profil');

Route::post('/scan-nota', [App\Http\Controllers\TransactionController::class, 'scanNota'])->name('scan.nota');
Route::get('/bantuan', function () { return view('support.help'); })->name('bantuan');
Route::get('/tentang', function () { return view('support.about'); })->name('tentang');

Route::get('/profil/edit', [AuthController::class, 'editProfil'])->name('profil.edit');
Route::put('/profil/update', [AuthController::class, 'updateProfil'])->name('profil.update');

Route::get('/profil/keamanan', [AuthController::class, 'editKeamanan'])->name('profil.keamanan');
Route::put('/profil/keamanan/update', [AuthController::class, 'updateKeamanan'])->name('profil.keamanan.update');
});


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


Route::post('/goals/store', [SavingsGoalController::class, 'store'])->name('goals.store');
Route::get('/savings-advice/{id}', [SavingsGoalController::class, 'getAdvice']);

Route::get('/jalankan-migrasi', function() {
    Artisan::call('migrate:fresh', ['--force' => true]);
    return "Database Berhasil Dimigrasi!";
});
