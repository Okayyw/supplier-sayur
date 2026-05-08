<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $fillable = [
        'nomor_pesanan','user_id','subtotal','biaya_pengiriman','biaya_admin','total',
        'metode_pembayaran','nama_penerima','nomor_telepon_pengiriman',
        'alamat_pengiriman','catatan','status','status_pembayaran',
    ];

    public function user()      { return $this->belongsTo(User::class); }
    public function items()     { return $this->hasMany(PesananItem::class); }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'menunggu'   => 'Menunggu',
            'diproses'   => 'Diproses',
            'dikirim'    => 'Dikirim',
            'selesai'    => 'Selesai',
            'dibatalkan' => 'Dibatalkan',
            default      => ucfirst($this->status),
        };
    }

    public function getMetodeLabelAttribute(): string
    {
        return match($this->metode_pembayaran) {
            'cod'             => 'COD (Bayar di Tempat)',
            'e_wallet'        => 'E-Wallet',
            'virtual_account' => 'Virtual Account',
            'transfer_bank'   => 'Transfer Bank',
            default           => $this->metode_pembayaran,
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'menunggu'   => 'yellow',
            'diproses'   => 'blue',
            'dikirim'    => 'purple',
            'selesai'    => 'green',
            'dibatalkan' => 'red',
            default      => 'gray',
        };
    }
}
