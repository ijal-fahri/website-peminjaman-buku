@extends('layouts.user')

@section('title', 'Jelajah Buku - RuangBaca')

@section('content')

<!-- Header & Filter Section -->
<div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8 sm:p-10 mb-8 relative overflow-hidden z-10">
    <!-- Ornamen Dekorasi -->
    <div class="absolute top-0 right-0 w-64 h-64 bg-emerald-50 rounded-full blur-3xl -translate-y-1/2 translate-x-1/4 -z-10"></div>

    <div class="flex flex-col lg:flex-row justify-between items-center gap-8 relative z-20">
        <div class="w-full lg:w-1/2 text-center lg:text-left">
            <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900 tracking-tight mb-3">
                Katalog <span class="text-transparent bg-clip-text bg-gradient-to-r from-secondary to-teal-500">Buku</span>
            </h1>
            <p class="text-gray-500 font-medium text-lg">Temukan buku favoritmu dari berbagai kategori menarik.</p>
        </div>

        <div class="w-full lg:w-1/2">
            <!-- Form Pencarian & Filter -->
            <form action="{{ route('user.books.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
                
                <!-- Filter Kategori -->
                <div class="relative w-full sm:w-1/3 shrink-0">
                    <select name="category" onchange="this.form.submit()" class="appearance-none block w-full pl-4 pr-10 py-3.5 border border-gray-200 rounded-2xl text-sm font-bold text-gray-700 focus:outline-none focus:border-secondary focus:ring-4 focus:ring-secondary/10 bg-gray-50 transition-all cursor-pointer shadow-sm hover:border-gray-300">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-400">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>

                <!-- Input Pencarian -->
                <div class="relative w-full sm:w-2/3">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" class="block w-full pl-12 pr-4 py-3.5 border border-gray-200 rounded-2xl text-sm font-medium placeholder-gray-400 focus:outline-none focus:border-secondary focus:ring-4 focus:ring-secondary/10 bg-white transition-all shadow-sm hover:border-gray-300" placeholder="Cari judul atau penulis...">
                    
                    <button type="submit" class="absolute inset-y-1.5 right-1.5 bg-secondary hover:bg-emerald-600 text-white rounded-xl px-4 text-sm font-bold transition-colors">
                        Cari
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Hasil Pencarian Indicator -->
@if(request('search') || request('category'))
<div class="mb-6 flex items-center justify-between">
    <p class="text-gray-600 font-medium text-sm sm:text-base">
        Menampilkan hasil pencarian untuk: 
        @if(request('search')) <span class="font-bold text-gray-900">"{{ request('search') }}"</span> @endif
        @if(request('category')) 
            @php $catName = $categories->where('id', request('category'))->first()->name ?? ''; @endphp
            Kategori <span class="font-bold text-secondary">{{ $catName }}</span>
        @endif
    </p>
    <a href="{{ route('user.books.index') }}" class="text-sm font-bold text-red-500 hover:text-red-700 bg-red-50 px-3 py-1.5 rounded-lg transition-colors">Reset Filter</a>
</div>
@endif

<!-- Grid Buku -->
<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 sm:gap-6 mb-10">
    
    @forelse($books as $book)
    <div class="bg-white rounded-2xl p-4 shadow-sm hover:shadow-xl hover:shadow-emerald-100/50 transition-all duration-300 border border-gray-100 group flex flex-col h-full relative transform hover:-translate-y-1">
        
        <!-- Badge Status (Tersedia / Habis) -->
        @if($book->stock > 0)
            <div class="absolute top-6 right-6 bg-secondary/90 backdrop-blur-sm text-white text-[10px] font-bold px-2.5 py-1 rounded-md z-10 uppercase tracking-wider shadow-sm">
                Tersedia
            </div>
        @else
            <div class="absolute top-6 right-6 bg-red-500/90 backdrop-blur-sm text-white text-[10px] font-bold px-2.5 py-1 rounded-md z-10 uppercase tracking-wider shadow-sm">
                Habis
            </div>
        @endif

        <!-- Cover Gambar -->
        <div class="aspect-[2/3] rounded-xl overflow-hidden mb-4 relative bg-gray-100 shrink-0 shadow-inner">
            @if($book->cover_url)
                <img src="{{ str_starts_with($book->cover_url, 'http') ? $book->cover_url : asset('storage/' . $book->cover_url) }}" alt="{{ $book->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 {{ $book->stock == 0 ? 'grayscale' : '' }}">
            @else
                <div class="w-full h-full flex flex-col items-center justify-center bg-gray-50 text-gray-400 p-4 text-center">
                    <svg class="w-8 h-8 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    <span class="text-[10px] uppercase font-bold tracking-widest">No Cover</span>
                </div>
            @endif

            <!-- Overlay Hover (Detail Buku) -->
            <div class="absolute inset-0 bg-gray-900/60 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center backdrop-blur-[2px]">
                <a href="{{ route('user.books.show', $book->id) }}" class="bg-white text-gray-900 px-5 py-2.5 rounded-xl font-bold transform translate-y-4 group-hover:translate-y-0 transition-all duration-300 hover:bg-secondary hover:text-white shadow-lg">
                    Lihat Detail
                </a>
            </div>
        </div>

        <!-- Info Buku -->
        <div class="flex flex-col flex-grow">
            <!-- Nama Kategori -->
            <p class="text-[11px] font-bold text-secondary uppercase tracking-wider mb-1.5 truncate">
                {{ $book->category ? $book->category->name : 'Uncategorized' }}
            </p>
            <!-- Judul -->
            <h3 class="font-extrabold text-gray-900 text-base leading-snug mb-1 line-clamp-2 hover:text-secondary cursor-pointer transition-colors" title="{{ $book->title }}">
                {{ $book->title }}
            </h3>
            <!-- Penulis -->
            <p class="text-gray-500 text-xs font-medium line-clamp-1 mb-3">{{ $book->author }}</p>
            
            <!-- Push bottom -->
            <div class="mt-auto pt-3 border-t border-gray-100 flex items-center justify-between">
                <span class="text-xs font-semibold text-gray-400">Tahun Terbit: {{ $book->published_year ?: '-' }}</span>
                <span class="text-xs font-bold {{ $book->stock > 0 ? 'text-gray-800' : 'text-red-500' }}">Stok: {{ $book->stock }}</span>
            </div>
        </div>
    </div>
    @empty
    <div class="col-span-full bg-white rounded-3xl p-12 text-center border border-gray-100 shadow-sm">
        <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <h3 class="text-xl font-bold text-gray-800 mb-2">Buku Tidak Ditemukan</h3>
        <p class="text-gray-500 max-w-md mx-auto">Kami tidak dapat menemukan buku yang sesuai dengan kata kunci atau filter kategori Anda. Coba gunakan kata kunci lain.</p>
        @if(request('search') || request('category'))
            <a href="{{ route('user.books.index') }}" class="inline-block mt-6 bg-secondary text-white px-6 py-2.5 rounded-xl font-bold hover:bg-emerald-600 transition-colors shadow-md shadow-secondary/30">Hapus Semua Filter</a>
        @endif
    </div>
    @endforelse

</div>

<!-- Pagination Bawaan Laravel -->
@if ($books->hasPages())
    <div class="flex justify-center pb-8">
        <div class="bg-white px-4 py-3 rounded-2xl shadow-sm border border-gray-100">
            {{ $books->appends(request()->query())->links('pagination::tailwind') }}
        </div>
    </div>
@endif

@endsection