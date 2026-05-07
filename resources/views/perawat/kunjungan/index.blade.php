@extends('layouts.app')

@section('title', 'Antrian Pasien')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Header -->
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Antrian Pasien</h2>
            <p class="text-sm text-gray-500 mt-1">
                Kelola antrean pasien dan lakukan pemeriksaan dengan cepat.
            </p>
        </div>

        <!-- Alert Success -->
        @if (session('success'))
            <div
                class="mb-5 flex items-center gap-3 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-green-700 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 13l4 4L19 7" />
                </svg>
                <span class="text-sm font-medium">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Alert Error -->
        @if (session('error'))
            <div
                class="mb-5 flex items-center gap-3 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-red-700 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M6 18L18 6M6 6l12 12" />
                </svg>
                <span class="text-sm font-medium">{{ session('error') }}</span>
            </div>
        @endif

        <!-- Table Container -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border-t-4 border-green-500">

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse whitespace-nowrap">

                    <!-- Table Header -->
                    <thead>
                        <tr class="bg-green-600 text-white">
                            <th class="py-4 px-6 font-semibold text-sm uppercase tracking-wider">#</th>
                            <th class="py-4 px-6 font-semibold text-sm uppercase tracking-wider">Nama Pasien</th>
                            <th class="py-4 px-6 font-semibold text-sm uppercase tracking-wider">Tanggal</th>
                            <th class="py-4 px-6 font-semibold text-sm uppercase tracking-wider">Status</th>
                            <th class="py-4 px-6 font-semibold text-sm uppercase tracking-wider">Perawat</th>
                            <th class="py-4 px-6 font-semibold text-sm uppercase tracking-wider text-center">Aksi</th>
                        </tr>
                    </thead>

                    <!-- Table Body -->
                    <tbody class="bg-white text-gray-700">

                        @forelse ($kunjungans as $k)
                            <tr
                                class="border-b border-gray-200 hover:bg-gray-50 transition duration-150 ease-in-out group">

                                <!-- Nomor -->
                                <td class="py-4 px-6 text-sm">
                                    {{ $loop->iteration }}
                                </td>

                                <!-- Nama Pasien -->
                                <td
                                    class="py-4 px-6 font-medium group-hover:text-green-600 transition-colors">
                                    {{ $k->pasien->pengguna->name ?? '-' }}
                                </td>

                                <!-- Tanggal -->
                                <td class="py-4 px-6 text-sm">
                                    {{ $k->created_at->format('d M Y') }}
                                </td>

                                <!-- Status -->
                                <td class="py-4 px-6">

                                    @if ($k->status == 'menunggu')
                                        <span
                                            class="inline-flex items-center rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold text-yellow-800 ring-1 ring-yellow-200">
                                            Menunggu
                                        </span>
                                    @elseif($k->status == 'diproses')
                                        <span
                                            class="inline-flex items-center rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-800 ring-1 ring-blue-200">
                                            Diproses
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-800 ring-1 ring-green-200">
                                            Selesai
                                        </span>
                                    @endif

                                </td>

                                <!-- Perawat -->
                                <td class="py-4 px-6 text-sm">
                                    {{ $k->perawat->name ?? 'Belum Ditentukan' }}
                                </td>

                                <!-- Aksi -->
                                <td class="py-4 px-6">
                                    <div class="flex items-center justify-center gap-3">

                                        {{-- Tombol Ambil --}}
                                        @if ($k->status == 'menunggu')
                                            <form action="{{ route('perawat.ambil', $k) }}" method="POST">
                                                @csrf
                                                <button type="submit"
                                                    class="bg-green-600 hover:bg-green-700 text-white text-sm font-semibold px-4 py-2 rounded-lg shadow-sm transition-colors">
                                                    Ambil
                                                </button>
                                            </form>
                                        @endif

                                        {{-- Tombol Periksa --}}
                                        @if ($k->status == 'diproses' && $k->perawat_id == auth()->id())
                                            <a href="{{ route('perawat.show', $k) }}"
                                                class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2 rounded-lg shadow-sm transition-colors">
                                                Periksa
                                            </a>
                                        @endif

                                        {{-- Sedang diproses perawat lain --}}
                                        @if ($k->status == 'diproses' && $k->perawat_id != auth()->id())
                                            <span
                                                class="text-xs italic text-gray-400 font-medium">
                                                Diproses perawat lain
                                            </span>
                                        @endif

                                    </div>
                                </td>

                            </tr>

                        @empty
                            <tr>
                                <td colspan="6"
                                    class="py-10 px-6 text-center text-gray-500 font-medium">
                                    Tidak ada antrian pasien saat ini.
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