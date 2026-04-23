@extends('layouts.user')

@section('title', $book->title . ' - RuangBaca')

@section('content')

@if ($errors->any())
    <div class="bg-red-50 border border-red-200 p-4 mb-6 rounded-xl shadow-sm flex items-start gap-3">
        <svg class="h-6 w-6 text-red-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
        <div>
            <h4 class="text-red-800 font-bold mb-1">Gagal Meminjam Buku</h4>
            <ul class="text-red-700 font-medium text-sm list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

<div class="mb-8">
    <a href="{{ route('user.books.index') }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-secondary font-medium transition-colors bg-white px-4 py-2 rounded-xl border border-gray-200 shadow-sm hover:border-secondary/30">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Kembali ke Katalog
    </a>
</div>

<div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden relative">
    <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-gradient-to-bl from-emerald-50/50 to-teal-50/50 rounded-full blur-3xl -translate-y-1/2 translate-x-1/3 pointer-events-none"></div>

    <div class="p-6 md:p-10 lg:p-12 relative z-10 grid grid-cols-1 lg:grid-cols-12 gap-10">
        <div class="lg:col-span-4 flex flex-col items-center">
            <div class="w-full max-w-[280px] lg:max-w-full aspect-[2/3] rounded-2xl overflow-hidden shadow-2xl shadow-gray-200/50 border-4 border-white shrink-0 bg-gray-100 relative">
                
                @if($book->stock > 0)
                    <div class="absolute top-4 right-4 bg-secondary/90 backdrop-blur-sm text-white text-xs font-bold px-3 py-1.5 rounded-lg z-10 uppercase tracking-wider shadow-sm">
                        Tersedia
                    </div>
                @else
                    <div class="absolute top-4 right-4 bg-red-500/90 backdrop-blur-sm text-white text-xs font-bold px-3 py-1.5 rounded-lg z-10 uppercase tracking-wider shadow-sm">
                        Habis
                    </div>
                @endif

                @if($book->cover_url)
                    <img src="{{ str_starts_with($book->cover_url, 'http') ? $book->cover_url : asset('storage/' . $book->cover_url) }}" alt="{{ $book->title }}" class="w-full h-full object-cover {{ $book->stock == 0 ? 'grayscale' : '' }}">
                @else
                    <div class="w-full h-full flex flex-col items-center justify-center bg-gray-50 text-gray-400 p-6 text-center">
                        <svg class="w-12 h-12 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        <span class="text-xs uppercase font-bold tracking-widest">Tidak Ada Cover</span>
                    </div>
                @endif
            </div>

            <div class="w-full max-w-[280px] lg:max-w-full mt-6 space-y-3">
                @if($book->stock > 0)
                    <button onclick="openBorrowModal()" class="w-full bg-secondary text-white py-3.5 rounded-xl font-extrabold text-base shadow-lg shadow-secondary/30 hover:bg-emerald-600 transition-colors transform active:scale-95 flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        Pinjam Buku Ini
                    </button>
                @else
                    <button disabled class="w-full bg-gray-100 text-gray-400 py-3.5 rounded-xl font-extrabold text-base border border-gray-200 cursor-not-allowed flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Stok Habis
                    </button>
                @endif
                
                <button class="w-full bg-white text-gray-700 py-3.5 rounded-xl font-bold text-base border-2 border-gray-200 hover:border-gray-300 hover:bg-gray-50 transition-colors flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                    Simpan ke Favorit
                </button>
            </div>
        </div>

        <div class="lg:col-span-8 flex flex-col">
            <div class="mb-6">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-indigo-50 text-primary text-xs font-bold uppercase tracking-wider mb-4 border border-indigo-100">
                    <span class="w-1.5 h-1.5 rounded-full bg-primary"></span>
                    {{ $book->category ? $book->category->name : 'Uncategorized' }}
                </span>
                
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-gray-900 tracking-tight leading-tight mb-2">
                    {{ $book->title }}
                </h1>
                
                <p class="text-lg sm:text-xl text-gray-500 font-medium">
                    Karya <span class="text-gray-800 font-bold border-b-2 border-secondary/30 pb-0.5">{{ $book->author }}</span>
                </p>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 py-6 border-y border-gray-100 mb-8 bg-gray-50/50 rounded-2xl p-6">
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Penerbit</p>
                    <p class="font-bold text-gray-800 line-clamp-1" title="{{ $book->publisher ?: '-' }}">{{ $book->publisher ?: 'Tidak diketahui' }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Thn. Terbit</p>
                    <p class="font-bold text-gray-800">{{ $book->published_year ?: '-' }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Sisa Stok</p>
                    <p class="font-bold {{ $book->stock > 0 ? 'text-secondary' : 'text-red-500' }}">{{ $book->stock }} Buku</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Kode Buku</p>
                    <p class="font-bold text-gray-800">RB-{{ str_pad($book->id, 4, '0', STR_PAD_LEFT) }}</p>
                </div>
            </div>

            <div class="flex-grow">
                <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Sinopsis Buku
                </h3>
                
                <div class="prose prose-gray max-w-none text-gray-600 leading-relaxed text-justify">
                    @if($book->description)
                        {!! nl2br(e($book->description)) !!}
                    @else
                        <p class="italic text-gray-400">Belum ada sinopsis atau deskripsi untuk buku ini.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ============================================== -->
<!-- MODAL FORMULIR PEMINJAMAN BUKU -->
<!-- ============================================== -->
<div id="borrowModal" class="fixed inset-0 z-[100] hidden">
    <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" onclick="closeBorrowModal()"></div>
    
    <div class="flex justify-center items-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
        <div class="relative bg-white rounded-[2rem] text-left shadow-2xl transform transition-all sm:max-w-lg w-full border border-gray-100 overflow-hidden">
            
            <!-- Header Modal -->
            <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                <div>
                    <h3 class="text-xl font-extrabold text-gray-900 tracking-tight">Formulir Peminjaman</h3>
                    <p class="text-xs text-gray-500 font-medium mt-1">Atur jadwal pengembalian buku Anda.</p>
                </div>
                <button onclick="closeBorrowModal()" class="text-gray-400 hover:text-gray-500 hover:bg-gray-200 p-2 rounded-full transition-colors focus:outline-none">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
            
            <!-- Body Modal -->
            <div class="p-6 sm:p-8">
                <!-- Info Buku -->
                <div class="flex items-center gap-4 p-4 bg-emerald-50 rounded-2xl border border-emerald-100 mb-6">
                    <div class="w-12 h-16 bg-gray-200 rounded shrink-0 overflow-hidden shadow-sm">
                        @if($book->cover_url)
                            <img src="{{ str_starts_with($book->cover_url, 'http') ? $book->cover_url : asset('storage/' . $book->cover_url) }}" class="w-full h-full object-cover">
                        @endif
                    </div>
                    <div>
                        <p class="text-xs font-bold text-secondary uppercase">Buku Terpilih:</p>
                        <h4 class="font-bold text-gray-900 line-clamp-1">{{ $book->title }}</h4>
                        <p class="text-xs text-gray-600">{{ $book->author }}</p>
                    </div>
                </div>

                <form id="borrow-form" action="{{ route('user.books.borrow', $book->id) }}" method="POST" class="space-y-5">
                    @csrf
                    
                    <!-- Pilihan Tanggal -->
                    <div>
                        <label for="due_date" class="block text-sm font-bold text-gray-700 mb-2">Tanggal Pengembalian <span class="text-red-500">*</span></label>
                        <input type="date" name="due_date" id="due_date" required class="block w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-secondary focus:border-secondary transition-colors bg-gray-50 focus:bg-white font-medium text-gray-700 cursor-pointer">
                        <p class="text-xs text-gray-400 mt-1.5 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Maksimal durasi peminjaman adalah 14 Hari.
                        </p>
                    </div>

                    <!-- KONDISI JAMINAN PINTAR -->
                    @if($activeBorrow)
                        <!-- Jika punya peminjaman aktif, tampilkan notifikasi ini dan sembunyikan input jaminan -->
                        <div class="bg-blue-50 border border-blue-200 p-4 rounded-xl mt-4">
                            <div class="flex gap-3">
                                <svg class="w-6 h-6 text-blue-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <div>
                                    <p class="text-sm text-blue-800 font-bold mb-0.5">Jaminan Otomatis</p>
                                    <p class="text-xs text-blue-700">Kami mendeteksi Anda memiliki peminjaman aktif. Sistem akan menggunakan jaminan <span class="font-bold uppercase">{{ $activeBorrow->guarantee }}</span> Anda yang sudah berada di petugas. Anda tidak perlu membawa jaminan baru.</p>
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Jika TIDAK punya peminjaman aktif, tampilkan form input jaminan -->
                        <div>
                            <label for="guarantee" class="block text-sm font-bold text-gray-700 mb-2">Pilih Jaminan yang Diserahkan <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <select name="guarantee" id="guarantee" required class="appearance-none block w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-secondary focus:border-secondary transition-colors bg-gray-50 focus:bg-white font-medium text-gray-700 cursor-pointer">
                                    <option value="" disabled selected>Pilih jenis jaminan...</option>
                                    <option value="Kartu Pelajar">Kartu Pelajar</option>
                                    <option value="Kartu Perpustakaan">Kartu Perpustakaan</option>
                                    <option value="Kartu OSIS">Kartu OSIS</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-400">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                            <p class="text-xs text-orange-500 mt-1.5 flex items-center gap-1 font-medium">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                Harap serahkan jaminan ini ke Petugas Perpustakaan Sekolah saat mengambil buku.
                            </p>
                        </div>
                    @endif
                    
                    <!-- Tombol Form -->
                    <div class="mt-8 pt-6 border-t border-gray-100 flex flex-col-reverse sm:flex-row justify-end gap-3">
                        <button type="button" onclick="closeBorrowModal()" class="w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-6 py-3.5 bg-white text-sm font-bold text-gray-700 hover:bg-gray-50 focus:outline-none transition-all sm:w-auto">
                            Batal
                        </button>
                        <button type="submit" class="w-full inline-flex justify-center items-center gap-2 rounded-xl border border-transparent shadow-lg shadow-secondary/30 px-6 py-3.5 bg-secondary text-sm font-bold text-white hover:bg-emerald-600 focus:outline-none transition-all sm:w-auto transform active:scale-95">
                            Konfirmasi & Pinjam
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function openBorrowModal() {
        const modal = document.getElementById('borrowModal');
        modal.classList.remove('hidden');
        
        // Membatasi input tanggal (Minimal besok, Maksimal 14 hari dari sekarang)
        const dateInput = document.getElementById('due_date');
        
        const today = new Date();
        
        // Min Date (Besok)
        const minDate = new Date(today);
        minDate.setDate(minDate.getDate() + 1);
        const minStr = minDate.toISOString().split('T')[0];
        
        // Max Date (14 Hari)
        const maxDate = new Date(today);
        maxDate.setDate(maxDate.getDate() + 14);
        const maxStr = maxDate.toISOString().split('T')[0];
        
        dateInput.setAttribute('min', minStr);
        dateInput.setAttribute('max', maxStr);
    }

    function closeBorrowModal() {
        const modal = document.getElementById('borrowModal');
        modal.classList.add('hidden');
    }
</script>
@endpush