<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\PendaftaranOnline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PendaftaranController extends Controller
{
  public function index()
  {
    $pasien = Auth::user()->pasien;

    if (!$pasien) {
      abort(404, 'Data pasien tidak ditemukan.');
    }

    $pendaftarans = PendaftaranOnline::with('petugas')
      ->where('pasien_id', $pasien->id)
      ->latest()
      ->paginate(10);

    return view('pasien.pendaftaran.index', compact('pendaftarans'));
  }

  public function create()
  {
    $pasien = Auth::user()->pasien;

    if (!$pasien) {
      abort(404, 'Data pasien tidak ditemukan.');
    }

    return view('pasien.pendaftaran.create', compact('pasien'));
  }

  public function store(Request $request)
  {
    $pasien = Auth::user()->pasien;

    if (!$pasien) {
      abort(404, 'Data pasien tidak ditemukan.');
    }

    $validated = $request->validate([
      'tipe' => 'required|in:rawat_jalan,rawat_inap',
      'tanggal_kunjungan' => 'required|date|after_or_equal:today',
      'keluhan' => 'nullable|string|max:500',
    ]);

    PendaftaranOnline::create([
      'pasien_id' => $pasien->id,
      'tipe' => $validated['tipe'],
      'tanggal_kunjungan' => $validated['tanggal_kunjungan'],
      'keluhan' => $validated['keluhan'] ?? null,
      'status' => 'pending',
    ]);

    return redirect()->route('pasien.pendaftaran.index')
      ->with('success', 'Pendaftaran online berhasil dikirim. Silakan menunggu validasi dari petugas.');
  }
}
