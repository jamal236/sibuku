<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('buku', function (Blueprint $table) {
            $table->id();
            $table->string('kode_buku')->unique()
                  ->comment('Format: BKU-00001, digenerate otomatis');
            $table->string('judul');
            $table->string('pengarang');
            $table->string('penerbit')->nullable();
            $table->year('tahun_terbit')->nullable();
            $table->string('isbn', 20)->nullable();
            $table->foreignId('kategori_id')->constrained('kategori')
                  ->restrictOnDelete();
            $table->enum('kondisi', [
                'baru',
                'sangat_baik',
                'baik',
                'cukup',
                'rusak_ringan',
            ])->default('baik');
            $table->text('deskripsi_kondisi')->nullable()
                  ->comment('Catatan kondisi fisik detail, misal: ada coretan di halaman 5');
            $table->decimal('harga', 10, 2);
            $table->unsignedInteger('stok')->default(0);
            $table->unsignedInteger('stok_minimum')->default(1)
                  ->comment('Batas bawah untuk peringatan stok rendah');
            $table->string('lokasi_rak')->nullable()
                  ->comment('Nomor atau kode rak tempat buku disimpan');
            $table->string('foto')->nullable()
                  ->comment('Path file foto sampul buku');
            $table->boolean('is_aktif')->default(true);
            $table->foreignId('created_by')->constrained('users')
                  ->restrictOnDelete();
            $table->timestamps();

            // Index untuk mempercepat filter dan pencarian
            $table->index('kategori_id');
            $table->index('kondisi');
            $table->index('is_aktif');
            $table->index(['judul', 'pengarang']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('buku');
    }
};
