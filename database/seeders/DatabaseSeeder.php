<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,      // 1. Buat role: admin, kasir, owner
            UserSeeder::class,      // 2. Buat akun default per role
            KategoriSeeder::class,  // 3. Isi kategori buku default
            PengaturanSeeder::class,// 4. Isi konfigurasi toko default
        ]);
    }
}
