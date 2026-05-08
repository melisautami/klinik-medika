<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kunjungan;

class KunjunganController extends Controller
{
  public function index(Request $request)
  {
    $query = Kunjungan::with(['pasien.pengguna', 'petugas', 'perawat']);

    if ($request->filled('status')) {
      $query->where('status', $request->status);
    }

    if ($request->filled('from')) {
      $query->where('tanggal_kunjungan', '>=', $request->from);
    }

    if ($request->filled('to')) {
      $query->where('tanggal_kunjungan', '<=', $request->to);
    }

    $kunjungans = $query->orderBy('tanggal_kunjungan', 'desc')->paginate(20)->withQueryString();

    return view('admin.kunjungan.index', compact('kunjungans'));
  }

  public function show(Kunjungan $kunjungan)
  {
    $kunjungan->load(['pasien.pengguna', 'petugas', 'perawat', 'pembayaran']);
    return view('admin.kunjungan.show', compact('kunjungan'));
  }

  public function updateStatus(Request $request, $id)
  {
    $kunjungan = Kunjungan::findOrFail($id);
    $statusBaru = $request->input('status');

    // 1. Update status di tabel Kunjungan
    $kunjungan->status = $statusBaru;
    $kunjungan->save();

    // 2. OTOMATISASI: Jika status kunjungan diubah ke 'selesai', 
    //    maka status pembayaran (jika ada) otomatis di-set 'Lunas'
    if ($statusBaru === 'selesai' && $kunjungan->pembayaran) {
      $kunjungan->pembayaran->status = 'Lunas';
      $kunjungan->pembayaran->save();
    }

    return redirect()->back()->with('success', 'Status kunjungan berhasil diperbarui.');
  }
}
