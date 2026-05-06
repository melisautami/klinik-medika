<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function loginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard')->with('success', 'selamat datang di dashboard admin');
            } elseif ($user->role === 'perawat') {
                return redirect()->route('perawat.dashboard')->with('success', 'selamat datang di dashboard perawat');
            } elseif ($user->role === 'pasien') {
                return redirect()->route('pasien.dashboard')->with('success', 'selamat datang di dashboard pasien');
            } else {
                Auth::logout();
                return redirect()->route('login')->withErrors('role pengguna tidak dienali');
            }
        }
        return back()->withErrors([
            'email' => 'Email atau password'
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login')->with('success', 'Anda telah berhasil logout.');
    }
}
