@extends('layouts.app')

@section('title', 'Katalog Tarif & Tindakan')

@section('content')
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Katalog Tarif Klinik</h2>
                <p class="text-sm text-gray-500 mt-1">Daftar harga tindakan medis dan layanan laboratorium.</p>
            </div>
            <a href="{{ route('admin.tarif.create') }}"
                class="bg-green-600 hover:bg-green-700 text-white font-bold px-4 py-2.5 rounded-lg transition shadow-sm text-sm">
                + Tambah Tarif
            </a>
        </div>

        @if (session('success'))
            <div class="mb-4 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg text-sm text-green-800 font-medium">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-lg border-t-4 border-green-500 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-600 border-b border-gray-200">
                        <th class="py-4 px-6 font-bold text-xs uppercase">No</th>
                        <th class="py-4 px-6 font-bold text-xs uppercase">Nama Tindakan / Layanan</th>
                        <th class="py-4 px-6 font-bold text-xs uppercase text-right">Harga (IDR)</th>
                        <th class="py-4 px-6 font-bold text-xs uppercase text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @forelse ($tarifs as $t)
                        <tr class="border-b border-gray-100 hover:bg-green-50 transition-colors">
                            <td class="py-4 px-6 text-sm">{{ $loop->iteration }}</td>
                            <td class="py-4 px-6 font-bold text-gray-900">{{ $t->nama_tindakan }}</td>
                            <td class="py-4 px-6 text-right font-black text-green-700">
                                Rp {{ number_format($t->harga, 0, ',', '.') }}
                            </td>
                            <td class="py-4 px-6 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.tarif.edit', $t->id) }}"
                                        class="bg-black text-white px-3 py-1.5 rounded-md text-xs font-bold hover:bg-gray-800 transition">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.tarif.destroy', $t->id) }}" method="POST"
                                        onsubmit="return confirm('Hapus tarif ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-600 text-white px-3 py-1.5 rounded-md text-xs font-bold hover:bg-red-700 transition">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-10 text-center text-gray-400">Belum ada data tarif. Silakan tambah
                                data baru.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
