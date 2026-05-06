@extends('layouts.app')

@section('title', 'Detail Pasien')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Header & Tombol Kembali -->
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Detail Informasi Pasien</h2>

            <!-- Pastikan route 'admin.pasien.index' sesuai dengan nama route di web.php kamu -->
            <a href="{{ route('admin.pasien.index') }}"
                class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-semibold text-gray-700 hover:bg-gray-50 hover:text-green-600 transition-colors shadow-sm text-sm">
                &larr; Kembali
            </a>
        </div>

        <!-- Card Utama -->
        <div class="bg-white rounded-xl shadow-lg border-t-4 border-green-500 overflow-hidden">

            <!-- Bagian Profil Singkat -->
            <div class="p-6 sm:p-8">
                <div class="flex items-center mb-8 pb-6 border-b border-gray-200">
                    <!-- Icon Avatar Dummy -->
                    <div class="h-16 w-16 bg-green-100 rounded-full flex items-center justify-center text-green-600 mr-5">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900">
                            {{ $pasien->pengguna->name ?? ($pasien->pengguna->name ?? 'Nama Tidak Tersedia') }}
                        </h3>
                        <p class="text-sm text-gray-500 mt-1">Pasien Terdaftar</p>
                    </div>
                </div>

                <!-- Grid Detail Data -->
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-6">
                    <!-- Block Nama -->
                    <div class="bg-gray-50 px-5 py-4 rounded-lg border border-gray-100">
                        <dt class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Nama Lengkap</dt>
                        <dd class="text-base font-medium text-gray-900">
                            {{ $pasien->pengguna->name ?? ($pasien->pengguna->name ?? 'Nama Tidak Tersedia') }}</dd>
                    </div>

                    <div class="bg-gray-50 px-5 py-4 rounded-lg border border-gray-100">
                        <dt class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">NIK</dt>
                        <dd class="text-base font-medium text-gray-900">{{ $pasien->nik ?? '-' }}</dd>
                    </div>

                    <div class="bg-gray-50 px-5 py-4 rounded-lg border border-gray-100">
                        <dt class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Nomor Handphone</dt>
                        <dd class="text-base font-medium text-gray-900">{{ $pasien->no_hp ?? '-' }}</dd>
                    </div>

                    <!-- Block Tanggal Lahir -->
                    <div class="bg-gray-50 px-5 py-4 rounded-lg border border-gray-100">
                        <dt class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Tanggal Lahir</dt>
                        <dd class="text-base font-medium text-gray-900">
                            <!-- Format diubah menjadi d/m/Y agar lebih rapi, contoh: 27/04/2026 -->
                            {{ $pasien->tanggal_lahir ?? '-' }}
                        </dd>
                    </div>

                    <!-- Block Alamat (Mengambil 2 kolom penuh di layar besar) -->
                    <div class="bg-gray-50 px-5 py-4 rounded-lg border border-gray-100 sm:col-span-2">
                        <dt class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Alamat Domisili</dt>
                        <dd class="text-base font-medium text-gray-900">{{ $pasien->alamat ?? '-' }}</dd>
                    </div>
                </dl>
            </div>

            <!-- Footer / Tombol Aksi (Opsional, sesuai kebutuhan dokumenmu) -->
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex justify-end gap-3">
                <a href="{{ route('admin.pasien.edit', $pasien->id) }}"
                    class="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100 font-medium transition text-sm">
                    Edit Data Pasien
                </a>
                <!-- Perhatikan bagian array ['pasien_id' => $pasien->id] di dalam fungsi route() -->
                <a href="{{ route('admin.pemeriksaan.create', ['pasien_id' => $pasien->id]) }}"
                    class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 font-medium shadow-sm transition text-sm">
                    + Ajukan Pemeriksaan
                </a>
            </div>

        </div>
    </div>
@endsection
