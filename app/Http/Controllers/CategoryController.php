<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Menampilkan halaman daftar kategori dengan Search & Dynamic Pagination
    public function index(Request $request)
    {
        // Tambahkan withCount('books') untuk menghitung total buku per kategori secara otomatis
        $query = Category::withCount('books')->latest();

        // 1. Fitur Pencarian (Search)
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        // 2. Fitur Jumlah Data per Halaman (Default 5)
        $perPage = $request->input('per_page', 5);

        // Eksekusi query dengan pagination dinamis
        $categories = $query->paginate($perPage);

        return view('admin.categories.index', compact('categories'));
    }

    // Menyimpan kategori baru (Create)
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string',
        ]);

        Category::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    // Mengupdate kategori (Update)
    public function update(Request $request, Category $kategori)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $kategori->id,
            'description' => 'nullable|string',
        ]);

        $kategori->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    // Menghapus kategori (Delete)
    public function destroy(Category $kategori)
    {
        $kategori->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil dihapus!');
    }
}