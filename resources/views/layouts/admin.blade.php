<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel - RuangBaca')</title>

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
                        primary: '#4F46E5', // Indigo 600
                        secondary: '#10B981', // Emerald 500
                        sidebar: '#1e1e2d', // Warna gelap khusus sidebar
                    }
                }
            }
        }
    </script>

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @stack('styles')
</head>

<body class="font-sans antialiased bg-[#F4F7FE] text-gray-800 overflow-hidden">

    <div class="flex h-screen w-full">
        <!-- Sidebar (Kiri) -->
        <!-- Overlay untuk mobile -->
        <div id="sidebar-overlay"
            class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-40 hidden lg:hidden transition-opacity"
            onclick="toggleSidebar()"></div>

        <!-- Sidebar Container -->
        <aside id="sidebar"
            class="fixed inset-y-0 left-0 z-50 w-[260px] bg-sidebar text-slate-300 transform -translate-x-full lg:translate-x-0 lg:static lg:block transition-transform duration-300 ease-in-out shadow-2xl flex flex-col">

            <!-- Logo area -->
            <div class="flex items-center h-20 px-6 pt-2">
                <div class="flex items-center gap-3 cursor-pointer" onclick="window.location='{{ url('/') }}'">
                    <div
                        class="w-9 h-9 bg-primary rounded-lg flex items-center justify-center font-bold text-white shadow-lg shadow-primary/40">
                        RB</div>
                    <span class="font-bold text-xl tracking-tight text-white">Admin<span
                            class="text-primary">Panel</span></span>
                </div>
            </div>

            <!-- Menu Links -->
            <div class="flex-1 overflow-y-auto py-6 mt-2">
                <nav class="px-4 space-y-1.5">
                    <!-- Link Dashboard -->
                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center gap-3 px-4 py-3.5 rounded-xl {{ request()->routeIs('admin.dashboard') ? 'bg-primary text-white shadow-md shadow-primary/30' : 'text-slate-400 hover:bg-white/5 hover:text-white' }} font-medium transition-all group">
                        <svg class="w-5 h-5 {{ request()->routeIs('admin.dashboard') ? '' : 'group-hover:text-primary transition-colors' }}"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                            </path>
                        </svg>
                        Dashboard
                    </a>

                    <!-- Link Kelola Kategori -->
                    <a href="{{ route('admin.categories.index') }}"
                        class="flex items-center gap-3 px-4 py-3.5 rounded-xl {{ request()->routeIs('admin.categories.*') ? 'bg-primary text-white shadow-md shadow-primary/30' : 'text-slate-400 hover:bg-white/5 hover:text-white' }} font-medium transition-all group">
                        <svg class="w-5 h-5 {{ request()->routeIs('admin.categories.*') ? '' : 'group-hover:text-primary transition-colors' }}"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                            </path>
                        </svg>
                        Kategori Buku
                    </a>

                    <!-- Link Kelola Buku -->
                    <a href="{{ route('admin.books.index') }}"
                        class="flex items-center gap-3 px-4 py-3.5 rounded-xl {{ request()->routeIs('admin.books.*') ? 'bg-primary text-white shadow-md shadow-primary/30' : 'text-slate-400 hover:bg-white/5 hover:text-white' }} font-medium transition-all group">
                        <svg class="w-5 h-5 {{ request()->routeIs('admin.books.*') ? '' : 'group-hover:text-primary transition-colors' }}"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                            </path>
                        </svg>
                        Kelola Buku
                    </a>

                    <!-- Link Kelola Pengguna -->
                    <a href="{{ route('admin.users.index') }}"
                        class="flex items-center gap-3 px-4 py-3.5 rounded-xl {{ request()->routeIs('admin.users.*') ? 'bg-primary text-white shadow-md shadow-primary/30' : 'text-slate-400 hover:bg-white/5 hover:text-white' }} font-medium transition-all group">
                        <svg class="w-5 h-5 {{ request()->routeIs('admin.users.*') ? '' : 'group-hover:text-secondary transition-colors' }}"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                        Pengguna
                    </a>

                    <!-- Link Transaksi Peminjaman -->
                    <a href="{{ route('admin.borrows.index') }}"
                        class="flex items-center gap-3 px-4 py-3.5 rounded-xl {{ request()->routeIs('admin.borrows.index') ? 'bg-primary text-white shadow-md shadow-primary/30' : 'text-slate-400 hover:bg-white/5 hover:text-white' }} font-medium transition-all group">
                        <svg class="w-5 h-5 {{ request()->routeIs('admin.borrows.index') ? '' : 'group-hover:text-orange-400 transition-colors' }}"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                            </path>
                        </svg>
                        Peminjaman
                    </a>

                    <!-- Link Riwayat Peminjaman -->
                    <a href="{{ route('admin.borrows.history') }}"
                        class="flex items-center gap-3 px-4 py-3.5 rounded-xl {{ request()->routeIs('admin.borrows.history') ? 'bg-primary text-white shadow-md shadow-primary/30' : 'text-slate-400 hover:bg-white/5 hover:text-white' }} font-medium transition-all group">
                        <svg class="w-5 h-5 {{ request()->routeIs('admin.borrows.history') ? '' : 'group-hover:text-purple-400 transition-colors' }}"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Riwayat
                    </a>
                </nav>
            </div>

            <!-- Footer Sidebar (Copyright) -->
            <div class="p-6 text-center border-t border-white/5">
                <p class="text-xs text-slate-500 font-medium">&copy; {{ date('Y') }} RuangBaca</p>
            </div>
        </aside>

        <!-- Area Konten Utama (Kanan) -->
        <div class="flex-1 flex flex-col h-screen overflow-hidden">

            <!-- Header Atas -->
            <header
                class="bg-white h-[84px] flex items-center justify-between px-6 sm:px-10 z-10 shrink-0 sticky top-0 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)]">

                <!-- Kiri: Hamburger & Title -->
                <div class="flex items-center gap-4">
                    <button onclick="toggleSidebar()"
                        class="lg:hidden p-2 -ml-2 rounded-xl text-gray-500 hover:text-primary hover:bg-indigo-50 focus:outline-none transition-colors">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <div class="hidden lg:block">
                        <h2 class="text-[1.15rem] font-medium text-gray-700 tracking-wide">@yield('header_title', 'Dashboard')</h2>
                    </div>
                </div>

                <!-- Kanan: Dropdown Profil & Logout -->
                <div class="relative" id="profile-menu-container">

                    <!-- Tombol Profil -->
                    <button onclick="toggleProfileMenu()" class="flex items-center gap-3 focus:outline-none group">
                        <div class="text-right hidden sm:block">
                            <p
                                class="text-sm font-bold text-gray-800 leading-tight group-hover:text-primary transition-colors">
                                {{ Auth::user()->name }}</p>
                            <p class="text-xs font-semibold text-gray-500">Administrator</p>
                        </div>

                        <!-- Avatar Bulat -->
                        <div
                            class="w-10 h-10 rounded-full bg-indigo-50 text-primary font-bold text-lg flex items-center justify-center border border-indigo-100 group-hover:ring-2 group-hover:ring-primary/40 transition-all shadow-sm overflow-hidden">
                            @if (Auth::user()->avatar)
                                <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar"
                                    class="w-full h-full object-cover">
                            @else
                                {{ substr(Auth::user()->name, 0, 1) }}
                            @endif
                        </div>

                        <svg class="w-4 h-4 text-gray-400 group-hover:text-primary transition-colors hidden sm:block"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </button>

                    <!-- Dropdown Menu -->
                    <div id="profile-dropdown"
                        class="absolute right-0 mt-3 w-56 bg-white rounded-xl shadow-[0_10px_40px_-10px_rgba(0,0,0,0.1)] border border-gray-100 py-2 hidden z-50 transform origin-top-right transition-all">

                        <div class="px-4 py-3 border-b border-gray-50 sm:hidden">
                            <p class="text-sm font-bold text-gray-800">{{ Auth::user()->name }}</p>
                            <p class="text-xs font-semibold text-primary">Administrator</p>
                        </div>

                        <a href="{{ route('admin.profile.edit') }}"
                            class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-gray-600 hover:bg-indigo-50 hover:text-primary transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Profil Saya
                        </a>

                        <div class="h-px bg-gray-100 my-1.5"></div>

                        <!-- Tombol Logout -->
                        <button type="button" onclick="confirmLogout(event)"
                            class="w-full text-left flex items-center gap-3 px-4 py-2.5 text-sm font-bold text-red-600 hover:bg-red-50 cursor-pointer transition-colors">
                            <svg class="w-4 h-4 pointer-events-none" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                </path>
                            </svg>
                            Keluar Sistem
                        </button>
                    </div>

                    <!-- Form Logout -->
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                        @csrf
                    </form>

                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto p-4 sm:p-8">
                <div class="max-w-7xl mx-auto">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        // Fitur Toggle Sidebar (Mobile)
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');

            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        // Fitur Toggle Dropdown Profil
        function toggleProfileMenu() {
            const menu = document.getElementById('profile-dropdown');
            menu.classList.toggle('hidden');
        }

        // Menutup Dropdown Profil jika mengklik di luar areanya
        document.addEventListener('click', function(event) {
            const container = document.getElementById('profile-menu-container');
            const menu = document.getElementById('profile-dropdown');
            if (!container.contains(event.target)) {
                menu.classList.add('hidden');
            }
        });

        // Fitur SweetAlert2 Konfirmasi Logout
        function confirmLogout(e) {
            if (e) e.preventDefault();

            document.getElementById('profile-dropdown').classList.add('hidden');

            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Keluar dari Sistem?',
                    text: "Anda akan diminta login kembali untuk mengakses panel ini.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#4F46E5',
                    cancelButtonColor: '#ef4444',
                    confirmButtonText: 'Ya, Keluar',
                    cancelButtonText: 'Batal',
                    reverseButtons: true,
                    customClass: {
                        popup: 'rounded-2xl',
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('logout-form').submit();
                    }
                });
            } else {
                if (confirm('Apakah Anda yakin ingin keluar dari sistem?')) {
                    document.getElementById('logout-form').submit();
                }
            }
        }
    </script>

    @stack('scripts')
</body>

</html>
