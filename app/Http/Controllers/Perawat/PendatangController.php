<?php

namespace App\Http\Controllers\Perawat;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PendatangController extends Controller
{
    public function index()
    {
        $kunjungans = Kunjungan::with(['pasien.pengguna', 'perawat'])
            ->whereIn('status', ['menunggu', 'diproses'])
            ->orderBy('created_at', 'asc')
            ->paginate(10);

        return view('perawat.kunjungan.index', compact('kunjungans'));
    }
    /**
     * 🔥 Ambil pasien
     */
    public function ambil(Kunjungan $kunjungan)
    {
        // kalau sudah diambil
        if ($kunjungan->status !== 'menunggu') {
            return back()->with('error', 'Pasien sudah diambil');
        }

        $kunjungan->update([
            'perawat_id' => Auth::id(),
            'status' => 'diproses'
        ]);

        return back()->with('success', 'Pasien berhasil diambil');
    }

    /**
     * 🔍 Detail pasien (halaman periksa)
     */
    public function show(Kunjungan $kunjungan)
    {
        // pastikan hanya perawat yang mengambil yang bisa akses
        if ($kunjungan->perawat_id !== Auth::id()) {
            abort(403);
        }

        return view('perawat.kunjungan.show', compact('kunjungan'));
    }

    /**
     * 🩺 Input rekam medis
     */
    public function rekamMedis(Request $request, Kunjungan $kunjungan)
    {
        // keamanan
        if ($kunjungan->perawat_id !== Auth::id()) {
            abort(403);
        }

        // Validasi tambahan
        $request->validate([
            'keluhan'  => 'required|string',
            'diagnosa' => 'required|string',
            'tindakan' => 'required|string',
        ]);

        // Simpan data
        $kunjungan->keluhan  = $request->keluhan;
        $kunjungan->diagnosa = $request->diagnosa;
        $kunjungan->tindakan = $request->tindakan;
        $kunjungan->status   = 'selesai_diperiksa';
        $kunjungan->save();

        return redirect()->route('perawat.kunjungan')
            ->with('success', 'Rekam medis berhasil disimpan');
    }

    /**
     * Riwayat pemeriksaan
     */
    public function riwayat(Request $request)
    {
        $query = Kunjungan::with(['pasien.pengguna', 'perawat'])

            // hanya pasien milik perawat login
            ->where('perawat_id', Auth::id())

            // hanya yang selesai diperiksa
            ->whereIn('status', ['diproses', 'selesai_diperiksa', 'menunggu_pembayaran', 'selesai']);

        /**
         * Search nama pasien
         */
        if ($request->search) {
            $query->whereHas('pasien.pengguna', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        /**
         * Filter tanggal awal
         */
        if ($request->from) {
            $query->whereDate('created_at', '>=', $request->from);
        }

        /**
         * Filter tanggal akhir
         */
        if ($request->to) {
            $query->whereDate('created_at', '<=', $request->to);
        }

        $kunjungans = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('perawat.kunjungan.riwayat', compact('kunjungans'));
    }

    public function detail(Kunjungan $kunjungan)
    {
        // hanya perawat yang menangani pasien ini
        if ($kunjungan->perawat_id !== Auth::id()) {
            abort(403);
        }

        // load relasi
        $kunjungan->load([
            'pasien.pengguna',
            'perawat',
            'pembayaran'
        ]);

        return view('perawat.kunjungan.detail', compact('kunjungan'));
    }
}
