<?php

namespace App\Http\Controllers;

use App\Models\Kunjungan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function masuk()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            return view('admin.dashboard', compact('user'));
        } elseif ($user->role === 'perawat') {
            $today = now()->startOfDay();
            $totalKunjungan = Kunjungan::where('created_at', '>=', $today)->count();
            $rawatJalan = Kunjungan::where('tipe', 'rawat_jalan')->where('created_at', '>=', $today)->count();
            $rawatInap = Kunjungan::where('tipe', 'rawat_inap')->where('created_at', '>=', $today)->count();
            return view('perawat.dashboard', compact('user', 'totalKunjungan', 'rawatJalan', 'rawatInap'));
        } elseif ($user->role === 'pasien') {
            return view('pasien.dashboard', compact('user'));
        } else {
            abort(403, 'Role penguna tidak dikenali');
        }
    }
}
