@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="fade-in">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h2 class="text-3xl font-bold text-[#444] animate-fade-in font-display">
                Selamat Datang, {{ Auth::user()->name ?? 'Admin' }}!
            </h2>
            <p class="text-[#666] mt-2 text-body">Berikut adalah ringkasan aktivitas perpustakaan hari ini</p>
        </div>
        <div class="text-sm text-[#444] bg-gradient-to-r from-white to-[#fbefe3] px-4 py-2 rounded-lg shadow-sm border border-[#ddd] font-accent">
            <i class="far fa-calendar mr-2 text-[rgb(128,150,77)]"></i>
            {{ now()->translatedFormat('l, d F Y') }}
        </div>
    </div>
    
    <!-- Statistik Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <div class="stat-card p-6 rounded-2xl transform transition-all duration-300 hover:scale-105">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-[#666] text-sm font-medium text-body">Total Buku</p>
                    <h3 class="text-2xl font-bold mt-2 text-[rgb(128,150,77)] font-display">{{ $totalBuku }}</h3>
                    <p class="text-xs text-[#666] mt-1 text-body">Koleksi tersedia</p>
                </div>
                <div class="bg-[#fbefe3] p-3 rounded-xl border border-[#ddd]">
                    <i class="fas fa-book text-[rgb(128,150,77)] text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="stat-card p-6 rounded-2xl transform transition-all duration-300 hover:scale-105">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-[#666] text-sm font-medium text-body">Total Member</p>
                    <h3 class="text-2xl font-bold mt-2 text-[rgb(128,150,77)] font-display">{{ $totalMember }}</h3>
                    <p class="text-xs text-[#666] mt-1 text-body">Anggota terdaftar</p>
                </div>
                <div class="bg-[#fbefe3] p-3 rounded-xl border border-[#ddd]">
                    <i class="fas fa-users text-[rgb(128,150,77)] text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="stat-card p-6 rounded-2xl transform transition-all duration-300 hover:scale-105">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-[#666] text-sm font-medium text-body">Total Peminjaman</p>
                    <h3 class="text-2xl font-bold mt-2 text-[rgb(128,150,77)] font-display">{{ $peminjamanAktif }}</h3>
                    <p class="text-xs text-[#666] mt-1 text-body">Sedang dipinjam</p>
                </div>
                <div class="bg-[#fbefe3] p-3 rounded-xl border border-[#ddd]">
                    <i class="fas fa-hand-holding text-[rgb(128,150,77)] text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="stat-card p-6 rounded-2xl transform transition-all duration-300 hover:scale-105">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-[#666] text-sm font-medium text-body">Total Denda</p>
                    <h3 class="text-2xl font-bold mt-2 text-[rgb(128,150,77)] font-display">Rp {{ number_format($totalDenda, 0, ',', '.') }}</h3>
                    <p class="text-xs text-[#666] mt-1 text-body">Belum dibayar</p>
                </div>
                <div class="bg-[#fbefe3] p-3 rounded-xl border border-[#ddd]">
                    <i class="fas fa-money-bill-wave text-[rgb(128,150,77)] text-xl"></i>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Aktivitas dan Aksi Cepat -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-10">
        <!-- Quick Actions -->
        <div class="stat-card p-6 rounded-2xl">
            <h3 class="text-xl font-bold text-[#444] mb-4 flex items-center font-display">
                <i class="fas fa-bolt text-[#e09c08] mr-2"></i> Aksi Cepat
            </h3>
            <div class="grid grid-cols-2 gap-4">
                <a href="{{ route('admin.buku.create') }}" class="btn-primary px-4 py-4 rounded-xl font-medium transition-all duration-300 transform hover:scale-105 flex items-center justify-center text-center font-accent">
                    <div>
                        <i class="fas fa-plus text-lg mb-1 block"></i>
                        <span class="text-sm">Tambah Buku</span>
                    </div>
                </a>
                <a href="{{ route('admin.member.create') }}" class="btn-primary px-4 py-4 rounded-xl font-medium transition-all duration-300 transform hover:scale-105 flex items-center justify-center text-center font-accent">
                    <div>
                        <i class="fas fa-user-plus text-lg mb-1 block"></i>
                        <span class="text-sm">Tambah Member</span>
                    </div>
                </a>
                <a href="{{ route('admin.peminjaman.create') }}" class="btn-primary px-4 py-4 rounded-xl font-medium transition-all duration-300 transform hover:scale-105 flex items-center justify-center text-center font-accent">
                    <div>
                        <i class="fas fa-hand-holding text-lg mb-1 block"></i>
                        <span class="text-sm">Peminjaman Baru</span>
                    </div>
                </a>
                <a href="{{ route('admin.denda.index') }}" class="btn-primary px-4 py-4 rounded-xl font-medium transition-all duration-300 transform hover:scale-105 flex items-center justify-center text-center font-accent">
                    <div>
                        <i class="fas fa-file-invoice-dollar text-lg mb-1 block"></i>
                        <span class="text-sm">Kelola Denda</span>
                    </div>
                </a>
            </div>
        </div>

        <!-- Aktivitas Hari Ini -->
        <div class="stat-card p-6 rounded-2xl">
            <h3 class="text-xl font-bold text-[#444] mb-4 flex items-center font-display">
                <i class="far fa-clock text-[#e09c08] mr-2"></i> Aktivitas Hari Ini
            </h3>
            <div class="space-y-3">
                <div class="flex items-center justify-between p-3 bg-white rounded-lg transition-all duration-300 hover:bg-[#fbefe3] border border-[#ddd]">
                    <div class="flex items-center">
                        <div class="bg-[#fbefe3] p-2 rounded-lg mr-3 border border-[#ddd]">
                            <i class="fas fa-hand-holding text-[rgb(128,150,77)]"></i>
                        </div>
                        <div>
                            <p class="font-medium text-sm text-[#444] text-body">Peminjaman Baru</p>
                            <p class="text-xs text-[#666] text-body">{{ $peminjamanHariIni }} transaksi</p>
                        </div>
                    </div>
                    <span class="bg-[rgb(128,150,77)] text-white px-2 py-1 rounded-full text-xs font-bold font-accent">{{ $peminjamanHariIni }}</span>
                </div>
                
                <div class="flex items-center justify-between p-3 bg-white rounded-lg transition-all duration-300 hover:bg-[#fbefe3] border border-[#ddd]">
                    <div class="flex items-center">
                        <div class="bg-[#fbefe3] p-2 rounded-lg mr-3 border border-[#ddd]">
                            <i class="fas fa-undo-alt text-[rgb(128,150,77)]"></i>
                        </div>
                        <div>
                            <p class="font-medium text-sm text-[#444] text-body">Pengembalian</p>
                            <p class="text-xs text-[#666] text-body">Bulan ini</p>
                        </div>
                    </div>
                    <span class="bg-[rgb(128,150,77)] text-white px-2 py-1 rounded-full text-xs font-bold font-accent">{{ $pengembalianBulanIni }}</span>
                </div>
                
                <div class="flex items-center justify-between p-3 bg-white rounded-lg transition-all duration-300 hover:bg-[#fbefe3] border border-[#ddd]">
                    <div class="flex items-center">
                        <div class="bg-[#fbefe3] p-2 rounded-lg mr-3 border border-[#ddd]">
                            <i class="fas fa-book text-[rgb(128,150,77)]"></i>
                        </div>
                        <div>
                            <p class="font-medium text-sm text-[#444] text-body">Buku Baru</p>
                            <p class="text-xs text-[#666] text-body">Ditambahkan bulan ini</p>
                        </div>
                    </div>
                    <span class="bg-[rgb(128,150,77)] text-white px-2 py-1 rounded-full text-xs font-bold font-accent">{{ $bukuBulanIni ?? '0' }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Buku Paling Populer -->
    <div class="stat-card p-6 rounded-2xl">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold text-[#444] flex items-center font-display">
                <i class="fas fa-chart-line text-[#e09c08] mr-2"></i> Buku Paling Populer
            </h3>
            <a href="{{ route('admin.buku.index') }}" class="text-sm text-[#666] hover:text-[rgb(128,150,77)] font-medium flex items-center font-accent">
                Lihat Semua <i class="fas fa-chevron-right ml-1 text-xs"></i>
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-[#fbefe3]">
                    <tr>
                        <th class="p-3 text-left text-sm font-medium text-[#444] border-b border-[#ddd] font-display">Judul Buku</th>
                        <th class="p-3 text-left text-sm font-medium text-[#444] border-b border-[#ddd] font-display">Penulis</th>
                        <th class="p-3 text-left text-sm font-medium text-[#444] border-b border-[#ddd] font-display">Jumlah Dipinjam</th>
                        <th class="p-3 text-left text-sm font-medium text-[#444] border-b border-[#ddd] font-display">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bukuPopuler as $buku)
                    <tr class="table-row border-b border-[#ddd]">
                        <td class="p-3 font-medium text-[#444] text-body">{{ $buku->judul }}</td>
                        <td class="p-3 text-[#666] text-body">{{ $buku->penulis }}</td>
                        <td class="p-3">
                            <span class="bg-[#fbefe3] text-[rgb(128,150,77)] px-2 py-1 rounded-full text-xs font-medium border border-[#ddd] font-accent">
                                {{ $buku->peminjaman_count }} kali
                            </span>
                        </td>
                        <td class="p-3">
                            @if($buku->stok > 0)
                                <span class="bg-[#fbefe3] text-[rgb(128,150,77)] px-2 py-1 rounded-full text-xs font-medium border border-[#ddd] font-accent">Tersedia</span>
                            @else
                                <span class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs font-medium border border-red-200 font-accent">Habis</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-3 text-center text-[#666] text-body">
                            <i class="fas fa-book-open mr-2"></i>Belum ada data peminjaman
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
.animate-fade-in {
    animation: fadeIn 0.8s ease-in-out;
}
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Font Smoothing */
.font-display, .font-body, .font-accent {
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}

/* Improved Typography */
.font-display {
    font-weight: 700;
    letter-spacing: -0.025em;
    line-height: 1.2;
}

.font-body {
    font-weight: 400;
    line-height: 1.6;
    letter-spacing: -0.01em;
}

.font-accent {
    font-weight: 600;
    letter-spacing: -0.015em;
}
</style>
@endsection