<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Buku;
use App\Models\Member;
use App\Models\Denda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    public function index()
    {
        $peminjamans = Peminjaman::with(['buku', 'member', 'denda'])->paginate(10);
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

        $buku = Buku::find($request->buku_id);

        if ($buku->stok < 1) {
            return back()->with('error', 'Stok buku tidak tersedia.');
        }

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

        // === LOGIKA OTOMATIS BUAT / UPDATE DENDA ===
        if ($peminjaman->status === 'terlambat') {
            $tanggalKembali = Carbon::parse($peminjaman->tanggal_pengembalian);
            $hariTerlambat = $tanggalKembali->diffInDays(now(), false);

            if ($hariTerlambat > 0) {
                $jumlahDenda = $hariTerlambat * 1000;

                $denda = Denda::updateOrCreate(
                    ['peminjaman_id' => $peminjaman->id],
                    [
                        'jumlah_denda' => $jumlahDenda,
                        'status_pembayaran' => false,
                        'keterangan' => "Terlambat $hariTerlambat hari"
                    ]
                );

                // Kirim WA otomatis
                try {
                    $member = $peminjaman->member;
                    $pesan = "Halo *{$member->nama}*, Anda terlambat mengembalikan buku *{$peminjaman->buku->judul}* selama *{$hariTerlambat} hari*.
Denda Anda sebesar *Rp " . number_format($jumlahDenda, 0, ',', '.') . "*.
Mohon segera melunasi di bagian administrasi. 🙏";

                    Http::withHeaders([
                        'Authorization' => env('FONNTE_API_KEY'),
                    ])->post('https://api.fonnte.com/send', [
                        'target' => $member->no_hp,
                        'message' => $pesan,
                    ]);
                } catch (\Exception $e) {
                    \Log::error('Gagal kirim notifikasi denda: ' . $e->getMessage());
                }
            }
        } else {
            // Jika status bukan terlambat → hapus denda (opsional)
            if ($peminjaman->denda) {
                $peminjaman->denda->delete();
            }
        }

        return redirect()->route('admin.peminjaman.index')
            ->with('success', 'Peminjaman berhasil diupdate (denda otomatis diperbarui jika perlu).');
    }

    public function destroy(Peminjaman $peminjaman)
    {
        if ($peminjaman->status == 'dipinjam') {
            $buku = Buku::find($peminjaman->buku_id);
            $buku->increment('stok');
        }

        // Hapus juga denda-nya
        if ($peminjaman->denda) {
            $peminjaman->denda->delete();
        }

        $peminjaman->delete();

        return redirect()->route('admin.peminjaman.index')
            ->with('success', 'Peminjaman dan denda terkait berhasil dihapus');
    }

    // === KIRIM PENGINGAT (sudah bagus, minor cleanup) ===
    public function kirimPengingat($id)
    {
        $peminjaman = Peminjaman::with('member', 'buku')->findOrFail($id);
        $nomor = $peminjaman->member->no_hp;
        $nama = $peminjaman->member->nama;
        $judul = $peminjaman->buku->judul;
        $tanggalKembali = Carbon::parse($peminjaman->tanggal_pengembalian)->translatedFormat('d F Y');

        $pesan = "Halo {$nama}, buku *{$judul}* harus dikembalikan pada {$tanggalKembali}. Mohon dikembalikan tepat waktu. 📚";

        $response = Http::withHeaders([
            'Authorization' => env('FONNTE_API_KEY'),
        ])->post('https://api.fonnte.com/send', [
            'target' => $nomor,
            'message' => $pesan,
        ]);

        return $response->successful()
            ? back()->with('success', "Pengingat berhasil dikirim ke {$nama}")
            : back()->with('error', 'Gagal mengirim pengingat.');
    }
}
