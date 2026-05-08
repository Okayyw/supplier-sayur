@extends('layouts.app')
@section('title', 'Detail Pesanan')
@section('page-title', 'Detail Pesanan')

@push('styles')
<style>
    .detail-grid{display:grid;grid-template-columns:1fr 320px;gap:18px;align-items:start;}
    .d-card{background:#fff;border:1px solid var(--gray-200);border-radius:14px;box-shadow:var(--shadow);margin-bottom:16px;overflow:hidden;}
    .d-header{padding:16px 20px;border-bottom:1px solid var(--gray-100);display:flex;align-items:flex-start;justify-content:space-between;gap:12px;}
    .d-header h2{font-size:15px;font-weight:700;}
    .d-header .sub{font-size:12px;color:var(--gray-500);margin-top:2px;}
    .d-body{padding:18px 20px;}
    .prod-item{display:flex;align-items:center;gap:12px;padding:12px 0;border-bottom:1px solid var(--gray-100);}
    .prod-item:last-child{border-bottom:none;}
    .prod-emoji{width:48px;height:48px;border-radius:10px;background:var(--green-light);display:grid;place-items:center;font-size:24px;flex-shrink:0;}
    .prod-info{flex:1;}
    .prod-info strong{display:block;font-size:13.5px;font-weight:600;}
    .prod-info span{font-size:12px;color:var(--gray-500);}
    .prod-price{font-size:13.5px;font-weight:700;}
    .info-row{display:flex;gap:10px;padding:10px 0;border-bottom:1px solid var(--gray-100);font-size:13.5px;}
    .info-row:last-child{border-bottom:none;}
    .info-icon{font-size:16px;flex-shrink:0;margin-top:1px;}
    .info-content strong{display:block;font-size:12px;color:var(--gray-500);font-weight:600;margin-bottom:2px;}
    .r-row{display:flex;justify-content:space-between;padding:6px 0;font-size:13.5px;color:var(--gray-700);}
    .r-total{display:flex;justify-content:space-between;font-size:16px;font-weight:700;padding:8px 0;color:var(--green-dark);}
    .status-badge{display:inline-flex;align-items:center;gap:4px;padding:4px 12px;border-radius:20px;font-size:12px;font-weight:600;}
    .s-menunggu{background:#fef3c7;color:#d97706;}
    .s-diproses{background:#dbeafe;color:#2563eb;}
    .s-dikirim{background:#ede9fe;color:#7c3aed;}
    .s-selesai{background:var(--green-light);color:var(--green-dark);}
    .s-dibatalkan{background:#fee2e2;color:#dc2626;}
    @media(max-width:768px){.detail-grid{grid-template-columns:1fr;}}
    </style>
    @endpush

    @section('content')
    <div style="display:flex;align-items:center;gap:12px;margin-bottom:18px;">
        <a href="{{ route('riwayat') }}" style="color:var(--gray-500);text-decoration:none;font-size:20px;line-height:1;">←</a>
        <div>
            <h2 style="font-size:17px;font-weight:700;">Detail Pesanan</h2>
            <p style="font-size:12px;color:var(--gray-500);">{{ $pesanan->nomor_pesanan }}</p>
        </div>
    </div>

    <div class="detail-grid">
        <!-- KIRI -->
        <div>
            <!-- Status & nomor pesanan -->
            <div class="d-card">
                <div class="d-header">
                    <div>
                        <h2>{{ $pesanan->nomor_pesanan }}</h2>
                        <div class="sub">{{ \Carbon\Carbon::parse($pesanan->created_at)->translatedFormat('l, d F Y — H:i') }}</div>
                    </div>
                    <span class="status-badge s-{{ $pesanan->status }}">
                        @php $icon = match($pesanan->status){ 'menunggu'=>'⏳','diproses'=>'🔄','dikirim'=>'🚚','selesai'=>'✅','dibatalkan'=>'❌',default=>'•' }; @endphp
                        {{ $icon }} {{ $pesanan->status_label }}
                    </span>
                </div>
            </div>

            <!-- Produk yang dipesan -->
            <div class="d-card">
                <div class="d-header"><h2>🛒 Produk yang Dipesan</h2></div>
                <div class="d-body">
                    @foreach($pesanan->items as $item)
                    <div class="prod-item">
                        <div class="prod-emoji">{{ $item->emoji_produk }}</div>
                        <div class="prod-info">
                            <strong>{{ $item->nama_produk }}</strong>
                            <span>{{ $item->jumlah }} kg × Rp {{ number_format($item->harga,0,',','.') }}</span>
                        </div>
                        <div class="prod-price">Rp {{ number_format($item->subtotal,0,',','.') }}</div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Tombol Pesan Lagi -->
            <form method="POST" action="{{ route('keranjang.pesan_lagi') }}">
                @csrf
                <input type="hidden" name="pesanan_id" value="{{ $pesanan->id }}">
                <button type="submit" class="btn btn-primary" style="width:100%;padding:12px;font-size:14px;">
                    🔁 Pesan Lagi
                </button>
            </form>
        </div>

        <!-- KANAN -->
        <div>
            <!-- Ringkasan Pembayaran -->
            <div class="d-card">
                <div class="d-header"><h2>💳 Ringkasan Pembayaran</h2></div>
                <div class="d-body">
                    <div class="r-row"><span>Subtotal Produk</span><span>Rp {{ number_format($pesanan->subtotal,0,',','.') }}</span></div>
                    <div class="r-row"><span>Biaya Pengiriman</span><span>Rp {{ number_format($pesanan->biaya_pengiriman,0,',','.') }}</span></div>
                    @if($pesanan->biaya_admin)
                    <div class="r-row"><span>Biaya Admin</span><span>Rp {{ number_format($pesanan->biaya_admin,0,',','.') }}</span></div>
                    @endif
                    <div style="height:1px;background:var(--gray-200);margin:8px 0;"></div>
                    <div class="r-total"><span>Total</span><span>Rp {{ number_format($pesanan->total,0,',','.') }}</span></div>
                    <div style="margin-top:10px;padding:8px 12px;background:var(--gray-50);border-radius:8px;font-size:12.5px;color:var(--gray-700);">
                        💳 {{ $pesanan->metode_label }}
                    </div>
                </div>
            </div>

            <!-- Informasi Pengiriman -->
            <div class="d-card">
                <div class="d-header"><h2>📍 Informasi Pengiriman</h2></div>
                <div class="d-body">
                    <div class="info-row">
                        <span class="info-icon">📍</span>
                        <div class="info-content">
                            <strong>Alamat Pengiriman</strong>
                            {{ $pesanan->alamat_pengiriman ?? $pesanan->user->alamat ?? '-' }}
                        </div>
                    </div>
                    <div class="info-row">
                        <span class="info-icon">📞</span>
                        <div class="info-content">
                            <strong>Nomor Telepon</strong>
                            {{ $pesanan->nomor_telepon_pengiriman ?? $pesanan->user->nomor_telepon ?? '-' }}
                        </div>
                    </div>
                    <div class="info-row">
                        <span class="info-icon">✉️</span>
                        <div class="info-content">
                            <strong>Email</strong>
                            {{ $pesanan->user->email }}
                        </div>
                    </div>
                    @if($pesanan->catatan)
                    <div class="info-row">
                        <span class="info-icon">📝</span>
                        <div class="info-content">
                            <strong>Catatan</strong>
                            {{ $pesanan->catatan }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endsection
