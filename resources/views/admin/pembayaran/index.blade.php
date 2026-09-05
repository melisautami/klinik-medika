@extends('layouts.app')

@section('title', 'Konfirmasi Pembayaran & Tarif')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Header -->
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Manajemen Tarif & Konfirmasi Pembayaran</h2>
            <p class="text-sm text-gray-500 mt-1">Konversi tindakan medis menjadi tagihan dan validasi pembayaran pasien.</p>
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

        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg mb-6 shadow-sm">
                <ul class="text-red-800 font-medium text-sm list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form Filter Pencarian -->
        <div
            class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 mb-6 flex flex-col sm:flex-row justify-between items-center gap-4">
            <form action="{{ route('admin.pembayaran.index') }}" method="GET" class="flex w-full sm:w-1/2 gap-3">
                <div class="relative w-full">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama pasien..."
                        class="w-full rounded-lg border-gray-300 border p-2.5 text-sm focus:border-green-500 focus:ring-1 focus:ring-green-500 outline-none bg-gray-50 focus:bg-white transition-colors"
                        autocomplete="off">
                </div>
                <button type="submit"
                    class="bg-black text-white px-5 py-2.5 rounded-lg text-sm font-semibold hover:bg-gray-800 transition-colors shadow-sm">
                    Cari
                </button>
                @if (request('search'))
                    <a href="{{ route('admin.pembayaran.index') }}"
                        class="bg-gray-100 border border-gray-300 text-gray-700 px-4 py-2.5 rounded-lg text-sm font-semibold hover:bg-gray-200 transition-colors">Reset</a>
                @endif
            </form>
        </div>

        <!-- Tabel Data -->
        <div class="bg-white rounded-xl shadow-lg border-t-4 border-green-500 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse whitespace-nowrap">
                    <thead>
                        <tr class="bg-green-600 text-white">
                            <th class="py-4 px-6 font-semibold text-sm uppercase tracking-wider">Tanggal</th>
                            <th class="py-4 px-6 font-semibold text-sm uppercase tracking-wider">Nama Pasien</th>
                            <th class="py-4 px-6 font-semibold text-sm uppercase tracking-wider">Alamat</th>
                            <th class="py-4 px-6 font-semibold text-sm uppercase tracking-wider">Layanan</th>
                            <th class="py-4 px-6 font-semibold text-sm uppercase tracking-wider">Total Tagihan</th>
                            <th class="py-4 px-6 font-semibold text-sm uppercase tracking-wider text-center">Status</th>
                            <th class="py-4 px-6 font-semibold text-sm uppercase tracking-wider text-center">Aksi Kendali
                            </th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700 bg-white">
                        @forelse ($kunjungans as $k)
                            <tr class="border-b border-gray-200 hover:bg-gray-50 transition duration-150 ease-in-out group">
                                <td class="py-4 px-6 text-sm">
                                    {{ \Carbon\Carbon::parse($k->tanggal_kunjungan)->format('d M Y') }}
                                </td>

                                <td class="py-4 px-6 font-bold group-hover:text-green-600 transition-colors">
                                    {{ $k->pasien->pengguna->name ?? 'Pasien Terhapus' }}
                                </td>

                                <td class="py-4 px-6 font-bold group-hover:text-green-600 transition-colors">
                                    {{ $k->pasien->alamat ?? 'Pasien Terhapus' }}
                                </td>

                                <td class="py-4 px-6 text-sm">
                                    <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded text-xs font-bold uppercase">
                                        {{ str_replace('_', ' ', $k->tipe) }}
                                    </span>
                                </td>

                                <!-- Total Tagihan -->
                                <td
                                    class="py-4 px-6 text-sm font-bold {{ $k->pembayaran ? 'text-gray-900' : 'text-gray-400' }}">
                                    @if ($k->pembayaran)
                                        Rp {{ number_format($k->pembayaran->total_bayar, 0, ',', '.') }}
                                    @else
                                        <span class="italic font-normal">Belum dihitung</span>
                                    @endif
                                </td>

                                <!-- Status Pembayaran -->
                                <td class="py-4 px-6 text-center">
                                    @if (!$k->pembayaran)
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-800 uppercase tracking-wider">
                                            Menunggu Tarif
                                        </span>
                                    @elseif($k->pembayaran->status == 'belum_lunas')
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-red-100 text-red-800 uppercase tracking-wider">
                                            Belum Lunas
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800 uppercase tracking-wider">
                                            Lunas
                                        </span>
                                    @endif
                                </td>

                                <!-- Aksi Kendali -->
                                <td class="py-4 px-6 text-center">
                                    @if (!$k->pembayaran)
                                        <!-- Aksi 1: Buat Tarif jika Perawat sudah selesai -->
                                        <a href="{{ route('admin.pembayaran.create', $k->id) }}"
                                            class="inline-flex items-center px-3 py-1.5 bg-black text-white text-xs font-bold rounded-md hover:bg-gray-800 transition-colors shadow-sm">
                                            Input Tarif
                                        </a>
                                    @elseif($k->pembayaran->status == 'belum_lunas')
                                        <!-- Aksi 2: Konfirmasi Bayar jika pasien sudah menyerahkan uang -->
                                        <form action="{{ route('admin.konfirmasi.bayar', $k->id) }}" method="POST"
                                            class="inline"
                                            onsubmit="return confirm('Konfirmasi bahwa pasien ini telah membayar lunas tagihan sebesar Rp {{ number_format($k->pembayaran->total_bayar, 0, ',', '.') }}?')">
                                            @csrf
                                            <input type="hidden" name="status" value="lunas">
                                            <button type="submit"
                                                class="inline-flex items-center px-3 py-1.5 bg-green-500 text-white text-xs font-bold rounded-md hover:bg-green-600 transition-colors shadow-sm cursor-pointer">
                                                Konfirmasi Lunas
                                            </button>
                                        </form>
                                    @else
                                        <!-- Aksi 3: Jika sudah lunas, lihat detail nota -->
                                        <a href="{{ route('admin.kunjungan.show', $k->id) }}"
                                            class="text-green-600 font-bold text-sm hover:underline hover:text-green-800">
                                            Cetak Nota
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8 px-6 text-center text-gray-500 font-medium">
                                    Tidak ada data tagihan atau antrean administrasi yang perlu diproses.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if (isset($kunjungans) && $kunjungans->hasPages())
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                    {{ $kunjungans->appends(request()->query())->links() }}
                </div>
            @endif
        </div>

    </div>
@endsection
