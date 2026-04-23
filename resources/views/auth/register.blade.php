@extends('layouts.app')

@section('title', 'Daftar - RuangBaca')

@section('content')
<!-- Sisi Kiri: Gambar/Ilustrasi (Disembunyikan di layar kecil) -->
<div class="hidden lg:flex lg:w-1/2 bg-primary relative overflow-hidden items-center justify-center">
    <!-- Dekorasi Background -->
    <div class="absolute top-0 left-0 w-full h-full opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
    <div class="absolute -bottom-32 -right-32 w-96 h-96 bg-emerald-500 rounded-full mix-blend-multiply filter blur-2xl opacity-50"></div>
    <div class="absolute -top-32 -left-32 w-96 h-96 bg-blue-500 rounded-full mix-blend-multiply filter blur-2xl opacity-50"></div>

    <div class="relative z-10 text-center px-12 text-white">
        <div class="w-20 h-20 bg-white text-primary rounded-2xl flex items-center justify-center font-bold text-4xl shadow-2xl mx-auto mb-8 transform rotate-3">
            RB
        </div>
        <h2 class="text-4xl font-bold mb-4">Bergabung Bersama Kami!</h2>
        <p class="text-indigo-100 text-lg max-w-md mx-auto">
            Buat akunmu sekarang dan dapatkan akses tanpa batas ke ribuan koleksi buku digital berkualitas dari seluruh dunia.
        </p>
    </div>
</div>

<!-- Sisi Kanan: Form Registrasi -->
<div class="w-full lg:w-1/2 flex items-center justify-center p-8 sm:p-12 overflow-y-auto">
    <div class="w-full max-w-md my-auto">
        <!-- Header Mobile (Tampil hanya di HP) -->
        <div class="lg:hidden text-center mb-10">
            <div class="w-16 h-16 bg-primary text-white rounded-xl flex items-center justify-center font-bold text-2xl shadow-lg mx-auto mb-4">
                RB
            </div>
            <h2 class="text-3xl font-bold text-dark">Ruang<span class="text-primary">Baca</span></h2>
        </div>

        <div class="text-left mb-8">
            <h1 class="text-3xl font-bold text-dark mb-2">Buat Akun Baru</h1>
            <p class="text-gray-500">Isi data di bawah ini untuk memulai petualangan membacamu.</p>
        </div>

        <!-- Pesan Error -->
        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-r-lg">
                <div class="flex">
                    <svg class="h-5 w-5 text-red-500 mr-2 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <ul class="text-red-700 font-medium text-sm list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <form action="{{ route('register.post') }}" method="POST" class="space-y-5">
            @csrf
            
            <!-- Input Nama -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required autofocus
                        class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl focus:ring-primary focus:border-primary sm:text-sm transition-colors"
                        placeholder="John Doe">
                </div>
            </div>

            <!-- Input Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Alamat Email</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                        </svg>
                    </div>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required
                        class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl focus:ring-primary focus:border-primary sm:text-sm transition-colors"
                        placeholder="nama@email.com">
                </div>
            </div>

            <!-- Input Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <!-- Ubah pr-3 menjadi pr-12 -->
                    <input type="password" name="password" id="password" required
                        class="block w-full pl-10 pr-12 py-3 border border-gray-300 rounded-xl focus:ring-primary focus:border-primary sm:text-sm transition-colors"
                        placeholder="Minimal 8 karakter">
                    
                    <!-- Tombol Toggle Show/Hide Password -->
                    <button type="button" onclick="togglePassword('password', 'eye-icon-pass')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-primary transition-colors focus:outline-none">
                        <svg id="eye-icon-pass" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Konfirmasi Password -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <!-- Ubah pr-3 menjadi pr-12 -->
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                        class="block w-full pl-10 pr-12 py-3 border border-gray-300 rounded-xl focus:ring-primary focus:border-primary sm:text-sm transition-colors"
                        placeholder="Ketik ulang password">
                        
                    <!-- Tombol Toggle Show/Hide Confirm Password -->
                    <button type="button" onclick="togglePassword('password_confirmation', 'eye-icon-confirm')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-primary transition-colors focus:outline-none">
                        <svg id="eye-icon-confirm" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl shadow-md shadow-primary/30 text-sm font-bold text-white bg-primary hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-all transform active:scale-95 mt-4">
                Daftar Sekarang
            </button>
        </form>

        <!-- Footer / Login Link -->
        <div class="mt-8 text-center text-sm text-gray-600">
            <p>Sudah punya akun? 
                <a href="{{ route('login') }}" class="font-bold text-primary hover:text-indigo-800 transition-colors">Masuk di sini</a>
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