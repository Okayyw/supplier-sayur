@extends('layouts.app')
@section('title', 'Riwayat Pesanan')
@section('page-title', 'Riwayat')

@push('styles')
    @vite('resources/css/customer-riwayat.css')
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
            <div class="p-item-chip">
                @if($item->gambar_produk)
                    <img src="{{ asset('storage/' . $item->gambar_produk) }}" alt="{{ $item->nama_produk }}">
                @else
                    {{ $item->emoji_produk }}
                @endif
                {{ $item->nama_produk }}
            </div>
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
