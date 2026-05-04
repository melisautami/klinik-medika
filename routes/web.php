<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\PemeriksaanController;
use App\Http\Controllers\Admin\KonfirmasiController;
use App\Http\Controllers\Admin\PasienController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

// Auth routes  logout
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

//prefik untuk admin routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    // Dashboard
    Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Manajemen pasien (CRUD)
    Route::resource('pasien', PasienController::class);

    // Ajukan pemeriksaan
    Route::get('pemeriksaan/create', [PemeriksaanController::class, 'create'])->name('pemeriksaan.create');
    Route::post('pemeriksaan/ajukan', [PemeriksaanController::class, 'ajukan'])->name('pemeriksaan.ajukan');

    // Kunjungan management
    Route::get('kunjungan', [App\Http\Controllers\Admin\KunjunganController::class, 'index'])->name('kunjungan.index');
    Route::get('kunjungan/{kunjungan}', [App\Http\Controllers\Admin\KunjunganController::class, 'show'])->name('kunjungan.show');
    Route::post('kunjungan/{kunjungan}/status', [App\Http\Controllers\Admin\KunjunganController::class, 'updateStatus'])->name('kunjungan.updateStatus');

    // Konfirmasi pembayaran
    Route::post('konfirmasi/{id}/bayar', [KonfirmasiController::class, 'konfirmasiBayar'])->name('konfirmasi.bayar');

    // Pembayaran / Tarif conversion
    Route::get('kunjungan/{kunjungan}/pembayaran/create', [App\Http\Controllers\Admin\PembayaranController::class, 'create'])->name('pembayaran.create');
    Route::post('kunjungan/{kunjungan}/pembayaran', [App\Http\Controllers\Admin\PembayaranController::class, 'store'])->name('pembayaran.store');
});
