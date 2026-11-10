@extends('layouts.app')

@section('title', 'Laporan Kategori')
@section('page-title', 'Laporan Kategori')
@section('page-subtitle', 'Analisis penjualan berdasarkan kategori buku')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <!-- Header Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 no-print">
        <a href="{{ route('laporan.index') }}" class="inline-flex items-center gap-2 text-sm text-forest-600 hover:text-forest-800 transition-colors font-medium">
            <i class="fas fa-arrow-left"></i>
            <span>Kembali ke Menu Laporan</span>
        </a>
        <button onclick="window.print()" class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-br from-forest-500 to-forest-700 text-moonlight-50 rounded-xl font-semibold text-sm shadow-md hover:shadow-lg hover:from-forest-600 hover:to-forest-800 transition-all">
            <i class="fas fa-print text-sm"></i>
            <span>Cetak / Simpan PDF</span>
        </button>
    </div>

    <!-- Filter Form -->
    <div class="card">
        <form method="GET" action="{{ route('laporan.kategori') }}" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3 items-end">
            <div>
                <label class="block text-xs font-semibold text-forest-700 mb-1">Tanggal Mulai</label>
                <input type="date" name="start_date" value="{{ $startDate }}" required
                      class="w-full px-3 py-2 bg-moonlight-50 border-2 border-forest-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-forest-300 focus:border-forest-400 text-sm">
            </div>
            <div>
                <label class="block text-xs font-semibold text-forest-700 mb-1">Tanggal Akhir</label>
                <input type="date" name="end_date" value="{{ $endDate }}" required
                      class="w-full px-3 py-2 bg-moonlight-50 border-2 border-forest-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-forest-300 focus:border-forest-400 text-sm">
            </div>
            <div>
                <label class="block text-xs font-semibold text-forest-700 mb-1">Kategori (Opsional)</label>
                <select name="kategori_id" class="w-full px-3 py-2 bg-moonlight-50 border-2 border-forest-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-forest-300 focus:border-forest-400 text-sm">
                    <option value="">Semua Kategori</option>
                    @foreach($kategoris as $kategori)
                        <option value="{{ $kategori->id }}" {{ request('kategori_id') == $kategori->id ? 'selected' : '' }}>
                            {{ $kategori->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <button type="submit" class="w-full bg-gradient-to-br from-forest-500 to-forest-700 text-moonlight-50 px-4 py-2 rounded-lg font-semibold text-sm hover:shadow-lg transition-all inline-flex items-center justify-center gap-2">
                    <i class="fas fa-filter text-sm"></i>
                    <span>Tampilkan</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="card border-l-4 border-l-purple-500 bg-gradient-to-br from-purple-50 to-white">
            <p class="text-sm text-purple-700 font-medium">Total Kategori</p>
            <h3 class="text-3xl font-display font-bold text-purple-900 mt-1">{{ $totalKategori }}</h3>
            <p class="text-xs text-purple-600 mt-2">Aktif</p>
        </div>

        <div class="card border-l-4 border-l-emerald-500 bg-gradient-to-br from-emerald-50 to-white">
            <p class="text-sm text-emerald-700 font-medium">Total Transaksi</p>
            <h3 class="text-3xl font-display font-bold text-emerald-900 mt-1">{{ $totalTransaksi }}</h3>
            <p class="text-xs text-emerald-600 mt-2">Transaksi</p>
        </div>

        <div class="card border-l-4 border-l-blue-500 bg-gradient-to-br from-blue-50 to-white">
            <p class="text-sm text-blue-700 font-medium">Total Buku Terjual</p>
            <h3 class="text-3xl font-display font-bold text-blue-900 mt-1">{{ $totalItem }}</h3>
            <p class="text-xs text-blue-600 mt-2">Eksemplar</p>
        </div>

        <div class="card border-l-4 border-l-amber-500 bg-gradient-to-br from-amber-50 to-white">
            <p class="text-sm text-amber-700 font-medium">Total Pendapatan</p>
            <h3 class="text-2xl font-display font-bold text-amber-900 mt-1">{{ format_rupiah($totalPendapatan) }}</h3>
            <p class="text-xs text-amber-600 mt-2">Omzet</p>
        </div>
    </div>

    <!-- Chart Section -->
    @if($kategoriData->count() > 0)
        <div class="card">
            <h3 class="font-display text-lg font-bold text-forest-900 mb-6 flex items-center gap-2">
                <i class="fas fa-chart-pie text-forest-500"></i>
                Distribusi Penjualan per Kategori
            </h3>
            <div class="relative h-64 md:h-80 max-w-2xl mx-auto">
                <canvas id="kategoriChart"></canvas>
            </div>
        </div>
    @endif

    <!-- Table Laporan -->
    <div class="card overflow-hidden p-0">
        <div class="p-6 border-b border-forest-200 flex items-center justify-between">
            <div>
                <h3 class="font-display text-lg font-bold text-forest-900">Detail Penjualan per Kategori</h3>
                <p class="text-xs text-forest-500 mt-1">
                    Periode: {{ format_tanggal_indo($startDate) }} s/d {{ format_tanggal_indo($endDate) }}
                </p>
            </div>
        </div>

        @if($kategoriData->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gradient-to-r from-forest-50 to-moonlight-50 border-b border-forest-200">
                            <th class="text-left py-4 px-6 text-xs font-semibold text-forest-700 uppercase">Kategori</th>
                            <th class="text-center py-4 px-6 text-xs font-semibold text-forest-700 uppercase">Total Buku</th>
                            <th class="text-center py-4 px-6 text-xs font-semibold text-forest-700 uppercase">Total Transaksi</th>
                            <th class="text-center py-4 px-6 text-xs font-semibold text-forest-700 uppercase">Total Terjual</th>
                            <th class="text-right py-4 px-6 text-xs font-semibold text-forest-700 uppercase">Pendapatan</th>
                            <th class="text-right py-4 px-6 text-xs font-semibold text-forest-700 uppercase">Persentase</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-forest-100">
                        @foreach($kategoriData as $kategori)
                            @php
                                $persentase = $totalPendapatan > 0 ? ($kategori->total_pendapatan / $totalPendapatan) * 100 : 0;
                            @endphp
                            <tr class="hover:bg-forest-50/50 transition-colors">
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-lg flex items-center justify-center text-white font-bold text-sm shadow-md" 
                                             style="background-color: {{ $kategori->warna_label ?? '#4A6B3D' }}">
                                            {{ substr($kategori->nama_kategori, 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="font-semibold text-forest-900 text-sm">{{ $kategori->nama_kategori }}</p>
                                            <p class="text-xs text-forest-500">{{ $kategori->total_buku }} buku dalam kategori</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-700">
                                        {{ $kategori->total_buku }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">
                                        {{ $kategori->total_transaksi }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">
                                        {{ $kategori->total_terjual }} eksemplar
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-right font-display font-bold text-forest-900">
                                    {{ format_rupiah($kategori->total_pendapatan) }}
                                </td>
                                <td class="py-4 px-6 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <div class="w-24 h-2 bg-gray-200 rounded-full overflow-hidden">
                                            <div class="h-full bg-gradient-to-r from-purple-500 to-purple-600 rounded-full" 
                                                 style="width: {{ $persentase }}%"></div>
                                        </div>
                                        <span class="text-sm font-semibold text-forest-700">{{ number_format($persentase, 1) }}%</span>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gradient-to-r from-forest-50 to-moonlight-50 border-t-2 border-forest-200">
                        <tr>
                            <td colspan="4" class="py-4 px-6 text-right font-bold text-forest-900">TOTAL</td>
                            <td class="py-4 px-6 text-right font-display text-xl font-bold text-emerald-600">
                                {{ format_rupiah($totalPendapatan) }}
                            </td>
                            <td class="py-4 px-6 text-right font-bold text-forest-900">100%</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        @else
            <div class="py-16 text-center">
                <div class="w-16 h-16 mx-auto rounded-full bg-forest-100 flex items-center justify-center mb-3">
                    <i class="fas fa-inbox text-2xl text-forest-400"></i>
                </div>
                <p class="text-sm text-forest-500">Tidak ada data transaksi pada periode ini.</p>
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
@if($kategoriData->count() > 0)
    const ctx = document.getElementById('kategoriChart').getContext('2d');
    
    // Ambil warna dari setiap kategori (warna_label), jika tidak ada gunakan warna default
    const kategoriWarna = @json($kategoriData->pluck('warna_label')->map(fn($w) => $w ?? '#4A6B3D'));
    
    // Warna default sebagai fallback jika warna_label kosong
    const defaultColors = [
        '#4A6B3D', '#235347', '#6B8F5A', '#8FA878', '#B8C9A0',
        '#DDE5C9', '#1E3A5F', '#2E5C8A', '#3D7A9A', '#5A9A5A'
    ];
    
    // Gabungkan: pakai warna kategori jika ada, jika tidak pakai default
    const chartColors = kategoriWarna.map((color, index) => 
        color ? color : defaultColors[index % defaultColors.length]
    );

    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($kategoriData->pluck('nama_kategori')) !!},
            datasets: [{
                data: {!! json_encode($kategoriData->pluck('total_pendapatan')) !!},
                backgroundColor: chartColors,
                borderWidth: 2,
                borderColor: '#fff',
                hoverOffset: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            aspectRatio: 1.5,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 15,
                        font: {
                            size: 11,
                            family: "'Plus Jakarta Sans', sans-serif"
                        },
                        boxWidth: 12,
                        usePointStyle: true,
                        pointStyle: 'rectRounded'
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(35, 83, 71, 0.95)',
                    titleFont: { size: 13, family: "'Plus Jakarta Sans', sans-serif" },
                    bodyFont: { size: 12, family: "'Plus Jakarta Sans', sans-serif" },
                    padding: 12,
                    cornerRadius: 8,
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.parsed || 0;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                            return label + ': Rp ' + value.toLocaleString('id-ID') + ' (' + percentage + '%)';
                        }
                    }
                }
            },
            animation: {
                animateRotate: true,
                animateScale: true,
                duration: 1000,
                easing: 'easeOutQuart'
            }
        }
    });
@endif
</script>
@endpush

<style>
@media print {
    .no-print { display: none !important; }
    body { background: white; }
    .card { box-shadow: none; border: 1px solid #eee; }
    aside, header { display: none !important; }
    main { padding: 0 !important; margin: 0 !important; }
}
</style>
@endsection