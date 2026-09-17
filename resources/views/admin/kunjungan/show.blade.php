@extends('layouts.app')

@section('title', 'Detail Kunjungan')

@section('content')
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Header & Tombol Kembali -->
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Detail Kunjungan Pasien</h2>
                <p class="text-sm text-gray-500 mt-1">Rincian informasi kunjungan, tindakan medis, dan status pembayaran.</p>
            </div>
            <a href="{{ route('admin.kunjungan.index') }}"
                class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-semibold text-gray-700 hover:bg-gray-50 hover:text-green-600 transition-colors shadow-sm text-sm">
                &larr; Kembali
            </a>
        </div>

        <!-- Alert Success -->
        @if (session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg mb-6 shadow-sm flex items-center">
                <svg class="h-5 w-5 mr-3 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd"></path>
                </svg>
                <span class="text-green-800 font-medium text-sm">{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg mb-6 shadow-sm">
                <span class="text-red-800 font-medium text-sm">{{ session('error') }}</span>
            </div>
        @endif

        <!-- Card Utama -->
        <div class="bg-white rounded-xl shadow-lg border-t-4 border-green-500 overflow-hidden">

            <div class="p-6 sm:p-8">
                <!-- Section 1: Informasi Umum -->
                <h3 class="text-lg font-bold text-gray-900 mb-4 border-b border-gray-200 pb-2">Informasi Umum</h3>
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
                    <div class="bg-gray-50 px-5 py-3 rounded-lg border border-gray-100">
                        <dt class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Nama Pasien</dt>
                        <dd class="text-base font-bold text-gray-900">{{ $kunjungan->pasien->pengguna->name ?? '-' }}</dd>
                    </div>
                    <div class="bg-gray-50 px-5 py-3 rounded-lg border border-gray-100">
                        <dt class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Tanggal Kunjungan</dt>
                        <dd class="text-base font-medium text-gray-900">{{ $kunjungan->tanggal_kunjungan }}</dd>
                    </div>
                    <div class="bg-gray-50 px-5 py-3 rounded-lg border border-gray-100">
                        <dt class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Perawat Bertugas</dt>
                        <dd class="text-base font-medium text-gray-900">{{ $kunjungan->perawat->name ?? '-' }}</dd>
                    </div>
                    <div class="bg-gray-50 px-5 py-3 rounded-lg border border-gray-100 flex items-center justify-between">
                        <div>
                            <dt class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Status Kunjungan
                            </dt>
                            <dd class="text-base font-bold text-green-600 uppercase">
                                {{ str_replace('_', ' ', $kunjungan->status) }}</dd>
                        </div>
                    </div>
                </dl>

                <!-- Section 2: Rekam Medis Singkat -->
                <h3 class="text-lg font-bold text-gray-900 mb-4 border-b border-gray-200 pb-2">Catatan Medis</h3>
                <dl class="grid grid-cols-1 gap-4 mb-8">
                    <div class="bg-white border border-gray-200 px-5 py-4 rounded-lg shadow-sm">
                        <dt class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Keluhan Pasien</dt>
                        <dd class="text-sm font-medium text-gray-800 whitespace-pre-wrap">
                            {{ $kunjungan->keluhan ?? 'Belum ada data keluhan.' }}</dd>
                    </div>
                    <div
                        class="bg-white border border-gray-200 px-5 py-4 rounded-lg shadow-sm border-l-4 border-l-green-500">
                        <dt class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Diagnosa / Tindakan
                            Medis</dt>
                        <dd class="text-sm font-medium text-gray-800 whitespace-pre-wrap">
                            {{ $kunjungan->diagnosa ?? 'Belum ada data diagnosa.' }}</dd>
                    </div>
                </dl>

                <!-- Section 3: Pembayaran -->
                <h3 class="text-lg font-bold text-gray-900 mb-4 border-b border-gray-200 pb-2">Status Pembayaran</h3>
                <div
                    class="bg-gray-50 p-5 rounded-lg border border-gray-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                    @if (!$kunjungan->pembayaran)
                        <div>
                            <p class="text-sm text-gray-600">Tagihan untuk kunjungan ini belum diterbitkan atau belum
                                dibayar.</p>
                        </div>
                        <a href="{{ route('admin.pembayaran.create', $kunjungan->id) }}"
                            class="inline-flex items-center px-4 py-2 bg-black text-white font-semibold rounded-lg hover:bg-gray-800 transition shadow-sm text-sm whitespace-nowrap">
                            + Buat Tagihan Pembayaran
                        </a>
                    @else
                        <div>
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Total Tagihan</p>
                            <p class="text-2xl font-bold text-gray-900">Rp
                                {{ number_format($kunjungan->pembayaran->total_bayar, 0, ',', '.') }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Status</p>
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold uppercase tracking-wider 
                            {{ $kunjungan->pembayaran->status == 'lunas' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $kunjungan->pembayaran->status == 'lunas' ? 'Lunas' : 'Belum Lunas' }}
                            </span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Footer / Form Update Status (Sticky di bawah Card) -->
            <div class="bg-gray-100 px-6 py-5 border-t border-gray-200">
                <form action="{{ route('admin.kunjungan.updateStatus', $kunjungan->id) }}" method="POST"
                    class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    @csrf
                    <!-- Jika routenya menggunakan method PATCH/PUT, pastikan ditambahkan @method('PATCH') di sini -->

                    <div class="flex-1">
                        <label class="block text-sm font-bold text-gray-700 mb-1">Perbarui Status Kunjungan</label>
                        <p class="text-xs text-gray-500">Ubah status ini sesuai dengan progres pasien di klinik.</p>
                    </div>

                    <div class="flex items-center gap-3 w-full sm:w-auto">
                        <select name="status"
                            class="w-full sm:w-auto rounded-lg border-gray-300 border p-2.5 text-sm font-medium focus:border-green-500 focus:ring-1 focus:ring-green-500 outline-none bg-white">
                            <option value="menunggu" {{ $kunjungan->status == 'menunggu' ? 'selected' : '' }}>Menunggu
                            </option>
                            <option value="diproses" {{ $kunjungan->status == 'diproses' ? 'selected' : '' }}>Diproses
                                (Perawat)</option>
                            <option value="selesai_diperiksa"
                                {{ $kunjungan->status == 'selesai_diperiksa' ? 'selected' : '' }}>Selesai Diperiksa
                            </option>
                            <option value="menunggu_pembayaran"
                                {{ $kunjungan->status == 'menunggu_pembayaran' ? 'selected' : '' }}>Menunggu Pembayaran
                            </option>
                            <option value="selesai" {{ $kunjungan->status == 'selesai' ? 'selected' : '' }}>Selesai & Lunas
                            </option>
                        </select>
                        <button type="submit"
                            class="px-5 py-2.5 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition-colors shadow-sm text-sm">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
@endsection
