@extends('layouts.navigation')

@section('title', 'Rak Pinjam - LiteraSpace')

@section('content')
<div class="container-fluid bg-light min-vh-100">
    <div class="container py-5">
        <!-- Header Section -->
        <div class="row align-items-center mb-5">
            <div class="col-md-8">
                <div class="d-flex align-items-center">
                    <div class="bg-primary rounded-circle p-3 me-3">
                        <i class="fas fa-bookmark text-white fs-4"></i>
                    </div>
                    <div>
                        <h1 class="h2 fw-bold text-dark mb-2">Rak Pinjam Saya</h1>
                        <p class="text-muted mb-0">Kelola buku-buku yang sedang Anda pinjam</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 text-md-end">
                <div class="bg-white rounded-3 p-3 shadow-sm">
                    <div class="text-center">
                        <h3 class="h4 fw-bold text-warning mb-1">{{ $books->where('status', 'dipinjam')->count() }}</h3>
                        <p class="small text-muted mb-0">Sedang Dipinjam</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Books Grid -->
        <div class="row">
            @if($books->isEmpty())
                <!-- Empty State -->
                <div class="col-12">
                    <div class="text-center py-5 my-4">
                        <div class="empty-state-icon mb-4">
                            <i class="fas fa-book-open fa-4x text-muted opacity-25"></i>
                        </div>
                        <h3 class="h4 text-muted fw-normal mb-3">Rak Pinjam Masih Kosong</h3>
                        <p class="text-muted mb-4">Belum ada buku yang dipinjam. Silakan cari buku yang menarik untuk dipinjam.</p>
                        <div class="d-flex justify-content-center gap-3">
                            <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg px-4">
                                <i class="fas fa-home me-2"></i>Kembali ke Beranda
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <!-- Books List -->
                @foreach($books as $book)
                <div class="col-xl-4 col-lg-6 mb-4">
                    <div class="book-card card border-0 shadow-sm h-100 transition-all">
                        <div class="card-header bg-transparent border-0 pb-0">
                            <div class="d-flex justify-content-between align-items-start">
                                <span class="badge bg-{{ $book->status == 'dipinjam' ? 'warning' : 'success' }} rounded-pill">
                                    {{ $book->status == 'dipinjam' ? 'Sedang Dipinjam' : 'Tersedia' }}
                                </span>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary border-0" type="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('buku.detail', $book->id) }}">
                                                <i class="fas fa-info-circle me-2"></i>Detail Buku
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#">
                                                <i class="fas fa-share me-2"></i>Bagikan
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-3">
                                    <div class="book-cover-small rounded-3" style="height: 100px; background: linear-gradient(135deg, #4361ee, #4cc9f0);">
                                        <div class="w-100 h-100 d-flex align-items-center justify-content-center text-white">
                                            <i class="fas fa-book fa-lg opacity-75"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-9">
                                    <h5 class="card-title fw-bold text-dark mb-2 line-clamp-2">{{ $book->judul }}</h5>
                                    <p class="card-text text-muted small mb-2">
                                        <i class="fas fa-user-edit me-1"></i>{{ $book->penulis }}
                                    </p>
                                    <p class="card-text text-muted small mb-3">
                                        <i class="fas fa-calendar me-1"></i>
                                        Batas: {{ $book->batas_pengembalian ?? '15 Des 2023' }}
                                    </p>
                                    
                                    @if($book->status == 'dipinjam')
                                    <div class="progress mb-3" style="height: 6px;">
                                        <div class="progress-bar bg-warning" role="progressbar" style="width: 65%;" 
                                             aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <p class="small text-muted mb-0">Sisa waktu: 5 hari</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <div class="card-footer bg-transparent border-0 pt-0">
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="{{ route('buku.kembalikan', $book->id) }}" 
                                   class="btn btn-outline-danger btn-sm action-btn flex-fill"
                                   onclick="return confirm('Apakah Anda yakin ingin mengembalikan buku ini?')">
                                    <i class="fas fa-undo me-1"></i>Kembalikan
                                </a>
                                <a href="{{ route('buku.baca', $book->id) }}" 
                                   class="btn btn-primary btn-sm action-btn flex-fill">
                                    <i class="fas fa-book-open me-1"></i>Baca
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @endif
        </div>

        <!-- Quick Actions -->
        @if(!$books->isEmpty())
        <div class="row mt-5">
            <div class="col-12">
                <div class="bg-white rounded-3 p-4 shadow-sm">
                    <h5 class="fw-bold mb-3">Aksi Cepat</h5>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="d-flex align-items-center p-3 border rounded-3 hover-shadow">
                                <div class="bg-primary bg-opacity-10 rounded-2 p-2 me-3">
                                    <i class="fas fa-download text-primary fs-5"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1">Download Semua</h6>
                                    <p class="small text-muted mb-0">Unduh buku yang tersedia</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex align-items-center p-3 border rounded-3 hover-shadow">
                                <div class="bg-success bg-opacity-10 rounded-2 p-2 me-3">
                                    <i class="fas fa-sync text-success fs-5"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1">Perpanjang Semua</h6>
                                    <p class="small text-muted mb-0">Perpanjang masa pinjam</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('riwayat.peminjaman') }}" class="text-decoration-none text-dark">
                                <div class="d-flex align-items-center p-3 border rounded-3 hover-shadow">
                                    <div class="bg-info bg-opacity-10 rounded-2 p-2 me-3">
                                        <i class="fas fa-history text-info fs-5"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-1">Riwayat Pinjam</h6>
                                        <p class="small text-muted mb-0">Lihat sejarah peminjaman</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<style>
    .transition-all {
        transition: all 0.3s ease;
    }
    
    .book-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15) !important;
    }
    
    .hover-shadow:hover {
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        transform: translateY(-2px);
        transition: all 0.3s ease;
    }
    
    .action-btn {
        transition: all 0.3s ease;
    }
    
    .action-btn:hover {
        transform: translateY(-1px);
    }
    
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .empty-state-icon {
        opacity: 0.5;
    }
    
    .book-cover-small {
        background: linear-gradient(135deg, var(--primary), var(--accent));
    }
    
    .progress {
        background-color: #e9ecef;
        border-radius: 10px;
    }
    
    .progress-bar {
        border-radius: 10px;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('a[href*="kembalikan"]').forEach(link => {
            link.addEventListener('click', function(e) {
                if (!confirm('Apakah Anda yakin ingin mengembalikan buku ini?')) {
                    e.preventDefault();
                }
            });
        });
    });

    function showSearchTips() {
        alert('Tips Pencarian:\n\n1. Gunakan kata kunci spesifik\n2. Filter berdasarkan kategori\n3. Cari berdasarkan penulis\n4. Gunakan fitur pencarian lanjutan di beranda');
    }
</script>
@endsection
