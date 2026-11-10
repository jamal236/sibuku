<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // -------------------------------------------------------
        // Akun Admin
        // -------------------------------------------------------
        $admin = User::firstOrCreate(
            ['email' => 'admin@sibuku.com'],
            [
                'name'     => 'Administrator',
                'password' => Hash::make('admin123'),
                'is_aktif' => true,
            ]
        );
        $admin->assignRole('admin');

        // -------------------------------------------------------
        // Akun Kasir
        // -------------------------------------------------------
        $kasir = User::firstOrCreate(
            ['email' => 'kasir@sibuku.com'],
            [
                'name'     => 'Kasir 1',
                'password' => Hash::make('kasir123'),
                'is_aktif' => true,
            ]
        );
        $kasir->assignRole('kasir');

        // -------------------------------------------------------
        // Akun Owner
        // -------------------------------------------------------
        $owner = User::firstOrCreate(
            ['email' => 'owner@sibuku.com'],
            [
                'name'     => 'Pemilik Toko',
                'password' => Hash::make('owner123'),
                'is_aktif' => true,
            ]
        );
        $owner->assignRole('owner');

        $this->command->info('Akun default berhasil dibuat:');
        $this->command->table(
            ['Role', 'Email', 'Password'],
            [
                ['Admin', 'admin@sibuku.com', 'admin123'],
                ['Kasir', 'kasir@sibuku.com', 'kasir123'],
                ['Owner', 'owner@sibuku.com', 'owner123'],
            ]
        );
        $this->command->warn('Segera ganti password setelah login pertama!');
    }
}
