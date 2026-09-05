<?php

namespace Tests\Feature;

use App\Models\Kunjungan;
use App\Models\Pasien;
use App\Models\Pembayaran;
use App\Models\Tarif;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RevisionBillingTarifTest extends TestCase
{
  use RefreshDatabase;

  public function test_admin_can_edit_and_delete_tariff(): void
  {
    $admin = User::factory()->create([
      'role' => 'admin',
      'email' => 'admin@test.com',
    ]);

    $tarif = Tarif::create([
      'nama_tindakan' => 'Cek Gula Darah',
      'harga' => 150000,
    ]);

    $this->actingAs($admin)
      ->put(route('admin.tarif.update', $tarif), [
        'nama_tindakan' => 'Cek Gula Darah + Hemoglobin',
        'harga' => 180000,
      ])
      ->assertRedirect(route('admin.tarif.index'))
      ->assertSessionHas('success');

    $this->assertDatabaseHas('tarifs', [
      'id' => $tarif->id,
      'nama_tindakan' => 'Cek Gula Darah + Hemoglobin',
      'harga' => 180000,
    ]);

    $this->actingAs($admin)
      ->delete(route('admin.tarif.destroy', $tarif))
      ->assertRedirect(route('admin.tarif.index'))
      ->assertSessionHas('success');

    $this->assertDatabaseMissing('tarifs', ['id' => $tarif->id]);
  }

  public function test_admin_can_set_qris_payment_status_manually(): void
  {
    $admin = User::factory()->create(['role' => 'admin']);
    $patientUser = User::factory()->create(['role' => 'pasien']);

    $pasien = Pasien::create([
      'pengguna_id' => $patientUser->id,
      'nik' => '1234567890123456',
      'alamat' => 'Jl. Merdeka 123',
      'no_hp' => '081234567890',
      'tanggal_lahir' => '2000-01-01',
    ]);

    $kunjungan = Kunjungan::create([
      'pasien_id' => $pasien->id,
      'petugas_id' => $admin->id,
      'perawat_id' => $admin->id,
      'tipe' => 'rawat_jalan',
      'tanggal_kunjungan' => now()->toDateString(),
      'keluhan' => 'Pusing',
      'diagnosa' => 'Demam ringan',
      'tindakan' => 'Konsultasi',
      'status' => 'selesai_diperiksa',
    ]);

    Pembayaran::create([
      'kunjungan_id' => $kunjungan->id,
      'total_bayar' => 250000,
      'status' => 'belum_lunas',
      'metode_pembayaran' => 'qris',
    ]);

    $this->actingAs($admin)
      ->post(route('admin.konfirmasi.bayar', $kunjungan), [
        'status' => 'lunas',
        'metode_pembayaran' => 'qris',
      ])
      ->assertRedirect(route('admin.kunjungan.show', $kunjungan->id));

    $this->assertDatabaseHas('pembayarans', [
      'kunjungan_id' => $kunjungan->id,
      'status' => 'lunas',
      'metode_pembayaran' => 'qris',
    ]);
  }

  public function test_perawat_can_store_manual_treatment_and_admin_calculates_total_from_manual_prices(): void
  {
    $admin = User::factory()->create(['role' => 'admin']);
    $perawat = User::factory()->create(['role' => 'perawat']);
    $patientUser = User::factory()->create(['role' => 'pasien']);

    $pasien = Pasien::create([
      'pengguna_id' => $patientUser->id,
      'nik' => '1234567890123456',
      'alamat' => 'Jl. Merdeka 123',
      'no_hp' => '081234567890',
      'tanggal_lahir' => '2000-01-01',
    ]);

    $kunjungan = Kunjungan::create([
      'pasien_id' => $pasien->id,
      'petugas_id' => $admin->id,
      'perawat_id' => $perawat->id,
      'tipe' => 'rawat_jalan',
      'tanggal_kunjungan' => now()->toDateString(),
      'keluhan' => 'Pusing',
      'diagnosa' => 'Demam ringan',
      'status' => 'diproses',
    ]);

    $this->actingAs($perawat)
      ->post(route('perawat.rekam', $kunjungan), [
        'keluhan' => 'Pusing',
        'diagnosa' => 'Demam ringan',
        'tindakan' => "Paracetamol - Rp 5.000\nObat batuk - Rp 15.000\nTindakan penanganan - Rp 50.000",
      ])
      ->assertRedirect(route('perawat.kunjungan'))
      ->assertSessionHas('success');

    $kunjungan->refresh();
    $this->assertSame("Paracetamol - Rp 5.000\nObat batuk - Rp 15.000\nTindakan penanganan - Rp 50.000", $kunjungan->tindakan);

    $this->actingAs($admin)
      ->post(route('admin.pembayaran.store', $kunjungan), [
        'metode_pembayaran' => 'manual',
      ])
      ->assertRedirect(route('admin.kunjungan.show', $kunjungan->id));

    $this->assertDatabaseHas('pembayarans', [
      'kunjungan_id' => $kunjungan->id,
      'total_bayar' => 70000,
      'metode_pembayaran' => 'manual',
    ]);
  }
}
