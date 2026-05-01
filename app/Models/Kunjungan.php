<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kunjungan extends Model
{
    protected $table = 'kunjungan';

    protected $fillable = [
        'pasien_id',
        'petugas_id',
        'perawat_id',
        'tanggal_kunjungan',
        'keluhan',
        'diagnosa',
        'tindakan',
        'status'
    ];

    // 🔹 ke pasien
    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'pasien_id');
    }

    // 🔹 ke petugas
    public function petugas()
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }

    // 🔹 ke perawat
    public function perawat()
    {
        return $this->belongsTo(User::class, 'perawat_id');
    }

    // 🔹 ke pembayaran (1:1)
    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'kunjungan_id');
    }
}
