@extends('layouts.admin')

@section('title', 'Manajemen Pengguna - RuangBaca')

@section('header_title')
<div class="flex items-center gap-3">
    <div class="w-1.5 h-6 bg-gradient-to-b from-primary to-indigo-400 rounded-full shadow-sm"></div>
    <span class="text-xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-gray-800 to-gray-600 tracking-tight">
        Manajemen Pengguna
    </span>
    <span class="hidden sm:inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider bg-orange-50 text-orange-600 border border-orange-100 shadow-sm ml-1">
        Akses
    </span>
</div>
@endsection

@section('content')

<!-- Notifikasi Error (misal admin menghapus diri sendiri) -->
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
            <div class="p-3.5 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl shadow-lg shadow-blue-200/50 flex-shrink-0 relative overflow-hidden group cursor-default">
                <div class="absolute inset-0 bg-white/20 blur-md transform -translate-x-full group-hover:translate-x-full transition-transform duration-1000 ease-in-out"></div>
                <svg class="w-6 h-6 text-white relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>
            <div>
                <h2 class="text-2xl font-extrabold text-gray-800 tracking-tight mb-1">Daftar Pengguna</h2>
                <p class="text-sm text-gray-500 font-medium">Kelola akun admin dan anggota terdaftar di sistem.</p>
            </div>
        </div>
        
        <div class="flex flex-col sm:flex-row w-full xl:w-auto gap-3">
            <!-- Form Gabungan: Dropdown Per Page & Search dipindah ke KIRI -->
            <form action="{{ route('admin.users.index') }}" method="GET" class="flex flex-col sm:flex-row w-full xl:w-auto gap-3">
                <div class="relative w-full sm:w-28 shrink-0">
                    <select name="per_page" onchange="this.form.submit()" class="appearance-none block w-full pl-4 pr-10 py-3 border border-gray-200 rounded-xl text-sm font-bold text-gray-700 focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 bg-gray-50/50 transition-all hover:bg-gray-50 cursor-pointer">
                        <option value="5" {{ request('per_page') == 5 ? 'selected' : '' }}>5 Data</option>
                        <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10 Data</option>
                        <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 Data</option>
                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 Data</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-400">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>

                <div class="relative w-full sm:w-72">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" class="block w-full pl-11 pr-4 py-3 border border-gray-200 rounded-xl text-sm font-medium placeholder-gray-400 focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 bg-gray-50/50 transition-all hover:bg-gray-50" placeholder="Cari nama atau email...">
                </div>

                <!-- Filter Role Baru -->
                <div class="relative w-full sm:w-40 shrink-0">
                    <select name="role" onchange="this.form.submit()" class="appearance-none block w-full pl-4 pr-10 py-3 border border-gray-200 rounded-xl text-sm font-bold text-gray-700 focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 bg-gray-50/50 transition-all hover:bg-gray-50 cursor-pointer">
                        <option value="">Semua Role</option>
                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Administrator</option>
                        <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>Member</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-400">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>
            </form>

            <!-- Tombol Tambah Pengguna Baru dipindah ke KANAN dengan style persis buku -->
            <button type="button" onclick="openModal('addUserModal')" class="bg-primary text-white px-6 py-3 rounded-xl font-bold hover:bg-indigo-700 transition-all shadow-lg shadow-primary/30 flex items-center justify-center gap-2 transform hover:-translate-y-0.5 w-full sm:w-auto shrink-0">
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
                    <th scope="col" class="px-6 py-5 font-bold tracking-wider">Profil Pengguna</th>
                    <th scope="col" class="px-6 py-5 font-bold tracking-wider text-center">Hak Akses (Role)</th>
                    <th scope="col" class="px-6 py-5 font-bold tracking-wider text-center">Bergabung Pada</th>
                    <th scope="col" class="px-6 py-5 font-bold tracking-wider text-right rounded-tr-lg">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                
                @forelse ($users as $user)
                <tr class="bg-white hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-5 text-center font-bold text-gray-800">
                        {{ $users->firstItem() + $loop->index }}
                    </td>
                    <td class="px-6 py-5">
                        <div class="flex items-center gap-4">
                            <!-- Avatar Bulat Inisial -->
                            <div class="w-12 h-12 rounded-full {{ $user->role === 'admin' ? 'bg-indigo-100 text-primary border-indigo-200' : 'bg-emerald-100 text-emerald-600 border-emerald-200' }} border flex items-center justify-center font-bold uppercase text-lg shrink-0 shadow-sm">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 text-base mb-0.5">{{ $user->name }}
                                    @if(Auth::id() === $user->id)
                                        <span class="ml-2 text-[10px] font-bold bg-blue-100 text-blue-600 px-2 py-0.5 rounded-full uppercase tracking-wider">Anda</span>
                                    @endif
                                </h4>
                                <p class="text-xs font-medium text-gray-500">{{ $user->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-5 text-center">
                        @if($user->role === 'admin')
                            <span class="inline-flex items-center gap-1.5 bg-primary/10 text-primary border border-primary/20 px-3 py-1.5 rounded-lg text-xs font-bold uppercase tracking-wide">
                                <span class="w-1.5 h-1.5 rounded-full bg-primary"></span> Administrator
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 bg-gray-100 text-gray-600 border border-gray-200 px-3 py-1.5 rounded-lg text-xs font-bold uppercase tracking-wide">
                                <span class="w-1.5 h-1.5 rounded-full bg-gray-500"></span> Member
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-5 text-center font-medium text-gray-500 whitespace-nowrap">
                        {{ $user->created_at->format('d M Y') }}
                    </td>
                    <td class="px-6 py-5 text-right">
                        <div class="flex justify-end gap-2">
                            <!-- Tombol Ganti Role -->
                            <button onclick="editRole({{ $user->id }}, '{{ $user->role }}', '{{ addslashes($user->name) }}')" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Ubah Hak Akses">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                            </button>
                            
                            <!-- Tombol Hapus memanggil SweetAlert -->
                            <button onclick="confirmDelete({{ $user->id }})" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus Pengguna" {{ Auth::id() === $user->id ? 'disabled' : '' }}>
                                <svg class="w-5 h-5 {{ Auth::id() === $user->id ? 'opacity-30' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>

                            <form id="delete-form-{{ $user->id }}" action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="hidden">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center justify-center text-gray-400">
                            <svg class="w-12 h-12 mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            <span class="text-lg font-medium text-gray-500">Tidak ada pengguna ditemukan</span>
                            <p class="text-sm mt-1">Coba ubah kata kunci pencarian Anda.</p>
                        </div>
                    </td>
                </tr>
                @endforelse

            </tbody>
        </table>
    </div>
    
    <!-- Dynamic Pagination -->
    <div class="px-6 py-4 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-4 bg-gray-50/30">
        <span class="text-sm text-gray-500 text-center sm:text-left">
            Menampilkan <span class="font-bold text-gray-800">{{ $users->count() > 0 ? $users->firstItem() : 0 }}</span> 
            sampai <span class="font-bold text-gray-800">{{ $users->count() > 0 ? $users->lastItem() : 0 }}</span> 
            dari <span class="font-bold text-gray-800">{{ $users->total() }}</span> pengguna
        </span>
        
        @if ($users->hasPages())
        <div class="flex gap-1">
            @if ($users->onFirstPage())
                <button class="px-3 py-1.5 border border-gray-200 rounded-lg text-sm text-gray-400 bg-gray-50 cursor-not-allowed" disabled>Sebelumnya</button>
            @else
                <a href="{{ $users->appends(request()->query())->previousPageUrl() }}" class="px-3 py-1.5 border border-gray-200 rounded-lg text-sm text-gray-600 bg-white hover:bg-gray-50 transition-colors">Sebelumnya</a>
            @endif

            @foreach ($users->appends(request()->query())->getUrlRange(max(1, $users->currentPage() - 1), min($users->lastPage(), $users->currentPage() + 1)) as $page => $url)
                @if ($page == $users->currentPage())
                    <button class="px-3 py-1.5 border border-primary bg-primary text-white rounded-lg text-sm font-medium shadow-sm">{{ $page }}</button>
                @else
                    <a href="{{ $url }}" class="px-3 py-1.5 border border-gray-200 rounded-lg text-sm text-gray-600 bg-white hover:bg-gray-50 transition-colors">{{ $page }}</a>
                @endif
            @endforeach

            @if ($users->hasMorePages())
                <a href="{{ $users->appends(request()->query())->nextPageUrl() }}" class="px-3 py-1.5 border border-gray-200 rounded-lg text-sm text-gray-600 bg-white hover:bg-gray-50 transition-colors">Selanjutnya</a>
            @else
                <button class="px-3 py-1.5 border border-gray-200 rounded-lg text-sm text-gray-400 bg-gray-50 cursor-not-allowed" disabled>Selanjutnya</button>
            @endif
        </div>
        @endif
    </div>

</div>

<!-- ============================================== -->
<!-- MODAL TAMBAH PENGGUNA BARU -->
<!-- ============================================== -->
<div id="addUserModal" class="fixed inset-0 z-[100] hidden">
    <div class="fixed inset-0 bg-gray-900/40 backdrop-blur-sm transition-opacity" onclick="closeModal('addUserModal')"></div>
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
        <div class="relative bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:max-w-xl w-full border border-gray-100">
            <div class="bg-white px-6 pt-6 pb-6 sm:p-8">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-2xl font-extrabold text-gray-900 tracking-tight">Tambah Pengguna Baru</h3>
                    <button onclick="closeModal('addUserModal')" class="text-gray-400 hover:text-gray-500 hover:bg-gray-100 p-2 rounded-full transition-colors focus:outline-none">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>
                
                <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-5">
                    @csrf
                    
                    <!-- Input Nama -->
                    <div>
                        <label for="name" class="block text-sm font-bold text-gray-700 mb-1">Nama Lengkap</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required class="block w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-primary focus:border-primary sm:text-sm transition-colors" placeholder="Masukkan nama lengkap">
                    </div>

                    <!-- Input Email -->
                    <div>
                        <label for="email" class="block text-sm font-bold text-gray-700 mb-1">Alamat Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required class="block w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-primary focus:border-primary sm:text-sm transition-colors" placeholder="nama@email.com">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Input Password -->
                        <div>
                            <label for="password" class="block text-sm font-bold text-gray-700 mb-1">Password</label>
                            <input type="password" name="password" id="password" required class="block w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-primary focus:border-primary sm:text-sm transition-colors" placeholder="Minimal 8 karakter">
                        </div>

                        <!-- Konfirmasi Password -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-bold text-gray-700 mb-1">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" required class="block w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-primary focus:border-primary sm:text-sm transition-colors" placeholder="Ketik ulang password">
                        </div>
                    </div>

                    <!-- Hak Akses -->
                    <div class="pt-2">
                        <label class="block text-sm font-bold text-gray-700 mb-3">Pilih Hak Akses</label>
                        <div class="grid grid-cols-2 gap-4">
                            <label class="relative flex flex-col bg-white border-2 border-gray-200 rounded-xl p-4 cursor-pointer hover:bg-gray-50 transition-all [&:has(input:checked)]:border-primary [&:has(input:checked)]:bg-indigo-50">
                                <input type="radio" name="role" value="user" class="absolute w-0 h-0 opacity-0" {{ old('role', 'user') == 'user' ? 'checked' : '' }}>
                                <span class="font-bold text-gray-900 mb-1">Member</span>
                                <span class="text-xs text-gray-500">Akses pengguna biasa.</span>
                            </label>
                            
                            <label class="relative flex flex-col bg-white border-2 border-gray-200 rounded-xl p-4 cursor-pointer hover:bg-gray-50 transition-all [&:has(input:checked)]:border-primary [&:has(input:checked)]:bg-indigo-50">
                                <input type="radio" name="role" value="admin" class="absolute w-0 h-0 opacity-0" {{ old('role') == 'admin' ? 'checked' : '' }}>
                                <span class="font-bold text-gray-900 mb-1">Administrator</span>
                                <span class="text-xs text-gray-500">Akses penuh ke admin.</span>
                            </label>
                        </div>
                    </div>
                    
                    <div class="mt-8 pt-4 border-t border-gray-100 sm:flex sm:flex-row-reverse gap-3">
                        <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-md px-6 py-3 bg-primary text-base font-bold text-white hover:bg-indigo-700 focus:outline-none transition-all sm:w-auto sm:text-sm transform active:scale-95">
                            Simpan Pengguna
                        </button>
                        <button type="button" onclick="closeModal('addUserModal')" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-6 py-3 bg-white text-base font-bold text-gray-700 hover:bg-gray-50 focus:outline-none transition-all sm:mt-0 sm:w-auto sm:text-sm">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- ============================================== -->
<!-- MODAL UBAH ROLE PENGGUNA -->
<!-- ============================================== -->
<div id="roleModal" class="fixed inset-0 z-[100] hidden">
    <div class="fixed inset-0 bg-gray-900/40 backdrop-blur-sm transition-opacity" onclick="closeModal('roleModal')"></div>
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
        <div class="relative bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:max-w-lg w-full border border-gray-100">
            <div class="bg-white px-6 pt-6 pb-6 sm:p-8">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-2xl font-extrabold text-gray-900 tracking-tight">Ubah Hak Akses</h3>
                    <button onclick="closeModal('roleModal')" class="text-gray-400 hover:text-gray-500 hover:bg-gray-100 p-2 rounded-full transition-colors focus:outline-none">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>
                
                <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 mb-6">
                    <p class="text-sm text-blue-800">Ubah peran untuk pengguna: <span id="modal_user_name" class="font-bold text-blue-900 uppercase"></span></p>
                </div>

                <form id="editRoleForm" method="POST" class="space-y-5">
                    @csrf
                    @method('PUT') 
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-3">Pilih Hak Akses Baru</label>
                        <div class="grid grid-cols-2 gap-4">
                            <label class="relative flex flex-col bg-white border-2 border-gray-200 rounded-xl p-4 cursor-pointer hover:bg-gray-50 transition-all [&:has(input:checked)]:border-primary [&:has(input:checked)]:bg-indigo-50">
                                <input type="radio" name="role" value="user" id="role_user" class="absolute w-0 h-0 opacity-0">
                                <span class="font-bold text-gray-900 mb-1">Member</span>
                                <span class="text-xs text-gray-500">Akses hanya untuk meminjam buku.</span>
                            </label>
                            
                            <label class="relative flex flex-col bg-white border-2 border-gray-200 rounded-xl p-4 cursor-pointer hover:bg-gray-50 transition-all [&:has(input:checked)]:border-primary [&:has(input:checked)]:bg-indigo-50">
                                <input type="radio" name="role" value="admin" id="role_admin" class="absolute w-0 h-0 opacity-0">
                                <span class="font-bold text-gray-900 mb-1">Administrator</span>
                                <span class="text-xs text-gray-500">Akses penuh ke panel admin.</span>
                            </label>
                        </div>
                    </div>
                    
                    <div class="mt-8 sm:flex sm:flex-row-reverse gap-3">
                        <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-md px-6 py-3 bg-primary text-base font-bold text-white hover:bg-indigo-700 focus:outline-none transition-all sm:w-auto sm:text-sm transform active:scale-95">
                            Simpan Akses
                        </button>
                        <button type="button" onclick="closeModal('roleModal')" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-6 py-3 bg-white text-base font-bold text-gray-700 hover:bg-gray-50 focus:outline-none transition-all sm:mt-0 sm:w-auto sm:text-sm">
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

    // FUNGSI MENGISI DATA KE MODAL EDIT ROLE
    function editRole(id, currentRole, name) {
        document.getElementById('modal_user_name').innerText = name;
        
        // Otomatis mencentang radio button sesuai role saat ini
        if(currentRole === 'admin') {
            document.getElementById('role_admin').checked = true;
        } else {
            document.getElementById('role_user').checked = true;
        }

        document.getElementById('editRoleForm').action = '/admin/pengguna/' + id;
        openModal('roleModal');
    }

    // FUNGSI SWEETALERT UNTUK HAPUS
    function confirmDelete(id) {
        Swal.fire({
            title: 'Hapus Pengguna Ini?',
            text: "Seluruh data dan akses pengguna akan dihapus permanen!",
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

    // SWEETALERT NOTIFIKASI SUKSES
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

    // OTOMATIS BUKA MODAL JIKA ADA ERROR VALIDASI TAMBAH USER
    @if($errors->has('name') || $errors->has('email') || $errors->has('password'))
        openModal('addUserModal');
    @endif
</script>
@endpush