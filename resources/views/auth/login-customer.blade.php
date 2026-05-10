<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Customer — Supplier Sayur</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/css/auth.css'])
</head>
<body class="auth-page">
<div class="wrapper">
    <!-- LEFT -->
    <div class="left-panel">
        <div class="brand">
            <div class="brand-icon">🏪</div>
            <div>
                <div class="brand-name">Supplier Sayur</div>
                <div class="brand-sub">Sayuran Segar Setiap Hari</div>
            </div>
        </div>

        <h2>Selamat Datang,<br>Pelanggan Kami!</h2>
        <p>Pesan sayuran segar berkualitas langsung dari supplier terpercaya. Tersedia berbagai pilihan sayur setiap hari.</p>

        <ul class="feature-list">
            <li><span class="check">✓</span> Katalog produk lengkap & terupdate</li>
            <li><span class="check">✓</span> Pemesanan mudah & cepat</li>
            <li><span class="check">✓</span> Pengiriman ke lokasi Anda</li>
            <li><span class="check">✓</span> Poin loyalitas setiap pembelian</li>
        </ul>

        <div class="admin-link">
            Anda admin? <a href="{{ route('admin.login') }}">Login ke Panel Admin →</a>
        </div>
    </div>

    <!-- RIGHT -->
    <div class="right-panel">
        <h1>Login Customer</h1>
        <p class="subtitle">Masuk untuk mulai berbelanja sayuran segar</p>

        <div class="demo-box">
            <strong>🔑 Demo Login:</strong>
            Email: tokoberkah@email.com &nbsp;|&nbsp; Password: customer123
        </div>

        @if($errors->any())
            <div class="alert-danger">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('customer.login.post') }}">
            @csrf
            <div class="form-group">
                <label class="form-label">Email</label>
                <div class="input-wrap">
                    <span class="input-icon">✉️</span>
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                        placeholder="nama@email.com" autofocus>
                </div>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label class="form-label">Password</label>
                <div class="input-wrap">
                    <span class="input-icon">🔒</span>
                    <input type="password" name="password"
                        class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                        placeholder="Masukkan password">
                </div>
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="form-bottom">
                <label>
                    <input type="checkbox" name="remember"> Ingat saya
                </label>
                <a href="#" class="link-green">Lupa password?</a>
            </div>

            <button type="submit" class="btn-submit">Masuk</button>
        </form>

        <div class="auth-footer">
            Belum punya akun? <a href="{{ route('register') }}" class="link-green">Daftar sekarang</a>
        </div>
    </div>
</div>
</body>
</html>