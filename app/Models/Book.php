<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 
        'author', 
        'publisher', 
        'published_year', 
        'category_id', 
        'stock', 
        'description', 
        'cover_url'
    ];

    // Relasi: Setiap buku memiliki 1 kategori (BelongsTo)
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}