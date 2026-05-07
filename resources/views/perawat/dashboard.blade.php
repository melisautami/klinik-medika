@extends('layouts.app')

@section('title', 'Dashboard Perawat')
@section('header_title', 'Dashboard Perawat')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Header -->
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-900">
                Dashboard Perawat
            </h2>

            <p class="text-sm text-gray-500 mt-2">
                Pantau aktivitas pasien dan proses pemeriksaan hari ini.
            </p>
        </div>

        <!-- Statistik -->
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">

            <!-- Total Kunjungan -->
            <div
                class="bg-white rounded-2xl shadow-lg border-l-4 border-green-500 p-6 hover:shadow-xl transition duration-200">

                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">
                            Total Kunjungan
                        </p>

                        <h3 class="text-4xl font-bold text-gray-900 mt-2">
                            {{ $totalKunjungan }}
                        </h3>
                    </div>

                    <div class="bg-green-100 p-4 rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-8 w-8 text-green-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">

                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10m-11 9h12a2 2 0 002-2V7a2 2 0 00-2-2H6a2 2 0 00-2 2v11a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Menunggu -->
            <div
                class="bg-white rounded-2xl shadow-lg border-l-4 border-yellow-500 p-6 hover:shadow-xl transition duration-200">

                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">
                            Pasien Menunggu
                        </p>

                        <h3 class="text-4xl font-bold text-gray-900 mt-2">
                            {{ $menunggu }}
                        </h3>
                    </div>

                    <div class="bg-yellow-100 p-4 rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-8 w-8 text-yellow-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">

                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Diproses -->
            <div
                class="bg-white rounded-2xl shadow-lg border-l-4 border-blue-500 p-6 hover:shadow-xl transition duration-200">

                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">
                            Sedang Diproses
                        </p>

                        <h3 class="text-4xl font-bold text-gray-900 mt-2">
                            {{ $diproses }}
                        </h3>
                    </div>

                    <div class="bg-blue-100 p-4 rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-8 w-8 text-blue-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">

                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Selesai -->
            <div
                class="bg-white rounded-2xl shadow-lg border-l-4 border-green-700 p-6 hover:shadow-xl transition duration-200">

                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">
                            Pemeriksaan Selesai
                        </p>

                        <h3 class="text-4xl font-bold text-gray-900 mt-2">
                            {{ $selesai }}
                        </h3>
                    </div>

                    <div class="bg-green-200 p-4 rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-8 w-8 text-green-700" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">

                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                </div>
            </div>

        </div>

        <!-- Menu Cepat -->
        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">

            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

                <div>
                    <h3 class="text-lg font-bold text-gray-900">
                        Menu Cepat
                    </h3>

                    <p class="text-sm text-gray-500 mt-1">
                        Akses cepat ke fitur pemeriksaan pasien.
                    </p>
                </div>

                <div class="flex flex-wrap gap-3">

                    <a href="{{ route('perawat.kunjungan') }}"
                        class="bg-green-600 hover:bg-green-700 text-white px-5 py-3 rounded-xl font-semibold shadow-sm transition duration-200">

                        Lihat Antrian
                    </a>

                    <a href="{{ route('perawat.riwayat') }}"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-xl font-semibold shadow-sm transition duration-200">

                        Riwayat Pemeriksaan
                    </a>

                </div>
            </div>
        </div>

    </div>
@endsection