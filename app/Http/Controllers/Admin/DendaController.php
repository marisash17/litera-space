<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Denda;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DendaController extends Controller
{
    /**
     * Menampilkan daftar denda
     */
    public function index()
    {
        $dendas = Denda::with(['peminjaman.buku', 'peminjaman.member'])
            ->latest()
            ->paginate(10);

        $totalDenda = Denda::sum('jumlah_denda');
        $dendaLunas = Denda::where('status_pembayaran', true)->sum('jumlah_denda');
        $dendaBelumLunas = Denda::where('status_pembayaran', false)->sum('jumlah_denda');

        return view('admin.denda.index', compact('dendas', 'totalDenda', 'dendaLunas', 'dendaBelumLunas'));
    }

    /**
     * Menampilkan form tambah denda
     */
    public function create()
    {
        $peminjamans = Peminjaman::with(['buku', 'member'])
            ->whereIn('status', ['dipinjam', 'terlambat'])
            ->get();

        return view('admin.denda.create', compact('peminjamans'));
    }

    /**
     * Simpan data denda baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'peminjaman_id' => 'required|exists:peminjaman,id',
            'jumlah_denda' => 'required|numeric|min:0',
            'status_pembayaran' => 'required|boolean',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $denda = Denda::create($validated);

        // Kirim notifikasi WhatsApp via Fonnte
        $this->sendFonnteNotification($denda);

        return redirect()->route('admin.denda.index')->with('success', 'Data denda berhasil ditambahkan dan notifikasi dikirim.');
    }

    /**
     * Menampilkan form edit denda
     */
    public function edit($id)
    {
        $denda = Denda::with(['peminjaman.buku', 'peminjaman.member'])->findOrFail($id);
        $peminjamans = Peminjaman::with(['buku', 'member'])->get();

        return view('admin.denda.edit', compact('denda', 'peminjamans'));
    }

    /**
     * Update data denda
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'peminjaman_id' => 'required|exists:peminjaman,id',
            'jumlah_denda' => 'required|numeric|min:0',
            'status_pembayaran' => 'required|boolean',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $denda = Denda::findOrFail($id);
        $denda->update($validated);

        return redirect()->route('admin.denda.index')->with('success', 'Data denda berhasil diperbarui.');
    }

    /**
     * Hapus data denda
     */
    public function destroy($id)
    {
        $denda = Denda::findOrFail($id);
        $denda->delete();

        return redirect()->route('admin.denda.index')->with('success', 'Data denda berhasil dihapus.');
    }

    /**
     * Kirim notifikasi WhatsApp ke member via Fonnte
     */
    private function sendFonnteNotification(Denda $denda)
    {
        try {
            $member = $denda->peminjaman->member;
            $nohp = $member->no_hp; // Pastikan kolom no_hp ada di tabel member
            $nama = $member->nama;
            $jumlah = number_format($denda->jumlah_denda, 0, ',', '.');

            $pesan = "Halo *{$nama}*, Anda memiliki denda sebesar *Rp {$jumlah}* untuk peminjaman buku *{$denda->peminjaman->buku->judul}*. Mohon segera melunasi.";

            Http::withHeaders([
                'Authorization' => env('FONNTE_API_KEY'), // Simpan token di .env
            ])->post('https://api.fonnte.com/send', [
                'target' => $nohp,
                'message' => $pesan,
            ]);

        } catch (\Exception $e) {
            \Log::error('Gagal mengirim notifikasi Fonnte: ' . $e->getMessage());
        }
    }
}
