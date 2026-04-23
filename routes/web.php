<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserBookController;
use App\Http\Controllers\DashboardController; // <-- Tambahkan import ini
use App\Http\Controllers\BookReturnController;
use App\Http\Middleware\RoleManager;

// Rute Halaman Utama (Landing Page)
Route::get('/', function () {
    return view('welcome');
});

// Rute Autentikasi (Login & Register)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route yang hanya bisa diakses jika sudah login (Middleware 'auth')
Route::middleware('auth')->group(function () {

    // =================================================================
    // GRUP RUTE KHUSUS ADMIN
    // =================================================================
    Route::middleware([RoleManager::class.':admin'])->group(function () {
        
        // Rute Dashboard Admin yang jauh lebih rapi
        Route::get('/admin/dashboard', [DashboardController::class, 'admin'])->name('admin.dashboard');

        Route::resource('/admin/kategori', CategoryController::class)
            ->names('admin.categories')
            ->parameters(['kategori' => 'kategori']);

        Route::resource('/admin/buku', BookController::class)
            ->names('admin.books')
            ->parameters(['buku' => 'buku']);

        // Rute Pengguna yang sudah diperbarui dengan fungsi 'store'
        Route::resource('/admin/pengguna', UserController::class)
            ->only(['index', 'store', 'update', 'destroy'])
            ->names('admin.users')
            ->parameters(['pengguna' => 'pengguna']);

        // Route untuk halaman Profil Admin
        Route::get('/admin/profil', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('admin.profile.edit');
        Route::put('/admin/profil', [\App\Http\Controllers\ProfileController::class, 'update'])->name('admin.profile.update');

        // ROUTE UNTUK TRANSAKSI PEMINJAMAN ADMIN
        Route::get('/admin/transaksi', [\App\Http\Controllers\AdminBorrowController::class, 'index'])->name('admin.borrows.index');
        Route::put('/admin/transaksi/{transaksi}/approve', [\App\Http\Controllers\AdminBorrowController::class, 'approve'])->name('admin.borrows.approve');
        Route::put('/admin/transaksi/{transaksi}/reject', [\App\Http\Controllers\AdminBorrowController::class, 'reject'])->name('admin.borrows.reject');
        Route::put('/admin/transaksi/{transaksi}/return', [\App\Http\Controllers\AdminBorrowController::class, 'returnBook'])->name('admin.borrows.return');
        
        // ROUTE UNTUK RIWAYAT PEMINJAMAN ADMIN
        Route::get('/admin/riwayat', [\App\Http\Controllers\AdminBorrowController::class, 'history'])->name('admin.borrows.history');

        // ROUTE UNTUK PENGEMBALIAN BUKU (BOOK RETURNS)
        Route::get('/admin/pengembalian', [BookReturnController::class, 'index'])->name('returns.index');
        Route::get('/admin/pengembalian/riwayat', [BookReturnController::class, 'history'])->name('returns.history');
        Route::get('/admin/pengembalian/{return}', [BookReturnController::class, 'show'])->name('returns.show');
        Route::get('/admin/pengembalian/{return}/edit', [BookReturnController::class, 'edit'])->name('returns.edit');
        Route::put('/admin/pengembalian/{return}', [BookReturnController::class, 'update'])->name('returns.update');
        Route::get('/admin/pengembalian-dashboard', [BookReturnController::class, 'dashboard'])->name('returns.dashboard');
    });

    // =================================================================
    // GRUP RUTE KHUSUS USER (MEMBER)
    // =================================================================
    Route::middleware([RoleManager::class.':user'])->group(function () {
        
        // ROUTE PROFIL USER
        Route::get('/user/profil', [ProfileController::class, 'userEdit'])->name('user.profile.edit');
        Route::put('/user/profil', [ProfileController::class, 'update'])->name('user.profile.update');

        // Dashboard User yang jauh lebih rapi
        Route::get('/user/dashboard', [DashboardController::class, 'user'])->name('user.dashboard');

        // Halaman Peminjaman Saya (Riwayat Keseluruhan)
        Route::get('/user/peminjaman', [UserBookController::class, 'history'])->name('user.borrows.history');

        // Halaman Jelajah Buku
        Route::get('/user/jelajah-buku', [UserBookController::class, 'index'])->name('user.books.index');
        
        // Halaman Detail Buku
        Route::get('/user/buku/{id}', [UserBookController::class, 'show'])->name('user.books.show');
        
        // Aksi Pinjam Buku
        Route::post('/user/buku/{id}/pinjam', [UserBookController::class, 'borrow'])->name('user.books.borrow');

        // AKSI KEMBALIKAN BUKU OLEH USER
        Route::put('/user/buku/{id}/kembalikan', [UserBookController::class, 'returnBook'])->name('user.books.return');
        
        // AKSI PEMBAYARAN DENDA
        Route::post('/user/bayar-denda', [UserBookController::class, 'payFine'])->name('user.pay-fine');
        
    });

});