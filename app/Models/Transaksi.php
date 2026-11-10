<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi'; // ← TAMBAHKAN INI
    
    protected $fillable = [
        'kode_transaksi', 'pelanggan_id', 'user_id', 'total', 'diskon', 
        'total_setelah_diskon', 'bayar', 'kembalian', 'metode_bayar', 
        'status', 'alasan_batal', 'catatan', 'tanggal'
    ];

    protected $casts = [
        'total' => 'decimal:2', 
        'diskon' => 'decimal:2', 
        'total_setelah_diskon' => 'decimal:2', 
        'bayar' => 'decimal:2', 
        'kembalian' => 'decimal:2', 
        'tanggal' => 'date',
    ];

    public function pelanggan() { return $this->belongsTo(Pelanggan::class); }
    public function kasir() { return $this->belongsTo(User::class, 'user_id'); }
    public function detail() { return $this->hasMany(DetailTransaksi::class, 'transaksi_id'); }
}