// ============================================================
// app.js — JavaScript utama Supplier Sayur
// ============================================================

/* ── PWA: Register Service Worker ──────────────────────────── */
if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
        navigator.serviceWorker.register('/sw.js')
            .then(reg => console.log('[PWA] Service Worker registered:', reg.scope))
            .catch(err => console.warn('[PWA] SW registration failed:', err));
    });
}

/* ── PWA: Install prompt ────────────────────────────────────── */
let deferredPrompt = null;
const installBanner = document.getElementById('pwa-install-banner');
const installBtn    = document.getElementById('pwa-install-btn');
const installDismiss= document.getElementById('pwa-install-dismiss');

window.addEventListener('beforeinstallprompt', e => {
    e.preventDefault();
    deferredPrompt = e;
    if (installBanner) installBanner.style.display = 'flex';
});

if (installBtn) {
    installBtn.addEventListener('click', async () => {
        if (!deferredPrompt) return;
        deferredPrompt.prompt();
        const { outcome } = await deferredPrompt.userChoice;
        console.log('[PWA] Install outcome:', outcome);
        deferredPrompt = null;
        if (installBanner) installBanner.style.display = 'none';
    });
}

if (installDismiss) {
    installDismiss.addEventListener('click', () => {
        if (installBanner) installBanner.style.display = 'none';
        sessionStorage.setItem('pwa-dismissed', '1');
    });
}

// Sembunyikan banner kalau sudah dismiss di session ini
if (sessionStorage.getItem('pwa-dismissed') && installBanner) {
    installBanner.style.display = 'none';
}

window.addEventListener('appinstalled', () => {
    console.log('[PWA] App installed!');
    if (installBanner) installBanner.style.display = 'none';
});

/* ── Sidebar Mobile ─────────────────────────────────────────── */
function openSidebar() {
    document.getElementById('sidebar')?.classList.add('open');
    document.getElementById('overlay')?.classList.add('show');
}
function closeSidebar() {
    document.getElementById('sidebar')?.classList.remove('open');
    document.getElementById('overlay')?.classList.remove('show');
}

/* ── Alert Auto-hide ────────────────────────────────────────── */
document.addEventListener('DOMContentLoaded', () => {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.transition = 'opacity .5s';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        }, 4000);
    });
});

/* ── Metode Pembayaran ──────────────────────────────────────── */
function pilihMetode(el, val) {
    document.querySelectorAll('.metode-item').forEach(item => {
        item.classList.remove('selected');
        const radio = item.querySelector('.metode-radio');
        if (radio) { radio.style.background = ''; radio.style.borderColor = ''; }
    });
    el.classList.add('selected');
    const radio = el.querySelector('.metode-radio');
    if (radio) { radio.style.background = 'var(--green)'; radio.style.borderColor = 'var(--green)'; }
    const input = el.querySelector('input[type=radio]');
    if (input) input.checked = true;
}

/* ── Form Submit: disable double click ──────────────────────── */
document.addEventListener('DOMContentLoaded', () => {
    const formBayar = document.getElementById('form-bayar');
    if (formBayar) {
        formBayar.addEventListener('submit', () => {
            const btn = document.getElementById('btn-bayar');
            if (btn) { btn.disabled = true; btn.innerHTML = '⏳ Memproses...'; }
        });
    }
});

/* ── Modal helper ───────────────────────────────────────────── */
function openModal(id)  { document.getElementById(id)?.classList.add('show'); }
function closeModal(id) { document.getElementById(id)?.classList.remove('show'); }

/* ── Gambar fallback ────────────────────────────────────────── */
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('img[data-fallback]').forEach(img => {
        img.addEventListener('error', function () {
            const fallback = this.getAttribute('data-fallback');
            if (fallback) {
                this.style.display = 'none';
                const parent = this.closest('.produk-img-wrap, .item-img, .ringkasan-img, .prod-img');
                if (parent) {
                    const fb = document.createElement('div');
                    fb.className = parent.className.replace(/[a-z-]+$/, '') + '-fallback';
                    fb.style.cssText = 'width:100%;height:100%;display:flex;align-items:center;justify-content:center;font-size:40px;';
                    fb.textContent = fallback;
                    parent.appendChild(fb);
                }
            }
        });
    });
});

/* ── Admin: toggle grid/table view ─────────────────────────── */
function switchView(view) {
    const grid  = document.getElementById('grid-view');
    const table = document.getElementById('table-view');
    const btnG  = document.getElementById('btn-grid');
    const btnT  = document.getElementById('btn-table');
    if (!grid || !table) return;
    if (view === 'grid') {
        grid.style.display = ''; table.style.display = 'none';
        btnG?.classList.add('active'); btnT?.classList.remove('active');
    } else {
        grid.style.display = 'none'; table.style.display = '';
        btnG?.classList.remove('active'); btnT?.classList.add('active');
    }
}
