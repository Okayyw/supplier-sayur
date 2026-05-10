<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar — Supplier Sayur</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/css/auth.css'])
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
                    class="form-control {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}"
                    placeholder="Ulangi password">
            </div>
        </div>

        <button type="submit" class="btn-submit">Daftar Sekarang</button>
    </form>

    <div class="auth-footer">
        Sudah punya akun? <a href="{{ route('login') }}" class="link-green">Login di sini</a>
    </div>
</div>
</body>
</html>