@extends('layouts.user')

@section('title', 'Peminjaman Saya - RuangBaca')

@section('content')

<!-- Header Halaman -->
<div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div class="flex items-center gap-4">
        <div class="w-14 h-14 bg-emerald-100 text-secondary rounded-2xl flex items-center justify-center shadow-sm shrink-0">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Peminjaman Saya</h1>
            <p class="text-sm font-medium text-gray-500 mt-1">Seluruh riwayat buku yang pernah Anda pinjam di RuangBaca.</p>
        </div>
    </div>
    
    <div class="bg-white px-4 py-2.5 rounded-xl border border-gray-200 shadow-sm text-sm font-bold text-gray-600 flex items-center gap-2 self-start sm:self-auto">
        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
        Total: {{ $borrows->count() }} Transaksi
    </div>
</div>

<!-- Latar Belakang Abu-Abu agar Kartu Menonjol -->
<div class="bg-slate-100 rounded-[2rem] shadow-xl border border-gray-300 overflow-hidden relative p-6 sm:p-8">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        @forelse($borrows as $borrow)
        
        <!-- Pewarnaan Border Kiri Berdasarkan Status -->
        @php
            $borderLeftColor = 'border-l-gray-300';
            if($borrow->status == 'menunggu_persetujuan') $borderLeftColor = 'border-l-orange-400';
            elseif($borrow->status == 'dipinjam') $borderLeftColor = 'border-l-blue-500';
            elseif($borrow->status == 'menunggu_pengembalian') $borderLeftColor = 'border-l-purple-500';
            elseif($borrow->status == 'dikembalikan') $borderLeftColor = 'border-l-emerald-500';
            elseif($borrow->status == 'ditolak') $borderLeftColor = 'border-l-red-500';
        @endphp

        <!-- Kartu Riwayat -->
        <div class="flex flex-col p-6 border border-gray-200 border-l-[8px] {{ $borderLeftColor }} shadow-xl rounded-2xl hover:shadow-2xl hover:-translate-y-1.5 transition-all duration-300 bg-white relative ring-1 ring-gray-900/5">
            
            <div class="flex items-start sm:items-center gap-6">
                <!-- Cover Buku -->
                <div class="w-20 h-28 sm:w-24 sm:h-36 bg-gray-200 rounded-xl overflow-hidden shrink-0 shadow-lg border border-gray-100">
                    @if($borrow->book->cover_url)
                        <img src="{{ str_starts_with($borrow->book->cover_url, 'http') ? $borrow->book->cover_url : asset('storage/' . $borrow->book->cover_url) }}" class="w-full h-full object-cover">
                    @endif
                </div>
                
                <div class="flex-1 w-full min-w-0">
                    
                    <!-- Header Kartu: Judul dan ID -->
                    <div class="flex justify-between items-start gap-2 mb-1">
                        <h4 class="font-extrabold text-gray-900 text-xl leading-tight line-clamp-1" title="{{ $borrow->book->title }}">
                            {{ $borrow->book->title }}
                        </h4>
                        <span class="shrink-0 text-[10px] font-bold text-gray-400 bg-gray-50 px-2 py-1 rounded-md border border-gray-100">
                            #TRX-{{ str_pad($borrow->id, 3, '0', STR_PAD_LEFT) }}
                        </span>
                    </div>
                    
                    <!-- Info Penulis & Kategori -->
                    <div class="flex items-center gap-2 mb-3 text-xs">
                        <span class="font-medium text-gray-600 line-clamp-1" title="{{ $borrow->book->author }}">
                            <i class="fas fa-pen-nib mr-1 text-gray-400"></i> {{ $borrow->book->author }}
                        </span>
                        <span class="text-gray-300">•</span>
                        <span class="font-semibold text-primary bg-indigo-50 px-2 py-0.5 rounded text-[10px] shrink-0">
                            {{ $borrow->book->category->name ?? 'Umum' }}
                        </span>
                    </div>
                    
                    <!-- Format Tanggal -->
                    <div class="flex flex-wrap items-center gap-x-2 gap-y-1 mb-4 bg-gray-50/80 w-max px-3 py-1.5 rounded-lg border border-gray-100/80">
                        <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <p class="text-xs sm:text-[13px] font-bold text-gray-600">
                            <span class="hidden sm:inline">Pinjam: </span>{{ $borrow->borrow_date->format('d M') }} 
                            <span class="text-gray-400 mx-1">→</span> 
                            <span class="hidden sm:inline">Kembali: </span>{{ $borrow->return_date->format('d M Y') }}
                        </p>
                    </div>
                    
                    <!-- Area Bawah: Status & Aksi -->
                    <div class="flex flex-wrap items-center gap-3 mt-auto">
                        @if($borrow->status == 'menunggu_persetujuan')
                            <span class="inline-flex items-center gap-1.5 bg-orange-50 text-orange-600 px-3 py-1.5 rounded-md text-[11px] font-bold uppercase tracking-wider border border-orange-100">
                                <span class="w-1.5 h-1.5 rounded-full bg-orange-500 animate-pulse"></span> Menunggu ACC
                            </span>
                        @elseif($borrow->status == 'dipinjam')
                            <span class="inline-flex items-center gap-1.5 bg-blue-50 text-blue-600 px-3 py-1.5 rounded-md text-[11px] font-bold uppercase tracking-wider border border-blue-100">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span> Sedang Dipinjam
                            </span>
                            <!-- Tombol Kembalikan Buku -->
                            <button onclick="confirmReturn({{ $borrow->id }}, '{{ addslashes($borrow->book->title) }}')" class="bg-primary hover:bg-indigo-700 text-white px-4 py-1.5 rounded-lg text-xs font-bold transition-all shadow-md shadow-primary/30 transform active:scale-95 flex items-center gap-1.5 ml-auto">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path></svg>
                                Kembalikan
                            </button>
                            <form id="return-form-{{ $borrow->id }}" action="{{ route('user.books.return', $borrow->id) }}" method="POST" class="hidden">
                                @csrf @method('PUT')
                            </form>
                        @elseif($borrow->status == 'menunggu_pengembalian')
                            <span class="inline-flex items-center gap-1.5 bg-purple-50 text-purple-600 px-3 py-1.5 rounded-md text-[11px] font-bold uppercase tracking-wider border border-purple-100">
                                <span class="w-1.5 h-1.5 rounded-full bg-purple-500 animate-pulse"></span> Verifikasi Pengembalian
                            </span>
                        @elseif($borrow->status == 'dikembalikan')
                            <span class="inline-flex items-center gap-1.5 bg-emerald-50 text-secondary border border-emerald-100 px-3 py-1.5 rounded-md text-[11px] font-bold uppercase tracking-wider">
                                Selesai
                            </span>
                            @if($borrow->fine > 0)
                                <span class="inline-flex items-center gap-1.5 bg-red-50 text-red-600 border border-red-200 px-3 py-1.5 rounded-md text-[11px] font-bold uppercase tracking-wider ml-auto">
                                    Denda: Rp {{ number_format($borrow->fine, 0, ',', '.') }}
                                </span>
                            @endif
                        @elseif($borrow->status == 'ditolak')
                            <span class="inline-flex items-center gap-1.5 bg-red-50 text-red-600 border border-red-100 px-3 py-1.5 rounded-md text-[11px] font-bold uppercase tracking-wider">
                                Ditolak
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Pesan Penolakan -->
            @if($borrow->status == 'ditolak' && $borrow->reject_reason)
                <div class="mt-5 p-4 bg-red-50 rounded-xl border border-red-100 flex gap-3 items-start">
                    <svg class="w-5 h-5 text-red-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <div>
                        <p class="text-[11px] font-bold text-red-800 uppercase tracking-wider mb-1">Alasan Penolakan Petugas:</p>
                        <p class="text-sm font-semibold text-red-700 italic">"{{ $borrow->reject_reason }}"</p>
                    </div>
                </div>
            @endif

        </div>
        @empty
        <div class="col-span-full py-16 text-center bg-white shadow-sm rounded-3xl border border-gray-100">
            <div class="w-24 h-24 bg-indigo-50 text-primary rounded-full flex items-center justify-center mx-auto mb-5 shadow-inner">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
            </div>
            <p class="text-gray-900 font-extrabold text-2xl mb-2">Belum Ada Riwayat</p>
            <p class="text-gray-500 font-medium text-base mb-8 max-w-md mx-auto">Anda belum pernah melakukan peminjaman buku. Ayo mulai petualangan membaca Anda hari ini!</p>
            <a href="{{ route('user.books.index') }}" class="inline-block bg-primary text-white px-10 py-3.5 rounded-2xl font-bold shadow-xl shadow-primary/30 hover:bg-indigo-700 transition-all transform hover:-translate-y-1">Mulai Cari Buku</a>
        </div>
        @endforelse

    </div>
</div>

@endsection

@push('scripts')
<script>
    // Memungkinkan Pengguna Mengembalikan Buku Langsung dari Halaman History
    function confirmReturn(id, title) {
        Swal.fire({
            title: 'Kembalikan Buku?',
            text: "Anda akan mengembalikan buku '" + title + "'. Pastikan Anda segera menyerahkan buku fisiknya ke petugas perpustakaan.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#4F46E5',
            cancelButtonColor: '#9ca3af',
            confirmButtonText: 'Ya, Kembalikan',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            customClass: { popup: 'rounded-3xl' }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('return-form-' + id).submit();
            }
        });
    }
</script>
@endpush