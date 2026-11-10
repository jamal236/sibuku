@extends('layouts.app')

@section('title', 'Dashboard Owner')
@section('page-title', 'Dashboard Owner')
@section('page-subtitle', 'Monitor kesehatan finansial dan performa bisnis toko')

@section('content')
<div class="space-y-8">
    <!-- Hero Stats - Financial Overview -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Net Profit -->
        <div class="lg:col-span-2 card bg-gradient-to-br from-forest-700 via-forest-600 to-forest-800 text-moonlight-50 border-forest-800">
            <div class="flex items-start justify-between mb-6">
                <div>
                    <p class="text-sm opacity-80 mb-2">Net Profit Bulan Ini</p>
                    <p class="text-5xl font-display font-bold mb-2">{{ format_rupiah($netProfit) }}</p>
                    <div class="flex items-center gap-4">
                        <span class="flex items-center gap-1 text-sm {{ $pertumbuhan >= 0 ? 'text-emerald-300' : 'text-red-300' }}">
                            <i class="fas {{ $pertumbuhan >= 0 ? 'fa-arrow-up' : 'fa-arrow-down' }}"></i>
                            {{ number_format(abs($pertumbuhan), 1) }}% dari bulan lalu
                        </span>
                        <span class="text-sm opacity-80">Margin: {{ number_format($marginProfit, 1) }}%</span>
                    </div>
                </div>
                <div class="w-16 h-16 rounded-2xl bg-white/10 backdrop-blur-sm flex items-center justify-center">
                    <i class="fas fa-chart-line text-3xl"></i>
                </div>
            </div>
            
            <div class="grid grid-cols-3 gap-4 pt-6 border-t border-white/10">
                <div>
                    <p class="text-xs opacity-70 mb-1">Kas Masuk</p>
                    <p class="font-display font-bold text-lg text-emerald-300">{{ format_rupiah($kasMasuk) }}</p>
                </div>
                <div>
                    <p class="text-xs opacity-70 mb-1">Kas Keluar</p>
                    <p class="font-display font-bold text-lg text-red-300">{{ format_rupiah($kasKeluar) }}</p>
                </div>
                <div>
                    <p class="text-xs opacity-70 mb-1">Arus Kas Bersih</p>
                    <p class="font-display font-bold text-lg {{ $arusKasBersih >= 0 ? 'text-emerald-300' : 'text-red-300' }}">
                        {{ format_rupiah($arusKasBersih) }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Quick Metrics -->
        <div class="space-y-6">
            <div class="card card-hover bg-gradient-to-br from-forest-50 to-moonlight-50 border-forest-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-forest-700 font-medium">Total Transaksi</p>
                        <p class="text-3xl font-display font-bold text-forest-900 mt-1">{{ $totalTransaksiBulanIni }}</p>
                        <p class="text-xs text-forest-500 mt-2">
                            <i class="fas fa-receipt mr-1"></i>
                            Transaksi bulan ini
                        </p>
                    </div>
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-forest-500 to-forest-700 flex items-center justify-center shadow-lg">
                        <i class="fas fa-receipt text-moonlight-50 text-2xl"></i>
                    </div>
                </div>
            </div>
            <div class="card card-hover bg-gradient-to-br from-emerald-50 to-white border-emerald-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-emerald-700 font-medium">Rata-rata Transaksi</p>
                        <p class="text-2xl font-display font-bold text-emerald-900 mt-1">{{ format_rupiah($rataRataTransaksi) }}</p>
                        <p class="text-xs text-emerald-600 mt-2">
                            <i class="fas fa-calculator mr-1"></i>
                            Per transaksi
                        </p>
                    </div>
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center shadow-lg">
                        <i class="fas fa-calculator text-white text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik Pendapatan 30 Hari -->
    <div class="card">
        <div class="flex items-center justify-between mb-6">
            <h3 class="font-display text-lg font-bold text-forest-900">
                <i class="fas fa-chart-area text-forest-500 mr-2"></i>
                Tren Pendapatan 30 Hari Terakhir
            </h3>
            <a href="{{ route('laporan.penjualan') }}" class="text-sm text-forest-600 hover:text-forest-800 font-medium">
                Lihat Laporan Lengkap <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>
        <div class="relative h-64 md:h-80">
            <canvas id="revenueChart"></canvas>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Profitabilitas per Grade -->
        <div class="card">
            <h3 class="font-display text-lg font-bold text-forest-900 pb-3 border-b border-forest-200 mb-4">
                <i class="fas fa-star text-forest-500 mr-2"></i>
                Profitabilitas per Grade Buku
            </h3>
            @if($profitPerGrade->count() > 0)
                <div class="space-y-4">
                    @foreach($profitPerGrade as $grade)
                        @php
                            $totalPendapatan = $profitPerGrade->sum('total_pendapatan');
                            $persentase = $totalPendapatan > 0 ? ($grade->total_pendapatan / $totalPendapatan) * 100 : 0;
                            $colorMap = [
                                'baru' => ['bg' => 'emerald', 'label' => 'Baru'],
                                'sangat_baik' => ['bg' => 'blue', 'label' => 'Sangat Baik'],
                                'baik' => ['bg' => 'forest', 'label' => 'Baik'],
                                'cukup' => ['bg' => 'amber', 'label' => 'Cukup'],
                                'rusak_ringan' => ['bg' => 'red', 'label' => 'Rusak Ringan'],
                            ];
                            $color = $colorMap[$grade->kondisi_snapshot] ?? ['bg' => 'gray', 'label' => ucfirst($grade->kondisi_snapshot)];
                        @endphp
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center gap-2">
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-{{ $color['bg'] }}-100 text-{{ $color['bg'] }}-700">
                                        {{ $color['label'] }}
                                    </span>
                                    <span class="text-sm text-forest-600">{{ $grade->total_terjual }} buku terjual</span>
                                </div>
                                <span class="font-display font-bold text-forest-900">{{ format_rupiah($grade->total_pendapatan) }}</span>
                            </div>
                            <div class="w-full bg-forest-100 rounded-full h-2.5">
                                <div class="bg-gradient-to-r from-{{ $color['bg'] }}-500 to-{{ $color['bg'] }}-600 h-2.5 rounded-full transition-all duration-500" 
                                     style="width: {{ $persentase }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="py-8 text-center">
                    <div class="w-16 h-16 mx-auto rounded-full bg-forest-100 flex items-center justify-center mb-3">
                        <i class="fas fa-star text-2xl text-forest-400"></i>
                    </div>
                    <p class="text-sm text-forest-500">Belum ada data penjualan bulan ini</p>
                </div>
            @endif
        </div>

        <!-- Top Buku Terlaris -->
        <div class="card">
            <h3 class="font-display text-lg font-bold text-forest-900 pb-3 border-b border-forest-200 mb-4">
                <i class="fas fa-fire text-orange-500 mr-2"></i>
                Top 5 Buku Terlaris Bulan Ini
            </h3>
            @if($topBuku->count() > 0)
                <div class="space-y-3">
                    @foreach($topBuku as $index => $buku)
                        <div class="flex items-center gap-4 p-3 bg-forest-50 rounded-xl hover:bg-forest-100 transition-colors">
                            <div class="w-10 h-10 rounded-full 
                                {{ $index === 0 ? 'bg-gradient-to-br from-yellow-400 to-yellow-500 text-white' : ($index === 1 ? 'bg-gradient-to-br from-gray-300 to-gray-400 text-white' : ($index === 2 ? 'bg-gradient-to-br from-orange-400 to-orange-500 text-white' : 'bg-gradient-to-br from-forest-200 to-forest-300 text-forest-700')) }} 
                                flex items-center justify-center font-bold text-sm flex-shrink-0 shadow-sm">
                                {{ $index + 1 }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-forest-900 text-sm truncate">{{ $buku->judul_snapshot }}</p>
                                <p class="text-xs text-forest-500">{{ $buku->total_terjual }} eksemplar terjual</p>
                            </div>
                            <div class="text-right">
                                <p class="font-display font-bold text-forest-700 text-sm">{{ format_rupiah($buku->total_pendapatan) }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="py-8 text-center">
                    <div class="w-16 h-16 mx-auto rounded-full bg-forest-100 flex items-center justify-center mb-3">
                        <i class="fas fa-fire text-2xl text-forest-400"></i>
                    </div>
                    <p class="text-sm text-forest-500">Belum ada data penjualan bulan ini</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Performa Kasir -->
    <div class="card">
        <h3 class="font-display text-lg font-bold text-forest-900 pb-3 border-b border-forest-200 mb-4">
            <i class="fas fa-users text-forest-500 mr-2"></i>
            Performa Kasir Bulan Ini
        </h3>
        @if($performaKasir->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gradient-to-r from-forest-50 to-moonlight-50 border-b border-forest-200">
                            <th class="text-left py-4 px-6 text-xs font-semibold text-forest-700 uppercase tracking-wider">Kasir</th>
                            <th class="text-center py-4 px-6 text-xs font-semibold text-forest-700 uppercase tracking-wider">Total Transaksi</th>
                            <th class="text-right py-4 px-6 text-xs font-semibold text-forest-700 uppercase tracking-wider">Total Penjualan</th>
                            <th class="text-right py-4 px-6 text-xs font-semibold text-forest-700 uppercase tracking-wider">Rata-rata per Transaksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-forest-100">
                        @foreach($performaKasir as $index => $kasir)
                            @php
                                $rataRata = $kasir->total_transaksi > 0 ? $kasir->total_penjualan / $kasir->total_transaksi : 0;
                            @endphp
                            <tr class="hover:bg-forest-50/50 transition-colors">
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-forest-500 to-forest-700 text-moonlight-50 flex items-center justify-center font-bold text-sm shadow-md">
                                            {{ strtoupper(substr($kasir->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-semibold text-forest-900 text-sm">{{ $kasir->name }}</p>
                                            @if($index === 0)
                                                <span class="inline-flex items-center gap-1 text-xs text-yellow-700 bg-yellow-100 px-2 py-0.5 rounded-full mt-1">
                                                    <i class="fas fa-crown text-[10px]"></i> Top Performer
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <span class="px-3 py-1.5 rounded-full text-xs font-semibold bg-forest-100 text-forest-700">
                                        {{ $kasir->total_transaksi }} transaksi
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-right font-display font-bold text-forest-900">
                                    {{ format_rupiah($kasir->total_penjualan) }}
                                </td>
                                <td class="py-4 px-6 text-right text-sm text-forest-600">
                                    {{ format_rupiah($rataRata) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="py-8 text-center">
                <div class="w-16 h-16 mx-auto rounded-full bg-forest-100 flex items-center justify-center mb-3">
                    <i class="fas fa-users text-2xl text-forest-400"></i>
                </div>
                <p class="text-sm text-forest-500">Belum ada data transaksi bulan ini</p>
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('revenueChart')?.getContext('2d');
if (ctx) {
    // Gradient fill
    const gradient = ctx.createLinearGradient(0, 0, 0, 300);
    gradient.addColorStop(0, 'rgba(74, 107, 61, 0.4)');
    gradient.addColorStop(1, 'rgba(74, 107, 61, 0.02)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($chartLabels) !!},
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: {!! json_encode($chartData) !!},
                borderColor: '#4A6B3D',
                backgroundColor: gradient,
                tension: 0.4,
                fill: true,
                pointRadius: 0,
                pointHoverRadius: 6,
                pointHoverBackgroundColor: '#4A6B3D',
                pointHoverBorderColor: '#fff',
                pointHoverBorderWidth: 3,
                borderWidth: 2.5
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: 'rgba(45, 74, 35, 0.95)',
                    titleFont: { size: 12, family: "'Plus Jakarta Sans', sans-serif" },
                    bodyFont: { size: 13, family: "'Plus Jakarta Sans', sans-serif", weight: 'bold' },
                    padding: 12,
                    cornerRadius: 8,
                    mode: 'index',
                    intersect: false,
                    callbacks: {
                        label: function(context) {
                            return 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(74, 107, 61, 0.08)' },
                    ticks: {
                        color: '#6B8F5A',
                        font: { size: 11 },
                        callback: function(value) {
                            if (value >= 1000000) {
                                return 'Rp ' + (value / 1000000).toFixed(1) + 'jt';
                            } else if (value >= 1000) {
                                return 'Rp ' + (value / 1000).toFixed(0) + 'rb';
                            }
                            return 'Rp ' + value;
                        }
                    }
                },
                x: {
                    grid: { display: false },
                    ticks: {
                        color: '#6B8F5A',
                        font: { size: 11 },
                        maxTicksLimit: 10
                    }
                }
            },
            interaction: {
                mode: 'index',
                intersect: false
            }
        }
    });
}
</script>
@endpush
@endsection