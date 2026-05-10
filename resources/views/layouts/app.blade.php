<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Supplier Sayur') — Sayuran Segar Setiap Hari</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body>
<div class="overlay" id="overlay" onclick="closeSidebar()"></div>

<!-- SIDEBAR -->
<aside class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <div class="sidebar-brand-icon">🏪</div>
        <div class="sidebar-brand-text">
            <strong>Supplier Azam Heri</strong>
            <span>Sayuran Segar dan Berkualitas</span>
        </div>
    </div>
    <nav class="sidebar-nav">
        @if(auth()->user()->isAdmin())
            {{-- ── ADMIN NAVIGATION ── --}}
            <span class="nav-section-label">Menu Admin</span>
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <span class="nav-icon">📊</span> Dashboard
            </a>
            <a href="{{ route('admin.produk') }}" class="{{ request()->routeIs('admin.produk*') ? 'active' : '' }}">
                <span class="nav-icon">🥬</span> Produk
            </a>
            <a href="{{ route('admin.pesanan') }}" class="{{ request()->routeIs('admin.pesanan*') ? 'active' : '' }}">
                <span class="nav-icon">📦</span> Pesanan
            </a>
            <a href="{{ route('admin.customers') }}" class="{{ request()->routeIs('admin.customers') ? 'active' : '' }}">
                <span class="nav-icon">👥</span> Customers
            </a>
        @else
            {{-- ── CUSTOMER NAVIGATION ── --}}
            <span class="nav-section-label">Menu</span>
            <a href="{{ route('katalog') }}" class="{{ request()->routeIs('katalog') ? 'active' : '' }}">
                <span class="nav-icon">🏪</span> Katalog
            </a>
            <a href="{{ route('keranjang') }}" class="{{ request()->routeIs('keranjang') ? 'active' : '' }}">
                <span class="nav-icon">🛒</span> Keranjang
                @php $cartCount = auth()->user()->keranjangs()->count(); @endphp
                @if($cartCount > 0)
                    <span class="badge-count">{{ $cartCount }}</span>
                @endif
            </a>
            <a href="{{ route('riwayat') }}" class="{{ request()->routeIs('riwayat*') ? 'active' : '' }}">
                <span class="nav-icon">🕐</span> Riwayat
            </a>
            <a href="{{ route('profil') }}" class="{{ request()->routeIs('profil*') ? 'active' : '' }}">
                <span class="nav-icon">👤</span> Profil
            </a>
        @endif

        <div class="nav-divider"></div>

        {{-- ── LOGOUT ── --}}
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                style="width:100%;text-align:left;background:none;border:none;cursor:pointer;
                       display:flex;align-items:center;gap:10px;padding:9px 10px;border-radius:8px;
                       font-size:13.5px;font-weight:500;color:var(--red);font-family:inherit;
                       transition:background .15s;"
                onmouseover="this.style.background='#fee2e2'"
                onmouseout="this.style.background='none'">
                <span class="nav-icon">🚪</span> Keluar
            </button>
        </form>
    </nav>
</aside>

<!-- MAIN -->
<div class="main-wrap">
    <header class="topbar">
        <button class="hamburger" onclick="openSidebar()">☰</button>
        <span class="topbar-title">@yield('page-title', 'Dashboard')</span>
        <div class="topbar-user">
            <div class="topbar-user-info">
                <strong>{{ auth()->user()->nama_toko }}</strong>
                <span>{{ auth()->user()->email }}</span>
            </div>
            <div class="avatar">{{ auth()->user()->inisial }}</div>
        </div>
    </header>

    <main class="page-content">
        @if(session('success'))
            <div class="alert alert-success">✅ {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">❌ {{ session('error') }}</div>
        @endif

        @yield('content')
    </main>
</div>

<script>
function openSidebar()  { document.getElementById('sidebar').classList.add('open');  document.getElementById('overlay').classList.add('show'); }
function closeSidebar() { document.getElementById('sidebar').classList.remove('open'); document.getElementById('overlay').classList.remove('show'); }
</script>
@stack('scripts')
</body>
</html>
