@extends('layouts.admin')

@section('title', 'Daftar Buku')

@section('content')
@php use Illuminate\Support\Str; @endphp

<div class="fade-in">
    <div class="flex justify-between items-center mb-8">
        <h2 class="text-3xl font-bold text-gray-800">Daftar Buku</h2>
        <a href="{{ route('admin.buku.create') }}" 
           class="btn-primary text-white px-4 py-2 rounded-lg font-medium transition flex items-center">
            <i class="fas fa-plus mr-2"></i> Tambah Buku
        </a>
    </div>

    <!-- Notifikasi -->
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 fade-in">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('success') }}
            </div>
        </div>
    @endif

    <div class="bg-white p-6 rounded-2xl shadow-sm overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="p-3 text-left text-sm font-medium text-gray-600">No</th>
                    <th class="p-3 text-left text-sm font-medium text-gray-600">Judul</th>
                    <th class="p-3 text-left text-sm font-medium text-gray-600">Penulis</th>
                    <th class="p-3 text-left text-sm font-medium text-gray-600">Penerbit</th>
                    <th class="p-3 text-left text-sm font-medium text-gray-600">Tahun Terbit</th>
                    <th class="p-3 text-left text-sm font-medium text-gray-600">ISBN</th>
                    <th class="p-3 text-left text-sm font-medium text-gray-600">Stok</th>
                    <th class="p-3 text-left text-sm font-medium text-gray-600">Deskripsi</th>
                    <th class="p-3 text-left text-sm font-medium text-gray-600">Foto</th>
                    <th class="p-3 text-center text-sm font-medium text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($buku as $item)
                    <tr class="table-row border-b hover:bg-gray-50">
                        <td class="p-3">{{ $loop->iteration }}</td>
                        <td class="p-3 font-medium">{{ $item->judul }}</td>
                        <td class="p-3">{{ $item->penulis }}</td>
                        <td class="p-3">{{ $item->penerbit }}</td>
                        <td class="p-3">{{ $item->tahun_terbit }}</td>
                        <td class="p-3">{{ $item->isbn ?? '-' }}</td>
                        <td class="p-3">{{ $item->stok }}</td>
                        <td class="p-3">{{ Str::limit($item->deskripsi, 60) ?? '-' }}</td>
                        <td class="p-3 text-center">
                            @if ($item->foto)
                                <img src="{{ asset('storage/' . $item->foto) }}" 
                                     alt="Foto Buku" 
                                     class="w-16 h-16 object-cover rounded-lg mx-auto">
                            @else
                                <span class="text-gray-400 italic">Tidak ada foto</span>
                            @endif
                        </td>
                        <td class="p-3 text-center">
                            <div class="flex justify-center space-x-2">
                                <a href="{{ route('admin.buku.edit', $item->id) }}" 
                                   class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-lg text-sm transition">
                                   <i class="fas fa-edit"></i>
                                </a>

                                <form action="{{ route('admin.buku.destroy', $item->id) }}" method="POST" 
                                      onsubmit="return confirm('Yakin ingin menghapus buku ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg text-sm transition">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="p-3 text-center text-gray-500">
                            <i class="fas fa-book-open mr-2"></i>Belum ada data buku
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
