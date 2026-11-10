@extends('layouts.app')

@section('title', 'Detail Stok Masuk')
@section('page-title', 'Detail Stok Masuk')
@section('page-subtitle', 'Informasi lengkap pencatatan {{ $stokMasuk->kode_stok_masuk }}')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    <!-- Back Button -->
    <a href="{{ route('stok.index') }}" 
       class="inline-flex items-center gap-2 text-sm text-forest-600 hover:text-forest-800 mb-4 transition-colors font-medium">
        <i class="fas fa-arrow-left"></i>
        <span>Kembali ke Daftar Stok Masuk</span>
    </a>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column - Info Utama -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Header Card -->
            <div class="card">
                <div class="flex items-start justify-between mb-6">
                    <div>
                        <div class="flex items-center gap-3 mb-2">
                            <span class="font-mono text-lg font-bold text-forest-600">{{ $stokMasuk->kode_stok_masuk }}</span>
                            <span class="px-3 py-1.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">
                                <i class="fas fa-arrow-down mr-1"></i> Stok Masuk
                            </span>
                        </div>
                        <p class="text-sm text-forest-500">{{ $stokMasuk->tanggal->format('d M Y') }} • {{ $stokMasuk->created_at->format('H:i') }}</p>
                    </div>
                </div>

                <!-- Info Grid -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="p-4 bg-forest-50 rounded-xl">
                        <p class="text-xs text-forest-500 uppercase tracking-wider mb-1">Buku</p>
                        <p class="font-semibold text-forest-900">{{ $stokMasuk->buku->judul }}</p>
                        <p class="text-xs text-forest-400 mt-1">{{ $stokMasuk->buku->kode_buku }}</p>
                    </div>
                    <div class="p-4 bg-forest-50 rounded-xl">
                        <p class="text-xs text-forest-500 uppercase tracking-wider mb-1">Kategori</p>
                        <p class="font-semibold text-forest-900">{{ $stokMasuk->buku->kategori->nama_kategori }}</p>
                    </div>
                    <div class="p-4 bg-forest-50 rounded-xl">
                        <p class="text-xs text-forest-500 uppercase tracking-wider mb-1">Supplier/Donatur</p>
                        <p class="font-semibold text-forest-900">{{ $stokMasuk->supplier->nama }}</p>
                        <p class="text-xs text-forest-400 mt-1 capitalize">{{ $stokMasuk->supplier->jenis }}</p>
                    </div>
                    <div class="p-4 bg-forest-50 rounded-xl">
                        <p class="text-xs text-forest-500 uppercase tracking-wider mb-1">Dicatat Oleh</p>
                        <p class="font-semibold text-forest-900">{{ $stokMasuk->user->name }}</p>
                    </div>
                </div>
            </div>

            <!-- Riwayat Perubahan Stok -->
            @if($riwayatStok)
                <div class="card">
                    <h3 class="font-display text-lg font-bold text-forest-900 pb-3 border-b border-forest-200 mb-4">
                        <i class="fas fa-history text-forest-500 mr-2"></i>
                        Riwayat Perubahan Stok
                    </h3>
                    <div class="flex items-center gap-4 p-4 bg-emerald-50 rounded-xl border border-emerald-200">
                        <div class="w-12 h-12 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-arrow-down text-xl"></i>
                        </div>
                        <div class="flex-1">
                            <p class="font-semibold text-forest-900">Stok bertambah {{ $riwayatStok->jumlah }} eksemplar</p>
                            <p class="text-sm text-forest-500 mt-1">
                                {{ $riwayatStok->stok_sebelum }} → {{ $riwayatStok->stok_sesudah }} • 
                                {{ $riwayatStok->created_at->format('d M Y H:i') }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Keterangan -->
            @if($stokMasuk->keterangan)
                <div class="card">
                    <h3 class="font-display text-lg font-bold text-forest-900 pb-3 border-b border-forest-200 mb-3">
                        <i class="fas fa-sticky-note text-forest-500 mr-2"></i>
                        Keterangan
                    </h3>
                    <p class="text-sm text-forest-700">{{ $stokMasuk->keterangan }}</p>
                </div>
            @endif
        </div>

        <!-- Right Column - Ringkasan Biaya -->
        <div class="space-y-6">
            <div class="card space-y-4 sticky top-6">
                <h3 class="font-display text-lg font-bold text-forest-900 pb-3 border-b border-forest-200">
                    <i class="fas fa-calculator text-forest-500 mr-2"></i>
                    Ringkasan Biaya
                </h3>

                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-forest-600">Jumlah Buku</span>
                        <span class="font-semibold text-forest-900">{{ $stokMasuk->jumlah }} eksemplar</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-forest-600">Harga Beli Satuan</span>
                        <span class="font-semibold text-forest-900">
                            {{ $stokMasuk->harga_beli ? format_rupiah($stokMasuk->harga_beli) : '-' }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between pt-3 border-t border-forest-200">
                        <span class="font-display font-bold text-forest-900">TOTAL BIAYA</span>
                        <span class="font-display text-2xl font-bold text-forest-600">
                            {{ $stokMasuk->total_harga_beli ? format_rupiah($stokMasuk->total_harga_beli) : 'Rp 0 (Donasi)' }}
                        </span>
                    </div>
                </div>

                <!-- Info Card -->
                <div class="mt-6 p-4 bg-forest-50 rounded-xl border border-forest-200">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-full bg-forest-100 text-forest-600 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-info-circle"></i>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-forest-900 mb-1">Informasi</p>
                            <p class="text-xs text-forest-600">
                                @if($stokMasuk->supplier->jenis === 'donatur')
                                    Ini adalah donasi buku, tidak ada biaya pengadaan.
                                @else
                                    Biaya pengadaan dari supplier.
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection