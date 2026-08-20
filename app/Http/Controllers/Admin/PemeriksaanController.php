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
    $pasiens = Pasien::with('pengguna')
      ->whereHas('pengguna', function ($query) {
        $query->where('role', 'pasien');
      })
      ->orderBy('created_at', 'desc')
      ->get();

    $perawats = User::where('role', 'perawat')->get();

    return view('admin.pemeriksaan.create', compact('pasiens', 'perawats'));
  }

  // Ajukan pemeriksaan: buat kunjungan baru dan assign ke perawat (placeholder)
  public function ajukan(Request $request)
  {
    $request->validate([
      'pasien_id'  => 'required|exists:pasiens,id',
      'tipe'       => 'required|in:rawat_jalan,rawat_inap',
      'perawat_id' => 'nullable|exists:users,id',
      'keluhan'    => 'nullable|string'
    ]);

    // Simpan ke tabel kunjungans
    Kunjungan::create([
      'pasien_id'         => $request->pasien_id,
      'tipe'              => $request->tipe,
      'perawat_id'        => $request->perawat_id,
      'petugas_id'        => auth()->id(), // <-- INI YANG KETINGGALAN
      'keluhan'           => $request->keluhan,
      'tanggal_kunjungan' => now()->format('Y-m-d'),
      'status'            => 'menunggu'
    ]);

    return redirect()->route('admin.dashboard')->with('success', 'Pasien berhasil masuk ke antrean pemeriksaan.');
  }
}
