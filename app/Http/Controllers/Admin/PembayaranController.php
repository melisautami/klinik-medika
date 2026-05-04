<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kunjungan;
use App\Models\Tarif;
use App\Models\Pembayaran;

class PembayaranController extends Controller
{
  // show form to convert kunjungan -> pembayaran
  public function create(Kunjungan $kunjungan)
  {
    $tarifs = Tarif::orderBy('nama_tindakan')->get();
    return view('admin.pembayaran.create', compact('kunjungan', 'tarifs'));
  }

  // store pembayaran from selected tarif ids
  public function store(Request $request, Kunjungan $kunjungan)
  {
    $request->validate([
      'tarif_ids' => 'required|array|min:1',
      'tarif_ids.*' => 'exists:tarifs,id',
    ]);

    $tarifs = Tarif::whereIn('id', $request->tarif_ids)->get();
    $total = $tarifs->sum('harga');

    $pembayaran = Pembayaran::create([
      'kunjungan_id' => $kunjungan->id,
      'total_bayar' => $total,
      'status' => 'belum_lunas',
      'tanggal_bayar' => null,
    ]);

    return redirect()->route('admin.kunjungan.show', $kunjungan->id)->with('success', 'Pembayaran dibuat (belum lunas).');
  }
}
