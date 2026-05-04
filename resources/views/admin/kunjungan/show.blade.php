@extends('layouts.app')

@section('title', 'Detail Kunjungan')

@section('content')
    <div class="container mx-auto p-6">
        <h2 class="text-2xl font-bold mb-4">Detail Kunjungan</h2>

        @if (session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4">{{ session('success') }}</div>
        @endif

        <div class="bg-white rounded shadow p-6">
            <p><strong>Pasien:</strong> {{ $kunjungan->pasien->pengguna->name ?? '-' }}</p>
            <p><strong>Tanggal:</strong> {{ $kunjungan->tanggal_kunjungan }}</p>
            <p><strong>Perawat:</strong> {{ $kunjungan->perawat->name ?? '-' }}</p>
            <p><strong>Status:</strong> {{ $kunjungan->status }}</p>
            <p><strong>Keluhan:</strong> {{ $kunjungan->keluhan ?? '-' }}</p>
            <p><strong>Diagnosa:</strong> {{ $kunjungan->diagnosa ?? '-' }}</p>

            @if (!$kunjungan->pembayaran)
                <div class="mt-4">
                    <a href="{{ route('admin.pembayaran.create', $kunjungan->id) }}"
                        class="bg-blue-600 text-white px-3 py-2 rounded">Buat Pembayaran</a>
                </div>
            @else
                <div class="mt-4">
                    <p><strong>Pembayaran:</strong> Rp {{ number_format($kunjungan->pembayaran->total_bayar, 0, ',', '.') }} —
                        {{ $kunjungan->pembayaran->status }}</p>
                </div>
            @endif

            <div class="mt-4">
                <form action="{{ route('admin.kunjungan.updateStatus', $kunjungan->id) }}" method="POST">
                    @csrf
                    <label class="block text-sm">Ubah Status</label>
                    <select name="status" class="border p-2 rounded">
                        <option value="menunggu" {{ $kunjungan->status == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                        <option value="diproses" {{ $kunjungan->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                        <option value="selesai_diperiksa"
                            {{ $kunjungan->status == 'selesai_diperiksa' ? 'selected' : '' }}>
                            Selesai Diperiksa</option>
                        <option value="menunggu_pembayaran"
                            {{ $kunjungan->status == 'menunggu_pembayaran' ? 'selected' : '' }}>Menunggu Pembayaran
                        </option>
                        <option value="selesai" {{ $kunjungan->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                    <button type="submit" class="ml-2 bg-green-600 text-white px-3 py-1 rounded">Simpan</button>
                </form>
            </div>
        </div>
    </div>
@endsection
