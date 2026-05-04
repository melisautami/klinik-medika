@extends('layouts.app')

@section('title', 'Edit Pasien')

@section('content')
    <div class="container mx-auto p-6">
        <h2 class="text-2xl font-bold mb-4">Edit Pasien</h2>

        @if (session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4">{{ session('success') }}</div>
        @endif

        <div class="bg-white rounded shadow p-6 max-w-xl">
            <form action="{{ route('admin.pasien.update', $pasien->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Nama</label>
                    <input type="text" name="name" value="{{ old('name', $pengguna->name ?? '') }}" required
                        class="w-full border rounded p-2" />
                    @error('name')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" value="{{ old('email', $pengguna->email ?? '') }}" required
                        class="w-full border rounded p-2" />
                    @error('email')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">NIK</label>
                    <input type="text" name="nik" value="{{ old('nik', $pasien->nik) }}" required
                        class="w-full border rounded p-2" />
                    @error('nik')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Alamat</label>
                    <input type="text" name="alamat" value="{{ old('alamat', $pasien->alamat) }}" required
                        class="w-full border rounded p-2" />
                    @error('alamat')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">No. HP</label>
                    <input type="text" name="no_hp" value="{{ old('no_hp', $pasien->no_hp) }}" required
                        class="w-full border rounded p-2" />
                    @error('no_hp')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $pasien->tanggal_lahir) }}"
                        required class="w-full border rounded p-2" />
                    @error('tanggal_lahir')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <a href="{{ route('admin.pasien.index') }}" class="text-gray-600">Batal</a>
                    <div>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded mr-2">Simpan</button>
                        <form action="{{ route('admin.pasien.destroy', $pasien->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Hapus pasien ini?')"
                                class="bg-red-600 text-white px-3 py-2 rounded">Hapus</button>
                        </form>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
