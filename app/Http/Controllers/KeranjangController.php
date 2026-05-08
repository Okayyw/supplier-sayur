<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeranjangController extends Controller
{
    public function index()
    {
        $keranjangs      = Auth::user()->keranjangs()->with('produk')->get();
        $subtotal        = $keranjangs->sum('subtotal');
        $biayaPengiriman = 15000;
        $biayaAdmin      = 2500;
        $total           = $subtotal + $biayaPengiriman + $biayaAdmin;

        return view('customer.keranjang', compact('keranjangs','subtotal','biayaPengiriman','biayaAdmin','total'));
    }

    public function tambah(Request $request)
    {
        $request->validate(['produk_id' => 'required|exists:produks,id']);
        $produk = Produk::findOrFail($request->produk_id);

        if ($produk->stok <= 0) {
            return back()->with('error', 'Stok produk habis.');
        }

        $keranjang = Keranjang::where('user_id', Auth::id())
            ->where('produk_id', $produk->id)->first();

        if ($keranjang) {
            if ($keranjang->jumlah >= $produk->stok) {
                return back()->with('error', 'Jumlah melebihi stok tersedia.');
            }
            $keranjang->increment('jumlah');
        } else {
            Keranjang::create(['user_id' => Auth::id(), 'produk_id' => $produk->id, 'jumlah' => 1]);
        }

        return back()->with('success', $produk->nama . ' ditambahkan ke keranjang.');
    }

    public function update(Request $request, Keranjang $keranjang)
    {
        if ($keranjang->user_id !== Auth::id()) abort(403);
        $request->validate(['jumlah' => 'required|integer|min:1']);
        if ($request->jumlah > $keranjang->produk->stok) {
            return back()->with('error', 'Jumlah melebihi stok.');
        }
        $keranjang->update(['jumlah' => $request->jumlah]);
        return back()->with('success', 'Keranjang diperbarui.');
    }

    public function hapus(Keranjang $keranjang)
    {
        if ($keranjang->user_id !== Auth::id()) abort(403);
        $keranjang->delete();
        return back()->with('success', 'Item dihapus dari keranjang.');
    }

    /** Tambah ulang item dari pesanan lama ke keranjang */
    public function pesanLagi(Request $request)
    {
        $request->validate(['pesanan_id' => 'required|exists:pesanans,id']);
        $pesanan = \App\Models\Pesanan::where('id', $request->pesanan_id)
            ->where('user_id', Auth::id())
            ->with('items.produk')
            ->firstOrFail();

        $ditambahkan = 0;
        foreach ($pesanan->items as $item) {
            if (!$item->produk || $item->produk->stok <= 0) continue;
            $existing = Keranjang::where('user_id', Auth::id())
                ->where('produk_id', $item->produk_id)->first();
            if ($existing) {
                $existing->increment('jumlah');
            } else {
                Keranjang::create([
                    'user_id'   => Auth::id(),
                    'produk_id' => $item->produk_id,
                    'jumlah'    => 1,
                ]);
            }
            $ditambahkan++;
        }

        return redirect()->route('keranjang')
            ->with('success', $ditambahkan . ' produk berhasil ditambahkan ke keranjang.');
    }
}
