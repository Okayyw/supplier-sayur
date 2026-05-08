@extends('layouts.app')
@section('title', 'Detail Pesanan')
@section('page-title', 'Detail Pesanan')

@push('styles')
<style>
    .detail-grid {
        display: grid;
        grid-template-columns: 1fr 340px;
        gap: 16px;
        align-items: start;
    }
    .info-row {
        display: flex;
        justify-content: space-between;
        padding: 9px 0;
        border-bottom: 1px solid var(--gray-100);
        font-size: 13.5px;
    }
    .info-row:last-child { border-bottom: none; }
    .info-row span:first-child { color: var(--gray-500); }
    .info-row span:last-child  { font-weight: 600; }
    .status-select {
        width: 100%;
        padding: 9px 12px;
        border: 1.5px solid var(--gray-200);
        border-radius: 8px;
        font-size: 13.5px;
        font-family: inherit;
        background: var(--gray-50);
        outline: none;
        cursor: pointer;
        transition: border-color .15s;
    }
    .status-select:focus { border-color: var(--green); }
    .customer-info {
        background: var(--gray-50);
        border-radius: 10px;
        padding: 14px;
        margin-bottom: 16px;
    }
    .customer-info h4 {
        font-size: 13px;
        font-weight: 700;
        color: var(--gray-500);
        text-transform: uppercase;
        letter-spacing: .04em;
        margin-bottom: 10px;
    }
    @media (max-width: 768px) {
        .detail-grid { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('content')
<div style="margin-bottom:14px;">
    <a href="{{ route('admin.pesanan') }}" class="btn btn-outline btn-sm">← Kembali ke Pesanan</a>
</div>

<div class="detail-grid">
    <!-- LEFT: Items & Summary -->
    <div>
        <!-- Pesanan Header -->
        <div class="card" style="margin-bottom:16px;">
            <div class="card-header">
                <div>
                    <h2>{{ $pesanan->nomor_pesanan }}</h2>
                    <p style="font-size:12px;color:var(--gray-500);margin-top:3px;">
                        📅 {{ $pesanan->created_at->format('d F Y, H:i') }}
                    </p>
                </div>
                <span class="badge badge-{{ match($pesanan->status) {
                    'menunggu'   => 'yellow',
                    'diproses'   => 'blue',
                    'dikirim'    => 'purple',
                    'selesai'    => 'green',
                    'dibatalkan' => 'red',
                    default      => 'gray'
                } }}" style="font-size:13px;padding:5px 14px;">
                    @php
                        $icon = match($pesanan->status) {
                            'menunggu'   => '⏳',
                            'diproses'   => '🔄',
                            'dikirim'    => '🚚',
                            'selesai'    => '✅',
                            'dibatalkan' => '❌',
                            default      => '•'
                        };
                    @endphp
                    {{ $icon }} {{ $pesanan->status_label }}
                </span>
            </div>

            <!-- Items Table -->
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th style="text-align:center;">Jumlah</th>
                            <th style="text-align:right;">Harga Satuan</th>
                            <th style="text-align:right;">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pesanan->items as $item)
                            <tr>
                                <td>
                                    <div style="display:flex;align-items:center;gap:10px;">
                                        <span style="font-size:22px;">
                                            {{ $item->produk ? $item->produk->emoji : '🥬' }}
                                        </span>
                                        <strong>{{ $item->nama_produk }}</strong>
                                    </div>
                                </td>
                                <td style="text-align:center;">{{ $item->jumlah }} kg</td>
                                <td style="text-align:right;">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                                <td style="text-align:right;font-weight:600;">
                                    Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Totals -->
            <div style="padding:16px 20px;border-top:1px solid var(--gray-100);">
                <div style="max-width:280px;margin-left:auto;">
                    <div class="info-row">
                        <span>Subtotal</span>
                        <span>Rp {{ number_format($pesanan->subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="info-row">
                        <span>Biaya Pengiriman</span>
                        <span>Rp {{ number_format($pesanan->biaya_pengiriman, 0, ',', '.') }}</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;padding-top:10px;font-size:16px;font-weight:700;color:var(--green-dark);">
                        <span>Total</span>
                        <span>Rp {{ number_format($pesanan->total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- RIGHT: Customer Info & Update Status -->
    <div>
        <!-- Customer Info Card -->
        <div class="card" style="margin-bottom:16px;">
            <div class="card-header"><h2>👤 Info Customer</h2></div>
            <div class="card-body">
                <div class="customer-info">
                    <h4>Data Toko</h4>
                    <div class="info-row">
                        <span>Nama Toko</span>
                        <span>{{ $pesanan->user->nama_toko }}</span>
                    </div>
                    <div class="info-row">
                        <span>Pemilik</span>
                        <span>{{ $pesanan->user->nama_pemilik }}</span>
                    </div>
                    <div class="info-row">
                        <span>Telepon</span>
                        <span>{{ $pesanan->user->nomor_telepon ?? '-' }}</span>
                    </div>
                    <div class="info-row">
                        <span>Email</span>
                        <span style="font-size:12px;">{{ $pesanan->user->email }}</span>
                    </div>
                </div>

                @if($pesanan->user->alamat)
                    <div style="background:var(--gray-50);border-radius:8px;padding:12px;font-size:13px;">
                        <div style="font-size:11px;font-weight:700;color:var(--gray-500);text-transform:uppercase;letter-spacing:.04em;margin-bottom:5px;">📍 Alamat Pengiriman</div>
                        {{ $pesanan->user->alamat }}
                    </div>
                @endif
            </div>
        </div>

        <!-- Update Status Card -->
        <div class="card">
            <div class="card-header"><h2>🔄 Update Status</h2></div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.pesanan.status', $pesanan) }}">
                    @csrf @method('PATCH')
                    <div class="form-group">
                        <label class="form-label">Status Pesanan</label>
                        <select name="status" class="status-select">
                            <option value="menunggu"   {{ $pesanan->status === 'menunggu'   ? 'selected' : '' }}>⏳ Menunggu</option>
                            <option value="diproses"   {{ $pesanan->status === 'diproses'   ? 'selected' : '' }}>🔄 Diproses</option>
                            <option value="dikirim"    {{ $pesanan->status === 'dikirim'    ? 'selected' : '' }}>🚚 Dikirim</option>
                            <option value="selesai"    {{ $pesanan->status === 'selesai'    ? 'selected' : '' }}>✅ Selesai</option>
                            <option value="dibatalkan" {{ $pesanan->status === 'dibatalkan' ? 'selected' : '' }}>❌ Dibatalkan</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-green" style="width:100%;">
                        💾 Simpan Status
                    </button>
                </form>

                <!-- Timeline Status -->
                <div style="margin-top:20px;">
                    <div style="font-size:11px;font-weight:700;color:var(--gray-500);text-transform:uppercase;letter-spacing:.04em;margin-bottom:12px;">Timeline</div>
                    @php
                        $steps = [
                            ['key' => 'menunggu',   'label' => 'Menunggu',   'icon' => '⏳'],
                            ['key' => 'diproses',   'label' => 'Diproses',   'icon' => '🔄'],
                            ['key' => 'dikirim',    'label' => 'Dikirim',    'icon' => '🚚'],
                            ['key' => 'selesai',    'label' => 'Selesai',    'icon' => '✅'],
                        ];
                        $statusOrder = ['menunggu' => 0, 'diproses' => 1, 'dikirim' => 2, 'selesai' => 3, 'dibatalkan' => 99];
                        $currentOrder = $statusOrder[$pesanan->status] ?? 0;
                    @endphp

                    @foreach($steps as $i => $step)
                        @php
                            $stepOrder = $statusOrder[$step['key']] ?? 0;
                            $isDone    = $currentOrder >= $stepOrder && $pesanan->status !== 'dibatalkan';
                            $isCurrent = $pesanan->status === $step['key'];
                        @endphp
                        <div style="display:flex;align-items:center;gap:10px;margin-bottom:{{ $i < count($steps)-1 ? '4px' : '0' }};">
                            <div style="
                                width:28px;height:28px;border-radius:50%;
                                display:grid;place-items:center;font-size:13px;flex-shrink:0;
                                background:{{ $isDone ? 'var(--green)' : 'var(--gray-100)' }};
                                border:2px solid {{ $isCurrent ? 'var(--green-dark)' : ($isDone ? 'var(--green)' : 'var(--gray-200)') }};
                            ">
                                @if($isDone)
                                    <span style="color:#fff;font-size:11px;">✓</span>
                                @else
                                    <span style="font-size:11px;">{{ $i+1 }}</span>
                                @endif
                            </div>
                            @if($i < count($steps)-1)
                                <div style="flex:1;">
                                    <div style="font-size:13px;font-weight:{{ $isCurrent ? '700' : '500' }};color:{{ $isDone ? 'var(--gray-900)' : 'var(--gray-400)' }};">
                                        {{ $step['label'] }}
                                    </div>
                                </div>
                            @else
                                <div style="font-size:13px;font-weight:{{ $isCurrent ? '700' : '500' }};color:{{ $isDone ? 'var(--gray-900)' : 'var(--gray-400)' }};">
                                    {{ $step['label'] }}
                                </div>
                            @endif
                        </div>
                        @if($i < count($steps)-1)
                            <div style="width:2px;height:14px;background:{{ $currentOrder > $stepOrder && $pesanan->status !== 'dibatalkan' ? 'var(--green)' : 'var(--gray-200)' }};margin-left:13px;"></div>
                        @endif
                    @endforeach

                    @if($pesanan->status === 'dibatalkan')
                        <div style="margin-top:10px;padding:10px;background:#fee2e2;border-radius:8px;font-size:12.5px;color:#dc2626;font-weight:600;">
                            ❌ Pesanan ini telah dibatalkan
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection