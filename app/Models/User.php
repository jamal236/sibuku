<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = ['name', 'email', 'password', 'is_aktif', 'last_login_at'];
    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login_at' => 'datetime',
            'password' => 'hashed',
            'is_aktif' => 'boolean',
        ];
    }

    // Relasi
    public function bukuDibuat() { return $this->hasMany(Buku::class, 'created_by'); }
    public function pelangganDibuat() { return $this->hasMany(Pelanggan::class, 'created_by'); }
    public function transaksi() { return $this->hasMany(Transaksi::class); }
    public function stokMasuk() { return $this->hasMany(StokMasuk::class); }
}