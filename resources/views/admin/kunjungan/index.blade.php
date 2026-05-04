@extends('layouts.app')

@section('title', 'Daftar Kunjungan')

@section('content')
    <div class="container mx-auto p-6">
        <h2 class="text-2xl font-bold mb-4">Daftar Kunjungan</h2>

        <form method="GET" class="mb-4 flex gap-2 items-end">
            <div>
                <label class="block text-sm">Status</label>
                <select name="status" class="border p-2 rounded">
                    <option value="">Semua</option>
                    <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                    <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                    <option value="selesai_diperiksa" {{ request('status') == 'selesai_diperiksa' ? 'selected' : '' }}>
                        Selesai
                        Diperiksa</option>
                    <option value="menunggu_pembayaran" {{ request('status') == 'menunggu_pembayaran' ? 'selected' : '' }}>
                        Menunggu Pembayaran</option>
                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>

            <div>
                <label class="block text-sm">Dari</label>
                <input type="date" name="from" value="{{ request('from') }}" class="border p-2 rounded" />
            </div>

            <div>
                <label class="block text-sm">Sampai</label>
                <input type="date" name="to" value="{{ request('to') }}" class="border p-2 rounded" />
            </div>

            <div>
                <button type="submit" class="bg-blue-600 text-white px-3 py-2 rounded">Filter</button>
                <a href="{{ route('admin.kunjungan.index') }}"
                    class="ml-2 bg-gray-200 text-gray-800 px-3 py-2 rounded">Reset</a>
            </div>
        </form>

        <div class="bg-white rounded shadow p-4">
            <table class="w-full table-auto">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Pasien</th>
                        <th>Tanggal</th>
                        <th>Perawat</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kunjungans as $k)
                        <tr>
                            <td>{{ $loop->iteration + ($kunjungans->currentPage() - 1) * $kunjungans->perPage() }}</td>
                            <td>{{ $k->pasien->pengguna->name ?? '-' }}</td>
                            <td>{{ $k->tanggal_kunjungan }}</td>
                            <td>{{ $k->perawat->name ?? '-' }}</td>
                            <td>{{ $k->status }}</td>
                            <td>
                                <a href="{{ route('admin.kunjungan.show', $k->id) }}" class="text-blue-600 mr-2">Lihat</a>
                                <form action="{{ route('admin.kunjungan.updateStatus', $k->id) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    <select name="status" class="border p-1 rounded text-sm">
                                        <option value="menunggu">Menunggu</option>
                                        <option value="diproses">Diproses</option>
                                        <option value="selesai_diperiksa">Selesai Diperiksa</option>
                                        <option value="menunggu_pembayaran">Menunggu Pembayaran</option>
                                        <option value="selesai">Selesai</option>
                                    </select>
                                    <button type="submit" class="ml-2 bg-gray-200 px-2 py-1 rounded text-sm">Set</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4">{{ $kunjungans->links() }}</div>
        </div>
    </div>
@endsection
