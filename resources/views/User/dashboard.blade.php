@extends('layouts.navigation')

@section('title', 'Dashboard - LiteraSpace')

<style>
    :root {
        --primary: rgb(128, 150, 77);     /* hijau dari login */
        --primary-dark: rgb(108, 130, 57); /* hijau dark dari login */
        --secondary: #e09c08;             /* gold/orange dari login */
        --bg-light: #f6f7fb;              /* background dari login */
        --bg-cream: #fbefe3;              /* cream dari login */
        --text-dark: #444;                /* text dari login */
        --text-light: #666;               /* text light dari login */
        --border: #ddd;                   /* border dari login */
    }

    /* Warna dasar */
    body {
        background-color: var(--bg-light);
        color: var(--text-dark);
        font-family: 'Poppins', sans-serif;
    }

    .bg-primary {
        background: linear-gradient(135deg, var(--bg-cream), white) !important;
    }

    .text-primary {
        color: var(--primary) !important;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--bg-cream), var(--bg-cream)) !important;
        border: 2px solid var(--primary) !important;
        color: var(--primary) !important;
        transition: all 0.3s ease;
        font-weight: 600;
        box-shadow: 0 4px 15px rgba(128, 150, 77, 0.2);
    }

    .btn-primary:hover {
        background: var(--primary) !important;
        border-color: var(--primary) !important;
        color: white !important;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(128, 150, 77, 0.3);
    }

    /* Profil circle */
    .profile-circle {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark)) !important;
        color: white;
        font-weight: 600;
    }

    /* Search bar */
    .search-bar input {
        background-color: white !important;
        border: 2px solid var(--border);
        transition: all 0.3s ease;
    }

    .search-bar input:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(128, 150, 77, 0.1);
    }

    /* CARD STATS: putih dengan aksen login */
    .stat-card {
        background: linear-gradient(135deg, white, var(--bg-cream)) !important;
        border: 1px solid var(--border) !important;
        border-left: 4px solid var(--primary) !important;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 25px rgba(128, 150, 77, 0.15);
    }

    /* Ikon dalam stat-card */
    .stat-icon {
        background: var(--bg-cream) !important;
        border: 1px solid var(--border);
    }

    .stat-icon.text-info {
        color: var(--primary) !important;
    }

    .stat-icon.text-success {
        color: var(--secondary) !important;
    }

    /* Book card */
    .book-card {
        background: linear-gradient(135deg, white, var(--bg-cream)) !important;
        border: 1px solid var(--border) !important;
        border-left: 4px solid var(--primary) !important;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
    }

    .book-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(128, 150, 77, 0.15);
    }

    /* Book cover */
    .book-cover {
        background: linear-gradient(135deg, var(--bg-cream), white);
        color: var(--text-dark);
        border-bottom: 1px solid var(--border);
    }

    /* Link */
    .btn-link.text-primary {
        color: var(--primary) !important;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-link.text-primary:hover {
        color: var(--primary-dark) !important;
        text-decoration: underline;
        transform: translateX(2px);
    }

    /* Welcome banner */
    .welcome-banner {
        background: linear-gradient(135deg, white, var(--bg-cream)) !important;
        color: var(--text-dark);
        border: 1px solid var(--border);
        border-left: 4px solid var(--primary);
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        border-radius: 12px;
    }

    /* Badge styles */
    .badge.bg-success {
        background: var(--primary) !important;
    }

    .badge.bg-warning {
        background: var(--secondary) !important;
    }

    .badge.bg-primary {
        background: var(--primary) !important;
    }

    .bg-opacity-10 {
        background-color: rgba(128, 150, 77, 0.1) !important;
    }

    /* Text colors */
    .text-muted {
        color: var(--text-light) !important;
    }

    /* Animation */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .fade-in {
        animation: fadeIn 0.5s ease forwards;
    }

    /* Typography improvements */
    h1, h2, h3, h4, h5, h6 {
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        color: var(--text-dark);
    }

    .fw-bold {
        font-weight: 600 !important;
    }

    /* Icon colors */
    .fa-book-open {
        color: var(--primary);
    }

    .fa-search {
        color: var(--text-light);
    }
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
                <div class="welcome-banner rounded-3 p-4 shadow fade-in">
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
                <a href="{{ route('rak.pinjam') }}" class="text-decoration-none">
                    <div class="stat-card p-3 h-100 fade-in">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon rounded-2 p-3 me-3">
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
                <a href="{{ route('riwayat.peminjaman') }}" class="text-decoration-none">
                    <div class="stat-card p-3 h-100 fade-in">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon rounded-2 p-3 me-3">
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
                            <div class="book-card card h-100 fade-in">
                                <div class="book-cover position-relative overflow-hidden" style="height: 200px;">
                                    <div class="position-absolute top-0 end-0 m-3">
                                        <span class="badge bg-{{ $book->status == 'tersedia' ? 'success' : 'warning' }}">
                                            {{ ucfirst($book->status) }}
                                        </span>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-center h-100">
                                        <i class="fas fa-book fa-3x opacity-50" style="color: var(--primary);"></i>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title fw-bold">{{ $book->judul }}</h5>
                                    <p class="card-text text-muted small">{{ $book->penulis }}</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="badge bg-opacity-10 text-primary">
                                            {{ $book->kategori ?? 'Umum' }}
                                        </span>
                                        <a href="{{ route('rak.pinjam') }}" class="btn btn-primary btn-sm rounded-circle" title="Pinjam Buku">
                                            <i class="fas fa-plus"></i>
                                        </a>
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

<script>
    // Add animation delays for staggered effect
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.book-card, .stat-card');
        cards.forEach((card, index) => {
            card.style.animationDelay = `${index * 0.1}s`;
        });
    });
</script>
@endsection