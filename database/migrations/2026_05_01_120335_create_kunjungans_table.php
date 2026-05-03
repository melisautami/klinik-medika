<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kunjungans', function (Blueprint $table) {
            $table->id();

            $table->foreignId('pasien_id')->constrained('pasiens');
            $table->foreignId('petugas_id')->constrained('users');
            $table->foreignId('perawat_id')->nullable()->constrained('users');

            $table->date('tanggal_kunjungan');

            // rekam medis
            $table->text('keluhan')->nullable();
            $table->text('diagnosa')->nullable();
            $table->text('tindakan')->nullable();

            // status alur
            $table->enum('status', [
                'menunggu',              // setelah input petugas
                'diproses',              // perawat ambil
                'selesai_diperiksa',     // setelah isi rekam medis
                'menunggu_pembayaran',
                'selesai'
            ]);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kunjungans');
    }
};
