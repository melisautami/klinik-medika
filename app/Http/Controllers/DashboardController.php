<?php

namespace App\Http\Controllers;

use App\Models\Kunjungan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function masuk()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            return view('admin.dashboard', compact('user'));
        } elseif ($user->role === 'perawat') {
            $perawatId = Auth::id();

            // Total pasien yang pernah ditangani perawat ini
            $totalKunjungan = Kunjungan::where('perawat_id', $perawatId)
                ->count();

            // Pasien menunggu (belum diambil siapapun)
            $menunggu = Kunjungan::where('status', 'menunggu')
                ->count();

            // Sedang diproses oleh perawat login
            $diproses = Kunjungan::where('perawat_id', $perawatId)
                ->where('status', 'diproses')
                ->count();

            // Selesai diperiksa oleh perawat login
            $selesai = Kunjungan::where('perawat_id', $perawatId)
                ->where('status', 'selesai_diperiksa')
                ->count();

            return view('perawat.dashboard', compact(
                'totalKunjungan',
                'menunggu',
                'diproses',
                'selesai'
            ));
        } elseif ($user->role === 'pasien') {
            // pastikan pasien tersedia
            if (!$user->pasien) {
                abort(404, 'Data pasien tidak ditemukan');
            }

            $pasien = $user->pasien;

            $query = Kunjungan::with([
                'perawat',
                'pembayaran'
            ])->where('pasien_id', $pasien->id);

            // Total kunjungan
            $totalKunjungan = (clone $query)->count();
            $statusPasien = $totalKunjungan > 1 ? 'Pasien Lama' : 'Pasien Baru';

            // Pemeriksaan selesai
            $selesai = (clone $query)
                ->where('status', 'selesai')
                ->count();

            // Menunggu pembayaran
            $menungguPembayaran = (clone $query)
                ->where('status', 'menunggu_pembayaran')
                ->count();

            // Riwayat kunjungan
            $kunjungans = (clone $query)
                ->latest()
                ->take(10)
                ->get();

            return view('pasien.dashboard', compact(
                'totalKunjungan',
                'statusPasien',
                'selesai',
                'menungguPembayaran',
                'kunjungans'
            ));
        } else {
            abort(403, 'Role penguna tidak dikenali');
        }
    }
}
