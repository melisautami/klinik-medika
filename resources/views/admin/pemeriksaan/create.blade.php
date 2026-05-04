@extends('layouts.app')

@section('title', 'Ajukan Pemeriksaan')

@section('content')
    <div class="container mx-auto p-6">
        <h2 class="text-2xl font-bold mb-4">Ajukan Pemeriksaan</h2>

        @if (session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4">{{ session('success') }}</div>
        @endif

        <div class="bg-white rounded shadow p-6 max-w-xl">
            <form action="{{ route('admin.pemeriksaan.ajukan') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Pilih Pasien</label>
                    <select name="pasien_id" required class="w-full border rounded p-2">
                        <option value="">-- Pilih pasien --</option>
                        @foreach ($pasiens as $p)
                            <option value="{{ $p->id }}" {{ old('pasien_id') == $p->id ? 'selected' : '' }}>
                                {{ $p->nama ?? ($p->name ?? 'Pasien #' . $p->id) }}</option>
                        @endforeach
                    </select>
                    @error('pasien_id')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Assign Perawat (opsional)</label>
                    <select name="perawat_id" class="w-full border rounded p-2">
                        <option value="">-- Tidak ada / pilih nanti --</option>
                        @foreach ($perawats as $u)
                            <option value="{{ $u->id }}" {{ old('perawat_id') == $u->id ? 'selected' : '' }}>
                                {{ $u->name }}</option>
                        @endforeach
                    </select>
                    @error('perawat_id')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Tipe Kunjungan</label>
                    <select name="tipe" required class="w-full border rounded p-2">
                        <option value="rawat_jalan" {{ old('tipe') == 'rawat_jalan' ? 'selected' : '' }}>Rawat Jalan
                        </option>
                        <option value="rawat_inap" {{ old('tipe') == 'rawat_inap' ? 'selected' : '' }}>Rawat Inap</option>
                    </select>
                    @error('tipe')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                @if ($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-700 p-3 rounded mb-4">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="flex items-center justify-between">
                    <a href="{{ route('admin.dashboard') }}" class="text-gray-600">Batal</a>
                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Ajukan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
