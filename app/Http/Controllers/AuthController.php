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
    /**
     * Proses login
     */
    public function login(Request $request)
    {
        // Validasi input awal
        $request->validate([
            'login_id' => ['required'],
            'password' => ['required'],
        ]);

        $loginId = $request->login_id;
        $password = $request->password;

        /**
         * SKENARIO 1: Jika input hanya berisi ANGKA (Dianggap sebagai NIK Pasien)
         */
        if (is_numeric($loginId)) {

            // cari pasien berdasarkan NIK
            $pasien = Pasien::with('pengguna')->where('nik', $loginId)->first();

            if (!$pasien) {
                return back()->withErrors([
                    'login_id' => 'NIK tidak terdaftar di sistem kami.'
                ])->onlyInput('login_id');
            }

            if (!$pasien->pengguna) {
                return back()->withErrors([
                    'login_id' => 'Akun pasien belum diaktifkan.'
                ])->onlyInput('login_id');
            }

            // Login menggunakan email milik relasi pasien tersebut
            $login = Auth::attempt([
                'email' => $pasien->pengguna->email,
                'password' => $password,
                'role' => 'pasien'
            ]);

            if (!$login) {
                return back()->withErrors([
                    'password' => 'Kata sandi yang Anda masukkan salah.'
                ])->onlyInput('login_id');
            }
        }

        /**
         * SKENARIO 2: Jika input bukan angka murni (Dianggap sebagai Email Admin/Perawat)
         */
        else {

            // Coba login sebagai Admin/Perawat
            $login = Auth::attempt([
                'email' => $loginId,
                'password' => $password
            ]);

            if (!$login) {
                return back()->withErrors([
                    'login_id' => 'Email atau kata sandi yang Anda masukkan salah.'
                ])->onlyInput('login_id');
            }
        }

        /**
         * Session regenerate & Redirect (BERLAKU UNTUK KEDUANYA)
         */
        $request->session()->regenerate();
        $user = Auth::user();

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard')->with('success', 'Selamat datang di dashboard admin');
        } elseif ($user->role === 'perawat') {
            return redirect()->route('perawat.dashboard')->with('success', 'Selamat datang di dashboard perawat');
        } elseif ($user->role === 'pasien') {
            return redirect()->route('pasien.dashboard')->with('success', 'Selamat datang di portal pasien');
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
