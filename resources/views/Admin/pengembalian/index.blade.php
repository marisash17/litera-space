@extends('layouts.admin')

@section('title', 'Data Pengembalian')

@section('content')
<div class="fade-in">
    <div class="flex justify-between items-center mb-8">
        <h2 class="text-3xl font-bold text-gray-800">Data Pengembalian</h2>
        <a href="{{ route('admin.pengembalian.create') }}" 
           class="btn-primary bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg font-medium transition flex items-center">
           <i class="fas fa-undo mr-2"></i> Proses Pengembalian
        </a>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="p-3 text-left text-sm font-medium text-gray-600">No</th>
                    <th class="p-3 text-left text-sm font-medium text-gray-600">Kode Peminjaman</th>
                    <th class="p-3 text-left text-sm font-medium text-gray-600">Buku</th>
                    <th class="p-3 text-left text-sm font-medium text-gray-600">Member</th>
                    <th class="p-3 text-left text-sm font-medium text-gray-600">Tanggal Kembali</th>
                    <th class="p-3 text-left text-sm font-medium text-gray-600">Denda</th>
                    <th class="p-3 text-center text-sm font-medium text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pengembalians as $pengembalian)
                <tr class="table-row border-b hover:bg-gray-50">
                    <td class="p-3">{{ $loop->iteration + ($pengembalians->currentPage() - 1) * $pengembalians->perPage() }}</td>
                    <td class="p-3">
                        <span class="bg-blue-100 text-blue-600 px-2 py-1 rounded-full text-xs font-medium">
                            PMJ-{{ str_pad($pengembalian->peminjaman_id, 4, '0', STR_PAD_LEFT) }}
                        </span>
                    </td>
                    <td class="p-3">
                        <div class="font-medium">{{ $pengembalian->peminjaman->buku->judul }}</div>
                        <div class="text-sm text-gray-600">{{ $pengembalian->peminjaman->buku->penulis }}</div>
                    </td>
                    <td class="p-3">
                        <div class="font-medium">{{ $pengembalian->peminjaman->member->nama }}</div>
                        <div class="text-sm text-gray-600">{{ $pengembalian->peminjaman->member->email }}</div>
                    </td>
                    <td class="p-3">{{ \Carbon\Carbon::parse($pengembalian->tanggal_dikembalikan)->format('d/m/Y') }}</td>
                    <td class="p-3">
                        @if($pengembalian->denda > 0)
                            <span class="bg-red-100 text-red-600 px-2 py-1 rounded-full text-xs font-medium">
                                Rp {{ number_format($pengembalian->denda, 0, ',', '.') }}
                            </span>
                        @else
                            <span class="bg-green-100 text-green-600 px-2 py-1 rounded-full text-xs font-medium">
                                Tidak Ada
                            </span>
                        @endif
                    </td>
                    <td class="p-3 text-center">
                        <div class="flex justify-center space-x-2">
                            <a href="{{ route('admin.pengembalian.edit', $pengembalian->id) }}" 
                               class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-lg text-sm transition" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.pengembalian.destroy', $pengembalian->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg text-sm transition" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="p-3 text-center text-gray-500">
                        <i class="fas fa-undo mr-2"></i>Belum ada data pengembalian
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $pengembalians->links() }}
    </div>
</div>
@endsection
