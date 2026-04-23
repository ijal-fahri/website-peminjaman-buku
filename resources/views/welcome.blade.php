@extends('layouts.app')

@section('title', 'RuangBaca - Peminjaman Buku Digital')

@push('styles')
    <style>
        /* Mengaktifkan smooth scrolling yang sebelumnya ada di tag <html> */
        html {
            scroll-behavior: smooth;
        }
    </style>
@endpush

@section('content')
    <!-- Membungkus semua konten dalam div w-full agar layoutnya memanjang ke bawah -->
    <div class="w-full block">

        <!-- Navbar -->
        <nav class="fixed w-full z-50 bg-white/90 backdrop-blur-md shadow-sm transition-all duration-300" id="navbar">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-20">
                    <!-- Logo -->
                    <div class="flex-shrink-0 flex items-center gap-2 cursor-pointer">
                        <div
                            class="w-10 h-10 bg-primary text-white rounded-lg flex items-center justify-center font-bold text-xl shadow-lg shadow-primary/30">
                            RB
                        </div>
                        <span class="font-bold text-2xl text-dark tracking-tight">Ruang<span
                                class="text-primary">Baca</span></span>
                    </div>

                    <!-- Desktop Menu -->
                    <div class="hidden md:flex items-center space-x-8">
                        <a href="#beranda"
                            class="text-gray-600 hover:text-primary font-medium transition-colors">Beranda</a>
                        <a href="#fitur" class="text-gray-600 hover:text-primary font-medium transition-colors">Fitur</a>
                        <a href="#koleksi" class="text-gray-600 hover:text-primary font-medium transition-colors">Koleksi
                            Populer</a>

                        <div class="pl-4 border-l border-gray-200 flex space-x-4">
                            @if (Route::has('login'))
                                @auth
                                    @if (Auth::user()->role === 'admin')
                                        <a href="{{ route('admin.dashboard') }}"
                                            class="bg-dark text-white px-5 py-2.5 rounded-full font-medium hover:bg-gray-800 transition-all shadow-md">Dashboard
                                            Admin</a>
                                    @else
                                        <a href="{{ route('user.dashboard') }}"
                                            class="bg-primary text-white px-5 py-2.5 rounded-full font-medium hover:bg-indigo-700 transition-all shadow-md shadow-primary/30">Dashboard
                                            Saya</a>
                                    @endif
                                @else
                                    <a href="{{ route('login') }}"
                                        class="text-dark font-medium hover:text-primary px-4 py-2.5 transition-colors">Masuk</a>
                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}"
                                            class="bg-primary text-white px-5 py-2.5 rounded-full font-medium hover:bg-indigo-700 transition-all shadow-md shadow-primary/30">Daftar</a>
                                    @endif
                                @endauth
                            @endif
                        </div>
                    </div>

                    <!-- Mobile Menu Button -->
                    <div class="md:hidden flex items-center">
                        <button id="mobile-menu-btn" class="text-gray-600 hover:text-primary focus:outline-none p-2">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path id="menu-icon-open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16"></path>
                                <path id="menu-icon-close" class="hidden" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile Menu Panel -->
            <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-gray-100 absolute w-full shadow-lg">
                <div class="px-4 pt-2 pb-6 space-y-2">
                    <a href="#beranda"
                        class="block px-3 py-3 text-base font-medium text-gray-700 hover:text-primary hover:bg-indigo-50 rounded-md">Beranda</a>
                    <a href="#fitur"
                        class="block px-3 py-3 text-base font-medium text-gray-700 hover:text-primary hover:bg-indigo-50 rounded-md">Fitur</a>
                    <a href="#koleksi"
                        class="block px-3 py-3 text-base font-medium text-gray-700 hover:text-primary hover:bg-indigo-50 rounded-md">Koleksi
                        Populer</a>

                    <div class="mt-4 pt-4 border-t border-gray-200 flex flex-col gap-3">
                        @if (Route::has('login'))
                            @auth
                                @if (Auth::user()->role === 'admin')
                                    <a href="{{ route('admin.dashboard') }}"
                                        class="block text-center w-full bg-dark text-white px-5 py-3 rounded-xl font-medium">Dashboard
                                        Admin</a>
                                @else
                                    <a href="{{ route('user.dashboard') }}"
                                        class="block text-center w-full bg-primary text-white px-5 py-3 rounded-xl font-medium">Dashboard
                                        Saya</a>
                                @endif
                            @else
                                <a href="{{ route('login') }}"
                                    class="block text-center w-full border-2 border-primary text-primary px-5 py-3 rounded-xl font-medium">Masuk</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}"
                                        class="block text-center w-full bg-primary text-white px-5 py-3 rounded-xl font-medium">Daftar
                                        Sekarang</a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <section id="beranda" class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-8">
                    <!-- Text Content -->
                    <div class="w-full lg:w-1/2 text-center lg:text-left">
                        <div
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-indigo-50 text-primary font-medium text-sm mb-6 border border-indigo-100">
                            <span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span>
                            Platform Peminjaman Buku #1
                        </div>
                        <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight text-dark mb-6">
                            Jelajahi Dunia Lewat <span
                                class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-emerald-400">Ribuan
                                Buku</span> Berkualitas
                        </h1>
                        <p class="text-lg text-gray-600 mb-8 max-w-2xl mx-auto lg:mx-0 leading-relaxed">
                            Pinjam dan baca buku favoritmu kapan saja dan di mana saja. Dari fiksi hingga sains, kami
                            menyediakan literatur terbaik untuk menemani harimu.
                        </p>
                        <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4">
                            <a href="#koleksi"
                                class="w-full sm:w-auto px-8 py-4 bg-primary text-white rounded-xl font-semibold text-lg hover:bg-indigo-700 transition-all shadow-lg shadow-primary/30 flex items-center justify-center gap-2">
                                Mulai Membaca
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                </svg>
                            </a>
                            <a href="#fitur"
                                class="w-full sm:w-auto px-8 py-4 bg-white text-dark border border-gray-200 rounded-xl font-semibold text-lg hover:bg-gray-50 transition-all flex items-center justify-center">
                                Pelajari Lebih Lanjut
                            </a>
                        </div>
                    </div>

                    <!-- Hero Image/Illustration -->
                    <div class="w-full lg:w-1/2 relative">
                        <!-- Blob shape background -->
                        <div
                            class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[300px] h-[300px] md:w-[500px] md:h-[500px] bg-gradient-to-tr from-indigo-200 to-emerald-100 rounded-full blur-3xl opacity-50 -z-10">
                        </div>

                        <div
                            class="relative rounded-2xl overflow-hidden shadow-2xl transform lg:rotate-2 hover:rotate-0 transition-transform duration-500 border-4 border-white">
                            <img src="https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?q=80&w=1000&auto=format&fit=crop"
                                alt="Orang membaca buku di perpustakaan" class="w-full h-auto object-cover aspect-[4/3]">
                            <!-- Floating Badge -->
                            <div
                                class="absolute bottom-6 left-6 bg-white/90 backdrop-blur px-6 py-4 rounded-xl shadow-lg flex items-center gap-4">
                                <div
                                    class="w-12 h-12 bg-emerald-100 text-secondary rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 font-medium">Total Koleksi</p>
                                    <p class="text-xl font-bold text-dark">5,000+ Buku</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section id="fitur" class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold text-dark mb-4">Mengapa Memilih RuangBaca?</h2>
                    <p class="text-lg text-gray-600">Kami memberikan pengalaman meminjam buku yang modern, cepat, dan
                        efisien untuk mendukung minat bacamu.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Feature 1 -->
                    <div
                        class="bg-gray-50 rounded-2xl p-8 hover:shadow-xl hover:-translate-y-2 transition-all duration-300 border border-gray-100">
                        <div class="w-14 h-14 bg-indigo-100 text-primary rounded-xl flex items-center justify-center mb-6">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-dark mb-3">Pencarian Cerdas</h3>
                        <p class="text-gray-600">Temukan buku yang kamu inginkan dalam hitungan detik berdasarkan judul,
                            penulis, atau kategori spesifik.</p>
                    </div>

                    <!-- Feature 2 -->
                    <div
                        class="bg-gray-50 rounded-2xl p-8 hover:shadow-xl hover:-translate-y-2 transition-all duration-300 border border-gray-100">
                        <div
                            class="w-14 h-14 bg-emerald-100 text-secondary rounded-xl flex items-center justify-center mb-6">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-dark mb-3">Akses 24/7</h3>
                        <p class="text-gray-600">Perpustakaan tidak pernah tutup. Lakukan pemesanan buku secara online
                            kapanpun kamu punya waktu luang.</p>
                    </div>

                    <!-- Feature 3 -->
                    <div
                        class="bg-gray-50 rounded-2xl p-8 hover:shadow-xl hover:-translate-y-2 transition-all duration-300 border border-gray-100">
                        <div
                            class="w-14 h-14 bg-orange-100 text-orange-600 rounded-xl flex items-center justify-center mb-6">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-dark mb-3">Keamanan Data</h3>
                        <p class="text-gray-600">Sistem keamanan tingkat lanjut untuk memastikan data diri dan riwayat
                            peminjamanmu tetap rahasia dan aman.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Popular Books Section -->
        <section id="koleksi" class="py-20 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-4">
                    <div class="max-w-2xl">
                        <h2 class="text-3xl md:text-4xl font-bold text-dark mb-4">Koleksi Terpopuler</h2>
                        <p class="text-gray-600">Buku-buku yang paling banyak dipinjam oleh komunitas pembaca kami bulan
                            ini.</p>
                    </div>
                    <a href="#"
                        class="text-primary font-semibold hover:text-indigo-800 flex items-center gap-1 group">
                        Lihat Semua
                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </a>
                </div>

                <!-- Book Grid -->
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    <!-- Book Card 1 -->
                    <div
                        class="bg-white rounded-2xl p-4 shadow-sm hover:shadow-xl transition-shadow border border-gray-100 group relative">
                        <div
                            class="absolute top-6 right-6 bg-secondary text-white text-xs font-bold px-2 py-1 rounded-md z-10">
                            Tersedia</div>
                        <div class="aspect-[2/3] rounded-xl overflow-hidden mb-4 relative bg-gray-200">
                            <img src="https://images.unsplash.com/photo-1544947950-fa07a98d237f?q=80&w=600&auto=format&fit=crop"
                                alt="Buku"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <div
                                class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                <button
                                    class="bg-white text-dark px-4 py-2 rounded-lg font-medium transform translate-y-4 group-hover:translate-y-0 transition-all">Detail</button>
                            </div>
                        </div>
                        <div>
                            <p class="text-sm text-primary font-medium mb-1">Pengembangan Diri</p>
                            <h3 class="font-bold text-dark text-lg leading-snug mb-1 line-clamp-1">The Art of Thinking</h3>
                            <p class="text-gray-500 text-sm">Rolf Dobelli</p>
                        </div>
                    </div>

                    <!-- Book Card 2 -->
                    <div
                        class="bg-white rounded-2xl p-4 shadow-sm hover:shadow-xl transition-shadow border border-gray-100 group relative">
                        <div
                            class="absolute top-6 right-6 bg-secondary text-white text-xs font-bold px-2 py-1 rounded-md z-10">
                            Tersedia</div>
                        <div class="aspect-[2/3] rounded-xl overflow-hidden mb-4 relative bg-gray-200">
                            <img src="https://images.unsplash.com/photo-1589829085413-56de8ae18c73?q=80&w=600&auto=format&fit=crop"
                                alt="Buku"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <div
                                class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                <button
                                    class="bg-white text-dark px-4 py-2 rounded-lg font-medium transform translate-y-4 group-hover:translate-y-0 transition-all">Detail</button>
                            </div>
                        </div>
                        <div>
                            <p class="text-sm text-primary font-medium mb-1">Novel Fiksi</p>
                            <h3 class="font-bold text-dark text-lg leading-snug mb-1 line-clamp-1">Senja di Jakarta</h3>
                            <p class="text-gray-500 text-sm">Mochtar Lubis</p>
                        </div>
                    </div>

                    <!-- Book Card 3 -->
                    <div
                        class="bg-white rounded-2xl p-4 shadow-sm hover:shadow-xl transition-shadow border border-gray-100 group relative">
                        <div
                            class="absolute top-6 right-6 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-md z-10">
                            Dipinjam</div>
                        <div class="aspect-[2/3] rounded-xl overflow-hidden mb-4 relative bg-gray-200">
                            <img src="https://images.unsplash.com/photo-1629196914225-eb255dd530cb?q=80&w=600&auto=format&fit=crop"
                                alt="Buku"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 grayscale">
                        </div>
                        <div>
                            <p class="text-sm text-primary font-medium mb-1">Teknologi</p>
                            <h3 class="font-bold text-dark text-lg leading-snug mb-1 line-clamp-1">Clean Code</h3>
                            <p class="text-gray-500 text-sm">Robert C. Martin</p>
                        </div>
                    </div>

                    <!-- Book Card 4 -->
                    <div
                        class="bg-white rounded-2xl p-4 shadow-sm hover:shadow-xl transition-shadow border border-gray-100 group relative">
                        <div
                            class="absolute top-6 right-6 bg-secondary text-white text-xs font-bold px-2 py-1 rounded-md z-10">
                            Tersedia</div>
                        <div class="aspect-[2/3] rounded-xl overflow-hidden mb-4 relative bg-gray-200">
                            <img src="https://images.unsplash.com/photo-1592496431122-2349e0fbc666?q=80&w=600&auto=format&fit=crop"
                                alt="Buku"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <div
                                class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                <button
                                    class="bg-white text-dark px-4 py-2 rounded-lg font-medium transform translate-y-4 group-hover:translate-y-0 transition-all">Detail</button>
                            </div>
                        </div>
                        <div>
                            <p class="text-sm text-primary font-medium mb-1">Sejarah</p>
                            <h3 class="font-bold text-dark text-lg leading-snug mb-1 line-clamp-1">Sapiens</h3>
                            <p class="text-gray-500 text-sm">Yuval Noah Harari</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-dark text-white pt-16 pb-8 border-t border-gray-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                    <div class="col-span-1 md:col-span-2">
                        <div class="flex items-center gap-2 mb-4">
                            <div class="w-8 h-8 bg-primary rounded flex items-center justify-center font-bold text-sm">RB
                            </div>
                            <span class="font-bold text-xl tracking-tight">Ruang<span
                                    class="text-primary">Baca</span></span>
                        </div>
                        <p class="text-gray-400 max-w-sm mb-6">Membuka jendela dunia melalui perpustakaan digital terpadu.
                            Mari tingkatkan literasi bersama kami.</p>
                    </div>

                    <div>
                        <h4 class="font-bold text-lg mb-4">Tautan Cepat</h4>
                        <ul class="space-y-2">
                            <li><a href="#beranda" class="text-gray-400 hover:text-white transition-colors">Beranda</a>
                            </li>
                            <li><a href="#fitur" class="text-gray-400 hover:text-white transition-colors">Fitur
                                    Sistem</a></li>
                            <li><a href="#koleksi" class="text-gray-400 hover:text-white transition-colors">Koleksi
                                    Buku</a></li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="font-bold text-lg mb-4">Bantuan</h4>
                        <ul class="space-y-2">
                            <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Cara
                                    Meminjam</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Syarat &
                                    Ketentuan</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Hubungi
                                    Kami</a></li>
                        </ul>
                    </div>
                </div>

                <div class="pt-8 border-t border-gray-800 text-center text-gray-500 text-sm">
                    &copy; {{ date('Y') }} RuangBaca Digital. Dibuat dengan menggunakan Laravel.
                </div>
            </div>
        </footer>
    </div>
@endsection

@push('scripts')
    <!-- JavaScript untuk interaksi menu -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuBtn = document.getElementById('mobile-menu-btn');
            const mobileMenu = document.getElementById('mobile-menu');
            const iconOpen = document.getElementById('menu-icon-open');
            const iconClose = document.getElementById('menu-icon-close');
            const navbar = document.getElementById('navbar');

            // Toggle Mobile Menu
            mobileMenuBtn.addEventListener('click', function() {
                mobileMenu.classList.toggle('hidden');
                iconOpen.classList.toggle('hidden');
                iconClose.classList.toggle('hidden');
            });

            // Navbar shadow & size on scroll
            window.addEventListener('scroll', function() {
                if (window.scrollY > 20) {
                    navbar.classList.add('shadow-md', 'py-0');
                    navbar.classList.remove('py-2');
                } else {
                    navbar.classList.remove('shadow-md', 'py-0');
                    navbar.classList.add('py-2');
                }
            });

            // Close mobile menu when clicking outside or clicking a link
            document.querySelectorAll('#mobile-menu a').forEach(link => {
                link.addEventListener('click', () => {
                    mobileMenu.classList.add('hidden');
                    iconOpen.classList.remove('hidden');
                    iconClose.classList.add('hidden');
                });
            });
        });
    </script>
@endpush
