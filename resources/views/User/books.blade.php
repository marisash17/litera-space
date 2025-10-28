@extends('layouts.navigation')

@section('title', 'Semua Buku - LiteraSpace')

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

    .page-container {
        max-width: 1200px;
        margin: 0 auto;
    }

    .page-title {
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 1rem;
    }

    .page-subtitle {
        color: var(--text-light);
        margin-bottom: 2rem;
    }

    .search-section {
        background: linear-gradient(135deg, white, var(--bg-cream));
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        border: 1px solid var(--border);
    }

    .search-bar input {
        background-color: white !important;
        border: 2px solid var(--border);
        transition: all 0.3s ease;
    }

    .search-bar input:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(128, 150, 77, 0.1);
    }

    .btn-search {
        background: linear-gradient(135deg, var(--bg-cream), var(--bg-cream)) !important;
        border: 2px solid var(--primary) !important;
        color: var(--primary) !important;
        transition: all 0.3s ease;
        font-weight: 600;
    }

    .btn-search:hover {
        background: var(--primary) !important;
        color: white !important;
        transform: translateY(-1px);
    }

    .books-counter {
        color: var(--text-light);
        font-size: 0.9rem;
        margin-bottom: 1rem;
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

    .book-cover {
        background: linear-gradient(135deg, var(--primary-dark), var(--primary));
        color: white;
        height: 160px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }

    .book-icon {
        font-size: 2.5rem;
        opacity: 0.9;
    }

    .status-badge {
        position: absolute;
        top: 12px;
        right: 12px;
        font-size: 0.75rem;
        font-weight: 600;
        padding: 0.4rem 0.8rem;
        border-radius: 20px;
    }

    .book-content {
        padding: 1.25rem;
    }

    .book-title {
        font-weight: 600;
        font-size: 1rem;
        line-height: 1.4;
        margin-bottom: 0.5rem;
        color: var(--text-dark);
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .book-author {
        color: var(--text-light);
        font-size: 0.85rem;
        margin-bottom: 1rem;
    }

    .book-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .category-tag {
        background: rgba(128, 150, 77, 0.1);
        color: var(--primary);
        padding: 0.3rem 0.7rem;
        border-radius: 16px;
        font-size: 0.75rem;
        font-weight: 500;
    }

    .borrow-btn {
        background: linear-gradient(135deg, var(--bg-cream), var(--bg-cream));
        border: 2px solid var(--primary);
        color: var(--primary);
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
        transition: all 0.3s ease;
    }

    .borrow-btn:hover:not(.disabled) {
        background: var(--primary);
        color: white;
        transform: scale(1.1);
    }

    .borrow-btn.disabled {
        opacity: 0.5;
        cursor: not-allowed;
        border-color: var(--text-light);
        color: var(--text-light);
    }

    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        background: linear-gradient(135deg, white, var(--bg-cream));
        border-radius: 12px;
        border: 1px solid var(--border);
    }

    .empty-icon {
        font-size: 3rem;
        color: var(--primary);
        opacity: 0.3;
        margin-bottom: 1rem;
    }

    .empty-text {
        color: var(--text-light);
        margin: 0;
    }

    .books-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 1.5rem;
    }

    @media (max-width: 768px) {
        .books-grid {
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 1rem;
        }
        
        .search-section {
            padding: 1rem;
        }
    }

    @media (max-width: 480px) {
        .books-grid {
            grid-template-columns: 1fr;
        }
        
        .book-cover {
            height: 140px;
        }
    }
</style>

@section('content')
<div class="container py-4">
    <div class="page-container">

        <!-- Page Header -->
        <div class="mb-4">
            <h1 class="page-title h3">Semua Buku</h1>
            <p class="page-subtitle">Jelajahi koleksi buku diLiteraSpace</p>
        </div>

        <!-- Search Section -->
        <div class="search-section">
            <form action="{{ route('books.index') }}" method="GET" class="search-bar input-group">
                <input type="text" name="search" value="{{ request('search') }}" 
                       class="form-control rounded-start-pill ps-3"
                       placeholder="Cari buku...">
                <button class="btn btn-search rounded-end-pill px-4" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>

        <!-- Books Counter -->
        @if($books->isNotEmpty())
            <div class="books-counter">
                Menampilkan {{ $books->count() }} buku
                @if($search)
                    untuk "{{ $search }}"
                @endif
            </div>
        @endif

        <!-- Books Grid -->
        <div class="books-grid">
            @forelse($books as $book)
                <div class="book-card">
                    <!-- Book Cover -->
                    <div class="book-cover">
                        <i class="fas fa-book book-icon"></i>
                        <span class="status-badge bg-{{ $book->status == 'tersedia' ? 'success' : 'warning' }}">
                            {{ $book->status == 'tersedia' ? 'Tersedia' : 'Dipinjam' }}
                        </span>
                    </div>

                    <!-- Book Content -->
                    <div class="book-content">
                        <h3 class="book-title">{{ $book->judul }}</h3>
                        <p class="book-author">{{ $book->penulis }}</p>
                        
                        <div class="book-meta">
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
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <i class="fas fa-book-open empty-icon"></i>
                    <p class="empty-text">
                        @if($search)
                            Tidak ada buku yang cocok dengan "{{ $search }}"
                        @else
                            Belum ada buku tersedia
                        @endif
                    </p>
                </div>
            @endforelse
        </div>

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Simple hover effects
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