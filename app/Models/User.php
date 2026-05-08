<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nama_toko',
        'nama_pemilik',
        'email',
        'password',
        'nomor_telepon',
        'alamat',
        'role',
        'total_pesanan',
        'total_pembelian',
        'poin_loyalitas',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function keranjangs()
    {
        return $this->hasMany(Keranjang::class);
    }

    public function pesanans()
    {
        return $this->hasMany(Pesanan::class);
    }

    public function getInisialAttribute(): string
    {
        $words = explode(' ', $this->nama_toko);
        $inisial = '';
        foreach (array_slice($words, 0, 2) as $word) {
            $inisial .= strtoupper(substr($word, 0, 1));
        }
        return $inisial ?: 'TB';
    }
}