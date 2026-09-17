<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kunjungan;
use App\Models\Tarif;
use App\Models\Pembayaran;

class PembayaranController extends Controller
{
  public function index(Request $request)
  {
    // Ambil kunjungan yang statusnya sudah Selesai Diperiksa (perlu tarif),
    // Menunggu Pembayaran (belum lunas), atau Selesai (sudah lunas)
    $query = Kunjungan::with(['pasien.pengguna', 'pembayaran'])
      ->whereIn('status', ['selesai_diperiksa', 'menunggu_pembayaran', 'selesai']);

    // Logika pencarian (jika ada input search di view)
    if ($request->has('search') && $request->search != '') {
      $search = $request->search;
      $query->whereHas('pasien.pengguna', function ($q) use ($search) {
        $q->where('name', 'like', '%' . $search . '%');
      });
    }

    // Urutkan yang terbaru di atas
    $kunjungans = $query->latest('tanggal_kunjungan')->paginate(10);

    return view('admin.pembayaran.index', compact('kunjungans'));
  }
  // show form to convert kunjungan -> pembayaran
  public function create(Kunjungan $kunjungan)
  {
    $tarifs = $kunjungan->getParsedTindakanItems();

    if ($tarifs->isEmpty()) {
      $tarifs = Tarif::whereIn('id', $kunjungan->tarif_ids ?? [])
        ->orderBy('nama_tindakan')
        ->get();
    }

    return view('admin.pembayaran.create', compact('kunjungan', 'tarifs'));
  }

  public function store(Request $request, Kunjungan $kunjungan)
  {
    $request->validate([
      'metode_pembayaran' => 'required|in:qris,manual',
    ]);

    $total = $kunjungan->getTindakanTotal();

    if ($total <= 0) {
      $tarifIds = $kunjungan->tarif_ids ?? [];
      if (!empty($tarifIds)) {
        $total = Tarif::whereIn('id', $tarifIds)->sum('harga');
      }
    }

    if ($total <= 0) {
      return back()->withErrors(['tindakan' => 'Belum ada tindakan dan harga yang dicatat perawat.']);
    }

    $pembayaran = Pembayaran::updateOrCreate(
      ['kunjungan_id' => $kunjungan->id],
      [
        'total_bayar' => $total,
        'status' => 'belum_lunas',
        'metode_pembayaran' => $request->metode_pembayaran,
        'tanggal_bayar' => null,
      ]
    );

    if ($request->metode_pembayaran === 'qris') {
      return redirect()->route('admin.pembayaran.qris', $kunjungan->id);
    }

    return redirect()->route('admin.kunjungan.show', $kunjungan->id)->with('success', 'Pembayaran cash berhasil dibuat.');
  }

  public function qris(Kunjungan $kunjungan)
  {
    $kunjungan->load(['pasien.pengguna', 'pembayaran']);

    $pembayaran = $kunjungan->pembayaran;
    if (!$pembayaran) {
      return redirect()->route('admin.pembayaran.index')->with('error', 'Tagihan pembayaran belum dibuat.');
    }

    return view('admin.pembayaran.qris', compact('kunjungan', 'pembayaran'));
  }

  public function ubahKeManual(Kunjungan $kunjungan)
  {
    $pembayaran = $kunjungan->pembayaran;

    if (!$pembayaran) {
      return redirect()->route('admin.pembayaran.index')
        ->with('error', 'Tagihan pembayaran belum dibuat.');
    }

    if ($pembayaran->status === 'lunas') {
      return back()->with('error', 'Pembayaran yang sudah lunas tidak dapat diubah metodenya.');
    }

    $pembayaran->update([
      'metode_pembayaran' => 'manual',
    ]);

    return redirect()->route('admin.pembayaran.create', $kunjungan->id)
      ->with('success', 'Metode pembayaran diubah menjadi cash/manual. Silakan lanjutkan pembayaran.');
  }
}
