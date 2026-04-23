<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('borrows', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('book_id')->constrained()->onDelete('cascade');
            
            $table->date('borrow_date'); 
            $table->date('due_date');    
            $table->string('guarantee'); 
            
            // PERBAIKAN: Tambahkan semua kemungkinan status di sini
            $table->enum('status', [
                'menunggu_persetujuan', 
                'dipinjam', 
                'ditolak',
                'menunggu_pengembalian', // <-- Tambahkan ini
                'dikembalikan',          // <-- Tambahkan ini
                'terlambat'              // <-- Tambahkan ini
            ])->default('menunggu_persetujuan');
            
            $table->text('reject_reason')->nullable(); 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('borrows');
    }
};