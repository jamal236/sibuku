@extends('layouts.app')

@section('title', 'Detail Buku')
@section('page-title', 'Detail Buku')
@section('page-subtitle', 'Informasi lengkap tentang buku ini')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    <!-- Back Button -->
    <a href="{{ route('buku.index') }}" 
       class="inline-flex items-center gap-2 text-sm text-forest-600 hover:text-forest-800 mb-4 transition-colors font-medium">
        <i class="fas fa-arrow-left"></i>
        <span>Kembali ke Daftar Buku</span>
    </a>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column - Foto & Info Utama -->
        <div class="space-y-6">
            <!-- Foto -->
            <div class="card p-0 overflow-hidden">
                @if($buku->foto)
                    <img src="{{ asset('storage/' . $buku->foto) }}" 
                         alt="{{ $buku->judul }}"
                         class="w-full h-80 object-contain bg-forest-50">
                @else
                    <div class="w-full h-80 flex items-center justify-center bg-gradient-to-br from-forest-100 to-forest-200">
                        <i class="fas fa-book text-6xl text-forest-400"></i>
                    </div>
                @endif
            </div>

            <!-- Status & Kondisi -->
            <div class="card space-y-4">
                <h3 class="font-display text-lg font-bold text-forest-900 pb-3 border-b border-forest-200">
                    <i class="fas fa-info-circle text-forest-500 mr-2"></i>
                    Status Buku
                </h3>
                
                <div class="space-y-3">
                    <div class="flex items-center justify-between p-3 bg-forest-50 rounded-lg">
                        <span class="text-sm text-forest-700">Status</span>
                        @if($buku->is_aktif)
                            <span class="px-3 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700">
                                <i class="fas fa-check-circle mr-1"></i> Aktif
                            </span>
                        @else
                            <span class="px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                <i class="fas fa-times-circle mr-1"></i> Nonaktif
                            </span>
                        @endif
                    </div>

                    <div class="flex items-center justify-between p-3 bg-forest-50 rounded-lg">
                        <span class="text-sm text-forest-700">Kondisi</span>
                        <span class="px-3 py-1 rounded-full text-xs font-medium bg-forest-100 text-forest-700">
                            {{ ucfirst(str_replace('_', ' ', $buku->kondisi)) }}
                        </span>
                    </div>

                    <div class="flex items-center justify-between p-3 bg-forest-50 rounded-lg">
                        <span class="text-sm text-forest-700">Stok Tersedia</span>
                        <span class="font-display font-bold text-forest-900 text-lg">{{ $buku->stok }}</span>
                    </div>

                    <div class="flex items-center justify-between p-3 bg-forest-50 rounded-lg">
                        <span class="text-sm text-forest-700">Stok Minimum</span>
                        <span class="font-semibold text-forest-700">{{ $buku->stok_minimum }}</span>
                    </div>

                    @if($buku->stok <= $buku->stok_minimum)
                        <div class="p-3 bg-red-50 border border-red-200 rounded-lg">
                            <p class="text-xs text-red-700 font-semibold">
                                <i class="fas fa-exclamation-triangle mr-1"></i>
                                Stok menipis! Perlu restock segera.
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card space-y-3">
                <h3 class="font-display text-lg font-bold text-forest-900 pb-3 border-b border-forest-200">
                    <i class="fas fa-bolt text-forest-500 mr-2"></i>
                    Aksi Cepat
                </h3>
                <a href="{{ route('buku.edit', $buku) }}" 
                   class="block w-full py-3 px-4 bg-gradient-to-br from-forest-500 to-forest-700 text-moonlight-50 rounded-xl font-semibold text-sm text-center shadow-md hover:shadow-lg hover:from-forest-600 hover:to-forest-800 transition-all">
                    <i class="fas fa-pen mr-2"></i>
                    Edit Buku
                </a>
                <a href="{{ route('stok.create', ['buku_id' => $buku->id]) }}" 
                   class="block w-full py-3 px-4 bg-forest-100 text-forest-700 rounded-xl font-semibold text-sm text-center hover:bg-forest-200 transition-all">
                    <i class="fas fa-plus mr-2"></i>
                    Tambah Stok
                </a>
            </div>
        </div>

        <!-- Right Column - Detail Info -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Informasi Buku -->
            <div class="card">
                <div class="flex items-start justify-between mb-6">
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold text-white" 
                                  style="background-color: {{ $buku->kategori->warna_label ?? '#4A6B3D' }}">
                                {{ $buku->kategori->nama_kategori }}
                            </span>
                            <span class="text-xs text-forest-400 font-mono bg-forest-50 px-2 py-1 rounded">{{ $buku->kode_buku }}</span>
                        </div>
                        <h2 class="font-display text-3xl font-bold text-forest-900 mb-2">{{ $buku->judul }}</h2>
                        <p class="text-forest-600 text-lg">oleh <span class="font-semibold">{{ $buku->pengarang }}</span></p>
                    </div>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 gap-6 pt-6 border-t border-forest-100">
                    <div>
                        <p class="text-xs text-forest-400 uppercase tracking-wider mb-2">Penerbit</p>
                        <p class="font-semibold text-forest-900">{{ $buku->penerbit ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-forest-400 uppercase tracking-wider mb-2">Tahun Terbit</p>
                        <p class="font-semibold text-forest-900">{{ $buku->tahun_terbit ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-forest-400 uppercase tracking-wider mb-2">ISBN</p>
                        <p class="font-semibold text-forest-900 font-mono text-sm">{{ $buku->isbn ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-forest-400 uppercase tracking-wider mb-2">Lokasi Rak</p>
                        <p class="font-semibold text-forest-900">{{ $buku->lokasi_rak ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-forest-400 uppercase tracking-wider mb-2">Ditambahkan</p>
                        <p class="font-semibold text-forest-900 text-sm">{{ $buku->created_at->format('d M Y') }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-forest-400 uppercase tracking-wider mb-2">Terakhir Diupdate</p>
                        <p class="font-semibold text-forest-900 text-sm">{{ $buku->updated_at->format('d M Y') }}</p>
                    </div>
                </div>
            </div>

            <!-- Harga -->
            <div class="card">
                <h3 class="font-display text-lg font-bold text-forest-900 pb-3 border-b border-forest-200 mb-4">
                    <i class="fas fa-tags text-forest-500 mr-2"></i>
                    Harga Jual
                </h3>
                <div class="flex items-baseline gap-3">
                    <span class="font-display text-5xl font-bold text-forest-600">{{ format_rupiah($buku->harga) }}</span>
                </div>
                <p class="text-xs text-forest-500 mt-2">Harga sudah termasuk PPN (jika ada)</p>
            </div>

            <!-- Deskripsi Kondisi -->
            @if($buku->deskripsi_kondisi)
                <div class="card">
                    <h3 class="font-display text-lg font-bold text-forest-900 pb-3 border-b border-forest-200 mb-4">
                        <i class="fas fa-clipboard-check text-forest-500 mr-2"></i>
                        Deskripsi Kondisi
                    </h3>
                    <p class="text-forest-700 leading-relaxed bg-forest-50 p-4 rounded-lg">{{ $buku->deskripsi_kondisi }}</p>
                </div>
            @endif

            <!-- Riwayat Stok -->
            @if($buku->riwayatStok->count() > 0)
                <div class="card">
                    <h3 class="font-display text-lg font-bold text-forest-900 pb-3 border-b border-forest-200 mb-4">
                        <i class="fas fa-history text-forest-500 mr-2"></i>
                        Riwayat Stok (5 Terakhir)
                    </h3>
                    <div class="space-y-3">
                        @foreach($buku->riwayatStok->take(5) as $riwayat)
                            <div class="flex items-center gap-4 p-4 bg-forest-50 rounded-xl border border-forest-100">
                                <div class="w-12 h-12 rounded-full 
                                            {{ $riwayat->jenis_perubahan === 'masuk' ? 'bg-emerald-100 text-emerald-600' : 'bg-red-100 text-red-600' }} 
                                            flex items-center justify-center flex-shrink-0">
                                    <i class="fas {{ $riwayat->jenis_perubahan === 'masuk' ? 'fa-arrow-down' : 'fa-arrow-up' }} text-lg"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-forest-900">
                                        {{ ucfirst($riwayat->jenis_perubahan) }} {{ $riwayat->jumlah }} eksemplar
                                    </p>
                                    <p class="text-xs text-forest-500 mt-1">
                                        {{ $riwayat->stok_sebelum }} → {{ $riwayat->stok_sesudah }} • 
                                        {{ $riwayat->created_at->format('d M Y, H:i') }}
                                    </p>
                                    @if($riwayat->keterangan)
                                        <p class="text-xs text-forest-600 mt-1 italic">{{ $riwayat->keterangan }}</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection