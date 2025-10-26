<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Denda;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class DendaController extends Controller
{
    public function index()
    {
        // Ambil semua denda beserta relasi peminjaman, member, dan buku
        $dendas = Denda::with('peminjaman.buku', 'peminjaman.member')->paginate(10);

        // Summary
        $totalDenda = Denda::sum('jumlah_denda');
        $dendaLunas = Denda::where('status_pembayaran', true)->sum('jumlah_denda');
        $dendaBelumLunas = Denda::where('status_pembayaran', false)->sum('jumlah_denda');

        // Kirim semua variabel ke view
        return view('admin.denda.index', compact('dendas', 'totalDenda', 'dendaLunas', 'dendaBelumLunas'));
    }

    public function create()
    {
        $peminjamans = Peminjaman::with('member', 'buku')
            ->where('status', 'terlambat')
            ->get();

        return view('admin.denda.create', compact('peminjamans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'peminjaman_id' => 'required|exists:peminjaman,id',
            'jumlah_denda' => 'required|integer|min:0',
            'keterangan' => 'nullable|string'
        ]);

        Denda::create($request->all());

        return redirect()->route('denda.index')
            ->with('success', 'Denda berhasil ditambahkan');
    }

    public function show(Denda $denda)
    {
        return view('admin.denda.show', compact('denda'));
    }

    public function edit(Denda $denda)
    {
        $peminjamans = Peminjaman::all();
        return view('admin.denda.edit', compact('denda', 'peminjamans'));
    }

    public function update(Request $request, Denda $denda)
    {
        $request->validate([
            'peminjaman_id' => 'required|exists:peminjaman,id',
            'jumlah_denda' => 'required|integer|min:0',
            'status_pembayaran' => 'required|boolean',
            'keterangan' => 'nullable|string'
        ]);

        $denda->update($request->all());

        return redirect()->route('admin.denda.index')
            ->with('success', 'Denda berhasil diupdate');
    }

    public function destroy(Denda $denda)
    {
        $denda->delete();

        return redirect()->route('admin.denda.index')
            ->with('success', 'Denda berhasil dihapus');
    }
}