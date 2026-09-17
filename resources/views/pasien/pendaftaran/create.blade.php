@extends('layouts.app')

@section('title', 'Pendaftaran Online')

@section('content')
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Ajukan Pendaftaran Online</h2>
                <p class="text-sm text-gray-500 mt-1">Isi formulir berikut untuk mendaftar kunjungan ke klinik.</p>
            </div>
            <a href="{{ route('pasien.pendaftaran.index') }}"
                class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-semibold text-gray-700 hover:bg-gray-50">
                &larr; Kembali
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-lg border-t-4 border-green-500 overflow-hidden">
            <form action="{{ route('pasien.pendaftaran.store') }}" method="POST" class="p-6 sm:p-8">
                @csrf

                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Pasien</label>
                        <input type="text" value="{{ auth()->user()->name }}" disabled
                            class="w-full rounded-lg border border-gray-300 bg-gray-100 px-3 py-3 text-sm text-gray-700" />
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">NIK</label>
                        <input type="text" value="{{ $pasien->nik ?? '-' }}" disabled
                            class="w-full rounded-lg border border-gray-300 bg-gray-100 px-3 py-3 text-sm text-gray-700" />
                    </div>

                    <div>
                        <label for="tipe" class="block text-sm font-semibold text-gray-700 mb-1">Jenis Kunjungan <span
                                class="text-red-500">*</span></label>
                        <select name="tipe" id="tipe" required
                            class="w-full rounded-lg border border-gray-300 bg-gray-50 px-3 py-3 text-sm focus:border-green-500 focus:ring-2 focus:ring-green-200 outline-none">
                            <option value="rawat_jalan">Rawat Jalan</option>
                            <option value="rawat_inap">Rawat Inap</option>
                        </select>
                    </div>

                    <div>
                        <label for="tanggal_kunjungan" class="block text-sm font-semibold text-gray-700 mb-1">Tanggal
                            Kunjungan <span class="text-red-500">*</span></label>
                        <input type="date" name="tanggal_kunjungan" id="tanggal_kunjungan" required
                            min="{{ date('Y-m-d') }}"
                            class="w-full rounded-lg border border-gray-300 bg-gray-50 px-3 py-3 text-sm focus:border-green-500 focus:ring-2 focus:ring-green-200 outline-none" />
                    </div>

                    <div>
                        <label for="keluhan" class="block text-sm font-semibold text-gray-700 mb-1">Keluhan Awal</label>
                        <textarea name="keluhan" id="keluhan" rows="4" placeholder="Contoh: Demam, pusing, batuk, atau keluhan lain..."
                            class="w-full rounded-lg border border-gray-300 bg-gray-50 px-3 py-3 text-sm focus:border-green-500 focus:ring-2 focus:ring-green-200 outline-none"></textarea>
                    </div>
                </div>

                <div class="mt-8 flex items-center justify-end gap-3">
                    <a href="{{ route('pasien.dashboard') }}"
                        class="px-5 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100 text-sm font-semibold">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-6 py-2.5 bg-green-600 text-white rounded-lg hover:bg-green-700 text-sm font-bold shadow-sm">
                        Ajukan Pendaftaran
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
