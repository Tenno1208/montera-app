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

    public function showProfil()
{
    $user = Auth::user();

    // Jika user ternyata null (belum login), tendang ke halaman login
    if (!$user) {
        return redirect()->route('login');
    }

    // Hitung total transaksi HANYA milik user ini
    $transactionCount = \App\Models\Transaction::where('user_id', $user->id)->count();
    
    return view('profil', compact('user', 'transactionCount'));
}

// Tambahkan 'use Illuminate\Support\Facades\Hash;' di bagian atas jika belum ada

public function editProfil() {
    return view('auth.edit_profil', ['user' => auth()->user()]);
}

public function updateProfil(Request $request) {
    $user = auth()->user();
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
    ]);

    $user->update($request->only('name', 'email'));
    return redirect()->route('profil')->with('success', 'Profil berhasil diperbarui!');
}

public function editKeamanan() {
    return view('auth.keamanan');
}

public function updateKeamanan(Request $request) {
    $request->validate([
        'current_password' => 'required|current_password',
        'password' => [
            'required',
            'string',
            'min:8',             // Minimal 8 karakter
            'confirmed',
            'regex:/[a-z]/',      // Harus ada huruf kecil
            'regex:/[A-Z]/',      // Harus ada huruf besar
            'regex:/[0-9]/',      // Harus ada angka
            'regex:/[@$!%*#?&]/', // Harus ada simbol (@$!%*#?&)
        ],
    ], [
        'current_password.current_password' => 'Kata sandi lama tidak sesuai.',
        'password.regex' => 'Kata sandi harus mengandung huruf besar, huruf kecil, angka, dan simbol.',
        'password.min' => 'Kata sandi minimal 8 karakter.',
        'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.'
    ]);

    auth()->user()->update([
        'password' => \Illuminate\Support\Facades\Hash::make($request->password)
    ]);

    return redirect()->route('profil')->with('success', 'Kata sandi berhasil diganti!');
}
}
