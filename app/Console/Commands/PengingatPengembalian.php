<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class PengingatPengembalian extends Command
{
    protected $signature = 'pengingat:pengembalian';
    protected $description = 'Kirim pengingat pengembalian buku via WhatsApp (H-1 sebelum tanggal_pengembalian)';

    public function handle()
    {
        $besok = Carbon::tomorrow()->toDateString();

        // Ambil semua peminjaman dengan tanggal_pengembalian besok
        $peminjamans = Peminjaman::with(['member', 'buku'])
            ->where('status', 'dipinjam')
            ->whereDate('tanggal_pengembalian', $besok)
            ->get();

        if ($peminjamans->isEmpty()) {
            $this->info('Tidak ada pengingat yang perlu dikirim hari ini.');
            return;
        }

        foreach ($peminjamans as $pinjam) {
            $nama = $pinjam->member->nama;
            $nohp = $pinjam->member->no_hp; // pastikan kolom ini ada di tabel members
            $judul = $pinjam->buku->judul;
            $tanggal = Carbon::parse($pinjam->tanggal_pengembalian)->translatedFormat('d F Y');

            $pesan = "Halo *{$nama}*, jangan lupa buku *{$judul}* harus dikembalikan besok ({$tanggal}). Terima kasih telah meminjam di Perpustakaan LiteraSpace 📚";

            try {
                Http::withHeaders([
                    'Authorization' => env('FONNTE_TOKEN'),
                ])->post('https://api.fonnte.com/send', [
                    'target' => $nohp,
                    'message' => $pesan,
                ]);

                $this->info("✅ Pesan terkirim ke {$nama}");
            } catch (\Exception $e) {
                \Log::error("❌ Gagal kirim WA ke {$nama}: " . $e->getMessage());
            }
        }

        $this->info('Semua pengingat pengembalian berhasil dikirim.');
    }
}
