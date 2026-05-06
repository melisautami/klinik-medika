@extends('layouts.app')

@section('title', 'Daftar Kunjungan')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Header -->
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Daftar Kunjungan Pasien</h2>
            <p class="text-sm text-gray-500 mt-1">Kelola dan pantau status antrean serta pemeriksaan pasien hari ini.</p>
        </div>

        <!-- Form Filter (Grid Layout untuk Responsivitas) -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 mb-6">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-4 lg:grid-cols-5 gap-4 items-end">

                <!-- Filter Status -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Status Kunjungan</label>
                    <select name="status"
                        class="w-full rounded-lg border-gray-300 border p-2.5 text-sm focus:border-green-500 focus:ring-1 focus:ring-green-500 outline-none bg-gray-50 focus:bg-white transition-colors">
                        <option value="">Semua Status</option>
                        <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                        <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses (Perawat)
                        </option>
                        <option value="selesai_diperiksa" {{ request('status') == 'selesai_diperiksa' ? 'selected' : '' }}>
                            Selesai Diperiksa</option>
                        <option value="menunggu_pembayaran"
                            {{ request('status') == 'menunggu_pembayaran' ? 'selected' : '' }}>Menunggu Pembayaran</option>
                        <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai & Lunas
                        </option>
                    </select>
                </div>

                <!-- Filter Dari Tanggal -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Dari Tanggal</label>
                    <input type="date" name="from" value="{{ request('from') }}"
                        class="w-full rounded-lg border-gray-300 border p-2.5 text-sm focus:border-green-500 focus:ring-1 focus:ring-green-500 outline-none bg-gray-50 focus:bg-white transition-colors" />
                </div>

                <!-- Filter Sampai Tanggal -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Sampai Tanggal</label>
                    <input type="date" name="to" value="{{ request('to') }}"
                        class="w-full rounded-lg border-gray-300 border p-2.5 text-sm focus:border-green-500 focus:ring-1 focus:ring-green-500 outline-none bg-gray-50 focus:bg-white transition-colors" />
                </div>

                <!-- Tombol Aksi -->
                <div class="flex gap-2 lg:col-span-2">
                    <button type="submit"
                        class="flex-1 bg-blue-500 text-white font-semibold rounded-lg py-2.5 px-4 shadow-sm hover:bg-blue-600 transition-colors text-sm text-center">
                        Terapkan Filter
                    </button>
                    <a href="{{ route('admin.kunjungan.index') }}"
                        class="flex-1 bg-white border border-gray-300 text-gray-700 font-semibold rounded-lg py-2.5 px-4 hover:bg-gray-50 transition-colors text-sm text-center">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Tabel Data -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border-t-4 border-green-500">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse whitespace-nowrap">
                    <thead>
                        <tr class="bg-green-600 text-white">
                            <th class="py-4 px-6 font-semibold text-sm uppercase tracking-wider">#</th>
                            <th class="py-4 px-6 font-semibold text-sm uppercase tracking-wider">Nama Pasien</th>
                            <th class="py-4 px-6 font-semibold text-sm uppercase tracking-wider">Tanggal</th>
                            <th class="py-4 px-6 font-semibold text-sm uppercase tracking-wider">Perawat Medis</th>
                            <th class="py-4 px-6 font-semibold text-sm uppercase tracking-wider">Status</th>
                            <th class="py-4 px-6 font-semibold text-sm uppercase tracking-wider text-center">Aksi Kendali
                            </th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700 bg-white">
                        @forelse ($kunjungans as $k)
                            <tr class="border-b border-gray-200 hover:bg-gray-50 transition duration-150 ease-in-out group">
                                <td class="py-4 px-6 text-sm">
                                    {{ $loop->iteration + ($kunjungans->currentPage() - 1) * $kunjungans->perPage() }}</td>

                                <td class="py-4 px-6 font-medium group-hover:text-green-600 transition-colors">
                                    {{ $k->pasien->pengguna->name ?? 'Data Terhapus/Kosong' }}
                                </td>

                                <td class="py-4 px-6 text-sm">
                                    {{ \Carbon\Carbon::parse($k->tanggal_kunjungan)->format('d M Y') }}</td>
                                <td class="py-4 px-6 text-sm">{{ $k->perawat->name ?? 'Belum Ditentukan' }}</td>

                                <!-- Kolom Status Berjalan -->
                                <td class="py-4 px-6 text-sm font-semibold uppercase tracking-wider text-gray-600">
                                    {{ str_replace('_', ' ', $k->status) }}
                                </td>

                                <!-- Kolom Aksi -->
                                <td class="py-4 px-6">
                                    <div class="flex items-center justify-center space-x-4">
                                        <a href="{{ route('admin.kunjungan.show', $k->id) }}"
                                            class="text-green-600 font-bold hover:text-green-800 hover:underline text-sm">
                                            Lihat Detail
                                        </a>

                                        <span class="text-gray-300">|</span>

                                        <!-- Form Update Status Singkat -->
                                        <form action="{{ route('admin.kunjungan.updateStatus', $k->id) }}" method="POST"
                                            class="flex items-center space-x-2">
                                            @csrf
                                            @method('PATCH')
                                            <!-- Biasanya update status menggunakan PATCH, sesuaikan dengan route Anda -->
                                            <select name="status" onchange="this.form.submit()"
                                                class="border border-gray-300 rounded text-xs p-1.5 focus:border-green-500 focus:ring-1 focus:ring-green-500 outline-none bg-gray-50 cursor-pointer">
                                                <option value="menunggu" {{ $k->status == 'menunggu' ? 'selected' : '' }}>
                                                    Menunggu</option>
                                                <option value="diproses" {{ $k->status == 'diproses' ? 'selected' : '' }}>
                                                    Diproses</option>
                                                <option value="selesai_diperiksa"
                                                    {{ $k->status == 'selesai_diperiksa' ? 'selected' : '' }}>Selesai
                                                    Diperiksa</option>
                                                <option value="menunggu_pembayaran"
                                                    {{ $k->status == 'menunggu_pembayaran' ? 'selected' : '' }}>Menunggu
                                                    Pembayaran</option>
                                                <option value="selesai" {{ $k->status == 'selesai' ? 'selected' : '' }}>
                                                    Selesai</option>
                                            </select>

                                            <!-- Tombol Set disembunyikan jika ingin menggunakan fitur onchange submit otomatis.
                                                 Jika ingin tombol manual, hapus atribut onchange="this.form.submit()" pada select di atas. -->
                                            <noscript>
                                                <button type="submit"
                                                    class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-2 py-1.5 rounded text-xs font-semibold transition-colors">Set</button>
                                            </noscript>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8 px-6 text-center text-gray-500 font-medium">
                                    Tidak ada data kunjungan yang ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Container pagination dengan padding -->
            @if ($kunjungans->hasPages())
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                    {{ $kunjungans->links() }}
                </div>
            @endif
        </div>

    </div>
@endsection
