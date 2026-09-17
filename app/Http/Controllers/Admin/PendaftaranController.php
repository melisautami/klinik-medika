<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\PendaftaranOnline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PendaftaranController extends Controller
{
  public function index(Request $request)
  {
    $query = PendaftaranOnline::with(['pasien.pengguna', 'petugas'])
      ->orderBy('created_at', 'desc');

    if ($request->filled('status')) {
      $query->where('status', $request->status);
    }

    if ($request->filled('search')) {
      $search = $request->search;

      $query->where(function ($q) use ($search) {
        $q->whereHas('pasien.pengguna', function ($sub) use ($search) {
          $sub->where('name', 'like', '%' . $search . '%');
        })->orWhereHas('pasien', function ($sub) use ($search) {
          $sub->where('nik', 'like', '%' . $search . '%');
        });
      });
    }

    $pendaftarans = $query->paginate(10)->withQueryString();

    return view('admin.pendaftaran.index', compact('pendaftarans'));
  }

  public function approve(PendaftaranOnline $pendaftaran)
  {
    if ($pendaftaran->status !== 'pending') {
      return back()->with('error', 'Status pendaftaran tidak dapat diproses lagi.');
    }

    $pendaftaran->update([
      'status' => 'diterima',
      'petugas_id' => Auth::id(),
      'catatan_admin' => 'Pendaftaran diterima oleh petugas.',
    ]);

    Kunjungan::create([
      'pasien_id' => $pendaftaran->pasien_id,
      'petugas_id' => Auth::id(),
      'perawat_id' => null,
      'tipe' => $pendaftaran->tipe,
      'tanggal_kunjungan' => $pendaftaran->tanggal_kunjungan,
      'keluhan' => $pendaftaran->keluhan,
      'status' => 'menunggu',
    ]);

    return back()->with('success', 'Pendaftaran pasien berhasil diterima dan antrean dibuat.');
  }

  public function reject(Request $request, PendaftaranOnline $pendaftaran)
  {
    $request->validate([
      'catatan_admin' => 'required|string|max:255',
    ]);

    if ($pendaftaran->status !== 'pending') {
      return back()->with('error', 'Status pendaftaran tidak dapat diproses lagi.');
    }

    $pendaftaran->update([
      'status' => 'ditolak',
      'petugas_id' => Auth::id(),
      'catatan_admin' => $request->catatan_admin,
    ]);

    return back()->with('success', 'Pendaftaran pasien berhasil ditolak.');
  }
}
