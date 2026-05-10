@extends('layouts.app')
@section('title', 'Profil Saya')
@section('page-title', 'Profil')

@push('styles')
    @vite('resources/css/customer-profil.css')
@endpush

@section('content')
<div class="profil-card">
    <div class="profil-header">
        <h2>👤 Profil Saya</h2>
        <button class="btn btn-outline btn-sm" onclick="document.getElementById('modalEdit').classList.add('show')">
            ✏️ Edit Profil
        </button>
    </div>

    <div class="profil-user">
        <div class="profil-avatar">{{ $user->inisial }}</div>
        <div class="profil-user-info">
            <strong>{{ $user->nama_toko }}</strong>
            <span>Pelanggan sejak {{ $user->created_at->format('F Y') }}</span>
        </div>
    </div>

    <div class="profil-body">
        <div class="profil-fields">
            <div class="form-row">
                <div>
                    <div class="field-label">Nama Toko/Usaha</div>
                    <div class="field-value">{{ $user->nama_toko }}</div>
                </div>
                <div>
                    <div class="field-label">Nama Pemilik</div>
                    <div class="field-value">{{ $user->nama_pemilik }}</div>
                </div>
            </div>
            <div class="form-row" style="margin-top:12px;">
                <div>
                    <div class="field-label">✉️ Email</div>
                    <div class="field-value">{{ $user->email }}</div>
                </div>
                <div>
                    <div class="field-label">📞 Nomor Telepon</div>
                    <div class="field-value">{{ $user->nomor_telepon ?? '-' }}</div>
                </div>
            </div>
            <div style="margin-top:12px;">
                <div class="field-label">📍 Alamat Lengkap</div>
                <div class="field-value">{{ $user->alamat ?? '-' }}</div>
            </div>
        </div>
    </div>
</div>

<div class="stats-row">
    <div class="stat-box">
        <div class="stat-label">Total Pesanan</div>
        <div class="stat-val">{{ number_format($user->total_pesanan) }}</div>
    </div>
    <div class="stat-box">
        <div class="stat-label">Total Pembelian</div>
        <div class="stat-val" style="font-size:16px;">Rp {{ number_format($user->total_pembelian / 1000000, 1) }} Jt</div>
    </div>
    <div class="stat-box">
        <div class="stat-label">Poin Loyalitas</div>
        <div class="stat-val">{{ number_format($user->poin_loyalitas) }}</div>
    </div>
</div>

<!-- MODAL EDIT PROFIL -->
<div class="modal-overlay" id="modalEdit">
    <div class="modal">
        <div class="modal-header">
            <h3>✏️ Edit Profil</h3>
            <button class="btn-close-modal" onclick="document.getElementById('modalEdit').classList.remove('show')">✕</button>
        </div>
        <form method="POST" action="{{ route('profil.update') }}">
            @csrf @method('PATCH')
            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Nama Toko</label>
                        <input type="text" name="nama_toko" value="{{ old('nama_toko', $user->nama_toko) }}"
                            class="form-control {{ $errors->has('nama_toko') ? 'is-invalid' : '' }}">
                        @error('nama_toko')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nama Pemilik</label>
                        <input type="text" name="nama_pemilik" value="{{ old('nama_pemilik', $user->nama_pemilik) }}"
                            class="form-control {{ $errors->has('nama_pemilik') ? 'is-invalid' : '' }}">
                        @error('nama_pemilik')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Nomor Telepon</label>
                    <input type="text" name="nomor_telepon" value="{{ old('nomor_telepon', $user->nomor_telepon) }}"
                        class="form-control {{ $errors->has('nomor_telepon') ? 'is-invalid' : '' }}">
                    @error('nomor_telepon')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Alamat Lengkap</label>
                    <textarea name="alamat" rows="3"
                        class="form-control {{ $errors->has('alamat') ? 'is-invalid' : '' }}">{{ old('alamat', $user->alamat) }}</textarea>
                    @error('alamat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline" onclick="document.getElementById('modalEdit').classList.remove('show')">Batal</button>
                <button type="submit" class="btn btn-primary">💾 Simpan</button>
            </div>
        </form>
    </div>
</div>

@if($errors->any())
<script>document.getElementById('modalEdit').classList.add('show');</script>
@endif
@endsection