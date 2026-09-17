<?php

namespace App\Http\Controllers\Perawat;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\Tarif;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PendatangController extends Controller
{
    public function index(Request $request)
    {
        $tab = in_array($request->input('tab'), ['rawat_jalan', 'rawat_inap'], true)
            ? $request->input('tab')
            : 'rawat_jalan';

        $search = trim((string) $request->input('search', ''));

        $query = Kunjungan::with(['pasien.pengguna', 'perawat'])
            ->where('tipe', $tab)
            ->where(function ($query) {
                $query->where('status', 'menunggu')
                    ->orWhere(function ($query) {
                        $query->where('status', 'diproses')
                            ->where('perawat_id', Auth::id());
                    });
            });

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->whereHas('pasien.pengguna', function ($subQuery) use ($search) {
                    $subQuery->where('name', 'like', '%' . $search . '%');
                })->orWhereHas('pasien', function ($subQuery) use ($search) {
                    $subQuery->where('nik', 'like', '%' . $search . '%');
                });
            });
        }

        $kunjungans = $query
            ->orderBy('created_at', 'asc')
            ->paginate(10)
            ->appends(['tab' => $tab, 'search' => $search]);

        return view('perawat.kunjungan.index', compact('kunjungans', 'tab', 'search'));
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
        if ($kunjungan->perawat_id != Auth::id()) {
            abort(403);
        }

        $tarifs = Tarif::orderBy('nama_tindakan')->get();

        return view('perawat.kunjungan.show', compact('kunjungan', 'tarifs'));
    }

    /**
     * 🩺 Input rekam medis
     */
    public function rekamMedis(Request $request, Kunjungan $kunjungan)
    {
        // keamanan
        if ((int) $kunjungan->perawat_id !== (int) Auth::id()) {
            abort(403);
        }

        // Validasi tambahan
        $request->validate([
            'keluhan'   => 'required|string',
            'diagnosa'  => 'required|string',
            'tindakan'  => 'nullable|string',
            'tarif_ids' => 'nullable|array',
            'tarif_ids.*' => 'exists:tarifs,id',
        ]);

        $tindakanText = Kunjungan::normalizeTindakanText($request->tindakan);
        $tarifIds = array_values(array_unique(array_map('intval', $request->input('tarif_ids', []))));

        if ($tindakanText === '' && empty($tarifIds)) {
            return back()->withErrors(['tindakan' => 'Isi minimal satu tindakan medik dan harga.'])->withInput();
        }

        // Simpan data
        $kunjungan->keluhan  = $request->keluhan;
        $kunjungan->diagnosa = $request->diagnosa;
        $kunjungan->tindakan = $tindakanText;
        $kunjungan->tarif_ids = $tarifIds;
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
        if ((int) $kunjungan->perawat_id !== (int) Auth::id()) {
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
