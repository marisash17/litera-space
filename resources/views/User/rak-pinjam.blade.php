@extends('layouts.navigation')

@section('title', 'Rak Pinjam - LiteraSpace')

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

    body {
        font-family: 'Poppins', sans-serif;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }

    .container-fluid {
        background-color: var(--bg-light) !important;
        min-height: 100vh;
    }

    h1, h2, h3, h4, h5, h6 {
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        color: var(--text-dark);
    }

    .fw-bold {
        font-weight: 600 !important;
    }

    /* Card Styles */
    .card {
        background: linear-gradient(135deg, white, var(--bg-cream)) !important;
        border: 1px solid var(--border) !important;
        border-left: 4px solid var(--primary) !important;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(128, 150, 77, 0.15);
    }

    /* Button Styles */
    .btn-primary-custom {
        background: linear-gradient(135deg, var(--bg-cream), var(--bg-cream));
        color: var(--primary);
        border: 2px solid var(--primary);
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(128, 150, 77, 0.2);
        font-weight: 600;
        font-family: 'Poppins', sans-serif;
    }

    .btn-primary-custom:hover {
        background: var(--primary);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(128, 150, 77, 0.3);
    }

    .btn-outline-danger {
        border: 2px solid #dc3545;
        color: #dc3545;
        background: transparent;
        transition: all 0.3s ease;
        font-weight: 500;
        font-family: 'Poppins', sans-serif;
    }

    .btn-outline-danger:hover {
        background: #dc3545;
        color: white;
        transform: translateY(-1px);
    }

    /* Badge Styles */
    .badge.bg-warning {
        background: var(--secondary) !important;
        color: var(--text-dark) !important;
        font-weight: 500;
        font-family: 'Poppins', sans-serif;
    }

    /* Text Colors */
    .text-muted {
        color: var(--text-light) !important;
        font-family: 'Poppins', sans-serif;
    }

    .text-dark {
        color: var(--text-dark) !important;
    }

    /* Empty State */
    .empty-state {
        color: var(--text-light);
    }

    .empty-state i {
        color: var(--primary);
        opacity: 0.3;
    }

    /* Animation */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .fade-in {
        animation: fadeIn 0.5s ease forwards;
    }
</style>

@section('content')
<div class="container-fluid">
    <div class="container py-5">
        <h1 class="h2 fw-bold mb-4 fade-in">Rak Pinjam Saya</h1>

        @if($books->isEmpty())
            <div class="text-center py-5 empty-state fade-in">
                <i class="fas fa-book-open fa-4x mb-3"></i>
                <h3 class="fw-normal mb-2">Rak Pinjam Masih Kosong</h3>
                <p class="mb-4">Silakan cari buku yang menarik untuk dipinjam.</p>
                <a href="{{ route('dashboard') }}" class="btn btn-primary-custom">
                    <i class="fas fa-home me-2"></i>Kembali ke Dashboard
                </a>
            </div>
        @else
            <div class="row g-4">
                @foreach($books as $index => $book)
                    <div class="col-xl-4 col-lg-6 col-md-6">
                        <div class="card shadow-sm h-100 fade-in" style="animation-delay: {{ $index * 0.1 }}s">
                            <div class="card-body">
                                <h5 class="fw-bold mb-2">{{ $book->judul }}</h5>
                                <p class="text-muted small mb-2">{{ $book->penulis }}</p>
                                <div class="d-flex align-items-center mb-3">
                                    <span class="badge bg-warning me-2">Sedang Dipinjam</span>
                                    @if($book->tanggal_kembali)
                                        <small class="text-muted">
                                            <i class="fas fa-clock me-1"></i>
                                            Kembali: {{ \Carbon\Carbon::parse($book->tanggal_kembali)->format('d M Y') }}
                                        </small>
                                    @endif
                                </div>
                            </div>
                            <div class="card-footer bg-transparent border-0 d-flex justify-content-between align-items-center">
                                <form action="{{ route('kembalikan.buku', $book->id) }}" method="POST" class="mb-0">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger btn-sm" 
                                            onclick="return confirm('Apakah yakin ingin mengembalikan buku ini?')">
                                        <i class="fas fa-undo me-1"></i>Kembalikan
                                    </button>
                                </form>
                                <a href="{{ route('baca.buku', $book->id) }}" class="btn btn-primary-custom btn-sm">
                                    <i class="fas fa-book-open me-1"></i>Baca
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Info Summary -->
            <div class="row mt-5">
                <div class="col-12">
                    <div class="card fade-in">
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-md-4">
                                    <h4 class="fw-bold text-primary">{{ $books->count() }}</h4>
                                    <p class="text-muted mb-0">Total Buku Dipinjam</p>
                                </div>
                                <div class="col-md-4">
                                    <h4 class="fw-bold text-primary">
                                        {{ $books->where('tanggal_kembali', '>=', now())->count() }}
                                    </h4>
                                    <p class="text-muted mb-0">Aktif</p>
                                </div>
                                <div class="col-md-4">
                                    <h4 class="fw-bold text-primary">
                                        {{ $books->where('tanggal_kembali', '<', now())->count() }}
                                    </h4>
                                    <p class="text-muted mb-0">Perlu Dikembalikan</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<script>
    // Add confirmation for return action
    document.addEventListener('DOMContentLoaded', function() {
        const returnForms = document.querySelectorAll('form[action*="kembalikan"]');
        returnForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                if (!confirm('Apakah yakin ingin mengembalikan buku ini?')) {
                    e.preventDefault();
                }
            });
        });

        // Add hover effects
        const cards = document.querySelectorAll('.card');
        cards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px)';
            });
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
    });
</script>
@endsection