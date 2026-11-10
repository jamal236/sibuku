@extends('layouts.app')

@section('title', 'Stok Masuk')
@section('page-title', 'Riwayat Stok Masuk')
@section('page-subtitle', 'Catatan penambahan stok buku dari supplier atau donatur')

@section('content')
<div class="space-y-6">
    <!-- Header Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-forest-500 to-forest-700 text-moonlight-50 flex items-center justify-center shadow-lg">
                <i class="fas fa-boxes-stacked text-xl"></i>
            </div>
            <div>
                <h3 class="font-display text-lg font-bold text-forest-900">Daftar Stok Masuk</h3>
                <p class="text-xs text-forest-500">Total {{ $stokMasuks->total() }} pencatatan</p>
            </div>
        </div>
        <a href="{{ route('stok.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-br from-forest-500 to-forest-700 text-moonlight-50 rounded-xl font-semibold text-sm shadow-md hover:shadow-lg hover:from-forest-600 hover:to-forest-800 transition-all">
            <i class="fas fa-plus text-sm"></i>
            <span>Catat Stok Masuk</span>
        </a>
    </div>

    <!-- Filter Card -->
    <div class="card">
        <form method="GET" action="{{ route('stok.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-3">
            <div class="md:col-span-2 relative">
                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-forest-400"></i>
                <input type="text" name="search" value="{{ request('search') }}" 
                      placeholder="Cari kode stok masuk..."
                      class="w-full pl-11 pr-4 py-2.5 bg-moonlight-50 border-2 border-forest-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-forest-300 focus:border-forest-400 text-sm text-forest-900 placeholder-forest-400">
            </div>
            <input type="date" name="tanggal" value="{{ request('tanggal') }}" 
                  class="px-4 py-2.5 bg-moonlight-50 border-2 border-forest-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-forest-300 focus:border-forest-400 text-sm text-forest-900">
            <select name="supplier_id" onchange="this.form.submit()"
                   class="px-4 py-2.5 bg-moonlight-50 border-2 border-forest-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-forest-300 focus:border-forest-400 text-sm text-forest-900">
                <option value="">Semua Supplier</option>
                @foreach($suppliers as $supplier)
                    <option value="{{ $supplier->id }}" {{ request('supplier_id') == $supplier->id ? 'selected' : '' }}>
                        {{ $supplier->nama }}
                    </option>
                @endforeach
            </select>
        </form>
    </div>

    <!-- Table -->
    <div class="card overflow-hidden p-0">
        @if($stokMasuks->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gradient-to-r from-forest-50 to-moonlight-50 border-b border-forest-200">
                            <th class="text-left py-4 px-6 text-xs font-semibold text-forest-700 uppercase tracking-wider">Kode</th>
                            <th class="text-left py-4 px-6 text-xs font-semibold text-forest-700 uppercase tracking-wider">Tanggal</th>
                            <th class="text-left py-4 px-6 text-xs font-semibold text-forest-700 uppercase tracking-wider">Buku</th>
                            <th class="text-left py-4 px-6 text-xs font-semibold text-forest-700 uppercase tracking-wider">Supplier/Donatur</th>
                            <th class="text-center py-4 px-6 text-xs font-semibold text-forest-700 uppercase tracking-wider">Jumlah</th>
                            <th class="text-right py-4 px-6 text-xs font-semibold text-forest-700 uppercase tracking-wider">Harga Beli</th>
                            <th class="text-right py-4 px-6 text-xs font-semibold text-forest-700 uppercase tracking-wider">Total</th>
                            <th class="text-right py-4 px-6 text-xs font-semibold text-forest-700 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-forest-100">
                        @foreach($stokMasuks as $stok)
                            <tr class="hover:bg-forest-50/50 transition-colors group">
                                <td class="py-4 px-6 text-sm font-mono font-semibold text-forest-600">{{ $stok->kode_stok_masuk }}</td>
                                <td class="py-4 px-6 text-sm text-forest-700">
                                    <div class="flex flex-col">
                                        <span class="font-medium">{{ $stok->tanggal->format('d M Y') }}</span>
                                        <span class="text-xs text-forest-400">{{ $stok->created_at->format('H:i') }}</span>
                                    </div>
                                </td>
                                <td class="py-4 px-6">
                                    <p class="font-semibold text-forest-900 text-sm">{{ $stok->buku->judul }}</p>
                                    <p class="text-xs text-forest-500">{{ $stok->buku->kode_buku }}</p>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 rounded-full {{ $stok->supplier->jenis === 'supplier' ? 'bg-gradient-to-br from-blue-400 to-blue-600' : 'bg-gradient-to-br from-purple-400 to-purple-600' }} text-moonlight-50 flex items-center justify-center font-bold text-xs shadow-sm">
                                            <i class="fas {{ $stok->supplier->jenis === 'supplier' ? 'fa-truck' : 'fa-hand-holding-heart' }} text-xs"></i>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-forest-900 text-sm">{{ $stok->supplier->nama }}</p>
                                            <p class="text-xs text-forest-500 capitalize">{{ $stok->supplier->jenis }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <span class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-emerald-100 text-emerald-700 font-bold text-sm shadow-sm">
                                        +{{ $stok->jumlah }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-right text-sm text-forest-700">
                                    {{ $stok->harga_beli ? format_rupiah($stok->harga_beli) : '-' }}
                                </td>
                                <td class="py-4 px-6 text-right font-display font-bold text-forest-900">
                                    {{ $stok->total_harga_beli ? format_rupiah($stok->total_harga_beli) : '-' }}
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('stok.show', $stok) }}" 
                                           class="w-9 h-9 rounded-lg bg-forest-100 text-forest-600 hover:bg-forest-200 hover:scale-110 flex items-center justify-center transition-all"
                                           title="Detail">
                                            <i class="fas fa-eye text-xs"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-forest-200 bg-gradient-to-r from-forest-50 to-moonlight-50">
                {{ $stokMasuks->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="py-16 text-center">
                <div class="w-20 h-20 mx-auto rounded-full bg-forest-100 flex items-center justify-center mb-4">
                    <i class="fas fa-boxes-stacked text-3xl text-forest-400"></i>
                </div>
                <h4 class="font-display text-lg font-bold text-forest-900 mb-2">Belum Ada Stok Masuk</h4>
                <p class="text-sm text-forest-500 mb-6">Mulai dengan mencatat stok masuk pertama Anda</p>
                <a href="{{ route('stok.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-br from-forest-500 to-forest-700 text-moonlight-50 rounded-xl font-semibold text-sm shadow-md hover:shadow-lg hover:from-forest-600 hover:to-forest-800 transition-all">
                    <i class="fas fa-plus text-sm"></i>
                    <span>Catat Stok Masuk</span>
                </a>
            </div>
        @endif
    </div>
</div>
@endsection