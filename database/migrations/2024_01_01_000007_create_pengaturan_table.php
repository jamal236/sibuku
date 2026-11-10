<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengaturan', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique()
                  ->comment('Nama konfigurasi, misal: toko_nama, toko_alamat');
            $table->text('value')->nullable();
            $table->string('label')
                  ->comment('Label yang ditampilkan di form pengaturan');
            $table->string('group')->default('umum')
                  ->comment('Pengelompokan pengaturan: umum, toko, nota');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengaturan');
    }
};
