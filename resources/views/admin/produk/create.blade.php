@extends('layouts.app')
@section('title', 'Tambah Produk')
@section('page-title', 'Tambah Produk')

@section('content')
<div style="margin-bottom:14px;">
    <a href="{{ route('admin.produk') }}" class="btn btn-outline btn-sm">← Kembali</a>
</div>

<div class="card" style="max-width:600px;">
    <div class="card-header"><h2>➕ Tambah Produk Baru</h2></div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.produk.store') }}">
            @csrf
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Nama Produk</label>
                    <input type="text" name="nama" value="{{ old('nama') }}"
                        class="form-control {{ $errors->has('nama') ? 'is-invalid' : '' }}"
                        placeholder="Tomat Segar">
                    @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Emoji</label>
                    <input type="text" name="emoji" value="{{ old('emoji', '🥬') }}"
                        class="form-control {{ $errors->has('emoji') ? 'is-invalid' : '' }}"
                        placeholder="🥬">
                    @error('emoji')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Deskripsi</label>
                <input type="text" name="deskripsi" value="{{ old('deskripsi') }}"
                    class="form-control"
                    placeholder="Deskripsi singkat produk">
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Harga (Rp/kg)</label>
                    <input type="number" name="harga" value="{{ old('harga') }}"
                        class="form-control {{ $errors->has('harga') ? 'is-invalid' : '' }}"
                        placeholder="8000" min="0">
                    @error('harga')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Stok (kg)</label>
                    <input type="number" name="stok" value="{{ old('stok') }}"
                        class="form-control {{ $errors->has('stok') ? 'is-invalid' : '' }}"
                        placeholder="100" min="0">
                    @error('stok')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Kategori</label>
                <select name="kategori" class="form-control {{ $errors->has('kategori') ? 'is-invalid' : '' }}">
                    <option value="">Pilih kategori...</option>
                    @foreach($kategoris as $k)
                        <option value="{{ $k }}" {{ old('kategori') == $k ? 'selected' : '' }}>{{ $k }}</option>
                    @endforeach
                </select>
                @error('kategori')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div style="display:flex;gap:10px;margin-top:4px;">
                <button type="submit" class="btn btn-green">💾 Simpan Produk</button>
                <a href="{{ route('admin.produk') }}" class="btn btn-outline">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection