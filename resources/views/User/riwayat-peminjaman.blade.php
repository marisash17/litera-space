@extends('layouts.navigation')

@section('title', 'Riwayat Peminjaman - LiteraSpace')

@section('content')
<div class="container py-5">
    <h2 class="fw-bold mb-4">Riwayat Peminjaman</h2>

    @if($riwayat->isEmpty())
        <div class="alert alert-info">Belum ada buku yang pernah dipinjam.</div>
    @else
        <div class="row g-3">
            @foreach($riwayat as $book)
                <div class="col-md-4">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body">
                            <h5 class="card-title fw-bold">{{ $book->judul }}</h5>
                            <p class="card-text text-muted small">{{ $book->penulis }}</p>
                            <span class="badge bg-success">Dikembalikan</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
