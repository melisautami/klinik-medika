@extends('layouts.app')

@section('title', 'Buat Pembayaran')

@section('content')
    <div class="container mx-auto p-6">
        <h2 class="text-2xl font-bold mb-4">Buat Pembayaran untuk Kunjungan</h2>

        <div class="bg-white rounded shadow p-6 max-w-2xl">
            <p><strong>Pasien:</strong> {{ $kunjungan->pasien->pengguna->name ?? '-' }}</p>
            <p><strong>Tanggal:</strong> {{ $kunjungan->tanggal_kunjungan }}</p>

            <form action="{{ route('admin.pembayaran.store', $kunjungan->id) }}" method="POST">
                @csrf

                <div class="mt-4">
                    <label class="block text-sm font-medium">Pilih Rincian Tarif</label>
                    @foreach ($tarifs as $t)
                        <div class="flex items-center mt-2">
                            <input type="checkbox" name="tarif_ids[]" value="{{ $t->id }}"
                                id="tarif_{{ $t->id }}" class="mr-2">
                            <label for="tarif_{{ $t->id }}">{{ $t->nama_tindakan }} — Rp
                                {{ number_format($t->harga, 0, ',', '.') }}</label>
                        </div>
                    @endforeach
                    @error('tarif_ids')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-6 flex justify-between items-center">
                    <a href="{{ route('admin.kunjungan.show', $kunjungan->id) }}" class="text-gray-600">Batal</a>
                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Buat Pembayaran</button>
                </div>
            </form>
        </div>
    </div>
@endsection
