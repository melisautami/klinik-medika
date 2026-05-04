<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kunjungan;
use App\Models\Pasien;
use App\Models\User;

class PemeriksaanController extends Controller
{
  public function create()
  {
    $pasiens = Pasien::orderBy('created_at', 'desc')->get();
    $perawats = User::where('role', 'perawat')->get();

    return view('admin.pemeriksaan.create', compact('pasiens', 'perawats'));
  }
  // Ajukan pemeriksaan: buat kunjungan baru dan assign ke perawat (placeholder)
  public function ajukan(Request $request)
  {
    $request->validate([
      'pasien_id' => 'required|exists:pasiens,id',
      'perawat_id' => 'nullable|exists:users,id',
      'tipe' => 'required|string',
    ]);

    $kunjungan = Kunjungan::create([
      'pasien_id' => $request->pasien_id,
      'petugas_id' => auth()->id(),
      'perawat_id' => $request->perawat_id,
      'tanggal_kunjungan' => now()->toDateString(),
      'tipe' => $request->tipe,
      'status' => 'menunggu',
    ]);

    return redirect()->back()->with('success', 'Pemeriksaan diajukan.');
  }
}
