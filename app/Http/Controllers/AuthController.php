<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Form login admin
     */
    public function adminLoginForm()
    {
        return view('auth.admin-login');
    }

    /**
     * Form login perawat
     */
    public function perawatLoginForm()
    {
        return view('auth.perawat-login');
    }

    /**
     * Form login pasien
     */
    public function pasienLoginForm()
    {
        return view('auth.pasien-login');
    }

    /**
     * Proses login admin
     */
    public function loginAdmin(Request $request)
    {
        return $this->authenticate($request, 'admin');
    }

    /**
     * Proses login perawat
     */
    public function loginPerawat(Request $request)
    {
        return $this->authenticate($request, 'perawat');
    }

    /**
     * Proses login pasien
     */
    public function loginPasien(Request $request)
    {
        return $this->authenticate($request, 'pasien');
    }

    private function authenticate(Request $request, string $role)
    {
        $request->validate([
            'login_id' => ['required'],
            'password' => ['required'],
        ]);

        if ($role === 'pasien') {
            $pasien = Pasien::with('pengguna')->where('nik', $request->login_id)->first();

            if (!$pasien || !$pasien->pengguna) {
                return back()->withErrors([
                    'login_id' => 'NIK atau akun pasien tidak ditemukan.'
                ])->onlyInput('login_id');
            }

            $credentials = [
                'email' => $pasien->pengguna->email,
                'password' => $request->password,
                'role' => 'pasien'
            ];
        } else {
            $credentials = [
                'email' => $request->login_id,
                'password' => $request->password,
                'role' => $role
            ];
        }

        if (!Auth::attempt($credentials)) {
            return back()->withErrors([
                'login_id' => $role === 'pasien'
                    ? 'NIK atau kata sandi yang Anda masukkan salah.'
                    : 'Email atau kata sandi yang Anda masukkan salah.'
            ])->onlyInput('login_id');
        }

        $request->session()->regenerate();
        $user = Auth::user();

        if ($user->role !== $role) {
            Auth::logout();
            return back()->withErrors([
                'login_id' => 'Akun ini tidak terdaftar sebagai ' . $role . '.'
            ])->onlyInput('login_id');
        }

        $redirectRoute = match ($role) {
            'admin' => 'admin.dashboard',
            'perawat' => 'perawat.dashboard',
            'pasien' => 'pasien.dashboard',
        };

        $successMessage = match ($role) {
            'admin' => 'Selamat datang di dashboard admin',
            'perawat' => 'Selamat datang di dashboard perawat',
            'pasien' => 'Selamat datang di portal pasien',
        };

        return redirect()->route($redirectRoute)->with('success', $successMessage);
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
