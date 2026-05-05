@extends('layouts.app')

@section('title', 'Edit Perawat')

@section('content')
    <div class="container mx-auto p-6">
        <h2 class="text-2xl font-bold mb-4">Edit Perawat</h2>

        @if (session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded shadow p-6 max-w-xl">
            <form action="{{ route('admin.perawat.update', $perawat) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Nama -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Nama</label>
                    <input type="text" name="name"
                        value="{{ old('name', $perawat->name) }}" required
                        class="w-full border rounded p-2" />
                    @error('name')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email"
                        value="{{ old('email', $perawat->email) }}" required
                        class="w-full border rounded p-2" />
                    @error('email')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password (Opsional) -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">
                        Password (Kosongkan jika tidak diubah)
                    </label>
                    <input type="password" name="password"
                        class="w-full border rounded p-2" />
                    @error('password')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Konfirmasi Password -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">
                        Konfirmasi Password
                    </label>
                    <input type="password" name="password_confirmation"
                        class="w-full border rounded p-2" />
                </div>

                <!-- Aksi -->
                <div class="flex items-center justify-between">
                    <a href="{{ route('admin.perawat.index') }}" class="text-gray-600">
                        Batal
                    </a>

                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection