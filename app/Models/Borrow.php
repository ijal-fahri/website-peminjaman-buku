<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Borrow extends Model
{
    use HasFactory;

    protected $table = 'borrows';
    protected $guarded = ['id'];
    protected $casts = [
        'borrow_date' => 'date',
        'due_date' => 'date',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Buku
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    // Relasi ke Pengembalian Buku
    public function bookReturn()
    {
        return $this->hasOne(BookReturn::class, 'borrow_id');
    }

    // Accessor untuk backward compatibility (return_date -> due_date)
    protected function returnDate(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->due_date,
        );
    }

    // Scope: Peminjaman yang aktif (sudah disetujui dan belum dikembalikan)
    public function scopeActive($query)
    {
        return $query->where('status', 'dipinjam');
    }

    // Scope: Peminjaman yang sudah dikembalikan
    public function scopeCompleted($query)
    {
        return $query->whereHas('bookReturn', function($q) {
            $q->where('status', 'dikembalikan');
        });
    }

    // Cek apakah peminjaman sudah terlambat
    public function isLate()
    {
        return now()->toDateString() > $this->due_date && $this->status == 'dipinjam';
    }

    // Hitung denda (Rp 5000 per hari)
    public function calculateFine()
    {
        if ($this->bookReturn && $this->bookReturn->status == 'dikembalikan') {
            $daysLate = $this->bookReturn->actual_return_date->diffInDays($this->due_date);
            return max(0, $daysLate * 5000);
        }
        return 0;
    }
}