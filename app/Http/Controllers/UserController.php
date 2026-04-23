<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Menampilkan daftar pengguna
    public function index(Request $request)
    {
        $query = User::latest();

        // Fitur Pencarian (Berdasarkan nama atau email) dikelompokkan
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Fitur Filter Role (Admin / User)
        if ($request->has('role') && $request->role != '') {
            $query->where('role', $request->role);
        }

        // Pagination Dinamis
        $perPage = $request->input('per_page', 5);
        $users = $query->paginate($perPage);

        return view('admin.users.index', compact('users'));
    }

    // Tampilkan form tambah pengguna
    public function create()
    {
        return view('admin.users.create');
    }

    // Simpan pengguna baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'min:8', 'confirmed'],
            'role' => ['required', 'in:admin,user'],
        ], [
            'name.required' => 'Nama pengguna wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah terdaftar di sistem.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal harus 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'role.required' => 'Pilih hak akses (role) untuk pengguna.',
            'role.in' => 'Hak akses hanya boleh admin atau user.',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Pengguna baru berhasil ditambahkan ke sistem!');
    }

    // Memperbarui Role Pengguna
    public function update(Request $request, User $pengguna)
    {
        $request->validate([
            'role' => 'required|in:admin,user'
        ]);

        // Mencegah admin mengubah role-nya sendiri menjadi user biasa (mencegah terkunci dari sistem)
        if ($pengguna->id === Auth::id() && $request->role !== 'admin') {
            return back()->withErrors(['error' => 'Anda tidak dapat mengubah hak akses akun Anda sendiri.']);
        }

        $pengguna->update([
            'role' => $request->role
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Hak akses (Role) pengguna berhasil diperbarui!');
    }

    // Menghapus Pengguna
    public function destroy(User $pengguna)
    {
        // Mencegah admin menghapus dirinya sendiri
        if ($pengguna->id === Auth::id()) {
            return back()->withErrors(['error' => 'Anda tidak dapat menghapus akun Anda sendiri.']);
        }

        $pengguna->delete();
        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil dihapus dari sistem!');
    }
}