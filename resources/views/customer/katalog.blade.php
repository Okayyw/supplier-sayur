@extends('layouts.app')
@section('title', 'Katalog')
@section('page-title', 'Katalog')

@push('styles')
<style>
    .search-bar {
        position: relative;
        margin-bottom: 16px;
    }
    .search-bar input {
        width: 100%;
        padding: 10px 14px 10px 38px;
        border: 1.5px solid var(--gray-200);
        border-radius: 10px;
        font-size: 13.5px;
        font-family: inherit;
        background: #fff;
        outline: none;
        transition: border-color .15s;
    }
    .search-bar input:focus { border-color: var(--green); }
    .search-icon {
        position: absolute;
        left: 12px; top: 50%;
        transform: translateY(-50%);
        color: var(--gray-400);
        font-size: 15px;
    }
    .filter-tabs {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        margin-bottom: 20px;
    }
    .filter-tab {
        padding: 6px 16px;
        border-radius: 20px;
        border: 1.5px solid var(--gray-200);
        background: #fff;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        color: var(--gray-700);
        text-decoration: none;
        transition: all .15s;
    }
    .filter-tab:hover { border-color: var(--green); color: var(--green-dark); }
    .filter-tab.active { background: var(--gray-900); color: #fff; border-color: var(--gray-900); }
    .produk-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 16px;
    }
    .produk-card {
        background: #fff;
        border: 1px solid var(--gray-200);
        border-radius: 14px;
        overflow: hidden;
        transition: box-shadow .2s, transform .2s;
        box-shadow: var(--shadow);
    }
    .produk-card:hover {
        box-shadow: 0 8px 20px rgba(0,0,0,.1);
        transform: translateY(-2px);
    }
    .produk-img {
        background: #f0fdf4;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 120px;
        font-size: 56px;
    }
    .produk-info { padding: 14px; }
    .produk-nama-row {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 6px;
        margin-bottom: 4px;
    }
    .produk-nama { font-size: 14px; font-weight: 700; color: var(--gray-900); }
    .produk-kategori-badge {
        display: inline-block;
        background: var(--gray-100);
        color: var(--gray-700);
        font-size: 10px;
        font-weight: 600;
        padding: 2px 8px;
        border-radius: 20px;
        flex-shrink: 0;
    }
    .produk-desc {
        font-size: 12px;
        color: var(--gray-500);
        margin-bottom: 10px;
    }
    .produk-price-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 12px;
    }
    .produk-harga {
        font-size: 15px;
        font-weight: 700;
        color: var(--green-dark);
    }
    .produk-harga small { display: block; font-size: 10px; font-weight: 400; color: var(--gray-400); }
    .produk-stok { font-size: 11.5px; color: var(--gray-500); }
    .btn-tambah {
        width: 100%;
        padding: 9px;
        background: var(--gray-900);
        color: #fff;
        border: none;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        font-family: inherit;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        transition: background .15s;
    }
    .btn-tambah:hover { background: #1f2937; }
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: var(--gray-500);
    }
    .empty-state .empty-icon { font-size: 48px; margin-bottom: 12px; }
    .empty-state h3 { font-size: 15px; font-weight: 600; margin-bottom: 4px; }
</style>
@endpush

@section('content')
<form method="GET" action="{{ route('katalog') }}">
    <div class="search-bar">
        <span class="search-icon">🔍</span>
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari sayuran...">
    </div>

    <div class="filter-tabs">
        @foreach($kategoris as $kat)
            <button type="submit" name="kategori" value="{{ $kat }}"
                class="filter-tab {{ request('kategori', 'Semua') === $kat ? 'active' : '' }}">
                {{ $kat }}
            </button>
        @endforeach
    </div>
</form>

@if($produks->isEmpty())
    <div class="empty-state">
        <div class="empty-icon">🥬</div>
        <h3>Produk tidak ditemukan</h3>
        <p>Coba cari dengan kata kunci lain atau pilih kategori berbeda.</p>
    </div>
@else
    <div class="produk-grid">
        @foreach($produks as $produk)
            <div class="produk-card">
                <div class="produk-img">{{ $produk->emoji }}</div>
                <div class="produk-info">
                    <div class="produk-nama-row">
                        <span class="produk-nama">{{ $produk->nama }}</span>
                        <span class="produk-kategori-badge">{{ $produk->kategori }}</span>
                    </div>
                    <div class="produk-desc">{{ $produk->deskripsi }}</div>
                    <div class="produk-price-row">
                        <div class="produk-harga">
                            {{ $produk->harga_format }}
                            <small>per kg</small>
                        </div>
                        <div class="produk-stok">Stok: {{ number_format($produk->stok) }} kg</div>
                    </div>
                    <form method="POST" action="{{ route('keranjang.tambah') }}">
                        @csrf
                        <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                        <button type="submit" class="btn-tambah" {{ $produk->stok <= 0 ? 'disabled' : '' }}>
                            🛒 {{ $produk->stok > 0 ? 'Tambah ke Keranjang' : 'Stok Habis' }}
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
@endif
@endsection