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
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        Auth::login($user);
        return redirect()->route('home');
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
