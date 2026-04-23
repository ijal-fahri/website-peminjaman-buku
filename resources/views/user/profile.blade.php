@extends('layouts.user')

@section('title', 'Profil Saya - RuangBaca')

@section('content')

    <!-- Header Halaman -->
    <div class="mb-8 flex items-center gap-4">
        <div class="w-14 h-14 bg-emerald-100 text-secondary rounded-2xl flex items-center justify-center shadow-sm">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
        </div>
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Profil Saya</h1>
            <p class="text-sm font-medium text-gray-500 mt-1">Kelola informasi data diri, foto profil, dan kata sandi Anda.</p>
        </div>
    </div>

    <!-- Notifikasi Error Validasi -->
    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 p-5 mb-8 rounded-2xl shadow-sm flex items-start gap-3">
            <svg class="h-6 w-6 text-red-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <div>
                <h4 class="text-red-800 font-bold mb-1">Terdapat kesalahan pada input Anda:</h4>
                <ul class="text-red-700 font-medium text-sm list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <!-- Sisi Kiri: Kartu Identitas Profil -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-[2rem] shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden relative group">
                <!-- Header Card Gradient -->
                <div class="h-40 bg-gradient-to-br from-secondary via-teal-600 to-teal-800 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-40 h-40 bg-white/10 rounded-full blur-2xl -translate-y-1/2 translate-x-1/4"></div>
                    <div class="absolute bottom-0 left-0 w-24 h-24 bg-black/10 rounded-full blur-xl translate-y-1/2 -translate-x-1/4"></div>
                </div>

                <div class="px-8 pb-10 text-center relative z-10">
                    <!-- Avatar Menampilkan Foto atau Inisial -->
                    <div class="w-32 h-32 mx-auto -mt-16 rounded-full border-[6px] border-white shadow-xl bg-emerald-50 flex items-center justify-center text-5xl font-black text-secondary mb-5 transform group-hover:scale-105 transition-transform duration-500 overflow-hidden relative ring-1 ring-gray-100">
                        @if(Auth::user()->avatar)
                            <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Foto Profil" class="w-full h-full object-cover">
                        @else
                            {{ substr(Auth::user()->name, 0, 1) }}
                        @endif
                    </div>

                    <h3 class="text-2xl font-extrabold text-gray-900 tracking-tight mb-1">{{ Auth::user()->name }}</h3>
                    <p class="text-sm font-medium text-gray-500 mb-6">{{ Auth::user()->email }}</p>

                    <div class="flex justify-center items-center gap-3">
                        <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wider bg-emerald-50 text-secondary border border-emerald-100">
                            <span class="w-2 h-2 rounded-full bg-secondary animate-pulse"></span>
                            Member Aktif
                        </span>
                    </div>
                    
                    <div class="mt-8 pt-6 border-t border-gray-100">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Bergabung Sejak</p>
                        <p class="text-sm font-semibold text-gray-700 mt-1">{{ Auth::user()->created_at->translatedFormat('d F Y') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sisi Kanan: Form Ubah Profil -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-[2rem] shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden">
                <div class="p-8 border-b border-gray-100 flex items-center justify-between bg-white">
                    <div>
                        <h3 class="text-xl font-extrabold text-gray-900 tracking-tight">Perbarui Informasi</h3>
                        <p class="text-sm text-gray-500 mt-1 font-medium">Pastikan data diri Anda selalu valid dan terbaru.</p>
                    </div>
                </div>

                <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-8 bg-gray-50/30">
                    @csrf
                    @method('PUT')

                    <!-- Input Foto Profil -->
                    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:border-emerald-200 transition-colors">
                        <label class="block text-sm font-bold text-gray-800 mb-3">Ganti Foto Profil</label>
                        <div class="flex items-center gap-4">
                            <div class="flex-1">
                                <input type="file" name="avatar" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-3 file:px-6 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-emerald-50 file:text-secondary hover:file:bg-emerald-100 cursor-pointer transition-colors border border-gray-200 rounded-xl bg-gray-50 focus:outline-none">
                            </div>
                        </div>
                        <p class="text-xs font-medium text-gray-400 mt-3 flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-orange-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Format didukung: JPG, JPEG, PNG. Ukuran Maksimal 2MB.
                        </p>
                    </div>

                    <!-- Baris: Nama & Email -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-bold text-gray-800 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                            <input type="text" name="name" id="name" value="{{ old('name', Auth::user()->name) }}" required class="block w-full px-5 py-3.5 border border-gray-200 rounded-2xl focus:ring-secondary focus:border-secondary transition-colors bg-white text-sm font-semibold text-gray-800 shadow-sm">
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-bold text-gray-800 mb-2">Alamat Email <span class="text-red-500">*</span></label>
                            <input type="email" name="email" id="email" value="{{ old('email', Auth::user()->email) }}" required class="block w-full px-5 py-3.5 border border-gray-200 rounded-2xl focus:ring-secondary focus:border-secondary transition-colors bg-white text-sm font-semibold text-gray-800 shadow-sm">
                        </div>
                    </div>

                    <div class="relative py-4">
                        <div class="absolute inset-0 flex items-center" aria-hidden="true">
                            <div class="w-full border-t border-gray-200 border-dashed"></div>
                        </div>
                        <div class="relative flex justify-center">
                            <span class="bg-gray-50/50 px-4 text-sm font-bold text-gray-400 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                Keamanan Akun
                            </span>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm space-y-6">
                        <div>
                            <h4 class="text-base font-extrabold text-gray-900 tracking-tight mb-1">Ubah Kata Sandi</h4>
                            <p class="text-xs text-gray-500 font-medium">Kosongkan kedua kolom di bawah ini jika Anda tidak ingin mengubah kata sandi.</p>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <!-- Kata Sandi Baru -->
                            <div>
                                <label for="password" class="block text-sm font-bold text-gray-800 mb-2">Kata Sandi Baru</label>
                                <input type="password" name="password" id="password" class="block w-full px-5 py-3.5 border border-gray-200 rounded-xl focus:ring-secondary focus:border-secondary transition-colors bg-gray-50 focus:bg-white text-sm" placeholder="Minimal 8 karakter">
                            </div>

                            <!-- Konfirmasi Kata Sandi -->
                            <div>
                                <label for="password_confirmation" class="block text-sm font-bold text-gray-800 mb-2">Ketik Ulang Kata Sandi</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="block w-full px-5 py-3.5 border border-gray-200 rounded-xl focus:ring-secondary focus:border-secondary transition-colors bg-gray-50 focus:bg-white text-sm" placeholder="Ketik ulang kata sandi baru">
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 flex flex-col-reverse sm:flex-row justify-end gap-4">
                        <a href="{{ route('user.dashboard') }}" class="w-full sm:w-auto text-center px-8 py-3.5 rounded-xl border border-gray-200 text-sm font-bold text-gray-600 hover:bg-gray-50 focus:outline-none transition-colors">
                            Batal
                        </a>
                        <button type="submit" class="w-full sm:w-auto inline-flex justify-center items-center gap-2 rounded-xl border border-transparent shadow-lg shadow-emerald-500/30 px-8 py-3.5 bg-secondary text-sm font-bold text-white hover:bg-emerald-600 focus:outline-none transition-all transform active:scale-95">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 2500,
                customClass: {
                    popup: 'rounded-3xl'
                }
            });
        @endif
    </script>
@endpush