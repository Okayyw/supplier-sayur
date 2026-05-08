@extends('layouts.app')
@section('title', 'Profil Saya')
@section('page-title', 'Profil')

@push('styles')
<style>
    .profil-card { background:#fff; border:1px solid var(--gray-200); border-radius:14px; box-shadow:var(--shadow); }
    .profil-header {
        padding: 20px;
        border-bottom: 1px solid var(--gray-100);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .profil-header h2 { font-size: 15px; font-weight: 700; display:flex;align-items:center;gap:8px; }
    .profil-user {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 20px 20px 0;
        margin-bottom: 20px;
    }
    .profil-avatar {
        width: 60px; height: 60px;
        border-radius: 50%;
        background: var(--green);
        color: #fff;
        font-size: 20px;
        font-weight: 700;
        display: grid;
        place-items: center;
        flex-shrink: 0;
    }
    .profil-user-info strong { font-size: 16px; font-weight: 700; }
    .profil-user-info span { font-size: 12.5px; color:var(--gray-500); display:block;margin-top:2px; }
    .profil-body { padding: 0 20px 20px; }
    .profil-fields .form-row { gap:14px; }
    .field-label {
        font-size: 12px;
        font-weight: 600;
        color: var(--gray-500);
        display:flex;align-items:center;gap:5px;
        margin-bottom: 5px;
    }
    .field-value {
        padding: 9px 12px;
        background: var(--gray-50);
        border: 1.5px solid var(--gray-200);
        border-radius: 8px;
        font-size: 13.5px;
        color: var(--gray-900);
    }
    .stats-row {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
        margin-top: 20px;
    }
    .stat-box {
        background: #fff;
        border: 1px solid var(--gray-200);
        border-radius: 12px;
        padding: 16px;
        text-align: center;
    }
    .stat-box .stat-label { font-size: 12px; color: var(--gray-500); margin-bottom: 6px; }
    .stat-box .stat-val { font-size: 22px; font-weight: 700; color: var(--gray-900); }
    .modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,.4);
        z-index: 200;
        align-items: center;
        justify-content: center;
    }
    .modal-overlay.show { display: flex; }
    .modal {
        background: #fff;
        border-radius: 14px;
        width: 100%;
        max-width: 500px;
        margin: 16px;
        box-shadow: 0 20px 60px rgba(0,0,0,.2);
    }
    .modal-header {
        padding: 16px 20px;
        border-bottom: 1px solid var(--gray-100);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .modal-header h3 { font-size: 15px; font-weight: 700; }
    .modal-body { padding: 20px; }
    .modal-footer { padding: 14px 20px; border-top: 1px solid var(--gray-100); display:flex; gap:10px; justify-content:flex-end; }
    .btn-close-modal { background:none;border:none;cursor:pointer;font-size:18px;color:var(--gray-500); }
    @media(max-width:600px){ .stats-row{grid-template-columns:1fr 1fr;} }
</style>
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