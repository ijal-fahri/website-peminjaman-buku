@extends('layouts.admin')

@section('title', 'Admin Dashboard - RuangBaca')

@section('header_title')
    <div class="flex items-center gap-3">
        <!-- Garis Aksen Vertikal -->
        <div class="w-1.5 h-6 bg-gradient-to-b from-primary to-indigo-400 rounded-full shadow-sm"></div>
        <!-- Teks dengan efek gradasi dan tebal -->
        <span
            class="text-xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-gray-800 to-gray-600 tracking-tight">
            Ringkasan Sistem
        </span>
        <span
            class="hidden sm:inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider bg-indigo-50 text-primary border border-indigo-100 shadow-sm ml-1">
            Dashboard
        </span>
    </div>
@endsection

@section('content')

    <!-- Welcome Card Premium dengan Gradasi -->
    <div
        class="rounded-[2rem] bg-gradient-to-br from-primary via-indigo-600 to-indigo-800 p-8 md:p-10 mb-8 relative overflow-hidden shadow-2xl shadow-indigo-200/50">
        <!-- Efek Dekorasi Abstrak (Kaca / Cahaya) -->
        <div
            class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 rounded-full bg-white/10 blur-3xl mix-blend-overlay pointer-events-none">
        </div>
        <div class="absolute bottom-0 right-32 w-40 h-40 rounded-full bg-blue-400/20 blur-2xl pointer-events-none"></div>
        <div class="absolute top-1/2 left-1/4 w-32 h-32 rounded-full bg-white/5 blur-xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
            <div class="text-white">
                <span
                    class="inline-flex items-center gap-1.5 py-1.5 px-3.5 rounded-full bg-white/20 text-white text-[10px] font-bold tracking-widest mb-4 backdrop-blur-md border border-white/20 shadow-sm uppercase">
                    <span class="w-1.5 h-1.5 rounded-full bg-green-400 animate-pulse"></span>
                    Sistem Aktif
                </span>
                <h1 class="text-3xl md:text-4xl font-extrabold text-white mb-3 tracking-tight">Selamat Datang,
                    {{ explode(' ', Auth::user()->name)[0] }}! 👋</h1>
                <p class="text-indigo-100 mb-6 max-w-xl text-base md:text-lg leading-relaxed font-medium">
                    Pantau perkembangan perpustakaan digital RuangBaca hari ini. Kelola koleksi buku dan aktivitas pengguna
                    dari satu tempat yang nyaman.
                </p>

                <div
                    class="inline-flex items-center bg-white/10 backdrop-blur-md border border-white/20 rounded-xl px-4 py-2.5 text-white shadow-sm">
                    <svg class="w-5 h-5 mr-2 text-indigo-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                        </path>
                    </svg>
                    <span class="text-sm font-semibold">{{ Auth::user()->email }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Dashboard Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Stat 1: Total Buku -->
        <div
            class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm hover:shadow-xl hover:shadow-indigo-100/40 transition-all duration-300 transform hover:-translate-y-1 group cursor-default">
            <div class="flex justify-between items-start mb-4">
                <div
                    class="w-14 h-14 bg-indigo-50 text-primary rounded-2xl flex items-center justify-center group-hover:bg-primary group-hover:text-white transition-colors duration-300 shadow-sm">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                        </path>
                    </svg>
                </div>
                <span
                    class="flex items-center text-xs font-bold text-emerald-600 bg-emerald-50 border border-emerald-100 px-2.5 py-1 rounded-md">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                    Update
                </span>
            </div>
            <div>
                <h3 class="text-3xl font-extrabold text-gray-800 mb-1 tracking-tight">{{ $totalBooks }}</h3>
                <p class="text-sm font-semibold text-gray-500">Total Buku Koleksi</p>
            </div>
        </div>

        <!-- Stat 2: Total Pengguna -->
        <div
            class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm hover:shadow-xl hover:shadow-emerald-100/40 transition-all duration-300 transform hover:-translate-y-1 group cursor-default">
            <div class="flex justify-between items-start mb-4">
                <div
                    class="w-14 h-14 bg-emerald-50 text-secondary rounded-2xl flex items-center justify-center group-hover:bg-secondary group-hover:text-white transition-colors duration-300 shadow-sm">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                        </path>
                    </svg>
                </div>
                <span
                    class="flex items-center text-xs font-bold text-emerald-600 bg-emerald-50 border border-emerald-100 px-2.5 py-1 rounded-md">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                    Real-time
                </span>
            </div>
            <div>
                <h3 class="text-3xl font-extrabold text-gray-800 mb-1 tracking-tight">{{ $totalUsers }}</h3>
                <p class="text-sm font-semibold text-gray-500">Total Member Terdaftar</p>
            </div>
        </div>

        <!-- Stat 3: Transaksi Aktif -->
        <div
            class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm hover:shadow-xl hover:shadow-orange-100/40 transition-all duration-300 transform hover:-translate-y-1 group cursor-default">
            <div class="flex justify-between items-start mb-4">
                <div
                    class="w-14 h-14 bg-orange-50 text-orange-500 rounded-2xl flex items-center justify-center group-hover:bg-orange-500 group-hover:text-white transition-colors duration-300 shadow-sm">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                </div>
                <span
                    class="flex items-center text-xs font-bold text-gray-600 bg-gray-100 border border-gray-200 px-2.5 py-1 rounded-md">
                    Hari ini
                </span>
            </div>
            <div>
                <h3 class="text-3xl font-extrabold text-gray-800 mb-1 tracking-tight">{{ $booksOnLoan }}</h3>
                <p class="text-sm font-semibold text-gray-500">Buku Sedang Dipinjam</p>
            </div>
        </div>

        <!-- Stat 4: Denda / Terlambat -->
        <div
            class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm hover:shadow-xl hover:shadow-red-100/40 transition-all duration-300 transform hover:-translate-y-1 group cursor-default">
            <div class="flex justify-between items-start mb-4">
                <div
                    class="w-14 h-14 bg-red-50 text-red-500 rounded-2xl flex items-center justify-center group-hover:bg-red-500 group-hover:text-white transition-colors duration-300 shadow-sm">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <span
                    class="flex items-center text-xs font-bold text-red-600 bg-red-50 border border-red-100 px-2.5 py-1 rounded-md">
                    Perlu Tindakan
                </span>
            </div>
            <div>
                <h3 class="text-3xl font-extrabold text-gray-800 mb-1 tracking-tight">{{ $overdueCount }}</h3>
                <p class="text-sm font-semibold text-gray-500">Terlambat Kembali</p>
            </div>
        </div>
    </div>

    <!-- Tabel Aktivitas Terbaru Dinamis -->
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-8 py-6 border-b border-gray-100 flex justify-between items-center bg-white">
            <div>
                <h3 class="font-extrabold text-xl text-gray-800 tracking-tight">Peminjaman Terbaru</h3>
                <p class="text-sm font-medium text-gray-500 mt-1">Daftar transaksi peminjaman buku yang baru saja terjadi.
                </p>
            </div>
            <a href="{{ route('admin.borrows.index') }}"
                class="text-sm font-bold text-primary hover:text-indigo-800 bg-indigo-50 hover:bg-indigo-100 px-4 py-2.5 rounded-xl transition-colors shadow-sm">Lihat
                Semua</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600">
                <thead class="text-xs text-gray-500 uppercase bg-gray-50/50">
                    <tr>
                        <th scope="col" class="px-8 py-5 font-bold tracking-wider">ID Transaksi</th>
                        <th scope="col" class="px-8 py-5 font-bold tracking-wider">Peminjam</th>
                        <th scope="col" class="px-8 py-5 font-bold tracking-wider">Buku</th>
                        <th scope="col" class="px-8 py-5 font-bold tracking-wider">Tanggal Pinjam</th>
                        <th scope="col" class="px-8 py-5 font-bold tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($recentBorrows as $borrow)
                        <tr class="bg-white hover:bg-gray-50 transition-colors">
                            <td class="px-8 py-5 font-bold text-gray-800 whitespace-nowrap">
                                #TRX-{{ str_pad($borrow->id, 3, '0', STR_PAD_LEFT) }}</td>
                            <td class="px-8 py-5 font-semibold text-gray-700">{{ $borrow->user->name }}</td>
                            <td class="px-8 py-5 font-bold text-primary">{{ $borrow->book->title }}</td>
                            <td class="px-8 py-5 font-medium">
                                {{ \Carbon\Carbon::parse($borrow->borrow_date)->translatedFormat('d M Y') }}</td>
                            <td class="px-8 py-5">
                                @php
                                    $statusColor = 'bg-gray-50 text-gray-600 border-gray-200';
                                    $dotColor = 'bg-gray-500';
                                    $statusText = ucwords(str_replace('_', ' ', $borrow->status));

                                    switch ($borrow->status) {
                                        case 'menunggu_persetujuan':
                                            $statusColor = 'bg-orange-50 text-orange-600 border-orange-200';
                                            $dotColor = 'bg-orange-500';
                                            break;
                                        case 'dipinjam':
                                            $statusColor = 'bg-blue-50 text-blue-600 border-blue-200';
                                            $dotColor = 'bg-blue-500';
                                            break;
                                        case 'menunggu_pengembalian':
                                            $statusColor = 'bg-yellow-50 text-yellow-600 border-yellow-200';
                                            $dotColor = 'bg-yellow-500';
                                            break;
                                        case 'dikembalikan':
                                            $statusColor = 'bg-emerald-50 text-emerald-600 border-emerald-200';
                                            $dotColor = 'bg-emerald-500';
                                            break;
                                        case 'terlambat':
                                            $statusColor = 'bg-red-50 text-red-600 border-red-200';
                                            $dotColor = 'bg-red-500';
                                            break;
                                        case 'ditolak':
                                            $statusColor = 'bg-gray-100 text-gray-600 border-gray-300';
                                            $dotColor = 'bg-gray-600';
                                            break;
                                    }
                                @endphp
                                <span
                                    class="inline-flex items-center gap-1.5 {{ $statusColor }} px-3 py-1.5 rounded-md text-[11px] font-bold uppercase tracking-wider">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $dotColor }}"></span>
                                    {{ $statusText }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-8 py-8 text-center text-gray-500 font-medium bg-gray-50/50">
                                <div class="flex flex-col items-center justify-center gap-2">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>Belum ada aktivitas peminjaman terbaru.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
