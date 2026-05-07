@extends('layouts.app')

@section('title', 'Riwayat Pemeriksaan')
@section('header_title', 'Riwayat Pemeriksaan')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Header -->
        <div class="mb-6">
            <h2 class="text-3xl font-bold text-gray-900">
                Riwayat Pemeriksaan
            </h2>

            <p class="text-sm text-gray-500 mt-2">
                Daftar pasien yang telah diperiksa oleh Anda.
            </p>
        </div>

        <!-- Alert -->
        @if (session('success'))
            <div class="mb-5 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-green-700 shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <!-- Filter -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-5 mb-6">

            <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">

                <!-- Search -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                        Cari Pasien
                    </label>

                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Masukkan nama pasien..."
                        class="w-full rounded-xl border-gray-300 border p-3 text-sm focus:border-green-500 focus:ring-1 focus:ring-green-500 outline-none bg-gray-50 focus:bg-white transition-colors">
                </div>

                <!-- From -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                        Dari Tanggal
                    </label>

                    <input type="date" name="from" value="{{ request('from') }}"
                        class="w-full rounded-xl border-gray-300 border p-3 text-sm focus:border-green-500 focus:ring-1 focus:ring-green-500 outline-none bg-gray-50 focus:bg-white transition-colors">
                </div>

                <!-- To -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                        Sampai Tanggal
                    </label>

                    <input type="date" name="to" value="{{ request('to') }}"
                        class="w-full rounded-xl border-gray-300 border p-3 text-sm focus:border-green-500 focus:ring-1 focus:ring-green-500 outline-none bg-gray-50 focus:bg-white transition-colors">
                </div>

                <!-- Buttons -->
                <div class="md:col-span-3 flex gap-3">

                    <button type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white px-5 py-3 rounded-xl font-semibold shadow-sm transition duration-200">

                        Terapkan Filter
                    </button>

                    <a href="{{ route('perawat.riwayat') }}"
                        class="bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 px-5 py-3 rounded-xl font-semibold transition duration-200">

                        Reset
                    </a>
                </div>

            </form>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border-t-4 border-green-500">

            <div class="overflow-x-auto">

                <table class="w-full text-left border-collapse whitespace-nowrap">

                    <!-- Head -->
                    <thead>
                        <tr class="bg-green-600 text-white">

                            <th class="py-4 px-6 font-semibold text-sm uppercase tracking-wider">
                                #
                            </th>

                            <th class="py-4 px-6 font-semibold text-sm uppercase tracking-wider">
                                Nama Pasien
                            </th>

                            <th class="py-4 px-6 font-semibold text-sm uppercase tracking-wider">
                                Perawat
                            </th>

                            <th class="py-4 px-6 font-semibold text-sm uppercase tracking-wider">
                                Tanggal
                            </th>

                            <th class="py-4 px-6 font-semibold text-sm uppercase tracking-wider">
                                Diagnosa
                            </th>

                            <th class="py-4 px-6 font-semibold text-sm uppercase tracking-wider">
                                Tindakan
                            </th>

                            <th class="py-4 px-6 font-semibold text-sm uppercase tracking-wider">
                                Status
                            </th>

                            <th class="py-4 px-6 font-semibold text-sm uppercase tracking-wider text-center">
                                Aksi
                            </th>

                        </tr>
                    </thead>

                    <!-- Body -->
                    <tbody class="bg-white text-gray-700">

                        @forelse ($kunjungans as $k)
                            <tr class="border-b border-gray-200 hover:bg-gray-50 transition duration-150 ease-in-out group">

                                <!-- Number -->
                                <td class="py-4 px-6 text-sm">
                                    {{ $loop->iteration + ($kunjungans->currentPage() - 1) * $kunjungans->perPage() }}
                                </td>

                                <!-- Name -->
                                <td class="py-4 px-6 font-medium group-hover:text-green-600 transition-colors">

                                    {{ $k->pasien->pengguna->name ?? '-' }}
                                </td>

                                <!-- Perawat -->
                                <td class="py-4 px-6 text-sm">
                                    {{ $k->perawat->name ?? '-' }}
                                </td>

                                <!-- Date -->
                                <td class="py-4 px-6 text-sm">
                                    {{ $k->created_at->format('d M Y') }}
                                </td>

                                <!-- Diagnosa -->
                                <td class="py-4 px-6 text-sm max-w-xs truncate">
                                    {{ $k->diagnosa ?? '-' }}
                                </td>

                                <!-- Tindakan -->
                                <td class="py-4 px-6 text-sm max-w-xs truncate">
                                    {{ $k->tindakan ?? '-' }}
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
                                    @else
                                        <span
                                            class="inline-flex items-center rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-700 ring-1 ring-gray-200">

                                            {{ ucfirst(str_replace('_', ' ', $k->status)) }}
                                        </span>
                                    @endif

                                </td>

                                <!-- Aksi -->
                                <td class="py-4 px-6 text-center">

                                    @if (in_array($k->status, ['selesai', 'selesai_diperiksa', 'menunggu_pembayaran']))
                                        <a href="{{ route('perawat.detail', $k->id) }}"
                                            class="inline-flex items-center rounded-lg bg-green-600 px-4 py-2 text-xs font-semibold text-white shadow-sm transition hover:bg-green-700">

                                            Lihat Detail
                                        </a>
                                    @else
                                        <span class="text-xs text-gray-400 italic">
                                            Belum tersedia
                                        </span>
                                    @endif

                                </td>

                            </tr>

                        @empty
                            <tr>
                                <td colspan="8" class="py-10 px-6 text-center text-gray-500 font-medium">

                                    Belum ada riwayat pemeriksaan.
                                </td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>
            </div>

            <!-- Pagination -->
            @if ($kunjungans->hasPages())
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                    {{ $kunjungans->links() }}
                </div>
            @endif

        </div>
    </div>
@endsection
