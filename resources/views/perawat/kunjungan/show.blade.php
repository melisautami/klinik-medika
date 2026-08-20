@extends('layouts.app')

@section('title', 'Periksa Pasien')

@section('content')
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Header -->
        <div class="mb-6">
            <h2 class="text-3xl font-bold text-gray-900">
                Pemeriksaan Pasien
            </h2>

            <p class="text-sm text-gray-500 mt-2">
                Lengkapi data rekam medis pasien yang sedang diperiksa.
            </p>
        </div>

        <!-- Alert Success -->
        @if (session('success'))
            <div class="mb-5 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-green-700 shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <!-- Data Pasien -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border-t-4 border-green-500 mb-6">

            <!-- Header Card -->
            <div class="px-6 py-5 border-b border-gray-100 bg-gray-50">
                <h3 class="text-lg font-bold text-gray-900">
                    Data Pasien
                </h3>

                <p class="text-sm text-gray-500 mt-1">
                    Informasi pasien yang sedang diperiksa.
                </p>
            </div>

            <!-- Content -->
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Nama -->
                <div>
                    <p class="text-sm text-gray-500 mb-1">
                        Nama Pasien
                    </p>

                    <h4 class="text-base font-semibold text-gray-900">
                        {{ $kunjungan->pasien->pengguna->name ?? '-' }}
                    </h4>
                </div>

                <!-- Tanggal -->
                <div>
                    <p class="text-sm text-gray-500 mb-1">
                        Tanggal Kunjungan
                    </p>

                    <h4 class="text-base font-semibold text-gray-900">
                        {{ \Carbon\Carbon::parse($kunjungan->tanggal_kunjungan)->format('d M Y') }}
                    </h4>
                </div>

                <!-- Keluhan -->
                <div class="md:col-span-2">
                    <p class="text-sm text-gray-500 mb-1">
                        Keluhan Pasien
                    </p>

                    <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 text-sm text-gray-700">
                        {{ $kunjungan->keluhan ?? '-' }}
                    </div>
                </div>

                <!-- Status -->
                <div>
                    <p class="text-sm text-gray-500 mb-1">
                        Status Pemeriksaan
                    </p>

                    @if ($kunjungan->status == 'diproses')
                        <span
                            class="inline-flex items-center rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-800 ring-1 ring-blue-200">

                            Diproses
                        </span>
                    @elseif($kunjungan->status == 'selesai_diperiksa')
                        <span
                            class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-800 ring-1 ring-green-200">

                            Selesai Diperiksa
                        </span>
                    @else
                        <span
                            class="inline-flex items-center rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-700 ring-1 ring-gray-200">

                            {{ ucfirst(str_replace('_', ' ', $kunjungan->status)) }}
                        </span>
                    @endif
                </div>

            </div>
        </div>

        <!-- Form Rekam Medis -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border-t-4 border-green-500">

            <!-- Header -->
            <div class="px-6 py-5 border-b border-gray-100 bg-gray-50">

                <h3 class="text-lg font-bold text-gray-900">
                    Form Rekam Medis
                </h3>

                <p class="text-sm text-gray-500 mt-1">
                    Isi hasil pemeriksaan pasien dengan lengkap.
                </p>
            </div>

            <!-- Form -->
            <form action="{{ route('perawat.rekam', $kunjungan) }}" method="POST" class="p-6">
                @csrf

                @php
                    $tarifs = \App\Models\Tarif::orderBy('nama_tindakan')->get();
                @endphp

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-3">
                        Pilih Tindakan dari Katalog Tarif <span class="text-red-500">*</span>
                    </label>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 rounded-xl border border-gray-200 bg-gray-50 p-4">
                        @forelse ($tarifs as $tarif)
                            <label
                                class="flex items-center gap-2 rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm text-gray-700 hover:border-green-400 transition">
                                <input type="checkbox" name="tarif_ids[]" value="{{ $tarif->id }}"
                                    class="h-4 w-4 rounded border-gray-300 text-green-600 focus:ring-green-500"
                                    {{ in_array($tarif->id, old('tarif_ids', [])) ? 'checked' : '' }}>
                                <span class="font-medium">{{ $tarif->nama_tindakan }}</span>
                                <span class="ml-auto text-xs text-gray-500">Rp
                                    {{ number_format($tarif->harga, 0, ',', '.') }}</span>
                            </label>
                        @empty
                            <p class="text-sm text-gray-500 italic md:col-span-2">Belum ada katalog tarif yang tersedia.</p>
                        @endforelse
                    </div>
                </div>

                <div class="mb-6">
                    <div class="flex justify-between items-end mb-2">
                        <label class="block text-sm font-semibold text-gray-700">
                            Keluhan Pasien (Anamnesa) <span class="text-red-500">*</span>
                        </label>
                        <span class="text-xs text-gray-500 italic">Data awal dari Petugas Pendaftaran</span>
                    </div>

                    <textarea name="keluhan" rows="4" required
                        class="w-full rounded-xl border-gray-300 border p-4 text-sm focus:border-green-500 focus:ring-1 focus:ring-green-500 outline-none bg-yellow-50 focus:bg-white transition-colors"
                        placeholder="Catat keluhan pasien secara detail...">{{ old('keluhan', $kunjungan->keluhan) }}</textarea>

                    @error('keluhan')
                        <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Diagnosa Medis <span class="text-red-500">*</span>
                    </label>

                    <textarea name="diagnosa" rows="4" required
                        class="w-full rounded-xl border-gray-300 border p-4 text-sm focus:border-green-500 focus:ring-1 focus:ring-green-500 outline-none bg-gray-50 focus:bg-white transition-colors"
                        placeholder="Tuliskan hasil diagnosa...">{{ old('diagnosa', $kunjungan->diagnosa) }}</textarea>

                    @error('diagnosa')
                        <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-8">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Catatan Tindakan / Terapi <span class="text-red-500">*</span>
                    </label>

                    <textarea name="tindakan" rows="4"
                        class="w-full rounded-xl border-gray-300 border p-4 text-sm focus:border-green-500 focus:ring-1 focus:ring-green-500 outline-none bg-gray-50 focus:bg-white transition-colors"
                        placeholder="Tuliskan tindakan medis atau resep obat yang diberikan...">{{ old('tindakan', $kunjungan->tindakan) }}</textarea>

                    <p class="text-xs text-gray-500 mt-2">Jika memilih dari katalog tarif, data tersebut akan ikut tertulis
                        di catatan tindakan.</p>

                    @error('tindakan')
                        <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-col sm:flex-row items-center justify-end gap-3 pt-4 border-t border-gray-200">
                    <a href="{{ route('perawat.kunjungan') }}"
                        class="w-full sm:w-auto text-center bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 px-6 py-2.5 rounded-lg font-bold transition duration-200 text-sm">
                        Batal
                    </a>

                    <button type="submit"
                        class="w-full sm:w-auto bg-green-600 hover:bg-green-700 text-white px-8 py-2.5 rounded-lg font-bold shadow-sm transition duration-200 text-sm">
                        Simpan Rekam Medis & Selesai
                    </button>
                </div>

            </form>
        </div>

    </div>
@endsection
