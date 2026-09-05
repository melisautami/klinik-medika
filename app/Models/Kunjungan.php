<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Pasien;
use App\Models\User;
use App\Models\Pembayaran;

class Kunjungan extends Model
{
    // gunakan nama tabel sesuai migration: 'kunjungans'
    protected $table = 'kunjungans';

    protected $fillable = [
        'pasien_id',
        'petugas_id',
        'perawat_id',
        'tipe',
        'tanggal_kunjungan',
        'keluhan',
        'diagnosa',
        'tindakan',
        'tarif_ids',
        'status'
    ];

    protected $casts = [
        'tarif_ids' => 'array',
    ];

    public static function normalizeTindakanText(?string $text): string
    {
        $lines = preg_split('/\R/', trim((string) $text ?? '')) ?: [];

        $cleanLines = array_values(array_filter(array_map(function ($line) {
            $line = preg_replace('/^\s+/', '', trim($line));
            return $line === '' ? null : $line;
        }, $lines)));

        return implode("\n", $cleanLines);
    }

    public function getParsedTindakanItems()
    {
        $items = collect();

        if (!empty($this->tindakan)) {
            foreach (preg_split('/\R/', (string) $this->tindakan) as $line) {
                $line = trim($line);
                if ($line === '') {
                    continue;
                }

                if (preg_match('/^(.*?)(?:\s*[-:|]\s*|\s+)(?:Rp\s*)?([0-9\.,]+)\s*$/i', $line, $matches)) {
                    $nama = trim($matches[1]);
                    $harga = (int) str_replace(['.', ','], '', $matches[2]);

                    if ($nama !== '' && $harga > 0) {
                        $items->push((object) [
                            'nama_tindakan' => $nama,
                            'harga' => $harga,
                        ]);
                    }
                }
            }
        }

        if (!empty($this->tarif_ids)) {
            $legacyTarifs = Tarif::whereIn('id', $this->tarif_ids)->get();

            foreach ($legacyTarifs as $tarif) {
                $duplicate = $items->contains(fn($item) => trim($item->nama_tindakan) === trim($tarif->nama_tindakan));

                if (!$duplicate) {
                    $items->push((object) [
                        'nama_tindakan' => $tarif->nama_tindakan,
                        'harga' => (int) $tarif->harga,
                    ]);
                }
            }
        }

        return $items;
    }

    public function getTindakanTotal(): int
    {
        return (int) $this->getParsedTindakanItems()->sum('harga');
    }

    // 🔹 ke pasien
    public function pasien()
    {
        // Tambahkan ->withTrashed() di sini
        return $this->belongsTo(Pasien::class, 'pasien_id')->withTrashed();
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
