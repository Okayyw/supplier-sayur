<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nama_toko');
            $table->string('nama_pemilik');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('nomor_telepon')->nullable();
            $table->text('alamat')->nullable();
            $table->enum('role', ['customer', 'admin'])->default('customer');
            $table->integer('total_pesanan')->default(0);
            $table->bigInteger('total_pembelian')->default(0);
            $table->integer('poin_loyalitas')->default(0);
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};