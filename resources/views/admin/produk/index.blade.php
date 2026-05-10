@extends('layouts.app')
@section('title', 'Manajemen Produk')
@section('page-title', 'Produk')

@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;">
    <div>
        <h2 style="font-size:16px;font-weight:700;">Daftar Produk</h2>
        <p style="font-size:12px;color:var(--gray-500);">{{ $produks->count() }} produk terdaftar</p>
    </div>
    <a href="{{ route('admin.produk.create') }}" class="btn btn-green">+ Tambah Produk</a>
</div>

<div class="card">
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($produks as $produk)
                    <tr>
                        <td>
                            <div style="display:flex;align-items:center;gap:10px;">
                                @if($produk->gambar)
                                    <img src="{{ asset('storage/' . $produk->gambar) }}" alt="{{ $produk->nama }}" style="width:40px;height:40px;border-radius:6px;object-fit:cover;">
                                @else
                                    <span style="font-size:24px;">{{ $produk->emoji }}</span>
                                @endif
                                <div>
                                    <div style="font-weight:600;">{{ $produk->nama }}</div>
                                    <div style="font-size:11.5px;color:var(--gray-500);">{{ $produk->deskripsi }}</div>
                                </div>
                            </div>
                        </td>
                        <td><span class="badge badge-green">{{ $produk->kategori }}</span></td>
                        <td><strong>{{ $produk->harga_format }}</strong></td>
                        <td>
                            <span class="{{ $produk->stok < 10 ? 'text-red fw-600' : '' }}">
                                {{ number_format($produk->stok) }} kg
                            </span>
                        </td>
                        <td>
                            <span class="badge {{ $produk->aktif ? 'badge-green' : 'badge-red' }}">
                                {{ $produk->aktif ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td>
                            <div style="display:flex;gap:6px;">
                                <a href="{{ route('admin.produk.edit', $produk) }}" class="btn btn-outline btn-sm">✏️ Edit</a>
                                <form method="POST" action="{{ route('admin.produk.destroy', $produk) }}"
                                      onsubmit="return confirm('Hapus produk {{ $produk->nama }}?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm">🗑️</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" style="text-align:center;color:var(--gray-500);padding:40px;">Belum ada produk</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection