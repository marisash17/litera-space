<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $table = 'members';

    protected $fillable = [
        'nama',
        'email',
        'no_hp',
        'alamat',
        'status',
    ];

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class);
    }
}