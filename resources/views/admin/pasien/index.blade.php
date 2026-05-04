@extends('layouts.app')

@section('title', 'Manajemen Pasien')

@section('content')
    <div class="container mx-auto p-6">
        <h2 class="text-2xl font-bold mb-4">Daftar Pasien</h2>
        <a href="{{ route('admin.pasien.create') }}" class="bg-green-600 text-white px-4 py-2 rounded mb-4 inline-block">Tambah Pasien</a>
        <div class="bg-white rounded shadow p-4">
            <table class="w-full table-auto">
                <thead>
                    <tr>
                        <th class="text-left">#</th>
                        <th class="text-left">Nama</th>
                        <th class="text-left">Tanggal Lahir</th>
                        <th class="text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pasiens as $p)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $p->pengguna->name ?? ($p->pengguna->name ?? '—') }}</td>
                            <td>{{ $p->tanggal_lahir ?? '-' }}</td>
                            <td><a href="{{ route('admin.pasien.show', $p->id) }}" class="text-blue-600">Lihat</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4">{{ $pasiens->links() }}</div>
        </div>
    </div>
@endsection
