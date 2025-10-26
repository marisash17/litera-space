<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class RakPinjamController extends Controller
{
    // Dashboard user (dengan pencarian)
    public function dashboard(Request $request)
    {
        $search = $request->input('search');

        $books = Book::query()
            ->when($search, function ($query, $search) {
                return $query->where('judul', 'like', "%{$search}%")
                             ->orWhere('penulis', 'like', "%{$search}%")
                             ->orWhere('kategori', 'like', "%{$search}%");
            })
            ->get();

        $rakPinjamCount = Book::where('status', 'dipinjam')
                            ->where('user_id', auth()->id())
                            ->count();

        $riwayatCount = Book::where('status', 'dikembalikan')
                            ->where('user_id', auth()->id())
                            ->count();

        return view('user.dashboard', compact('books', 'rakPinjamCount', 'riwayatCount'));
    }

    // Halaman daftar buku yang sedang dipinjam
    public function index()
    {
        $books = Book::where('status', 'dipinjam')
                     ->where('user_id', auth()->id())
                     ->get();

        return view('user.rak-pinjam', compact('books'));
    }

    // Halaman riwayat peminjaman
    public function riwayat()
    {
        $riwayat = Book::where('status', 'dikembalikan')
                       ->where('user_id', auth()->id())
                       ->get();

        return view('user.riwayat-peminjaman', compact('riwayat'));
    }

    // Halaman baca buku
    public function baca($id)
    {
        $book = Book::findOrFail($id);
        return view('user.baca-buku', compact('book'));
    }

    // Aksi untuk mengembalikan buku
    public function kembalikan($id)
    {
        $book = Book::findOrFail($id);
        $book->status = 'dikembalikan';
        $book->save();

        return redirect()->route('rak.pinjam')->with('success', 'Buku berhasil dikembalikan!');
    }
}
