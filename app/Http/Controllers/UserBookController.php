<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\Borrow;
use App\Models\BookReturn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserBookController extends Controller
{
    // Menampilkan halaman jelajah buku
    public function index(Request $request)
    {
        $query = Book::with('category')->latest();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%");
        }

        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        $books = $query->paginate(12);
        $categories = Category::orderBy('name', 'asc')->get();

        return view('user.books.index', compact('books', 'categories'));
    }

    // Menampilkan detail satu buku
    public function show($id)
    {
        $book = Book::with('category')->findOrFail($id);
        
        // Termasuk mengecek yang sedang "menunggu_persetujuan" agar jaminan otomatis terbaca
        $activeBorrow = Borrow::where('user_id', Auth::id())
            ->whereIn('status', ['menunggu_persetujuan', 'dipinjam', 'terlambat'])
            ->first();

        return view('user.books.show', compact('book', 'activeBorrow'));
    }

    // Proses meminjam buku
    public function borrow(Request $request, $id)
    {
        // VALIDASI BARU: Cek apakah user punya denda dari book_returns
        $totalFine = BookReturn::where('status', '!=', 'menunggu_pengembalian')
            ->whereHas('borrow', function($q) {
                $q->where('user_id', Auth::id());
            })
            ->sum('fine');
        
        if ($totalFine > 0) {
            return back()->withErrors(['error' => 'Anda memiliki denda sebesar Rp ' . number_format($totalFine, 0, ',', '.') . '. Silakan bayar denda terlebih dahulu sebelum meminjam buku baru.']);
        }

        $activeBorrow = Borrow::where('user_id', Auth::id())
            ->whereIn('status', ['menunggu_persetujuan', 'dipinjam', 'terlambat'])
            ->first();

        $rules = [
            'due_date' => 'required|date|after:today|before_or_equal:+14 days',
        ];

        if (!$activeBorrow) {
            $rules['guarantee'] = 'required|string|max:255';
        }

        $request->validate($rules, [
            'due_date.required' => 'Tanggal pengembalian wajib diisi.',
            'due_date.after' => 'Tanggal kembali minimal 1 hari dari sekarang.',
            'due_date.before_or_equal' => 'Maksimal durasi peminjaman adalah 14 hari.',
            'guarantee.required' => 'Jaminan wajib diisi.'
        ]);

        $book = Book::findOrFail($id);

        if ($book->stock <= 0) {
            return back()->withErrors(['error' => 'Maaf, stok buku ini sedang kosong.']);
        }

        $alreadyBorrowedThisBook = Borrow::where('user_id', Auth::id())
            ->where('book_id', $book->id)
            ->whereIn('status', ['menunggu_persetujuan', 'dipinjam', 'terlambat'])
            ->first();

        if ($alreadyBorrowedThisBook) {
            return back()->withErrors(['error' => 'Anda sudah memiliki permintaan atau sedang meminjam buku ini.']);
        }

        $totalBorrowed = Borrow::where('user_id', Auth::id())
            ->whereIn('status', ['menunggu_persetujuan', 'dipinjam', 'terlambat'])
            ->count();

        if ($totalBorrowed >= 3) {
            return back()->withErrors(['error' => 'Anda telah mencapai batas maksimal peminjaman (3 buku sekaligus).']);
        }

        $guaranteeToSave = $activeBorrow ? $activeBorrow->guarantee : $request->guarantee;

        Borrow::create([
            'user_id' => Auth::id(),
            'book_id' => $book->id,
            'borrow_date' => now(),
            'due_date' => $request->due_date,
            'guarantee' => $guaranteeToSave,
            'status' => 'menunggu_persetujuan', // BUKU BERSTATUS PENDING
        ]);

        // Booking Stok
        $book->decrement('stock');

        // Pesan Sukses disesuaikan dengan alur baru
        $pesanSukses = 'Permintaan peminjaman buku "'. $book->title .'" berhasil dikirim! ';
        if (!$activeBorrow) {
            $pesanSukses .= 'Silakan bawa ' . $guaranteeToSave . ' Anda dan temui petugas di Perpustakaan.';
        } else {
            $pesanSukses .= 'Silakan temui petugas di Perpustakaan untuk mengambil buku (Jaminan Anda sudah ada di sana).';
        }

        return redirect()->route('user.dashboard')->with('success', $pesanSukses);
    }

    // FUNGSI BARU: Halaman Riwayat Keseluruhan Peminjaman Saya
    public function history()
    {
        $borrows = Borrow::with('book')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();
            
        return view('user.history', compact('borrows'));
    }

    // Pengajuan Pengembalian Buku oleh Siswa
    public function returnBook($id)
    {
        $borrow = Borrow::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        // Hanya buku yang berstatus dipinjam atau terlambat yang bisa dikembalikan
        if (in_array($borrow->status, ['dipinjam', 'terlambat'])) {
            $borrow->update(['status' => 'menunggu_pengembalian']);
            return back()->with('success', 'Berhasil! Silakan serahkan buku fisik ke petugas perpustakaan.');
        }

        return back()->withErrors(['error' => 'Buku tidak dapat dikembalikan pada status ini.']);
    }

    // Pembayaran Denda
    public function payFine(Request $request)
    {
        $request->validate([
            'amount' => 'required|integer|min:1'
        ], [
            'amount.required' => 'Nominal pembayaran wajib diisi.',
            'amount.min' => 'Nominal pembayaran harus lebih dari 0.'
        ]);

        // Hitung total denda dari book_returns yang belum dibayar
        $totalFine = BookReturn::where('status', '!=', 'menunggu_pengembalian')
            ->where('fine', '>', 0)
            ->whereHas('borrow', function($q) {
                $q->where('user_id', Auth::id());
            })
            ->sum('fine');

        if ($totalFine <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki denda.'
            ], 400);
        }

        if ($request->amount > $totalFine) {
            return response()->json([
                'success' => false,
                'message' => 'Nominal pembayaran tidak boleh melebihi total denda Rp ' . number_format($totalFine, 0, ',', '.')
            ], 422);
        }

        // Kurangi denda dari book_returns (dari yang paling tua/pertama kali)
        $remaining = $request->amount;
        $returns = BookReturn::where('fine', '>', 0)
            ->whereHas('borrow', function($q) {
                $q->where('user_id', Auth::id());
            })
            ->orderBy('updated_at', 'asc')
            ->get();

        foreach ($returns as $bookReturn) {
            if ($remaining <= 0) break;

            if ($bookReturn->fine >= $remaining) {
                $bookReturn->update(['fine' => $bookReturn->fine - $remaining]);
                $remaining = 0;
            } else {
                $remaining -= $bookReturn->fine;
                $bookReturn->update(['fine' => 0]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Pembayaran denda sebesar Rp ' . number_format($request->amount, 0, ',', '.') . ' berhasil diproses!'
        ]);
    }
}