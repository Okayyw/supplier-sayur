@extends('layouts.app')
@section('title', 'Pembayaran')
@section('page-title', 'Pembayaran')

@push('styles')
    @vite('resources/css/customer-pembayaran.css')
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
                    <div class="ringkasan-emoji">
                        @if($item->produk->gambar)
                            <img src="{{ asset('storage/' . $item->produk->gambar) }}" alt="{{ $item->produk->nama }}">
                        @else
                            {{ $item->produk->emoji }}
                        @endif
                    </div>
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
