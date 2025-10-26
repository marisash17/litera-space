@extends('layouts.admin')

@section('title', 'Tambah Kategori')

@section('content')
<div class="bg-white p-6 rounded-lg shadow max-w-2xl">
    <h2 class="text-xl font-semibold mb-6">Tambah Kategori Baru</h2>

    <form action="{{ route('kategori.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="nama_kategori" class="block text-sm font-medium text-gray-700">Nama Kategori</label>
            <input type="text" name="nama_kategori" id="nama_kategori" required
                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
        </div>

        <div class="mb-4">
            <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
            <textarea name="deskripsi" id="deskripsi" rows="3"
                      class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2"></textarea>
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('kategori.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                Batal
            </a>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Simpan
            </button>
        </div>
    </form>
</div>
@endsection