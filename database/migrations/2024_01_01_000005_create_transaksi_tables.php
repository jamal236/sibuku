<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->string('kode_transaksi')->unique()
                  ->comment('Format: TRX-20250601-001');
            $table->foreignId('pelanggan_id')->nullable()
                  ->constrained('pelanggan')->nullOnDelete()
                  ->comment('Nullable: transaksi bisa tanpa data pelanggan');
            $table->foreignId('user_id')
                  ->constrained('users')->restrictOnDelete()
                  ->comment('Kasir yang memproses transaksi');
            $table->decimal('total', 10, 2)
                  ->comment('Total sebelum diskon');
            $table->decimal('diskon', 10, 2)->default(0);
            $table->decimal('total_setelah_diskon', 10, 2)
                  ->comment('Total yang harus dibayar');
            $table->decimal('bayar', 10, 2)
                  ->comment('Jumlah uang yang diberikan pelanggan');
            $table->decimal('kembalian', 10, 2)
                  ->comment('Uang kembalian untuk pelanggan');
            $table->enum('metode_bayar', ['tunai', 'transfer', 'qris'])
                  ->default('tunai');
            $table->enum('status', ['selesai', 'dibatalkan'])
                  ->default('selesai');
            $table->text('alasan_batal')->nullable()
                  ->comment('Wajib diisi jika status dibatalkan');
            $table->text('catatan')->nullable();
            $table->date('tanggal');
            $table->timestamps();

            $table->index('kode_transaksi');
            $table->index('tanggal');
            $table->index('user_id');
            $table->index('status');
        });

        Schema::create('detail_transaksi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaksi_id')
                  ->constrained('transaksi')->cascadeOnDelete();
            $table->foreignId('buku_id')
                  ->constrained('buku')->restrictOnDelete();
            $table->string('judul_snapshot')
                  ->comment('Salinan judul buku saat transaksi, untuk integritas laporan');
            $table->string('kondisi_snapshot')
                  ->comment('Salinan kondisi buku saat transaksi');
            $table->unsignedInteger('jumlah')
                  ->comment('Jumlah eksemplar yang dibeli');
            $table->decimal('harga_satuan', 10, 2)
                  ->comment('Harga per buku saat transaksi terjadi');
            $table->decimal('diskon_item', 10, 2)->default(0);
            $table->decimal('subtotal', 10, 2)
                  ->comment('jumlah × harga_satuan − diskon_item');
            $table->timestamp('created_at')->useCurrent();

            $table->index('transaksi_id');
            $table->index('buku_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_transaksi');
        Schema::dropIfExists('transaksi');
    }
};
