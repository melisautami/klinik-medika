@extends('layouts.app')

@section('title', 'Manajemen Perawat')

@section('content')
    <div class="container mx-auto p-6">

        <!-- Header & Tombol Tambah -->
        <div class="w-full lg:w-[80%] mx-auto flex justify-between items-center mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Daftar Perawat</h2>
                <p class="text-sm text-gray-500 mt-1">Kelola data tenaga medis yang bertugas di klinik.</p>
            </div>
            <a href="{{ route('admin.perawat.create') }}"
                class="bg-green-600 hover:bg-green-700 text-white font-semibold px-4 py-2.5 rounded-lg transition duration-200 shadow-sm flex items-center gap-2 text-sm">
                <span>+</span> Tambah Perawat
            </a>
        </div>

        <!-- Alert Success (Untuk Notifikasi Tambah/Edit/Hapus) -->
        @if (session('success'))
            <div
                class="w-full lg:w-[80%] mx-auto bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg mb-6 shadow-sm flex items-center">
                <svg class="h-5 w-5 mr-3 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd"></path>
                </svg>
                <span class="text-green-800 font-medium text-sm">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Tabel Data -->
        <div class="w-full lg:w-[80%] mx-auto bg-white rounded-xl shadow-lg border-t-4 border-green-500 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse whitespace-nowrap">
                    <thead>
                        <tr class="bg-green-600 text-white">
                            <th class="py-4 px-6 font-semibold text-sm uppercase tracking-wider">#</th>
                            <th class="py-4 px-6 font-semibold text-sm uppercase tracking-wider">Nama Lengkap</th>
                            <th class="py-4 px-6 font-semibold text-sm uppercase tracking-wider">Alamat Email</th>
                            <th class="py-4 px-6 font-semibold text-sm uppercase tracking-wider text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700 bg-white">
                        @forelse ($perawats as $p)
                            <!-- Efek hover: latar belakang abu-abu muda -->
                            <tr class="border-b border-gray-200 hover:bg-gray-50 transition duration-150 ease-in-out group">

                                <!-- Penomoran otomatis menyesuaikan halaman pagination -->
                                <td class="py-4 px-6 text-sm">
                                    {{ $loop->iteration + ($perawats->currentPage() - 1) * $perawats->perPage() }}
                                </td>

                                <!-- Nama akan menjadi hijau saat baris di-hover -->
                                <td class="py-4 px-6 font-medium group-hover:text-green-600 transition-colors">
                                    {{ $p->name ?? '-' }}
                                </td>

                                <td class="py-4 px-6 text-sm">
                                    {{ $p->email ?? '-' }}
                                </td>

                                <td class="py-4 px-6">
                                    <div class="flex items-center justify-center space-x-3">
                                        <!-- Tombol Edit -->
                                        <a href="{{ route('admin.perawat.edit', $p->id) }}"
                                            class="text-blue-600 font-semibold hover:text-blue-800 hover:underline text-sm transition-colors">
                                            Edit
                                        </a>

                                        <span class="text-gray-300">|</span>

                                        <!-- Tombol Hapus -->
                                        <form action="{{ route('admin.perawat.destroy', $p->id) }}" method="POST"
                                            class="inline"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus data perawat ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-red-600 font-semibold hover:text-red-800 hover:underline text-sm transition-colors cursor-pointer">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <!-- Tampilan jika perawat tidak ditemukan -->
                            <tr>
                                <td colspan="4" class="py-8 px-6 text-center text-gray-500 font-medium">
                                    Belum ada data perawat yang terdaftar di sistem.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Container pagination dengan padding -->
            @if ($perawats->hasPages())
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                    {{ $perawats->links() }}
                </div>
            @endif
        </div>

    </div>
@endsection
