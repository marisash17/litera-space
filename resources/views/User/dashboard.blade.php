@extends('layouts.navigation')

@section('title', 'Dashboard - LiteraSpace')

<style>
    :root {
        --primary-pastel: #FBEFE3;
        --primary-text: #3E2723;
        --hover-pastel: #E7BFA7;
    }

    body { background-color: #FFF6F0; color: var(--primary-text); }

    .bg-primary { background-color: var(--primary-pastel) !important; }
    .text-primary { color: var(--primary-text) !important; }

    .btn-primary {
        background-color: var(--primary-pastel) !important;
        border-color: var(--primary-pastel) !important;
        color: var(--primary-text) !important;
        transition: all 0.3s ease;
    }
    .btn-primary:hover {
        background-color: var(--hover-pastel) !important;
        border-color: var(--hover-pastel) !important;
        color: var(--primary-text) !important;
    }

    .profile-circle { background-color: var(--primary-pastel) !important; color: var(--primary-text); }
    .search-bar input { background-color: #fff !important; }

    .stat-card { background-color: #fff !important; border: none !important; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); transition: all 0.3s ease; }
    .stat-card:hover { transform: translateY(-4px); box-shadow: 0 10px 25px rgba(0,0,0,0.15); }
    .stat-icon { background-color: rgba(0,0,0,0.04) !important; }

    .book-card { background-color: var(--primary-pastel) !important; border: none !important; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); transition: all 0.3s ease; }
    .book-card:hover { transform: translateY(-5px); box-shadow: 0 10px 25px rgba(0,0,0,0.15); }

    .book-cover { background: linear-gradient(135deg, var(--primary-pastel), var(--hover-pastel)); color: var(--primary-text); }
    .btn-link.text-primary { color: var(--primary-text) !important; text-decoration: none; }
    .btn-link.text-primary:hover { color: var(--hover-pastel) !important; text-decoration: underline; }

    .welcome-banner { background-color: #ffffff !important; color: var(--primary-text); border: 1px solid rgba(0, 0, 0, 0.05); box-shadow: 0 4px 12px rgba(0,0,0,0.08); border-radius: 12px; }
</style>

@section('content')
<div class="container-fluid min-vh-100">
    <div class="container py-4">

        <!-- Header -->
        <div class="row align-items-center mb-4">
            <div class="col-md-6">
                <div class="d-flex align-items-center mb-4">
                    <div class="profile-circle fw-bold me-3 d-flex align-items-center justify-content-center"
                         style="width: 60px; height: 60px; font-size: 18px; border-radius:50%;">
                        {{ Auth::check() ? strtoupper(substr(Auth::user()->name, 0, 2)) : 'GU' }}
                    </div>
                    <div>
                        <h1 class="h4 mb-1 fw-bold">
                            Halo, {{ Auth::check() ? ucfirst(Auth::user()->name) : 'Pengguna' }}
                        </h1>
                        <p class="text-muted mb-0">Selamat datang di LiteraSpace</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <form action="{{ route('dashboard') }}" method="GET" class="search-bar input-group rounded-pill shadow-sm">
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control border-0"
                           placeholder="Cari buku, penulis, atau kategori...">
                    <button class="btn btn-primary rounded-pill px-4" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
        </div>

        <!-- Welcome Banner -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="welcome-banner rounded-3 p-4 shadow">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h2 class="h4 mb-2">Dalam Genggaman, Tersimpan Ribuan Cerita</h2>
                            <p class="mb-0 opacity-90">Setiap halaman menyimpan keajaiban yang menunggu untuk kamu temukan.</p>
                        </div>
                        <div class="col-md-4 text-md-end">
                            <i class="fas fa-book-open display-4 opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="row mb-5">
            <div class="col-md-3 col-6 mb-3">
                <a href="{{ route('rak.pinjam') }}" class="text-decoration-none text-dark">
                    <div class="stat-card p-3 h-100">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon bg-info bg-opacity-10 rounded-2 p-3 me-3">
                                <i class="fas fa-bookmark text-info fs-4"></i>
                            </div>
                            <div>
                                <h3 class="h2 mb-0 fw-bold">{{ $rakPinjamCount ?? 0 }}</h3>
                                <p class="text-muted mb-0 small">Dalam Rak Pinjam</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-3 col-6 mb-3">
                <a href="{{ route('riwayat.peminjaman') }}" class="text-decoration-none text-dark">
                    <div class="stat-card p-3 h-100">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon bg-success bg-opacity-10 rounded-2 p-3 me-3">
                                <i class="fas fa-history text-success fs-4"></i>
                            </div>
                            <div>
                                <h3 class="h2 mb-0 fw-bold">{{ $riwayatCount ?? 0 }}</h3>
                                <p class="text-muted mb-0 small">Riwayat Peminjaman</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <!-- Daftar Buku -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="h4 fw-bold mb-0">
                        @if(request('search'))
                            Hasil Pencarian: "{{ request('search') }}"
                        @else
                            Rekomendasi Untuk Anda
                        @endif
                    </h2>
                    @if(!request('search'))
                        <a href="#" class="btn btn-link text-primary">
                            Lihat Semua <i class="fas fa-chevron-right ms-1"></i>
                        </a>
                    @endif
                </div>
                
                <div class="row g-3">
                    @forelse($books as $book)
                        <div class="col-xl-3 col-lg-4 col-md-6">
                            <div class="book-card card h-100">
                                <div class="book-cover position-relative overflow-hidden" style="height: 200px;">
                                    <div class="position-absolute top-0 end-0 m-3">
                                        <span class="badge bg-{{ $book->status == 'tersedia' ? 'success' : 'warning' }}">
                                            {{ ucfirst($book->status) }}
                                        </span>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-center h-100 text-white">
                                        <i class="fas fa-book fa-3x opacity-50"></i>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title fw-bold">{{ $book->judul }}</h5>
                                    <p class="card-text text-muted small">{{ $book->penulis }}</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="badge bg-primary bg-opacity-10 text-primary">
                                            {{ $book->kategori ?? 'Umum' }}
                                        </span>

                                        <!-- FORM POST PINJAM BUKU -->
<form action="{{ route('rak.add', $book->id) }}" method="POST">
    @csrf
    <button type="submit">Pinjam Buku</button>
</form>


                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5">
                            <i class="fas fa-search fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Tidak ada hasil ditemukan untuk "{{ request('search') }}"</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
