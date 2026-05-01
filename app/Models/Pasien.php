<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    protected $table = 'pasien';

    protected $fillable = [
        'pengguna_id',
        'nik',
        'alamat',
        'no_hp',
        'tanggal_lahir'
    ];

    // 🔹 ke pengguna
    public function pengguna()
    {
        return $this->belongsTo(User::class, 'pengguna_id');
    }

    // 🔹 ke kunjungan (1:N)
    public function kunjungan()
    {
        return $this->hasMany(Kunjungan::class, 'pasien_id');
    }
}
