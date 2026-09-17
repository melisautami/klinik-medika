<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use Illuminate\Http\Request;

class BiodataController extends Controller
{
    public function detailPasien(Kunjungan $kunjungan)
    {
        // pastikan hanya pasien pemilik data
        $pasien = auth()->user()->pasien;

        if (!$pasien || $kunjungan->pasien_id != $pasien->id) {
            abort(403);
        }

        $kunjungan->load([
            'pasien.pengguna',
            'perawat',
            'pembayaran'
        ]);

        return view('pasien.pemeriksaan.detail', compact('kunjungan'));
    }
}
