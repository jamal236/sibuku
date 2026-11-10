<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('riwayat_stok', function (Blueprint $table) {
            // Tambahkan kolom stok_masuk_id (nullable karena data lama mungkin tidak punya)
            $table->unsignedBigInteger('stok_masuk_id')->nullable()->after('user_id');
            
            // Tambahkan foreign key ke tabel stok_masuk
            $table->foreign('stok_masuk_id')
                  ->references('id')
                  ->on('stok_masuk')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('riwayat_stok', function (Blueprint $table) {
            $table->dropForeign(['stok_masuk_id']);
            $table->dropColumn('stok_masuk_id');
        });
    }
};