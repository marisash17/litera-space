@extends('layouts.admin')

@section('title', 'Edit Pengembalian')

@section('content')
<div class="fade-in">
    <div class="flex justify-between items-center mb-8">
        <h2 class="text-3xl font-bold text-gray-800">Edit Data Pengembalian</h2>
        <a href="{{ route('admin.pengembalian.index') }}" 
           class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-medium transition flex items-center">
            <i class="fas fa-arrow-left mr-2"></i> Kembali
        </a>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm">
        <form action="{{ route('admin.pengembalian.update', $pengembalian->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Detail Peminjaman -->
            <div class="mb-6 p-5 bg-blue-50 rounded-lg border border-blue-200">
                <h3 class="text-lg font-semibold text-blue-900 mb-3">Detail Peminjaman</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <h4 class="font-medium text-blue-800">Data Buku</h4>
                        <p class="text-sm text-gray-800">{{ $pengembalian->peminjaman->buku->judul }}</p>
                        <p class="text-sm text-gray-600">{{ $pengembalian->peminjaman->buku->penulis }}</p>
                    </div>
                    <div>
                        <h4 class="font-medium text-blue-800">Data Member</h4>
                        <p class="text-sm text-gray-800">{{ $pengembalian->peminjaman->member->nama }}</p>
                        <p class="text-sm text-gray-600">{{ $pengembalian->peminjaman->member->email }}</p>
                    </div>
                    <div>
                        <h4 class="font-medium text-blue-800">Tanggal</h4>
                        <p class="text-sm text-gray-800">Pinjam: {{ \Carbon\Carbon::parse($pengembalian->peminjaman->tanggal_peminjaman)->format('d/m/Y') }}</p>
                        <p class="text-sm text-gray-800">Harus Kembali: {{ \Carbon\Carbon::parse($pengembalian->peminjaman->tanggal_pengembalian)->format('d/m/Y') }}</p>
                    </div>
                </div>
            </div>

            <!-- Form Pengembalian -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="peminjaman_id" class="block text-sm font-medium text-gray-700 mb-2">Peminjaman *</label>
                    <select name="peminjaman_id" id="peminjaman_id" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        @foreach($peminjamans as $peminjaman)
                            <option value="{{ $peminjaman->id }}" {{ $pengembalian->peminjaman_id == $peminjaman->id ? 'selected' : '' }}>
                                PMJ-{{ str_pad($peminjaman->id, 4, '0', STR_PAD_LEFT) }} - {{ $peminjaman->buku->judul }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="tanggal_dikembalikan" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Dikembalikan *</label>
                    <input type="date" name="tanggal_dikembalikan" id="tanggal_dikembalikan"
                           value="{{ old('tanggal_dikembalikan', $pengembalian->tanggal_dikembalikan) }}" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="denda" class="block text-sm font-medium text-gray-700 mb-2">Denda (Rp)</label>
                    <input type="number" name="denda" id="denda"
                           value="{{ old('denda', $pengembalian->denda) }}" min="0"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>

            <div class="mb-6">
                <label for="keterangan" class="block text-sm font-medium text-gray-700 mb-2">Keterangan</label>
                <textarea name="keterangan" id="keterangan" rows="3"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('keterangan', $pengembalian->keterangan) }}</textarea>
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.pengembalian.index') }}"
                   class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg font-medium transition">
                    Batal
                </a>
                <button type="submit" class="btn-primary text-white px-6 py-3 rounded-lg font-medium transition flex items-center">
                    <i class="fas fa-save mr-2"></i> Update Pengembalian
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
