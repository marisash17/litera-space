@extends('layouts.admin')

@section('title', 'Tambah Denda')

@section('content')
<div class="bg-white p-6 rounded-lg shadow max-w-4xl mx-auto">
    <h2 class="text-xl font-semibold text-gray-800 mb-6">Tambah Data Denda</h2>

    {{-- Form Simpan Denda --}}
    <form action="{{ route('admin.denda.store') }}" method="POST" id="formDenda">
        @csrf

        {{-- Pilih Peminjaman --}}
        <div class="mb-6">
            <label for="peminjaman_id" class="block text-sm font-medium text-gray-700">Pilih Peminjaman *</label>
            <select name="peminjaman_id" id="peminjaman_id" required
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-green-500 focus:border-green-500">
                <option value="">-- Pilih Peminjaman --</option>
                @foreach($peminjamans as $peminjaman)
                    <option value="{{ $peminjaman->id }}"
                        data-tgl-kembali="{{ \Carbon\Carbon::parse($peminjaman->tanggal_pengembalian)->format('Y-m-d') }}"
                        {{ old('peminjaman_id') == $peminjaman->id ? 'selected' : '' }}>
                        {{ $peminjaman->member->nama ?? '-' }} - 
                        {{ $peminjaman->buku->judul ?? '-' }} 
                        ({{ ucfirst($peminjaman->status) }})
                    </option>
                @endforeach
            </select>
            @error('peminjaman_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Jumlah Denda dan Status Pembayaran --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label for="jumlah_denda" class="block text-sm font-medium text-gray-700">Jumlah Denda (Rp) *</label>
                <input type="number" name="jumlah_denda" id="jumlah_denda"
                       value="{{ old('jumlah_denda', 0) }}" min="0" required
                       class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-green-500 focus:border-green-500" readonly>
                @error('jumlah_denda')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="status_pembayaran" class="block text-sm font-medium text-gray-700">Status Pembayaran *</label>
                <select name="status_pembayaran" id="status_pembayaran" required
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-green-500 focus:border-green-500">
                    <option value="0" {{ old('status_pembayaran') == '0' ? 'selected' : '' }}>Belum Bayar</option>
                    <option value="1" {{ old('status_pembayaran') == '1' ? 'selected' : '' }}>Lunas</option>
                </select>
            </div>
        </div>

        {{-- Keterangan --}}
        <div class="mb-6">
            <label for="keterangan" class="block text-sm font-medium text-gray-700">Keterangan</label>
            <textarea name="keterangan" id="keterangan" rows="3"
                      class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-green-500 focus:border-green-500">{{ old('keterangan') }}</textarea>
        </div>

        {{-- Tombol --}}
        <div class="flex justify-end space-x-3">
            <a href="{{ route('admin.denda.index') }}"
               class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">
                Batal
            </a>
            <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-medium transition flex items-center">
                Simpan Denda
            </button>
        </div>
    </form>
</div>

{{-- JS: otomatis hitung jumlah denda Rp 3.000/hari kelipatan keterlambatan --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const peminjamanSelect = document.getElementById('peminjaman_id');
    const jumlahInput = document.getElementById('jumlah_denda');
    const TARIF_PER_HARI = 3000;

    function hitungDenda() {
        const selectedOption = peminjamanSelect.options[peminjamanSelect.selectedIndex];
        const tglKembali = selectedOption.dataset.tglKembali;

        if(tglKembali) {
            const tglParts = tglKembali.split('-'); // YYYY-MM-DD
            const dueDate = new Date(tglParts[0], tglParts[1] - 1, tglParts[2]);
            const today = new Date();

            let diffTime = today - dueDate;
            let diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

            jumlahInput.value = diffDays > 0 ? diffDays * TARIF_PER_HARI : 0;
        } else {
            jumlahInput.value = 0;
        }
    }

    peminjamanSelect.addEventListener('change', hitungDenda);

    // trigger sekali agar terisi jika ada old value
    hitungDenda();
});
</script>
@endsection
