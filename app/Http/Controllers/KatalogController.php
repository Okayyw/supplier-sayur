<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class KatalogController extends Controller
{
    public function index(Request $request)
    {
        $query = Produk::aktif();

        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('kategori') && $request->kategori !== 'Semua') {
            $query->where('kategori', $request->kategori);
        }

        $produks   = $query->orderBy('nama')->get();
        $kategoris = ['Semua', 'Buah', 'Daun', 'Umbi', 'Kembang', 'Bumbu', 'Biji'];

        return view('customer.katalog', compact('produks', 'kategoris'));
    }
}