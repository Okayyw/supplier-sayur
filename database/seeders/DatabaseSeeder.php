<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Produk;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'nama_toko'     => 'Supplier Sayur',
            'nama_pemilik'  => 'Admin Utama',
            'email'         => 'admin@supplier.com',
            'password'      => Hash::make('admin123'),
            'nomor_telepon' => '0800-0000-0000',
            'alamat'        => 'Jl. Pasar Induk No. 1, Jakarta',
            'role'          => 'admin',
        ]);

        // Customer demo
        User::create([
            'nama_toko'      => 'Toko Berkah',
            'nama_pemilik'   => 'Budi Santoso',
            'email'          => 'tokoberkah@email.com',
            'password'       => Hash::make('customer123'),
            'nomor_telepon'  => '0812-3456-7890',
            'alamat'         => 'Jl. Raya Bandung No. 123, Bandung, Jawa Barat 40111',
            'role'           => 'customer',
            'total_pesanan'  => 87,
            'total_pembelian'=> 18500000,
            'poin_loyalitas' => 1250,
        ]);

        User::create([
            'nama_toko'      => 'Toko Berkah',
            'nama_pemilik'   => 'Budi Santoso',
            'email'          => 'tokoberkah2@email.com',
            'password'       => Hash::make('berkah123'),
            'nomor_telepon'  => '0812-3456-7890',
            'alamat'         => 'Jl. Raya Bandung No. 123, Bandung, Jawa Barat 40111',
            'role'           => 'customer',
            'total_pesanan'  => 87,
            'total_pembelian'=> 18500000,
            'poin_loyalitas' => 1250,
        ]);
        // Produk
        $produks = [
            ['nama' => 'Tomat Segar',   'deskripsi' => 'Tomat merah segar pilihan',     'harga' => 8000,  'stok' => 150, 'kategori' => 'Buah',    'emoji' => '🍅'],
            ['nama' => 'Bayam Hijau',   'deskripsi' => 'Bayam hijau organik',            'harga' => 6000,  'stok' => 45,  'kategori' => 'Daun',    'emoji' => '🥬'],
            ['nama' => 'Wortel',        'deskripsi' => 'Wortel manis dari Lembang',      'harga' => 7500,  'stok' => 20,  'kategori' => 'Umbi',    'emoji' => '🥕'],
            ['nama' => 'Kentang',       'deskripsi' => 'Kentang berkualitas tinggi',     'harga' => 9000,  'stok' => 80,  'kategori' => 'Umbi',    'emoji' => '🥔'],
            ['nama' => 'Brokoli',       'deskripsi' => 'Brokoli segar dan bergizi',      'harga' => 12000, 'stok' => 30,  'kategori' => 'Kembang', 'emoji' => '🥦'],
            ['nama' => 'Kol',           'deskripsi' => 'Kol segar untuk masakan',        'harga' => 5000,  'stok' => 60,  'kategori' => 'Kembang', 'emoji' => '🥬'],
            ['nama' => 'Cabai Merah',   'deskripsi' => 'Cabai merah pedas pilihan',      'harga' => 35000, 'stok' => 25,  'kategori' => 'Buah',    'emoji' => '🌶️'],
            ['nama' => 'Bawang Merah',  'deskripsi' => 'Bawang merah lokal segar',       'harga' => 28000, 'stok' => 40,  'kategori' => 'Umbi',    'emoji' => '🧅'],
            ['nama' => 'Bawang Putih',  'deskripsi' => 'Bawang putih aromatik',          'harga' => 22000, 'stok' => 35,  'kategori' => 'Bumbu',   'emoji' => '🧄'],
            ['nama' => 'Kangkung',      'deskripsi' => 'Kangkung segar siap masak',      'harga' => 4000,  'stok' => 70,  'kategori' => 'Daun',    'emoji' => '🌿'],
            ['nama' => 'Terong',        'deskripsi' => 'Terong ungu segar berkualitas',  'harga' => 8000,  'stok' => 45,  'kategori' => 'Buah',    'emoji' => '🍆'],
            ['nama' => 'Jagung',        'deskripsi' => 'Jagung manis dari petani lokal', 'harga' => 5000,  'stok' => 90,  'kategori' => 'Biji',    'emoji' => '🌽'],
        ];

        foreach ($produks as $p) {
            Produk::create($p);
        }
    }
}