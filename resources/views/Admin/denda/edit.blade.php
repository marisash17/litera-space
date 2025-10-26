@extends('layouts.admin')

@section('title', 'Edit Denda')

@section('content')
<div class="bg-white p-6 rounded-lg shadow max-w-4xl">
    <h2 class="text-xl font-semibold mb-6">Edit Data Denda</h2>

    <form action="{{ route('admin.denda.update', $denda->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
            <h3 class="text-lg font-medium text-blue-900 mb-3">Detail Peminjaman</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <h4 class="font-medium text-blue-800">Data Buku</h4>
                    <p class="text-sm">{{ $denda->peminjaman->buku->judul }}</p>
                    <p class="text-sm text-gray-600">{{ $denda->peminjaman->buku->penulis }}</p>
                </div>
                <div>
                    <h4 class="font-medium text-blue-800">Data Member</h4>
                    <p class="text-sm">{{ $denda->peminjaman->member->nama }}</p>
                    <p class="text-sm text-gray-600">{{ $denda->peminjaman->member->email }}</p>
                </div>
                <div>
                    <h4 class="font-medium text-blue-800">Tanggal</h4>
                    <p class="text-sm">Pinjam: {{ \Carbon\Carbon::parse($denda->peminjaman->tanggal_peminjaman)->format('d/m/Y') }}</p>
                    <p class="text-sm">Harus Kembali: {{ \Carbon\Carbon::parse($denda->peminjaman->tanggal_pengembalian)->format('d/m/Y') }}</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label for="peminjaman_id" class="block text-sm font-medium text-gray-700">Peminjaman *</label>
                <select name="peminjaman_id" id="peminjaman_id" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                    @foreach($peminjamans as $peminjaman)
                        <option value="{{ $peminjaman->id }}" {{ $denda->peminjaman_id == $peminjaman->id ? 'selected' : '' }}>
                            PMJ-{{ str_pad($peminjaman->id, 4, '0', STR_PAD_LEFT) }} - {{ $peminjaman->buku->judul }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="jumlah_denda" class="block text-sm font-medium text-gray-700">Jumlah Denda (Rp) *</label>
                <input type="number" name="jumlah_denda" id="jumlah_denda" 
                       value="{{ old('jumlah_denda', $denda->jumlah_denda) }}" min="0" required
                       class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label for="status_pembayaran" class="block text-sm font-medium text-gray-700">Status Pembayaran *</label>
                <select name="status_pembayaran" id="status_pembayaran" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                    <option value="0" {{ $denda->status_pembayaran == 0 ? 'selected' : '' }}>Belum Bayar</option>
                    <option value="1" {{ $denda->status_pembayaran == 1 ? 'selected' : '' }}>Lunas</option>
                </select>
            </div>
        </div>

        <div class="mb-6">
            <label for="keterangan" class="block text-sm font-medium text-gray-700">Keterangan</label>
            <textarea name="keterangan" id="keterangan" rows="3" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">{{ old('keterangan', $denda->keterangan) }}</textarea>
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('admin.denda.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                Batal
            </a>
            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                Update Denda
            </button>
        </div>
    </form>
</div>
@endsection