<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('supplier', function (Blueprint $table) {
            $table->id();
            $table->string('kode_supplier')->unique()
                  ->comment('Format: SUP-001');
            $table->string('nama');
            $table->enum('jenis', ['supplier', 'donatur'])->default('supplier')
                  ->comment('Supplier = buku dibeli/dibayar, Donatur = buku diberikan gratis');
            $table->string('telepon', 20)->nullable();
            $table->string('email')->nullable();
            $table->text('alamat')->nullable();
            $table->text('keterangan')->nullable()
                  ->comment('Catatan tentang jenis buku yang biasa disuplai');
            $table->boolean('is_aktif')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('supplier');
    }
};
