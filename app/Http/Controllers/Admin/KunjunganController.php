<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
    $statusBaru = $request->validate([
      'status' => 'required|in:menunggu,diproses,selesai_diperiksa,menunggu_pembayaran,selesai',
    ])['status'];

    if ($statusBaru === 'selesai' && (!$kunjungan->pembayaran || $kunjungan->pembayaran->status !== 'lunas')) {
      return redirect()->back()->with('error', 'Kunjungan hanya dapat berstatus selesai setelah pembayaran lunas.');
    }

    DB::transaction(function () use ($kunjungan, $statusBaru) {
      $kunjungan->status = $statusBaru;
      $kunjungan->save();

      if ($statusBaru === 'menunggu_pembayaran' && $kunjungan->pembayaran) {
        $kunjungan->pembayaran->update([
          'status' => 'belum_lunas',
          'tanggal_bayar' => null,
        ]);
      }
    });

    return redirect()->back()->with('success', 'Status kunjungan berhasil diperbarui.');
  }
}
