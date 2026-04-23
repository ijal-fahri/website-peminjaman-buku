<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Kolom yang diizinkan untuk diisi secara massal
    protected $fillable = [
        'name',
        'description',
    ];

    // Relasi ke tabel buku (1 Kategori punya banyak Buku)
    public function books()
    {
        return $this->hasMany(Book::class);
    }
}