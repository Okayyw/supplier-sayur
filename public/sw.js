// ============================================================
// sw.js — Service Worker untuk PWA Supplier Sayur
// ============================================================

const CACHE_NAME     = 'supplier-sayur-v1';
const STATIC_CACHE   = 'supplier-sayur-static-v1';

// File yang di-cache saat install
const STATIC_ASSETS = [
    '/css/base.css',
    '/css/layout.css',
    '/css/components.css',
    '/css/katalog.css',
    '/css/keranjang.css',
    '/css/pages.css',
    '/js/app.js',
    '/manifest.json',
    '/offline.html',
];

// ── Install ──────────────────────────────────────────────────
self.addEventListener('install', event => {
    console.log('[SW] Installing...');
    event.waitUntil(
        caches.open(STATIC_CACHE)
            .then(cache => {
                console.log('[SW] Caching static assets');
                return cache.addAll(STATIC_ASSETS);
            })
            .then(() => self.skipWaiting())
    );
});

// ── Activate ─────────────────────────────────────────────────
self.addEventListener('activate', event => {
    console.log('[SW] Activating...');
    event.waitUntil(
        caches.keys().then(keys =>
            Promise.all(
                keys.filter(k => k !== CACHE_NAME && k !== STATIC_CACHE)
                    .map(k => caches.delete(k))
            )
        ).then(() => self.clients.claim())
    );
});

// ── Fetch ─────────────────────────────────────────────────────
self.addEventListener('fetch', event => {
    const { request } = event;
    const url = new URL(request.url);

    // Hanya handle GET request
    if (request.method !== 'GET') return;

    // Abaikan request ke domain eksternal (Unsplash, fonts, dll)
    if (url.origin !== self.location.origin) {
        event.respondWith(
            fetch(request).catch(() => new Response('', { status: 408 }))
        );
        return;
    }

    // CSS, JS, images → Cache First
    if (
        url.pathname.startsWith('/css/') ||
        url.pathname.startsWith('/js/')  ||
        url.pathname.startsWith('/icons/')
    ) {
        event.respondWith(
            caches.match(request).then(cached =>
                cached || fetch(request).then(response => {
                    const clone = response.clone();
                    caches.open(STATIC_CACHE).then(c => c.put(request, clone));
                    return response;
                })
            )
        );
        return;
    }

    // HTML pages → Network First, fallback ke cache, lalu offline page
    if (request.headers.get('accept')?.includes('text/html')) {
        event.respondWith(
            fetch(request)
                .then(response => {
                    const clone = response.clone();
                    caches.open(CACHE_NAME).then(c => c.put(request, clone));
                    return response;
                })
                .catch(() =>
                    caches.match(request)
                        .then(cached => cached || caches.match('/offline.html'))
                )
        );
        return;
    }

    // Lainnya → Network first
    event.respondWith(
        fetch(request).catch(() => caches.match(request))
    );
});

// ── Background Sync (opsional) ────────────────────────────────
self.addEventListener('sync', event => {
    if (event.tag === 'sync-pesanan') {
        console.log('[SW] Background sync: pesanan');
    }
});

// ── Push Notification (opsional) ─────────────────────────────
self.addEventListener('push', event => {
    if (!event.data) return;
    const data = event.data.json();
    event.waitUntil(
        self.registration.showNotification(data.title || 'Supplier Sayur', {
            body: data.body || 'Ada update pesanan Anda.',
            icon: '/icons/icon-192.png',
            badge: '/icons/icon-72.png',
            tag: 'pesanan-update',
            data: { url: data.url || '/riwayat' }
        })
    );
});

self.addEventListener('notificationclick', event => {
    event.notification.close();
    event.waitUntil(
        clients.openWindow(event.notification.data?.url || '/katalog')
    );
});
