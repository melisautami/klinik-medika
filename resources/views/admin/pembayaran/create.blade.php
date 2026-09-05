@extends('layouts.app')

@section('title', 'Buat Tagihan Pembayaran')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Buat Tagihan Pembayaran</h2>
                <p class="text-sm text-gray-500 mt-1">Periksa rincian tindakan medis yang sudah dipilih perawat.</p>
            </div>
            <a href="{{ route('admin.kunjungan.show', $kunjungan->id) }}"
                class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-semibold text-gray-700 hover:bg-gray-50 hover:text-green-600 transition-colors shadow-sm text-sm whitespace-nowrap">
                &larr; Kembali
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-lg border-t-4 border-green-500 overflow-hidden">

            <div class="bg-gray-50 p-6 border-b border-gray-100 grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Nama Pasien</p>
                    <p class="text-lg font-black text-gray-900">{{ $kunjungan->pasien->pengguna->name ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Tanggal Pemeriksaan</p>
                    <p class="text-lg font-black text-gray-900">
                        {{ \Carbon\Carbon::parse($kunjungan->tanggal_kunjungan)->format('d M Y') }}</p>
                </div>
            </div>

           <div class="p-6 border-b border-gray-100 bg-white">
    <h3 class="text-sm font-bold text-gray-900 mb-3 border-b border-gray-100 pb-2">Catatan Pemeriksaan Perawat</h3>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-gray-50 border border-gray-200 rounded-xl p-4">
            <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Keluhan</p>
            <p class="text-sm text-gray-800 whitespace-pre-wrap">{{ $kunjungan->keluhan ?? 'Tidak ada catatan keluhan.' }}</p>
        </div>

        <div class="bg-gray-50 border border-gray-200 rounded-xl p-4">
            <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Diagnosa</p>
            <p class="text-sm text-gray-800 whitespace-pre-wrap">{{ $kunjungan->diagnosa ?? 'Tidak ada catatan diagnosa.' }}</p>
        </div>

        <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
            <p class="text-xs font-bold text-blue-800 uppercase tracking-wider mb-2">Tindakan / Terapi</p>
            <p class="text-sm font-semibold text-blue-900 whitespace-pre-wrap">{{ $kunjungan->tindakan ?? 'Tidak ada catatan tindakan.' }}</p>
        </div>
    </div>
</div>

            <form action="{{ route('admin.pembayaran.store', $kunjungan->id) }}" method="POST" class="p-6 bg-gray-50">
                @csrf

                <h3 class="text-lg font-bold text-gray-900 mb-4">Rincian Tindakan Perawat</h3>

                @error('tindakan')
                    <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm font-semibold">
                        ⚠️ {{ $message }}
                    </div>
                @enderror

                <div class="space-y-3 mb-8">
                    @forelse ($tarifs as $t)
                        <div
                            class="flex flex-col sm:flex-row sm:items-center sm:justify-between text-left p-4 bg-white border border-gray-200 rounded-xl shadow-sm gap-2 sm:gap-3">
                            <div class="min-w-0">
                                <span class="font-bold text-gray-800 block text-left whitespace-normal">
                                    {{ preg_replace('/^\s+/', '', trim((string) ($t->nama_tindakan ?? ($t['nama_tindakan'] ?? '')))) }}
                                </span>
                            </div>

                            <span class="font-black text-gray-900 whitespace-nowrap text-left sm:text-right">
                                Rp {{ number_format((int) ($t->harga ?? ($t['harga'] ?? 0)), 0, ',', '.') }}
                            </span>
                        </div>
                    @empty
                        <div class="p-6 text-center border-2 border-dashed border-gray-300 rounded-xl bg-white">
                            <p class="text-gray-500 font-medium">Belum ada tindakan dan harga yang dicatat perawat.</p>
                        </div>
                    @endforelse
                </div>

                <div class="mb-6 space-y-3">
                    <label class="block text-sm font-bold text-gray-700">Metode Pembayaran</label>
                    <select name="metode_pembayaran"
                        class="w-full rounded-lg border-gray-300 border p-3 text-sm focus:border-green-500 focus:ring-1 focus:ring-green-500 outline-none bg-white">
                        <option value="qris" selected>QRIS</option>
                        <option value="manual">Manual / Tunai</option>
                    </select>
                </div>

                <div class="pt-5 border-t border-gray-200 flex flex-col sm:flex-row items-center justify-between gap-6">

                    <div
                        class="w-full sm:w-auto bg-green-100 border border-green-300 px-5 py-3 rounded-xl flex items-center justify-between gap-4 shadow-sm">
                        <span class="text-sm font-bold text-green-800">Estimasi Total:</span>
                        <span class="text-xl font-black text-green-700">Rp
                            {{ number_format($kunjungan->getTindakanTotal(), 0, ',', '.') }}</span>
                    </div>

                    <div class="flex w-full sm:w-auto gap-3">
                        <a href="{{ route('admin.kunjungan.show', $kunjungan->id) }}"
                            class="flex-1 sm:flex-none text-center bg-white border border-gray-300 text-gray-700 px-6 py-3 rounded-xl font-semibold hover:bg-gray-50 transition text-sm shadow-sm">
                            Batal
                        </a>
                        <button type="submit"
                            class="flex-1 sm:flex-none text-center bg-black hover:bg-gray-800 text-white px-8 py-3 rounded-xl font-bold shadow-sm transition text-sm">
                            Terbitkan Tagihan
                        </button>
                    </div>

                </div>
            </form>

        </div>
    </div>

@endsection
