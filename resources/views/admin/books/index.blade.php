@extends('layouts.admin')

@section('title', 'Kelola Buku - RuangBaca')

@section('header_title')
    <div class="flex items-center gap-3">
        <div class="w-1.5 h-6 bg-gradient-to-b from-primary to-indigo-400 rounded-full shadow-sm"></div>
        <span
            class="text-xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-gray-800 to-gray-600 tracking-tight">
            Manajemen Buku
        </span>
        <span
            class="hidden sm:inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider bg-indigo-50 text-primary border border-indigo-100 shadow-sm ml-1">
            Katalog
        </span>
    </div>
@endsection

@section('content')

    <!-- Notifikasi Error Validasi -->
    @if ($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-r-xl shadow-sm">
            <div class="flex">
                <svg class="h-5 w-5 text-red-500 mr-2 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <ul class="text-red-700 font-medium text-sm list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden mb-8">

        <!-- Top Action Bar -->
        <div
            class="p-6 sm:p-8 border-b border-gray-100 flex flex-col xl:flex-row justify-between items-start xl:items-center gap-6">
            <div class="flex items-center gap-4">
                <div
                    class="p-3.5 bg-gradient-to-br from-primary to-indigo-600 rounded-2xl shadow-lg shadow-indigo-200/50 flex-shrink-0 relative overflow-hidden group cursor-default">
                    <div
                        class="absolute inset-0 bg-white/20 blur-md transform -translate-x-full group-hover:translate-x-full transition-transform duration-1000 ease-in-out">
                    </div>
                    <svg class="w-6 h-6 text-white relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                        </path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-2xl font-extrabold text-gray-800 tracking-tight mb-1">Daftar Buku</h2>
                    <p class="text-sm text-gray-500 font-medium">Kelola dan pantau seluruh koleksi perpustakaan Anda.</p>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row w-full xl:w-auto gap-3">
                <!-- Form Gabungan: Dropdown Per Page & Search -->
                <form action="{{ route('admin.books.index') }}" method="GET"
                    class="flex flex-col sm:flex-row w-full xl:w-auto gap-3">
                    <div class="relative w-full sm:w-28 shrink-0">
                        <select name="per_page" onchange="this.form.submit()"
                            class="appearance-none block w-full pl-4 pr-10 py-3 border border-gray-200 rounded-xl text-sm font-bold text-gray-700 focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 bg-gray-50/50 transition-all hover:bg-gray-50 cursor-pointer">
                            <option value="5" {{ request('per_page') == 5 ? 'selected' : '' }}>5 Data</option>
                            <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10 Data</option>
                            <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 Data</option>
                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 Data</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-400">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                                </path>
                            </svg>
                        </div>
                    </div>

                    <div class="relative w-full sm:w-64">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}"
                            class="block w-full pl-11 pr-4 py-3 border border-gray-200 rounded-xl text-sm font-medium placeholder-gray-400 focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 bg-gray-50/50 transition-all hover:bg-gray-50"
                            placeholder="Cari judul, penulis...">
                    </div>
                </form>

                <button type="button" onclick="openModal('addBookModal')"
                    class="bg-primary text-white px-6 py-3 rounded-xl font-bold hover:bg-indigo-700 transition-all shadow-lg shadow-primary/30 flex items-center justify-center gap-2 transform hover:-translate-y-0.5 w-full sm:w-auto shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah
                </button>
            </div>
        </div>

        <!-- Data Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600">
                <thead class="text-xs text-gray-500 uppercase bg-gray-50/50">
                    <tr>
                        <th scope="col" class="px-6 py-5 font-bold tracking-wider rounded-tl-lg text-center w-16">No</th>
                        <th scope="col" class="px-6 py-5 font-bold tracking-wider">Info Buku</th>
                        <th scope="col" class="px-6 py-5 font-bold tracking-wider">Kategori</th>
                        <th scope="col" class="px-6 py-5 font-bold tracking-wider text-center">Stok</th>
                        <th scope="col" class="px-6 py-5 font-bold tracking-wider text-center">Status</th>
                        <th scope="col" class="px-6 py-5 font-bold tracking-wider text-right rounded-tr-lg">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">

                    @forelse ($books as $book)
                        <tr class="bg-white hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 text-center font-bold text-gray-800">
                                {{ $books->firstItem() + $loop->index }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <!-- Thumbnail -->
                                    <div class="w-12 h-16 bg-gray-200 rounded-md overflow-hidden shrink-0 shadow-sm">
                                        @if ($book->cover_url)
                                            <img src="{{ str_starts_with($book->cover_url, 'http') ? $book->cover_url : asset('storage/' . $book->cover_url) }}"
                                                alt="Cover" class="w-full h-full object-cover">
                                        @else
                                            <div
                                                class="w-full h-full flex items-center justify-center bg-indigo-50 text-indigo-300">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                    </path>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-gray-900 text-base mb-0.5 line-clamp-1">
                                            {{ $book->title }}</h4>
                                        <p class="text-xs text-gray-500 font-medium line-clamp-1">{{ $book->author }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-600">
                                <!-- Cek Relasi Kategori -->
                                {{ $book->category ? $book->category->name : '-' }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span
                                    class="font-bold {{ $book->stock > 0 ? 'text-gray-800' : 'text-red-500' }} text-base">{{ $book->stock }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if ($book->stock > 0)
                                    <span
                                        class="inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-600 border border-emerald-200 px-3 py-1 rounded-md text-[10px] font-bold uppercase tracking-wide">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Tersedia
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center gap-1.5 bg-red-50 text-red-600 border border-red-200 px-3 py-1 rounded-md text-[10px] font-bold uppercase tracking-wide">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Habis
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <button
                                        onclick="editBook({{ $book->id }}, '{{ addslashes($book->title) }}', '{{ addslashes($book->author) }}', '{{ addslashes($book->publisher) }}', '{{ $book->published_year }}', {{ $book->category_id }}, {{ $book->stock }}, '{{ addslashes($book->description) }}', '{{ addslashes($book->cover_url) }}')"
                                        class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                                        title="Edit">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                            </path>
                                        </svg>
                                    </button>
                                    <button onclick="confirmDelete({{ $book->id }})"
                                        class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                                        title="Hapus">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                            </path>
                                        </svg>
                                    </button>

                                    <form id="delete-form-book-{{ $book->id }}"
                                        action="{{ route('admin.books.destroy', $book->id) }}" method="POST"
                                        class="hidden">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center text-gray-400">
                                    <svg class="w-12 h-12 mb-3 text-gray-300" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                        </path>
                                    </svg>
                                    <span class="text-lg font-medium text-gray-500">Belum ada koleksi buku</span>
                                    <p class="text-sm mt-1">Silakan tambahkan buku baru atau ubah filter pencarian.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>

        <!-- Pagination Bawaan Laravel -->
        <div
            class="px-6 py-4 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-4 bg-gray-50/30">
            <span class="text-sm text-gray-500 text-center sm:text-left">
                Menampilkan <span
                    class="font-bold text-gray-800">{{ $books->count() > 0 ? $books->firstItem() : 0 }}</span>
                sampai <span class="font-bold text-gray-800">{{ $books->count() > 0 ? $books->lastItem() : 0 }}</span>
                dari <span class="font-bold text-gray-800">{{ $books->total() }}</span> buku
            </span>

            @if ($books->hasPages())
                <div class="flex gap-1">
                    @if ($books->onFirstPage())
                        <button
                            class="px-3 py-1.5 border border-gray-200 rounded-lg text-sm text-gray-400 bg-gray-50 cursor-not-allowed"
                            disabled>Sebelumnya</button>
                    @else
                        <a href="{{ $books->appends(request()->query())->previousPageUrl() }}"
                            class="px-3 py-1.5 border border-gray-200 rounded-lg text-sm text-gray-600 bg-white hover:bg-gray-50 transition-colors">Sebelumnya</a>
                    @endif

                    @foreach ($books->appends(request()->query())->getUrlRange(max(1, $books->currentPage() - 1), min($books->lastPage(), $books->currentPage() + 1)) as $page => $url)
                        @if ($page == $books->currentPage())
                            <button
                                class="px-3 py-1.5 border border-primary bg-primary text-white rounded-lg text-sm font-medium shadow-sm">{{ $page }}</button>
                        @else
                            <a href="{{ $url }}"
                                class="px-3 py-1.5 border border-gray-200 rounded-lg text-sm text-gray-600 bg-white hover:bg-gray-50 transition-colors">{{ $page }}</a>
                        @endif
                    @endforeach

                    @if ($books->hasMorePages())
                        <a href="{{ $books->appends(request()->query())->nextPageUrl() }}"
                            class="px-3 py-1.5 border border-gray-200 rounded-lg text-sm text-gray-600 bg-white hover:bg-gray-50 transition-colors">Selanjutnya</a>
                    @else
                        <button
                            class="px-3 py-1.5 border border-gray-200 rounded-lg text-sm text-gray-400 bg-gray-50 cursor-not-allowed"
                            disabled>Selanjutnya</button>
                    @endif
                </div>
            @endif
        </div>

    </div>

    <!-- ============================================== -->
    <!-- MODAL TAMBAH BUKU -->
    <!-- ============================================== -->
    <div id="addBookModal" class="fixed inset-0 z-[100] hidden">
        <div class="fixed inset-0 bg-gray-900/40 backdrop-blur-sm transition-opacity"
            onclick="closeModal('addBookModal')"></div>
        <div class="flex justify-center min-h-screen px-4 pt-10 pb-20 text-center sm:p-0">
            <!-- Tambahan relative, top-10 dll agar modal panjang bisa di scroll -->
            <div
                class="relative bg-white rounded-3xl text-left shadow-2xl transform transition-all sm:my-8 sm:max-w-2xl w-full border border-gray-100 flex flex-col max-h-[85vh]">
                <div
                    class="px-6 pt-6 pb-4 sm:p-8 sm:pb-4 border-b border-gray-100 flex justify-between items-center shrink-0">
                    <h3 class="text-2xl font-extrabold text-gray-900 tracking-tight">Tambah Buku Baru</h3>
                    <button onclick="closeModal('addBookModal')"
                        class="text-gray-400 hover:text-gray-500 hover:bg-gray-100 p-2 rounded-full transition-colors focus:outline-none">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="p-6 sm:p-8 overflow-y-auto">
                    <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data"
                        class="space-y-5">
                        @csrf

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div class="sm:col-span-2">
                                <label class="block text-sm font-bold text-gray-700 mb-2">Judul Buku <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="title" required
                                    class="block w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-primary focus:border-primary transition-colors bg-gray-50 focus:bg-white sm:text-sm">
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Penulis <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="author" required
                                    class="block w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-primary focus:border-primary transition-colors bg-gray-50 focus:bg-white sm:text-sm">
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Kategori <span
                                        class="text-red-500">*</span></label>
                                <div class="relative">
                                    <select name="category_id" required
                                        class="appearance-none block w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-primary focus:border-primary transition-colors bg-gray-50 focus:bg-white sm:text-sm cursor-pointer">
                                        <option value="" disabled selected>Pilih Kategori...</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    <div
                                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-400">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Penerbit</label>
                                <input type="text" name="publisher"
                                    class="block w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-primary focus:border-primary transition-colors bg-gray-50 focus:bg-white sm:text-sm">
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Tahun Terbit</label>
                                    <input type="number" name="published_year" placeholder="YYYY"
                                        class="block w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-primary focus:border-primary transition-colors bg-gray-50 focus:bg-white sm:text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Stok <span
                                            class="text-red-500">*</span></label>
                                    <input type="number" name="stock" required min="0" value="0"
                                        class="block w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-primary focus:border-primary transition-colors bg-gray-50 focus:bg-white sm:text-sm">
                                </div>
                            </div>

                            <div class="sm:col-span-2">
                                <label class="block text-sm font-bold text-gray-700 mb-2">Upload Gambar Cover
                                    (Opsional)</label>
                                <input type="file" name="cover_image" accept="image/*"
                                    class="block w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-primary focus:border-primary transition-colors bg-gray-50 focus:bg-white sm:text-sm file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-primary hover:file:bg-indigo-100 cursor-pointer">
                                <p class="text-xs text-gray-400 mt-1">Format yang didukung: JPG, JPEG, PNG. Maksimal ukuran
                                    2MB.</p>
                            </div>

                            <div class="sm:col-span-2">
                                <label class="block text-sm font-bold text-gray-700 mb-2">Deskripsi Singkat</label>
                                <textarea name="description" rows="3"
                                    class="block w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-primary focus:border-primary transition-colors bg-gray-50 focus:bg-white sm:text-sm resize-none"></textarea>
                            </div>
                        </div>

                        <div class="mt-8 pt-6 border-t border-gray-100 sm:flex sm:flex-row-reverse gap-3">
                            <button type="submit"
                                class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-md px-6 py-3 bg-primary text-base font-bold text-white hover:bg-indigo-700 focus:outline-none transition-all sm:w-auto sm:text-sm transform active:scale-95">
                                Simpan Buku
                            </button>
                            <button type="button" onclick="closeModal('addBookModal')"
                                class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-6 py-3 bg-white text-base font-bold text-gray-700 hover:bg-gray-50 focus:outline-none transition-all sm:mt-0 sm:w-auto sm:text-sm">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- ============================================== -->
    <!-- MODAL EDIT BUKU -->
    <!-- ============================================== -->
    <div id="editBookModal" class="fixed inset-0 z-[100] hidden">
        <div class="fixed inset-0 bg-gray-900/40 backdrop-blur-sm transition-opacity"
            onclick="closeModal('editBookModal')"></div>
        <div class="flex justify-center min-h-screen px-4 pt-10 pb-20 text-center sm:p-0">
            <div
                class="relative bg-white rounded-3xl text-left shadow-2xl transform transition-all sm:my-8 sm:max-w-2xl w-full border border-gray-100 flex flex-col max-h-[85vh]">
                <div
                    class="px-6 pt-6 pb-4 sm:p-8 sm:pb-4 border-b border-gray-100 flex justify-between items-center shrink-0">
                    <h3 class="text-2xl font-extrabold text-gray-900 tracking-tight">Edit Buku</h3>
                    <button onclick="closeModal('editBookModal')"
                        class="text-gray-400 hover:text-gray-500 hover:bg-gray-100 p-2 rounded-full transition-colors focus:outline-none">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="p-6 sm:p-8 overflow-y-auto">
                    <form id="editBookForm" method="POST" enctype="multipart/form-data" class="space-y-5">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div class="sm:col-span-2">
                                <label class="block text-sm font-bold text-gray-700 mb-2">Judul Buku <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="title" id="edit_title" required
                                    class="block w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-primary focus:border-primary transition-colors bg-gray-50 focus:bg-white sm:text-sm">
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Penulis <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="author" id="edit_author" required
                                    class="block w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-primary focus:border-primary transition-colors bg-gray-50 focus:bg-white sm:text-sm">
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Kategori <span
                                        class="text-red-500">*</span></label>
                                <div class="relative">
                                    <select name="category_id" id="edit_category_id" required
                                        class="appearance-none block w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-primary focus:border-primary transition-colors bg-gray-50 focus:bg-white sm:text-sm cursor-pointer">
                                        <option value="" disabled>Pilih Kategori...</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    <div
                                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-400">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Penerbit</label>
                                <input type="text" name="publisher" id="edit_publisher"
                                    class="block w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-primary focus:border-primary transition-colors bg-gray-50 focus:bg-white sm:text-sm">
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Tahun Terbit</label>
                                    <input type="number" name="published_year" id="edit_year" placeholder="YYYY"
                                        class="block w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-primary focus:border-primary transition-colors bg-gray-50 focus:bg-white sm:text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Stok <span
                                            class="text-red-500">*</span></label>
                                    <input type="number" name="stock" id="edit_stock" required min="0"
                                        class="block w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-primary focus:border-primary transition-colors bg-gray-50 focus:bg-white sm:text-sm">
                                </div>
                            </div>

                            <div class="sm:col-span-2">
                                <label class="block text-sm font-bold text-gray-700 mb-2">Upload Gambar Cover Baru
                                    (Opsional)</label>
                                <div class="flex items-center gap-4">
                                    <div id="current_cover_preview"
                                        class="w-12 h-16 bg-gray-100 rounded-md overflow-hidden shrink-0 border border-gray-200 hidden">
                                        <img id="current_cover_img" src="" class="w-full h-full object-cover"
                                            alt="Current Cover">
                                    </div>
                                    <div class="w-full">
                                        <input type="file" name="cover_image" accept="image/*"
                                            class="block w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-primary focus:border-primary transition-colors bg-gray-50 focus:bg-white sm:text-sm file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-primary hover:file:bg-indigo-100 cursor-pointer">
                                        <p class="text-xs text-gray-400 mt-1">Abaikan jika tidak ingin mengganti cover.
                                            Format: JPG, JPEG, PNG.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="sm:col-span-2">
                                <label class="block text-sm font-bold text-gray-700 mb-2">Deskripsi</label>
                                <textarea name="description" id="edit_description" rows="3"
                                    class="block w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-primary focus:border-primary transition-colors bg-gray-50 focus:bg-white sm:text-sm resize-none"></textarea>
                            </div>
                        </div>

                        <div class="mt-8 pt-6 border-t border-gray-100 sm:flex sm:flex-row-reverse gap-3">
                            <button type="submit"
                                class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-md px-6 py-3 bg-primary text-base font-bold text-white hover:bg-indigo-700 focus:outline-none transition-all sm:w-auto sm:text-sm transform active:scale-95">
                                Simpan Perubahan
                            </button>
                            <button type="button" onclick="closeModal('editBookModal')"
                                class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-6 py-3 bg-white text-base font-bold text-gray-700 hover:bg-gray-50 focus:outline-none transition-all sm:mt-0 sm:w-auto sm:text-sm">
                                Batal
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
        function openModal(modalId) {
            document.getElementById(modalId).classList.remove('hidden');
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }

        // MENGISI DATA KE DALAM FORM MODAL EDIT BUKU
        function editBook(id, title, author, publisher, year, category_id, stock, description, cover_url) {
            document.getElementById('edit_title').value = title;
            document.getElementById('edit_author').value = author;
            document.getElementById('edit_publisher').value = publisher;
            document.getElementById('edit_year').value = year;
            document.getElementById('edit_category_id').value = category_id;
            document.getElementById('edit_stock').value = stock;
            document.getElementById('edit_description').value = description;

            // Memunculkan preview gambar jika sudah ada cover sebelumnya
            const previewDiv = document.getElementById('current_cover_preview');
            const previewImg = document.getElementById('current_cover_img');

            if (cover_url) {
                // Mengecek jika URL dimulai dengan http (link luar) atau file lokal di storage
                previewImg.src = cover_url.startsWith('http') ? cover_url : '/storage/' + cover_url;
                previewDiv.classList.remove('hidden');
            } else {
                previewImg.src = '';
                previewDiv.classList.add('hidden');
            }

            document.getElementById('editBookForm').action = '/admin/buku/' + id;

            openModal('editBookModal');
        }

        function confirmDelete(id) {
            Swal.fire({
                title: 'Hapus Buku Ini?',
                text: "Data buku akan dihapus permanen dari sistem!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444', // Merah
                cancelButtonColor: '#9ca3af', // Abu-abu
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                customClass: {
                    popup: 'rounded-3xl'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-book-' + id).submit();
                }
            });
        }

        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 2000,
                customClass: {
                    popup: 'rounded-3xl'
                }
            });
        @endif
    </script>
@endpush
