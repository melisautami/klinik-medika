@extends('layouts.app')

@section('title', 'Pembayaran QRIS')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Pembayaran QRIS</h2>
                <p class="text-sm text-gray-500 mt-1">Scan kode QR berikut untuk pembayaran pasien, lalu konfirmasi manual
                    setelah transfer selesai.</p>
            </div>
            <a href="{{ route('admin.kunjungan.show', $kunjungan->id) }}"
                class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-semibold text-gray-700 hover:bg-gray-50 hover:text-green-600 transition-colors shadow-sm text-sm whitespace-nowrap">
                &larr; Kembali
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-lg border-t-4 border-green-500 overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-[1.1fr_0.9fr]">
                <div class="p-8 border-b lg:border-b-0 lg:border-r border-gray-200 bg-gray-50">
                    <div class="flex justify-center">
                        <div class="bg-white border-4 border-dashed border-green-200 rounded-2xl p-6 shadow-sm">
                            <div
                                class="w-64 h-64 bg-white flex items-center justify-center text-6xl font-black text-green-600 border-2 border-gray-200 rounded-2xl">
                                <img src="{{ asset('qr.png') }}" alt="QRIS" class="w-50 h-50">
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 text-center">
                        <p class="text-sm text-gray-500 uppercase tracking-wider font-bold">Nominal</p>
                        <p class="mt-2 text-3xl font-black text-gray-900">
                            Rp {{ number_format($pembayaran->total_bayar, 0, ',', '.') }}
                        </p>
                    </div>
                </div>

                <div class="p-8">
                    <div class="space-y-5">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-wider text-gray-500">Nama Pasien</p>
                            <p class="mt-1 text-lg font-bold text-gray-900">{{ $kunjungan->pasien->pengguna->name ?? '-' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs font-bold uppercase tracking-wider text-gray-500">Metode</p>
                            <p class="mt-1 text-lg font-bold text-green-700 uppercase">QRIS</p>
                        </div>

                        <div>
                            <p class="text-xs font-bold uppercase tracking-wider text-gray-500">Status</p>
                            <span
                                class="mt-1 inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-800 uppercase tracking-wider">
                                Belum Lunas
                            </span>
                        </div>

                        <form action="{{ route('admin.konfirmasi.bayar', $kunjungan->id) }}" method="POST"
                            class="pt-4 border-t border-gray-200">
                            @csrf
                            <input type="hidden" name="status" value="lunas">
                            <input type="hidden" name="metode_pembayaran" value="qris">
                            <button type="submit"
                                onclick="return confirm('Konfirmasi pasien sudah membayar via QRIS dan tagihan ini lunas?')"
                                class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 rounded-xl transition shadow-sm">
                                Konfirmasi Pembayaran QRIS Sudah Lunas
                            </button>
                        </form>

                        <form action="{{ route('admin.pembayaran.ubahManual', $kunjungan->id) }}" method="POST">
                            @csrf
                            <button type="submit"
                                onclick="return confirm('Ubah metode pembayaran pasien ini menjadi cash/manual?')"
                                class="w-full bg-white hover:bg-gray-50 text-gray-800 border border-gray-300 font-bold py-3 rounded-xl transition shadow-sm">
                                Ubah ke Pembayaran Cash
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
