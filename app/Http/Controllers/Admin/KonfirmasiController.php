<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\Pembayaran;
use Illuminate\Http\Request;

class KonfirmasiController extends Controller
{
  public function konfirmasiBayar(Request $request, Kunjungan $kunjungan)
  {
    $request->validate([
      'status' => 'required|in:belum_lunas,lunas',
      'metode_pembayaran' => 'nullable|in:qris,manual',
    ]);

    $statusBaru = $request->status ?? 'lunas';
    $metodePembayaran = $request->metode_pembayaran ?? $kunjungan->pembayaran?->metode_pembayaran ?? 'qris';

    $pembayaran = Pembayaran::updateOrCreate(
      ['kunjungan_id' => $kunjungan->id],
      [
        'status' => $statusBaru,
        'metode_pembayaran' => $metodePembayaran,
        'tanggal_bayar' => $statusBaru === 'lunas' ? now() : null,
      ]
    );

    if ($statusBaru === 'lunas') {
      $kunjungan->status = 'selesai';
      $kunjungan->save();
    }

    return redirect()->route('admin.kunjungan.show', $kunjungan->id)
      ->with('success', 'Status pembayaran berhasil diperbarui.');
  }
}
