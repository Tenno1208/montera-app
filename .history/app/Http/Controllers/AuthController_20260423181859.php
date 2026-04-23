<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin() { return view('auth.login'); }
    public function showRegister() { return view('auth.register'); }

    public function register(Request $request) {
    // Pesan validasi Bahasa Indonesia
    $messages = [
        'name.required' => 'Nama lengkap wajib diisi.',
        'email.required' => 'Alamat email wajib diisi.',
        'email.email' => 'Format email tidak valid.',
        'email.unique' => 'Email ini sudah terdaftar.',
        'password.required' => 'Kata sandi wajib diisi.',
        'password.min' => 'Kata sandi minimal harus 8 karakter.',
        'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
    ];

    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
    ], $messages);

    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

    // Redirect ke Login bukan ke Home
    return redirect()->route('login')->with('success', 'Akun berhasil dibuat! Silakan masuk.');
}

    public function login(Request $request) {
        if (Auth::attempt($request->only('email', 'password'))) {
            return redirect()->route('home');
        }
        return back()->withErrors(['email' => 'Email atau password salah.']);
    }

    

    public function logout() {
        Auth::logout();
        return redirect()->route('landing');
    }
}
