@extends('layouts.app')

@section('title', 'Ajukan Pemeriksaan')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Header & Tombol Batal -->
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Ajukan Pemeriksaan Baru</h2>
                <p class="text-sm text-gray-500 mt-1">Daftarkan pasien ke antrean perawat untuk dilakukan tindakan medis.</p>
            </div>
            <a href="{{ route('admin.dashboard') }}"
                class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-semibold text-gray-700 hover:bg-gray-50 hover:text-green-600 transition-colors shadow-sm text-sm">
                &larr; Kembali ke Dashboard
            </a>
        </div>

        <!-- Alert Success -->
        @if (session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg mb-6 shadow-sm flex items-center">
                <svg class="h-5 w-5 mr-3 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd"></path>
                </svg>
                <span class="text-green-800 font-medium text-sm">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Alert Validasi Error Global -->
        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg mb-6 shadow-sm flex items-start">
                <svg class="h-5 w-5 mr-3 text-red-500 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                        clip-rule="evenodd"></path>
                </svg>
                <div>
                    <h3 class="text-red-800 font-bold text-sm mb-1">Terdapat kesalahan pengisian form:</h3>
                    <ul class="list-disc list-inside text-red-700 text-sm font-medium">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <!-- Card Form Utama -->
        <div class="bg-white rounded-xl shadow-lg border-t-4 border-green-500 overflow-hidden">

            <form action="{{ route('admin.pemeriksaan.ajukan') }}" method="POST" class="p-6 sm:p-8">
                @csrf

                <div class="grid grid-cols-1 gap-6">

                    <!-- Pilih Pasien (searchable + bisa terisi lewat query param pasien_id) -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Pilih Pasien <span
                                class="text-red-500">*</span></label>

                        @php
                            $selectedId = old('pasien_id', request('pasien_id'));
                            $selectedPasien = $pasiens->firstWhere('id', $selectedId);
                            // PERBAIKAN DI SINI: Menggunakan $selectedPasien->pengguna->name
                            $selectedName = $selectedPasien
                                ? $selectedPasien->pengguna->name ?? 'Pasien #' . $selectedPasien->id
                                : old('pasien_name', '');
                        @endphp

                        <input list="pasiens-list" id="pasiens-search"
                            class="w-full rounded-lg border-gray-300 border p-3 text-sm focus:border-green-500 focus:ring-1 focus:ring-green-500 outline-none transition-shadow bg-gray-50 focus:bg-white cursor-text"
                            placeholder="Ketuk untuk mencari pasien berdasarkan nama" autocomplete="off"
                            value="{{ $selectedName }}" />

                        <datalist id="pasiens-list">
                            @foreach ($pasiens as $p)
                                <!-- PERBAIKAN DI SINI: Menggunakan $p->pengguna->name -->
                                <option value="{{ $p->pengguna->name ?? 'Pasien #' . $p->id }}"
                                    data-id="{{ $p->id }}">
                            @endforeach
                        </datalist>

                        <!-- Hidden input yang dikirim ke server -->
                        <input type="hidden" name="pasien_id" id="pasien_id_input" value="{{ $selectedId }}" />

                        <p class="text-xs text-gray-500 mt-1">Ketik untuk mencari berdasarkan nama. Jika datang dari halaman
                            detail pasien, isian akan terisi otomatis.</p>

                        @error('pasien_id')
                            <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror

                        <script>
                            (function() {
                                // PERBAIKAN DI SINI: Menggunakan $p->pengguna->name di dalam JavaScript map
                                const patients = @json(
                                    $pasiens->map(function ($p) {
                                        return ['id' => $p->id, 'name' => $p->pengguna->name ?? 'Pasien #' . $p->id];
                                    }));

                                const searchInput = document.getElementById('pasiens-search');
                                const hiddenInput = document.getElementById('pasien_id_input');

                                function setHiddenByName(name) {
                                    const found = patients.find(p => p.name === name);
                                    if (found) hiddenInput.value = found.id;
                                }

                                // Jika ada pasien_id di query/old, setkan nama di input
                                const existingId = hiddenInput.value;
                                if (existingId) {
                                    const found = patients.find(p => String(p.id) === String(existingId));
                                    if (found) searchInput.value = found.name;
                                }

                                // Ketika user memilih/menulis dan fokus keluar, sinkronkan ke hidden input jika ada kecocokan nama
                                searchInput.addEventListener('change', function(e) {
                                    setHiddenByName(this.value);
                                });

                                // Juga pada blur (untuk kasus datalist selection via click)
                                searchInput.addEventListener('blur', function(e) {
                                    setHiddenByName(this.value);
                                });
                            })();
                        </script>
                    </div>

                    <!-- Tipe Kunjungan -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Tipe Kunjungan <span
                                class="text-red-500">*</span></label>
                        <select name="tipe" required
                            class="w-full rounded-lg border-gray-300 border p-3 text-sm focus:border-green-500 focus:ring-1 focus:ring-green-500 outline-none transition-shadow bg-gray-50 focus:bg-white cursor-pointer">
                            <option value="rawat_jalan" {{ old('tipe') == 'rawat_jalan' ? 'selected' : '' }}>Rawat Jalan
                            </option>
                            <option value="rawat_inap" {{ old('tipe') == 'rawat_inap' ? 'selected' : '' }}>Rawat Inap
                            </option>
                        </select>
                        @error('tipe')
                            <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Assign Perawat -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Serahkan ke Perawat (Opsional)</label>
                        <select name="perawat_id"
                            class="w-full rounded-lg border-gray-300 border p-3 text-sm focus:border-green-500 focus:ring-1 focus:ring-green-500 outline-none transition-shadow bg-gray-50 focus:bg-white cursor-pointer">
                            <option value="" {{ !old('perawat_id') ? 'selected' : '' }}>-- Tidak ada / Ditentukan
                                nanti --</option>
                            @foreach ($perawats as $u)
                                <option value="{{ $u->id }}" {{ old('perawat_id') == $u->id ? 'selected' : '' }}>
                                    {{ $u->name }}
                                </option>
                            @endforeach
                        </select>
                        <p class="text-xs text-gray-500 mt-1">Kosongkan jika ingin membiarkan sistem memasukkan pasien ke
                            antrean umum.</p>
                        @error('perawat_id')
                            <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                <div class="sm:col-span-1">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Keluhan Awal (Opsional)</label>
                    <textarea name="keluhan" rows="3" placeholder="Contoh: Pusing, demam, atau batuk..."
                        class="w-full rounded-lg border-gray-300 border p-3 text-sm focus:border-green-500 focus:ring-1 focus:ring-green-500 outline-none transition-shadow bg-gray-50 focus:bg-white">{{ old('keluhan') }}</textarea>
                    <p class="text-xs text-gray-500 mt-1">Keluhan singkat ini akan dibaca oleh perawat.</p>
                    @error('keluhan')
                        <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Area Tombol Aksi -->
                <div class="mt-8 pt-5 border-t border-gray-200 flex items-center justify-end gap-3">
                    <a href="{{ route('admin.dashboard') }}"
                        class="px-5 py-2.5 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100 font-medium transition text-sm text-center">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-6 py-2.5 bg-green-600 text-white rounded-lg hover:bg-green-700 font-bold shadow-sm transition text-sm text-center">
                        Simpan & Ajukan Pemeriksaan
                    </button>
                </div>

            </form>
        </div>
    </div>
@endsection
