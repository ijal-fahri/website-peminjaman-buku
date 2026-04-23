<?php

namespace App\Http\Controllers;

use App\Models\BookReturn;
use App\Models\Borrow;
use Illuminate\Http\Request;

class BookReturnController extends Controller
{
    // Tampilkan daftar pengembalian yang menunggu
    public function index(Request $request)
    {
        $query = BookReturn::with(['borrow.user', 'borrow.book'])
            ->where('status', 'menunggu_pengembalian')
            ->latest();

        // SEARCH
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('borrow.user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            })
            ->orWhereHas('borrow.book', function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%");
            });
        }

        $per_page = $request->get('per_page', 10);
        $pending_returns = $query->paginate($per_page);
        
        return view('admin.returns.pending', compact('pending_returns'));
    }

    // Tampilkan riwayat pengembalian yang sudah selesai
    public function history(Request $request)
    {
        $query = BookReturn::with(['borrow.user', 'borrow.book'])
            ->whereIn('status', ['dikembalikan', 'terlambat'])
            ->latest();

        // SEARCH
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('borrow.user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            })
            ->orWhereHas('borrow.book', function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%");
            });
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $per_page = $request->get('per_page', 10);
        $return_history = $query->paginate($per_page);
        
        return view('admin.returns.history', compact('return_history'));
    }

    // Show detail pengembalian
    public function show(BookReturn $return)
    {
        $return->load(['borrow.user', 'borrow.book']);
        return view('admin.returns.show', compact('return'));
    }

    // Form untuk menerima pengembalian
    public function edit(BookReturn $return)
    {
        $return->load(['borrow.user', 'borrow.book']);
        return view('admin.returns.edit', compact('return'));
    }

    // Update pengembalian (proses penerimaan)
    public function update(Request $request, BookReturn $return)
    {
        if ($return->status != 'menunggu_pengembalian') {
            return back()->withErrors(['error' => 'Pengembalian sudah diproses sebelumnya.']);
        }

        $request->validate([
            'actual_return_date' => 'required|date',
            'fine' => 'nullable|integer|min:0'
        ]);

        $actualReturnDate = $request->actual_return_date;
        $denda = $request->fine ?? 0;
        
        // Tentukan status: apakah terlambat atau tidak
        $status = $actualReturnDate <= $return->borrow->due_date ? 'dikembalikan' : 'terlambat';

        // Update record pengembalian
        $return->update([
            'actual_return_date' => $actualReturnDate,
            'status' => $status,
            'fine' => $denda,
        ]);
        
        // Kembalikan stock buku
        $return->borrow->book->increment('stock');
        
        $pesan = 'Pengembalian buku berhasil diproses.';
        if ($status == 'terlambat') {
            $pesan .= ' Status: TERLAMBAT.';
        }
        if ($denda > 0) {
            $pesan .= ' Denda: Rp ' . number_format($denda, 0, ',', '.');
        }
        
        return redirect()->route('returns.history')->with('success', $pesan);
    }

    // Dashboard statistik pengembalian
    public function dashboard()
    {
        $total_returns = BookReturn::count();
        $returned = BookReturn::where('status', 'dikembalikan')->count();
        $late = BookReturn::where('status', 'terlambat')->count();
        $pending = BookReturn::where('status', 'menunggu_pengembalian')->count();
        
        $total_fines = BookReturn::where('status', '!=', 'menunggu_pengembalian')->sum('fine');

        return view('admin.returns.dashboard', compact(
            'total_returns', 'returned', 'late', 'pending', 'total_fines'
        ));
    }
}
