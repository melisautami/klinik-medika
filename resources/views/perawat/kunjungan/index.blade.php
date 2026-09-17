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
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span class="text-sm font-medium">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Alert Error -->
        @if (session('error'))
            <div
                class="mb-5 flex items-center gap-3 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-red-700 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
                <span class="text-sm font-medium">{{ session('error') }}</span>
            </div>
        @endif

        <div class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div class="inline-flex rounded-xl border border-gray-200 bg-white p-1 shadow-sm">
                <a href="{{ route('perawat.kunjungan', ['tab' => 'rawat_jalan', 'search' => $search]) }}"
                    class="rounded-lg px-4 py-2 text-sm font-semibold transition {{ $tab === 'rawat_jalan' ? 'bg-green-600 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-100' }}">
                    Rawat Jalan
                </a>
                <a href="{{ route('perawat.kunjungan', ['tab' => 'rawat_inap', 'search' => $search]) }}"
                    class="rounded-lg px-4 py-2 text-sm font-semibold transition {{ $tab === 'rawat_inap' ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-100' }}">
                    Rawat Inap
                </a>
            </div>

            <form method="GET" action="{{ route('perawat.kunjungan') }}" class="flex w-full max-w-md items-center gap-2">
                <input type="hidden" name="tab" value="{{ $tab }}">
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama atau NIK pasien..."
                    class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-2.5 text-sm text-gray-800 outline-none transition focus:border-green-500 focus:bg-white focus:ring-2 focus:ring-green-200" />
                <button type="submit"
                    class="rounded-lg bg-gray-900 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-gray-700">
                    Cari
                </button>
            </form>
        </div>

        <div
            class="bg-white rounded-xl shadow-lg overflow-hidden border-t-4 {{ $tab === 'rawat_jalan' ? 'border-green-500' : 'border-blue-500' }}">
            <div class="{{ $tab === 'rawat_jalan' ? 'bg-green-50' : 'bg-blue-50' }} px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-bold {{ $tab === 'rawat_jalan' ? 'text-green-800' : 'text-blue-800' }}">
                    {{ $tab === 'rawat_jalan' ? 'Antrean Rawat Jalan' : 'Antrean Rawat Inap' }}
                </h3>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse whitespace-nowrap">
                    <thead>
                        <tr class="{{ $tab === 'rawat_jalan' ? 'bg-green-600' : 'bg-blue-600' }} text-white">
                            <th class="py-4 px-6 font-semibold text-sm uppercase tracking-wider">#</th>
                            <th class="py-4 px-6 font-semibold text-sm uppercase tracking-wider">Nama Pasien</th>
                            <th class="py-4 px-6 font-semibold text-sm uppercase tracking-wider">NIK</th>
                            <th class="py-4 px-6 font-semibold text-sm uppercase tracking-wider">Tanggal</th>
                            <th class="py-4 px-6 font-semibold text-sm uppercase tracking-wider">Status</th>
                            <th class="py-4 px-6 font-semibold text-sm uppercase tracking-wider">Perawat</th>
                            <th class="py-4 px-6 font-semibold text-sm uppercase tracking-wider text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white text-gray-700">
                        @forelse ($kunjungans as $k)
                            <tr class="border-b border-gray-200 hover:bg-gray-50 transition duration-150 ease-in-out group">
                                <td class="py-4 px-6 text-sm">{{ $loop->iteration }}</td>
                                <td
                                    class="py-4 px-6 font-medium {{ $tab === 'rawat_jalan' ? 'group-hover:text-green-600' : 'group-hover:text-blue-600' }} transition-colors">
                                    {{ $k->pasien->pengguna->name ?? '-' }}
                                </td>
                                <td class="py-4 px-6 text-sm">{{ $k->pasien->nik ?? '-' }}</td>
                                <td class="py-4 px-6 text-sm">{{ $k->created_at->format('d M Y') }}</td>
                                <td class="py-4 px-6">
                                    @if ($k->status == 'menunggu')
                                        <span
                                            class="inline-flex items-center rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold text-yellow-800 ring-1 ring-yellow-200">Menunggu</span>
                                    @elseif($k->status == 'diproses')
                                        <span
                                            class="inline-flex items-center rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-800 ring-1 ring-blue-200">Diproses</span>
                                    @else
                                        <span
                                            class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-800 ring-1 ring-green-200">Selesai</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-sm">{{ $k->perawat->name ?? 'Belum Ditentukan' }}</td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center justify-center gap-3">
                                        @if ($k->status == 'menunggu')
                                            <form action="{{ route('perawat.ambil', $k) }}" method="POST">
                                                @csrf
                                                <button type="submit"
                                                    class="bg-green-600 hover:bg-green-700 text-white text-sm font-semibold px-4 py-2 rounded-lg shadow-sm transition-colors">Ambil</button>
                                            </form>
                                        @endif

                                        @if ($k->status == 'diproses' && $k->perawat_id == auth()->id())
                                            <a href="{{ route('perawat.show', $k) }}"
                                                class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2 rounded-lg shadow-sm transition-colors">Periksa</a>
                                        @endif

                                        @if ($k->status == 'diproses' && $k->perawat_id != auth()->id())
                                            <span class="text-xs italic text-gray-400 font-medium">Diproses perawat
                                                lain</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-10 px-6 text-center text-gray-500 font-medium">
                                    {{ $search ? 'Tidak ada hasil pencarian untuk kata kunci tersebut.' : 'Tidak ada antrean ' . ($tab === 'rawat_jalan' ? 'rawat jalan' : 'rawat inap') . ' saat ini.' }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($kunjungans->hasPages())
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                    {{ $kunjungans->appends(['tab' => $tab, 'search' => $search])->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
