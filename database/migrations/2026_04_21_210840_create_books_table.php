<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('author');
            $table->string('publisher')->nullable();
            $table->string('published_year', 4)->nullable();
            
            // Relasi Foreign Key ke tabel categories
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            
            $table->integer('stock')->default(0);
            $table->text('description')->nullable();
            
            // Menggunakan URL gambar untuk cover (bisa dikembangkan jadi upload file nanti)
            $table->string('cover_url')->nullable(); 
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};