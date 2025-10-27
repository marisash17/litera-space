<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Buku;
use App\Models\Member;
use App\Models\Peminjaman;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // View Composer untuk sidebar statistik cepat
        View::composer('layouts.admin', function ($view) {
            $totalBuku = Buku::count();
            $totalMember = Member::count();
            $peminjamanAktif = Peminjaman::where('status', 'dipinjam')->count();

            $view->with(compact('totalBuku', 'totalMember', 'peminjamanAktif'));
        });
    }
}
