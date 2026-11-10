@extends('layouts.app')

@section('title', 'Data Buku')
@section('page-title', 'Data Buku')
@section('page-subtitle', 'Kelola inventaris buku bekas di toko Anda')

@section('content')
<div class="space-y-6">
    <!-- Header Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-forest-500 to-forest-700 text-moonlight-50 flex items-center justify-center shadow-lg">
                <i class="fas fa-book text-xl"></i>
            </div>
            <div>
                <h3 class="font-display text-lg font-bold text-forest-900">Daftar Buku</h3>
                <p class="text-xs text-forest-500">Total {{ $bukus->total() }} buku</p>
            </div>
        </div>
        <a href="{{ route('buku.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-br from-forest-500 to-forest-700 text-moonlight-50 rounded-xl font-semibold text-sm shadow-md hover:shadow-lg hover:from-forest-600 hover:to-forest-800 transition-all">
            <i class="fas fa-plus text-sm"></i>
            <span>Tambah Buku</span>
        </a>
    </div>

    <!-- Filter Card -->
    <div class="card">
        <form method="GET" action="{{ route('buku.index') }}" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-3">
            <!-- Search -->
            <div class="lg:col-span-2 relative">
                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-forest-400"></i>
                <input type="text" name="search" value="{{ request('search') }}" 
                      placeholder="Cari judul, pengarang, atau kode..."
                      class="w-full pl-11 pr-4 py-2.5 bg-moonlight-50 border-2 border-forest-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-forest-300 focus:border-forest-400 text-sm text-forest-900 placeholder-forest-400">
            </div>

            <!-- Filter Kategori -->
            <select name="kategori" onchange="this.form.submit()"
                   class="px-4 py-2.5 bg-moonlight-50 border-2 border-forest-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-forest-300 focus:border-forest-400 text-sm text-forest-900">
                <option value="">Semua Kategori</option>
                @foreach($kategoris as $kategori)
                    <option value="{{ $kategori->id }}" {{ request('kategori') == $kategori->id ? 'selected' : '' }}>
                        {{ $kategori->nama_kategori }}
                    </option>
                @endforeach
            </select>

            <!-- Filter Kondisi -->
            <select name="kondisi" onchange="this.form.submit()"
                   class="px-4 py-2.5 bg-moonlight-50 border-2 border-forest-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-forest-300 focus:border-forest-400 text-sm text-forest-900">
                <option value="">Semua Kondisi</option>
                <option value="baru" {{ request('kondisi') === 'baru' ? 'selected' : '' }}>Baru</option>
                <option value="sangat_baik" {{ request('kondisi') === 'sangat_baik' ? 'selected' : '' }}>Sangat Baik</option>
                <option value="baik" {{ request('kondisi') === 'baik' ? 'selected' : '' }}>Baik</option>
                <option value="cukup" {{ request('kondisi') === 'cukup' ? 'selected' : '' }}>Cukup</option>
                <option value="rusak_ringan" {{ request('kondisi') === 'rusak_ringan' ? 'selected' : '' }}>Rusak Ringan</option>
            </select>

            <!-- Filter Status -->
            <select name="status" onchange="this.form.submit()"
                   class="px-4 py-2.5 bg-moonlight-50 border-2 border-forest-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-forest-300 focus:border-forest-400 text-sm text-forest-900">
                <option value="">Semua Status</option>
                <option value="aktif" {{ request('status') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="nonaktif" {{ request('status') === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
            </select>

            @if(request()->anyFilled(['search', 'kategori', 'kondisi', 'status']))
                <div class="lg:col-span-5">
                    <a href="{{ route('buku.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-forest-100 text-forest-700 rounded-xl font-semibold text-sm hover:bg-forest-200 transition-colors">
                        <i class="fas fa-times"></i>
                        <span>Reset Filter</span>
                    </a>
                </div>
            @endif
        </form>
    </div>

    <!-- Books Grid -->
    @if($bukus->count() > 0)
        <style>
            .book-card {
                perspective: 1000px;
            }
            .book-cover-container {
                position: relative;
                height: 280px;
                display: flex;
                align-items: center;
                justify-content: center;
                background: linear-gradient(135deg, #f0f4e8 0%, #dde5c9 100%);
                padding: 20px;
            }
            .book-cover {
                position: relative;
                width: 100%;
                max-width: 180px;
                height: 100%;
                max-height: 240px;
                transform-style: preserve-3d;
                transition: transform 0.5s ease;
                box-shadow: 
                    -3px 0 8px rgba(0,0,0,0.15),
                    0 5px 15px rgba(0,0,0,0.2),
                    inset 2px 0 3px rgba(255,255,255,0.3);
                border-radius: 4px 8px 8px 4px;
            }
            .book-cover img {
                width: 100%;
                height: 100%;
                object-fit: contain;
                border-radius: 4px 8px 8px 4px;
            }
            .book-cover::before {
                content: '';
                position: absolute;
                left: 0;
                top: 0;
                bottom: 0;
                width: 15px;
                background: linear-gradient(90deg, 
                    rgba(0,0,0,0.3) 0%, 
                    rgba(255,255,255,0.15) 30%, 
                    rgba(0,0,0,0.1) 60%, 
                    rgba(255,255,255,0.1) 100%);
                z-index: 10;
                border-radius: 4px 0 0 4px;
            }
            .book-cover::after {
                content: '';
                position: absolute;
                left: 15px;
                top: 0;
                bottom: 0;
                width: 2px;
                background: rgba(0,0,0,0.15);
                z-index: 10;
            }
            .book-card:hover .book-cover {
                transform: rotateY(-8deg) rotateX(3deg) scale(1.03);
                box-shadow: 
                    -5px 0 20px rgba(0,0,0,0.25),
                    0 10px 30px rgba(0,0,0,0.3),
                    inset 2px 0 3px rgba(255,255,255,0.3);
            }
        </style>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($bukus as $buku)
                <div class="book-card">
                    <div class="card p-0 overflow-hidden group hover:shadow-xl transition-all duration-300">
                        <!-- Foto dengan Efek Buku Vertikal -->
                        <div class="book-cover-container">
                            <div class="book-cover">
                                @if($buku->foto)
                                    <img src="{{ asset('storage/' . $buku->foto) }}" 
                                         alt="{{ $buku->judul }}">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-forest-400 to-forest-600 rounded-lg">
                                        <i class="fas fa-book text-5xl text-white/40"></i>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Badge Kondisi -->
                            <div class="absolute top-4 left-4 z-20">
                                <span class="px-3 py-1.5 rounded-lg text-xs font-bold bg-moonlight-50/95 backdrop-blur-sm text-forest-900 shadow-md border border-forest-200">
                                    {{ ucfirst(str_replace('_', ' ', $buku->kondisi)) }}
                                </span>
                            </div>

                            <!-- Badge Stok -->
                            <div class="absolute top-4 right-4 z-20">
                                @if($buku->stok <= $buku->stok_minimum)
                                    <span class="px-3 py-1.5 rounded-lg text-xs font-bold bg-red-500 text-white shadow-md flex items-center gap-1">
                                        <i class="fas fa-exclamation-circle"></i>
                                        Stok Habis
                                    </span>
                                @elseif($buku->stok <= 5)
                                    <span class="px-3 py-1.5 rounded-lg text-xs font-bold bg-amber-400 text-white shadow-md">
                                        Stok {{ $buku->stok }}
                                    </span>
                                @else
                                    <span class="px-3 py-1.5 rounded-lg text-xs font-bold bg-emerald-400 text-white shadow-md">
                                        Stok {{ $buku->stok }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="p-4">
                            <!-- Kategori & Kode -->
                            <div class="flex items-center gap-2 mb-2">
                                <span class="px-2.5 py-1 rounded-md text-xs font-bold text-white shadow-sm" 
                                    style="background-color: {{ $buku->kategori->warna_label ?? '#4A6B3D' }}">
                                    {{ $buku->kategori->nama_kategori }}
                                </span>
                                <span class="text-xs text-forest-400 font-mono bg-forest-50 px-2 py-1 rounded">{{ $buku->kode_buku }}</span>
                            </div>

                            <!-- Judul -->
                            <h4 class="font-display font-bold text-forest-900 line-clamp-2 mb-1 group-hover:text-forest-600 transition-colors text-lg">
                                {{ $buku->judul }}
                            </h4>
                            
                            <!-- Pengarang -->
                            <p class="text-xs text-forest-500 mb-3 font-medium">{{ $buku->pengarang }}</p>

                            <!-- Harga & Lokasi -->
                            <div class="flex items-center justify-between pt-3 border-t border-forest-100 mb-3">
                                <div>
                                    <p class="text-xs text-forest-400 mb-0.5">Harga</p>
                                    <p class="font-display font-bold text-forest-600 text-lg">{{ format_rupiah($buku->harga) }}</p>
                                </div>
                                @if($buku->lokasi_rak)
                                    <div class="text-right">
                                        <p class="text-xs text-forest-400 mb-0.5">Rak</p>
                                        <p class="text-sm font-bold text-forest-700 bg-forest-100 px-2 py-1 rounded">{{ $buku->lokasi_rak }}</p>
                                    </div>
                                @endif
                            </div>

                            <!-- Actions -->
                            <div class="flex items-center gap-2 pt-3 border-t border-forest-100">
                                <a href="{{ route('buku.show', $buku) }}" 
                                   class="flex-1 py-2.5 rounded-xl bg-forest-100 text-forest-600 hover:bg-forest-200 text-xs font-bold text-center transition-colors flex items-center justify-center gap-1">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                                <a href="{{ route('buku.edit', $buku) }}" 
                                   class="flex-1 py-2.5 rounded-xl bg-amber-100 text-amber-700 hover:bg-amber-200 text-xs font-bold text-center transition-colors flex items-center justify-center gap-1">
                                    <i class="fas fa-pen"></i> Edit
                                </a>
                                <form method="POST" action="{{ route('buku.destroy', $buku) }}" 
                                      onsubmit="return confirm('Yakin ingin menghapus buku ini?')" class="flex-1">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                          class="w-full py-2.5 rounded-xl bg-red-50 text-red-600 hover:bg-red-100 text-xs font-bold transition-colors flex items-center justify-center gap-1">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="card">
            {{ $bukus->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="card py-16 text-center">
            <div class="w-24 h-24 mx-auto rounded-full bg-forest-100 flex items-center justify-center mb-4">
                <i class="fas fa-book text-4xl text-forest-400"></i>
            </div>
            <h4 class="font-display text-lg font-bold text-forest-900 mb-2">Belum Ada Buku</h4>
            <p class="text-sm text-forest-500 mb-6">Mulai dengan menambahkan buku pertama Anda</p>
            <a href="{{ route('buku.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-br from-forest-500 to-forest-700 text-moonlight-50 rounded-xl font-semibold text-sm shadow-md hover:shadow-lg hover:from-forest-600 hover:to-forest-800 transition-all">
                <i class="fas fa-plus text-sm"></i>
                <span>Tambah Buku</span>
            </a>
        </div>
    @endif
</div>
@endsection