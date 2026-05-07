@extends('layouts.app')

@section('title', 'Detail Pemeriksaan')
@section('header_title', 'Detail Pemeriksaan')

@section('content')
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Header -->
        <div class="mb-8">

            <h2 class="text-3xl font-bold text-gray-900">
                Detail Pemeriksaan Pasien
            </h2>

            <p class="text-sm text-gray-500 mt-2">
                Informasi lengkap data diri, pemeriksaan, dan biaya pengobatan.
            </p>
        </div>

        <!-- Main Card -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border-t-4 border-green-500">

            <!-- Header -->
            <div class="px-6 py-5 border-b border-gray-100 bg-gray-50">

                <h3 class="text-lg font-bold text-gray-900">
                    Informasi Pemeriksaan
                </h3>

            </div>

            <!-- Content -->
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Nama -->
                <div>

                    <p class="text-sm text-gray-500 mb-1">
                        Nama Pasien
                    </p>

                    <h4 class="font-semibold text-gray-900">
                        {{ $kunjungan->pasien->pengguna->name ?? '-' }}
                    </h4>

                </div>

                <!-- NIK -->
                <div>

                    <p class="text-sm text-gray-500 mb-1">
                        NIK
                    </p>

                    <h4 class="font-semibold text-gray-900">
                        {{ $kunjungan->pasien->nik ?? '-' }}
                    </h4>

                </div>

                <!-- Perawat -->
                <div>

                    <p class="text-sm text-gray-500 mb-1">
                        Perawat Pemeriksa
                    </p>

                    <h4 class="font-semibold text-gray-900">
                        {{ $kunjungan->perawat->name ?? '-' }}
                    </h4>

                </div>

                <!-- Tanggal -->
                <div>

                    <p class="text-sm text-gray-500 mb-1">
                        Tanggal Pemeriksaan
                    </p>

                    <h4 class="font-semibold text-gray-900">
                        {{ \Carbon\Carbon::parse($kunjungan->tanggal_kunjungan)->format('d M Y') }}
                    </h4>

                </div>

                <!-- Status -->
                <div>

                    <p class="text-sm text-gray-500 mb-1">
                        Status Pemeriksaan
                    </p>

                    @if ($kunjungan->status == 'diproses')

                        <span
                            class="inline-flex items-center rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-800 ring-1 ring-blue-200">

                            Diproses
                        </span>

                    @elseif($kunjungan->status == 'selesai_diperiksa')

                        <span
                            class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-800 ring-1 ring-green-200">

                            Selesai Diperiksa
                        </span>

                    @elseif($kunjungan->status == 'menunggu_pembayaran')

                        <span
                            class="inline-flex items-center rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold text-yellow-800 ring-1 ring-yellow-200">

                            Menunggu Pembayaran
                        </span>

                    @elseif($kunjungan->status == 'selesai')

                        <span
                            class="inline-flex items-center rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-800 ring-1 ring-emerald-200">

                            Selesai
                        </span>

                    @endif

                </div>

                <!-- Harga -->
                <div>

                    <p class="text-sm text-gray-500 mb-1">
                        Total Biaya Pengobatan
                    </p>

                    <div
                        class="inline-flex items-center rounded-xl bg-emerald-50 border border-emerald-200 px-4 py-3">

                        <span class="text-xl font-bold text-emerald-700">

                            Rp
                            {{ number_format($kunjungan->pembayaran->total_bayar ?? 0, 0, ',', '.') }}

                        </span>

                    </div>

                </div>

                <!-- Keluhan -->
                <div class="md:col-span-2">

                    <p class="text-sm text-gray-500 mb-1">
                        Keluhan Pasien
                    </p>

                    <div
                        class="rounded-xl border border-gray-200 bg-gray-50 p-4 text-sm text-gray-700 leading-relaxed">

                        {{ $kunjungan->keluhan ?? '-' }}

                    </div>

                </div>

                <!-- Diagnosa -->
                <div class="md:col-span-2">

                    <p class="text-sm text-gray-500 mb-1">
                        Diagnosa
                    </p>

                    <div
                        class="rounded-xl border border-gray-200 bg-gray-50 p-4 text-sm text-gray-700 leading-relaxed">

                        {{ $kunjungan->diagnosa ?? '-' }}

                    </div>

                </div>

                <!-- Tindakan -->
                <div class="md:col-span-2">

                    <p class="text-sm text-gray-500 mb-1">
                        Tindakan / Perawatan
                    </p>

                    <div
                        class="rounded-xl border border-gray-200 bg-gray-50 p-4 text-sm text-gray-700 leading-relaxed">

                        {{ $kunjungan->tindakan ?? '-' }}

                    </div>

                </div>

            </div>

            <!-- Footer -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">

                <a href="{{ route('pasien.dashboard') }}"
                    class="inline-flex items-center rounded-xl bg-gray-700 px-5 py-3 text-sm font-semibold text-white transition hover:bg-gray-800">

                    Kembali ke Dashboard
                </a>

            </div>

        </div>

    </div>
@endsection