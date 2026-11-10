@extends('layouts.app')

@section('title', 'Laporan Penjualan')
@section('page-title', 'Laporan Penjualan')
@section('page-subtitle', 'Rekapitulasi transaksi dan pendapatan toko')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 no-print">
        <a href="{{ route('laporan.index') }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-brand-primary transition-colors">
            <i class="fas fa-arrow-left"></i>
            <span>Kembali ke Menu Laporan</span>
        </a>
        <button onclick="window.print()" class="btn-primary inline-flex items-center gap-2">
            <i class="fas fa-print text-sm"></i>
            <span>Cetak / Simpan PDF</span>
        </button>
    </div>

    <!-- Filter Form (Hidden saat print) -->
    <div class="card no-print">
        <form method="GET" action="{{ route('laporan.penjualan') }}" class="grid grid-cols-1 md:grid-cols-5 gap-3 items-end">
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Tanggal Mulai</label>
                <input type="date" name="start_date" value="{{ $startDate }}" required
                       class="w-full px-3 py-2 bg-brand-light/30 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-primary text-sm">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Tanggal Akhir</label>
                <input type="date" name="end_date" value="{{ $endDate }}" required
                       class="w-full px-3 py-2 bg-brand-light/30 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-primary text-sm">
            </div>
            @if(auth()->user()->hasRole('admin'))
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Kasir (Opsional)</label>
                    <select name="user_id" class="w-full px-3 py-2 bg-brand-light/30 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-primary text-sm">
                        <option value="">Semua Kasir</option>
                        @foreach($kasirs as $kasir)
                            <option value="{{ $kasir->id }}" {{ request('user_id') == $kasir->id ? 'selected' : '' }}>
                                {{ $kasir->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif
            <div class="md:col-span-2 flex gap-2">
                <button type="submit" class="btn-primary flex-1 inline-flex items-center justify-center gap-2">
                    <i class="fas fa-filter text-sm"></i>
                    <span>Tampilkan</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="card border-l-4 border-l-brand-primary">
            <p class="text-sm text-gray-500 font-medium">Total Transaksi</p>
            <h3 class="text-3xl font-display font-bold text-brand-darkest mt-1">{{ $totalTransaksi }}</h3>
            <p class="text-xs text-gray-400 mt-2">Transaksi selesai</p>
        </div>
        <div class="card border-l-4 border-l-green-500">
            <p class="text-sm text-gray-500 font-medium">Total Pendapatan</p>
            <h3 class="text-3xl font-display font-bold text-green-600 mt-1">{{ format_rupiah($totalPendapatan) }}</h3>
            <p class="text-xs text-gray-400 mt-2">Omzet bersih</p>
        </div>
        <div class="card border-l-4 border-l-blue-500">
            <p class="text-sm text-gray-500 font-medium">Total Buku Terjual</p>
            <h3 class="text-3xl font-display font-bold text-blue-600 mt-1">{{ $totalItem }}</h3>
            <p class="text-xs text-gray-400 mt-2">Eksemplar</p>
        </div>
    </div>

    <!-- Table Laporan -->
    <div class="card overflow-hidden p-0">
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
            <div>
                <h3 class="font-display text-lg font-bold text-brand-darkest">Detail Transaksi</h3>
                <p class="text-xs text-gray-500">Periode: {{ format_tanggal_indo($startDate) }} s/d {{ format_tanggal_indo($endDate) }}</p>
            </div>
        </div>

        @if($transaksis->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-brand-light/50 border-b border-gray-100">
                            <th class="text-left py-3 px-6 text-xs font-semibold text-gray-600 uppercase">Tanggal</th>
                            <th class="text-left py-3 px-6 text-xs font-semibold text-gray-600 uppercase">Kode</th>
                            <th class="text-left py-3 px-6 text-xs font-semibold text-gray-600 uppercase">Kasir</th>
                            <th class="text-left py-3 px-6 text-xs font-semibold text-gray-600 uppercase">Pelanggan</th>
                            <th class="text-center py-3 px-6 text-xs font-semibold text-gray-600 uppercase">Items</th>
                            <th class="text-right py-3 px-6 text-xs font-semibold text-gray-600 uppercase">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($transaksis as $trx)
                            <tr class="hover:bg-brand-light/30 transition-colors">
                                <td class="py-3 px-6 text-sm text-gray-600">{{ format_tanggal_indo($trx->tanggal) }}</td>
                                <td class="py-3 px-6 text-sm font-mono font-semibold text-brand-primary">{{ $trx->kode_transaksi }}</td>
                                <td class="py-3 px-6 text-sm text-gray-600">{{ $trx->kasir->name }}</td>
                                <td class="py-3 px-6 text-sm text-gray-600">{{ $trx->pelanggan->nama ?? 'Umum' }}</td>
                                <td class="py-3 px-6 text-center">
                                    <span class="px-2 py-1 rounded-full text-xs font-semibold bg-brand-light text-brand-primary">
                                        {{ $trx->detail->count() }}
                                    </span>
                                </td>
                                <td class="py-3 px-6 text-right font-display font-bold text-brand-darkest">{{ format_rupiah($trx->total_setelah_diskon) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50 border-t-2 border-gray-200">
                        <tr>
                            <td colspan="5" class="py-4 px-6 text-right font-bold text-brand-darkest">GRAND TOTAL</td>
                            <td class="py-4 px-6 text-right font-display text-xl font-bold text-green-600">{{ format_rupiah($totalPendapatan) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        @else
            <div class="py-16 text-center">
                <div class="w-16 h-16 mx-auto rounded-full bg-gray-100 flex items-center justify-center mb-3">
                    <i class="fas fa-inbox text-2xl text-gray-400"></i>
                </div>
                <p class="text-sm text-gray-500">Tidak ada data transaksi pada periode ini.</p>
            </div>
        @endif
    </div>
</div>

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