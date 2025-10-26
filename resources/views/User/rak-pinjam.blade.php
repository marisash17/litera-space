@extends('layouts.navigation')

@section('title', 'Rak Pinjam - LiteraSpace')

@section('content')
<div class="container-fluid" style="background-color: #FBEFE3; min-height: 100vh;">
    <div class="container py-5">
        <h1 class="h2 fw-bold text-dark mb-4">Rak Pinjam Saya</h1>

        @if($books->isEmpty())
            <div class="text-center py-5">
                <i class="fas fa-book-open fa-4x text-muted opacity-25 mb-3"></i>
                <h3 class="text-muted fw-normal mb-2">Rak Pinjam Masih Kosong</h3>
                <p class="text-muted mb-4">Silakan cari buku yang menarik untuk dipinjam.</p>
                <a href="{{ route('dashboard') }}" class="btn" style="background-color:#D4B896; color:white;">
                    <i class="fas fa-home me-2"></i>Kembali ke Dashboard
                </a>
            </div>
        @else
            <div class="row g-4">
                @foreach($books as $book)
                    <div class="col-md-4">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-body">
                                <h5 class="fw-bold mb-2">{{ $book->judul }}</h5>
                                <p class="text-muted small mb-2">{{ $book->penulis }}</p>
                                <span class="badge bg-warning text-dark">Sedang Dipinjam</span>
                            </div>
                            <div class="card-footer bg-transparent border-0 d-flex justify-content-between">
                                <form action="{{ route('kembalikan.buku', $book->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Apakah yakin ingin mengembalikan buku ini?')">
                                        <i class="fas fa-undo me-1"></i>Kembalikan
                                    </button>
                                </form>
                                <a href="{{ route('baca.buku', $book->id) }}" class="btn btn-sm" style="background-color:#D4B896;color:white;">
                                    <i class="fas fa-book-open me-1"></i>Baca
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
