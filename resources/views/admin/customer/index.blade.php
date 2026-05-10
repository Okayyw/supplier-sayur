@extends('layouts.app')
@section('title', 'Manajemen Customer')
@section('page-title', 'Customers')

@push('styles')
    @vite('resources/css/admin-customer.css')
@endpush

@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;flex-wrap:wrap;gap:10px;">
    <div>
        <h2 style="font-size:16px;font-weight:700;">Daftar Customer</h2>
        <p style="font-size:12px;color:var(--gray-500);">{{ $customers->count() }} customer terdaftar</p>
    </div>
    <div class="view-toggle">
        <button class="view-btn active" id="btn-grid" onclick="switchView('grid')">⊞ Grid</button>
        <button class="view-btn" id="btn-table" onclick="switchView('table')">☰ Tabel</button>
    </div>
</div>

<!-- GRID VIEW -->
<div id="grid-view" class="customer-grid">
    @forelse($customers as $customer)
        <div class="customer-card">
            <div class="customer-card-top">
                <div class="c-avatar">{{ $customer->inisial }}</div>
                <div style="min-width:0;">
                    <div class="c-name">{{ $customer->nama_toko }}</div>
                    <div class="c-email">{{ $customer->email }}</div>
                </div>
            </div>

            <div class="c-stat-row">
                <div class="c-stat">
                    <div class="c-stat-val">{{ number_format($customer->total_pesanan) }}</div>
                    <div class="c-stat-label">Pesanan</div>
                </div>
                <div class="c-stat">
                    <div class="c-stat-val" style="font-size:12px;">
                        Rp {{ number_format($customer->total_pembelian / 1000000, 1) }}Jt
                    </div>
                    <div class="c-stat-label">Pembelian</div>
                </div>
                <div class="c-stat">
                    <div class="c-stat-val">{{ number_format($customer->poin_loyalitas) }}</div>
                    <div class="c-stat-label">Poin</div>
                </div>
            </div>

            <div class="c-detail">
                @if($customer->nama_pemilik)
                    <span>👤 {{ $customer->nama_pemilik }}</span>
                @endif
                @if($customer->nomor_telepon)
                    <span>📞 {{ $customer->nomor_telepon }}</span>
                @endif
                @if($customer->alamat)
                    <span style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                        📍 {{ $customer->alamat }}
                    </span>
                @endif
                <span style="color:var(--gray-400);font-size:11px;">
                    Bergabung {{ $customer->created_at->format('d M Y') }}
                </span>
            </div>
        </div>
    @empty
        <div style="grid-column:1/-1;text-align:center;padding:60px;color:var(--gray-500);">
            <div style="font-size:40px;margin-bottom:10px;">👥</div>
            <div>Belum ada customer terdaftar</div>
        </div>
    @endforelse
</div>

<!-- TABLE VIEW -->
<div id="table-view" class="card" style="display:none;">
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Customer</th>
                    <th>Kontak</th>
                    <th>Total Pesanan</th>
                    <th>Total Pembelian</th>
                    <th>Poin</th>
                    <th>Bergabung</th>
                </tr>
            </thead>
            <tbody>
                @forelse($customers as $customer)
                    <tr>
                        <td>
                            <div style="display:flex;align-items:center;gap:10px;">
                                <div style="width:34px;height:34px;border-radius:50%;background:var(--green);color:#fff;display:grid;place-items:center;font-size:11px;font-weight:700;flex-shrink:0;">
                                    {{ $customer->inisial }}
                                </div>
                                <div>
                                    <div style="font-weight:600;font-size:13px;">{{ $customer->nama_toko }}</div>
                                    <div style="font-size:11.5px;color:var(--gray-500);">{{ $customer->nama_pemilik }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div style="font-size:12.5px;">{{ $customer->email }}</div>
                            <div style="font-size:12px;color:var(--gray-500);">{{ $customer->nomor_telepon ?? '-' }}</div>
                        </td>
                        <td>
                            <strong>{{ number_format($customer->total_pesanan) }}</strong>
                        </td>
                        <td>
                            <strong>Rp {{ number_format($customer->total_pembelian, 0, ',', '.') }}</strong>
                        </td>
                        <td>
                            <span class="badge badge-green">{{ number_format($customer->poin_loyalitas) }} pts</span>
                        </td>
                        <td style="font-size:12.5px;color:var(--gray-500);">
                            {{ $customer->created_at->format('d M Y') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align:center;padding:40px;color:var(--gray-500);">
                            Belum ada customer
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
function switchView(view) {
    const grid  = document.getElementById('grid-view');
    const table = document.getElementById('table-view');
    const btnG  = document.getElementById('btn-grid');
    const btnT  = document.getElementById('btn-table');
    if (view === 'grid') {
        grid.style.display  = '';
        table.style.display = 'none';
        btnG.classList.add('active');
        btnT.classList.remove('active');
    } else {
        grid.style.display  = 'none';
        table.style.display = '';
        btnG.classList.remove('active');
        btnT.classList.add('active');
    }
}
</script>
@endpush