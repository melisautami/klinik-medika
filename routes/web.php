<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\PemeriksaanController;
use App\Http\Controllers\Admin\KonfirmasiController;
use App\Http\Controllers\Admin\PasienController;
use App\Http\Controllers\Admin\PerawatController;
use App\Http\Controllers\Perawat\PendatangController;
use App\Http\Controllers\Pasien\BiodataController;
use App\Http\Controllers\Pasien\PendaftaranController as PasienPendaftaranController;
use App\Http\Controllers\Admin\PendaftaranController as AdminPendaftaranController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

// Auth routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'pasienLoginForm'])->name('login');
    Route::get('/login/petugas', [AuthController::class, 'adminLoginForm'])->name('login.admin');
    Route::get('/login/perawat', [AuthController::class, 'perawatLoginForm'])->name('login.perawat');
    Route::get('/login/pasien', [AuthController::class, 'pasienLoginForm'])->name('login.pasien');

    Route::post('/login/petugas', [AuthController::class, 'loginAdmin'])->name('login.admin.post');
    Route::post('/login/perawat', [AuthController::class, 'loginPerawat'])->name('login.perawat.post');
    Route::post('/login/pasien', [AuthController::class, 'loginPasien'])->name('login.pasien.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

//prefik untuk admin routes
Route::prefix('petugas')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    // Dashboard
    Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Manajemen pasien (CRUD)
    Route::get('pasien-kategori/{kategori}', [PasienController::class, 'kategori'])->name('pasien.kategori');
    Route::resource('pasien', PasienController::class);

    //crud perawat
    Route::resource('perawat', PerawatController::class);

    // Ajukan pemeriksaan
    Route::get('pemeriksaan/create', [PemeriksaanController::class, 'create'])->name('pemeriksaan.create');
    Route::post('pemeriksaan/ajukan', [PemeriksaanController::class, 'ajukan'])->name('pemeriksaan.ajukan');

    // Kunjungan management
    Route::get('kunjungan', [App\Http\Controllers\Admin\KunjunganController::class, 'index'])->name('kunjungan.index');
    Route::get('kunjungan/{kunjungan}', [App\Http\Controllers\Admin\KunjunganController::class, 'show'])->name('kunjungan.show');
    Route::post('kunjungan/{kunjungan}/status', [App\Http\Controllers\Admin\KunjunganController::class, 'updateStatus'])->name('kunjungan.updateStatus');

    Route::resource('tarif', App\Http\Controllers\Admin\TarifController::class);

    // Konfirmasi pembayaran
    Route::post('konfirmasi/{kunjungan}/bayar', [KonfirmasiController::class, 'konfirmasiBayar'])->name('konfirmasi.bayar');

    // Pembayaran / Tarif conversion
    Route::get('pembayaran', [App\Http\Controllers\Admin\PembayaranController::class, 'index'])->name('pembayaran.index');
    Route::get('kunjungan/{kunjungan}/pembayaran/create', [App\Http\Controllers\Admin\PembayaranController::class, 'create'])->name('pembayaran.create');
    Route::post('kunjungan/{kunjungan}/pembayaran', [App\Http\Controllers\Admin\PembayaranController::class, 'store'])->name('pembayaran.store');
    Route::get('kunjungan/{kunjungan}/pembayaran/qris', [App\Http\Controllers\Admin\PembayaranController::class, 'qris'])->name('pembayaran.qris');
    Route::post('kunjungan/{kunjungan}/pembayaran/ubah-ke-manual', [App\Http\Controllers\Admin\PembayaranController::class, 'ubahKeManual'])->name('pembayaran.ubahManual');
    // Laporan
    Route::get('laporan', [App\Http\Controllers\Admin\LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/pdf', [\App\Http\Controllers\Admin\LaporanController::class, 'cetakPdf'])->name('laporan.pdf');

    // Pendaftaran online
    Route::get('pendaftaran', [AdminPendaftaranController::class, 'index'])->name('pendaftaran.index');
    Route::post('pendaftaran/{pendaftaran}/approve', [AdminPendaftaranController::class, 'approve'])->name('pendaftaran.approve');
    Route::post('pendaftaran/{pendaftaran}/reject', [AdminPendaftaranController::class, 'reject'])->name('pendaftaran.reject');
});
//prefik untuk perawat routes
Route::prefix('perawat')->name('perawat.')->middleware(['auth', 'role:perawat'])->group(function () {
    //Dashboard
    Route::get('dashboard', [DashboardController::class, 'masuk'])->name('dashboard');

    //lihat pasien pendatang
    Route::get('/kunjungan', [PendatangController::class, 'index'])->name('kunjungan');

    Route::post('/kunjungan/{kunjungan}/ambil', [PendatangController::class, 'ambil'])->name('ambil');

    Route::get('/kunjungan/{kunjungan}', [PendatangController::class, 'show'])->name('show');

    Route::post('/kunjungan/{kunjungan}/rekam-medis', [PendatangController::class, 'rekamMedis'])->name('rekam');

    // Riwayat pemeriksaan
    Route::get('/riwayat', [PendatangController::class, 'riwayat'])->name('riwayat');

    Route::get('/kunjungan/{kunjungan}/detail', [PendatangController::class, 'detail'])->name('detail');
});


// prefix untuk pasien routes
Route::prefix('pasien')
    ->name('pasien.')
    ->middleware(['auth', 'role:pasien'])
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'masuk'])
            ->name('dashboard');

        Route::get('/kunjungan/{kunjungan}/detail', [BiodataController::class, 'detailPasien'])
            ->name('detail');

        Route::get('/pendaftaran', [PasienPendaftaranController::class, 'index'])->name('pendaftaran.index');
        Route::get('/pendaftaran/create', [PasienPendaftaranController::class, 'create'])->name('pendaftaran.create');
        Route::post('/pendaftaran', [PasienPendaftaranController::class, 'store'])->name('pendaftaran.store');
    });
