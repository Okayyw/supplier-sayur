@extends('layouts.app')
@section('title', 'Pembayaran')
@section('page-title', 'Pembayaran')

@push('styles')
<style>
    .pay-grid {
        display: grid;
        grid-template-columns: 1fr 340px;
        gap: 20px;
        align-items: start;
    }
    .pay-card {
        background: #fff;
        border: 1px solid var(--gray-200);
        border-radius: 14px;
        box-shadow: var(--shadow);
        margin-bottom: 16px;
    }
    .pay-card-header {
        padding: 16px 20px;
        border-bottom: 1px solid var(--gray-100);
        display: flex; align-items: center; gap: 10px;
    }
    .pay-card-header h2 { font-size: 15px; font-weight: 700; }
    .pay-card-body { padding: 20px; }
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
    .form-group { margin-bottom: 14px; }
    .form-label { display: block; font-size: 12.5px; font-weight: 600; color: var(--gray-700); margin-bottom: 5px; }
    .form-control {
        width: 100%; padding: 10px 12px;
        border: 1.5px solid var(--gray-200); border-radius: 8px;
        font-size: 13.5px; font-family: inherit;
        background: var(--gray-50); color: var(--gray-900);
        outline: none; transition: border-color .15s;
    }
    .form-control:focus { border-color: var(--green); background: #fff; }
    .form-control.is-invalid { border-color: var(--red); }
    .invalid-feedback { color: var(--red); font-size: 11.5px; margin-top: 4px; }

    /* Metode Pembayaran */
    .metode-list { display: flex; flex-direction: column; gap: 10px; }
    .metode-item {
        display: flex; align-items: center; gap: 14px;
        padding: 14px 16px;
        border: 1.5px solid var(--gray-200);
        border-radius: 10px; cursor: pointer;
        transition: all .15s; position: relative;
    }
    .metode-item:hover { border-color: var(--green); background: var(--green-bg); }
    .metode-item.selected { border-color: var(--green); background: var(--green-bg); }
    .metode-item input[type=radio] { display: none; }
    .metode-icon {
        width: 40px; height: 40px; border-radius: 10px;
        display: grid; place-items: center; font-size: 20px;
        flex-shrink: 0;
    }
    .metode-info { flex: 1; }
    .metode-info strong { display: block; font-size: 13.5px; font-weight: 700; color: var(--gray-900); }
    .metode-info span { font-size: 12px; color: var(--gray-500); }
    .metode-check {
        width: 18px; height: 18px; border-radius: 50%;
        border: 2px solid var(--gray-300);
        display: grid; place-items: center;
        transition: all .15s;
    }
    .metode-item.selected .metode-check {
        background: var(--green); border-color: var(--green);
    }
    .metode-item.selected .metode-check::after {
        content: '✓'; color: #fff; font-size: 10px; font-weight: 700;
    }

    /* Ringkasan kanan */
    .ringkasan-item {
        display: flex; align-items: center; gap: 12px;
        padding: 10px 0; border-bottom: 1px solid var(--gray-100);
    }
    .ringkasan-item:last-child { border-bottom: none; }
    .ringkasan-emoji {
        width: 44px; height: 44px; border-radius: 8px;
        background: var(--green-light); display: grid;
        place-items: center; font-size: 22px; flex-shrink: 0;
    }
    .ringkasan-item-info { flex: 1; }
    .ringkasan-item-info strong { display: block; font-size: 13px; font-weight: 600; }
    .ringkasan-item-info span { font-size: 11.5px; color: var(--gray-500); }
    .ringkasan-price { font-size: 13px; font-weight: 700; }
    .r-row { display: flex; justify-content: space-between; padding: 6px 0; font-size: 13px; color: var(--gray-700); }
    .r-total { display: flex; justify-content: space-between; font-size: 16px; font-weight: 700; padding: 8px 0; }
    .r-total span:last-child { color: var(--green-dark); }
    .btn-bayar {
        width: 100%; padding: 13px; background: var(--gray-900);
        color: #fff; border: none; border-radius: 10px;
        font-size: 14px; font-weight: 700; cursor: pointer;
        font-family: inherit; margin-top: 14px; transition: background .15s;
        display: flex; align-items: center; justify-content: center; gap: 8px;
    }
    .btn-bayar:hover { background: #1f2937; }
    .btn-bayar:disabled { background: var(--gray-400); cursor: not-allowed; }
    @media (max-width: 768px) {
        .pay-grid { grid-template-columns: 1fr; }
        .form-row { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('content')
<div style="margin-bottom:16px;display:flex;align-items:center;gap:10px;">
    <a href="{{ route('keranjang') }}" style="color:var(--gray-500);text-decoration:none;font-size:18px;">←</a>
    <div>
        <h2 style="font-size:17px;font-weight:700;">Pembayaran</h2>
        <p style="font-size:12px;color:var(--gray-500);">Pilih metode pembayaran Anda</p>
    </div>
</div>

<form method="POST" action="{{ route('pembayaran.proses') }}" id="form-bayar">
@csrf
<div class="pay-grid">
    <!-- KIRI -->
    <div>
        <!-- Informasi Pengiriman -->
        <div class="pay-card">
            <div class="pay-card-header">
                <span style="font-size:18px;">📦</span>
                <h2>Informasi Pengiriman</h2>
            </div>
            <div class="pay-card-body">
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Nama Penerima</label>
                        <input type="text" name="nama_penerima"
                            value="{{ old('nama_penerima', $user->nama_pemilik) }}"
                            class="form-control {{ $errors->has('nama_penerima') ? 'is-invalid' : '' }}"
                            placeholder="Nama lengkap penerima">
                        @error('nama_penerima')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nomor Telepon</label>
                        <input type="text" name="nomor_telepon"
                            value="{{ old('nomor_telepon', $user->nomor_telepon) }}"
                            class="form-control {{ $errors->has('nomor_telepon') ? 'is-invalid' : '' }}"
                            placeholder="08xx-xxxx-xxxx">
                        @error('nomor_telepon')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Alamat Lengkap</label>
                    <textarea name="alamat" rows="2"
                        class="form-control {{ $errors->has('alamat') ? 'is-invalid' : '' }}"
                        placeholder="Jl. Contoh No. 1, Kota, Provinsi">{{ old('alamat', $user->alamat) }}</textarea>
                    @error('alamat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-group" style="margin-bottom:0;">
                    <label class="form-label">Catatan (Opsional)</label>
                    <input type="text" name="catatan"
                        value="{{ old('catatan') }}"
                        class="form-control"
                        placeholder="Contoh: Antar pagi hari">
                </div>
            </div>
        </div>

        <!-- Metode Pembayaran -->
        <div class="pay-card">
            <div class="pay-card-header">
                <span style="font-size:18px;">💳</span>
                <h2>Metode Pembayaran</h2>
            </div>
            <div class="pay-card-body">
                @error('metode')<div class="alert alert-danger" style="margin-bottom:12px;">{{ $message }}</div>@enderror
                <div class="metode-list">
                    <label class="metode-item {{ old('metode') == 'cod' || !old('metode') ? 'selected' : '' }}" onclick="pilihMetode(this,'cod')">
                        <input type="radio" name="metode" value="cod" {{ old('metode','cod') == 'cod' ? 'checked' : '' }}>
                        <div class="metode-icon" style="background:#fef3c7;">🚚</div>
                        <div class="metode-info">
                            <strong>COD (Bayar di Tempat)</strong>
                            <span>Bayar tunai saat pesanan tiba</span>
                        </div>
                        <div class="metode-check {{ old('metode','cod') == 'cod' ? 'selected' : '' }}"></div>
                    </label>

                    <label class="metode-item {{ old('metode') == 'e_wallet' ? 'selected' : '' }}" onclick="pilihMetode(this,'e_wallet')">
                        <input type="radio" name="metode" value="e_wallet" {{ old('metode') == 'e_wallet' ? 'checked' : '' }}>
                        <div class="metode-icon" style="background:#dcfce7;">💚</div>
                        <div class="metode-info">
                            <strong>E-Wallet</strong>
                            <span>GoPay, OVO, Dana, ShopeePay</span>
                        </div>
                        <div class="metode-check"></div>
                    </label>

                    <label class="metode-item {{ old('metode') == 'virtual_account' ? 'selected' : '' }}" onclick="pilihMetode(this,'virtual_account')">
                        <input type="radio" name="metode" value="virtual_account" {{ old('metode') == 'virtual_account' ? 'checked' : '' }}>
                        <div class="metode-icon" style="background:#dbeafe;">🏦</div>
                        <div class="metode-info">
                            <strong>Virtual Account</strong>
                            <span>VA BCA, Mandiri, BNI</span>
                        </div>
                        <div class="metode-check"></div>
                    </label>

                    <label class="metode-item {{ old('metode') == 'transfer_bank' ? 'selected' : '' }}" onclick="pilihMetode(this,'transfer_bank')">
                        <input type="radio" name="metode" value="transfer_bank" {{ old('metode') == 'transfer_bank' ? 'checked' : '' }}>
                        <div class="metode-icon" style="background:#ede9fe;">🏧</div>
                        <div class="metode-info">
                            <strong>Transfer Bank</strong>
                            <span>BCA, Mandiri, BNI, BRI</span>
                        </div>
                        <div class="metode-check"></div>
                    </label>
                </div>
            </div>
        </div>
    </div>

    <!-- KANAN: Ringkasan -->
    <div>
        <div class="pay-card" style="position:sticky;top:70px;">
            <div class="pay-card-header">
                <span style="font-size:18px;">🧾</span>
                <h2>Ringkasan Pesanan</h2>
            </div>
            <div class="pay-card-body">
                <!-- Item list -->
                @foreach($keranjangs as $item)
                <div class="ringkasan-item">
                    <div class="ringkasan-emoji">{{ $item->produk->emoji }}</div>
                    <div class="ringkasan-item-info">
                        <strong>{{ $item->produk->nama }}</strong>
                        <span>{{ $item->jumlah }} kg × Rp {{ number_format($item->produk->harga,0,',','.') }}</span>
                    </div>
                    <div class="ringkasan-price">Rp {{ number_format($item->subtotal,0,',','.') }}</div>
                </div>
                @endforeach

                <!-- Biaya -->
                <div style="margin-top:12px;padding-top:12px;border-top:1px solid var(--gray-100);">
                    <div class="r-row"><span>Subtotal ({{ $keranjangs->count() }} item)</span><span>Rp {{ number_format($subtotal,0,',','.') }}</span></div>
                    <div class="r-row"><span>Biaya Pengiriman</span><span>Rp {{ number_format($biayaPengiriman,0,',','.') }}</span></div>
                    <div class="r-row"><span>Biaya Admin</span><span>Rp {{ number_format($biayaAdmin,0,',','.') }}</span></div>
                    <div style="height:1px;background:var(--gray-200);margin:8px 0;"></div>
                    <div class="r-total"><span>Total</span><span>Rp {{ number_format($total,0,',','.') }}</span></div>
                </div>

                <button type="submit" class="btn-bayar" id="btn-bayar">
                    💳 Bayar Sekarang
                </button>
                <p style="font-size:11px;color:var(--gray-400);text-align:center;margin-top:8px;">
                    🔒 Transaksi aman & terenkripsi
                </p>
            </div>
        </div>
    </div>
</div>
</form>
@endsection

@push('scripts')
<script>
function pilihMetode(el, val) {
    document.querySelectorAll('.metode-item').forEach(i => {
        i.classList.remove('selected');
        i.querySelector('.metode-check').classList.remove('selected');
        i.querySelector('.metode-check').style.background = '';
        i.querySelector('.metode-check').style.borderColor = '';
    });
    el.classList.add('selected');
    const check = el.querySelector('.metode-check');
    check.style.background = 'var(--green)';
    check.style.borderColor = 'var(--green)';
    el.querySelector('input[type=radio]').checked = true;
}

// Disable tombol saat submit agar tidak double click
document.getElementById('form-bayar').addEventListener('submit', function() {
    const btn = document.getElementById('btn-bayar');
    btn.disabled = true;
    btn.innerHTML = '⏳ Memproses...';
});
</script>
@endpush
