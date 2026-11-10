<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PengaturanController;

// ========================================
// ROOT REDIRECT
// ========================================
Route::get('/', function () {
    return redirect()->route('welcome');
});

// ========================================
// AUTHENTICATION ROUTES (3 Screen Flow)
// ========================================

// Screen 1: Welcome (tampil pertama kali)
Route::get('/welcome', function () {
    return view('auth.welcome');
})->name('welcome');

// Screen 2: Register
Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

// Screen 3: Login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

// Logout
Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

// ========================================
// PROTECTED ROUTES (Butuh Login)
// ========================================
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ========================================
    // KATEGORI - Admin only
    // ========================================
    Route::middleware(['permission:kategori.kelola'])->group(function () {
        Route::resource('kategori', KategoriController::class);
    });

    // ========================================
    // BUKU
    // ========================================

Route::middleware(['permission:buku.tambah'])->group(function () {
    Route::get('/buku/create', [BukuController::class, 'create'])->name('buku.create');
    Route::post('/buku', [BukuController::class, 'store'])->name('buku.store');
});


Route::middleware(['permission:buku.lihat'])->group(function () {
    Route::get('/buku', [BukuController::class, 'index'])->name('buku.index');
    Route::get('/buku/{buku}', [BukuController::class, 'show'])->name('buku.show');
});


Route::middleware(['permission:buku.edit'])->group(function () {
    Route::get('/buku/{buku}/edit', [BukuController::class, 'edit'])->name('buku.edit');
    Route::put('/buku/{buku}', [BukuController::class, 'update'])->name('buku.update');
});

Route::middleware(['permission:buku.hapus'])->group(function () {
    Route::delete('/buku/{buku}', [BukuController::class, 'destroy'])->name('buku.destroy');
});

    // ========================================
    // PELANGGAN
    // ========================================
    Route::middleware(['permission:pelanggan.lihat'])->group(function () {
        Route::get('/pelanggan', [PelangganController::class, 'index'])->name('pelanggan.index');
    });

    Route::middleware(['permission:pelanggan.tambah'])->group(function () {
        Route::get('/pelanggan/create', [PelangganController::class, 'create'])->name('pelanggan.create');
        Route::post('/pelanggan', [PelangganController::class, 'store'])->name('pelanggan.store');
    });

    Route::middleware(['permission:pelanggan.edit'])->group(function () {
        Route::get('/pelanggan/{pelanggan}/edit', [PelangganController::class, 'edit'])->name('pelanggan.edit');
        Route::put('/pelanggan/{pelanggan}', [PelangganController::class, 'update'])->name('pelanggan.update');
        Route::delete('/pelanggan/{pelanggan}', [PelangganController::class, 'destroy'])->name('pelanggan.destroy');
    });

    // ========================================
    // SUPPLIER
    // ========================================
    Route::middleware(['permission:supplier.lihat'])->group(function () {
        Route::get('/supplier', [SupplierController::class, 'index'])->name('supplier.index');
    });

    Route::middleware(['permission:supplier.kelola'])->group(function () {
        Route::get('/supplier/create', [SupplierController::class, 'create'])->name('supplier.create');
        Route::post('/supplier', [SupplierController::class, 'store'])->name('supplier.store');
        Route::get('/supplier/{supplier}/edit', [SupplierController::class, 'edit'])->name('supplier.edit');
        Route::put('/supplier/{supplier}', [SupplierController::class, 'update'])->name('supplier.update');
        Route::delete('/supplier/{supplier}', [SupplierController::class, 'destroy'])->name('supplier.destroy');
    });

    // ========================================
    // TRANSAKSI - URUTAN PENTING!
    // ========================================
    // ➤ 1. PROSES TRANSAKSI BARU (POS) - PALING ATAS!
    Route::middleware(['permission:transaksi.proses'])->group(function () {
        Route::get('/transaksi/create', [TransaksiController::class, 'create'])->name('transaksi.create');
        Route::post('/transaksi', [TransaksiController::class, 'store'])->name('transaksi.store');
        Route::get('/api/cari-buku', [TransaksiController::class, 'cariBuku'])->name('api.cari-buku');
    });

    // ➤ 2. LIHAT TRANSAKSI
    Route::middleware(['permission:transaksi.lihat-semua|transaksi.lihat-sendiri'])->group(function () {
        Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
        Route::get('/transaksi/{transaksi}', [TransaksiController::class, 'show'])->name('transaksi.show');
        Route::get('/transaksi/{transaksi}/nota', [TransaksiController::class, 'nota'])->name('transaksi.nota');
    });

    // ➤ 3. BATALKAN TRANSAKSI
    Route::middleware(['permission:transaksi.batal'])->group(function () {
        Route::post('/transaksi/{transaksi}/batal', [TransaksiController::class, 'batal'])->name('transaksi.batal');
    });

    // ========================================
    // STOK MASUK - URUTAN BENAR
    // ========================================
    Route::middleware(['permission:stok.catat-masuk'])->group(function () {
        Route::get('/stok/create', [StokController::class, 'create'])->name('stok.create');
        Route::post('/stok', [StokController::class, 'store'])->name('stok.store');
    });

    Route::middleware(['permission:stok.lihat'])->group(function () {
        Route::get('/stok', [StokController::class, 'index'])->name('stok.index');
        Route::get('/stok/{stokMasuk}', [StokController::class, 'show'])->name('stok.show');
    });

    // ========================================
// LAPORAN
// ========================================
Route::middleware(['permission:laporan.lihat'])->group(function () {
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/penjualan', [LaporanController::class, 'penjualan'])->name('laporan.penjualan');
    Route::get('/laporan/stok', [LaporanController::class, 'stok'])->name('laporan.stok');
    Route::get('/laporan/kategori', [LaporanController::class, 'kategori'])->name('laporan.kategori');
});

    // ========================================
    // PENGATURAN - Admin only
    // ========================================
    Route::middleware(['permission:pengaturan.kelola'])->group(function () {
        Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan.index');
        Route::put('/pengaturan', [PengaturanController::class, 'update'])->name('pengaturan.update');
    });
});