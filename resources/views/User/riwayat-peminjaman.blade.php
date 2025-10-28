@extends('layouts.navigation')

@section('title', 'Riwayat Peminjaman - LiteraSpace')

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
        --success: #28a745;
    }

    body {
        font-family: 'Poppins', sans-serif;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        background-color: var(--bg-light);
    }

    .page-container {
        background-color: var(--bg-light);
        min-height: 100vh;
        padding: 2rem 0;
    }

    .page-header {
        margin-bottom: 2rem;
    }

    .page-title {
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        color: var(--text-dark);
        font-size: 2rem;
        margin-bottom: 0.5rem;
    }

    .page-subtitle {
        color: var(--text-light);
        font-size: 1rem;
        margin-bottom: 0;
    }

    /* Card Styles */
    .history-card {
        background: linear-gradient(135deg, #ffffff, var(--bg-cream));
        border: 1px solid var(--border);
        border-left: 4px solid var(--success);
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        transition: all 0.3s ease;
        height: 100%;
        overflow: hidden;
    }

    .history-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 25px rgba(40, 167, 69, 0.12);
        border-left-color: var(--primary);
    }

    .card-content {
        padding: 1.5rem;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .book-title {
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        color: var(--text-dark);
        font-size: 1.1rem;
        line-height: 1.4;
        margin-bottom: 0.5rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .book-author {
        color: var(--text-light);
        font-size: 0.9rem;
        margin-bottom: 1rem;
        font-weight: 400;
    }

    .status-badge {
        background: var(--success);
        color: white;
        font-family: 'Poppins', sans-serif;
        font-weight: 500;
        font-size: 0.8rem;
        padding: 0.4rem 0.8rem;
        border-radius: 20px;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        margin-bottom: 1rem;
    }

    .date-info {
        margin-top: auto;
        padding-top: 1rem;
        border-top: 1px solid var(--border);
    }

    .date-text {
        color: var(--text-light);
        font-size: 0.8rem;
        display: flex;
        align-items: center;
        gap: 0.4rem;
        margin: 0;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        background: linear-gradient(135deg, #ffffff, var(--bg-cream));
        border: 1px solid var(--border);
        border-radius: 16px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    .empty-icon {
        font-size: 4rem;
        color: var(--secondary);
        opacity: 0.6;
        margin-bottom: 1.5rem;
    }

    .empty-title {
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        color: var(--text-dark);
        font-size: 1.5rem;
        margin-bottom: 0.75rem;
    }

    .empty-description {
        color: var(--text-light);
        font-size: 1rem;
        margin-bottom: 2rem;
        max-width: 400px;
        margin-left: auto;
        margin-right: auto;
    }

    .explore-btn {
        background: linear-gradient(135deg, var(--bg-cream), var(--bg-cream));
        color: var(--primary);
        border: 2px solid var(--primary);
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .explore-btn:hover {
        background: var(--primary);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(128, 150, 77, 0.3);
    }

    /* Grid Layout */
    .books-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 1.5rem;
        margin-top: 2rem;
    }

    /* Animation */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .fade-in {
        animation: fadeInUp 0.6s ease forwards;
    }

    .stagger-delay-1 { animation-delay: 0.1s; }
    .stagger-delay-2 { animation-delay: 0.2s; }
    .stagger-delay-3 { animation-delay: 0.3s; }

    /* Responsive */
    @media (max-width: 768px) {
        .page-container {
            padding: 1rem 0;
        }

        .page-title {
            font-size: 1.5rem;
        }

        .books-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .card-content {
            padding: 1.25rem;
        }

        .empty-state {
            padding: 3rem 1.5rem;
            margin: 0 1rem;
        }
    }

    @media (max-width: 480px) {
        .page-title {
            font-size: 1.25rem;
        }

        .empty-icon {
            font-size: 3rem;
        }

        .empty-title {
            font-size: 1.25rem;
        }
    }
</style>

@section('content')
<div class="page-container">
    <div class="container">
        <!-- Page Header -->
        <div class="page-header fade-in">
            <h1 class="page-title">Riwayat Peminjaman</h1>
            <p class="page-subtitle">Lihat semua buku yang pernah Anda pinjam</p>
        </div>

        @if($riwayat->isEmpty())
            <!-- Empty State -->
            <div class="empty-state fade-in">
                <i class="fas fa-history empty-icon"></i>
                <h2 class="empty-title">Belum Ada Riwayat Peminjaman</h2>
                <p class="empty-description">
                    Anda belum pernah meminjam buku dari LiteraSpace. 
                    Mulai jelajahi koleksi buku kami dan temukan bacaan menarik!
                </p>
                <a href="{{ route('dashboard') }}" class="explore-btn">
                    <i class="fas fa-book-open"></i>
                    Jelajahi Buku
                </a>
            </div>
        @else
            <!-- Books Grid -->
            <div class="books-grid">
                @foreach($riwayat as $index => $book)
                    <div class="history-card fade-in @if($index % 3 == 1) stagger-delay-1 @elseif($index % 3 == 2) stagger-delay-2 @endif">
                        <div class="card-content">
                            <!-- Book Info -->
                            <div class="book-info">
                                <h3 class="book-title">{{ $book->judul }}</h3>
                                <p class="book-author">{{ $book->penulis }}</p>
                            </div>

                            <!-- Status Badge -->
                            <span class="status-badge">
                                <i class="fas fa-check-circle"></i>
                                Dikembalikan
                            </span>

                            <!-- Date Information -->
                            <div class="date-info">
                                @if($book->tanggal_kembali)
                                    <p class="date-text">
                                        <i class="fas fa-calendar-check"></i>
                                        Dikembalikan: {{ \Carbon\Carbon::parse($book->tanggal_kembali)->translatedFormat('d F Y') }}
                                    </p>
                                @endif
                                
                                @if($book->tanggal_pinjam)
                                    <p class="date-text">
                                        <i class="fas fa-clock"></i>
                                        Dipinjam: {{ \Carbon\Carbon::parse($book->tanggal_pinjam)->translatedFormat('d F Y') }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Results Count -->
            <div class="mt-4 fade-in">
                <p class="text-muted" style="font-size: 0.9rem;">
                    Menampilkan {{ $riwayat->count() }} buku dari riwayat peminjaman Anda
                </p>
            </div>
        @endif
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Smooth hover effects
        const cards = document.querySelectorAll('.history-card');
        
        cards.forEach(card => {
            // Add hover effect
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-4px)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });

            // Add click effect
            card.addEventListener('mousedown', function() {
                this.style.transform = 'translateY(-2px)';
            });
            
            card.addEventListener('mouseup', function() {
                this.style.transform = 'translateY(-4px)';
            });
        });

        // Add loading animation for cards
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observe all cards for animation
        cards.forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'all 0.6s ease';
            observer.observe(card);
        });
    });
</script>
@endsection