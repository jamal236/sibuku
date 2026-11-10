<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pelanggan', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pelanggan')->unique()
                  ->comment('Format: PLG-00001, digenerate otomatis');
            $table->string('nama');
            $table->string('telepon', 20)->nullable();
            $table->string('email')->nullable();
            $table->text('alamat')->nullable();
            $table->date('tanggal_lahir')->nullable()
                  ->comment('Untuk kebutuhan program loyalitas di masa depan');
            $table->text('catatan')->nullable()
                  ->comment('Misal: sering cari buku fisika, langganan genre horor');
            $table->foreignId('created_by')->constrained('users')
                  ->restrictOnDelete();
            $table->timestamps();

            $table->index('nama');
            $table->index('telepon');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pelanggan');
    }
};
