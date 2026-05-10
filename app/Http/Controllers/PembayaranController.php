<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\Pesanan;
use App\Models\PesananItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PembayaranController extends Controller
{
    /** Halaman form pembayaran */
    public function index()
    {
        $user       = Auth::user();
        $keranjangs = $user->keranjangs()->with('produk')->get();

        if ($keranjangs->isEmpty()) {
            return redirect()->route('keranjang')->with('error', 'Keranjang kosong.');
        }

        $subtotal        = $keranjangs->sum('subtotal');
        $biayaPengiriman = 15000;
        $biayaAdmin      = 2500;
        $total           = $subtotal + $biayaPengiriman + $biayaAdmin;

        return view('customer.pembayaran', compact(
            'keranjangs','subtotal','biayaPengiriman','biayaAdmin','total','user'
        ));
    }

    /** Proses pembayaran → buat pesanan */
    public function proses(Request $request)
    {
        $request->validate([
            'nama_penerima'   => 'required|string|max:255',
            'nomor_telepon'   => 'required|string|max:20',
            'alamat'          => 'required|string',
            'metode'          => 'required|in:cod,e_wallet,virtual_account,transfer_bank',
            'catatan'         => 'nullable|string|max:500',
        ], [
            'nama_penerima.required' => 'Nama penerima wajib diisi.',
            'nomor_telepon.required' => 'Nomor telepon wajib diisi.',
            'alamat.required'        => 'Alamat pengiriman wajib diisi.',
            'metode.required'        => 'Pilih metode pembayaran.',
        ]);

        $user       = Auth::user();
        $keranjangs = $user->keranjangs()->with('produk')->get();

        if ($keranjangs->isEmpty()) {
            return redirect()->route('keranjang')->with('error', 'Keranjang kosong.');
        }

        $subtotal        = $keranjangs->sum('subtotal');
        $biayaPengiriman = 15000;
        $biayaAdmin      = 2500;
        $total           = $subtotal + $biayaPengiriman + $biayaAdmin;

        // Buat nomor pesanan unik: ORD-2026-XXX
        $nomorUrut = Pesanan::whereYear('created_at', now()->year)->count() + 1;
        $nomorPesanan = 'ORD-' . now()->year . '-' . str_pad($nomorUrut, 3, '0', STR_PAD_LEFT);

        $pesanan = Pesanan::create([
            'nomor_pesanan'              => $nomorPesanan,
            'user_id'                    => $user->id,
            'subtotal'                   => $subtotal,
            'biaya_pengiriman'           => $biayaPengiriman,
            'biaya_admin'                => $biayaAdmin,
            'total'                      => $total,
            'metode_pembayaran'          => $request->metode,
            'nama_penerima'              => $request->nama_penerima,
            'nomor_telepon_pengiriman'   => $request->nomor_telepon,
            'alamat_pengiriman'          => $request->alamat,
            'catatan'                    => $request->catatan,
            'status'                     => 'menunggu',
            'status_pembayaran'          => 'sudah_bayar',
        ]);

        foreach ($keranjangs as $item) {
            PesananItem::create([
                'pesanan_id'    => $pesanan->id,
                'produk_id'     => $item->produk_id,
                'nama_produk'   => $item->produk->nama,
                'emoji_produk'  => $item->produk->emoji,
                'gambar_produk' => $item->produk->gambar,
                'harga'         => $item->produk->harga,
                'jumlah'        => $item->jumlah,
                'subtotal'      => $item->subtotal,
            ]);
            $item->produk->decrement('stok', $item->jumlah);
        }

        $user->keranjangs()->delete();
        $user->increment('total_pesanan');
        $user->increment('total_pembelian', $total);
        $user->increment('poin_loyalitas', (int)($total / 10000));

        return redirect()->route('riwayat')->with('success',
            'Pesanan ' . $nomorPesanan . ' berhasil dibuat! Terima kasih.');
    }
}
