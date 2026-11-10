<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $table = 'supplier'; // ← TAMBAHKAN INI
    
    protected $fillable = ['kode_supplier', 'nama', 'jenis', 'telepon', 'email', 'alamat', 'keterangan', 'is_aktif'];
    protected $casts = ['is_aktif' => 'boolean'];
    
    public function stokMasuk() { return $this->hasMany(StokMasuk::class); }
}