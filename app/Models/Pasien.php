<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Kunjungan;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pasien extends Model
{
    use SoftDeletes;
    // gunakan nama tabel sesuai migration: 'pasiens'
    protected $table = 'pasiens';

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
