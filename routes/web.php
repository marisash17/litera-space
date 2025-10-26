<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RakPinjamController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Halaman pertama diarahkan ke login (Breeze default).
| Setelah login, user masuk ke dashboard dari RakPinjamController.
|
*/

// -----------------------------
// 🟢 HALAMAN LOGIN (awal)
// -----------------------------
Route::get('/', function () {
<<<<<<< HEAD
    return view('auth.login'); // karena kita pindahkan view ke folder auth
=======
    // Langsung arahkan ke halaman login Breeze
    return redirect()->route('login');
>>>>>>> 86793c908b3418c90d835939aba613fac33d469c
});

// -----------------------------
// 🔒 HALAMAN KHUSUS USER LOGIN
// -----------------------------
Route::middleware(['auth'])->group(function () {

    // 🏠 Dashboard user
    Route::get('/dashboard', [RakPinjamController::class, 'dashboard'])->name('dashboard');

    // 📚 Rak Pinjam
    Route::get('/rak-pinjam', [RakPinjamController::class, 'index'])->name('rak.pinjam');
    Route::get('/buku/baca/{id}', [RakPinjamController::class, 'baca'])->name('buku.baca');
    Route::get('/buku/kembalikan/{id}', [RakPinjamController::class, 'kembalikan'])->name('buku.kembalikan');

    // 🕘 Riwayat Peminjaman
    Route::get('/riwayat', [RakPinjamController::class, 'riwayat'])->name('riwayat');
    Route::get('/riwayat-peminjaman', [RakPinjamController::class, 'riwayat'])->name('riwayat.peminjaman');

    // 👤 Profil user (dari Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

<<<<<<< HEAD
// Route autentikasi bawaan Breeze
require __DIR__.'/auth.php';
=======
// -----------------------------
// 🧩 AUTH ROUTES (dari Breeze)
// -----------------------------
require __DIR__ . '/auth.php';
>>>>>>> 86793c908b3418c90d835939aba613fac33d469c
