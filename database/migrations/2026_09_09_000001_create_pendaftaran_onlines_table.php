<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    Schema::create('pendaftaran_onlines', function (Blueprint $table) {
      $table->id();
      $table->foreignId('pasien_id')->constrained('pasiens');
      $table->foreignId('petugas_id')->nullable()->constrained('users');
      $table->enum('tipe', ['rawat_jalan', 'rawat_inap']);
      $table->date('tanggal_kunjungan');
      $table->text('keluhan')->nullable();
      $table->enum('status', ['pending', 'diterima', 'ditolak'])->default('pending');
      $table->string('catatan_admin')->nullable();
      $table->timestamps();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('pendaftaran_onlines');
  }
};
