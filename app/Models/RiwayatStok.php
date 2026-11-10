<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatStok extends Model
{
    use HasFactory;

    protected $table = 'riwayat_stok';

    // ⚠️ TAMBAHKAN BARIS INI - Disable updated_at
    const UPDATED_AT = null;

    protected $fillable = [
        'buku_id',
        'user_id',
        'stok_masuk_id',
        'jenis_perubahan',
        'jumlah',
        'stok_sebelum',
        'stok_sesudah',
        'referensi_id',
        'referensi_tipe',
        'keterangan',
    ];

    protected $casts = [
        'jumlah' => 'integer',
        'stok_sebelum' => 'integer',
        'stok_sesudah' => 'integer',
    ];

    // Relasi ke Buku
    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke StokMasuk
    public function stokMasuk()
    {
        return $this->belongsTo(StokMasuk::class, 'stok_masuk_id');
    }
}