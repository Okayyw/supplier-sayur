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
        Schema::table('pesanan_items', function (Blueprint $table) {
            $table->string('gambar_produk')->nullable()->after('emoji_produk');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pesanan_items', function (Blueprint $table) {
            $table->dropColumn('gambar_produk');
        });
    }
};
