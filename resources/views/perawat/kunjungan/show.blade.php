@extends('layouts.app')

@section('title', 'Periksa Pasien')

@section('content')
<div class="container mx-auto p-6">

    <h2 class="text-2xl font-bold mb-4">Pemeriksaan Pasien</h2>

    {{-- Alert --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- Data Pasien --}}
    <div class="bg-white rounded shadow p-6 mb-6">
        <h3 class="text-lg font-semibold mb-2">Data Pasien</h3>

        <p><strong>Nama:</strong> {{ $kunjungan->pasien->pengguna->name ?? '-' }}</p>
        <p><strong>Tanggal:</strong> {{ $kunjungan->tanggal_kunjungan }}</p>
        <p><strong>Keluhan:</strong> {{ $kunjungan->keluhan ?? '-' }}</p>
        <p><strong>Status:</strong> 
            <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-sm">
                {{ $kunjungan->status }}
            </span>
        </p>
    </div>

    {{-- Form Rekam Medis --}}
    <div class="bg-white rounded shadow p-6 max-w-xl">
        <form action="{{ route('perawat.rekam', $kunjungan) }}" method="POST">
            @csrf

            {{-- Diagnosa --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Diagnosa</label>
                <textarea name="diagnosa" required
                    class="w-full border rounded p-2">{{ old('diagnosa', $kunjungan->diagnosa) }}</textarea>

                @error('diagnosa')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tindakan --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Tindakan</label>
                <textarea name="tindakan" required
                    class="w-full border rounded p-2">{{ old('tindakan', $kunjungan->tindakan) }}</textarea>

                @error('tindakan')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tombol --}}
            <div class="flex justify-between">
                <a href="{{ route('perawat.kunjungan') }}" class="text-gray-600">
                    Kembali
                </a>

                <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                    Simpan Rekam Medis
                </button>
            </div>
        </form>
    </div>

</div>
@endsection