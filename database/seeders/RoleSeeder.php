<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // -------------------------------------------------------
        // Daftar semua permission yang ada di sistem
        // -------------------------------------------------------
        $permissions = [
            // Buku
            'buku.lihat',
            'buku.tambah',
            'buku.edit',
            'buku.hapus',

            // Kategori
            'kategori.lihat',
            'kategori.kelola',

            // Transaksi
            'transaksi.proses',
            'transaksi.lihat-semua',
            'transaksi.lihat-sendiri',
            'transaksi.batal',

            // Pelanggan
            'pelanggan.lihat',
            'pelanggan.tambah',
            'pelanggan.edit',

            // Supplier
            'supplier.lihat',
            'supplier.kelola',

            // Stok
            'stok.lihat',
            'stok.catat-masuk',
            'stok.koreksi',

            // Laporan
            'laporan.lihat',
            'laporan.ekspor',
            'laporan.per-kasir',

            // User
            'user.kelola',

            // Pengaturan
            'pengaturan.kelola',
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm, 'guard_name' => 'web']);
        }

        // -------------------------------------------------------
        // Role: Admin — akses penuh
        // -------------------------------------------------------
        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $admin->syncPermissions($permissions); // semua permission

        // -------------------------------------------------------
        // Role: Kasir — hanya operasional kasir
        // -------------------------------------------------------
        $kasir = Role::firstOrCreate(['name' => 'kasir', 'guard_name' => 'web']);
        $kasir->syncPermissions([
            'buku.lihat',
            'transaksi.proses',
            'transaksi.lihat-sendiri',
            'pelanggan.lihat',
            'pelanggan.tambah',
            'stok.lihat',
        ]);

        // -------------------------------------------------------
        // Role: Owner — hanya monitoring dan laporan, tanpa input
        // -------------------------------------------------------
        $owner = Role::firstOrCreate(['name' => 'owner', 'guard_name' => 'web']);
        $owner->syncPermissions([
            'buku.lihat',
            'transaksi.lihat-semua',
            'pelanggan.lihat',
            'supplier.lihat',
            'stok.lihat',
            'laporan.lihat',
            'laporan.ekspor',
            'laporan.per-kasir',
        ]);

        $this->command->info('Roles dan permissions berhasil dibuat.');
    }
}
