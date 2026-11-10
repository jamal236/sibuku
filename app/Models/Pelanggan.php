<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $table = 'pelanggan'; // ← TAMBAHKAN INI
    
    protected $fillable = ['kode_pelanggan', 'nama', 'telepon', 'email', 'alamat', 'tanggal_lahir', 'catatan', 'created_by'];
    protected $casts = ['tanggal_lahir' => 'date'];
    
    public function creator() { return $this->belongsTo(User::class, 'created_by'); }
    public function transaksi() { return $this->hasMany(Transaksi::class); }
}