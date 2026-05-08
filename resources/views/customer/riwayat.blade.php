@extends('layouts.app')
@section('title', 'Riwayat Pesanan')
@section('page-title', 'Riwayat')

@push('styles')
<style>
.pesanan-card{background:#fff;border:1px solid var(--gray-200);border-radius:14px;margin-bottom:14px;box-shadow:var(--shadow);overflow:hidden;}
.p-header{display:flex;align-items:flex-start;justify-content:space-between;padding:16px 20px;border-bottom:1px solid var(--gray-100);gap:12px;flex-wrap:wrap;}
.p-no{font-size:14px;font-weight:700;}
.p-date{font-size:12px;color:var(--gray-500);margin-top:2px;}
.p-body{padding:14px 20px;}
.p-items{display:flex;gap:8px;flex-wrap:wrap;margin-bottom:12px;}
.p-item-chip{display:flex;align-items:center;gap:5px;background:var(--gray-50);border-radius:8px;padding:4px 10px;font-size:12.5px;}
.p-footer{display:flex;justify-content:space-between;align-items:center;padding-top:12px;border-top:1px solid var(--gray-100);flex-wrap:wrap;gap:8px;}
.p-total{font-size:15px;font-weight:700;color:var(--green-dark);}
.p-count{font-size:12.5px;color:var(--gray-500);margin-bottom:4px;}
.status-badge{display:inline-flex;align-items:center;gap:4px;padding:4px 12px;border-radius:20px;font-size:12px;font-weight:600;}
.s-menunggu{background:#fef3c7;color:#d97706;}
.s-diproses{background:#dbeafe;color:#2563eb;}
.s-dikirim{background:#ede9fe;color:#7c3aed;}
.s-selesai{background:var(--green-light);color:var(--green-dark);}
.s-dibatalkan{background:#fee2e2;color:#dc2626;}
.btn-actions{display:flex;gap:8px;}
.empty-state{text-align:center;padding:60px 20px;color:var(--gray-500);}
</style>
@endpush

@section('content')
@if($pesanans->isEmpty())
<div class="empty-state">
    <div style="font-size:56px;margin-bottom:14px;">📦</div>
    <h3 style="font-size:16px;font-weight:700;margin-bottom:6px;">Belum Ada Pesanan</h3>
    <p style="margin-bottom:20px;">Mulai belanja dan pesanan Anda akan muncul di sini.</p>
    <a href="{{ route('katalog') }}" class="btn btn-green">🏪 Mulai Belanja</a>
</div>
@else
@foreach($pesanans as $pesanan)
<div class="pesanan-card">
    <div class="p-header">
        <div>
            <div class="p-no">{{ $pesanan->nomor_pesanan }}</div>
            <div class="p-date">{{ \Carbon\Carbon::parse($pesanan->created_at)->translatedFormat('l, d F Y') }}</div>
        </div>
        <span class="status-badge s-{{ $pesanan->status }}">
            @php $icon = match($pesanan->status){ 'menunggu'=>'⏳','diproses'=>'🔄','dikirim'=>'🚚','selesai'=>'✅','dibatalkan'=>'❌',default=>'•' }; @endphp
            {{ $icon }} {{ $pesanan->status_label }}
        </span>
    </div>
    <div class="p-body">
        <div class="p-count">{{ $pesanan->items->count() }} item</div>
        <div class="p-items">
            @foreach($pesanan->items as $item)
            <div class="p-item-chip">{{ $item->emoji_produk }} {{ $item->nama_produk }}</div>
            @endforeach
        </div>
        <div class="p-footer">
            <div class="p-total">Rp {{ number_format($pesanan->total,0,',','.') }}</div>
            <div class="btn-actions">
                <a href="{{ route('riwayat.show',$pesanan) }}" class="btn btn-outline btn-sm">Lihat Detail</a>
                <form method="POST" action="{{ route('keranjang.pesan_lagi') }}">
                    @csrf
                    <input type="hidden" name="pesanan_id" value="{{ $pesanan->id }}">
                    <button type="submit" class="btn btn-primary btn-sm">Pesan Lagi</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
@endif
@endsection
