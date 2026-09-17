@extends('layouts.app')

@section('title', 'Status Pendaftaran')

@section('content')
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Status Pendaftaran Online</h2>
                <p class="text-sm text-gray-500 mt-1">Pantau status pengajuan kunjungan Anda.</p>
            </div>
            <div class="flex gap-10">
              <a href="{{ route('pasien.dashboard') }}"
                class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-semibold text-gray-700 hover:bg-gray-50">
                &larr; Kembali
            </a>
            <a href="{{ route('pasien.pendaftaran.create') }}"
                class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg font-semibold text-sm hover:bg-green-700 shadow-sm">
                + Ajukan Baru
            </a>
            </div>
            
        </div>

        @if (session('success'))
            <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border-t-4 border-green-500">
            <div class="overflow-x-auto">
                <table class="w-full border-collapse whitespace-nowrap">
                    <thead>
                        <tr class="bg-green-600 text-white">
                            <th class="py-4 px-6 text-left text-sm font-semibold uppercase tracking-wider">#</th>
                            <th class="py-4 px-6 text-left text-sm font-semibold uppercase tracking-wider">Tanggal</th>
                            <th class="py-4 px-6 text-left text-sm font-semibold uppercase tracking-wider">Tipe</th>
                            <th class="py-4 px-6 text-left text-sm font-semibold uppercase tracking-wider">Keluhan</th>
                            <th class="py-4 px-6 text-left text-sm font-semibold uppercase tracking-wider">Status</th>
                            <th class="py-4 px-6 text-left text-sm font-semibold uppercase tracking-wider">Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pendaftarans as $item)
                            <tr class="border-b border-gray-200 hover:bg-gray-50">
                                <td class="py-4 px-6 text-sm">{{ $loop->iteration }}</td>
                                <td class="py-4 px-6 text-sm">
                                    {{ \Carbon\Carbon::parse($item->tanggal_kunjungan)->format('d M Y') }}</td>
                                <td class="py-4 px-6 text-sm">
                                    {{ $item->tipe == 'rawat_jalan' ? 'Rawat Jalan' : 'Rawat Inap' }}
                                </td>
                                <td class="py-4 px-6 text-sm max-w-xs truncate">{{ $item->keluhan ?? '-' }}</td>
                                <td class="py-4 px-6 text-sm">
                                    @if ($item->status == 'pending')
                                        <span
                                            class="inline-flex items-center rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold text-yellow-800">Menunggu
                                            Review</span>
                                    @elseif($item->status == 'diterima')
                                        <span
                                            class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-800">Diterima</span>
                                    @else
                                        <span
                                            class="inline-flex items-center rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-800">Ditolak</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-sm">{{ $item->catatan_admin ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 px-6 text-center text-gray-500 font-medium">
                                    Belum ada pengajuan pendaftaran online.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($pendaftarans->hasPages())
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                    {{ $pendaftarans->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
