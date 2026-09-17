@extends('layouts.app')

@section('title', 'Validasi Pendaftaran Online')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Validasi Pendaftaran Online</h2>
            <p class="text-sm text-gray-500 mt-1">Review pengajuan pasien baru dan terima atau tolak sesuai kondisi klinik.
            </p>
        </div>

        <div class="mb-6 flex items-center gap-3">
            <a href="{{ route('admin.pendaftaran.index') }}"
                class="rounded-lg px-4 py-2 text-sm font-semibold {{ !request('status') ? 'bg-green-600 text-white' : 'bg-gray-200 text-gray-700' }}">Semua</a>
            <a href="{{ route('admin.pendaftaran.index', ['status' => 'pending']) }}"
                class="rounded-lg px-4 py-2 text-sm font-semibold {{ request('status') == 'pending' ? 'bg-yellow-500 text-white' : 'bg-gray-200 text-gray-700' }}">Menunggu</a>
            <a href="{{ route('admin.pendaftaran.index', ['status' => 'diterima']) }}"
                class="rounded-lg px-4 py-2 text-sm font-semibold {{ request('status') == 'diterima' ? 'bg-green-600 text-white' : 'bg-gray-200 text-gray-700' }}">Diterima</a>
            <a href="{{ route('admin.pendaftaran.index', ['status' => 'ditolak']) }}"
                class="rounded-lg px-4 py-2 text-sm font-semibold {{ request('status') == 'ditolak' ? 'bg-red-600 text-white' : 'bg-gray-200 text-gray-700' }}">Ditolak</a>
        </div>

        <div class="mb-6">
            <form method="GET" action="{{ route('admin.pendaftaran.index') }}" class="flex gap-3">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari nama atau NIK pasien..."
                    class="w-full max-w-md rounded-lg border border-gray-300 bg-gray-50 px-4 py-2.5 text-sm focus:border-green-500 focus:ring-2 focus:ring-green-200 outline-none" />
                @if (request('status'))
                    <input type="hidden" name="status" value="{{ request('status') }}">
                @endif
                <button type="submit"
                    class="rounded-lg bg-gray-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-gray-700">Cari</button>
            </form>
        </div>

        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border-t-4 border-green-500">
            <div class="overflow-x-auto">
                <table class="w-full border-collapse whitespace-nowrap">
                    <thead>
                        <tr class="bg-green-600 text-white">
                            <th class="py-4 px-6 text-left text-sm font-semibold uppercase tracking-wider">#</th>
                            <th class="py-4 px-6 text-left text-sm font-semibold uppercase tracking-wider">Pasien</th>
                            <th class="py-4 px-6 text-left text-sm font-semibold uppercase tracking-wider">NIK</th>
                            <th class="py-4 px-6 text-left text-sm font-semibold uppercase tracking-wider">Tipe</th>
                            <th class="py-4 px-6 text-left text-sm font-semibold uppercase tracking-wider">Tanggal</th>
                            <th class="py-4 px-6 text-left text-sm font-semibold uppercase tracking-wider">Status</th>
                            <th class="py-4 px-6 text-left text-sm font-semibold uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pendaftarans as $item)
                            <tr class="border-b border-gray-200 hover:bg-gray-50">
                                <td class="py-4 px-6 text-sm">{{ $loop->iteration }}</td>
                                <td class="py-4 px-6 text-sm font-medium">{{ $item->pasien->pengguna->name ?? '-' }}</td>
                                <td class="py-4 px-6 text-sm">{{ $item->pasien->nik ?? '-' }}</td>
                                <td class="py-4 px-6 text-sm">
                                    {{ $item->tipe == 'rawat_jalan' ? 'Rawat Jalan' : 'Rawat Inap' }}</td>
                                <td class="py-4 px-6 text-sm">
                                    {{ \Carbon\Carbon::parse($item->tanggal_kunjungan)->format('d M Y') }}</td>
                                <td class="py-4 px-6 text-sm">
                                    @if ($item->status == 'pending')
                                        <span
                                            class="inline-flex items-center rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold text-yellow-800">Menunggu</span>
                                    @elseif($item->status == 'diterima')
                                        <span
                                            class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-800">Diterima</span>
                                    @else
                                        <span
                                            class="inline-flex items-center rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-800">Ditolak</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-sm">
                                    @if ($item->status == 'pending')
                                        <div class="flex items-center gap-2">
                                            <form action="{{ route('admin.pendaftaran.approve', $item->id) }}"
                                                method="POST">
                                                @csrf
                                                <button type="submit"
                                                    class="rounded-lg bg-green-600 px-3 py-2 text-white text-xs font-semibold hover:bg-green-700">Terima</button>
                                            </form>
                                            <form action="{{ route('admin.pendaftaran.reject', $item->id) }}"
                                                method="POST">
                                                @csrf
                                                <input type="text" name="catatan_admin" placeholder="Alasan penolakan"
                                                    required
                                                    class="rounded-lg border border-gray-300 px-2 py-2 text-xs focus:border-red-500 focus:ring-2 focus:ring-red-200 outline-none w-32" />
                                                <button type="submit"
                                                    class="ml-1 rounded-lg bg-red-600 px-3 py-2 text-white text-xs font-semibold hover:bg-red-700">Tolak</button>
                                            </form>
                                        </div>
                                    @else
                                        <span class="text-gray-500">Selesai</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-12 px-6 text-center text-gray-500 font-medium">Belum ada
                                    pengajuan pendaftaran.</td>
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
