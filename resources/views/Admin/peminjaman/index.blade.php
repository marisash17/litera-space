@extends('layouts.admin')

@section('title', 'Data Peminjaman')

@section('content')
<div class="fade-in">
    <div class="flex justify-between items-center mb-8">
        <h2 class="text-3xl font-bold text-gray-800">Data Peminjaman</h2>
        <a href="{{ route('admin.peminjaman.create') }}" 
           class="btn-primary text-white px-4 py-2 rounded-lg font-medium transition flex items-center">
           <i class="fas fa-plus mr-2"></i> Tambah Peminjaman
        </a>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="p-3 text-left text-sm font-medium text-gray-600">No</th>
                    <th class="p-3 text-left text-sm font-medium text-gray-600">Buku</th>
                    <th class="p-3 text-left text-sm font-medium text-gray-600">Member</th>
                    <th class="p-3 text-left text-sm font-medium text-gray-600">Tanggal Pinjam</th>
                    <th class="p-3 text-left text-sm font-medium text-gray-600">Tanggal Kembali</th>
                    <th class="p-3 text-left text-sm font-medium text-gray-600">Status</th>
                    <th class="p-3 text-center text-sm font-medium text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($peminjamans as $peminjaman)
                <tr class="table-row border-b hover:bg-gray-50">
                    <td class="p-3">{{ $loop->iteration + ($peminjamans->currentPage() - 1) * $peminjamans->perPage() }}</td>
                    <td class="p-3">
                        <div class="font-medium">{{ $peminjaman->buku->judul }}</div>
                        <div class="text-sm text-gray-600">{{ $peminjaman->buku->penulis }}</div>
                    </td>
                    <td class="p-3">
                        <div class="font-medium">{{ $peminjaman->member->nama }}</div>
                        <div class="text-sm text-gray-600">{{ $peminjaman->member->email }}</div>
                    </td>
                    <td class="p-3">{{ \Carbon\Carbon::parse($peminjaman->tanggal_peminjaman)->format('d/m/Y') }}</td>
                    <td class="p-3">{{ \Carbon\Carbon::parse($peminjaman->tanggal_pengembalian)->format('d/m/Y') }}</td>
                    <td class="p-3">
                        @if($peminjaman->status == 'dipinjam')
                            <span class="bg-yellow-100 text-yellow-600 px-2 py-1 rounded-full text-xs font-medium">Dipinjam</span>
                        @elseif($peminjaman->status == 'dikembalikan')
                            <span class="bg-green-100 text-green-600 px-2 py-1 rounded-full text-xs font-medium">Dikembalikan</span>
                        @else
                            <span class="bg-red-100 text-red-600 px-2 py-1 rounded-full text-xs font-medium">Terlambat</span>
                        @endif
                    </td>
                    <td class="p-3 text-center">
                        <div class="flex justify-center space-x-2">
                            <a href="{{ route('admin.peminjaman.edit', $peminjaman->id) }}" 
                               class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-lg text-sm transition" 
                               title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>

                            @if($peminjaman->status == 'dipinjam')
                                <a href="{{ route('admin.pengembalian.create') }}?peminjaman_id={{ $peminjaman->id }}" 
                                   class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded-lg text-sm transition" 
                                   title="Proses Pengembalian">
                                    <i class="fas fa-undo"></i>
                                </a>
                            @endif

                            {{-- Tombol Kirim Pengingat --}}
                            <form action="{{ route('admin.peminjaman.kirimPengingat', $peminjaman->id) }}" method="POST" onsubmit="return confirm('Kirim pengingat ke {{ $peminjaman->member->nama }}?')">
                                @csrf
                                <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-lg text-sm transition" title="Kirim Pengingat">
                                    <i class="fas fa-bell"></i>
                                </button>
                            </form>

                            <form action="{{ route('admin.peminjaman.destroy', $peminjaman->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-gray-400 hover:bg-gray-500 text-white px-3 py-1 rounded-lg text-sm transition" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="p-3 text-center text-gray-500">
                        <i class="fas fa-book-reader mr-2"></i>Belum ada data peminjaman
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $peminjamans->links() }}
    </div>
</div>
@endsection
