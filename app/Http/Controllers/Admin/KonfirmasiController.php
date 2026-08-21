<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\Pembayaran;

class KonfirmasiController extends Controller
{
  public function konfirmasiBayar(Kunjungan $kunjungan)
  {
    $pembayaran = Pembayaran::updateOrCreate(
      ['kunjungan_id' => $kunjungan->id],
      [
        'status' => 'lunas',
        'tanggal_bayar' => now(),
      ]
    );

    $kunjungan->status = 'selesai';
    $kunjungan->save();

    return redirect()->back()->with('success', 'Status pembayaran berhasil diperbarui.');
  }
}
