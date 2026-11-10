@extends('layouts.app')

@section('title', 'Daftar Transaksi')
@section('page-title', 'Daftar Transaksi')
@section('page-subtitle', 'Riwayat semua transaksi penjualan')

@section('content')
<div class="space-y-6">
    <!-- Header Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-forest-500 to-forest-700 text-moonlight-50 flex items-center justify-center shadow-lg">
                <i class="fas fa-cash-register text-xl"></i>
            </div>
            <div>
                <h3 class="font-display text-lg font-bold text-forest-900">Daftar Transaksi</h3>
                <p class="text-xs text-forest-500">Total {{ $transaksis->total() }} transaksi</p>
            </div>
        </div>
        @can('transaksi.proses')
            <a href="{{ route('transaksi.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-br from-forest-500 to-forest-700 text-moonlight-50 rounded-xl font-semibold text-sm shadow-md hover:shadow-lg hover:from-forest-600 hover:to-forest-800 transition-all">
                <i class="fas fa-plus text-sm"></i>
                <span>Transaksi Baru (POS)</span>
            </a>
        @endcan
    </div>

    <!-- Filter Card -->
    <div class="card">
        <form method="GET" action="{{ route('transaksi.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-3">
            <div class="md:col-span-2 relative">
                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-forest-400"></i>
                <input type="text" name="search" value="{{ request('search') }}" 
                      placeholder="Cari kode transaksi..."
                      class="w-full pl-11 pr-4 py-2.5 bg-moonlight-50 border-2 border-forest-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-forest-300 focus:border-forest-400 text-sm text-forest-900 placeholder-forest-400">
            </div>
            <input type="date" name="tanggal" value="{{ request('tanggal') }}" 
                  class="px-4 py-2.5 bg-moonlight-50 border-2 border-forest-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-forest-300 focus:border-forest-400 text-sm text-forest-900">
            <select name="status" onchange="this.form.submit()"
                   class="px-4 py-2.5 bg-moonlight-50 border-2 border-forest-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-forest-300 focus:border-forest-400 text-sm text-forest-900">
                <option value="">Semua Status</option>
                <option value="selesai" {{ request('status') === 'selesai' ? 'selected' : '' }}>Selesai</option>
                <option value="dibatalkan" {{ request('status') === 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
            </select>
        </form>
    </div>

    <!-- Table -->
    <div class="card overflow-hidden p-0">
        @if($transaksis->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gradient-to-r from-forest-50 to-moonlight-50 border-b border-forest-200">
                            <th class="text-left py-4 px-6 text-xs font-semibold text-forest-700 uppercase tracking-wider">Kode</th>
                            <th class="text-left py-4 px-6 text-xs font-semibold text-forest-700 uppercase tracking-wider">Tanggal</th>
                            <th class="text-left py-4 px-6 text-xs font-semibold text-forest-700 uppercase tracking-wider">Pelanggan</th>
                            <th class="text-left py-4 px-6 text-xs font-semibold text-forest-700 uppercase tracking-wider">Kasir</th>
                            <th class="text-center py-4 px-6 text-xs font-semibold text-forest-700 uppercase tracking-wider">Items</th>
                            <th class="text-right py-4 px-6 text-xs font-semibold text-forest-700 uppercase tracking-wider">Total</th>
                            <th class="text-center py-4 px-6 text-xs font-semibold text-forest-700 uppercase tracking-wider">Status</th>
                            <th class="text-right py-4 px-6 text-xs font-semibold text-forest-700 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-forest-100">
                        @foreach($transaksis as $transaksi)
                            <tr class="hover:bg-forest-50/50 transition-colors group">
                                <td class="py-4 px-6 text-sm font-mono font-semibold text-forest-600">{{ $transaksi->kode_transaksi }}</td>
                                <td class="py-4 px-6 text-sm text-forest-700">
                                    <div class="flex flex-col">
                                        <span class="font-medium">{{ $transaksi->tanggal->format('d M Y') }}</span>
                                        <span class="text-xs text-forest-400">{{ $transaksi->created_at->format('H:i') }}</span>
                                    </div>
                                </td>
                                <td class="py-4 px-6 text-sm text-forest-700">
                                    @if($transaksi->pelanggan)
                                        <div class="flex items-center gap-2">
                                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-forest-400 to-forest-600 text-moonlight-50 flex items-center justify-center font-bold text-xs shadow-sm">
                                                {{ strtoupper(substr($transaksi->pelanggan->nama, 0, 1)) }}
                                            </div>
                                            <span class="font-medium">{{ $transaksi->pelanggan->nama }}</span>
                                        </div>
                                    @else
                                        <span class="text-forest-400 italic">Pelanggan Umum</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-sm text-forest-700">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-amber-400 to-amber-600 text-moonlight-50 flex items-center justify-center font-bold text-xs shadow-sm">
                                            {{ strtoupper(substr($transaksi->kasir->name, 0, 1)) }}
                                        </div>
                                        <span>{{ $transaksi->kasir->name }}</span>
                                    </div>
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <span class="px-3 py-1.5 rounded-full text-xs font-semibold bg-forest-100 text-forest-700">
                                        {{ $transaksi->detail->count() }} item
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-right">
                                    <p class="font-display font-bold text-forest-900 text-lg">Rp {{ number_format($transaksi->total_setelah_diskon, 0, ',', '.') }}</p>
                                </td>
                                <td class="py-4 px-6 text-center">
                                    @if($transaksi->status === 'selesai')
                                        <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Selesai
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full text-xs font-semibold bg-red-100 text-red-700">
                                            <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Batal
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('transaksi.show', $transaksi) }}" 
                                           class="w-9 h-9 rounded-lg bg-forest-100 text-forest-600 hover:bg-forest-200 hover:scale-110 flex items-center justify-center transition-all"
                                           title="Detail">
                                            <i class="fas fa-eye text-xs"></i>
                                        </a>
                                        <a href="{{ route('transaksi.nota', $transaksi) }}" 
                                           class="w-9 h-9 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 hover:scale-110 flex items-center justify-center transition-all"
                                           title="Cetak Nota">
                                            <i class="fas fa-print text-xs"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-forest-200 bg-gradient-to-r from-forest-50 to-moonlight-50">
                {{ $transaksis->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="py-16 text-center">
                <div class="w-20 h-20 mx-auto rounded-full bg-forest-100 flex items-center justify-center mb-4">
                    <i class="fas fa-cash-register text-3xl text-forest-400"></i>
                </div>
                <h4 class="font-display text-lg font-bold text-forest-900 mb-2">Belum Ada Transaksi</h4>
                <p class="text-sm text-forest-500 mb-6">Mulai dengan membuat transaksi pertama Anda</p>
                @can('transaksi.proses')
                    <a href="{{ route('transaksi.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-br from-forest-500 to-forest-700 text-moonlight-50 rounded-xl font-semibold text-sm shadow-md hover:shadow-lg hover:from-forest-600 hover:to-forest-800 transition-all">
                        <i class="fas fa-plus text-sm"></i>
                        <span>Transaksi Baru</span>
                    </a>
                @endcan
            </div>
        @endif
    </div>
</div>
@endsection