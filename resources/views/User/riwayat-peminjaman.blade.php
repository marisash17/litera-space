@extends('layouts.navigation')

@section('title', 'Riwayat Peminjaman - LiteraSpace')

@section('content')
<div class="container py-5" style="background-color: #FBEFE3; min-height: 100vh;">
    <h2 class="fw-bold mb-4 text-dark">Riwayat Peminjaman</h2>

    @if($riwayat->isEmpty())
        <div class="alert" style="background-color: #D4B89620; color: #4B4B4B; border-radius: 8px;">
            Belum ada buku yang pernah dipinjam.
        </div>
    @else
        <div class="row g-3">
            @foreach($riwayat as $book)
                <div class="col-md-4">
                    <div class="card shadow-sm border-0 h-100" style="background-color:#fff;">
                        <div class="card-body">
                            <h5 class="fw-bold mb-2">{{ $book->judul }}</h5>
                            <p class="text-muted small mb-2">{{ $book->penulis }}</p>
                            <span class="badge bg-success">Dikembalikan</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
