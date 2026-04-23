@extends('layouts.admin')

@section('title', 'Riwayat Peminjaman - RuangBaca')

@section('header_title')
<div class="flex items-center gap-3">
    <div class="w-1.5 h-6 bg-gradient-to-b from-purple-600 to-purple-400 rounded-full shadow-sm"></div>
    <span class="text-xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-gray-800 to-gray-600 tracking-tight">
        Riwayat Peminjaman
    </span>
    <span class="hidden sm:inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider bg-purple-50 text-purple-600 border border-purple-100 shadow-sm ml-1">
        Sejarah
    </span>
</div>
@endsection

@section('content')

@if (session('success'))
    <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 mb-6 rounded-r-xl shadow-sm">
        <p class="text-emerald-700 font-bold text-sm">{{ session('success') }}</p>
    </div>
@endif

<div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden mb-8">
    
    <div class="p-6 sm:p-8 border-b border-gray-100 flex flex-col xl:flex-row justify-between items-start xl:items-center gap-6">
        <div class="flex items-center gap-4">
            <div class="p-3.5 bg-gradient-to-br from-purple-500 to-indigo-500 rounded-2xl shadow-lg shadow-purple-200/50 flex-shrink-0 relative overflow-hidden">
                <svg class="w-6 h-6 text-white relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <h2 class="text-2xl font-extrabold text-gray-800 tracking-tight mb-1">Riwayat Peminjaman</h2>
                <p class="text-sm text-gray-500 font-medium">Lihat semua peminjaman yang sudah selesai atau ditolak.</p>
            </div>
        </div>
        
        <div class="flex flex-col sm:flex-row w-full xl:w-auto gap-3">
            <form action="{{ route('admin.borrows.history') }}" method="GET" class="flex flex-col sm:flex-row w-full xl:w-auto gap-3">
                <div class="relative w-full sm:w-28 shrink-0">
                    <select name="per_page" onchange="this.form.submit()" class="appearance-none block w-full pl-4 pr-10 py-3 border border-gray-200 rounded-xl text-sm font-bold text-gray-700 focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 bg-gray-50/50 transition-all hover:bg-gray-50 cursor-pointer">
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" class="block w-full pl-11 pr-4 py-3 border border-gray-200 rounded-xl text-sm font-medium placeholder-gray-400 focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 bg-gray-50/50 transition-all hover:bg-gray-50" placeholder="Cari nama siswa, email, buku...">
                </div>

                <!-- Filter Status -->
                <select name="status" onchange="this.form.submit()" class="appearance-none block w-full sm:w-40 pl-4 pr-10 py-3 border border-gray-200 rounded-xl text-sm font-bold text-gray-700 focus:ring-primary focus:border-primary bg-gray-50 cursor-pointer">
                    <option value="">Semua Status</option>
                    <option value="dikembalikan" {{ request('status') == 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                    <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </form>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-gray-600">
            <thead class="text-xs text-gray-500 uppercase bg-gray-50/50">
                <tr>
                    <th scope="col" class="px-6 py-5 font-bold tracking-wider">Detail Peminjam</th>
                    <th scope="col" class="px-6 py-5 font-bold tracking-wider">Buku & Jaminan</th>
                    <th scope="col" class="px-6 py-5 font-bold tracking-wider text-center">Durasi</th>
                    <th scope="col" class="px-6 py-5 font-bold tracking-wider text-center">Status</th>
                    <th scope="col" class="px-6 py-5 font-bold tracking-wider text-right">Keterangan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                
                @forelse ($history as $borrow)
                <tr class="bg-white hover:bg-gray-50 transition-colors">
                    
                    <td class="px-6 py-5">
                        <div class="font-bold text-gray-900 text-base">{{ $borrow->user->name }}</div>
                        <div class="text-xs text-gray-500 mt-0.5">{{ $borrow->user->email }}</div>
                    </td>

                    <td class="px-6 py-5">
                        <div class="font-bold text-primary mb-1">{{ $borrow->book->title }}</div>
                        <div class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-yellow-50 text-yellow-700 border border-yellow-200 rounded-md text-[10px] font-bold uppercase tracking-wider">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2"></path></svg>
                            Jaminan: {{ $borrow->guarantee }}
                        </div>
                    </td>

                    <td class="px-6 py-5 text-center">
                        <div class="text-sm font-medium text-gray-600">{{ $borrow->borrow_date->format('d M') }} - {{ $borrow->return_date->format('d M Y') }}</div>
                    </td>

                    <td class="px-6 py-5 text-center">
                        @if($borrow->status == 'dikembalikan')
                            <span class="inline-flex bg-emerald-100 text-emerald-600 px-3 py-1 rounded-md text-[11px] font-bold uppercase tracking-wider">Selesai</span>
                        @elseif($borrow->status == 'ditolak')
                            <span class="inline-flex bg-red-100 text-red-600 px-3 py-1 rounded-md text-[11px] font-bold uppercase tracking-wider">Ditolak</span>
                        @endif
                    </td>

                    <td class="px-6 py-5 text-right">
                        @if($borrow->status == 'dikembalikan')
                            @if($borrow->fine > 0)
                                <span class="text-red-500 text-xs font-bold bg-red-50 px-3 py-2 rounded-md inline-block">Denda: Rp {{ number_format($borrow->fine, 0, ',', '.') }}</span>
                            @else
                                <span class="text-emerald-500 text-xs font-bold bg-emerald-50 px-3 py-2 rounded-md inline-block">Tanpa Denda</span>
                            @endif
                        @elseif($borrow->status == 'ditolak')
                            <div class="max-w-xs">
                                @if($borrow->reject_reason)
                                    <p class="text-red-600 text-xs font-medium italic">"{{ $borrow->reject_reason }}"</p>
                                @else
                                    <span class="text-gray-400 text-xs font-bold">-</span>
                                @endif
                            </div>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center justify-center text-gray-400">
                            <span class="text-lg font-medium text-gray-500">Belum ada riwayat peminjaman</span>
                        </div>
                    </td>
                </tr>
                @endforelse

            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    @if ($history->hasPages())
    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/30">
        {{ $history->links('pagination::tailwind') }}
    </div>
    @endif

</div>

@endsection

@push('scripts')
<script>
    // Scripts jika diperlukan untuk halaman riwayat
</script>
@endpush
