<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Pasien;
use App\Models\Kunjungan;

#[Fillable(['name', 'email', 'password', 'role'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    // 🔹 Relasi ke pasien (1:1)
    public function pasien()
    {
        return $this->hasOne(Pasien::class, 'pengguna_id');
    }

    // 🔹 Petugas membuat banyak kunjungan
    public function kunjunganSebagaiPetugas()
    {
        return $this->hasMany(Kunjungan::class, 'petugas_id');
    }

    // 🔹 Perawat menangani banyak kunjungan
    public function kunjunganSebagaiPerawat()
    {
        return $this->hasMany(Kunjungan::class, 'perawat_id');
    }
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
