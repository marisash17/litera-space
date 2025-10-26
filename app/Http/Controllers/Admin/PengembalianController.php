<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengembalian;
use App\Models\Peminjaman;
use App\Models\Denda;
use Illuminate\Http\Request;

class PengembalianController extends Controller
{
    public function index()
    {
        $pengembalians = Pengembalian::with('peminjaman')->paginate(10);
        return view('admin.pengembalian.index', compact('pengembalians'));
    }

    public function create()
    {
        $peminjamans = Peminjaman::where('status', 'dipinjam')->get();
        return view('admin.pengembalian.create', compact('peminjamans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'peminjaman_id' => 'required|exists:peminjaman,id',
            'tanggal_dikembalikan' => 'required|date',
            'denda' => 'required|integer|min:0',
            'keterangan' => 'nullable|string'
        ]);

        // Update status peminjaman
        $peminjaman = Peminjaman::find($request->peminjaman_id);
        $peminjaman->update([
            'status' => 'dikembalikan',
            'tanggal_dikembalikan' => $request->tanggal_dikembalikan
        ]);

        // Kembalikan stok buku
        $buku = $peminjaman->buku;
        $buku->increment('stok');

        // Buat data pengembalian
        Pengembalian::create($request->all());

        // Jika ada denda, buat data denda
        if ($request->denda > 0) {
            Denda::create([
                'peminjaman_id' => $request->peminjaman_id,
                'jumlah_denda' => $request->denda,
                'status_pembayaran' => false,
                'keterangan' => 'Denda keterlambatan'
            ]);
        }

        return redirect()->route('admin.pengembalian.index')
            ->with('success', 'Pengembalian berhasil dicatat');
    }

    public function show(Pengembalian $pengembalian)
    {
        return view('admin.pengembalian.show', compact('pengembalian'));
    }

    public function edit(Pengembalian $pengembalian)
    {
        $peminjamans = Peminjaman::all();
        return view('admin.pengembalian.edit', compact('pengembalian', 'peminjamans'));
    }

    public function update(Request $request, Pengembalian $pengembalian)
    {
        $request->validate([
            'peminjaman_id' => 'required|exists:peminjaman,id',
            'tanggal_dikembalikan' => 'required|date',
            'denda' => 'required|integer|min:0',
            'keterangan' => 'nullable|string'
        ]);

        $pengembalian->update($request->all());

        return redirect()->route('admin.pengembalian.index')
            ->with('success', 'Pengembalian berhasil diupdate');
    }

    public function destroy(Pengembalian $pengembalian)
    {
        $pengembalian->delete();

        return redirect()->route('admin.pengembalian.index')
            ->with('success', 'Pengembalian berhasil dihapus');
    }
}