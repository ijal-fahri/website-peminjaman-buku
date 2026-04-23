@extends('layouts.app')

@section('title', 'Masuk - RuangBaca')

@section('content')
<!-- Sisi Kiri: Gambar/Ilustrasi (Disembunyikan di layar kecil) -->
<div class="hidden lg:flex lg:w-1/2 bg-primary relative overflow-hidden items-center justify-center">
    <!-- Dekorasi Background -->
    <div class="absolute top-0 left-0 w-full h-full opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
    <div class="absolute -bottom-32 -left-32 w-96 h-96 bg-indigo-500 rounded-full mix-blend-multiply filter blur-2xl opacity-70"></div>
    <div class="absolute -top-32 -right-32 w-96 h-96 bg-blue-500 rounded-full mix-blend-multiply filter blur-2xl opacity-70"></div>

    <div class="relative z-10 text-center px-12 text-white">
        <div class="w-20 h-20 bg-white text-primary rounded-2xl flex items-center justify-center font-bold text-4xl shadow-2xl mx-auto mb-8 transform -rotate-6">
            RB
        </div>
        <h2 class="text-4xl font-bold mb-4">Selamat Datang Kembali!</h2>
        <p class="text-indigo-100 text-lg max-w-md mx-auto">
            Akses ribuan koleksi buku digital kami. Lanjutkan perjalanan literasimu bersama RuangBaca hari ini.
        </p>
    </div>
</div>

<!-- Sisi Kanan: Form Login -->
<div class="w-full lg:w-1/2 flex items-center justify-center p-8 sm:p-12">
    <div class="w-full max-w-md">
        <!-- Header Mobile (Tampil hanya di HP) -->
        <div class="lg:hidden text-center mb-10">
            <div class="w-16 h-16 bg-primary text-white rounded-xl flex items-center justify-center font-bold text-2xl shadow-lg mx-auto mb-4">
                RB
            </div>
            <h2 class="text-3xl font-bold text-dark">Ruang<span class="text-primary">Baca</span></h2>
        </div>

        <div class="text-left mb-10">
            <h1 class="text-3xl font-bold text-dark mb-2">Masuk ke Akunmu</h1>
            <p class="text-gray-500">Masukkan email dan password untuk melanjutkan.</p>
        </div>

        <!-- Pesan Error -->
        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-r-lg">
                <div class="flex items-center">
                    <svg class="h-5 w-5 text-red-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="text-red-700 font-medium text-sm">{{ $errors->first() }}</span>
                </div>
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST" class="space-y-6">
            @csrf
            
            <!-- Input Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Alamat Email</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                        </svg>
                    </div>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                        class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl focus:ring-primary focus:border-primary sm:text-sm transition-colors"
                        placeholder="nama@email.com">
                </div>
            </div>

            <!-- Input Password -->
            <div>
                <div class="flex items-center justify-between mb-2">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <a href="#" class="text-sm font-medium text-primary hover:text-indigo-800 transition-colors">Lupa Password?</a>
                </div>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <!-- Ubah pr-3 menjadi pr-12 agar teks tidak tertutup ikon -->
                    <input type="password" name="password" id="password" required
                        class="block w-full pl-10 pr-12 py-3 border border-gray-300 rounded-xl focus:ring-primary focus:border-primary sm:text-sm transition-colors"
                        placeholder="••••••••">
                    
                    <!-- Tombol Toggle Show/Hide Password -->
                    <button type="button" onclick="togglePassword('password', 'eye-icon')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-primary transition-colors focus:outline-none">
                        <svg id="eye-icon" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Remember Me (Opsional) -->
            <div class="flex items-center">
                <input id="remember-me" name="remember" type="checkbox" class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                <label for="remember-me" class="ml-2 block text-sm text-gray-700">
                    Ingat saya
                </label>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl shadow-md shadow-primary/30 text-sm font-bold text-white bg-primary hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-all transform active:scale-95">
                Masuk Sekarang
            </button>
        </form>

        <!-- Footer / Register Link -->
        <div class="mt-8 text-center text-sm text-gray-600">
            <p>Belum punya akun? 
                <a href="{{ route('register') }}" class="font-bold text-primary hover:text-indigo-800 transition-colors">Daftar di sini</a>
            </p>
            <div class="mt-6">
                <a href="{{ url('/') }}" class="inline-flex items-center text-gray-500 hover:text-dark transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function togglePassword(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        
        if (input.type === 'password') {
            input.type = 'text';
            // Ubah menjadi icon Mata Terbuka
            icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />';
        } else {
            input.type = 'password';
            // Ubah kembali menjadi icon Mata Tertutup (Eye Slash)
            icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />';
        }
    }
</script>
@endpush