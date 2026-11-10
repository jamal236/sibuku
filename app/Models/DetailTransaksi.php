<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    protected $table = 'detail_transaksi'; // ← TAMBAHKAN INI
    
    const UPDATED_AT = null;

    protected $fillable = [
        'transaksi_id', 'buku_id', 'judul_snapshot', 'kondisi_snapshot', 
        'jumlah', 'harga_satuan', 'diskon_item', 'subtotal'
    ];

    protected $casts = [
        'jumlah' => 'integer', 
        'harga_satuan' => 'decimal:2', 
        'diskon_item' => 'decimal:2', 
        'subtotal' => 'decimal:2',
    ];

    public function transaksi() { return $this->belongsTo(Transaksi::class); }
    public function buku() { return $this->belongsTo(Buku::class); }
}