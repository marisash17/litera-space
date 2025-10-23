<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Halaman utama langsung arahkan ke login
Route::get('/', function () {
    return redirect('/login');
});

// Grup route untuk user yang sudah login
Route::middleware(['auth'])->group(function () {
    // Route profil (dibutuhkan oleh Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Dashboard admin dan user
    Route::get('/dashboard', function () {
        if (auth()->user()->role === 'admin') {
            return view('admin.dashboard');
        } else {
            return view('user.dashboard');
        }
    })->name('dashboard');
});

// Route autentikasi bawaan Breeze
require __DIR__.'/auth.php';
