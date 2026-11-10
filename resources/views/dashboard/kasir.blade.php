@extends('layouts.app')

@section('title', 'Dashboard Kasir')
@section('page-title', 'Dashboard Kasir')
@section('page-subtitle', 'Monitor performa penjualan shift Anda hari ini')

@section('content')
<div class="space-y-8">
    <!-- Stats Cards - Shift Hari Ini -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Transaksi Hari Ini -->
        <div class="card card-hover bg-gradient-to-br from-forest-50 to-moonlight-50 border-forest-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-forest-700 font-medium">Transaksi Hari Ini</p>
                    <p class="text-3xl font-display font-bold text-forest-900 mt-1">{{ $transaksiHariIni }}</p>
                    <p class="text-xs text-forest-500 mt-2">
                        <i class="fas fa-check-circle mr-1"></i>
                        Transaksi selesai
                    </p>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-forest-500 to-forest-700 flex items-center justify-center shadow-lg">
                    <i class="fas fa-cash-register text-moonlight-50 text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Pendapatan Hari Ini -->
        <div class="card card-hover bg-gradient-to-br from-emerald-50 to-white border-emerald-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-emerald-700 font-medium">Pendapatan Hari Ini</p>
                    <p class="text-2xl font-display font-bold text-emerald-900 mt-1">{{ format_rupiah($pendapatanHariIni) }}</p>
                    <p class="text-xs text-emerald-600 mt-2">
                        <i class="fas fa-arrow-up mr-1"></i>
                        Omzet bersih
                    </p>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center shadow-lg">
                    <i class="fas fa-money-bill-wave text-white text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Item Terjual -->
        <div class="card card-hover bg-gradient-to-br from-blue-50 to-white border-blue-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-blue-700 font-medium">Buku Terjual</p>
                    <p class="text-3xl font-display font-bold text-blue-900 mt-1">{{ $itemTerjualHariIni }}</p>
                    <p class="text-xs text-blue-600 mt-2">
                        <i class="fas fa-book-open mr-1"></i>
                        Eksemplar
                    </p>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-lg">
                    <i class="fas fa-book-open text-white text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Rata-rata Transaksi -->
        <div class="card card-hover bg-gradient-to-br from-purple-50 to-white border-purple-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-purple-700 font-medium">Rata-rata Belanja</p>
                    <p class="text-2xl font-display font-bold text-purple-900 mt-1">{{ format_rupiah($rataRataTransaksi) }}</p>
                    <p class="text-xs text-purple-600 mt-2">
                        <i class="fas fa-calculator mr-1"></i>
                        Per transaksi
                    </p>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center shadow-lg">
                    <i class="fas fa-calculator text-white text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column - Analisis -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Metode Pembayaran -->
            <div class="card">
                <h3 class="font-display text-lg font-bold text-forest-900 pb-3 border-b border-forest-200 mb-4">
                    <i class="fas fa-credit-card text-forest-500 mr-2"></i>
                    Metode Pembayaran Hari Ini
                </h3>
                @if($metodeBayar->count() > 0)
                    <div class="space-y-4">
                        @foreach($metodeBayar as $metode)
                            @php
                                $totalSemua = $metodeBayar->sum('total');
                                $persentase = $totalSemua > 0 ? ($metode->total / $totalSemua) * 100 : 0;
                                $icon = $metode->metode_bayar === 'tunai' ? 'fa-money-bill-wave' : ($metode->metode_bayar === 'transfer' ? 'fa-university' : 'fa-qrcode');
                                $color = $metode->metode_bayar === 'tunai' ? 'emerald' : ($metode->metode_bayar === 'transfer' ? 'blue' : 'purple');
                            @endphp
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 rounded-lg bg-{{ $color }}-100 flex items-center justify-center">
                                            <i class="fas {{ $icon }} text-{{ $color }}-500"></i>
                                        </div>
                                        <span class="font-semibold text-forest-900 capitalize">{{ $metode->metode_bayar }}</span>
                                    </div>
                                    <span class="text-sm font-bold text-{{ $color }}-600">{{ $metode->total }} transaksi ({{ number_format($persentase, 1) }}%)</span>
                                </div>
                                <div class="w-full bg-forest-100 rounded-full h-2.5">
                                    <div class="bg-gradient-to-r from-{{ $color }}-500 to-{{ $color }}-600 h-2.5 rounded-full transition-all duration-500" style="width: {{ $persentase }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="py-8 text-center">
                        <div class="w-16 h-16 mx-auto rounded-full bg-forest-100 flex items-center justify-center mb-3">
                            <i class="fas fa-credit-card text-2xl text-forest-400"></i>
                        </div>
                        <p class="text-sm text-forest-500">Belum ada transaksi hari ini</p>
                    </div>
                @endif
            </div>

            <!-- Jam Sibuk -->
            <div class="card">
                <h3 class="font-display text-lg font-bold text-forest-900 pb-3 border-b border-forest-200 mb-4">
                    <i class="fas fa-clock text-forest-500 mr-2"></i>
                    Analisis Jam Sibuk Hari Ini
                </h3>
                @if($jamSibuk->count() > 0)
                    <div class="grid grid-cols-6 md:grid-cols-12 gap-2">
                        @for($i = 8; $i <= 20; $i++)
                            @php
                                $data = $jamSibuk->firstWhere('jam', $i);
                                $total = $data ? $data->total : 0;
                                $maxTotal = $jamSibuk->max('total') ?? 1;
                                $height = $total > 0 ? max(20, ($total / $maxTotal) * 100) : 10;
                                $color = $total === 0 ? 'forest' : ($total >= $maxTotal * 0.7 ? 'red' : ($total >= $maxTotal * 0.4 ? 'amber' : 'emerald'));
                            @endphp
                            <div class="text-center">
                                <div class="flex items-end justify-center h-24 mb-2">
                                    <div class="w-8 bg-gradient-to-t from-{{ $color }}-500 to-{{ $color }}-400 rounded-t transition-all hover:opacity-80" 
                                         style="height: {{ $height }}%"
                                         title="{{ $total }} transaksi">
                                    </div>
                                </div>
                                <p class="text-xs font-semibold text-forest-700">{{ $i }}:00</p>
                                <p class="text-xs text-forest-400">{{ $total }}</p>
                            </div>
                        @endfor
                    </div>
                    <div class="flex items-center gap-4 mt-4 pt-4 border-t border-forest-100 text-xs">
                        <span class="flex items-center gap-1">
                            <span class="w-3 h-3 bg-red-500 rounded"></span> Sibuk
                        </span>
                        <span class="flex items-center gap-1">
                            <span class="w-3 h-3 bg-amber-500 rounded"></span> Sedang
                        </span>
                        <span class="flex items-center gap-1">
                            <span class="w-3 h-3 bg-emerald-500 rounded"></span> Normal
                        </span>
                    </div>
                @else
                    <div class="py-8 text-center">
                        <div class="w-16 h-16 mx-auto rounded-full bg-forest-100 flex items-center justify-center mb-3">
                            <i class="fas fa-clock text-2xl text-forest-400"></i>
                        </div>
                        <p class="text-sm text-forest-500">Belum ada transaksi hari ini</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Right Column - Sidebar -->
        <div class="space-y-6">
            <!-- Pelanggan Dilayani -->
            <div class="card bg-gradient-to-br from-forest-500 to-forest-700 text-moonlight-50">
                <div class="text-center">
                    <div class="w-16 h-16 rounded-full bg-white/20 backdrop-blur-sm mx-auto flex items-center justify-center mb-3">
                        <i class="fas fa-users text-3xl"></i>
                    </div>
                    <p class="text-4xl font-display font-bold">{{ $pelangganHariIni }}</p>
                    <p class="text-sm opacity-90 mt-1">Pelanggan Dilayani Hari Ini</p>
                </div>
            </div>

            <!-- Quick Action -->
            <div class="card space-y-4">
                <h3 class="font-display text-lg font-bold text-forest-900 pb-3 border-b border-forest-200">
                    <i class="fas fa-bolt text-forest-500 mr-2"></i>
                    Aksi Cepat
                </h3>
                <a href="{{ route('transaksi.create') }}" class="block w-full bg-gradient-to-r from-forest-500 to-forest-700 hover:from-forest-600 hover:to-forest-800 text-moonlight-50 font-bold py-4 rounded-xl transition-all duration-300 shadow-md hover:shadow-lg active:scale-[0.98] flex items-center justify-center gap-2">
                    <i class="fas fa-plus-circle text-lg"></i>
                    <span class="text-lg">Transaksi Baru</span>
                </a>
                <a href="{{ route('transaksi.index') }}" class="block w-full bg-forest-100 hover:bg-forest-200 text-forest-700 font-semibold py-3 rounded-xl transition-all text-center">
                    <i class="fas fa-history mr-2"></i>
                    Lihat Riwayat Transaksi
                </a>
            </div>

            <!-- Info Card -->
            <div class="card bg-gradient-to-br from-forest-50 to-moonlight-50 border-forest-200">
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 rounded-full bg-forest-100 text-forest-600 flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-lightbulb"></i>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-forest-900 mb-1">Tips</p>
                        <p class="text-xs text-forest-600">Gunakan fitur pencarian buku untuk mempercepat proses transaksi.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Transaksi Terbaru -->
    <div class="card">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-display text-lg font-bold text-forest-900">
                <i class="fas fa-history text-forest-500 mr-2"></i>
                Transaksi Terbaru Anda
            </h3>
            <a href="{{ route('transaksi.index') }}" class="text-sm text-forest-600 hover:text-forest-800 font-medium">
                Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>
        
        @if($transaksiTerbaru->count() > 0)
            <div class="space-y-3">
                @foreach($transaksiTerbaru as $transaksi)
                    <a href="{{ route('transaksi.show', $transaksi) }}" class="flex items-center gap-3 p-3 bg-forest-50 rounded-xl hover:bg-forest-100 transition-colors">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-forest-400 to-forest-600 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-receipt text-moonlight-50"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-forest-900 text-sm">{{ $transaksi->kode_transaksi }}</p>
                            <p class="text-xs text-forest-500">{{ $transaksi->pelanggan->nama ?? 'Pelanggan Umum' }} • {{ $transaksi->created_at->format('H:i') }}</p>
                        </div>
                        <div class="text-right">
                            <p class="font-display font-bold text-forest-700">{{ format_rupiah($transaksi->total_setelah_diskon) }}</p>
                            <p class="text-xs text-forest-400 capitalize">{{ $transaksi->metode_bayar }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="py-8 text-center">
                <div class="w-16 h-16 mx-auto rounded-full bg-forest-100 flex items-center justify-center mb-3">
                    <i class="fas fa-receipt text-2xl text-forest-400"></i>
                </div>
                <p class="text-sm text-forest-500">Belum ada transaksi hari ini. Mulai transaksi pertama Anda!</p>
            </div>
        @endif
    </div>

    <!-- Buku Stok Rendah Info -->
    @if($bukuStokRendah->count() > 0)
        <div class="card bg-gradient-to-br from-amber-50 to-orange-50 border-amber-200">
            <h3 class="font-display text-lg font-bold text-amber-900 mb-3">
                <i class="fas fa-exclamation-triangle text-amber-600 mr-2"></i>
                Info: Buku dengan Stok Rendah
            </h3>
            <p class="text-sm text-amber-700 mb-4">Berikut buku yang stoknya menipis. Informasikan ke pelanggan jika mereka mencari:</p>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                @foreach($bukuStokRendah as $buku)
                    <div class="bg-white p-3 rounded-lg border border-amber-200">
                        <p class="font-semibold text-forest-900 text-sm truncate">{{ $buku->judul }}</p>
                        <p class="text-xs text-forest-500">{{ $buku->pengarang }}</p>
                        <p class="text-xs font-bold text-amber-600 mt-1">Sisa: {{ $buku->stok }} eksemplar</p>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection