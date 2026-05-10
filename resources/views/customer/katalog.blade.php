@extends('layouts.app')
@section('title', 'Katalog')
@section('page-title', 'Katalog')

@push('styles')
    @vite('resources/css/customer-katalog.css')
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
                <div class="produk-img">
                    @if($produk->gambar)
                        <img src="{{ asset('storage/' . $produk->gambar) }}" alt="{{ $produk->nama }}">
                    @else
                        {{ $produk->emoji }}
                    @endif
                </div>
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