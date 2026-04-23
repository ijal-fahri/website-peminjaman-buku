<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Member Area - RuangBaca')</title>

    <!-- Fonts: Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    },
                    colors: {
                        primary: '#4F46E5', // Indigo
                        secondary: '#10B981', // Emerald (Warna khas user)
                        dark: '#1e293b', 
                    }
                }
            }
        }
    </script>

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @stack('styles')
</head>
<body class="font-sans antialiased bg-[#F8FAFC] text-gray-800 min-h-screen flex flex-col">

    <!-- Top Navigation -->
    <nav class="bg-white border-b border-gray-200 sticky top-0 z-50 shadow-sm transition-all">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-[72px] items-center">
                
                <!-- Kiri: Logo & Menu Utama -->
                <div class="flex items-center gap-8">
                    <!-- Logo -->
                    <div class="flex items-center gap-2 cursor-pointer group" onclick="window.location='{{ url('/') }}'">
                        <div class="w-9 h-9 bg-gradient-to-br from-secondary to-teal-500 rounded-xl flex items-center justify-center font-bold text-white shadow-lg shadow-secondary/40 group-hover:scale-105 transition-transform">RB</div>
                        <span class="font-bold text-xl tracking-tight text-gray-800">Ruang<span class="text-secondary">Baca</span></span>
                    </div>

                    <!-- Desktop Menu -->
                    <div class="hidden md:flex items-center space-x-1">
                        <a href="{{ route('user.dashboard') }}"
                            class="px-4 py-2 rounded-lg {{ request()->routeIs('user.dashboard') ? 'bg-emerald-50 text-secondary font-bold' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-50 font-medium' }} transition-colors">
                            Beranda
                        </a>
                        <a href="{{ route('user.books.index') }}"
                            class="px-4 py-2 rounded-lg {{ request()->routeIs('user.books.*') ? 'bg-emerald-50 text-secondary font-bold' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-50 font-medium' }} transition-colors">
                            Jelajah Buku
                        </a>
                        <!-- LINK MENU DIPERBARUI -->
                        <a href="{{ route('user.borrows.history') }}"
                            class="px-4 py-2 rounded-lg {{ request()->routeIs('user.borrows.history') ? 'bg-emerald-50 text-secondary font-bold' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-50 font-medium' }} transition-colors">
                            Peminjaman Saya
                        </a>
                    </div>
                </div>

                <!-- Kanan: Notifikasi & Profil -->
                <div class="flex items-center gap-2 sm:gap-4">
                    
                    <!-- Search Icon (Mobile) -->
                    <button class="p-2 text-gray-400 hover:text-secondary md:hidden">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </button>

                    <!-- Notifikasi -->
                    <button class="relative p-2 text-gray-400 hover:text-secondary transition-colors rounded-full hover:bg-gray-50">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        <span class="absolute top-1.5 right-1.5 block h-2.5 w-2.5 rounded-full bg-red-500 ring-2 ring-white"></span>
                    </button>
                    
                    <div class="h-8 w-px bg-gray-200 hidden sm:block mx-1"></div>

                    <!-- Dropdown Profil -->
                    <div class="relative" id="profile-menu-container">
                        <button onclick="toggleProfileMenu()" class="flex items-center gap-3 focus:outline-none group p-1 rounded-full hover:bg-gray-50 transition-colors">
                            <!-- Avatar -->
                            <div class="w-9 h-9 rounded-full bg-emerald-100 text-secondary font-bold flex items-center justify-center border border-emerald-200 shadow-sm overflow-hidden">
                                @if(Auth::user()->avatar)
                                    <img src="{{ asset('storage/' . Auth::user()->avatar) }}" class="w-full h-full object-cover">
                                @else
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                @endif
                            </div>
                            <!-- Nama (Desktop) -->
                            <div class="hidden md:block text-left mr-1">
                                <p class="text-sm font-bold text-gray-800 leading-tight group-hover:text-secondary transition-colors">{{ explode(' ', Auth::user()->name)[0] }}</p>
                            </div>
                            <svg class="w-4 h-4 text-gray-400 hidden md:block group-hover:text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <!-- Menu Dropdown -->
                        <div id="profile-dropdown" class="absolute right-0 mt-3 w-56 bg-white rounded-2xl shadow-[0_10px_40px_-10px_rgba(0,0,0,0.15)] border border-gray-100 py-2 hidden z-50 transform origin-top-right transition-all">
                            <div class="px-4 py-3 border-b border-gray-50 md:hidden">
                                <p class="text-sm font-bold text-gray-800">{{ Auth::user()->name }}</p>
                                <p class="text-xs font-semibold text-secondary">Member Aktif</p>
                            </div>
                            
                            <!-- LINK PROFIL DIPERBARUI DI SINI -->
                            <a href="{{ route('user.profile.edit') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-gray-600 hover:bg-emerald-50 hover:text-secondary transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                Profil Saya
                            </a>
                            <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-gray-600 hover:bg-emerald-50 hover:text-secondary transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg>
                                Buku Favorit
                            </a>
                            
                            <div class="h-px bg-gray-100 my-1.5"></div>
                            
                            <button type="button" onclick="confirmLogout(event)" class="w-full text-left flex items-center gap-3 px-4 py-2.5 text-sm font-bold text-red-600 hover:bg-red-50 cursor-pointer transition-colors">
                                <svg class="w-4 h-4 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                                Keluar
                            </button>
                        </div>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                            @csrf
                        </form>
                    </div>

                    <!-- Mobile Menu Button (Hamburger) -->
                    <button onclick="toggleMobileMenu()" class="md:hidden p-2 text-gray-500 hover:text-secondary focus:outline-none ml-1">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>

                </div>
            </div>
        </div>

        <!-- Mobile Menu (Drop-down) -->
        <div id="mobile-menu" class="md:hidden hidden bg-white border-t border-gray-100 shadow-lg absolute w-full">
            <div class="px-4 pt-2 pb-6 space-y-2">
                <a href="{{ route('user.dashboard') }}"
                    class="block px-4 py-3 rounded-xl {{ request()->routeIs('user.dashboard') ? 'bg-emerald-50 text-secondary font-bold' : 'text-gray-600 font-medium' }}">Beranda</a>
                <a href="{{ route('user.books.index') }}"
                    class="block px-4 py-3 rounded-xl {{ request()->routeIs('user.books.*') ? 'bg-emerald-50 text-secondary font-bold' : 'text-gray-600 font-medium hover:bg-gray-50' }}">Jelajah
                    Buku</a>
                <!-- LINK MENU MOBILE DIPERBARUI -->
                <a href="{{ route('user.borrows.history') }}"
                    class="block px-4 py-3 rounded-xl {{ request()->routeIs('user.borrows.history') ? 'bg-emerald-50 text-secondary font-bold' : 'text-gray-600 font-medium hover:bg-gray-50' }}">Peminjaman Saya</a>
            </div>
        </div>
    </nav>

    <!-- Main Content Area -->
    <main class="flex-grow w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 pb-16">
        @yield('content')
    </main>

    <!-- Footer Simple -->
    <footer class="bg-white border-t border-gray-200 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <p class="text-center text-sm text-gray-500 font-medium">&copy; {{ date('Y') }} RuangBaca. Selamat membaca!</p>
        </div>
    </footer>

    <script>
        // Toggle Dropdown Profil
        function toggleProfileMenu() {
            const menu = document.getElementById('profile-dropdown');
            menu.classList.toggle('hidden');
            document.getElementById('mobile-menu').classList.add('hidden'); // Tutup menu mobile jika profil dibuka
        }

        // Toggle Mobile Menu Navigation
        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
            document.getElementById('profile-dropdown').classList.add('hidden'); // Tutup profil jika menu mobile dibuka
        }

        // Klik di luar untuk menutup
        document.addEventListener('click', function(event) {
            const profileContainer = document.getElementById('profile-menu-container');
            const profileMenu = document.getElementById('profile-dropdown');
            if (!profileContainer.contains(event.target)) {
                profileMenu.classList.add('hidden');
            }
        });

        // Logout SweetAlert
        function confirmLogout(e) {
            if (e) e.preventDefault();
            document.getElementById('profile-dropdown').classList.add('hidden');

            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Akhiri sesi baca?',
                    text: "Pastikan Anda mengingat buku terakhir yang dibaca!",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#10B981', // Emerald
                    cancelButtonColor: '#ef4444',
                    confirmButtonText: 'Ya, Keluar',
                    cancelButtonText: 'Batal',
                    reverseButtons: true,
                    customClass: { popup: 'rounded-2xl' }
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('logout-form').submit();
                    }
                });
            } else {
                if (confirm('Apakah Anda yakin ingin keluar?')) {
                    document.getElementById('logout-form').submit();
                }
            }
        }
    </script>
    
    @stack('scripts')
</body>
</html>