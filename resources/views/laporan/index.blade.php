@extends('layouts.app')

@section('title', 'Pusat Laporan')
@section('page-title', 'Pusat Laporan')
@section('page-subtitle', 'Analisis performa toko dan inventaris buku Anda')

@section('content')
<div class="space-y-8">
    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="card card-hover border-l-4 border-l-emerald-500 bg-gradient-to-br from-emerald-50 to-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-emerald-700 font-medium">Penjualan Hari Ini</p>
                    <h3 class="text-3xl font-display font-bold text-emerald-900 mt-1">{{ format_rupiah($penjualanHariIni) }}</h3>
                    <p class="text-xs text-emerald-600 mt-2">
                        <i class="fas fa-chart-line mr-1"></i>
                        {{ $transaksiHariIni }} transaksi
                    </p>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center shadow-lg">
                    <i class="fas fa-chart-line text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="card card-hover border-l-4 border-l-red-500 bg-gradient-to-br from-red-50 to-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-red-700 font-medium">Peringatan Stok</p>
                    <h3 class="text-3xl font-display font-bold text-red-900 mt-1">{{ $stokRendah }} Buku</h3>
                    <p class="text-xs text-red-600 mt-2">
                        <i class="fas fa-exclamation-triangle mr-1"></i>
                        Perlu perhatian
                    </p>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-red-100 text-red-600 flex items-center justify-center shadow-lg">
                    <i class="fas fa-exclamation-triangle text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="card card-hover border-l-4 border-l-blue-500 bg-gradient-to-br from-blue-50 to-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-blue-700 font-medium">Periode Laporan</p>
                    <h3 class="text-2xl font-display font-bold text-blue-900 mt-1">{{ now()->format('M Y') }}</h3>
                    <p class="text-xs text-blue-600 mt-2">
                        <i class="fas fa-calendar-alt mr-1"></i>
                        Bulan berjalan
                    </p>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-blue-100 text-blue-600 flex items-center justify-center shadow-lg">
                    <i class="fas fa-calendar-alt text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Menu Laporan -->
    <div>
        <h3 class="font-display text-xl font-bold text-forest-900 mb-6 flex items-center gap-2">
            <i class="fas fa-folder-open text-forest-500"></i>
            Pilih Laporan
        </h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Laporan Penjualan -->
            <a href="{{ route('laporan.penjualan') }}" class="card card-hover group block relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-emerald-400 to-emerald-600 opacity-10 rounded-bl-full -mr-8 -mt-8 transition-transform group-hover:scale-110"></div>
                
                <div class="relative">
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center shadow-lg group-hover:shadow-xl group-hover:scale-110 transition-all">
                            <i class="fas fa-cash-register text-white text-2xl"></i>
                        </div>
                        <i class="fas fa-arrow-right text-gray-300 group-hover:text-emerald-500 group-hover:translate-x-1 transition-all"></i>
                    </div>
                    
                    <h4 class="font-display text-lg font-bold text-forest-900 mb-2 group-hover:text-emerald-700 transition-colors">
                        Laporan Penjualan
                    </h4>
                    <p class="text-sm text-gray-500 leading-relaxed">
                        Analisis pendapatan, jumlah transaksi, dan performa kasir berdasarkan periode waktu.
                    </p>
                    
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <span class="inline-flex items-center gap-2 text-sm font-semibold text-emerald-600 group-hover:text-emerald-700">
                            Lihat Laporan
                            <i class="fas fa-chevron-right text-xs"></i>
                        </span>
                    </div>
                </div>
            </a>

            <!-- Laporan Stok -->
            <a href="{{ route('laporan.stok') }}" class="card card-hover group block relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-blue-400 to-blue-600 opacity-10 rounded-bl-full -mr-8 -mt-8 transition-transform group-hover:scale-110"></div>
                
                <div class="relative">
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center shadow-lg group-hover:shadow-xl group-hover:scale-110 transition-all">
                            <i class="fas fa-boxes-stacked text-white text-2xl"></i>
                        </div>
                        <i class="fas fa-arrow-right text-gray-300 group-hover:text-blue-500 group-hover:translate-x-1 transition-all"></i>
                    </div>
                    
                    <h4 class="font-display text-lg font-bold text-forest-900 mb-2 group-hover:text-blue-700 transition-colors">
                        Laporan Stok Buku
                    </h4>
                    <p class="text-sm text-gray-500 leading-relaxed">
                        Pantau kondisi inventaris, nilai aset buku, dan identifikasi buku dengan stok rendah.
                    </p>
                    
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <span class="inline-flex items-center gap-2 text-sm font-semibold text-blue-600 group-hover:text-blue-700">
                            Lihat Laporan
                            <i class="fas fa-chevron-right text-xs"></i>
                        </span>
                    </div>
                </div>
            </a>

            <!-- Laporan Kategori -->
            <a href="{{ route('laporan.kategori') }}" class="card card-hover group block relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-purple-400 to-purple-600 opacity-10 rounded-bl-full -mr-8 -mt-8 transition-transform group-hover:scale-110"></div>
                
                <div class="relative">
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-purple-400 to-purple-600 flex items-center justify-center shadow-lg group-hover:shadow-xl group-hover:scale-110 transition-all">
                            <i class="fas fa-tags text-white text-2xl"></i>
                        </div>
                        <i class="fas fa-arrow-right text-gray-300 group-hover:text-purple-500 group-hover:translate-x-1 transition-all"></i>
                    </div>
                    
                    <h4 class="font-display text-lg font-bold text-forest-900 mb-2 group-hover:text-purple-700 transition-colors">
                        Laporan Kategori
                    </h4>
                    <p class="text-sm text-gray-500 leading-relaxed">
                        Analisis penjualan berdasarkan kategori buku dan performa setiap kategori.
                    </p>
                    
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <span class="inline-flex items-center gap-2 text-sm font-semibold text-purple-600 group-hover:text-purple-700">
                            Lihat Laporan
                            <i class="fas fa-chevron-right text-xs"></i>
                        </span>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Statistik Tambahan -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="card p-4 bg-gradient-to-br from-amber-50 to-orange-50 border-amber-200">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center">
                    <i class="fas fa-book"></i>
                </div>
                <div>
                    <p class="text-xs text-amber-700 font-medium">Total Buku</p>
                    <p class="text-xl font-bold text-amber-900">{{ $totalBuku ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="card p-4 bg-gradient-to-br from-green-50 to-emerald-50 border-green-200">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-green-100 text-green-600 flex items-center justify-center">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div>
                    <p class="text-xs text-green-700 font-medium">Buku Aktif</p>
                    <p class="text-xl font-bold text-green-900">{{ $bukuAktif ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="card p-4 bg-gradient-to-br from-purple-50 to-pink-50 border-purple-200">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center">
                    <i class="fas fa-users"></i>
                </div>
                <div>
                    <p class="text-xs text-purple-700 font-medium">Total Pelanggan</p>
                    <p class="text-xl font-bold text-purple-900">{{ $totalPelanggan ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="card p-4 bg-gradient-to-br from-cyan-50 to-blue-50 border-cyan-200">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-cyan-100 text-cyan-600 flex items-center justify-center">
                    <i class="fas fa-truck"></i>
                </div>
                <div>
                    <p class="text-xs text-cyan-700 font-medium">Total Supplier</p>
                    <p class="text-xl font-bold text-cyan-900">{{ $totalSupplier ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection