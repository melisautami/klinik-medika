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
    $today = now()->toDateString();

    $totalKunjungan = Kunjungan::whereDate('created_at', $today)->count();
    $rawatJalan = Kunjungan::where('tipe', 'rawat_jalan')->whereDate('created_at', $today)->count();
    $rawatInap = Kunjungan::where('tipe', 'rawat_inap')->whereDate('created_at', $today)->count();

    // antrean hari ini, eager-load pasien->pengguna dan perawat
    $antreanHariIni = Kunjungan::with(['pasien.pengguna', 'perawat'])
      ->whereDate('created_at', $today)
      ->orderBy('created_at', 'asc')
      ->get();

    // pasien yang selesai diperiksa namun belum ada/selesai proses pembayaran
    $menungguPembayaran = Kunjungan::where('status', 'like', '%selesai%')
      ->where(function ($q) {
        $q->doesntHave('pembayaran')
          ->orWhereHas('pembayaran', function ($q2) {
            $q2->where('status', '!=', 'selesai');
          });
      })->count();

    return view('admin.dashboard', compact(
      'totalKunjungan',
      'rawatJalan',
      'rawatInap',
      'antreanHariIni',
      'menungguPembayaran'
    ));
  }
}
