<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stok_masuk', function (Blueprint $table) {
            $table->id();
            $table->string('kode_stok_masuk')->unique()
                  ->comment('Format: STK-IN-20250601-001');
            $table->foreignId('buku_id')
                  ->constrained('buku')->restrictOnDelete();
            $table->foreignId('supplier_id')
                  ->constrained('supplier')->restrictOnDelete();
            $table->foreignId('user_id')
                  ->constrained('users')->restrictOnDelete()
                  ->comment('Admin yang mencatat stok masuk');
            $table->unsignedInteger('jumlah')
                  ->comment('Jumlah buku yang masuk');
            $table->decimal('harga_beli', 10, 2)->nullable()
                  ->comment('Harga beli per buku, null jika donasi');
            $table->decimal('total_harga_beli', 10, 2)->nullable()
                  ->comment('Total biaya pengadaan');
            $table->date('tanggal')
                  ->comment('Tanggal buku diterima di toko');
            $table->text('keterangan')->nullable()
                  ->comment('Kondisi kiriman, catatan dari supplier');
            $table->timestamp('created_at')->useCurrent();

            $table->index('buku_id');
            $table->index('supplier_id');
            $table->index('tanggal');
        });

        Schema::create('riwayat_stok', function (Blueprint $table) {
            $table->id();
            $table->foreignId('buku_id')
                  ->constrained('buku')->restrictOnDelete();
            $table->enum('jenis_perubahan', ['masuk', 'keluar', 'koreksi']);
            $table->unsignedInteger('jumlah')
                  ->comment('Jumlah perubahan, selalu positif');
            $table->unsignedInteger('stok_sebelum');
            $table->unsignedInteger('stok_sesudah');
            $table->unsignedBigInteger('referensi_id')->nullable()
                  ->comment('ID dari stok_masuk atau transaksi');
            $table->string('referensi_tipe')->nullable()
                  ->comment('Nama model referensi: StokMasuk atau Transaksi');
            $table->string('keterangan')->nullable();
            $table->foreignId('user_id')
                  ->constrained('users')->restrictOnDelete();
            $table->timestamp('created_at')->useCurrent();

            $table->index('buku_id');
            $table->index('jenis_perubahan');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('riwayat_stok');
        Schema::dropIfExists('stok_masuk');
    }
};
