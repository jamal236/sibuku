<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $kategori = [
            [
                'nama_kategori' => 'Novel',
                'deskripsi'     => 'Buku fiksi berupa novel, roman, dan cerita panjang',
                'warna_label'   => '#6f42c1', // ungu
                'urutan_tampil' => 1,
            ],
            [
                'nama_kategori' => 'Buku Pelajaran',
                'deskripsi'     => 'Buku teks pelajaran SD, SMP, SMA, dan bimbel',
                'warna_label'   => '#0d6efd', // biru
                'urutan_tampil' => 2,
            ],
            [
                'nama_kategori' => 'Komik',
                'deskripsi'     => 'Komik lokal, manga Jepang, dan graphic novel',
                'warna_label'   => '#fd7e14', // oranye
                'urutan_tampil' => 3,
            ],
            [
                'nama_kategori' => 'Agama',
                'deskripsi'     => 'Buku keagamaan, tafsir, fiqih, motivasi islami',
                'warna_label'   => '#198754', // hijau
                'urutan_tampil' => 4,
            ],
            [
                'nama_kategori' => 'Sains & Teknologi',
                'deskripsi'     => 'Buku sains, teknologi, komputer, dan pemrograman',
                'warna_label'   => '#0dcaf0', // cyan
                'urutan_tampil' => 5,
            ],
            [
                'nama_kategori' => 'Bisnis & Ekonomi',
                'deskripsi'     => 'Buku bisnis, ekonomi, manajemen, dan keuangan',
                'warna_label'   => '#ffc107', // kuning
                'urutan_tampil' => 6,
            ],
            [
                'nama_kategori' => 'Biografi & Sejarah',
                'deskripsi'     => 'Buku biografi tokoh dan sejarah',
                'warna_label'   => '#dc3545', // merah
                'urutan_tampil' => 7,
            ],
            [
                'nama_kategori' => 'Ensiklopedi & Referensi',
                'deskripsi'     => 'Ensiklopedi, kamus, atlas, dan buku referensi',
                'warna_label'   => '#6c757d', // abu
                'urutan_tampil' => 8,
            ],
            [
                'nama_kategori' => 'Anak-Anak',
                'deskripsi'     => 'Buku cerita anak, buku bergambar, dan dongeng',
                'warna_label'   => '#20c997', // teal
                'urutan_tampil' => 9,
            ],
            [
                'nama_kategori' => 'Majalah & Koran',
                'deskripsi'     => 'Majalah, tabloid, dan koran edisi lama',
                'warna_label'   => '#adb5bd', // abu muda
                'urutan_tampil' => 10,
            ],
            [
                'nama_kategori' => 'Lainnya',
                'deskripsi'     => 'Kategori umum untuk buku yang tidak masuk kategori lain',
                'warna_label'   => '#495057', // abu gelap
                'urutan_tampil' => 99,
            ],
        ];

        foreach ($kategori as $data) {
            Kategori::firstOrCreate(
                ['nama_kategori' => $data['nama_kategori']],
                $data
            );
        }

        $this->command->info('Kategori buku berhasil dibuat: ' . count($kategori) . ' kategori.');
    }
}
