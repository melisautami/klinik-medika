@extends('layouts.app')

@section('title', $judul)

@section('content')
    <div class="container mx-auto p-6">
        <div class="w-[80%] mx-auto mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <a href="{{ route('admin.dashboard') }}" class="text-sm font-semibold text-green-600 hover:text-green-800">
                    &larr; Kembali ke Dashboard
                </a>
                <h2 class="mt-2 text-2xl font-bold text-gray-800">{{ $judul }}</h2>
                <p class="mt-1 text-sm text-gray-500">{{ $deskripsi }}</p>
            </div>
        </div>

        <div class="w-[80%] mx-auto mb-4 rounded-xl border border-gray-100 bg-white p-4 shadow-sm">
            <form action="{{ route('admin.pasien.kategori', $kategori) }}" method="GET" class="flex w-full gap-3">
                <div class="relative w-full">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari nama atau NIK pasien..."
                        class="w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 pl-10 text-sm outline-none transition-shadow focus:border-green-500 focus:bg-white focus:ring-1 focus:ring-green-500"
                        autocomplete="off">
                </div>
                <button type="submit"
                    class="rounded-lg bg-black px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition-colors hover:bg-gray-800">
                    Cari
                </button>
                @if (request('search'))
                    <a href="{{ route('admin.pasien.kategori', $kategori) }}"
                        class="rounded-lg border border-gray-300 bg-gray-100 px-5 py-2.5 text-center text-sm font-semibold text-gray-700 transition-colors hover:bg-gray-200">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        <div class="mx-auto w-[80%] overflow-hidden rounded-xl border-t-4 border-green-500 bg-white shadow-lg">
            <table class="w-full border-collapse text-left">
                <thead>
                    <tr class="bg-green-600 text-white">
                        <th class="px-6 py-4 text-sm font-semibold uppercase tracking-wider">#</th>
                        <th class="px-6 py-4 text-sm font-semibold uppercase tracking-wider">Nama</th>
                        <th class="px-6 py-4 text-sm font-semibold uppercase tracking-wider">NIK</th>
                        <th class="px-6 py-4 text-sm font-semibold uppercase tracking-wider">Tanggal Daftar</th>
                        <th class="px-6 py-4 text-center text-sm font-semibold uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white text-gray-700">
                    @forelse ($pasiens as $pasien)
                        <tr class="border-b border-gray-200 transition duration-150 hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm">
                                {{ $loop->iteration + ($pasiens->currentPage() - 1) * $pasiens->perPage() }}
                            </td>
                            <td class="px-6 py-4 font-medium">
                                {{ $pasien->pengguna->name ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-sm">{{ $pasien->nik }}</td>
                            <td class="px-6 py-4 text-sm">
                                {{ $pasien->created_at?->format('d/m/Y') ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('admin.pasien.show', $pasien->id) }}"
                                    class="text-sm font-bold text-green-600 hover:text-green-800 hover:underline">
                                    Lihat Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center font-medium text-gray-500">
                                @if (request('search'))
                                    Pasien dengan nama atau NIK "{{ request('search') }}" tidak ditemukan.
                                @else
                                    Belum ada pasien dalam kategori ini.
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            @if ($pasiens->hasPages())
                <div class="border-t border-gray-200 bg-gray-50 px-6 py-4">
                    {{ $pasiens->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
