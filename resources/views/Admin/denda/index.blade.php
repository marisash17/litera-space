@extends('layouts.admin')

@section('title', 'Data Denda')

@section('content')
<div class="fade-in">
    <div class="flex justify-between items-center mb-8">
        <h2 class="text-3xl font-bold text-gray-800">Data Denda</h2>
        <a href="{{ route('admin.denda.create') }}" 
           class="btn-primary bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg font-medium transition flex items-center">
           <i class="fas fa-plus mr-2"></i> Tambah Denda
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
                    <th class="p-3 text-left text-sm font-medium text-gray-600">Jumlah Denda</th>
                    <th class="p-3 text-left text-sm font-medium text-gray-600">Status</th>
                    <th class="p-3 text-center text-sm font-medium text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($dendas as $denda)
                <tr class="table-row border-b hover:bg-gray-50">
                    <td class="p-3">{{ $loop->iteration + ($dendas->currentPage() - 1) * $dendas->perPage() }}</td>
                    <td class="p-3">
                        <span class="bg-blue-100 text-blue-600 px-2 py-1 rounded-full text-xs font-medium">
                            PMJ-{{ str_pad($denda->peminjaman_id, 4, '0', STR_PAD_LEFT) }}
                        </span>
                    </td>
                    <td class="p-3">
                        <div class="font-medium">{{ $denda->peminjaman->buku->judul }}</div>
                        <div class="text-sm text-gray-600">{{ $denda->peminjaman->buku->penulis }}</div>
                    </td>
                    <td class="p-3">
                        <div class="font-medium">{{ $denda->peminjaman->member->nama }}</div>
                        <div class="text-sm text-gray-600">{{ $denda->peminjaman->member->email }}</div>
                    </td>
                    <td class="p-3 font-medium">Rp {{ number_format($denda->jumlah_denda, 0, ',', '.') }}</td>
                    <td class="p-3">
                        @if($denda->status_pembayaran)
                            <span class="bg-green-100 text-green-600 px-2 py-1 rounded-full text-xs font-medium">Lunas</span>
                        @else
                            <span class="bg-red-100 text-red-600 px-2 py-1 rounded-full text-xs font-medium">Belum Bayar</span>
                        @endif
                    </td>
                    <td class="p-3 text-center">
                        <div class="flex justify-center space-x-2">
                            <a href="{{ route('admin.denda.edit', $denda->id) }}" 
                               class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-lg text-sm transition" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            @if(!$denda->status_pembayaran)
                                <form action="{{ route('denda.update', $denda->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status_pembayaran" value="1">
                                    <button type="submit" 
                                            class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded-lg text-sm transition" title="Tandai Lunas">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                            @endif
                            <form action="{{ route('admin.denda.destroy', $denda->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin?')">
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
                        <i class="fas fa-money-bill-wave mr-2"></i>Belum ada data denda
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $dendas->links() }}
    </div>

    <!-- Summary -->
    <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
            <h3 class="text-sm font-medium text-blue-800">Total Denda</h3>
            <p class="text-2xl font-bold text-blue-600">Rp {{ number_format($totalDenda, 0, ',', '.') }}</p>
        </div>

        <div class="bg-green-50 p-4 rounded-lg border border-green-200">
            <h3 class="text-sm font-medium text-green-800">Sudah Lunas</h3>
            <p class="text-2xl font-bold text-green-600">Rp {{ number_format($dendaLunas, 0, ',', '.') }}</p>
        </div>

        <div class="bg-red-50 p-4 rounded-lg border border-red-200">
            <h3 class="text-sm font-medium text-red-800">Belum Lunas</h3>
            <p class="text-2xl font-bold text-red-600">Rp {{ number_format($dendaBelumLunas, 0, ',', '.') }}</p>
        </div>
    </div>
</div>
@endsection
