@extends('layouts.app')

@section('title', 'Tambah Tarif Baru')

@section('content')
    <div class="max-w-2xl mx-auto px-4 py-8">
        <div class="mb-6 flex items-center justify-between">
            <h2 class="text-2xl font-bold text-gray-900">Tambah Tarif Baru</h2>
            <a href="{{ route('admin.tarif.index') }}" class="text-sm font-bold text-gray-500 hover:text-green-600">&larr;
                Kembali</a>
        </div>

        <div class="bg-white rounded-xl shadow-lg border-t-4 border-green-500 p-6 sm:p-8">
            <form action="{{ route('admin.tarif.store') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Nama Tindakan / Layanan</label>
                    <input type="text" name="nama_tindakan" required
                        placeholder="Contoh: Cek Gula Darah, Konsultasi Umum"
                        class="w-full rounded-lg border-gray-300 border p-3 text-sm focus:border-green-500 outline-none bg-gray-50">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Harga (Rupiah)</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500 font-bold">Rp</span>
                        <input type="number" name="harga" required placeholder="0"
                            class="w-full rounded-lg border-gray-300 border p-3 pl-10 text-sm focus:border-green-500 outline-none bg-gray-50">
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit"
                        class="w-full bg-black text-white font-bold py-3 rounded-xl hover:bg-gray-800 transition shadow-md">
                        SIMPAN TARIF
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
