@extends('layouts.app')
@section('title', 'Keranjang')
@section('page-title', 'Keranjang')

@push('styles')
<style>
.keranjang-card{background:#fff;border:1px solid var(--gray-200);border-radius:14px;box-shadow:var(--shadow);}
.keranjang-header{padding:16px 20px;border-bottom:1px solid var(--gray-100);display:flex;align-items:center;gap:10px;}
.keranjang-header h2{font-size:15px;font-weight:700;}
.k-count{background:var(--green-light);color:var(--green-dark);padding:2px 10px;border-radius:20px;font-size:12px;font-weight:600;}
.keranjang-item{display:flex;align-items:center;gap:14px;padding:16px 20px;border-bottom:1px solid var(--gray-100);}
.keranjang-item:last-of-type{border-bottom:none;}
.item-emoji{width:52px;height:52px;background:var(--green-light);border-radius:10px;display:grid;place-items:center;font-size:28px;flex-shrink:0;}
.item-info{flex:1;}
.item-info strong{display:block;font-size:14px;font-weight:600;margin-bottom:2px;}
.item-info span{font-size:12px;color:var(--gray-500);}
.qty-control{display:flex;align-items:center;gap:10px;}
.qty-btn{width:30px;height:30px;border:1.5px solid var(--gray-200);border-radius:6px;background:#fff;cursor:pointer;font-size:16px;display:grid;place-items:center;font-family:inherit;transition:all .15s;}
.qty-btn:hover{background:var(--gray-100);}
.qty-val{font-size:14px;font-weight:700;min-width:20px;text-align:center;}
.item-price{font-size:14px;font-weight:700;min-width:80px;text-align:right;}
.btn-del{background:none;border:none;cursor:pointer;font-size:18px;padding:4px;color:var(--gray-400);transition:color .15s;}
.btn-del:hover{color:var(--red);}
.summary-box{background:#fff;border:1px solid var(--gray-200);border-radius:14px;padding:20px;box-shadow:var(--shadow);margin-top:16px;}
.summary-row{display:flex;justify-content:space-between;padding:7px 0;font-size:13.5px;color:var(--gray-700);}
.summary-divider{height:1px;background:var(--gray-200);margin:8px 0;}
.summary-total{display:flex;justify-content:space-between;font-size:16px;font-weight:700;padding:4px 0;}
.summary-total span:last-child{color:var(--green-dark);}
.btn-checkout{width:100%;padding:13px;background:var(--gray-900);color:#fff;border:none;border-radius:10px;font-size:14px;font-weight:700;cursor:pointer;font-family:inherit;margin-top:16px;transition:background .15s;display:flex;align-items:center;justify-content:center;gap:8px;text-decoration:none;}
.btn-checkout:hover{background:#1f2937;}
</style>
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
        <div class="item-emoji">{{ $item->produk->emoji }}</div>
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
