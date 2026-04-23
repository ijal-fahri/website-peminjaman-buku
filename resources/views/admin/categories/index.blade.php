@extends('layouts.admin')

@section('title', 'Kategori Buku - RuangBaca')

@section('header_title')
<div class="flex items-center gap-3">
    <div class="w-1.5 h-6 bg-gradient-to-b from-primary to-indigo-400 rounded-full shadow-sm"></div>
    <span class="text-xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-gray-800 to-gray-600 tracking-tight">
        Kategori Buku
    </span>
    <span class="hidden sm:inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider bg-emerald-50 text-emerald-600 border border-emerald-100 shadow-sm ml-1">
        Klasifikasi
    </span>
</div>
@endsection

@section('content')

<!-- Notifikasi Error Validasi -->
@if ($errors->any())
    <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-r-xl shadow-sm">
        <div class="flex">
            <svg class="h-5 w-5 text-red-500 mr-2 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
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
    <div class="p-6 sm:p-8 border-b border-gray-100 flex flex-col xl:flex-row justify-between items-start xl:items-center gap-6">
        <div class="flex items-center gap-4">
            <div class="p-3.5 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl shadow-lg shadow-emerald-200/50 flex-shrink-0 relative overflow-hidden group cursor-default">
                <div class="absolute inset-0 bg-white/20 blur-md transform -translate-x-full group-hover:translate-x-full transition-transform duration-1000 ease-in-out"></div>
                <svg class="w-6 h-6 text-white relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
            </div>
            <div>
                <h2 class="text-2xl font-extrabold text-gray-800 tracking-tight mb-1">Daftar Kategori</h2>
                <p class="text-sm text-gray-500 font-medium">Kelompokkan buku untuk mempermudah pencarian pembaca.</p>
            </div>
        </div>
        
        <div class="flex flex-col sm:flex-row w-full xl:w-auto gap-3">
            
            <!-- Form Gabungan: Dropdown Per Page & Search -->
            <form action="{{ route('admin.categories.index') }}" method="GET" class="flex flex-col sm:flex-row w-full xl:w-auto gap-3">
                <!-- Dropdown Pilih Jumlah Data -->
                <div class="relative w-full sm:w-28 shrink-0">
                    <select name="per_page" onchange="this.form.submit()" class="appearance-none block w-full pl-4 pr-10 py-3 border border-gray-200 rounded-xl text-sm font-bold text-gray-700 focus:outline-none focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 bg-gray-50/50 transition-all hover:bg-gray-50 cursor-pointer">
                        <option value="5" {{ request('per_page') == 5 ? 'selected' : '' }}>5 Data</option>
                        <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10 Data</option>
                        <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 Data</option>
                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 Data</option>
                    </select>
                    <!-- Ikon Panah Bawah -->
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-400">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>

                <!-- Search Input -->
                <div class="relative w-full sm:w-64">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" class="block w-full pl-11 pr-4 py-3 border border-gray-200 rounded-xl text-sm font-medium placeholder-gray-400 focus:outline-none focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 bg-gray-50/50 transition-all hover:bg-gray-50" placeholder="Cari nama kategori...">
                </div>
            </form>

            <!-- Tombol Trigger Modal Tambah -->
            <!-- Note: type="button" penting agar tidak ikut ke-submit oleh form di sebelahnya -->
            <button type="button" onclick="openModal('addModal')" class="bg-primary text-white px-6 py-3 rounded-xl font-bold hover:bg-indigo-700 transition-all shadow-lg shadow-primary/30 flex items-center justify-center gap-2 transform hover:-translate-y-0.5 w-full sm:w-auto shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
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
                    <th scope="col" class="px-6 py-5 font-bold tracking-wider">Nama Kategori</th>
                    <th scope="col" class="px-6 py-5 font-bold tracking-wider">Deskripsi Singkat</th>
                    <th scope="col" class="px-6 py-5 font-bold tracking-wider text-center">Jumlah Buku</th>
                    <th scope="col" class="px-6 py-5 font-bold tracking-wider text-center">Tgl Dibuat</th>
                    <th scope="col" class="px-6 py-5 font-bold tracking-wider text-right rounded-tr-lg">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                
                @forelse ($categories as $category)
                <tr class="bg-white hover:bg-gray-50 transition-colors">
                    <!-- Kolom Penomoran Dinamis -->
                    <td class="px-6 py-5 text-center font-bold text-gray-800">
                        {{ $categories->firstItem() + $loop->index }}
                    </td>
                    <td class="px-6 py-5">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-indigo-50 text-primary border border-indigo-100 flex items-center justify-center font-bold uppercase shrink-0">
                                {{ substr($category->name, 0, 2) }}
                            </div>
                            <span class="font-bold text-gray-900 text-base whitespace-nowrap">{{ $category->name }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-5 font-medium text-gray-500 max-w-xs truncate">
                        {{ $category->description ?: 'Tidak ada deskripsi' }}
                    </td>
                    <td class="px-6 py-5 text-center">
                        <span class="inline-flex items-center justify-center bg-indigo-50 text-primary font-bold px-3 py-1 rounded-lg border border-indigo-100">
                            <!-- Data dinamis dari withCount() -->
                            {{ $category->books_count }}
                        </span>
                    </td>
                    <td class="px-6 py-5 text-center font-medium text-gray-500 whitespace-nowrap">
                        {{ $category->created_at->format('d M Y') }}
                    </td>
                    <td class="px-6 py-5 text-right">
                        <div class="flex justify-end gap-2">
                            <button onclick="editCategory({{ $category->id }}, '{{ addslashes($category->name) }}', '{{ addslashes($category->description) }}')" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Edit">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </button>
                            
                            <button onclick="confirmDelete({{ $category->id }})" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>

                            <form id="delete-form-{{ $category->id }}" action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="hidden">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-10 text-center">
                        <div class="flex flex-col items-center justify-center text-gray-400">
                            <svg class="w-12 h-12 mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                            <span class="text-lg font-medium text-gray-500">Belum ada data kategori</span>
                            <p class="text-sm mt-1">Silakan tambahkan kategori baru atau ubah kata kunci pencarian.</p>
                        </div>
                    </td>
                </tr>
                @endforelse

            </tbody>
        </table>
    </div>
    
    <!-- Dynamic Pagination Custom UI -->
    <div class="px-6 py-4 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-4 bg-gray-50/30">
        <span class="text-sm text-gray-500 text-center sm:text-left">
            Menampilkan <span class="font-bold text-gray-800">{{ $categories->count() > 0 ? $categories->firstItem() : 0 }}</span> 
            sampai <span class="font-bold text-gray-800">{{ $categories->count() > 0 ? $categories->lastItem() : 0 }}</span> 
            dari <span class="font-bold text-gray-800">{{ $categories->total() }}</span> kategori
        </span>
        
        @if ($categories->hasPages())
        <div class="flex gap-1">
            {{-- Tombol Sebelumnya --}}
            @if ($categories->onFirstPage())
                <button class="px-3 py-1.5 border border-gray-200 rounded-lg text-sm text-gray-400 bg-gray-50 cursor-not-allowed" disabled>Sebelumnya</button>
            @else
                <a href="{{ $categories->appends(request()->query())->previousPageUrl() }}" class="px-3 py-1.5 border border-gray-200 rounded-lg text-sm text-gray-600 bg-white hover:bg-gray-50 transition-colors">Sebelumnya</a>
            @endif

            {{-- Angka Pagination --}}
            @foreach ($categories->appends(request()->query())->getUrlRange(max(1, $categories->currentPage() - 1), min($categories->lastPage(), $categories->currentPage() + 1)) as $page => $url)
                @if ($page == $categories->currentPage())
                    <button class="px-3 py-1.5 border border-primary bg-primary text-white rounded-lg text-sm font-medium shadow-sm">{{ $page }}</button>
                @else
                    <a href="{{ $url }}" class="px-3 py-1.5 border border-gray-200 rounded-lg text-sm text-gray-600 bg-white hover:bg-gray-50 transition-colors">{{ $page }}</a>
                @endif
            @endforeach

            {{-- Tombol Selanjutnya --}}
            @if ($categories->hasMorePages())
                <a href="{{ $categories->appends(request()->query())->nextPageUrl() }}" class="px-3 py-1.5 border border-gray-200 rounded-lg text-sm text-gray-600 bg-white hover:bg-gray-50 transition-colors">Selanjutnya</a>
            @else
                <button class="px-3 py-1.5 border border-gray-200 rounded-lg text-sm text-gray-400 bg-gray-50 cursor-not-allowed" disabled>Selanjutnya</button>
            @endif
        </div>
        @endif
    </div>

</div>

<!-- ============================================== -->
<!-- MODAL TAMBAH KATEGORI -->
<!-- ============================================== -->
<div id="addModal" class="fixed inset-0 z-[100] hidden">
    <div class="fixed inset-0 bg-gray-900/40 backdrop-blur-sm transition-opacity" onclick="closeModal('addModal')"></div>
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
        <div class="relative bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:max-w-lg w-full border border-gray-100">
            <div class="bg-white px-6 pt-6 pb-6 sm:p-8">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-2xl font-extrabold text-gray-900 tracking-tight" id="modal-title">Tambah Kategori Baru</h3>
                    <button onclick="closeModal('addModal')" class="text-gray-400 hover:text-gray-500 hover:bg-gray-100 p-2 rounded-full transition-colors focus:outline-none">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>
                
                <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-5">
                    @csrf
                    <div>
                        <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Nama Kategori <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" required class="block w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-primary focus:border-primary transition-colors bg-gray-50 focus:bg-white sm:text-sm" placeholder="Contoh: Fiksi, Sains, dll">
                    </div>
                    <div>
                        <label for="description" class="block text-sm font-bold text-gray-700 mb-2">Deskripsi Singkat <span class="text-gray-400 font-normal">(Opsional)</span></label>
                        <textarea name="description" id="description" rows="3" class="block w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-primary focus:border-primary transition-colors bg-gray-50 focus:bg-white sm:text-sm resize-none" placeholder="Jelaskan sedikit tentang kategori ini..."></textarea>
                    </div>
                    <div class="mt-8 sm:flex sm:flex-row-reverse gap-3">
                        <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-md px-6 py-3 bg-primary text-base font-bold text-white hover:bg-indigo-700 focus:outline-none transition-all sm:w-auto sm:text-sm transform active:scale-95">
                            Simpan Kategori
                        </button>
                        <button type="button" onclick="closeModal('addModal')" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-6 py-3 bg-white text-base font-bold text-gray-700 hover:bg-gray-50 focus:outline-none transition-all sm:mt-0 sm:w-auto sm:text-sm">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- ============================================== -->
<!-- MODAL EDIT KATEGORI -->
<!-- ============================================== -->
<div id="editModal" class="fixed inset-0 z-[100] hidden">
    <div class="fixed inset-0 bg-gray-900/40 backdrop-blur-sm transition-opacity" onclick="closeModal('editModal')"></div>
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
        <div class="relative bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:max-w-lg w-full border border-gray-100">
            <div class="bg-white px-6 pt-6 pb-6 sm:p-8">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-2xl font-extrabold text-gray-900 tracking-tight">Edit Kategori</h3>
                    <button onclick="closeModal('editModal')" class="text-gray-400 hover:text-gray-500 hover:bg-gray-100 p-2 rounded-full transition-colors focus:outline-none">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>
                
                <form id="editForm" method="POST" class="space-y-5">
                    @csrf
                    @method('PUT') 
                    <div>
                        <label for="edit_name" class="block text-sm font-bold text-gray-700 mb-2">Nama Kategori <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="edit_name" required class="block w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-primary focus:border-primary transition-colors bg-gray-50 focus:bg-white sm:text-sm">
                    </div>
                    <div>
                        <label for="edit_description" class="block text-sm font-bold text-gray-700 mb-2">Deskripsi Singkat</label>
                        <textarea name="description" id="edit_description" rows="3" class="block w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-primary focus:border-primary transition-colors bg-gray-50 focus:bg-white sm:text-sm resize-none"></textarea>
                    </div>
                    <div class="mt-8 sm:flex sm:flex-row-reverse gap-3">
                        <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-md px-6 py-3 bg-primary text-base font-bold text-white hover:bg-indigo-700 focus:outline-none transition-all sm:w-auto sm:text-sm transform active:scale-95">
                            Simpan Perubahan
                        </button>
                        <button type="button" onclick="closeModal('editModal')" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-6 py-3 bg-white text-base font-bold text-gray-700 hover:bg-gray-50 focus:outline-none transition-all sm:mt-0 sm:w-auto sm:text-sm">
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
    // FUNGSI MEMBUKA & MENUTUP MODAL
    function openModal(modalId) {
        document.getElementById(modalId).classList.remove('hidden');
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }

    // FUNGSI MENGISI DATA KE MODAL EDIT
    function editCategory(id, name, description) {
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_description').value = description;
        document.getElementById('editForm').action = '/admin/kategori/' + id;
        openModal('editModal');
    }

    // FUNGSI SWEETALERT UNTUK HAPUS
    function confirmDelete(id) {
        Swal.fire({
            title: 'Hapus Kategori Ini?',
            text: "Data yang telah dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444', // Merah
            cancelButtonColor: '#9ca3af',  // Abu-abu
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            customClass: {
                popup: 'rounded-3xl'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }

    // FUNGSI SWEETALERT UNTUK NOTIFIKASI SUKSES
    @if(session('success'))
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