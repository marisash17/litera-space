<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Peminjaman;

class RakPinjamController extends Controller
{
    // Dashboard user (dengan pencarian)
    public function dashboard(Request $request)
    {
        $search = $request->input('search');

        $books = Buku::query()
            ->when($search, function ($query, $search) {
                return $query->where('judul', 'like', "%{$search}%")
                             ->orWhere('penulis', 'like', "%{$search}%")
                             ->orWhere('kategori', 'like', "%{$search}%");
            })
            ->get();

        $rakPinjamCount = Buku::where('status', 'dipinjam')
                              ->where('user_id', auth()->id())
                              ->count();

        $riwayatCount = Buku::where('status', 'dikembalikan')
                             ->where('user_id', auth()->id())
                             ->count();

        return view('user.dashboard', compact('books', 'rakPinjamCount', 'riwayatCount'));
    }

    // Halaman daftar buku yang sedang dipinjam
    public function index()
    {
        $books = Buku::where('status', 'dipinjam')
                     ->where('user_id', auth()->id())
                     ->get();

        return view('user.rak-pinjam', compact('books'));
    }

    // Halaman riwayat peminjaman
    public function riwayat()
    {
        $riwayat = Buku::where('status', 'dikembalikan')
                       ->where('user_id', auth()->id())
                       ->get();

        return view('user.riwayat-peminjaman', compact('riwayat'));
    }

    // Halaman baca buku
    public function baca($id)
    {
        $book = Buku::findOrFail($id);
        return view('user.baca-buku', compact('book'));
    }

    // Aksi untuk meminjam buku
public function pinjam($id)
{
    $book = Buku::findOrFail($id);

    if ($book->status == 'dipinjam') {
        return redirect()->back()->with('error', 'Buku sudah dipinjam orang lain.');
    }

    // Update status buku
    $book->status = 'dipinjam';
    $book->user_id = auth()->id(); // optional, jika ingin tahu siapa user terakhir
    $book->save();

    // Tambahkan ke tabel peminjaman
    Peminjaman::create([
        'buku_id' => $book->id,
        'member_id' => auth()->user()->member->id ?? null, // pastikan user punya relasi member
        'user_id' => auth()->id(), // user/petugas/admin yang input
        'tanggal_peminjaman' => now(),
        'tanggal_pengembalian' => now()->addDays(7), // misal 7 hari pinjam
        'status' => 'dipinjam',
        'keterangan' => 'Pinjaman dari rak pinjam'
    ]);

    return redirect()->route('rak.pinjam')->with('success', 'Buku berhasil ditambahkan ke rak Anda!');
}

    // Aksi untuk mengembalikan buku
    public function kembalikan($id)
    {
        $book = Buku::findOrFail($id);

        if ($book->user_id != auth()->id()) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengembalikan buku ini.');
        }

        $book->status = 'tersedia';
        $book->user_id = null;
        $book->save();

        return redirect()->route('rak.pinjam')->with('success', 'Buku berhasil dikembalikan!');
    }
}
