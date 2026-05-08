@extends('layouts.app')
@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard')

@push('styles')
<style>
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(190px, 1fr));
        gap: 14px;
        margin-bottom: 24px;
    }
    .stat-card {
        background: #fff;
        border: 1px solid var(--gray-200);
        border-radius: 12px;
        padding: 18px;
        box-shadow: var(--shadow);
    }
    .stat-card-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 10px;
    }
    .stat-card-label { font-size: 12px; color: var(--gray-500); font-weight: 600; }
    .stat-icon {
        width: 36px; height: 36px;
        border-radius: 9px;
        display: grid;
        place-items: center;
        font-size: 18px;
    }
    .stat-val { font-size: 24px; font-weight: 800; color: var(--gray-900); }
    .stat-val-sm { font-size: 16px; font-weight: 700; color: var(--gray-900); }
    .icon-green  { background: var(--green-light); }
    .icon-blue   { background: #dbeafe; }
    .icon-yellow { background: #fef3c7; }
    .icon-purple { background: #ede9fe; }
</style>
@endpush

@section('content')
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-card-top">
            <div class="stat-card-label">Total Produk</div>
            <div class="stat-icon icon-green">🥬</div>
        </div>
        <div class="stat-val">{{ $totalProduk }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-top">
            <div class="stat-card-label">Total Customer</div>
            <div class="stat-icon icon-blue">👥</div>
        </div>
        <div class="stat-val">{{ $totalCustomer }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-top">
            <div class="stat-card-label">Total Pesanan</div>
            <div class="stat-icon icon-yellow">📦</div>
        </div>
        <div class="stat-val">{{ $totalPesanan }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-top">
            <div class="stat-card-label">Pendapatan</div>
            <div class="stat-icon icon-purple">💰</div>
        </div>
        <div class="stat-val-sm">Rp {{ number_format($totalPendapatan / 1000000, 1) }} Jt</div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h2>📦 Pesanan Terbaru</h2>
        <a href="{{ route('admin.pesanan') }}" class="btn btn-outline btn-sm">Lihat Semua →</a>
    </div>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>No Pesanan</th>
                    <th>Customer</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pesananTerbaru as $p)
                    <tr>
                        <td><strong>{{ $p->nomor_pesanan }}</strong></td>
                        <td>{{ $p->user->nama_toko }}</td>
                        <td>Rp {{ number_format($p->total, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge badge-{{ match($p->status) {
                                'menunggu'=>'yellow','diproses'=>'blue','dikirim'=>'purple','selesai'=>'green','dibatalkan'=>'red',default=>'gray'
                            } }}">{{ $p->status_label }}</span>
                        </td>
                        <td>{{ $p->created_at->format('d M Y') }}</td>
                        <td>
                            <a href="{{ route('admin.pesanan.show', $p) }}" class="btn btn-outline btn-sm">Detail</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" style="text-align:center;color:var(--gray-500);padding:30px;">Belum ada pesanan</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection