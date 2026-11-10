<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;
    
    protected $table = 'buku'; // ← TAMBAHKAN INI
    
    protected $fillable = [
        'kode_buku', 'judul', 'pengarang', 'penerbit', 'tahun_terbit', 'isbn', 
        'kategori_id', 'kondisi', 'deskripsi_kondisi', 'harga', 'stok', 
        'stok_minimum', 'lokasi_rak', 'foto', 'is_aktif', 'created_by'
    ];

    protected $casts = [
        'tahun_terbit' => 'integer',
        'harga' => 'decimal:2',
        'stok' => 'integer',
        'stok_minimum' => 'integer',
        'is_aktif' => 'boolean',
    ];

    public function kategori() { return $this->belongsTo(Kategori::class); }
    public function creator() { return $this->belongsTo(User::class, 'created_by'); }
    public function detailTransaksi() { return $this->hasMany(DetailTransaksi::class); }
    public function stokMasuk() { return $this->hasMany(StokMasuk::class); }
    public function riwayatStok() { return $this->hasMany(RiwayatStok::class); }
}