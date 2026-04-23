<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookReturn extends Model
{
    use HasFactory;

    protected $table = 'book_returns';
    protected $guarded = ['id'];
    protected $casts = [
        'actual_return_date' => 'date',
    ];

    // Relasi ke Peminjaman
    public function borrow()
    {
        return $this->belongsTo(Borrow::class);
    }

    // Accessor untuk User (melalui borrow)
    public function getUser()
    {
        return $this->borrow?->user;
    }

    // Accessor untuk Book (melalui borrow)
    public function getBook()
    {
        return $this->borrow?->book;
    }

    // Scope untuk pengembalian yang sudah dikembalikan
    public function scopeReturned($query)
    {
        return $query->where('status', 'dikembalikan');
    }

    // Scope untuk pengembalian yang terlambat
    public function scopeLate($query)
    {
        return $query->where('status', 'terlambat');
    }
}
