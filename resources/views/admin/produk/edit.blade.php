@extends('layouts.app')
@section('title', 'Edit Produk')
@section('page-title', 'Edit Produk')

@section('content')
<div style="margin-bottom:14px;">
    <a href="{{ route('admin.produk') }}" class="btn btn-outline btn-sm">← Kembali</a>
</div>

<div class="card" style="max-width:600px;">
    <div class="card-header"><h2>✏️ Edit: {{ $produk->emoji }} {{ $produk->nama }}</h2></div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.produk.update', $produk) }}">
            @csrf @method('PATCH')
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Nama Produk</label>
                    <input type="text" name="nama" value="{{ old('nama', $produk->nama) }}"
                        class="form-control {{ $errors->has('nama') ? 'is-invalid' : '' }}">
                    @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Emoji</label>
                    <input type="text" name="emoji" value="{{ old('emoji', $produk->emoji) }}"
                        class="form-control">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Deskripsi</label>
                <input type="text" name="deskripsi" value="{{ old('deskripsi', $produk->deskripsi) }}"
                    class="form-control">
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Harga (Rp/kg)</label>
                    <input type="number" name="harga" value="{{ old('harga', $produk->harga) }}"
                        class="form-control {{ $errors->has('harga') ? 'is-invalid' : '' }}" min="0">
                    @error('harga')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Stok (kg)</label>
                    <input type="number" name="stok" value="{{ old('stok', $produk->stok) }}"
                        class="form-control {{ $errors->has('stok') ? 'is-invalid' : '' }}" min="0">
                    @error('stok')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Kategori</label>
                <select name="kategori" class="form-control">
                    @foreach($kategoris as $k)
                        <option value="{{ $k }}" {{ old('kategori', $produk->kategori) == $k ? 'selected' : '' }}>{{ $k }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Status</label>
                <select name="aktif" class="form-control">
                    <option value="1" {{ $produk->aktif ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ !$produk->aktif ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>

            <div style="display:flex;gap:10px;margin-top:4px;">
                <button type="submit" class="btn btn-green">💾 Update Produk</button>
                <a href="{{ route('admin.produk') }}" class="btn btn-outline">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection