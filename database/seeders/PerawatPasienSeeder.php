<?php

namespace Database\Seeders;

use App\Models\Pasien;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Tarif;

class PerawatPasienSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    // buat beberapa perawat
    foreach (range(1, 3) as $i) {
      User::firstOrCreate(
        ['email' => "perawat{$i}@klinik.test"],
        [
          'name' => "Perawat {$i}",
          'password' => Hash::make('secret'),
          'role' => 'perawat',
        ]
      );
    }

    // buat beberapa pasien (setiap pasien punya user sebagai 'pengguna')
    foreach (range(1, 5) as $i) {
      $user = User::firstOrCreate(
        ['email' => "pasien{$i}@example.test"],
        [
          'name' => "Pasien {$i}",
          'password' => Hash::make('secret'),
          'role' => 'pasien',
        ]
      );

      Pasien::firstOrCreate(
        ['pengguna_id' => $user->id],
        [
          'nik' => 'NIK' . rand(100000, 999999),
          'alamat' => 'Alamat contoh',
          'no_hp' => '0812' . rand(1000000, 9999999),
          'tanggal_lahir' => now()->subYears(30)->format('Y-m-d'),
        ]
      );
    }

    // sample tarifs
    $sample = [
      ['nama_tindakan' => 'Konsultasi Dokter', 'harga' => 50000],
      ['nama_tindakan' => 'Tindakan Minor', 'harga' => 75000],
      ['nama_tindakan' => 'Laboratorium Dasar', 'harga' => 60000],
    ];

    foreach ($sample as $s) {
      Tarif::firstOrCreate(['nama_tindakan' => $s['nama_tindakan']], ['harga' => $s['harga']]);
    }
  }
}
