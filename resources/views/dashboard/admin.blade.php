@extends('layouts.admin')
@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard Admin')
@section('page-subtitle', 'Kelola inventori dan operasional toko buku bekas')

@section('content')
<div class="space-y-6">
    <!-- Stats Cards Row 1 -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Judul Buku -->
        <div class="bg-moonlight-50 border border-forest-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-forest-400 font-medium">Total Judul Buku</p>
                    <p class="text-3xl font-display font-bold text-forest-900 mt-1">{{ $totalJudulBuku }}</p>
                    <p class="text-xs text-forest-300 mt-2">Judul unik aktif</p>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-forest-500 to-forest-700 flex items-center justify-center shadow-lg">
                    <i class="fas fa-book text-moonlight-100 text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Total Eksemplar -->
        <div class="bg-moonlight-50 border border-forest-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-forest-400 font-medium">Total Eksemplar</p>
                    <p class="text-3xl font-display font-bold text-forest-900 mt-1">{{ $totalEksemplar }}</p>
                    <p class="text-xs text-emerald-500 mt-2">
                        <i class="fas fa-layer-group mr-1"></i>{{ $bukuMultiEksemplar }} multi-eksemplar
                    </p>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-300 to-emerald-500 flex items-center justify-center shadow-lg">
                    <i class="fas fa-layer-group text-moonlight-50 text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Stok Masuk Bulan Ini -->
        <div class="bg-moonlight-50 border border-forest-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-forest-400 font-medium">Stok Masuk</p>
                    <p class="text-3xl font-display font-bold text-forest-900 mt-1">{{ $stokMasukBulanIni }}</p>
                    <p class="text-xs text-emerald-500 mt-2">
                        <i class="fas fa-arrow-up mr-1"></i>Bulan ini
                    </p>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-400 to-emerald-500 flex items-center justify-center shadow-lg">
                    <i class="fas fa-truck text-moonlight-50 text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Biaya Pengadaan -->
        <div class="bg-moonlight-50 border border-forest-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-forest-400 font-medium">Biaya Pengadaan</p>
                    <p class="text-2xl font-display font-bold text-forest-900 mt-1">{{ format_rupiah($totalBiayaStokMasuk) }}</p>
                    <p class="text-xs text-forest-300 mt-2">Bulan ini</p>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-moonlight-300 to-moonlight-500 flex items-center justify-center shadow-lg">
                    <i class="fas fa-wallet text-moonlight-50 text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards Row 2 - Alerts -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Stok Rendah -->
        <div class="bg-moonlight-50 border border-forest-200 border-l-4 border-l-moonlight-400 rounded-2xl p-6 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-forest-400 font-medium">Peringatan Stok</p>
                    <p class="text-3xl font-display font-bold text-moonlight-500 mt-1">{{ $stokRendah }}</p>
                    <p class="text-xs text-forest-300 mt-2">Buku di bawah minimum</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-moonlight-100 flex items-center justify-center">
                    <i class="fas fa-exclamation-triangle text-moonlight-500 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Stok Habis -->
        <div class="bg-moonlight-50 border border-forest-200 border-l-4 border-l-red-500 rounded-2xl p-6 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-forest-400 font-medium">Stok Habis</p>
                    <p class="text-3xl font-display font-bold text-red-600 mt-1">{{ $stokHabis }}</p>
                    <p class="text-xs text-forest-300 mt-2">Perlu restock segera</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-red-100 flex items-center justify-center">
                    <i class="fas fa-times-circle text-red-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Dead Stock -->
        <div class="bg-moonlight-50 border border-forest-200 border-l-4 border-l-forest-400 rounded-2xl p-6 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-forest-400 font-medium">Dead Stock</p>
                    <p class="text-3xl font-display font-bold text-forest-500 mt-1">{{ $deadStock }}</p>
                    <p class="text-xs text-forest-300 mt-2">Tidak laku > 6 bulan</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-forest-100 flex items-center justify-center">
                    <i class="fas fa-ghost text-forest-500 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Top Suppliers -->
        <div class="lg:col-span-2 bg-moonlight-50 border border-forest-200 rounded-2xl p-6 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-display text-lg font-bold text-forest-900">
                    <i class="fas fa-medal text-moonlight-300 mr-2"></i>
                    Top Supplier & Donatur Bulan Ini
                </h3>
                <a href="{{ route('supplier.index') }}" class="text-sm text-forest-600 hover:text-forest-800 font-medium transition-colors">
                    Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>

            @if($topSuppliers->count() > 0)
                <div class="space-y-3">
                    @foreach($topSuppliers as $index => $supplier)
                        <div class="flex items-center gap-4 p-4 bg-forest-50/50 rounded-xl hover:bg-forest-100/50 transition-colors border border-forest-100">
                            <div class="w-10 h-10 rounded-full 
                                {{ $index === 0 ? 'bg-gradient-to-br from-moonlight-200 to-moonlight-400 text-forest-900' : 
                                   ($index === 1 ? 'bg-gradient-to-br from-forest-200 to-forest-300 text-forest-800' : 
                                   ($index === 2 ? 'bg-gradient-to-br from-moonlight-400 to-moonlight-500 text-moonlight-50' : 
                                   'bg-forest-100 text-forest-600')) }} 
                                flex items-center justify-center font-bold text-sm shadow-sm">
                                {{ $index + 1 }}
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-forest-900">{{ $supplier->nama }}</p>
                                <p class="text-xs text-forest-400">{{ $supplier->total_kiriman }} kiriman</p>
                            </div>
                            <div class="text-right">
                                <p class="font-display font-bold text-forest-700">{{ $supplier->total_buku }}</p>
                                <p class="text-xs text-forest-300">buku</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-center text-forest-400 py-8">Belum ada data stok masuk bulan ini</p>
            @endif
        </div>

        <!-- Quick Actions -->
        <div class="bg-moonlight-50 border border-forest-200 rounded-2xl p-6 shadow-sm">
            <h3 class="font-display text-lg font-bold text-forest-900 mb-4">
                <i class="fas fa-bolt text-moonlight-400 mr-2"></i>
                Aksi Cepat
            </h3>
            <div class="space-y-3">
                <a href="{{ route('buku.create') }}" class="flex items-center gap-3 p-4 bg-forest-50/50 rounded-xl hover:bg-forest-100/50 transition-colors group border border-forest-100">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-forest-500 to-forest-700 text-moonlight-50 flex items-center justify-center shadow-md group-hover:scale-110 transition-transform">
                        <i class="fas fa-plus"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-forest-900 text-sm">Tambah Buku</p>
                        <p class="text-xs text-forest-400">Input buku baru ke inventaris</p>
                    </div>
                </a>
                <a href="{{ route('stok.create') }}" class="flex items-center gap-3 p-4 bg-forest-50/50 rounded-xl hover:bg-forest-100/50 transition-colors group border border-forest-100">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-400 to-emerald-500 text-moonlight-50 flex items-center justify-center shadow-md group-hover:scale-110 transition-transform">
                        <i class="fas fa-truck"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-forest-900 text-sm">Catat Stok Masuk</p>
                        <p class="text-xs text-forest-400">Tambah stok dari supplier</p>
                    </div>
                </a>
                <a href="{{ route('transaksi.create') }}" class="flex items-center gap-3 p-4 bg-forest-50/50 rounded-xl hover:bg-forest-100/50 transition-colors group border border-forest-100">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-forest-400 to-forest-600 text-moonlight-50 flex items-center justify-center shadow-md group-hover:scale-110 transition-transform">
                        <i class="fas fa-cash-register"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-forest-900 text-sm">Buat Transaksi</p>
                        <p class="text-xs text-forest-400">Proses penjualan baru</p>
                    </div>
                </a>
                <a href="{{ route('laporan.stok') }}" class="flex items-center gap-3 p-4 bg-forest-50/50 rounded-xl hover:bg-forest-100/50 transition-colors group border border-forest-100">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-forest-600 to-forest-800 text-moonlight-50 flex items-center justify-center shadow-md group-hover:scale-110 transition-transform">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-forest-900 text-sm">Laporan Stok</p>
                        <p class="text-xs text-forest-400">Analisis inventaris lengkap</p>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- Buku Stok Rendah Alert -->
    @if($bukuStokRendah->count() > 0)
        <div class="bg-moonlight-50 border border-forest-200 rounded-2xl p-6 shadow-sm">
            <h3 class="font-display text-lg font-bold text-forest-900 mb-4">
                <i class="fas fa-exclamation-triangle text-moonlight-400 mr-2"></i>
                Peringatan Stok Rendah
            </h3>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-forest-200">
                            <th class="text-left py-3 px-4 text-xs font-semibold text-forest-500 uppercase tracking-wider">Kode</th>
                            <th class="text-left py-3 px-4 text-xs font-semibold text-forest-500 uppercase tracking-wider">Judul Buku</th>
                            <th class="text-center py-3 px-4 text-xs font-semibold text-forest-500 uppercase tracking-wider">Stok</th>
                            <th class="text-center py-3 px-4 text-xs font-semibold text-forest-500 uppercase tracking-wider">Minimum</th>
                            <th class="text-right py-3 px-4 text-xs font-semibold text-forest-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-forest-100">
                        @foreach($bukuStokRendah as $buku)
                            <tr class="hover:bg-forest-100/50 transition-colors">
                                <td class="py-3 px-4 text-sm font-mono text-forest-600">{{ $buku->kode_buku }}</td>
                                <td class="py-3 px-4">
                                    <p class="font-semibold text-forest-900 text-sm">{{ $buku->judul }}</p>
                                    <p class="text-xs text-forest-400">{{ $buku->pengarang }}</p>
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <span class="px-2.5 py-1 rounded-full text-xs font-bold 
                                        {{ $buku->stok === 0 ? 'bg-red-100 text-red-700' : 'bg-moonlight-100 text-moonlight-500' }}">
                                        {{ $buku->stok }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 text-center text-sm text-forest-500">{{ $buku->stok_minimum }}</td>
                                <td class="py-3 px-4 text-right">
                                    <a href="{{ route('stok.create', ['buku_id' => $buku->id]) }}" 
                                       class="text-sm text-forest-600 hover:text-forest-800 font-semibold transition-colors">
                                        Restok <i class="fas fa-arrow-right ml-1"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
@endsection