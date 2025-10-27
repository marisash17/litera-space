<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// Controller umum
use App\Http\Controllers\ProfileController;

// Controller admin
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\BukuController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\PeminjamanController;
use App\Http\Controllers\Admin\PengembalianController;
use App\Http\Controllers\Admin\DendaController;

// Controller user
use App\Http\Controllers\DashboardController as UserDashboard;
use App\Http\Controllers\RakPinjamController;

// Middleware
use App\Http\Middleware\IsAdmin;

// -------------------------------------------------
// Halaman utama → redirect ke login
// -------------------------------------------------
Route::get('/', function () {
    return redirect()->route('login');
});

// -------------------------------------------------
// 🔒 Routes untuk user & admin (auth wajib login)
// -------------------------------------------------
Route::middleware(['auth'])->group(function () {

    // -----------------------------
    // Dashboard (auto role)
    // -----------------------------
    Route::get('/dashboard', function (Request $request) {
        if (auth()->user()->role === 'admin') {
            return app(AdminDashboard::class)->index();
        }
        return app(UserDashboard::class)->index($request);
    })->name('dashboard');

    // -----------------------------
    // Rak Pinjam (user)
    // -----------------------------
    // Halaman rak pinjam
    Route::get('/rak-pinjam', [RakPinjamController::class, 'index'])->name('rak.pinjam');

    // Tambah buku ke rak pinjam → POST
    Route::post('/rak-pinjam/add/{id}', [RakPinjamController::class, 'pinjam'])->name('rak.add');

    // Kembalikan buku → POST
    Route::post('/rak-pinjam/kembalikan/{id}', [RakPinjamController::class, 'kembalikan'])->name('kembalikan.buku');

    // Baca buku → GET
    Route::get('/buku/baca/{id}', [RakPinjamController::class, 'baca'])->name('baca.buku');

    // Riwayat peminjaman
    Route::get('/riwayat', [RakPinjamController::class, 'riwayat'])->name('riwayat');
    Route::get('/riwayat-peminjaman', [RakPinjamController::class, 'riwayat'])->name('riwayat.peminjaman');
    
    // -----------------------------
    // Riwayat Peminjaman (user)
    // -----------------------------
    Route::get('/riwayat', [RakPinjamController::class, 'riwayat'])->name('riwayat');
    Route::get('/riwayat-peminjaman', [RakPinjamController::class, 'riwayat'])->name('riwayat.peminjaman');

    // -----------------------------
    // Profil (bawaan Breeze)
    // -----------------------------
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// -------------------------------------------------
// Routes khusus Admin (prefix: /admin)
// -------------------------------------------------
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', IsAdmin::class])
    ->group(function () {

        // Dashboard Admin
        Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

        // Buku
        Route::resource('buku', BukuController::class);

        // Member
        Route::resource('member', MemberController::class);

        // Peminjaman
        Route::resource('peminjaman', PeminjamanController::class)->except(['show']);
        Route::get('peminjaman/{id}/detail', [PeminjamanController::class, 'show'])->name('peminjaman.detail');
        Route::post('peminjaman/{id}/kembalikan', [PeminjamanController::class, 'kembalikan'])->name('peminjaman.kembalikan');
        // Kirim Pengingat & Denda
        Route::post('peminjaman/{id}/kirim-pengingat', [PeminjamanController::class, 'kirimPengingat'])->name('peminjaman.kirimPengingat');
        Route::post('peminjaman/{id}/kirim-denda', [PeminjamanController::class, 'kirimDenda'])->name('peminjaman.kirimDenda');


        // Pengembalian
        Route::resource('pengembalian', PengembalianController::class);

        // Denda
        Route::resource('denda', DendaController::class);
        Route::post('denda/{id}/bayar', [DendaController::class, 'bayar'])->name('denda.bayar');
    });

// -------------------------------------------------
// Auth routes Laravel Breeze (login, register, forgot password, dll.)
// -------------------------------------------------
require __DIR__ . '/auth.php';
