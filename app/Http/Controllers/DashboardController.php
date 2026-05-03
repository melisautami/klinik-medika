<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function login()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            return view('admin.dashboard', compact('user'));
        } elseif ($user->role === 'pembimbing') {
            return view('perawat.dashboard', compact('user'));
        } elseif ($user->role === 'siswa') {
            return view('pasien.dashboard', compact('user'));
        } else {
            abort(403, 'Role penguna tidak dikenali');
        }
    }
}
