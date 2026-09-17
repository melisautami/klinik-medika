@extends('layouts.app')

@section('title', 'Dashboard Petugas')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900">Kendali Operasional Klinik</h2>
            <p class="text-sm text-gray-500 mt-1">Pantau antrean pasien dan aktivitas administrasi hari ini.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-8">
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 border-l-4 border-l-black">
                <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Kunjungan Hari Ini</p>
                <h3 class="text-3xl font-black text-gray-900">{{ $totalKunjungan ?? 0 }} <span
                        class="text-sm font-medium text-gray-500">Pasien</span></h3>
            </div>
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 border-l-4 border-l-green-500">
                <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Rawat Jalan</p>
                <h3 class="text-3xl font-black text-gray-900">{{ $rawatJalan ?? 0 }}</h3>
            </div>
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 border-l-4 border-l-gray-300">
                <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Rawat Inap</p>
                <h3 class="text-3xl font-black text-gray-900">{{ $rawatInap ?? 0 }}</h3>
            </div>
            <a href="{{ route('admin.pasien.kategori', 'baru') }}"
                class="block bg-white rounded-xl p-6 shadow-sm border border-gray-100 border-l-4 border-l-blue-500 hover:shadow-md hover:border-blue-300 transition">
                <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Pasien Baru</p>
                <h3 class="text-3xl font-black text-gray-900">{{ $pasienBaru ?? 0 }}</h3>
                <span class="mt-2 block text-xs font-semibold text-blue-600">Lihat daftar pasien baru</span>
            </a>
            <a href="{{ route('admin.pasien.kategori', 'lama') }}"
                class="block bg-white rounded-xl p-6 shadow-sm border border-gray-100 border-l-4 border-l-yellow-500 hover:shadow-md hover:border-yellow-300 transition">
                <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Pasien Lama</p>
                <h3 class="text-3xl font-black text-gray-900">{{ $pasienLama ?? 0 }}</h3>
                <span class="mt-2 block text-xs font-semibold text-yellow-600">Lihat daftar pasien lama</span>
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <div class="space-y-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Akses Cepat</h3>
                    <div class="flex flex-col gap-3">
                        <a href="{{ route('admin.pemeriksaan.create') }}"
                            class="flex items-center justify-center w-full bg-green-600 text-white font-bold px-4 py-3 rounded-lg hover:bg-green-700 transition shadow-sm">
                            + Ajukan Pemeriksaan Baru
                        </a>
                        <a href="{{ route('admin.pasien.create') }}"
                            class="flex items-center justify-center w-full bg-black text-white font-bold px-4 py-3 rounded-lg hover:bg-gray-800 transition shadow-sm">
                            + Daftar Pasien Baru
                        </a>
                        <a href="{{ route('admin.pembayaran.index') }}"
                            class="flex items-center justify-center w-full bg-white border-2 border-gray-200 text-gray-800 font-bold px-4 py-3 rounded-lg hover:bg-gray-50 transition">
                            Lihat Tagihan Pembayaran
                        </a>
                    </div>
                </div>

                <div class="bg-yellow-50 rounded-xl shadow-sm border border-yellow-200 p-6">
                    <h3 class="text-sm font-bold text-yellow-800 uppercase tracking-wider mb-2">Perhatian Administrasi</h3>
                    <p class="text-sm text-yellow-700 font-medium mb-3">Terdapat <span
                            class="font-bold">{{ $menungguPembayaran ?? 0 }}</span> pasien yang telah selesai diperiksa dan
                        menunggu konfirmasi tarif/pembayaran.</p>
                    <a href="{{ route('admin.pembayaran.index') }}"
                        class="text-sm font-bold text-yellow-900 hover:underline">Proses sekarang &rarr;</a>
                </div>
            </div>

            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-lg border-t-4 border-green-500 overflow-hidden h-full">
                    <div class="px-6 py-5 border-b border-gray-200 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-gray-900">Antrean Berjalan (Hari Ini)</h3>
                        <a href="{{ route('admin.kunjungan.index') }}"
                            class="text-sm font-bold text-green-600 hover:text-green-800">Lihat Semua</a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse whitespace-nowrap">
                            <thead>
                                <tr class="bg-gray-50 text-gray-600 border-b border-gray-200">
                                    <th class="py-3 px-6 font-semibold text-xs uppercase tracking-wider">No</th>
                                    <th class="py-3 px-6 font-semibold text-xs uppercase tracking-wider">Pasien</th>
                                    <th class="py-3 px-6 font-semibold text-xs uppercase tracking-wider">Perawat</th>
                                    <th class="py-3 px-6 font-semibold text-xs uppercase tracking-wider">Status Saat Ini
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-700">
                                @forelse ($antreanHariIni ?? [] as $antrean)
                                    <tr class="border-b border-gray-100 hover:bg-green-50 transition-colors">
                                        <td class="py-3 px-6 text-sm font-medium">{{ $loop->iteration }}</td>
                                        <td class="py-3 px-6 text-sm font-bold text-gray-900">
                                            {{ $antrean->pasien->pengguna->name ?? 'Anonim' }}</td>
                                        <td class="py-3 px-6 text-sm">{{ $antrean->perawat->name ?? 'Belum ada' }}</td>
                                        <td class="py-3 px-6">
                                            <span
                                                class="px-2.5 py-1 text-xs font-bold rounded-full uppercase
                                            {{ $antrean->status == 'menunggu' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                            {{ $antrean->status == 'diproses' ? 'bg-blue-100 text-blue-800' : '' }}
                                            {{ str_contains($antrean->status, 'selesai') ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}
                                        ">
                                                {{ str_replace('_', ' ', $antrean->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-8 px-6 text-center text-gray-500 font-medium">
                                            Belum ada pasien yang mendaftar hari ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
