<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kunjungan;
use App\Models\Pasien;
use App\Models\Pembayaran;

class DashboardController extends Controller
{
  public function index()
  {
    $today = now()->startOfDay();
    $totalKunjungan = Kunjungan::where('created_at', '>=', $today)->count();
    $rawatJalan = Kunjungan::where('tipe', 'rawat_jalan')->where('created_at', '>=', $today)->count();
    $rawatInap = Kunjungan::where('tipe', 'rawat_inap')->where('created_at', '>=', $today)->count();

    return view('admin.dashboard', compact('totalKunjungan', 'rawatJalan', 'rawatInap'));
  }
}
