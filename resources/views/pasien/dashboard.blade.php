@extends('layouts.app')

@section('title', 'Dashboard Pasien')
@section('header_title', 'Dashboard Pasien')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Welcome -->
        <div class="mb-8 rounded-2xl bg-gradient-to-r from-green-600 to-emerald-600 p-8 text-white shadow-lg">

            <h2 class="text-3xl font-bold">
                Selamat Datang,
                {{ auth()->user()->name }} 👋
            </h2>

            <p class="mt-2 text-sm text-green-100">
                Pantau riwayat pemeriksaan dan status layanan klinik Anda.
            </p>
        </div>

        <!-- Statistik -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

            <!-- Total Kunjungan -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">

                <div class="flex items-center justify-between">

                    <div>
                        <p class="text-sm text-gray-500">
                            Total Kunjungan
                        </p>

                        <h3 class="text-3xl font-bold text-gray-900 mt-2">
                            {{ $totalKunjungan }}
                        </h3>
                    </div>

                    <div class="h-14 w-14 rounded-xl bg-blue-100 flex items-center justify-center text-blue-600">

                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">

                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10m-11 9h12a2 2 0 002-2V7a2 2 0 00-2-2H6a2 2 0 00-2 2v11a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Pemeriksaan Selesai -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">

                <div class="flex items-center justify-between">

                    <div>
                        <p class="text-sm text-gray-500">
                            Pemeriksaan Selesai
                        </p>

                        <h3 class="text-3xl font-bold text-gray-900 mt-2">
                            {{ $selesai }}
                        </h3>
                    </div>

                    <div class="h-14 w-14 rounded-xl bg-green-100 flex items-center justify-center text-green-600">

                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">

                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Menunggu Pembayaran -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">

                <div class="flex items-center justify-between">

                    <div>
                        <p class="text-sm text-gray-500">
                            Menunggu Pembayaran
                        </p>

                        <h3 class="text-3xl font-bold text-gray-900 mt-2">
                            {{ $menungguPembayaran }}
                        </h3>
                    </div>

                    <div class="h-14 w-14 rounded-xl bg-yellow-100 flex items-center justify-center text-yellow-600">

                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">

                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3 3 1.343 3 3-1.343 3-3 3m0-12V3m0 18v-3" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Riwayat Pemeriksaan -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border-t-4 border-green-500">

            <!-- Header -->
            <div class="px-6 py-5 border-b border-gray-100 bg-gray-50">

                <h3 class="text-lg font-bold text-gray-900">
                    Riwayat Pemeriksaan
                </h3>

                <p class="text-sm text-gray-500 mt-1">
                    Daftar pemeriksaan pasien terbaru.
                </p>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">

                <table class="w-full text-left border-collapse whitespace-nowrap">

                    <thead>
                        <tr class="bg-green-600 text-white">

                            <th class="py-4 px-6 text-sm font-semibold uppercase tracking-wider">
                                #
                            </th>

                            <th class="py-4 px-6 text-sm font-semibold uppercase tracking-wider">
                                Tanggal
                            </th>

                            <th class="py-4 px-6 text-sm font-semibold uppercase tracking-wider">
                                Perawat
                            </th>

                            <th class="py-4 px-6 text-sm font-semibold uppercase tracking-wider">
                                Diagnosa
                            </th>

                            <th class="py-4 px-6 text-sm font-semibold uppercase tracking-wider">
                                Status
                            </th>

                            <th class="py-4 px-6 text-sm font-semibold uppercase tracking-wider text-center">
                                Aksi
                            </th>

                        </tr>
                    </thead>

                    <tbody class="bg-white text-gray-700">

                        @forelse ($kunjungans as $k)
                            <tr class="border-b border-gray-200 hover:bg-gray-50 transition duration-150">

                                <td class="py-4 px-6 text-sm">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="py-4 px-6 text-sm">
                                    {{ \Carbon\Carbon::parse($k->tanggal_kunjungan)->format('d M Y') }}
                                </td>

                                <td class="py-4 px-6 text-sm">
                                    {{ $k->perawat->name ?? '-' }}
                                </td>

                                <td class="py-4 px-6 text-sm max-w-xs truncate">
                                    {{ $k->diagnosa ?? '-' }}
                                </td>

                                <!-- Status -->
                                <td class="py-4 px-6">

                                    @if ($k->status == 'diproses')
                                        <span
                                            class="inline-flex items-center rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-800 ring-1 ring-blue-200">

                                            Diproses
                                        </span>
                                    @elseif($k->status == 'selesai_diperiksa')
                                        <span
                                            class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-800 ring-1 ring-green-200">

                                            Selesai Diperiksa
                                        </span>
                                    @elseif($k->status == 'menunggu_pembayaran')
                                        <span
                                            class="inline-flex items-center rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold text-yellow-800 ring-1 ring-yellow-200">

                                            Menunggu Pembayaran
                                        </span>
                                    @elseif($k->status == 'selesai')
                                        <span
                                            class="inline-flex items-center rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-800 ring-1 ring-emerald-200">

                                            Selesai
                                        </span>
                                    @endif

                                </td>

                                <!-- Aksi -->
                                <td class="py-4 px-6 text-center">

                                    <a href="{{ route('pasien.detail', $k->id) }}"
                                        class="inline-flex items-center rounded-lg bg-green-600 px-4 py-2 text-xs font-semibold text-white shadow-sm transition hover:bg-green-700">

                                        Detail
                                    </a>
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="6" class="py-10 px-6 text-center text-gray-500 font-medium">

                                    Belum ada riwayat pemeriksaan.
                                </td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
