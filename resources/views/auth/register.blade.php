<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar — Supplier Sayur</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --green: #22c55e; --green-dark: #16a34a;
            --gray-50: #f9fafb; --gray-100: #f3f4f6; --gray-200: #e5e7eb;
            --gray-400: #9ca3af; --gray-500: #6b7280; --gray-700: #374151; --gray-900: #111827;
            --red: #ef4444;
        }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #f0fdf4;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .auth-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(0,0,0,.08);
            width: 100%;
            max-width: 480px;
            padding: 32px;
        }
        .auth-logo { text-align: center; margin-bottom: 24px; }
        .auth-logo-icon {
            width: 50px; height: 50px;
            background: var(--green);
            border-radius: 14px;
            display: inline-grid; place-items: center;
            font-size: 24px;
            margin-bottom: 10px;
        }
        .auth-logo h1 { font-size: 19px; font-weight: 700; color: var(--gray-900); }
        .auth-logo p  { font-size: 12.5px; color: var(--gray-500); margin-top: 2px; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
        .form-group { margin-bottom: 12px; }
        .form-label { display: block; font-size: 13px; font-weight: 600; color: var(--gray-700); margin-bottom: 5px; }
        .form-control {
            width: 100%;
            padding: 9px 12px;
            border: 1.5px solid var(--gray-200);
            border-radius: 8px;
            font-size: 13.5px;
            font-family: inherit;
            background: var(--gray-50);
            color: var(--gray-900);
            outline: none;
            transition: border-color .15s;
        }
        .form-control:focus { border-color: var(--green); background: #fff; }
        .form-control.is-invalid { border-color: var(--red); }
        .invalid-feedback { color: var(--red); font-size: 12px; margin-top: 3px; }
        .btn-submit {
            width: 100%;
            padding: 11px;
            background: var(--gray-900);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            font-family: inherit;
            transition: background .15s;
            margin-top: 4px;
            margin-bottom: 14px;
        }
        .btn-submit:hover { background: #1f2937; }
        .auth-footer { text-align: center; font-size: 13px; color: var(--gray-500); }
        .link-green { color: var(--green-dark); text-decoration: none; font-weight: 600; }
        .link-green:hover { text-decoration: underline; }
        .alert-danger {
            background: #fee2e2; color: #dc2626;
            padding: 10px 14px; border-radius: 8px;
            font-size: 13px; margin-bottom: 14px;
        }
        @media (max-width: 480px) { .form-row { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
<div class="auth-card">
    <div class="auth-logo">
        <div class="auth-logo-icon">🏪</div>
        <h1>Daftar Akun Baru</h1>
        <p>Bergabung dan nikmati sayuran segar setiap hari</p>
    </div>

    @if($errors->any())
        <div class="alert-danger">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('register.post') }}">
        @csrf
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Nama Toko / Usaha</label>
                <input type="text" name="nama_toko" value="{{ old('nama_toko') }}"
                    class="form-control {{ $errors->has('nama_toko') ? 'is-invalid' : '' }}"
                    placeholder="Toko Berkah">
                @error('nama_toko')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label">Nama Pemilik</label>
                <input type="text" name="nama_pemilik" value="{{ old('nama_pemilik') }}"
                    class="form-control {{ $errors->has('nama_pemilik') ? 'is-invalid' : '' }}"
                    placeholder="Budi Santoso">
                @error('nama_pemilik')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" name="email" value="{{ old('email') }}"
                    class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                    placeholder="nama@email.com">
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label">Nomor Telepon</label>
                <input type="text" name="nomor_telepon" value="{{ old('nomor_telepon') }}"
                    class="form-control {{ $errors->has('nomor_telepon') ? 'is-invalid' : '' }}"
                    placeholder="0812-3456-7890">
                @error('nomor_telepon')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Alamat Lengkap</label>
            <textarea name="alamat" rows="2"
                class="form-control {{ $errors->has('alamat') ? 'is-invalid' : '' }}"
                placeholder="Jl. Contoh No. 123, Kota, Provinsi">{{ old('alamat') }}</textarea>
            @error('alamat')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password" name="password"
                    class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                    placeholder="Min. 6 karakter">
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label">Konfirmasi Password</label>
                <input type="password" name="password_confirmation"
                    class="form-control"
                    placeholder="Ulangi password">
            </div>
        </div>

        <button type="submit" class="btn-submit">Daftar Sekarang</button>
    </form>

    
</div>
</body>
</html>