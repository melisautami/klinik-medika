@extends('layouts.app')

@section('title', 'Manajemen Perawat')

@section('content')
    <div class="container mx-auto p-6">
        <h2 class="text-2xl font-bold mb-4">Daftar Perawat</h2>

        <!-- Tombol Tambah -->
        <a href="{{ route('admin.perawat.create') }}"
           class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded mb-4 inline-block">
            + Tambah Perawat
        </a>

        <div class="bg-white rounded shadow p-4">
            <table class="w-full table-auto border">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="text-left p-2">#</th>
                        <th class="text-left p-2">Nama</th>
                        <th class="text-left p-2">Email</th>
                        <th class="text-left p-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($perawats as $p)
                        <tr class="border-t">
                            <td class="p-2">{{ $loop->iteration }}</td>

                            <!-- relasi ke pengguna -->
                            <td class="p-2">
                                {{ $p->name ?? '-' }}
                            </td>

                            <td class="p-2">
                                {{ $p->email ?? '-' }}
                            </td>

                            <td class="p-2 space-x-2">
                                <a href="{{ route('admin.perawat.edit', $p->id) }}"
                                   class="text-yellow-600 hover:underline">Edit</a>

                                <form action="{{ route('admin.perawat.destroy', $p->id) }}"
                                      method="POST"
                                      class="inline"
                                      onsubmit="return confirm('Yakin hapus data?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 hover:underline">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center p-4 text-gray-500">
                                Data perawat belum ada
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $perawats->links() }}
            </div>
        </div>
    </div>
@endsection