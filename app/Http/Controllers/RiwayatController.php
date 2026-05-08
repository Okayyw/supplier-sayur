<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Support\Facades\Auth;

class RiwayatController extends Controller
{
    public function index()
    {
        $pesanans = Pesanan::where('user_id', Auth::id())
            ->with('items')
            ->latest()
            ->get();

        return view('customer.riwayat', compact('pesanans'));
    }

    public function show(Pesanan $pesanan)
    {
        if ($pesanan->user_id !== Auth::id()) abort(403);
        $pesanan->load('items.produk');
        return view('customer.riwayat-detail', compact('pesanan'));
    }
}
