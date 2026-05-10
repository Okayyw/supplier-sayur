import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/auth.css',
                'resources/css/admin-dashboard.css',
                'resources/css/admin-pesanan.css',
                'resources/css/admin-pesanan-show.css',
                'resources/css/admin-customer.css',
                'resources/css/customer-katalog.css',
                'resources/css/customer-keranjang.css',
                'resources/css/customer-pembayaran.css',
                'resources/css/customer-riwayat.css',
                'resources/css/customer-riwayat-detail.css',
                'resources/css/customer-profil.css',
                'resources/css/welcome.css',
                'resources/js/app.js'
            ],
            refresh: true,
        }),
    ],
});
