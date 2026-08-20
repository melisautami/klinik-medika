<?php

namespace Database\Seeders;

use App\Models\Kunjungan;
use App\Models\Pasien;
use App\Models\Pembayaran;
use App\Models\Tarif;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PerawatPasienSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    // 1. Admin
    User::firstOrCreate(
      ['email' => 'admin@gmail.com'],
      [
        'name' => 'Administrator',
        'password' => Hash::make('123'),
        'role' => 'admin',
      ]
    );

    // 2. Perawat
    $perawatIds = [];
    foreach (range(1, 4) as $i) {
      $perawat = User::firstOrCreate(
        ['email' => "perawat{$i}@klinik.test"],
        [
          'name' => "Perawat {$i}",
          'password' => Hash::make('secret'),
          'role' => 'perawat',
        ]
      );

      $perawatIds[] = $perawat->id;
    }

    // 3. Pasien
    $pasienIds = [];
    foreach (range(1, 12) as $i) {
      $user = User::firstOrCreate(
        ['email' => "pasien{$i}@example.test"],
        [
          'name' => "Pasien {$i}",
          'password' => Hash::make('secret'),
          'role' => 'pasien',
        ]
      );

      $pasien = Pasien::firstOrCreate(
        ['pengguna_id' => $user->id],
        [
          'nik' => str_pad((string) (3100000000000000 + $i), 16, '0', STR_PAD_LEFT),
          'alamat' => "Jl. Contoh No. {$i}, Kota Klinik",
          'no_hp' => '0812' . str_pad((string) ($i * 123456), 7, '0', STR_PAD_LEFT),
          'tanggal_lahir' => now()->subYears(20 + $i)->format('Y-m-d'),
        ]
      );

      $pasienIds[] = $pasien->id;
    }

    // 4. Tarif
    $sampleTarif = [
      ['nama_tindakan' => 'Konsultasi Dokter', 'harga' => 50000],
      ['nama_tindakan' => 'Tindakan Minor', 'harga' => 75000],
      ['nama_tindakan' => 'Laboratorium Dasar', 'harga' => 60000],
      ['nama_tindakan' => 'Pemeriksaan Umum', 'harga' => 85000],
      ['nama_tindakan' => 'Rawat Jalan', 'harga' => 120000],
    ];

    foreach ($sampleTarif as $tarif) {
      Tarif::firstOrCreate(
        ['nama_tindakan' => $tarif['nama_tindakan']],
        ['harga' => $tarif['harga']]
      );
    }

    // 5. Kunjungan sample tanpa pembayaran otomatis.
    // Pembayaran hanya dibuat setelah admin mengonfirmasi tagihan dan status lunas.
    $adminId = User::where('role', 'admin')->value('id');
    $petugasId = $adminId ?? User::first()->id;

    foreach ($pasienIds as $index => $pasienId) {
      $perawatId = $perawatIds[$index % count($perawatIds)];
      $date = now()->subDays($index + 1)->format('Y-m-d');
      $statusList = ['menunggu', 'diproses', 'selesai_diperiksa'];

      Kunjungan::firstOrCreate(
        [
          'pasien_id' => $pasienId,
          'tanggal_kunjungan' => $date,
        ],
        [
          'petugas_id' => $petugasId,
          'perawat_id' => $perawatId,
          'tipe' => $index % 2 === 0 ? 'rawat_jalan' : 'rawat_inap',
          'keluhan' => 'Keluhan sample ' . ($index + 1),
          'diagnosa' => 'Diagnosis sample ' . ($index + 1),
          'tindakan' => 'Tindakan sample ' . ($index + 1),
          'status' => $statusList[$index % count($statusList)],
        ]
      );
    }
  }
}
