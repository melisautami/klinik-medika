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

    $statusBayar = $request->status === 'lunas' ? 'Lunas' : 'Belum Lunas';

    $pembayaran = Pembayaran::updateOrCreate(
      ['kunjungan_id' => $kunjungan->id],
      [
        'status' => $statusBayar,
        'tanggal_bayar' => $request->status === 'lunas' ? now() : null,
      ]
    );

    $kunjungan->status = $request->status === 'lunas' ? 'selesai' : 'menunggu_pembayaran';
    $kunjungan->save();

    return redirect()->back()->with('success', 'Status pembayaran berhasil diperbarui.');
  }
}
