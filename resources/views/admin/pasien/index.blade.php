@extends('layouts.app')

@section('title', 'Manajemen Pasien')

@section('content')
    <div class="container mx-auto p-6">

        <!-- Header -->
        <div class="w-[80%] mx-auto flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Daftar Pasien</h2>
            <a href="{{ route('admin.pasien.create') }}"
                class="bg-green-600 hover:bg-green-700 text-white font-semibold px-4 py-2 rounded-lg transition duration-200 shadow-sm flex items-center gap-2 text-sm">
                <span>+</span> Tambah Pasien
            </a>
        </div>

        <!-- Form Filter Pencarian -->
        <div
            class="w-[80%] mx-auto mb-4 bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
            <form action="{{ route('admin.pasien.index') }}" method="GET" class="flex w-full md:w-2/3 lg:w-1/2 gap-3">
                <div class="relative w-full">
                    <!-- Icon Search (Opsional agar lebih manis) -->
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari berdasarkan nama pasien..."
                        class="w-full pl-10 rounded-lg border-gray-300 border p-2.5 text-sm focus:border-green-500 focus:ring-1 focus:ring-green-500 outline-none transition-shadow bg-gray-50 focus:bg-white"
                        autocomplete="off">
                </div>

                <button type="submit"
                    class="bg-black text-white px-5 py-2.5 rounded-lg text-sm font-semibold hover:bg-gray-800 transition-colors shadow-sm">
                    Cari
                </button>

                <!-- Tombol Reset hanya muncul jika ada query pencarian -->
                @if (request('search'))
                    <a href="{{ route('admin.pasien.index') }}"
                        class="bg-gray-100 border border-gray-300 text-gray-700 px-5 py-2.5 rounded-lg text-sm font-semibold hover:bg-gray-200 transition-colors text-center">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        <!-- Tabel Data -->
        <div class="mx-auto bg-white w-[80%] rounded-xl shadow-lg border-t-4 border-green-500 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-green-600 text-white">
                        <th class="py-4 px-6 font-semibold text-sm uppercase tracking-wider">#</th>
                        <th class="py-4 px-6 font-semibold text-sm uppercase tracking-wider">Nama</th>
                        <th class="py-4 px-6 font-semibold text-sm uppercase tracking-wider">Tanggal Lahir</th>
                        <th class="py-4 px-6 font-semibold text-sm uppercase tracking-wider text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 bg-white">
                    @forelse ($pasiens as $p)
                        <!-- Efek hover: latar belakang abu-abu muda -->
                        <tr class="border-b border-gray-200 hover:bg-gray-50 transition duration-150 ease-in-out group">
                            <!-- Penomoran otomatis menyesuaikan halaman pagination -->
                            <td class="py-4 px-6 text-sm">
                                {{ $loop->iteration + ($pasiens->currentPage() - 1) * $pasiens->perPage() }}
                            </td>

                            <!-- Nama akan menjadi hijau saat baris di-hover -->
                            <td class="py-4 px-6 font-medium group-hover:text-green-600 transition-colors">
                                {{ $p->pengguna->name ?? '—' }}
                            </td>

                            <td class="py-4 px-6 text-sm">
                                {{ optional($p->tanggal_lahir)->format('d/m/Y') ?? '-' }}
                            </td>
                            <td class="py-4 px-6 text-center">
                                <a href="{{ route('admin.pasien.show', $p->id) }}"
                                    class="text-green-600 font-bold hover:text-green-800 hover:underline text-sm">
                                    Lihat Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <!-- Tampilan jika pasien tidak ditemukan -->
                        <tr>
                            <td colspan="4" class="py-8 px-6 text-center text-gray-500 font-medium">
                                @if (request('search'))
                                    Pasien dengan nama "<span
                                        class="font-bold text-gray-800">{{ request('search') }}</span>" tidak ditemukan.
                                @else
                                    Belum ada data pasien yang terdaftar.
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Container pagination dengan padding -->
            @if ($pasiens->hasPages())
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                    {{ $pasiens->appends(['search' => request('search')])->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
