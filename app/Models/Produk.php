<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $fillable = [
        'nama', 'deskripsi', 'harga', 'stok', 'kategori', 'emoji', 'aktif'
    ];
 
    protected $casts = [
        'aktif' => 'boolean',
    ];
 
    public function keranjangs()
    {
        return $this->hasMany(Keranjang::class);
    }
 
    public function getHargaFormatAttribute(): string
    {
        return 'Rp ' . number_format($this->harga, 0, ',', '.');
    }
 
    public function scopeAktif($query)
    {
        return $query->where('aktif', true);
    }
 
    public function scopeKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }
}
