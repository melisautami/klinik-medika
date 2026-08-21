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
    $tarifs = Tarif::whereIn('id', $kunjungan->tarif_ids ?? [])
      ->orderBy('nama_tindakan')
      ->get();
    return view('admin.pembayaran.create', compact('kunjungan', 'tarifs'));
  }

  public function store(Request $request, Kunjungan $kunjungan)
  {
    $tarifIds = $kunjungan->tarif_ids ?? [];
    if (empty($tarifIds)) {
      return back()->withErrors(['tarif_ids' => 'Belum ada tindakan bertarif yang dipilih perawat.']);
    }

    $tarifs = Tarif::whereIn('id', $tarifIds)->get();
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
