<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Form login
     */
    public function loginForm()
    {
        return view('auth.login');
    }

    /**
     * Proses login
     */
    public function login(Request $request)
    {
        /**
         * Jika login pasien menggunakan NIK
         */
        if ($request->filled('nik')) {

            $request->validate([
                'nik' => ['required'],
                'password' => ['required'],
            ]);

            // cari pasien berdasarkan NIK
            $pasien = Pasien::with('pengguna')->where('nik', $request->nik)->first();

            // jika pasien tidak ditemukan
            if (!$pasien) {
                return back()->withErrors([
                    'nik' => 'NIK tidak ditemukan'
                ])->onlyInput('nik');
            }

            // pastikan pasien punya akun user
            if (!$pasien->pengguna) {
                return back()->withErrors([
                    'nik' => 'Akun pasien tidak tersedia'
                ]);
            }

            // login menggunakan akun user pasien
            $login = Auth::attempt([
                'email' => $pasien->pengguna->email,
                'password' => $request->password,
                'role' => 'pasien'
            ]);

            if (!$login) {
                return back()->withErrors([
                    'password' => 'Password salah'
                ])->onlyInput('nik');
            }
        }

        /**
         * Login admin / perawat menggunakan email
         */
        else {

            $credentials = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);

            $login = Auth::attempt($credentials);

            if (!$login) {
                return back()->withErrors([
                    'email' => 'Email atau password salah'
                ])->onlyInput('email');
            }
        }

        /**
         * Session regenerate
         */
        $request->session()->regenerate();

        $user = Auth::user();

        /**
         * Redirect berdasarkan role
         */
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard')->with('success', 'Selamat datang di dashboard admin');
        } elseif ($user->role === 'perawat') {
            return redirect()->route('perawat.dashboard')->with('success', 'Selamat datang di dashboard perawat');
        } elseif ($user->role === 'pasien') {
            return redirect()->route('pasien.dashboard')->with('success', 'Selamat datang di dashboard pasien');
        } else {
            Auth::logout();

            return redirect()->route('login')->withErrors('Role pengguna tidak dikenali');
        }
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login')
            ->with('success', 'Anda telah berhasil logout.');
    }
}