@extends('layouts.app')

@section('title', 'Dashboard Petugas')
@section('header_title', 'Kendali Operasional')

@section('content')
    <div class="container mx-auto p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                <p class="text-sm text-gray-500">Total Kunjungan Hari Ini</p>
                <h3 class="text-3xl font-bold">{{ $totalKunjungan ?? 0 }}</h3>
            </div>
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                <p class="text-sm text-gray-500">Pasien Rawat Jalan</p>
                <h3 class="text-3xl font-bold">{{ $rawatJalan ?? 0 }}</h3>
            </div>
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                <p class="text-sm text-gray-500">Pasien Rawat Inap</p>
                <h3 class="text-3xl font-bold">{{ $rawatInap ?? 0 }}</h3>
            </div>
        </div>

        <div>
            <a href="{{ route('admin.pemeriksaan.create') }}" class="bg-green-600 text-white px-4 py-2 rounded">Ajukan
                Pemeriksaan Baru</a>
        </div>
    </div>
@endsection
