@extends('layouts.app')

@section('title', 'Tambah Pasien')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Pendaftaran Pasien Baru</h2>
                <p class="text-sm text-gray-500 mt-1">Masukkan data diri pasien beserta informasi kontak untuk keperluan
                    rekam medis.</p>
            </div>
            <a href="{{ route('admin.pasien.index') }}"
                class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-semibold text-gray-700 hover:bg-gray-50 hover:text-green-600 transition-colors shadow-sm text-sm whitespace-nowrap">
                &larr; Kembali
            </a>
        </div>

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

        <div class="bg-white rounded-xl shadow-lg border-t-4 border-green-500 overflow-hidden">

            <form action="{{ route('admin.pasien.store') }}" method="POST" class="p-6 sm:p-8">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                            placeholder="Contoh: Budi Santoso"
                            class="w-full rounded-lg border-gray-300 border p-3 text-sm focus:border-green-500 focus:ring-1 focus:ring-green-500 outline-none transition-shadow bg-gray-50 focus:bg-white" />
                        @error('name')
                            <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Alamat Email <span
                                class="text-red-500">*</span></label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                            placeholder="email@contoh.com"
                            class="w-full rounded-lg border-gray-300 border p-3 text-sm focus:border-green-500 focus:ring-1 focus:ring-green-500 outline-none transition-shadow bg-gray-50 focus:bg-white" />
                        @error('email')
                            <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nomor Induk Kependudukan (NIK) <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="nik" value="{{ old('nik') }}" required
                            placeholder="16 Digit Angka NIK" maxlength="16"
                            class="w-full rounded-lg border-gray-300 border p-3 text-sm focus:border-green-500 focus:ring-1 focus:ring-green-500 outline-none transition-shadow bg-gray-50 focus:bg-white" />
                        @error('nik')
                            <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Tanggal Lahir <span
                                class="text-red-500">*</span></label>
                        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required
                            class="w-full rounded-lg border-gray-300 border p-3 text-sm focus:border-green-500 focus:ring-1 focus:ring-green-500 outline-none transition-shadow bg-gray-50 focus:bg-white" />
                        @error('tanggal_lahir')
                            <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nomor Handphone / WA <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="no_hp" value="{{ old('no_hp') }}" required
                            placeholder="Contoh: 08123456789"
                            class="w-full rounded-lg border-gray-300 border p-3 text-sm focus:border-green-500 focus:ring-1 focus:ring-green-500 outline-none transition-shadow bg-gray-50 focus:bg-white" />
                        @error('no_hp')
                            <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Alamat Tempat Tinggal <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="alamat" value="{{ old('alamat') }}" required
                            placeholder="Contoh: Jl. Merdeka No. 10, RT 01/RW 02, Jakarta"
                            class="w-full rounded-lg border-gray-300 border p-3 text-sm focus:border-green-500 focus:ring-1 focus:ring-green-500 outline-none transition-shadow bg-gray-50 focus:bg-white" />
                        @error('alamat')
                            <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                <div class="mt-8 pt-5 border-t border-gray-200 flex flex-col sm:flex-row items-center justify-end gap-3">
                    <a href="{{ route('admin.pasien.index') }}"
                        class="w-full sm:w-auto px-5 py-2.5 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100 font-medium transition text-sm text-center">
                        Batal
                    </a>
                    <button type="submit"
                        class="w-full sm:w-auto px-6 py-2.5 bg-green-600 text-white rounded-lg hover:bg-green-700 font-bold shadow-sm transition text-sm text-center">
                        Simpan Data Pasien
                    </button>
                </div>

            </form>

        </div>
    </div>
@endsection
