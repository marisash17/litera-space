@extends('layouts.admin')

@section('title', 'Kelola Member')

@section('content')
<div class="fade-in">
    <div class="flex justify-between items-center mb-8">
        <h2 class="text-3xl font-bold text-gray-800">Kelola Member</h2>
        <a href="{{ route('admin.member.create') }}" class="btn-primary text-white px-4 py-2 rounded-lg font-medium transition flex items-center">
            <i class="fas fa-plus mr-2"></i> Tambah Member
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
                        <th class="p-3 text-left text-sm font-medium text-gray-600">Nama</th>
                        <th class="p-3 text-left text-sm font-medium text-gray-600">Email</th>
                        <th class="p-3 text-left text-sm font-medium text-gray-600">Nomor Telp</th>
                        <th class="p-3 text-left text-sm font-medium text-gray-600">Alamat</th>
                        <th class="p-3 text-left text-sm font-medium text-gray-600">Status</th>
                        <th class="p-3 text-left text-sm font-medium text-gray-600">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($members as $member)
                    <tr class="table-row border-b">
                        <td class="p-3">{{ $loop->iteration }}</td>
                        <td class="p-3 font-medium">{{ $member->nama }}</td>
                        <td class="p-3">{{ $member->email }}</td>
                        <td class="p-3">{{ $member->no_hp }}</td>
                        <td class="p-3">{{ Str::limit($member->alamat, 30) }}</td>
                        <td class="p-3">
                            @if($member->status == 'aktif')
                                <span class="bg-green-100 text-green-600 px-2 py-1 rounded-full text-xs font-medium">Aktif</span>
                            @else
                                <span class="bg-red-100 text-red-600 px-2 py-1 rounded-full text-xs font-medium">Nonaktif</span>
                            @endif
                        </td>
                        <td class="p-3">
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.member.edit', $member->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-lg text-sm transition">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.member.destroy', $member->id) }}" method="POST" onsubmit="return confirmDelete()">
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
                        <td colspan="7" class="p-3 text-center text-gray-500">
                            <i class="fas fa-users mr-2"></i>Belum ada data member
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection