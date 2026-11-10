@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Selamat datang kembali, ' . auth()->user()->name . '!')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Card 1 -->
    <div class="card flex items-center justify-between">
        <div>
            <p class="text-sm text-gray-500 font-medium">Total Stok Buku</p>
            <h3 class="text-3xl font-display font-bold text-brand-darkest mt-1">{{ $totalBuku }}</h3>
            <p class="text-xs text-red-500 mt-2 font-medium"><i class="fas fa-exclamation-triangle mr-1"></i> {{ $bukuStokRendah }} stok rendah</p>
        </div>
        <div class="w-14 h-14 rounded-2xl bg-brand-light text-brand-primary flex items-center justify-center text-2xl shadow-matcha">
            <i class="fas fa-book"></i>
        </div>
    </div>

    <!-- Card 2 -->
    <div class="card flex items-center justify-between">
        <div>
            <p class="text-sm text-gray-500 font-medium">Transaksi Hari Ini</p>
            <h3 class="text-3xl font-display font-bold text-brand-darkest mt-1">{{ $transaksiHariIni }}</h3>
            <p class="text-xs text-green-600 mt-2 font-medium"><i class="fas fa-arrow-up mr-1"></i> Aktif</p>
        </div>
        <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-2xl shadow-matcha">
            <i class="fas fa-cash-register"></i>
        </div>
    </div>

    <!-- Card 3 -->
    <div class="card flex items-center justify-between">
        <div>
            <p class="text-sm text-gray-500 font-medium">Total Pelanggan</p>
            <h3 class="text-3xl font-display font-bold text-brand-darkest mt-1">{{ $totalPelanggan }}</h3>
            <p class="text-xs text-gray-400 mt-2 font-medium">Terdaftar di sistem</p>
        </div>
        <div class="w-14 h-14 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center text-2xl shadow-matcha">
            <i class="fas fa-users"></i>
        </div>
    </div>

    <!-- Card 4 -->
    <div class="card flex items-center justify-between">
        <div>
            <p class="text-sm text-gray-500 font-medium">Pendapatan</p>
            <h3 class="text-2xl font-display font-bold text-brand-darkest mt-1">Rp 0</h3>
            <p class="text-xs text-gray-400 mt-2 font-medium">Hari ini</p>
        </div>
        <div class="w-14 h-14 rounded-2xl bg-orange-50 text-orange-600 flex items-center justify-center text-2xl shadow-matcha">
            <i class="fas fa-wallet"></i>
        </div>
    </div>
</div>

<div class="card">
    <h3 class="text-lg font-display font-bold text-brand-darkest mb-4">Aktivitas Terbaru</h3>
    <p class="text-gray-500 text-sm">Belum ada aktivitas transaksi hari ini.</p>
</div>
@endsection