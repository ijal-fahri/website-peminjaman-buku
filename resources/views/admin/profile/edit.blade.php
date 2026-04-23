@extends('layouts.admin')

@section('title', 'Profil Saya - RuangBaca')

@section('header_title')
    <div class="flex items-center gap-3">
        <div class="w-1.5 h-6 bg-gradient-to-b from-primary to-indigo-400 rounded-full shadow-sm"></div>
        <span class="text-xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-gray-800 to-gray-600 tracking-tight">
            Pengaturan Profil
        </span>
    </div>
@endsection

@section('content')

    <!-- Notifikasi Error Validasi -->
    @if ($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-r-xl shadow-sm">
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

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <!-- Sisi Kiri: Kartu Identitas Profil -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden relative group">
                <div class="h-32 bg-gradient-to-br from-primary via-indigo-600 to-indigo-800 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full blur-2xl -translate-y-1/2 translate-x-1/4"></div>
                </div>

                <div class="px-6 pb-8 text-center relative z-10">
                    <!-- Avatar Menampilkan Foto atau Inisial -->
                    <div class="w-24 h-24 mx-auto -mt-12 rounded-full border-4 border-white shadow-lg bg-indigo-50 flex items-center justify-center text-4xl font-extrabold text-primary mb-4 transform group-hover:scale-105 transition-transform duration-300 overflow-hidden">
                        @if($user->avatar)
                            <img src="{{ asset('storage/' . $user->avatar) }}" alt="Foto Profil" class="w-full h-full object-cover">
                        @else
                            {{ substr($user->name, 0, 1) }}
                        @endif
                    </div>

                    <h3 class="text-2xl font-extrabold text-gray-900 tracking-tight mb-1">{{ $user->name }}</h3>
                    <p class="text-sm font-medium text-gray-500 mb-5">{{ $user->email }}</p>

                    <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-xl text-[11px] font-bold uppercase tracking-wider bg-primary/10 text-primary border border-primary/20">
                        <span class="w-1.5 h-1.5 rounded-full bg-primary"></span>
                        Akun Aktif
                    </span>
                </div>
            </div>
        </div>

        <!-- Sisi Kanan: Form Ubah Profil -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 sm:p-8 border-b border-gray-100 flex items-center gap-4 bg-white">
                    <div class="p-3 bg-indigo-50 text-primary rounded-xl shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-extrabold text-gray-900 tracking-tight">Ubah Data Diri</h3>
                        <p class="text-sm text-gray-500 mt-1 font-medium">Perbarui informasi dasar, foto profil, dan kata sandi Anda.</p>
                    </div>
                </div>

                <!-- Formulir: PASTIKAN ADA enctype="multipart/form-data" -->
                <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8 space-y-6 bg-gray-50/20">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <!-- Input Foto Profil -->
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Foto Profil (Opsional)</label>
                            <input type="file" name="avatar" accept="image/*" class="block w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-primary focus:border-primary transition-colors bg-white sm:text-sm file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-primary hover:file:bg-indigo-100 cursor-pointer">
                            <p class="text-xs text-gray-400 mt-2">Format: JPG, JPEG, PNG. Ukuran Maksimal 2MB.</p>
                        </div>

                        <!-- Baris 1: Nama -->
                        <div class="sm:col-span-2">
                            <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required class="block w-full px-4 py-3.5 border border-gray-200 rounded-xl focus:ring-primary focus:border-primary transition-colors bg-white sm:text-sm font-medium text-gray-800">
                        </div>

                        <!-- Baris 2: Email -->
                        <div class="sm:col-span-2">
                            <label for="email" class="block text-sm font-bold text-gray-700 mb-2">Alamat Email <span class="text-red-500">*</span></label>
                            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required class="block w-full px-4 py-3.5 border border-gray-200 rounded-xl focus:ring-primary focus:border-primary transition-colors bg-white sm:text-sm font-medium text-gray-800">
                        </div>

                        <div class="sm:col-span-2 my-2">
                            <div class="border-t border-gray-200 border-dashed"></div>
                        </div>

                        <div class="sm:col-span-2">
                            <h4 class="text-base font-extrabold text-gray-900 tracking-tight">Ubah Kata Sandi</h4>
                            <p class="text-sm text-gray-500 font-medium">Kosongkan kedua kolom di bawah ini jika Anda tidak ingin mengubah kata sandi Anda saat ini.</p>
                        </div>

                        <!-- Kata Sandi Baru -->
                        <div>
                            <label for="password" class="block text-sm font-bold text-gray-700 mb-2">Kata Sandi Baru</label>
                            <input type="password" name="password" id="password" class="block w-full px-4 py-3.5 border border-gray-200 rounded-xl focus:ring-primary focus:border-primary transition-colors bg-white sm:text-sm" placeholder="Minimal 8 karakter">
                        </div>

                        <!-- Konfirmasi Kata Sandi -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-bold text-gray-700 mb-2">Ketik Ulang Kata Sandi</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="block w-full px-4 py-3.5 border border-gray-200 rounded-xl focus:ring-primary focus:border-primary transition-colors bg-white sm:text-sm" placeholder="Ketik ulang kata sandi baru">
                        </div>
                    </div>

                    <div class="pt-6 mt-8 border-t border-gray-100 flex flex-col-reverse sm:flex-row justify-end gap-3">
                        <button type="submit" class="w-full sm:w-auto inline-flex justify-center rounded-xl border border-transparent shadow-md shadow-primary/30 px-8 py-3.5 bg-primary text-sm font-bold text-white hover:bg-indigo-700 focus:outline-none transition-all transform active:scale-95">
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