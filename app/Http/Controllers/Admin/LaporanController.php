<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        // Ambil input filter bulan & tahun (default: bulan & tahun saat ini)
        $bulan = $request->input('bulan', date('m'));
        $tahun = $request->input('tahun', date('Y'));

        // 1. Ambil data, TAMBAHKAN AWALAN 'kunjungans.' PADA NAMA KOLOM
        $query = Kunjungan::with(['pasien.pengguna', 'pembayaran'])
            ->whereMonth('kunjungans.tanggal_kunjungan', $bulan)
            ->whereYear('kunjungans.tanggal_kunjungan', $tahun)
            ->where('kunjungans.status', 'selesai') // <-- Perbaikan di sini
            ->whereHas('pembayaran', function ($q) {
                $q->where('status', 'Lunas');
            });

        // 2. Kalkulasi Ringkasan Data (tambahkan awalan 'kunjungans.' juga)
        $totalKunjungan = (clone $query)->count();
        $rawatJalan     = (clone $query)->where('kunjungans.tipe', 'rawat_jalan')->count();
        $rawatInap      = (clone $query)->where('kunjungans.tipe', 'rawat_inap')->count();

        // 3. Kalkulasi Pendapatan 
        $totalPendapatan = (clone $query)
            ->join('pembayarans', 'kunjungans.id', '=', 'pembayarans.kunjungan_id')
            ->sum('pembayarans.total_bayar');

        $pendapatanJalan = (clone $query)->where('kunjungans.tipe', 'rawat_jalan')
            ->join('pembayarans', 'kunjungans.id', '=', 'pembayarans.kunjungan_id')
            ->sum('pembayarans.total_bayar');

        $pendapatanInap = (clone $query)->where('kunjungans.tipe', 'rawat_inap')
            ->join('pembayarans', 'kunjungans.id', '=', 'pembayarans.kunjungan_id')
            ->sum('pembayarans.total_bayar');

        // 4. Ambil data list untuk tabel (Paginated)
        $laporans = $query->latest('kunjungans.tanggal_kunjungan')->paginate(15);

        return view('admin.laporan.index', compact(
            'totalKunjungan',
            'rawatJalan',
            'rawatInap',
            'totalPendapatan',
            'pendapatanJalan',
            'pendapatanInap',
            'laporans'
        ));
    }

    public function cetakPdf(Request $request)
    {
        // Ambil parameter bulan & tahun dari URL (yang dikirim oleh tombol)
        $bulan = $request->bulan ?? date('n');
        $tahun = $request->tahun ?? date('Y');

        // 1. Lakukan query yang SAMA PERSIS dengan yang ada di fungsi index() kamu
        // Contoh (sesuaikan dengan nama model/relasimu):
        $laporans = Kunjungan::with(['pasien.pengguna', 'pembayaran'])
            ->whereMonth('tanggal_kunjungan', $bulan)
            ->whereYear('tanggal_kunjungan', $tahun)
            ->where('status', 'selesai')
            ->get(); // Gunakan get(), BUKAN paginate() agar semua data tercetak di PDF

        // 2. Hitung statistik yang SAMA PERSIS dengan di index()
        $totalPendapatan = $laporans->sum(function ($item) {
            return $item->pembayaran->total_bayar ?? 0;
        });
        $totalKunjungan = $laporans->count();
        $rawatJalan = $laporans->where('tipe', 'rawat_jalan')->count();
        $rawatInap = $laporans->where('tipe', 'rawat_inap')->count();
        // ... hitung pendapatan jalan & inap

        // 3. Render ke PDF
        $pdf = Pdf::loadView('admin.laporan.cetak', compact(
            'laporans',
            'bulan',
            'tahun',
            'totalPendapatan',
            'totalKunjungan',
            'rawatJalan',
            'rawatInap'
        ));

        // Atur ukuran kertas ke A4 (opsional)
        $pdf->setPaper('a4', 'portrait');

        // 4. Buka di browser (stream) atau langsung download
        return $pdf->stream("Laporan_Klinik_{$bulan}_{$tahun}.pdf");
    }
}
