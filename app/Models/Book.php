<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    // Tabel default sudah 'books', jadi tidak perlu diubah

    protected $fillable = [
        'judul',
        'penulis',
        'penerbit',
        'tahun_terbit',
        'isbn',
        'stok',
        'deskripsi',
        'foto',
        'kategori',   // ditambahkan untuk search & filter
        'status',
        'user_id',
    ];

    // Relasi ke user (jika ada)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
