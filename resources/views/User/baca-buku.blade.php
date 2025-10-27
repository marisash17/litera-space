@extends('layouts.navigation')

@section('title', 'Baca Buku - LiteraSpace')

@section('content')
<div class="container py-5">
    <h1>{{ $book->judul }}</h1>
    <p>Penulis: {{ $book->penulis }}</p>
    <p>Kategori: {{ $book->kategori ?? 'Umum' }}</p>
    <p>{{ $book->deskripsi }}</p>
    <a href="{{ route('rak.pinjam') }}" class="btn btn-primary mt-3">Kembali ke Rak Pinjam</a>
</div>
@endsection
