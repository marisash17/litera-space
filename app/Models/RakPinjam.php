<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RakPinjam extends Model
{
    protected $fillable = ['user_id', 'buku_id', 'status'];
    
    public function buku()
    {
        return $this->belongsTo(Buku::class, 'buku_id');
    }
}
