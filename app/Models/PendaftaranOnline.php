<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendaftaranOnline extends Model
{
  protected $table = 'pendaftaran_onlines';

  protected $fillable = [
    'pasien_id',
    'petugas_id',
    'tipe',
    'tanggal_kunjungan',
    'keluhan',
    'status',
    'catatan_admin',
  ];

  public function pasien()
  {
    return $this->belongsTo(Pasien::class, 'pasien_id')->withTrashed();
  }

  public function petugas()
  {
    return $this->belongsTo(User::class, 'petugas_id');
  }

  public function getStatusLabelAttribute(): string
  {
    return match ($this->status) {
      'pending' => 'Menunggu Review',
      'diterima' => 'Diterima',
      'ditolak' => 'Ditolak',
      default => 'Status Tidak Dikenal',
    };
  }
}
