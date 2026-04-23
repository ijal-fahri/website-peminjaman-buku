@extends('layouts.user')

@section('title', 'Dashboard Saya - RuangBaca')

@section('content')

<!-- Welcome Card Premium (Tema Emerald/Teal) -->
<div class="rounded-[2.5rem] bg-gradient-to-br from-secondary via-teal-600 to-teal-800 p-8 sm:p-12 mb-10 relative overflow-hidden shadow-2xl shadow-teal-200/50">
    <!-- Efek Dekorasi Abstrak -->
    <div class="absolute top-0 right-0 -mr-20 -mt-20 w-80 h-80 rounded-full bg-white/10 blur-3xl mix-blend-overlay pointer-events-none"></div>
    <div class="absolute bottom-0 right-40 w-48 h-48 rounded-full bg-green-300/20 blur-3xl pointer-events-none"></div>
    <div class="absolute top-1/2 left-1/4 w-32 h-32 rounded-full bg-white/5 blur-xl pointer-events-none"></div>
    
    <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-8 text-center md:text-left">
        <div class="text-white max-w-2xl">
            <span class="inline-flex items-center gap-1.5 py-1.5 px-3.5 rounded-full bg-white/20 text-white text-[11px] font-bold tracking-widest mb-6 backdrop-blur-md border border-white/20 shadow-sm uppercase">
                <span class="w-1.5 h-1.5 rounded-full bg-yellow-300 animate-pulse"></span>
                Halo Member RuangBaca
            </span>
            <h1 class="text-4xl sm:text-5xl font-extrabold text-white mb-4 tracking-tight leading-tight">
                Selamat Datang, {{ explode(' ', Auth::user()->name)[0] }}! 📚
            </h1>
            <p class="text-teal-100 text-lg leading-relaxed font-medium mb-8">
                Mulai atau lanjutkan petualangan membacamu hari ini. Dari buku fiksi hingga sains, temukan dunia baru dalam genggamanmu.
            </p>
            
            <div class="flex flex-col sm:flex-row items-center gap-4">
                <!-- PERBAIKAN: Mengarah ke halaman Jelajah Buku yang benar -->
                <a href="{{ route('user.books.index') }}" class="w-full sm:w-auto bg-white text-secondary px-8 py-3.5 rounded-2xl font-extrabold hover:bg-gray-50 transition-all shadow-xl flex items-center justify-center gap-2 transform hover:-translate-y-1 hover:shadow-secondary/50">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    Cari Buku Baru
                </a>
                <!-- PERBAIKAN: Menggulir (scroll) ke riwayat peminjaman di bawah -->
                <a href="#riwayat-peminjaman" class="w-full sm:w-auto bg-teal-700/50 backdrop-blur-md border border-teal-500/50 text-white px-8 py-3.5 rounded-2xl font-bold hover:bg-teal-700 transition-all flex items-center justify-center">
                    Lihat Peminjaman
                </a>
            </div>
        </div>

        <!-- Ilustrasi/Gambar Kanan -->
        <div class="hidden lg:block shrink-0">
            <div class="w-48 h-48 bg-white/10 backdrop-blur-sm border-2 border-white/20 rounded-full flex items-center justify-center p-8 shadow-2xl relative animate-[bounce_4s_infinite]">
                <div class="absolute inset-0 bg-gradient-to-tr from-emerald-400 to-transparent rounded-full opacity-50 blur-lg"></div>
                <svg class="w-full h-full text-white relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Dashboard Stats Grid untuk User -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
    <!-- Stat 1: Sedang Dipinjam -->
    <div class="bg-white p-8 rounded-[2rem] border border-gray-200 shadow-md hover:shadow-xl hover:shadow-orange-100/40 transition-all duration-300 transform hover:-translate-y-1 group cursor-default">
        <div class="flex justify-between items-start mb-6">
            <div class="w-16 h-16 bg-orange-50 text-orange-500 rounded-2xl flex items-center justify-center group-hover:bg-orange-500 group-hover:text-white transition-colors duration-300 shadow-sm">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
            </div>
            <span class="flex items-center text-xs font-bold text-gray-500 bg-gray-100 px-3 py-1.5 rounded-lg border border-gray-200">
                Aktivitas Berjalan
            </span>
        </div>
        <div>
            <!-- DATA ASLI -->
            <h3 class="text-4xl font-black text-gray-800 mb-1 tracking-tight">{{ $activeCount }}</h3>
            <p class="text-sm font-bold text-gray-400">Sedang Anda Pinjam</p>
        </div>
    </div>

    <!-- Stat 2: Selesai Dibaca -->
    <div class="bg-white p-8 rounded-[2rem] border border-gray-200 shadow-md hover:shadow-xl hover:shadow-emerald-100/40 transition-all duration-300 transform hover:-translate-y-1 group cursor-default">
        <div class="flex justify-between items-start mb-6">
            <div class="w-16 h-16 bg-emerald-50 text-secondary rounded-2xl flex items-center justify-center group-hover:bg-secondary group-hover:text-white transition-colors duration-300 shadow-sm">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <span class="flex items-center text-xs font-bold text-emerald-600 bg-emerald-50 border border-emerald-100 px-3 py-1.5 rounded-lg">
                Hebat!
            </span>
        </div>
        <div>
            <!-- DATA ASLI -->
            <h3 class="text-4xl font-black text-gray-800 mb-1 tracking-tight">{{ $doneCount }}</h3>
            <p class="text-sm font-bold text-gray-400">Total Buku Selesai Dibaca</p>
        </div>
    </div>

    <!-- Stat 3: Total Denda -->
    <div class="bg-white p-8 rounded-[2rem] border border-gray-200 shadow-md hover:shadow-xl hover:shadow-red-100/40 transition-all duration-300 transform hover:-translate-y-1 group cursor-default">
        <div class="flex justify-between items-start mb-6">
            <div class="w-16 h-16 {{ $totalFine > 0 ? 'bg-red-50 text-red-500 group-hover:bg-red-500' : 'bg-emerald-50 text-emerald-500 group-hover:bg-emerald-500' }} rounded-2xl flex items-center justify-center group-hover:text-white transition-colors duration-300 shadow-sm">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            @if($totalFine > 0)
                <span class="flex items-center text-xs font-bold text-red-600 bg-red-50 border border-red-100 px-3 py-1.5 rounded-lg">Harus Dibayar</span>
            @else
                <span class="flex items-center text-xs font-bold text-emerald-600 bg-emerald-50 border border-emerald-100 px-3 py-1.5 rounded-lg">Aman!</span>
            @endif
        </div>
        <div>
            <!-- DATA DENDA ASLI -->
            <h3 class="text-3xl lg:text-4xl font-black text-gray-800 mb-1 tracking-tight">Rp {{ number_format($totalFine, 0, ',', '.') }}</h3>
            <p class="text-sm font-bold text-gray-400">Total Tagihan Denda</p>
            
            <!-- TOMBOL BAYAR DENDA (HANYA JIKA ADA DENDA) -->
            @if($totalFine > 0)
                <button onclick="openPaymentModal({{ $totalFine }})" class="mt-4 w-full bg-red-500 hover:bg-red-600 text-white px-4 py-2.5 rounded-xl text-sm font-bold transition-all shadow-md shadow-red-500/30 transform active:scale-95">
                    Bayar Denda Sekarang
                </button>
            @endif
        </div>
    </div>
</div>

<!-- Riwayat Peminjaman User Asli -->
<!-- PERBAIKAN: Menambahkan id="riwayat-peminjaman" dan scroll-mt-24 agar scroll pas dengan navbar -->
<div id="riwayat-peminjaman" class="bg-slate-100 rounded-[2rem] shadow-xl border border-gray-300 overflow-hidden mb-8 relative scroll-mt-24">
    <div class="px-8 py-8 border-b border-gray-200 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white relative z-10">
        <div>
            <h3 class="font-extrabold text-2xl text-gray-900 tracking-tight">Peminjaman Terbaru</h3>
            <p class="text-sm font-medium text-gray-500 mt-1">Aktivitas peminjaman dan pengembalian buku terakhir Anda.</p>
        </div>
        <!-- Tombol Lihat Semua -->
        <a href="{{ route('user.borrows.history') }}" class="shrink-0 text-sm font-bold text-secondary hover:text-emerald-800 bg-emerald-50 hover:bg-emerald-100 px-5 py-2.5 rounded-xl transition-all shadow-sm transform hover:-translate-y-0.5 flex items-center gap-2">
            Lihat Semua
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
        </a>
    </div>
    
    <!-- Latar belakang abu-abu pekat agar kartu putih sangat menonjol -->
    <div class="overflow-x-auto p-6 sm:p-8 relative z-0">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            
            <!-- Looping Data Asli dibatasi maksimal 4 -->
            @forelse($borrows->take(4) as $borrow)
            
            <!-- Pewarnaan Border Kiri Berdasarkan Status -->
            @php
                $borderLeftColor = 'border-l-gray-300';
                if($borrow->status == 'menunggu_persetujuan') $borderLeftColor = 'border-l-orange-400';
                elseif($borrow->status == 'dipinjam') $borderLeftColor = 'border-l-blue-500';
                elseif($borrow->status == 'menunggu_pengembalian') $borderLeftColor = 'border-l-purple-500';
                elseif($borrow->status == 'dikembalikan') $borderLeftColor = 'border-l-emerald-500';
                elseif($borrow->status == 'ditolak') $borderLeftColor = 'border-l-red-500';
            @endphp

            <!-- Peningkatan visibilitas maksimal: bg-white solid, shadow-xl, border-l tebal -->
            <div class="flex flex-col p-6 border border-gray-200 border-l-[8px] {{ $borderLeftColor }} shadow-xl rounded-2xl hover:shadow-2xl hover:-translate-y-1.5 transition-all duration-300 bg-white relative ring-1 ring-gray-900/5">
                
                <div class="flex items-start sm:items-center gap-6">
                    <!-- Cover Buku dengan ukuran sedikit lebih besar dan shadow kuat -->
                    <div class="w-20 h-28 sm:w-24 sm:h-36 bg-gray-200 rounded-xl overflow-hidden shrink-0 shadow-lg border border-gray-100">
                        @if($borrow->book->cover_url)
                            <img src="{{ str_starts_with($borrow->book->cover_url, 'http') ? $borrow->book->cover_url : asset('storage/' . $borrow->book->cover_url) }}" class="w-full h-full object-cover">
                        @endif
                    </div>
                    <div class="flex-1 w-full min-w-0"> <!-- Tambahkan min-w-0 agar teks panjang bisa truncate -->
                        
                        <!-- Header Kartu: Judul dan ID Transaksi -->
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
                        
                        <!-- Format Tanggal dengan Ikon -->
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
                            <!-- Status Badge yang Dinamis -->
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
                                <!-- Badge Status Baru -->
                                <span class="inline-flex items-center gap-1.5 bg-purple-50 text-purple-600 px-3 py-1.5 rounded-md text-[11px] font-bold uppercase tracking-wider border border-purple-100">
                                    <span class="w-1.5 h-1.5 rounded-full bg-purple-500 animate-pulse"></span> Verifikasi Pengembalian
                                </span>
                            @elseif($borrow->status == 'dikembalikan')
                                <span class="inline-flex items-center gap-1.5 bg-emerald-50 text-secondary border border-emerald-100 px-3 py-1.5 rounded-md text-[11px] font-bold uppercase tracking-wider">
                                    Selesai
                                </span>
                                <!-- TAMPILKAN JIKA ADA DENDA PADA BUKU INI -->
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

                <!-- JIKA DITOLAK, MUNCULKAN ALASAN DARI ADMIN! -->
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
            <div class="col-span-full py-12 text-center border border-gray-200 bg-white shadow-md rounded-3xl">
                <div class="w-20 h-20 bg-indigo-50 text-primary rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
                <p class="text-gray-900 font-extrabold text-xl mb-2">Belum Ada Riwayat Peminjaman</p>
                <p class="text-gray-500 font-medium text-sm mb-6 max-w-md mx-auto">Anda belum pernah meminjam buku. Yuk, mulai menjelajahi koleksi kami dan mulai membaca sekarang!</p>
                <a href="{{ route('user.books.index') }}" class="inline-block bg-primary text-white px-8 py-3 rounded-2xl font-bold shadow-lg shadow-primary/30 hover:bg-indigo-700 transition-all transform hover:-translate-y-1">Mulai Pinjam Buku</a>
            </div>
            @endforelse

        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
    function confirmReturn(id, title) {
        Swal.fire({
            title: 'Kembalikan Buku?',
            text: "Anda akan mengembalikan buku '" + title + "'. Pastikan Anda segera menyerahkan buku fisiknya ke petugas perpustakaan.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#4F46E5', // Warna Primary (Indigo)
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

    // MODAL PEMBAYARAN DENDA
    function openPaymentModal(maxAmount) {
        Swal.fire({
            title: 'Pembayaran Denda',
            html: `
                <div class="text-left">
                    <p class="text-sm text-gray-600 mb-3">Masukkan nominal yang ingin Anda bayarkan. Maksimal: <strong>Rp ${new Intl.NumberFormat('id-ID').format(maxAmount)}</strong></p>
                    <div class="mb-4">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Nominal Pembayaran</label>
                        <input type="number" id="paymentAmount" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-indigo-500" placeholder="Rp" min="1" max="${maxAmount}">
                    </div>
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 text-sm text-blue-800">
                        💡 Anda tidak dapat membuat peminjaman baru hingga semua denda terbayar.
                    </div>
                </div>
            `,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#EF4444', // Red
            cancelButtonColor: '#9ca3af',
            confirmButtonText: 'Bayar Sekarang',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            customClass: { popup: 'rounded-3xl' },
            preConfirm: () => {
                const amount = document.getElementById('paymentAmount').value;
                if (!amount || amount <= 0 || amount > maxAmount) {
                    Swal.showValidationMessage('Masukkan nominal yang valid (1 - ' + maxAmount + ')');
                    return false;
                }
                return amount;
            }
        }).then((result) => {
            if (result.isConfirmed) {
                processPayment(result.value);
            }
        });
    }

    function processPayment(amount) {
        // Show loading
        Swal.fire({
            title: 'Memproses Pembayaran...',
            allowOutsideClick: false,
            allowEscapeKey: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        // Submit payment via fetch
        fetch('{{ route("user.pay-fine") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                amount: parseInt(amount)
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    title: 'Pembayaran Berhasil!',
                    text: data.message,
                    icon: 'success',
                    confirmButtonColor: '#10B981'
                }).then(() => {
                    location.reload();
                });
            } else {
                Swal.fire({
                    title: 'Pembayaran Gagal',
                    text: data.message,
                    icon: 'error',
                    confirmButtonColor: '#EF4444'
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                title: 'Terjadi Kesalahan',
                text: 'Silakan coba lagi',
                icon: 'error',
                confirmButtonColor: '#EF4444'
            });
        });
    }
</script>
@endpush