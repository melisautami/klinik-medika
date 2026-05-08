@extends('layouts.app')

@section('title', 'Laporan Bulanan')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Header & Filter Bulan/Tahun -->
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Laporan Kunjungan & Keuangan</h2>
                <p class="text-sm text-gray-500 mt-1">Rekapitulasi performa klinik berdasarkan periode bulan.</p>
            </div>

            <!-- Form Filter -->
            <form method="GET" action="{{ route('admin.laporan.index') }}"
                class="flex items-center gap-2 bg-white p-2 rounded-lg shadow-sm border border-gray-200">
                <select name="bulan"
                    class="border-gray-300 rounded text-sm focus:ring-green-500 focus:border-green-500 outline-none p-2 bg-gray-50">
                    @for ($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ request('bulan', date('n')) == $i ? 'selected' : '' }}>
                            {{ date('F', mktime(0, 0, 0, $i, 1)) }}
                        </option>
                    @endfor
                </select>
                <select name="tahun"
                    class="border-gray-300 rounded text-sm focus:ring-green-500 focus:border-green-500 outline-none p-2 bg-gray-50">
                    @for ($i = date('Y'); $i >= date('Y') - 5; $i--)
                        <option value="{{ $i }}" {{ request('tahun', date('Y')) == $i ? 'selected' : '' }}>
                            {{ $i }}
                        </option>
                    @endfor
                </select>
                <button type="submit"
                    class="bg-black text-white px-4 py-2 rounded text-sm font-semibold hover:bg-gray-800 transition-colors">
                    Tampilkan
                </button>
                <a href="{{ route('admin.laporan.pdf', ['bulan' => request('bulan', date('n')), 'tahun' => request('tahun', date('Y'))]) }}"
                    target="_blank"
                    class="bg-green-600 text-white px-4 py-2 rounded text-sm font-semibold hover:bg-green-700 transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z">
                        </path>
                    </svg>
                    Cetak PDF
                </a>
            </form>
        </div>

        <!-- Grid Ringkasan Performa (Sesuai Poin F) -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Card 1: Total Pendapatan -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 border-b-4 border-b-black">
                <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-2">Total Pendapatan (Lunas)</h3>
                <p class="text-3xl font-black text-green-600">Rp {{ number_format($totalPendapatan ?? 0, 0, ',', '.') }}</p>
            </div>

            <!-- Card 2: Total Kunjungan -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 border-b-4 border-b-green-500">
                <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-2">Total Kunjungan Pasien</h3>
                <p class="text-3xl font-black text-gray-900">{{ $totalKunjungan ?? 0 }} <span
                        class="text-sm font-medium text-gray-500">Pasien</span></p>
            </div>

            <!-- Card 3 & 4: Pemisahan Layanan -->
            <div
                class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col justify-center border-b-4 border-b-black bg-green-50">
                <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wider mb-1">Pasien Rawat Jalan</h3>
                <div class="flex items-end justify-between mt-2">
                    <span class="text-2xl font-bold text-green-600">{{ $rawatJalan ?? 0 }}</span>
                    <span class="text-sm font-semibold text-green-700">Rp
                        {{ number_format($pendapatanJalan ?? 0, 0, ',', '.') }}</span>
                </div>
            </div>

            <div
                class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col justify-center border-b-4 border-b-green-500 bg-gray-50">
                <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wider mb-1">Pasien Rawat Inap</h3>
                <div class="flex items-end justify-between mt-2">
                    <span class="text-2xl font-bold text-black">{{ $rawatInap ?? 0 }}</span>
                    <span class="text-sm font-semibold text-green-700">Rp
                        {{ number_format($pendapatanInap ?? 0, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- Tabel Detail Transaksi Bulan Ini -->
        <div class="bg-white rounded-xl shadow-lg border-t-4 border-green-500 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h3 class="text-lg font-bold text-gray-800">Rincian Kunjungan & Pembayaran Lunas</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse whitespace-nowrap">
                    <thead>
                        <tr class="bg-white text-gray-600 border-b-2 border-gray-200">
                            <th class="py-3 px-6 font-semibold text-xs uppercase tracking-wider">Tanggal</th>
                            <th class="py-3 px-6 font-semibold text-xs uppercase tracking-wider">Nama Pasien</th>
                            <th class="py-3 px-6 font-semibold text-xs uppercase tracking-wider">Layanan</th>
                            <th class="py-3 px-6 font-semibold text-xs uppercase tracking-wider">Nominal Tarif</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        @forelse ($laporans as $item)
                            <tr class="border-b border-gray-100 hover:bg-green-50 transition-colors">
                                <td class="py-3 px-6 text-sm">
                                    {{ \Carbon\Carbon::parse($item->tanggal_kunjungan)->format('d/m/Y') }}</td>
                                <td class="py-3 px-6 text-sm font-medium">
                                    {{ $item->pasien->pengguna->name ?? 'Pasien Terhapus' }}</td>
                                <td class="py-3 px-6 text-sm">
                                    <span
                                        class="px-2 py-1 bg-gray-100 text-gray-700 text-xs font-bold rounded-full uppercase">
                                        {{ str_replace('_', ' ', $item->tipe) }}
                                    </span>
                                </td>
                                <td class="py-3 px-6 text-sm font-bold text-green-700">
                                    Rp {{ number_format($item->pembayaran->total_bayar ?? 0, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-8 px-6 text-center text-gray-500 font-medium">
                                    Belum ada data kunjungan lunas untuk bulan ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if (isset($laporans) && $laporans->hasPages())
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                    {{ $laporans->appends(request()->query())->links() }}
                </div>
            @endif
        </div>

    </div>
@endsection
