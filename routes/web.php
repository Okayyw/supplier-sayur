<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\KatalogController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => redirect()->route('customer.login'));

// ─── AUTH ─────────────────────────────────────────────────────
Route::get('/login',        [AuthController::class, 'showCustomerLogin'])->name('customer.login');
Route::post('/login',       [AuthController::class, 'customerLogin'])->name('customer.login.post');
Route::get('/register',     [AuthController::class, 'showRegister'])->name('register');
Route::post('/register',    [AuthController::class, 'register'])->name('register.post');
Route::get('/admin/login',  [AuthController::class, 'showAdminLogin'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'adminLogin'])->name('admin.login.post');
Route::post('/logout',      [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ─── CUSTOMER ─────────────────────────────────────────────────
Route::middleware(['auth'])->group(function () {
    Route::get('/katalog', [KatalogController::class, 'index'])->name('katalog');

    // Keranjang
    Route::prefix('keranjang')->name('keranjang')->group(function () {
        Route::get('/',              [KeranjangController::class, 'index']);
        Route::post('/tambah',       [KeranjangController::class, 'tambah'])->name('.tambah');
        Route::patch('/{keranjang}', [KeranjangController::class, 'update'])->name('.update');
        Route::delete('/{keranjang}',[KeranjangController::class, 'hapus'])->name('.hapus');
        Route::post('/pesan-lagi',   [KeranjangController::class, 'pesanLagi'])->name('.pesan_lagi');
    });

    // Pembayaran
    Route::get('/pembayaran',        [PembayaranController::class, 'index'])->name('pembayaran');
    Route::post('/pembayaran',       [PembayaranController::class, 'proses'])->name('pembayaran.proses');

    // Riwayat
    Route::get('/riwayat',           [RiwayatController::class, 'index'])->name('riwayat');
    Route::get('/riwayat/{pesanan}', [RiwayatController::class, 'show'])->name('riwayat.show');

    // Profil
    Route::get('/profil',            [ProfilController::class, 'index'])->name('profil');
    Route::patch('/profil',          [ProfilController::class, 'update'])->name('profil.update');
    Route::patch('/profil/password', [ProfilController::class, 'updatePassword'])->name('profil.password');
});

// ─── ADMIN ────────────────────────────────────────────────────
Route::middleware(['auth','admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/',                           [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/produk',                     [AdminController::class, 'produkIndex'])->name('produk');
    Route::get('/produk/create',              [AdminController::class, 'produkCreate'])->name('produk.create');
    Route::post('/produk',                    [AdminController::class, 'produkStore'])->name('produk.store');
    Route::get('/produk/{produk}/edit',       [AdminController::class, 'produkEdit'])->name('produk.edit');
    Route::patch('/produk/{produk}',          [AdminController::class, 'produkUpdate'])->name('produk.update');
    Route::delete('/produk/{produk}',         [AdminController::class, 'produkDestroy'])->name('produk.destroy');
    Route::get('/pesanan',                    [AdminController::class, 'pesananIndex'])->name('pesanan');
    Route::get('/pesanan/{pesanan}',          [AdminController::class, 'pesananShow'])->name('pesanan.show');
    Route::patch('/pesanan/{pesanan}/status', [AdminController::class, 'pesananUpdateStatus'])->name('pesanan.status');
    Route::get('/customers',                  [AdminController::class, 'customerIndex'])->name('customers');
});
