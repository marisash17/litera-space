<?php

namespace App\Http\Controllers;

use App\Models\Buku; // pakai model Buku yang di admin
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = Buku::query();

        // Search hanya kalau ada input
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;

            // Kolom kategori dicek dulu
            if (Schema::hasColumn('buku', 'kategori')) {
                $query->where(function($q) use ($search) {
                    $q->where('judul', 'like', "%$search%")
                      ->orWhere('penulis', 'like', "%$search%")
                      ->orWhere('kategori', 'like', "%$search%");
                });
            } else {
                $query->where(function($q) use ($search) {
                    $q->where('judul', 'like', "%$search%")
                      ->orWhere('penulis', 'like', "%$search%");
                });
            }
        }

        // Ambil data terbaru, batasi 8
        $books = $query->orderBy('created_at', 'desc')->take(8)->get();

        return view('user.dashboard', compact('books'));
    }
}
