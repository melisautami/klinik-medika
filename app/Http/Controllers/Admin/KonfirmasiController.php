<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kunjungan;
use App\Models\Pembayaran;

class KonfirmasiController extends Controller
{
  public function konfirmasiBayar(Request $request, $id)
  {
    $kunjungan = Kunjungan::findOrFail($id);

    $request->validate(['status' => 'required|in:lunas,belum']);

    // sederhana: buat atau update pembayaran
    $pembayaran = Pembayaran::updateOrCreate(
      ['kunjungan_id' => $kunjungan->id],
      ['status' => $request->status]
    );

    return redirect()->back()->with('success', 'Status pembayaran diperbarui.');
  }
}
