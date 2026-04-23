@extends('layouts.admin')

@section('title', 'Transaksi Peminjaman - RuangBaca')

@section('header_title')
    <div class="flex items-center gap-3">
        <div class="w-1.5 h-6 bg-gradient-to-b from-primary to-indigo-400 rounded-full shadow-sm"></div>
        <span
            class="text-xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-gray-800 to-gray-600 tracking-tight">
            Permintaan & Peminjaman Aktif
        </span>
        <span
            class="hidden sm:inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider bg-blue-50 text-blue-600 border border-blue-100 shadow-sm ml-1">
            Aktif
        </span>
    </div>
@endsection

@section('content')

    @if (session('success'))
        <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 mb-6 rounded-r-xl shadow-sm">
            <p class="text-emerald-700 font-bold text-sm">{{ session('success') }}</p>
        </div>
    @endif

    <!-- Blok Penampil Error agar sistem memberi tahu jika ada yang salah -->
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

        <div
            class="p-6 sm:p-8 border-b border-gray-100 flex flex-col xl:flex-row justify-between items-start xl:items-center gap-6">
            <div class="flex items-center gap-4">
                <div
                    class="p-3.5 bg-gradient-to-br from-orange-500 to-red-500 rounded-2xl shadow-lg shadow-orange-200/50 flex-shrink-0 relative overflow-hidden">
                    <svg class="w-6 h-6 text-white relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                        </path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-2xl font-extrabold text-gray-800 tracking-tight mb-1">Permintaan & Peminjaman</h2>
                    <p class="text-sm text-gray-500 font-medium">Kelola persetujuan dan pengembalian buku siswa.</p>
                </div>
            </div>

            <form action="{{ route('admin.borrows.index') }}" method="GET"
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
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
                        placeholder="Cari nama siswa, email, buku...">
                </div>

                <select name="status" onchange="this.form.submit()"
                    class="appearance-none block w-full sm:w-40 pl-4 pr-10 py-3 border border-gray-200 rounded-xl text-sm font-bold text-gray-700 focus:ring-primary focus:border-primary bg-gray-50 cursor-pointer">
                    <option value="">Semua Status</option>
                    <option value="menunggu_persetujuan"
                        {{ request('status') == 'menunggu_persetujuan' ? 'selected' : '' }}>Menunggu Persetujuan</option>
                    <option value="dipinjam" {{ request('status') == 'dipinjam' ? 'selected' : '' }}>Sedang Dipinjam
                    </option>
                    <option value="menunggu_pengembalian"
                        {{ request('status') == 'menunggu_pengembalian' ? 'selected' : '' }}>Menunggu Pengembalian</option>
                </select>
            </form>
        </div>

        <!-- TABEL DATA PEMINJAMAN -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600">
                <thead class="text-xs text-gray-500 uppercase bg-gray-50/50">
                    <tr>
                        <th scope="col" class="px-6 py-5 font-bold tracking-wider">Detail Peminjam</th>
                        <th scope="col" class="px-6 py-5 font-bold tracking-wider">Buku & Jaminan</th>
                        <th scope="col" class="px-6 py-5 font-bold tracking-wider text-center">Durasi</th>
                        <th scope="col" class="px-6 py-5 font-bold tracking-wider text-center">Status</th>
                        <th scope="col" class="px-6 py-5 font-bold tracking-wider text-right">Aksi Petugas</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">

                    <!-- AWAL FORELSE YANG SEBELUMNYA TERHAPUS -->
                    @forelse ($borrows as $borrow)
                        <tr class="bg-white hover:bg-gray-50 transition-colors">

                            <td class="px-6 py-5">
                                <div class="font-bold text-gray-900 text-base">{{ $borrow->user->name }}</div>
                                <div class="text-xs text-gray-500 mt-0.5">{{ $borrow->user->email }}</div>
                            </td>

                            <td class="px-6 py-5">
                                <div class="font-bold text-primary mb-1">{{ $borrow->book->title }}</div>
                                <div
                                    class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-yellow-50 text-yellow-700 border border-yellow-200 rounded-md text-[10px] font-bold uppercase tracking-wider">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2">
                                        </path>
                                    </svg>
                                    Jaminan: {{ $borrow->guarantee }}
                                </div>
                            </td>

                            <td class="px-6 py-5 text-center">
                                <div class="text-sm font-medium text-gray-600">{{ $borrow->borrow_date->format('d M') }} -
                                    {{ $borrow->due_date->format('d M Y') }}</div>
                            </td>

                            <td class="px-6 py-5 text-center">
                                @if ($borrow->status == 'menunggu_persetujuan')
                                    <span
                                        class="inline-flex bg-orange-100 text-orange-600 px-3 py-1 rounded-md text-[11px] font-bold uppercase tracking-wider">Menunggu
                                        ACC</span>
                                @elseif($borrow->status == 'dipinjam')
                                    <span
                                        class="inline-flex bg-blue-100 text-blue-600 px-3 py-1 rounded-md text-[11px] font-bold uppercase tracking-wider">Sedang
                                        Dibaca</span>
                                @elseif($borrow->status == 'menunggu_pengembalian')
                                    <span
                                        class="inline-flex bg-purple-100 text-purple-600 px-3 py-1 rounded-md text-[11px] font-bold uppercase tracking-wider">Minta
                                        Kembali</span>
                                @elseif($borrow->status == 'dikembalikan')
                                    <span
                                        class="inline-flex bg-emerald-100 text-emerald-600 px-3 py-1 rounded-md text-[11px] font-bold uppercase tracking-wider">Selesai</span>
                                @else
                                    <span
                                        class="inline-flex bg-red-100 text-red-600 px-3 py-1 rounded-md text-[11px] font-bold uppercase tracking-wider">Ditolak</span>
                                @endif
                            </td>

                            <td class="px-6 py-5 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <!-- TOMBOL SHOW DETAIL -->
                                    <button type="button" onclick="openDetailModal(this)"
                                        data-user-name="{{ $borrow->user->name }}"
                                        data-user-email="{{ $borrow->user->email }}"
                                        data-book-title="{{ $borrow->book->title }}"
                                        data-guarantee="{{ $borrow->guarantee }}"
                                        data-borrow-date="{{ $borrow->borrow_date->format('d F Y') }}"
                                        data-return-date="{{ $borrow->due_date->format('d F Y') }}"
                                        data-status="{{ $borrow->status }}"
                                        class="bg-blue-50 text-blue-600 hover:bg-blue-100 p-2 rounded-lg transition-colors shadow-sm"
                                        title="Lihat Detail Lengkap">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                            </path>
                                        </svg>
                                    </button>

                                    <!-- TOMBOL AKSI LAINNYA -->
                                    @if ($borrow->status == 'menunggu_persetujuan')
                                        <form action="{{ route('admin.borrows.approve', $borrow->id) }}" method="POST"
                                            class="inline-block">
                                            @csrf @method('PUT')
                                            <button type="submit"
                                                class="bg-emerald-500 hover:bg-emerald-600 text-white px-3 py-2 rounded-lg text-xs font-bold transition-colors shadow-sm"
                                                title="Setujui Peminjaman">Setujui</button>
                                        </form>
                                        <button type="button"
                                            onclick="openRejectModal({{ $borrow->id }}, '{{ addslashes($borrow->user->name) }}', '{{ addslashes($borrow->book->title) }}')"
                                            class="bg-white border border-gray-300 text-red-500 hover:bg-red-50 px-3 py-2 rounded-lg text-xs font-bold transition-colors"
                                            title="Tolak Permintaan">Tolak</button>
                                    @elseif($borrow->status == 'menunggu_pengembalian' || $borrow->status == 'dipinjam')
                                        <!-- Menerima buku yang sedang dipinjam atau menunggu pengembalian -->
                                        <button type="button"
                                            onclick="openReturnModal({{ $borrow->id }}, '{{ addslashes($borrow->user->name) }}', '{{ addslashes($borrow->book->title) }}')"
                                            class="bg-primary hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-xs font-bold transition-colors shadow-sm">Terima
                                            Buku</button>
                                    @elseif($borrow->status == 'dikembalikan' && $borrow->fine > 0)
                                        <span class="text-red-500 text-xs font-bold bg-red-50 px-2 py-1 rounded-md">Denda:
                                            Rp {{ number_format($borrow->fine, 0, ',', '.') }}</span>
                                    @else
                                        <span class="text-gray-400 text-xs font-bold">-</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center text-gray-400">
                                    <span class="text-lg font-medium text-gray-500">Belum ada data transaksi</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($borrows->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/30">
                {{ $borrows->links('pagination::tailwind') }}
            </div>
        @endif

    </div>

    <!-- ============================================== -->
    <!-- MODAL DETAIL PEMINJAMAN                        -->
    <!-- ============================================== -->
    <div id="detailModal" class="fixed inset-0 z-[100] hidden">
        <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" onclick="closeDetailModal()"></div>
        <div class="flex justify-center items-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div
                class="relative bg-white rounded-[2rem] text-left shadow-2xl transform transition-all sm:max-w-xl w-full border border-gray-100 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-extrabold text-gray-900 tracking-tight">Detail Peminjaman</h3>
                    </div>
                    <button onclick="closeDetailModal()"
                        class="text-gray-400 hover:text-gray-500 hover:bg-gray-200 p-2 rounded-full transition-colors focus:outline-none">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="p-6 sm:p-8 space-y-6">
                    <div class="bg-gray-50 p-4 rounded-2xl border border-gray-100">
                        <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Informasi Siswa</h4>
                        <div class="flex flex-col">
                            <span class="text-sm font-bold text-gray-900" id="detail_user_name">-</span>
                            <span class="text-sm text-gray-500" id="detail_user_email">-</span>
                        </div>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-2xl border border-gray-100">
                        <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Buku & Jaminan</h4>
                        <div class="flex flex-col gap-2">
                            <span class="text-base font-bold text-primary" id="detail_book_title">-</span>
                            <div
                                class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-yellow-50 text-yellow-700 border border-yellow-200 rounded-md text-[11px] font-bold uppercase tracking-wider w-fit">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2">
                                    </path>
                                </svg>
                                Jaminan: <span id="detail_guarantee">-</span>
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-gray-50 p-4 rounded-2xl border border-gray-100">
                            <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Tanggal Pinjam</h4>
                            <span class="text-sm font-bold text-gray-800" id="detail_borrow_date">-</span>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-2xl border border-gray-100">
                            <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Batas Kembali</h4>
                            <span class="text-sm font-bold text-gray-800" id="detail_return_date">-</span>
                        </div>
                    </div>
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-2xl border border-gray-100">
                        <span class="text-sm font-bold text-gray-600">Status Transaksi:</span>
                        <div id="detail_status_container"></div>
                    </div>
                </div>
                <div class="px-6 py-4 border-t border-gray-100 flex justify-end bg-gray-50/50">
                    <button type="button" onclick="closeDetailModal()"
                        class="w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-6 py-2.5 bg-white text-sm font-bold text-gray-700 hover:bg-gray-50 transition-all sm:w-auto">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- ============================================== -->
    <!-- MODAL TERIMA BUKU & DENDA                      -->
    <!-- ============================================== -->
    <div id="returnModal" class="fixed inset-0 z-[100] hidden">
        <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" onclick="closeReturnModal()"></div>
        <div class="flex justify-center items-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div
                class="relative bg-white rounded-[2rem] text-left shadow-2xl transform transition-all sm:max-w-lg w-full border border-gray-100 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-blue-50/50">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-extrabold text-gray-900 tracking-tight">Proses Pengembalian</h3>
                    </div>
                    <button onclick="closeReturnModal()"
                        class="text-gray-400 hover:text-gray-500 hover:bg-gray-200 p-2 rounded-full transition-colors focus:outline-none">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="p-6 sm:p-8">
                    <p class="text-sm text-gray-600 mb-5">Menerima pengembalian buku <span id="return_book_title"
                            class="font-bold text-gray-900 border-b border-gray-300"></span> dari siswa <span
                            id="return_user_name" class="font-bold text-gray-900 border-b border-gray-300"></span>.</p>
                    <form id="returnForm" method="POST" class="space-y-5">
                        @csrf
                        @method('PUT')

                        <!-- Input Tanggal Pengembalian (Otomatis hari ini) -->
                        <div class="bg-gray-50 p-5 rounded-2xl border border-gray-200 text-left">
                            <label for="actual_return_date" class="block text-sm font-bold text-gray-700 mb-2">Tanggal
                                Pengembalian Aktual</label>
                            <input type="date" name="actual_return_date" id="actual_return_date"
                                value="{{ date('Y-m-d') }}" required
                                class="block w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-primary focus:border-primary transition-colors text-gray-900">
                        </div>

                        <div class="bg-gray-50 p-5 rounded-2xl border border-gray-200">
                            <label for="fine" class="block text-sm font-bold text-gray-700 mb-2 text-left">Masalah
                                Fisik / Keterlambatan?</label>
                            <p class="text-xs text-gray-500 mb-4 text-left">Jika buku rusak, hilang, atau terlambat,
                                masukkan nominal denda. Biarkan 0 jika buku kembali dengan aman.</p>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <span class="text-gray-500 font-bold">Rp</span>
                                </div>
                                <input type="number" name="fine" id="fine" value="0" min="0"
                                    class="block w-full pl-12 pr-4 py-3 text-lg font-black border border-gray-300 rounded-xl focus:ring-primary focus:border-primary transition-colors text-gray-900">
                            </div>
                        </div>

                        <div
                            class="mt-8 pt-6 border-t border-gray-100 flex flex-col-reverse sm:flex-row justify-end gap-3">
                            <button type="button" onclick="closeReturnModal()"
                                class="w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-6 py-3.5 bg-white text-sm font-bold text-gray-700 hover:bg-gray-50 transition-all sm:w-auto">
                                Batal
                            </button>
                            <button type="submit"
                                class="w-full inline-flex justify-center items-center gap-2 rounded-xl border border-transparent shadow-lg shadow-primary/30 px-6 py-3.5 bg-primary text-sm font-bold text-white hover:bg-indigo-700 transition-all sm:w-auto transform active:scale-95">
                                Selesaikan Transaksi
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
        function openReturnModal(id, userName, bookTitle) {
            const modal = document.getElementById('returnModal');
            document.getElementById('return_user_name').innerText = userName;
            document.getElementById('return_book_title').innerText = bookTitle;
            document.getElementById('fine').value = 0;
            document.getElementById('returnForm').action = '/admin/transaksi/' + id + '/return';
            modal.classList.remove('hidden');
        }

        function closeReturnModal() {
            document.getElementById('returnModal').classList.add('hidden');
        }

        function openDetailModal(btn) {
            document.getElementById('detail_user_name').innerText = btn.getAttribute('data-user-name');
            document.getElementById('detail_user_email').innerText = btn.getAttribute('data-user-email');
            document.getElementById('detail_book_title').innerText = btn.getAttribute('data-book-title');
            document.getElementById('detail_guarantee').innerText = btn.getAttribute('data-guarantee');
            document.getElementById('detail_borrow_date').innerText = btn.getAttribute('data-borrow-date');
            document.getElementById('detail_return_date').innerText = btn.getAttribute('data-return-date');

            const status = btn.getAttribute('data-status');
            const statusContainer = document.getElementById('detail_status_container');

            let badgeHtml = '';
            if (status === 'menunggu_persetujuan') {
                badgeHtml =
                    '<span class="inline-flex bg-orange-100 text-orange-600 px-3 py-1 rounded-md text-[11px] font-bold uppercase tracking-wider">Menunggu ACC</span>';
            } else if (status === 'dipinjam') {
                badgeHtml =
                    '<span class="inline-flex bg-blue-100 text-blue-600 px-3 py-1 rounded-md text-[11px] font-bold uppercase tracking-wider">Sedang Dibaca</span>';
            } else if (status === 'menunggu_pengembalian') {
                badgeHtml =
                    '<span class="inline-flex bg-purple-100 text-purple-600 px-3 py-1 rounded-md text-[11px] font-bold uppercase tracking-wider">Minta Kembali</span>';
            } else if (status === 'dikembalikan') {
                badgeHtml =
                    '<span class="inline-flex bg-emerald-100 text-emerald-600 px-3 py-1 rounded-md text-[11px] font-bold uppercase tracking-wider">Selesai</span>';
            } else {
                badgeHtml =
                    '<span class="inline-flex bg-red-100 text-red-600 px-3 py-1 rounded-md text-[11px] font-bold uppercase tracking-wider">Ditolak</span>';
            }

            statusContainer.innerHTML = badgeHtml;
            document.getElementById('detailModal').classList.remove('hidden');
        }

        function closeDetailModal() {
            document.getElementById('detailModal').classList.add('hidden');
        }
    </script>
@endpush
