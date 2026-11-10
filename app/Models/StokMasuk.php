<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokMasuk extends Model
{
    use HasFactory;

    protected $table = 'stok_masuk';

    // ⚠️ TAMBAHKAN BARIS INI - Disable updated_at
    const UPDATED_AT = null;

    protected $fillable = [
        'kode_stok_masuk',
        'buku_id',
        'supplier_id',
        'user_id',
        'jumlah',
        'harga_beli',
        'total_harga_beli',
        'tanggal',
        'keterangan',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'harga_beli' => 'decimal:2',
        'total_harga_beli' => 'decimal:2',
        'jumlah' => 'integer',
    ];

    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function riwayatStok()
    {
        return $this->hasOne(RiwayatStok::class, 'stok_masuk_id');
    }
}