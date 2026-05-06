@extends('layouts.app')

@section('title', 'Edit Perawat')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Header & Tombol Kembali -->
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Edit Data Perawat</h2>
                <p class="text-sm text-gray-500 mt-1">Perbarui informasi profil dan kredensial akses tenaga medis.</p>
            </div>
            <a href="{{ route('admin.perawat.index') }}"
                class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-semibold text-gray-700 hover:bg-gray-50 hover:text-green-600 transition-colors shadow-sm text-sm">
                &larr; Kembali
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

        <!-- Card Form -->
        <div class="bg-white rounded-xl shadow-lg border-t-4 border-green-500 overflow-hidden">

            <form action="{{ route('admin.perawat.update', $perawat) }}" method="POST" class="p-6 sm:p-8">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

                    <!-- Nama (Full Width di layar kecil, Half Width di layar besar) -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $perawat->name) }}" required
                            class="w-full rounded-lg border-gray-300 border p-3 text-sm focus:border-green-500 focus:ring-1 focus:ring-green-500 outline-none transition-shadow bg-gray-50 focus:bg-white" />
                        @error('name')
                            <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Alamat Email <span
                                class="text-red-500">*</span></label>
                        <input type="email" name="email" value="{{ old('email', $perawat->email) }}" required
                            class="w-full rounded-lg border-gray-300 border p-3 text-sm focus:border-green-500 focus:ring-1 focus:ring-green-500 outline-none transition-shadow bg-gray-50 focus:bg-white" />
                        @error('email')
                            <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Pemisah Visual untuk area Password -->
                    <div class="sm:col-span-2 pt-4 mt-2 border-t border-gray-100">
                        <h3 class="text-sm font-bold text-gray-900 mb-1">Ubah Kata Sandi</h3>
                        <p class="text-xs text-gray-500 mb-4">Kosongkan kedua kolom di bawah ini jika Anda tidak ingin
                            mengubah kata sandi saat ini.</p>
                    </div>

                    <!-- Password (Opsional) -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Kata Sandi Baru</label>
                        <input type="password" name="password" placeholder="••••••••"
                            class="w-full rounded-lg border-gray-300 border p-3 text-sm focus:border-green-500 focus:ring-1 focus:ring-green-500 outline-none transition-shadow bg-gray-50 focus:bg-white" />
                        @error('password')
                            <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Konfirmasi Password -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Konfirmasi Kata Sandi Baru</label>
                        <input type="password" name="password_confirmation" placeholder="••••••••"
                            class="w-full rounded-lg border-gray-300 border p-3 text-sm focus:border-green-500 focus:ring-1 focus:ring-green-500 outline-none transition-shadow bg-gray-50 focus:bg-white" />
                    </div>

                </div>

                <!-- Footer / Area Tombol Aksi -->
                <div class="mt-8 pt-5 border-t border-gray-200 flex flex-col sm:flex-row items-center justify-end gap-3">
                    <a href="{{ route('admin.perawat.index') }}"
                        class="w-full sm:w-auto px-5 py-2.5 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100 font-medium transition text-sm text-center">
                        Batal
                    </a>
                    <button type="submit"
                        class="w-full sm:w-auto px-6 py-2.5 bg-green-600 text-white rounded-lg hover:bg-green-700 font-bold shadow-sm transition text-sm text-center">
                        Simpan Perubahan
                    </button>
                </div>

            </form>

        </div>
    </div>
@endsection
