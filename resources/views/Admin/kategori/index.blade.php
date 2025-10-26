@extends('layouts.admin')

@section('title', 'Kelola Kategori')

@section('content')
<div class="fade-in">
    <div class="flex justify-between items-center mb-8">
        <h2 class="text-3xl font-bold text-gray-800">Kelola Kategori</h2>
        <a href="{{ route('kategori.create') }}" class="btn-primary text-white px-4 py-2 rounded-lg font-medium transition flex items-center">
            <i class="fas fa-plus mr-2"></i> Tambah Kategori
        </a>
    </div>

    <!-- Notifikasi -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 fade-in">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('success') }}
            </div>
        </div>
    @endif

    <div class="bg-white p-6 rounded-2xl shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="p-3 text-left text-sm font-medium text-gray-600">No</th>
                        <th class="p-3 text-left text-sm font-medium text-gray-600">Nama Kategori</th>
                        <th class="p-3 text-left text-sm font-medium text-gray-600">Deskripsi</th>
                        <th class="p-3 text-left text-sm font-medium text-gray-600">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kategories as $kategori)
                    <tr class="table-row border-b">
                        <td class="p-3">{{ $loop->iteration }}</td>
                        <td class="p-3 font-medium">{{ $kategori->nama_kategori }}</td>
                        <td class="p-3">{{ $kategori->deskripsi ?? '-' }}</td>
                        <td class="p-3">
                            <div class="flex space-x-2">
                                <a href="{{ route('kategori.edit', $kategori->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-lg text-sm transition">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('kategori.destroy', $kategori->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg text-sm transition">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-3 text-center text-gray-500">
                            <i class="fas fa-folder-open mr-2"></i>Belum ada data kategori
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $kategories->links() }}
        </div>
    </div>
</div>
@endsection
