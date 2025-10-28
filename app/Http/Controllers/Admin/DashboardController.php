<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Member;
use App\Models\Peminjaman;
use App\Models\Denda;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Total buku
        $totalBuku = Buku::count();

        // Total member
        $totalMember = Member::count();

        // Peminjaman aktif: status masih dipinjam atau terlambat
        $peminjamanAktif = Peminjaman::whereIn('status', ['dipinjam', 'terlambat'])->count();

        // Total denda tertunggak (belum dibayar)
        $totalDenda = Denda::where('status_pembayaran', 0)->sum('jumlah_denda');

        // Peminjaman hari ini
        $peminjamanHariIni = Peminjaman::whereDate('tanggal_peminjaman', Carbon::today())->count();

        // Pengembalian bulan ini
        $pengembalianBulanIni = Peminjaman::whereMonth('tanggal_dikembalikan', Carbon::now()->month)
                                          ->whereNotNull('tanggal_dikembalikan')
                                          ->count();

        // Buku paling populer
        $bukuPopuler = Buku::withCount('peminjaman')
                            ->orderBy('peminjaman_count', 'desc')
                            ->take(5)
                            ->get();

        return view('admin.dashboard', compact(
            'totalBuku',
            'totalMember',
            'peminjamanAktif',
            'totalDenda',
            'peminjamanHariIni',
            'pengembalianBulanIni',
            'bukuPopuler'
        ));
    }
}
