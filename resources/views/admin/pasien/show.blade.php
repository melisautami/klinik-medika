@extends('layouts.app')

@section('title', 'Detail Pasien')

@section('content')
    <div class="container mx-auto p-6">
        <h2 class="text-2xl font-bold mb-4">Detail Pasien</h2>
        <div class="bg-white rounded shadow p-4">
            <p><strong>Nama:</strong> {{ $pasien->nama ?? ($pasien->name ?? '-') }}</p>
            <p><strong>Alamat:</strong> {{ $pasien->alamat ?? '-' }}</p>
            <p><strong>Tanggal Lahir:</strong> {{ optional($pasien->tanggal_lahir)->format('Y-m-d') ?? '-' }}</p>
        </div>
    </div>
@endsection
