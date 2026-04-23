<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    // Menampilkan form edit profil (Admin)
    public function edit()
    {
        $user = Auth::user();
        return view('admin.profile.edit', compact('user'));
    }

    // Menampilkan halaman profil khusus user (Member)
    public function userEdit()
    {
        return view('user.profile');
    }

    // Menyimpan perubahan profil dan password (Digunakan oleh Admin & User)
    public function update(Request $request)
    {
        $user = Auth::user();

        // Validasi input
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            // Validasi Avatar (harus gambar, maksimal 2MB)
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'], 
        ], [
            'email.unique' => 'Email ini sudah digunakan oleh pengguna lain.',
            'password.confirmed' => 'Konfirmasi kata sandi baru tidak cocok.',
            'password.min' => 'Kata sandi baru minimal harus 8 karakter.',
            'avatar.image' => 'File harus berupa gambar.',
            'avatar.max' => 'Ukuran foto maksimal adalah 2MB.'
        ]);

        // Update nama dan email
        $user->name = $request->name;
        $user->email = $request->email;

        // Jika user mengisi form password, maka ubah passwordnya
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Proses unggah Foto Profil (Avatar)
        if ($request->hasFile('avatar')) {
            // Hapus foto lama dari storage jika ada
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            
            // Simpan foto baru ke folder storage/app/public/avatars
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path; // Simpan alamat file ke database
        }

        // Simpan ke database
        $user->save();

        return back()->with('success', 'Informasi profil Anda berhasil diperbarui!');
    }
}