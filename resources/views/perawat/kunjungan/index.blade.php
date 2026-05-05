@extends('layouts.app')

@section('title', 'Antrian Pasien')

@section('content')
<div class="container mx-auto p-6">

    <h2 class="text-2xl font-bold mb-4">Antrian Pasien</h2>

    {{-- Alert --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white rounded shadow p-4">
        <table class="w-full table-auto border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2 text-left">#</th>
                    <th class="p-2 text-left">Nama Pasien</th>
                    <th class="p-2 text-left">Tanggal</th>
                    <th class="p-2 text-left">Status</th>
                    <th class="p-2 text-left">Perawat</th>
                    <th class="p-2 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($kunjungans as $k)
                    <tr class="border-t">

                        <td class="p-2">{{ $loop->iteration }}</td>

                        {{-- Nama pasien --}}
                        <td class="p-2">
                            {{ $k->pasien->pengguna->name ?? '-' }}
                        </td>

                        {{-- Tanggal --}}
                        <td class="p-2">
                            {{ $k->created_at->format('d-m-Y') }}
                        </td>

                        {{-- Status --}}
                        <td class="p-2">
                            @if($k->status == 'menunggu')
                                <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-sm">
                                    Menunggu
                                </span>
                            @elseif($k->status == 'diproses')
                                <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-sm">
                                    Diproses
                                </span>
                            @else
                                <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-sm">
                                    Selesai
                                </span>
                            @endif
                        </td>

                        {{-- Perawat --}}
                        <td class="p-2">
                            {{ $k->perawat->name ?? '-' }}
                        </td>

                        {{-- Aksi --}}
                        <td class="p-2 space-x-2">

                            {{-- Ambil --}}
                            @if($k->status == 'menunggu')
                                <form action="{{ route('perawat.ambil', $k) }}" method="POST" class="inline">
                                    @csrf
                                    <button class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm">
                                        Ambil
                                    </button>
                                </form>
                            @endif

                            {{-- Periksa --}}
                            @if($k->status == 'diproses' && $k->perawat_id == auth()->id())
                                <a href="{{ route('perawat.show', $k) }}"
                                   class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm">
                                    Periksa
                                </a>
                            @endif

                            {{-- Disable kalau bukan miliknya --}}
                            @if($k->status == 'diproses' && $k->perawat_id != auth()->id())
                                <span class="text-gray-400 text-sm italic">
                                    Diproses perawat lain
                                </span>
                            @endif

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center p-4 text-gray-500">
                            Tidak ada antrian
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection