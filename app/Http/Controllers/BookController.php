<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends Controller
{
    // Menampilkan halaman kelola buku
    public function index(Request $request)
    {
        // Mengambil data buku beserta relasi kategorinya untuk mencegah N+1 Query
        $query = Book::with('category')->latest();

        // Fitur Pencarian (Search)
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%")
                  // Pencarian berdasarkan nama kategori
                  ->orWhereHas('category', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
        }

        // Pagination Dinamis
        $perPage = $request->input('per_page', 5);
        $books = $query->paginate($perPage);

        // Mengambil semua kategori untuk ditampilkan di Dropdown (Select) form tambah/edit
        $categories = Category::orderBy('name', 'asc')->get();

        return view('admin.books.index', compact('books', 'categories'));
    }

    // Menyimpan buku baru
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'stock' => 'required|integer|min:0',
            // Validasi file gambar
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', 
        ]);

        $data = $request->all();

        // Jika ada file yang diupload, simpan ke storage/app/public/covers
        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('covers', 'public');
            $data['cover_url'] = $path; // Simpan path-nya ke kolom cover_url
        }

        Book::create($data);

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil ditambahkan!');
    }

    // Memperbarui buku
    public function update(Request $request, Book $buku)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'stock' => 'required|integer|min:0',
            // Validasi file gambar
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', 
        ]);

        $data = $request->all();

        // Cek jika admin mengganti cover dengan upload gambar baru
        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('covers', 'public');
            $data['cover_url'] = $path;
            
            // Opsional: Hapus file gambar lama dari storage agar tidak menumpuk
            if ($buku->cover_url && !str_starts_with($buku->cover_url, 'http')) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($buku->cover_url);
            }
        }

        $buku->update($data);

        return redirect()->route('admin.books.index')->with('success', 'Informasi buku berhasil diperbarui!');
    }

    // Menghapus buku
    public function destroy(Book $buku)
    {
        $buku->delete();
        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil dihapus!');
    }
}