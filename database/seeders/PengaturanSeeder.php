<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pengaturan;

class PengaturanSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // Grup: toko
            [
                'key'   => 'toko_nama',
                'value' => 'SiBuku',
                'label' => 'Nama Toko',
                'group' => 'toko',
            ],
            [
                'key'   => 'toko_alamat',
                'value' => 'Jl. Siliwangi No. 1, Cirebon',
                'label' => 'Alamat Toko',
                'group' => 'toko',
            ],
            [
                'key'   => 'toko_telepon',
                'value' => '0231-000000',
                'label' => 'Nomor Telepon Toko',
                'group' => 'toko',
            ],
            [
                'key'   => 'toko_email',
                'value' => 'info@sibuku.com',
                'label' => 'Email Toko',
                'group' => 'toko',
            ],
            [
                'key'   => 'toko_logo',
                'value' => null,
                'label' => 'Logo Toko (path file)',
                'group' => 'toko',
            ],
            // Grup: nota
            [
                'key'   => 'nota_pesan',
                'value' => 'Terima kasih telah berbelanja di SiBuku !',
                'label' => 'Pesan di Nota',
                'group' => 'nota',
            ],
            [
                'key'   => 'nota_tampilkan_logo',
                'value' => '1',
                'label' => 'Tampilkan Logo di Nota',
                'group' => 'nota',
            ],
            // Grup: sistem
            [
                'key'   => 'stok_minimum_default',
                'value' => '1',
                'label' => 'Batas Minimum Stok Default',
                'group' => 'sistem',
            ],
        ];

        foreach ($settings as $setting) {
            Pengaturan::firstOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }

        $this->command->info('Pengaturan toko default berhasil dibuat.');
    }
}
