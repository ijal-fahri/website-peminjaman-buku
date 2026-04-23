<?php

namespace App\Http\Controllers;

use App\Models\Borrow;
use App\Models\BookReturn;
use Illuminate\Http\Request;

class AdminBorrowController extends Controller
{
    public function index(Request $request)
    {
        // PERBAIKAN: Tambahkan 'menunggu_pengembalian' agar buku yang sedang diproses kembali tetap tampil di admin
        $query = Borrow::with(['user', 'book', 'bookReturn'])
            ->whereIn('status', ['menunggu_persetujuan', 'dipinjam', 'menunggu_pengembalian'])
            ->latest();

        // SEARCH: Cari berdasarkan nama user, email, atau judul buku
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            })
            ->orWhereHas('book', function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%");
            });
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // PER PAGE: Default 10, bisa diubah ke 5, 25, atau 50
        $per_page = $request->get('per_page', 10);
        $borrows = $query->paginate($per_page);
        return view('admin.borrows.index', compact('borrows'));
    }

    // METHOD BARU: Halaman Riwayat Pengembalian Buku (dari tabel book_returns)
    public function history(Request $request)
    {
        // PERBAIKAN: Gunakan model 'Borrow' agar status 'ditolak' juga bisa masuk ke riwayat
        $query = Borrow::with(['user', 'book', 'bookReturn'])
            ->whereIn('status', ['dikembalikan', 'terlambat', 'ditolak'])
            ->latest();

        // SEARCH: Cari berdasarkan nama user, email, atau judul buku
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            })
            ->orWhereHas('book', function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%");
            });
        }

        if ($request->has('status') && $request->status != '') {
            if ($request->status == 'dikembalikan') {
                // Tampilkan yang tepat waktu maupun terlambat sebagai kategori 'Selesai'
                $query->whereIn('status', ['dikembalikan', 'terlambat']);
            } else {
                $query->where('status', $request->status);
            }
        }

        // PER PAGE: Default 10, bisa diubah ke 5, 25, atau 50
        $per_page = $request->get('per_page', 10);
        $history = $query->paginate($per_page);
        return view('admin.borrows.history', compact('history'));
    }

    // Approve Peminjaman dan buat record pengembalian
    public function approve(Borrow $transaksi)
    {
        if ($transaksi->status == 'menunggu_persetujuan') {
            $transaksi->update(['status' => 'dipinjam']);
            
            // Buat record pengembalian otomatis
            BookReturn::create([
                'borrow_id' => $transaksi->id,
                'status' => 'menunggu_pengembalian',
                'fine' => 0,
            ]);
            
            return back()->with('success', 'Peminjaman berhasil disetujui. Buku telah diserahkan.');
        }
        return back()->withErrors(['error' => 'Aksi tidak valid.']);
    }

    public function reject(Request $request, Borrow $transaksi)
    {
        if ($transaksi->status == 'menunggu_persetujuan') {
            $request->validate([
                'reject_reason' => 'required|string|max:500'
            ], [
                'reject_reason.required' => 'Alasan penolakan wajib diisi agar siswa mengetahuinya.'
            ]);

            $transaksi->update([
                'status' => 'ditolak',
                'reject_reason' => $request->reject_reason
            ]);
            
            $transaksi->book->increment('stock');
            
            return back()->with('success', 'Permintaan peminjaman berhasil ditolak.');
        }
        return back()->withErrors(['error' => 'Aksi tidak valid.']);
    }

    // PENERIMAAN BUKU: Update status di tabel book_returns dan borrows
    public function returnBook(Request $request, Borrow $transaksi)
    {
        // PERBAIKAN: Terima status dipinjam (kembali langsung) ATAU menunggu_pengembalian (lewat klik user)
        if (!in_array($transaksi->status, ['dipinjam', 'menunggu_pengembalian'])) {
            return back()->withErrors(['error' => 'Status peminjaman tidak sesuai.']);
        }

        // Cek apakah sudah ada record pengembalian
        $bookReturn = $transaksi->bookReturn;
        if (!$bookReturn) {
            return back()->withErrors(['error' => 'Record pengembalian tidak ditemukan.']);
        }

        $request->validate([
            'actual_return_date' => 'required|date',
            'fine' => 'nullable|integer|min:0'
        ]);

        $actualReturnDate = $request->actual_return_date;
        $denda = $request->fine ?? 0;
        
        // Tentukan status: apakah terlambat atau tidak
        $statusAkhir = $actualReturnDate <= $transaksi->due_date ? 'dikembalikan' : 'terlambat';

        // 1. Update record di tabel book_returns
        $bookReturn->update([
            'actual_return_date' => $actualReturnDate,
            'status' => $statusAkhir,
            'fine' => $denda,
        ]);

        // 2. PERBAIKAN: Update juga status di tabel borrows!
        $transaksi->update([
            'status' => $statusAkhir
        ]);
        
        // Kembalikan stock buku
        $transaksi->book->increment('stock');
        
        $pesan = 'Buku berhasil diterima.';
        if ($statusAkhir == 'terlambat') {
            $pesan .= ' Pengembalian TERLAMBAT.';
        }
        if ($denda > 0) {
            $pesan .= ' Denda: Rp ' . number_format($denda, 0, ',', '.');
        }
        
        return back()->with('success', $pesan);
    }
}