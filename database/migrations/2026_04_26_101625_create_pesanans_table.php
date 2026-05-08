<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pesanans', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_pesanan')->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->bigInteger('subtotal');
            $table->bigInteger('biaya_pengiriman')->default(15000);
            $table->bigInteger('biaya_admin')->default(2500);
            $table->bigInteger('total');
            $table->enum('metode_pembayaran', ['cod', 'e_wallet', 'virtual_account'])->default('cod');
            $table->string('nama_penerima')->nullable();
            $table->string('nomor_telepon_pengiriman')->nullable();
            $table->text('alamat_pengiriman')->nullable();
            $table->text('catatan')->nullable();
            $table->enum('status', ['menunggu','diproses','dikirim','selesai','dibatalkan'])->default('menunggu');
            $table->enum('status_pembayaran', ['belum_bayar','sudah_bayar'])->default('belum_bayar');
            $table->timestamps();
        });

        Schema::create('pesanan_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pesanan_id')->constrained('pesanans')->onDelete('cascade');
            $table->foreignId('produk_id')->constrained('produks')->onDelete('cascade');
            $table->string('nama_produk');
            $table->string('emoji_produk')->default('🥬');
            $table->bigInteger('harga');
            $table->integer('jumlah');
            $table->bigInteger('subtotal');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pesanan_items');
        Schema::dropIfExists('pesanans');
    }
};
