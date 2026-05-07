@extends('layouts.app')

@section('title', 'Detail Pemeriksaan')

@section('content')
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Header -->
        <div class="mb-6">
            <h2 class="text-3xl font-bold text-gray-900">
                Detail Pemeriksaan Pasien
            </h2>

            <p class="text-sm text-gray-500 mt-2">
                Informasi lengkap hasil pemeriksaan pasien.
            </p>
        </div>

        <!-- Card -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border-t-4 border-green-500">

            <!-- Header -->
            <div class="px-6 py-5 border-b border-gray-100 bg-gray-50">
                <h3 class="text-lg font-bold text-gray-900">
                    Data Pemeriksaan
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
                        Status
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

                <!-- Harga Pemeriksaan -->
                @if (in_array($kunjungan->status, ['menunggu_pembayaran', 'selesai']))
                    <div>
                        <p class="text-sm text-gray-500 mb-1">
                            Biaya Pemeriksaan
                        </p>

                        <div class="inline-flex items-center rounded-xl bg-emerald-50 border border-emerald-200 px-4 py-3">

                            <span class="text-lg font-bold text-emerald-700">
                                Rp {{ number_format($kunjungan->pembayaran->total_bayar ?? 0, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                @endif

                <!-- Keluhan -->
                <div class="md:col-span-2">
                    <p class="text-sm text-gray-500 mb-1">
                        Keluhan
                    </p>

                    <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 text-sm text-gray-700">
                        {{ $kunjungan->keluhan ?? '-' }}
                    </div>
                </div>

                <!-- Diagnosa -->
                <div class="md:col-span-2">
                    <p class="text-sm text-gray-500 mb-1">
                        Diagnosa
                    </p>

                    <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 text-sm text-gray-700">
                        {{ $kunjungan->diagnosa ?? '-' }}
                    </div>
                </div>

                <!-- Tindakan -->
                <div class="md:col-span-2">
                    <p class="text-sm text-gray-500 mb-1">
                        Tindakan
                    </p>

                    <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 text-sm text-gray-700">
                        {{ $kunjungan->tindakan ?? '-' }}
                    </div>
                </div>

            </div>

            <!-- Footer -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">

                <a href="{{ route('perawat.riwayat') }}"
                    class="inline-flex items-center rounded-xl bg-gray-700 px-5 py-3 text-sm font-semibold text-white transition hover:bg-gray-800">

                    Kembali ke Riwayat
                </a>

            </div>

        </div>

    </div>
@endsection
