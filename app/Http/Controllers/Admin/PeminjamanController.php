<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Buku;
use App\Models\Member;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    public function index()
    {
        $peminjamans = Peminjaman::with(['buku', 'member', 'user'])->paginate(10);
        return view('admin.peminjaman.index', compact('peminjamans'));
    }

    public function create()
    {
        $bukus = Buku::where('stok', '>', 0)->get();
        $members = Member::all();
        return view('admin.peminjaman.create', compact('bukus', 'members'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'buku_id' => 'required|exists:buku,id',
            'member_id' => 'required|exists:members,id',
            'tanggal_peminjaman' => 'required|date',
            'tanggal_pengembalian' => 'required|date|after:tanggal_peminjaman',
            'keterangan' => 'nullable|string'
        ]);

        // Cek stok buku
        $buku = Buku::find($request->buku_id);
        if ($buku->stok < 1) {
            return back()->with('error', 'Stok buku tidak tersedia.');
        }

        // Kurangi stok buku
        $buku->decrement('stok');

        Peminjaman::create([
            'buku_id' => $request->buku_id,
            'member_id' => $request->member_id,
            'user_id' => Auth::id(),
            'tanggal_peminjaman' => $request->tanggal_peminjaman,
            'tanggal_pengembalian' => $request->tanggal_pengembalian,
            'keterangan' => $request->keterangan,
            'status' => 'dipinjam'
        ]);

        return redirect()->route('admin.peminjaman.index')
            ->with('success', 'Peminjaman berhasil ditambahkan');
    }

    public function show(Peminjaman $peminjaman)
    {
        return view('admin.peminjaman.show', compact('peminjaman'));
    }

    public function edit(Peminjaman $peminjaman)
    {
        $bukus = Buku::all();
        $members = Member::all();
        return view('admin.peminjaman.edit', compact('peminjaman', 'bukus', 'members'));
    }

    public function update(Request $request, Peminjaman $peminjaman)
    {
        $request->validate([
            'buku_id' => 'required|exists:buku,id',
            'member_id' => 'required|exists:members,id',
            'tanggal_peminjaman' => 'required|date',
            'tanggal_pengembalian' => 'required|date|after:tanggal_peminjaman',
            'status' => 'required|in:dipinjam,dikembalikan,terlambat',
            'keterangan' => 'nullable|string'
        ]);

        $peminjaman->update($request->all());

        return redirect()->route('admin.peminjaman.index')
            ->with('success', 'Peminjaman berhasil diupdate');
    }

    public function destroy(Peminjaman $peminjaman)
    {
        // Kembalikan stok buku jika peminjaman dibatalkan
        if ($peminjaman->status == 'dipinjam') {
            $buku = Buku::find($peminjaman->buku_id);
            $buku->increment('stok');
        }

        $peminjaman->delete();

        return redirect()->route('admin.peminjaman.index')
            ->with('success', 'Peminjaman berhasil dihapus');
    }
}