<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrow;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    // Menampilkan Dashboard Admin
    public function admin()
    {
        $totalBooks = Book::count();
        $totalUsers = User::where('role', 'user')->count();
        $booksOnLoan = Borrow::whereIn('status', ['dipinjam', 'terlambat'])->count();
        $overdueCount = Borrow::where('status', 'terlambat')->count();
        $recentBorrows = Borrow::with(['user', 'book'])->latest()->take(3)->get();
        
        return view('admin.dashboard', compact('totalBooks', 'totalUsers', 'booksOnLoan', 'overdueCount', 'recentBorrows'));
    }

    // Menampilkan Dashboard User (Member)
    public function user()
    {
        $borrows = Borrow::with('book')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();
        
        $activeCount = $borrows->whereIn('status', ['dipinjam', 'menunggu_pengembalian'])->count();
        $doneCount = $borrows->where('status', 'dikembalikan')->count();
        
        // Hitung Total Denda Siswa
        $totalFine = $borrows->sum('fine');

        return view('user.dashboard', compact('borrows', 'activeCount', 'doneCount', 'totalFine'));
    }
}