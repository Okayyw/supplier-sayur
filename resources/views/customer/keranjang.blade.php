@extends('layouts.app')
@section('title', 'Keranjang')
@section('page-title', 'Keranjang')

@push('styles')
    @vite('resources/css/customer-keranjang.css')
@endpush

@section('content')
@if($keranjangs->isEmpty())
<div class="keranjang-card" style="padding:60px 20px;text-align:center;">
    <div style="font-size:56px;margin-bottom:14px;">🛒</div>
    <h3 style="font-size:16px;font-weight:700;margin-bottom:6px;">Keranjang Kosong</h3>
    <p style="color:var(--gray-500);margin-bottom:20px;">Belum ada produk di keranjang Anda.</p>
    <a href="{{ route('katalog') }}" class="btn btn-green">🏪 Mulai Belanja</a>
</div>
@else
<div class="keranjang-card">
    <div class="keranjang-header">
        <span style="font-size:18px;">🛒</span>
        <h2>Keranjang Belanja</h2>
        <span class="k-count">{{ $keranjangs->count() }} Item</span>
    </div>
    @foreach($keranjangs as $item)
    <div class="keranjang-item">
        <div class="item-emoji">
            @if($item->produk->gambar)
                <img src="{{ asset('storage/' . $item->produk->gambar) }}" alt="{{ $item->produk->nama }}">
            @else
                {{ $item->produk->emoji }}
            @endif
        </div>
        <div class="item-info">
            <strong>{{ $item->produk->nama }}</strong>
            <span>Rp {{ number_format($item->produk->harga,0,',','.') }} / kg</span>
        </div>
        <div class="qty-control">
            <form method="POST" action="{{ route('keranjang.update',$item) }}">
                @csrf @method('PATCH')
                <input type="hidden" name="jumlah" value="{{ $item->jumlah-1 }}">
                <button type="submit" class="qty-btn" {{ $item->jumlah<=1?'disabled':'' }}>−</button>
            </form>
            <span class="qty-val">{{ $item->jumlah }}</span>
            <form method="POST" action="{{ route('keranjang.update',$item) }}">
                @csrf @method('PATCH')
                <input type="hidden" name="jumlah" value="{{ $item->jumlah+1 }}">
                <button type="submit" class="qty-btn">+</button>
            </form>
        </div>
        <div class="item-price">Rp {{ number_format($item->subtotal,0,',','.') }}</div>
        <form method="POST" action="{{ route('keranjang.hapus',$item) }}">
            @csrf @method('DELETE')
            <button type="submit" class="btn-del" onclick="return confirm('Hapus item ini?')">🗑️</button>
        </form>
    </div>
    @endforeach
</div>
<div class="summary-box">
    <div class="summary-row"><span>Subtotal</span><span>Rp {{ number_format($subtotal,0,',','.') }}</span></div>
    <div class="summary-row"><span>Biaya Pengiriman</span><span>Rp {{ number_format($biayaPengiriman,0,',','.') }}</span></div>
    <div class="summary-row"><span>Biaya Admin</span><span>Rp {{ number_format($biayaAdmin,0,',','.') }}</span></div>
    <div class="summary-divider"></div>
    <div class="summary-total"><span>Total</span><span>Rp {{ number_format($total,0,',','.') }}</span></div>
    <a href="{{ route('pembayaran') }}" class="btn-checkout">💳 Lanjut ke Pembayaran</a>
</div>
@endif
@endsection
