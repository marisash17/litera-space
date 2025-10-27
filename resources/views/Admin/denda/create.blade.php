@extends('layouts.admin')

@section('title', 'Tambah Denda')

@section('content')
<div class="bg-white p-6 rounded-lg shadow max-w-4xl mx-auto">
    <h2 class="text-xl font-semibold text-gray-800 mb-6">Tambah Data Denda</h2>

    {{-- Form Simpan Denda --}}
    <form action="{{ route('admin.denda.store') }}" method="POST">
        @csrf

        {{-- Pilih Peminjam --}}
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700">Pilih Peminjam *</label>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-2">
                @foreach($peminjamans as $peminjaman)
                    <div class="p-4 border border-gray-300 rounded-lg cursor-pointer hover:bg-green-50 peminjam-item transition"
                        data-id="{{ $peminjaman->id }}"
                        data-buku="{{ $peminjaman->buku->judul ?? '-' }}"
                        data-penulis="{{ $peminjaman->buku->penulis ?? '-' }}"
                        data-member="{{ $peminjaman->member->nama ?? '-' }}"
                        data-email="{{ $peminjaman->member->email ?? '-' }}"
                        data-pinjam="{{ $peminjaman->tanggal_peminjaman }}"
                        data-kembali="{{ $peminjaman->tanggal_pengembalian }}"
                        data-status="{{ ucfirst($peminjaman->status) }}">
                        <h4 class="font-medium text-gray-900">{{ $peminjaman->member->nama ?? '-' }}</h4>
                        <p class="text-sm text-gray-700">{{ $peminjaman->buku->judul ?? '-' }}</p>
                    </div>
                @endforeach
            </div>
            <input type="hidden" name="peminjaman_id" id="peminjaman_id" required>
            @error('peminjaman_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Detail Peminjaman --}}
        <div id="peminjaman-detail" class="hidden mb-6 p-4 bg-green-50 rounded-lg border border-green-200">
            <h3 class="text-lg font-medium text-green-900 mb-3">Detail Peminjaman</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <h4 class="font-medium text-green-800">Data Buku</h4>
                    <p id="detail-judul" class="text-sm text-gray-800"></p>
                    <p id="detail-penulis" class="text-sm text-gray-600"></p>
                </div>
                <div>
                    <h4 class="font-medium text-green-800">Data Member</h4>
                    <p id="detail-member" class="text-sm text-gray-800"></p>
                    <p id="detail-email" class="text-sm text-gray-600"></p>
                </div>
                <div>
                    <h4 class="font-medium text-green-800">Tanggal</h4>
                    <p id="detail-pinjam" class="text-sm text-gray-700"></p>
                    <p id="detail-kembali" class="text-sm text-gray-700"></p>
                </div>
                <div>
                    <h4 class="font-medium text-green-800">Status</h4>
                    <p id="detail-status" class="text-sm text-gray-700"></p>
                </div>
            </div>
        </div>

        {{-- Jumlah Denda dan Status --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label for="jumlah_denda" class="block text-sm font-medium text-gray-700">Jumlah Denda (Rp) *</label>
                <input type="number" name="jumlah_denda" id="jumlah_denda"
                       value="{{ old('jumlah_denda', 0) }}" min="0" required
                       class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-green-500 focus:border-green-500">
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

{{-- Script untuk interaksi peminjaman --}}
@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const peminjamanItems = document.querySelectorAll('.peminjam-item');
    const peminjamanIdInput = document.getElementById('peminjaman_id');
    const peminjamanDetail = document.getElementById('peminjaman-detail');

    peminjamanItems.forEach(item => {
        item.addEventListener('click', function() {
            peminjamanIdInput.value = item.dataset.id;

            document.getElementById('detail-judul').textContent = item.dataset.buku;
            document.getElementById('detail-penulis').textContent = `Penulis: ${item.dataset.penulis}`;
            document.getElementById('detail-member').textContent = item.dataset.member;
            document.getElementById('detail-email').textContent = item.dataset.email;
            document.getElementById('detail-pinjam').textContent = `Pinjam: ${new Date(item.dataset.pinjam).toLocaleDateString('id-ID')}`;
            document.getElementById('detail-kembali').textContent = `Harus Kembali: ${new Date(item.dataset.kembali).toLocaleDateString('id-ID')}`;
            document.getElementById('detail-status').textContent = `Status: ${item.dataset.status}`;

            peminjamanDetail.classList.remove('hidden');

            peminjamanItems.forEach(i => i.classList.remove('bg-green-100', 'border-green-500'));
            item.classList.add('bg-green-100', 'border-green-500');
        });
    });
});
</script>
@endsection
@endsection
