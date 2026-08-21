<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    Schema::table('kunjungans', function (Blueprint $table) {
      $table->json('tarif_ids')->nullable()->after('tindakan');
    });
  }

  public function down(): void
  {
    Schema::table('kunjungans', function (Blueprint $table) {
      $table->dropColumn('tarif_ids');
    });
  }
};
