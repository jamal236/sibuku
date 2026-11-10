<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;
    
    protected $table = 'kategori'; // ← TAMBAHKAN INI
    
    protected $fillable = ['nama_kategori', 'deskripsi', 'warna_label', 'urutan_tampil', 'is_aktif'];
    
    protected $casts = [
        'is_aktif' => 'boolean',
        'urutan_tampil' => 'integer',
    ];

    public function buku() { return $this->hasMany(Buku::class); }
}