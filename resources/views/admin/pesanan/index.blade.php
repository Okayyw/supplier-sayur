@extends('layouts.app')
@section('title', 'Manajemen Pesanan')
@section('page-title', 'Pesanan')

@push('styles')
<style>
    .status-filter {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        margin-bottom: 16px;
    }
    .status-filter a {
        padding: 5px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
        border: 1.5px solid var(--gray-200);
        color: var(--gray-700);
        background: #fff;
        transition: all .15s;
    }
    .status-filter a:hover { border-color: var(--green); color: var(--green-dark); }
    .status-filter a.active { background: var(--gray-900); color: #fff; border-color: var(--gray-900); }
</style>
@endpush

@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;">
    <div>
        <h2 style="font-size:16px;font-weight:700;">Daftar Pesanan</h2>
        <p style="font-size:12px;color:var(--gray-500);">{{ $pesanans->count() }} total pesanan</p>
    </div>
</div>

<div class="status-filter">
    <a href="{{ route('admin.pesanan') }}" class="{{ !request('status') ? 'active' : '' }}">Semua</a>
    <a href="{{ route('admin.pesanan', ['status' => 'menunggu']) }}"
       class="{{ request('status') === 'menunggu' ? 'active' : '' }}">⏳ Menunggu</a>
    <a href="{{ route('admin.pesanan', ['status' => 'diproses']) }}"
       class="{{ request('status') === 'diproses' ? 'active' : '' }}">🔄 Diproses</a>
    <a href="{{ route('admin.pesanan', ['status' => 'dikirim']) }}"
       class="{{ request('status') === 'dikirim' ? 'active' : '' }}">🚚 Dikirim</a>
    <a href="{{ route('admin.pesanan', ['status' => 'selesai']) }}"
       class="{{ request('status') === 'selesai' ? 'active' : '' }}">✅ Selesai</a>
    <a href="{{ route('admin.pesanan', ['status' => 'dibatalkan']) }}"
       class="{{ request('status') === 'dibatalkan' ? 'active' : '' }}">❌ Dibatalkan</a>
</div>

<div class="card">
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>No. Pesanan</th>
                    <th>Customer</th>
                    <th>Items</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pesanans as $pesanan)
                    <tr>
                        <td>
                            <strong style="font-size:13px;">{{ $pesanan->nomor_pesanan }}</strong>
                        </td>
                        <td>
                            <div style="font-weight:600;font-size:13px;">{{ $pesanan->user->nama_toko }}</div>
                            <div style="font-size:11.5px;color:var(--gray-500);">{{ $pesanan->user->nama_pemilik }}</div>
                        </td>
                        <td>
                            <span style="font-size:13px;">{{ $pesanan->items->count() }} item</span>
                        </td>
                        <td>
                            <strong>Rp {{ number_format($pesanan->total, 0, ',', '.') }}</strong>
                        </td>
                        <td>
                            <span class="badge badge-{{ match($pesanan->status) {
                                'menunggu'   => 'yellow',
                                'diproses'   => 'blue',
                                'dikirim'    => 'purple',
                                'selesai'    => 'green',
                                'dibatalkan' => 'red',
                                default      => 'gray'
                            } }}">{{ $pesanan->status_label }}</span>
                        </td>
                        <td style="font-size:12.5px;color:var(--gray-500);">
                            {{ $pesanan->created_at->format('d M Y') }}<br>
                            <span style="font-size:11px;">{{ $pesanan->created_at->format('H:i') }}</span>
                        </td>
                        <td>
                            <a href="{{ route('admin.pesanan.show', $pesanan) }}"
                               class="btn btn-outline btn-sm">Detail →</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align:center;padding:48px;color:var(--gray-500);">
                            <div style="font-size:32px;margin-bottom:8px;">📦</div>
                            <div>Belum ada pesanan</div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection