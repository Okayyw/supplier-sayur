<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PesananItem extends Model
{
    protected $table = 'pesanan_items';
    protected $fillable = [
        'pesanan_id','produk_id','nama_produk','emoji_produk','gambar_produk','harga','jumlah','subtotal'
    ];

    public function pesanan() { return $this->belongsTo(Pesanan::class); }
    public function produk()  { return $this->belongsTo(Produk::class); }
}
