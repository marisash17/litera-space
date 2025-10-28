@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="fade-in">
    <div class="flex justify-between items-center mb-8">
        <h2 class="text-3xl font-bold text-gray-800">Selamat Datang, {{ Auth::user()->name ?? 'Admin' }}!</h2>
        <div class="text-sm text-gray-600 bg-white/50 px-4 py-2 rounded-lg">
            <i class="far fa-calendar mr-2"></i>
            {{ now()->translatedFormat('l, d F Y') }}
        </div>
    </div>
    
    <!-- Statistik Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <div class="stat-card bg-white p-6 rounded-2xl shadow-sm border-l-4 border-blue-400">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Total Buku</p>
                    <h3 class="text-2xl font-bold mt-2 text-blue-600">{{ $totalBuku }}</h3>
                    <p class="text-xs text-gray-400 mt-1">Koleksi tersedia</p>
                </div>
                <div class="bg-blue-100 p-3 rounded-xl">
                    <i class="fas fa-book text-blue-500 text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="stat-card bg-white p-6 rounded-2xl shadow-sm border-l-4 border-green-400">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Total Member</p>
                    <h3 class="text-2xl font-bold mt-2 text-green-600">{{ $totalMember }}</h3>
                    <p class="text-xs text-gray-400 mt-1">Anggota terdaftar</p>
                </div>
                <div class="bg-green-100 p-3 rounded-xl">
                    <i class="fas fa-users text-green-500 text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="stat-card bg-white p-6 rounded-2xl shadow-sm border-l-4 border-yellow-400">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Total Peminjaman</p>
                    <h3 class="text-2xl font-bold mt-2 text-yellow-600">{{ $peminjamanAktif }}</h3>
                    <p class="text-xs text-gray-400 mt-1">Sedang dipinjam</p>
                </div>
                <div class="bg-yellow-100 p-3 rounded-xl">
                    <i class="fas fa-hand-holding text-yellow-500 text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="stat-card bg-white p-6 rounded-2xl shadow-sm border-l-4 border-red-400">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Denda Tertunggak</p>
                    <h3 class="text-2xl font-bold mt-2 text-red-600">Rp {{ number_format($totalDenda, 0, ',', '.') }}</h3>
                    <p class="text-xs text-gray-400 mt-1">Belum dibayar</p>
                </div>
                <div class="bg-red-100 p-3 rounded-xl">
                    <i class="fas fa-money-bill-wave text-red-500 text-xl"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-10">
        <!-- Quick Actions -->
        <div class="bg-white p-6 rounded-2xl shadow-sm">
            <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-bolt text-blue-500 mr-2"></i> Aksi Cepat
            </h3>
            <div class="grid grid-cols-2 gap-4">
                <a href="{{ route('admin.buku.create') }}" class="btn-primary text-white px-4 py-4 rounded-xl font-medium transition flex items-center justify-center text-center">
                    <div>
                        <i class="fas fa-plus text-lg mb-1 block"></i>
                        <span class="text-sm">Tambah Buku</span>
                    </div>
                </a>
                <a href="{{ route('admin.member.create') }}" class="btn-success text-white px-4 py-4 rounded-xl font-medium transition flex items-center justify-center text-center">
                    <div>
                        <i class="fas fa-user-plus text-lg mb-1 block"></i>
                        <span class="text-sm">Tambah Member</span>
                    </div>
                </a>
                <a href="{{ route('admin.peminjaman.create') }}" class="bg-gradient-to-r from-blue-400 to-blue-600 hover:from-blue-500 hover:to-blue-700 text-white px-4 py-4 rounded-xl font-medium transition flex items-center justify-center text-center">
                    <div>
                        <i class="fas fa-hand-holding text-lg mb-1 block"></i>
                        <span class="text-sm">Peminjaman Baru</span>
                    </div>
                </a>
                <a href="{{ route('admin.denda.index') }}" class="bg-gradient-to-r from-purple-400 to-purple-600 hover:from-purple-500 hover:to-purple-700 text-white px-4 py-4 rounded-xl font-medium transition flex items-center justify-center text-center">
                    <div>
                        <i class="fas fa-file-invoice-dollar text-lg mb-1 block"></i>
                        <span class="text-sm">Kelola Denda</span>
                    </div>
                </a>
            </div>
        </div>
        
        <!-- Aktivitas Hari Ini -->
        <div class="bg-white p-6 rounded-2xl shadow-sm">
            <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                <i class="far fa-clock text-blue-500 mr-2"></i> Aktivitas Hari Ini
            </h3>
            <div class="space-y-3">
                <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg">
                    <div class="flex items-center">
                        <div class="bg-blue-100 p-2 rounded-lg mr-3">
                            <i class="fas fa-hand-holding text-blue-500"></i>
                        </div>
                        <div>
                            <p class="font-medium text-sm">Peminjaman Baru</p>
                            <p class="text-xs text-gray-500">{{ $peminjamanHariIni }} transaksi</p>
                        </div>
                    </div>
                    <span class="bg-blue-500 text-white px-2 py-1 rounded-full text-xs">{{ $peminjamanHariIni }}</span>
                </div>
                
                <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg">
                    <div class="flex items-center">
                        <div class="bg-green-100 p-2 rounded-lg mr-3">
                            <i class="fas fa-undo-alt text-green-500"></i>
                        </div>
                        <div>
                            <p class="font-medium text-sm">Pengembalian</p>
                            <p class="text-xs text-gray-500">Bulan ini</p>
                        </div>
                    </div>
                    <span class="bg-green-500 text-white px-2 py-1 rounded-full text-xs">{{ $pengembalianBulanIni }}</span>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Buku Paling Populer -->
    <div class="bg-white p-6 rounded-2xl shadow-sm">
        <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
            <i class="fas fa-chart-line text-blue-500 mr-2"></i> Buku Paling Populer
        </h3>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="p-3 text-left text-sm font-medium text-gray-600">Judul Buku</th>
                        <th class="p-3 text-left text-sm font-medium text-gray-600">Penulis</th>
                        <th class="p-3 text-left text-sm font-medium text-gray-600">Jumlah Dipinjam</th>
                        <th class="p-3 text-left text-sm font-medium text-gray-600">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bukuPopuler as $buku)
                    <tr class="table-row border-b">
                        <td class="p-3 font-medium">{{ $buku->judul }}</td>
                        <td class="p-3 text-gray-600">{{ $buku->penulis }}</td>
                        <td class="p-3">
                            <span class="bg-blue-100 text-blue-600 px-2 py-1 rounded-full text-xs font-medium">
                                {{ $buku->peminjaman_count }} kali
                            </span>
                        </td>
                        <td class="p-3">
                            @if($buku->stok > 0)
                                <span class="bg-green-100 text-green-600 px-2 py-1 rounded-full text-xs font-medium">Tersedia</span>
                            @else
                                <span class="bg-red-100 text-red-600 px-2 py-1 rounded-full text-xs font-medium">Habis</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-3 text-center text-gray-500">
                            <i class="fas fa-book-open mr-2"></i>Belum ada data peminjaman
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection