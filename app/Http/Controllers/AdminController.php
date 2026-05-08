<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\User;
use App\Models\Pesanan;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalProduk   = Produk::count();
        $totalCustomer = User::where('role', 'customer')->count();
        $totalPesanan  = Pesanan::count();
        $totalPendapatan = Pesanan::where('status', 'selesai')->sum('total');
        $pesananTerbaru = Pesanan::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalProduk', 'totalCustomer', 'totalPesanan',
            'totalPendapatan', 'pesananTerbaru'
        ));
    }

    // ─── PRODUK ───────────────────────────────────────────────
    public function produkIndex()
    {
        $produks = Produk::latest()->get();
        return view('admin.produk.index', compact('produks'));
    }

    public function produkCreate()
    {
        $kategoris = ['Buah', 'Daun', 'Umbi', 'Kembang', 'Bumbu', 'Biji'];
        return view('admin.produk.create', compact('kategoris'));
    }

    public function produkStore(Request $request)
    {
        $request->validate([
            'nama'      => 'required|string|max:255',
            'harga'     => 'required|integer|min:0',
            'stok'      => 'required|integer|min:0',
            'kategori'  => 'required|in:Buah,Daun,Umbi,Kembang,Bumbu,Biji',
            'emoji'     => 'required|string',
            'deskripsi' => 'nullable|string',
        ]);

        Produk::create($request->all());
        return redirect()->route('admin.produk')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function produkEdit(Produk $produk)
    {
        $kategoris = ['Buah', 'Daun', 'Umbi', 'Kembang', 'Bumbu', 'Biji'];
        return view('admin.produk.edit', compact('produk', 'kategoris'));
    }

    public function produkUpdate(Request $request, Produk $produk)
    {
        $request->validate([
            'nama'      => 'required|string|max:255',
            'harga'     => 'required|integer|min:0',
            'stok'      => 'required|integer|min:0',
            'kategori'  => 'required|in:Buah,Daun,Umbi,Kembang,Bumbu,Biji',
            'emoji'     => 'required|string',
            'deskripsi' => 'nullable|string',
        ]);

        $produk->update($request->all());
        return redirect()->route('admin.produk')->with('success', 'Produk berhasil diperbarui.');
    }

    public function produkDestroy(Produk $produk)
    {
        $produk->delete();
        return back()->with('success', 'Produk berhasil dihapus.');
    }

    // ─── PESANAN ──────────────────────────────────────────────
    public function pesananIndex()
    {
        $pesanans = Pesanan::with('user')->latest()->get();
        return view('admin.pesanan.index', compact('pesanans'));
    }

    public function pesananShow(Pesanan $pesanan)
    {
        $pesanan->load('items.produk', 'user');
        return view('admin.pesanan.show', compact('pesanan'));
    }

    public function pesananUpdateStatus(Request $request, Pesanan $pesanan)
    {
        $request->validate(['status' => 'required|in:menunggu,diproses,dikirim,selesai,dibatalkan']);
        $pesanan->update(['status' => $request->status]);
        return back()->with('success', 'Status pesanan diperbarui.');
    }

    // ─── CUSTOMERS ────────────────────────────────────────────
    public function customerIndex()
    {
        $customers = User::where('role', 'customer')->latest()->get();
        return view('admin.customer.index', compact('customers'));
    }
}