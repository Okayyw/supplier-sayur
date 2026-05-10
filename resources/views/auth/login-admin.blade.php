<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin — Supplier Sayur</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/css/auth.css'])
</head>
<body class="auth-page admin">
<div class="wrapper">
    <!-- LEFT -->
    <div class="left-panel">
        <div class="brand">
            <div class="brand-icon">⚙️</div>
            <div>
                <div class="brand-name">Supplier Sayur</div>
                <div class="brand-sub">Panel Manajemen</div>
            </div>
        </div>

        <h2>Panel Admin<br>Supplier Sayur</h2>
        <p>Kelola seluruh operasional bisnis sayur Anda dari satu tempat. Akses terbatas hanya untuk administrator.</p>

        <ul class="admin-features">
            <li><span class="dot"></span> Manajemen produk & stok</li>
            <li><span class="dot"></span> Monitoring pesanan real-time</li>
            <li><span class="dot"></span> Data & statistik customer</li>
            <li><span class="dot"></span> Laporan penjualan</li>
        </ul>

        <div class="customer-link">
            Bukan admin? <a href="{{ route('customer.login') }}">Login sebagai Customer →</a>
        </div>
    </div>

    <!-- RIGHT -->
    <div class="right-panel">
        <div class="admin-badge">🔐 Admin Only</div>
        <h1>Masuk ke Dashboard</h1>
        <p class="subtitle">Hanya akun administrator yang dapat mengakses halaman ini</p>

        <div class="demo-box">
            <strong>🔑 Demo Admin:</strong>
            Email: admin@supplier.com &nbsp;|&nbsp; Password: admin123
        </div>

        @if($errors->any())
            <div class="alert-danger">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('admin.login.post') }}">
            @csrf
            <div class="form-group">
                <label class="form-label">Email Admin</label>
                <div class="input-wrap">
                    <span class="input-icon">✉️</span>
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                        placeholder="admin@supplier.com" autofocus>
                </div>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label class="form-label">Password</label>
                <div class="input-wrap">
                    <span class="input-icon">🔒</span>
                    <input type="password" name="password"
                        class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                        placeholder="Masukkan password admin">
                </div>
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="form-bottom">
                <label>
                    <input type="checkbox" name="remember"> Ingat saya
                </label>
            </div>

            <button type="submit" class="btn-submit">🔐 Masuk ke Dashboard</button>
        </form>

        <div class="security-note">
            🛡️ Koneksi aman &nbsp;|&nbsp; Akses terbatas admin
        </div>
    </div>
</div>
</body>
</html>