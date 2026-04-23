<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('book_returns', function (Blueprint $table) {
            $table->id();
            // Menyambungkan tabel ini dengan tabel borrows (ID Peminjaman)
            $table->foreignId('borrow_id')->constrained('borrows')->onDelete('cascade');
            
            $table->date('actual_return_date')->nullable(); // Tanggal buku benar-benar dikembalikan
            
            // Status khusus pengembalian
            $table->enum('status', [
                'menunggu_pengembalian', 
                'dikembalikan', 
                'terlambat'
            ])->default('menunggu_pengembalian');
            
            $table->integer('fine')->default(0); // Denda dipindah ke sini
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('book_returns');
    }
};