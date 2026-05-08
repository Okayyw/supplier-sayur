<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Customer — Supplier Sayur</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --green: #22c55e; --green-dark: #16a34a; --green-light: #dcfce7;
            --gray-50: #f9fafb; --gray-100: #f3f4f6; --gray-200: #e5e7eb;
            --gray-400: #9ca3af; --gray-500: #6b7280; --gray-700: #374151; --gray-900: #111827;
            --red: #ef4444;
        }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .wrapper {
            display: flex;
            width: 100%;
            max-width: 900px;
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 8px 40px rgba(0,0,0,.1);
            overflow: hidden;
            min-height: 520px;
        }
        /* LEFT PANEL */
        .left-panel {
            flex: 1;
            background: linear-gradient(160deg, #16a34a 0%, #22c55e 60%, #4ade80 100%);
            padding: 48px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            color: #fff;
        }
        .left-panel .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 40px;
        }
        .left-panel .brand-icon {
            width: 48px; height: 48px;
            background: rgba(255,255,255,.25);
            border-radius: 14px;
            display: grid; place-items: center;
            font-size: 24px;
        }
        .left-panel .brand-name {
            font-size: 18px;
            font-weight: 700;
        }
        .left-panel .brand-sub {
            font-size: 12px;
            opacity: .8;
        }
        .left-panel h2 {
            font-size: 26px;
            font-weight: 800;
            margin-bottom: 12px;
            line-height: 1.3;
        }
        .left-panel p {
            font-size: 13.5px;
            opacity: .85;
            line-height: 1.7;
            margin-bottom: 32px;
        }
        .feature-list { list-style: none; }
        .feature-list li {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 13px;
            margin-bottom: 10px;
            opacity: .9;
        }
        .feature-list li span.check {
            width: 20px; height: 20px;
            background: rgba(255,255,255,.3);
            border-radius: 50%;
            display: grid; place-items: center;
            font-size: 11px;
            flex-shrink: 0;
        }
        .admin-link {
            margin-top: auto;
            padding-top: 32px;
            font-size: 12.5px;
            opacity: .8;
        }
        .admin-link a {
            color: #fff;
            font-weight: 700;
            text-decoration: underline;
        }

        /* RIGHT PANEL */
        .right-panel {
            width: 380px;
            padding: 48px 36px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .right-panel h1 {
            font-size: 22px;
            font-weight: 800;
            color: var(--gray-900);
            margin-bottom: 4px;
        }
        .right-panel .subtitle {
            font-size: 13px;
            color: var(--gray-500);
            margin-bottom: 28px;
        }
        .demo-box {
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            border-radius: 8px;
            padding: 10px 14px;
            margin-bottom: 22px;
            font-size: 12px;
            color: #1d4ed8;
        }
        .demo-box strong { display: block; margin-bottom: 2px; }
        .form-group { margin-bottom: 14px; }
        .form-label { display: block; font-size: 12.5px; font-weight: 600; color: var(--gray-700); margin-bottom: 5px; }
        .input-wrap { position: relative; }
        .input-icon { position: absolute; left: 11px; top: 50%; transform: translateY(-50%); font-size: 14px; color: var(--gray-400); }
        .form-control {
            width: 100%;
            padding: 10px 12px 10px 34px;
            border: 1.5px solid var(--gray-200);
            border-radius: 8px;
            font-size: 13.5px;
            font-family: inherit;
            background: var(--gray-50);
            color: var(--gray-900);
            outline: none;
            transition: border-color .15s, background .15s;
        }
        .form-control:focus { border-color: var(--green); background: #fff; }
        .form-control.is-invalid { border-color: var(--red); }
        .invalid-feedback { color: var(--red); font-size: 11.5px; margin-top: 4px; }
        .form-bottom {
            display: flex; align-items: center;
            justify-content: space-between;
            margin-bottom: 18px;
        }
        .form-bottom label { display: flex; align-items: center; gap: 6px; font-size: 12.5px; color: var(--gray-700); cursor: pointer; }
        .link-green { color: var(--green-dark); font-size: 12.5px; text-decoration: none; font-weight: 600; }
        .link-green:hover { text-decoration: underline; }
        .btn-submit {
            width: 100%;
            padding: 11px;
            background: var(--green-dark);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            font-family: inherit;
            transition: background .15s;
            margin-bottom: 16px;
        }
        .btn-submit:hover { background: #15803d; }
        .auth-footer { text-align: center; font-size: 12.5px; color: var(--gray-500); }
        .alert-danger {
            background: #fee2e2; color: #dc2626;
            padding: 9px 12px; border-radius: 8px;
            font-size: 12.5px; margin-bottom: 16px;
        }
        @media (max-width: 680px) {
            .wrapper { flex-direction: column; }
            .left-panel { padding: 28px 24px; }
            .left-panel h2 { font-size: 20px; }
            .right-panel { width: 100%; padding: 28px 24px; }
        }
    </style>
</head>
<body>
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