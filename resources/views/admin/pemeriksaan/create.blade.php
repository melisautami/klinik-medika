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

                    <!-- Pilih Pasien -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Pilih Pasien <span
                                class="text-red-500">*</span></label>

                        <div class="mb-3">
                            <input type="text" id="search_pasien_input" placeholder="Cari nama pasien..."
                                class="w-full rounded-lg border-gray-300 border p-3 text-sm focus:border-green-500 focus:ring-1 focus:ring-green-500 outline-none transition-shadow bg-gray-50 focus:bg-white" />
                        </div>

                        @php
                            $selectedId = old('pasien_id', request('pasien_id'));
                        @endphp

                        <select name="pasien_id" id="pasien_id_input" required
                            class="w-full rounded-lg border-gray-300 border p-3 text-sm focus:border-green-500 focus:ring-1 focus:ring-green-500 outline-none transition-shadow bg-gray-50 focus:bg-white cursor-pointer">
                            <option value="">-- Pilih pasien --</option>
                            @foreach ($pasiens as $p)
                                <option value="{{ $p->id }}"
                                    data-nama="{{ strtolower($p->pengguna->name ?? 'pasien #' . $p->id) }}"
                                    {{ (string) $selectedId === (string) $p->id ? 'selected' : '' }}>
                                    {{ $p->pengguna->name ?? 'Pasien #' . $p->id }}
                                </option>
                            @endforeach
                        </select>

                        <p class="text-xs text-gray-500 mt-1">Cukup ketik nama pasien untuk memfilter daftar. Jika datang
                            dari halaman detail pasien, pilihan akan otomatis terisi.</p>

                        @error('pasien_id')
                            <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
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

                        <div class="mb-3">
                            <input type="text" id="search_perawat_input" placeholder="Cari nama perawat..."
                                class="w-full rounded-lg border-gray-300 border p-3 text-sm focus:border-green-500 focus:ring-1 focus:ring-green-500 outline-none transition-shadow bg-gray-50 focus:bg-white" />
                        </div>

                        <select name="perawat_id" id="perawat_id_input"
                            class="w-full rounded-lg border-gray-300 border p-3 text-sm focus:border-green-500 focus:ring-1 focus:ring-green-500 outline-none transition-shadow bg-gray-50 focus:bg-white cursor-pointer">
                            <option value="" {{ !old('perawat_id') ? 'selected' : '' }}>-- Tidak ada / Ditentukan
                                nanti --</option>
                            @foreach ($perawats as $u)
                                <option value="{{ $u->id }}" data-nama="{{ strtolower($u->name) }}"
                                    {{ old('perawat_id') == $u->id ? 'selected' : '' }}>
                                    {{ $u->name }}
                                </option>
                            @endforeach
                        </select>
                        <p class="text-xs text-gray-500 mt-1">Cukup ketik nama perawat untuk memfilter daftar. Kosongkan
                            jika ingin membiarkan sistem memasukkan pasien ke antrean umum.</p>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const patientSearch = document.getElementById('search_pasien_input');
            const patientSelect = document.getElementById('pasien_id_input');
            const perawatSearch = document.getElementById('search_perawat_input');
            const perawatSelect = document.getElementById('perawat_id_input');

            const attachFilter = (searchInput, select) => {
                if (!searchInput || !select) return;

                searchInput.addEventListener('input', function() {
                    const keyword = this.value.trim().toLowerCase();
                    const options = Array.from(select.options);
                    let firstVisible = null;

                    options.forEach((option) => {
                        if (!option.value) {
                            option.hidden = false;
                            return;
                        }

                        const nama = (option.dataset.nama || option.textContent || '')
                            .toLowerCase();
                        const match = !keyword || nama.includes(keyword);
                        option.hidden = !match;

                        if (match && !firstVisible) {
                            firstVisible = option;
                        }
                    });

                    if (firstVisible) {
                        select.value = firstVisible.value;
                    }
                });
            };

            attachFilter(patientSearch, patientSelect);
            attachFilter(perawatSearch, perawatSelect);
        });
    </script>
@endsection
