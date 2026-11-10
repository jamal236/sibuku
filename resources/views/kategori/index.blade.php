@extends('layouts.app')

@section('title', 'Kategori')
@section('page-title', 'Kategori Buku')
@section('page-subtitle', 'Kelola kategori untuk mengelompokkan buku-buku di toko')

@section('content')
<div class="space-y-6">
    <!-- Header Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 rounded-2xl bg-brand-primary/10 text-brand-primary flex items-center justify-center">
                <i class="fas fa-tags text-xl"></i>
            </div>
            <div>
                <h3 class="font-display text-lg font-bold text-brand-darkest">Daftar Kategori</h3>
                <p class="text-xs text-gray-500">Total {{ $kategoris->total() }} kategori</p>
            </div>
        </div>
        <a href="{{ route('kategori.create') }}" class="btn-primary inline-flex items-center gap-2">
            <i class="fas fa-plus text-sm"></i>
            <span>Tambah Kategori</span>
        </a>
    </div>

    <!-- Filter & Search Card -->
    <div class="card">
        <form method="GET" action="{{ route('kategori.index') }}" class="flex flex-col md:flex-row gap-3">
            <div class="flex-1 relative">
                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Cari kategori..."
                       class="w-full pl-11 pr-4 py-2.5 bg-brand-light/30 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-transparent text-sm">
            </div>
            <select name="status" onchange="this.form.submit()"
                    class="px-4 py-2.5 bg-brand-light/30 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-primary text-sm">
                <option value="">Semua Status</option>
                <option value="aktif" {{ request('status') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="nonaktif" {{ request('status') === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
            </select>
            @if(request('search') || request('status'))
                <a href="{{ route('kategori.index') }}" class="btn-secondary inline-flex items-center gap-2 justify-center">
                    <i class="fas fa-times text-sm"></i>
                    <span>Reset</span>
                </a>
            @endif
        </form>
    </div>

    <!-- Table Card -->
    <div class="card overflow-hidden p-0">
        @if($kategoris->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-brand-light/50 border-b border-gray-100">
                            <th class="text-left py-4 px-6 text-xs font-semibold text-gray-600 uppercase tracking-wider">No</th>
                            <th class="text-left py-4 px-6 text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama Kategori</th>
                            <th class="text-left py-4 px-6 text-xs font-semibold text-gray-600 uppercase tracking-wider">Deskripsi</th>
                            <th class="text-center py-4 px-6 text-xs font-semibold text-gray-600 uppercase tracking-wider">Urutan</th>
                            <th class="text-center py-4 px-6 text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                            <th class="text-center py-4 px-6 text-xs font-semibold text-gray-600 uppercase tracking-wider">Jumlah Buku</th>
                            <th class="text-right py-4 px-6 text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($kategoris as $index => $kategori)
                            <tr class="hover:bg-brand-light/30 transition-colors">
                                <td class="py-4 px-6 text-sm text-gray-500">
                                    {{ $kategoris->firstItem() + $index }}
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-3">
                                        <div class="w-3 h-3 rounded-full shadow-sm" style="background-color: {{ $kategori->warna_label }}"></div>
                                        <span class="font-medium text-brand-darkest">{{ $kategori->nama_kategori }}</span>
                                    </div>
                                </td>
                                <td class="py-4 px-6 text-sm text-gray-600 max-w-xs truncate">
                                    {{ $kategori->deskripsi ?? '-' }}
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-brand-light text-brand-primary text-sm font-semibold">
                                        {{ $kategori->urutan_tampil }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-center">
                                    @if($kategori->is_aktif)
                                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                            <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                            Aktif
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                            <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                                            Nonaktif
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <span class="text-sm font-semibold text-brand-darkest">
                                        {{ $kategori->buku()->where('is_aktif', true)->count() }}
                                    </span>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('kategori.edit', $kategori) }}" 
                                           class="w-9 h-9 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 flex items-center justify-center transition-colors"
                                           title="Edit">
                                            <i class="fas fa-pen text-xs"></i>
                                        </a>
                                        <form method="POST" action="{{ route('kategori.destroy', $kategori) }}" 
                                              onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="w-9 h-9 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 flex items-center justify-center transition-colors"
                                                    title="Hapus">
                                                <i class="fas fa-trash text-xs"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
                {{ $kategoris->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="py-16 text-center">
                <div class="w-20 h-20 mx-auto rounded-full bg-brand-light/50 flex items-center justify-center mb-4">
                    <i class="fas fa-tags text-3xl text-brand-primary/40"></i>
                </div>
                <h4 class="font-display text-lg font-bold text-brand-darkest mb-2">Belum Ada Kategori</h4>
                <p class="text-sm text-gray-500 mb-6">Mulai dengan menambahkan kategori pertama Anda</p>
                <a href="{{ route('kategori.create') }}" class="btn-primary inline-flex items-center gap-2">
                    <i class="fas fa-plus text-sm"></i>
                    <span>Tambah Kategori</span>
                </a>
            </div>
        @endif
    </div>
</div>
@endsection