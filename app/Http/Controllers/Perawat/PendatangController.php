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
            ->get();

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

        $request->validate([
            'diagnosa' => 'required|string',
            'tindakan' => 'required|string',
        ]);

        $kunjungan->update([
            'diagnosa' => $request->diagnosa,
            'tindakan' => $request->tindakan,
            'status' => 'selesai_diperiksa'
        ]);

        return redirect()->route('perawat.kunjungan')
            ->with('success', 'Rekam medis berhasil disimpan');
    }
}
