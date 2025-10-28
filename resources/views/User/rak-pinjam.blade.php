@extends('layouts.navigation')

@section('title', 'Rak Pinjam Saya - LiteraSpace')

<style>
    :root {
        --primary: rgb(128, 150, 77);     
        --primary-dark: rgb(108, 130, 57); 
        --secondary: #e09c08;             
        --bg-light: #f6f7fb;              
        --bg-cream: #fbefe3;              
        --text-dark: #444;                
        --text-light: #666;               
        --border: #ddd;                   
    }

    body {
        background-color: var(--bg-light);
        color: var(--text-dark);
        font-family: 'Poppins', sans-serif;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }

    .book-card {
        background: linear-gradient(135deg, white, var(--bg-cream));
        border: 1px solid var(--border);
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.06);
        transition: all 0.3s ease;
        height: 100%;
        overflow: hidden;
    }

    .book-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(128, 150, 77, 0.12);
    }

    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        background: linear-gradient(135deg, white, var(--bg-cream));
        border-radius: 12px;
        border: 1px solid var(--border);
    }

    .empty-state i {
        font-size: 3rem;
        color: var(--primary);
        opacity: 0.3;
        margin-bottom: 1rem;
    }
</style>

@section('content')
<div class="container py-4">
    <div class="page-header fade-in">
        <div>
            <h1 class="h2 fw-bold page-title">Rak Pinjam Saya</h1>
            <p class="text-muted mb-0">Kelola buku yang sedang Anda pinjam</p>
        </div>
        <a href="{{ route('dashboard') }}" class="btn btn-primary-custom">
            <i class="fas fa-home me-2"></i>Kembali ke Dashboard
        </a>
    </div>

    @if($books->isEmpty())
        <div class="text-center py-5 empty-state fade-in">
            <i class="fas fa-book-open fa-4x mb-3"></i>
            <h3 class="fw-normal mb-2">Rak Pinjam Masih Kosong</h3>
            <p class="mb-4">Silakan cari buku yang menarik untuk dipinjam.</p>
            {{-- Ganti route katalog dengan route books.index --}}
            <a href="{{ route('books.index') }}" class="btn btn-primary-custom">
                <i class="fas fa-search me-2"></i>Jelajahi Buku
            </a>
        </div>
    @else
        <div class="row g-4 mb-5">
            @foreach($books as $index => $book)
                @php
                    $isOverdue = $book->tanggal_kembali && \Carbon\Carbon::parse($book->tanggal_kembali)->isPast();
                @endphp
                <div class="col-xl-4 col-lg-6 col-md-6">
                    <div class="book-card h-100 fade-in" style="animation-delay: {{ $index * 0.1 }}s">
                        <div class="card-body">
                            <div class="book-header">
                                <div class="book-cover">
                                    <i class="fas fa-book book-icon"></i>
                                    <span class="status-badge bg-{{ $book->status == 'tersedia' ? 'success' : 'warning' }}">
                                        {{ $book->status == 'tersedia' ? 'Tersedia' : 'Dipinjam' }}
                                    </span>
                                </div>
                            </div>
                            <div class="book-content mt-3">
                                <h3 class="book-title">{{ $book->judul }}</h3>
                                <p class="book-author">{{ $book->penulis }}</p>
                                <div class="book-meta d-flex justify-content-between align-items-center">
                                    <span class="category-tag">
                                        {{ $book->kategori ?? 'Umum' }}
                                    </span>
                                    <form action="{{ route('rak.pinjam.post', $book->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" 
                                                class="borrow-btn {{ $book->status != 'tersedia' ? 'disabled' : '' }}"
                                                {{ $book->status != 'tersedia' ? 'disabled' : '' }}
                                                title="{{ $book->status == 'tersedia' ? 'Pinjam buku' : 'Buku sedang dipinjam' }}">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </form>
                                </div>
                                @if($isOverdue)
                                    <p class="text-danger mt-2 small">Telat dikembalikan!</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const bookCards = document.querySelectorAll('.book-card');
        bookCards.forEach(card => {
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
