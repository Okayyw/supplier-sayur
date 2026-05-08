<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin — Supplier Sayur</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --gray-50: #f9fafb; --gray-100: #f3f4f6; --gray-200: #e5e7eb;
            --gray-400: #9ca3af; --gray-500: #6b7280; --gray-700: #374151; --gray-900: #111827;
            --red: #ef4444;
        }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
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
            box-shadow: 0 8px 40px rgba(0,0,0,.3);
            overflow: hidden;
            min-height: 520px;
        }
        /* LEFT PANEL */
        .left-panel {
            flex: 1;
            background: linear-gradient(160deg, #0f172a 0%, #1e293b 60%, #334155 100%);
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
            background: rgba(255,255,255,.1);
            border: 1px solid rgba(255,255,255,.2);
            border-radius: 14px;
            display: grid; place-items: center;
            font-size: 24px;
        }
        .left-panel .brand-name { font-size: 18px; font-weight: 700; }
        .left-panel .brand-sub { font-size: 12px; opacity: .6; }
        .left-panel h2 {
            font-size: 26px;
            font-weight: 800;
            margin-bottom: 12px;
            line-height: 1.3;
        }
        .left-panel p {
            font-size: 13.5px;
            opacity: .7;
            line-height: 1.7;
            margin-bottom: 32px;
        }
        .admin-features { list-style: none; }
        .admin-features li {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 13px;
            margin-bottom: 10px;
            opacity: .8;
        }
        .admin-features li .dot {
            width: 6px; height: 6px;
            border-radius: 50%;
            background: #64748b;
            flex-shrink: 0;
        }
        .customer-link {
            margin-top: auto;
            padding-top: 32px;
            font-size: 12.5px;
            opacity: .6;
        }
        .customer-link a {
            color: #94a3b8;
            font-weight: 600;
            text-decoration: underline;
        }
        .customer-link a:hover { opacity: 1; }

        /* RIGHT PANEL */
        .right-panel {
            width: 380px;
            padding: 48px 36px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .admin-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #1e293b;
            color: #94a3b8;
            font-size: 11px;
            font-weight: 700;
            padding: 4px 12px;
            border-radius: 20px;
            margin-bottom: 16px;
            letter-spacing: .05em;
            text-transform: uppercase;
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
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 10px 14px;
            margin-bottom: 22px;
            font-size: 12px;
            color: #475569;
        }
        .demo-box strong { display: block; margin-bottom: 2px; color: #1e293b; }
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
            transition: border-color .15s;
        }
        .form-control:focus { border-color: #1e293b; background: #fff; }
        .form-control.is-invalid { border-color: var(--red); }
        .invalid-feedback { color: var(--red); font-size: 11.5px; margin-top: 4px; }
        .form-bottom {
            display: flex; align-items: center;
            justify-content: space-between;
            margin-bottom: 18px;
        }
        .form-bottom label { display: flex; align-items: center; gap: 6px; font-size: 12.5px; color: var(--gray-700); cursor: pointer; }
        .btn-submit {
            width: 100%;
            padding: 11px;
            background: #1e293b;
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
        .btn-submit:hover { background: #0f172a; }
        .alert-danger {
            background: #fee2e2; color: #dc2626;
            padding: 9px 12px; border-radius: 8px;
            font-size: 12.5px; margin-bottom: 14px;
        }
        .security-note {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 11.5px;
            color: var(--gray-400);
            text-align: center;
            justify-content: center;
        }
        @media (max-width: 680px) {
            .wrapper { flex-direction: column; }
            .left-panel { padding: 28px 24px; }
            .right-panel { width: 100%; padding: 28px 24px; }
        }
    </style>
</head>
<body>
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