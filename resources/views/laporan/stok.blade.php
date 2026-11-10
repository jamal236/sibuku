@extends('layouts.app')

@section('title', 'Laporan Stok')
@section('page-title', 'Laporan Stok Buku')
@section('page-subtitle', 'Pantau kondisi dan nilai inventaris buku bekas')

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

    <!-- Filter Form -->
    <div class="card no-print">
        <form method="GET" action="{{ route('laporan.stok') }}" class="grid grid-cols-1 md:grid-cols-4 gap-3 items-end">
            <div class="md:col-span-2 relative">
                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Cari judul atau kode buku..."
                       class="w-full pl-11 pr-4 py-2 bg-brand-light/30 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-primary text-sm">
            </div>
            <select name="kategori_id" class="px-3 py-2 bg-brand-light/30 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-primary text-sm">
                <option value="">Semua Kategori</option>
                @foreach($kategoris as $kategori)
                    <option value="{{ $kategori->id }}" {{ request('kategori_id') == $kategori->id ? 'selected' : '' }}>
                        {{ $kategori->nama_kategori }}
                    </option>
                @endforeach
            </select>
            <div class="flex gap-2">
                <label class="flex items-center gap-2 px-3 py-2 bg-brand-light/30 border border-gray-200 rounded-lg cursor-pointer hover:bg-brand-light/50 transition-colors flex-1 justify-center">
                    <input type="checkbox" name="stok_rendah" value="1" {{ request('stok_rendah') ? 'checked' : '' }} 
                           class="rounded border-gray-300 text-brand-primary focus:ring-brand-primary" onchange="this.form.submit()">
                    <span class="text-sm font-medium text-brand-darkest">Stok Rendah Saja</span>
                </label>
                <button type="submit" class="btn-primary px-4">
                    <i class="fas fa-filter"></i>
                </button>
            </div>
        </form>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="card border-l-4 border-l-brand-primary">
            <p class="text-sm text-gray-500 font-medium">Total Jenis Buku</p>
            <h3 class="text-3xl font-display font-bold text-brand-darkest mt-1">{{ $totalBuku }}</h3>
            <p class="text-xs text-gray-400 mt-2">Judul unik</p>
        </div>
        <div class="card border-l-4 border-l-blue-500">
            <p class="text-sm text-gray-500 font-medium">Total Eksemplar</p>
            <h3 class="text-3xl font-display font-bold text-blue-600 mt-1">{{ $totalStok }}</h3>
            <p class="text-xs text-gray-400 mt-2">Buku fisik di toko</p>
        </div>
        <div class="card border-l-4 border-l-green-500">
            <p class="text-sm text-gray-500 font-medium">Estimasi Nilai Aset</p>
            <h3 class="text-2xl font-display font-bold text-green-600 mt-1">{{ format_rupiah($nilaiInventaris) }}</h3>
            <p class="text-xs text-gray-400 mt-2">Berdasarkan harga jual</p>
        </div>
    </div>

    <!-- Table Laporan -->
    <div class="card overflow-hidden p-0">
        <div class="p-6 border-b border-gray-100">
            <h3 class="font-display text-lg font-bold text-brand-darkest">Daftar Inventaris Buku</h3>
        </div>

        @if($bukus->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-brand-light/50 border-b border-gray-100">
                            <th class="text-left py-3 px-6 text-xs font-semibold text-gray-600 uppercase">Kode</th>
                            <th class="text-left py-3 px-6 text-xs font-semibold text-gray-600 uppercase">Judul Buku</th>
                            <th class="text-left py-3 px-6 text-xs font-semibold text-gray-600 uppercase">Kategori</th>
                            <th class="text-center py-3 px-6 text-xs font-semibold text-gray-600 uppercase">Kondisi</th>
                            <th class="text-right py-3 px-6 text-xs font-semibold text-gray-600 uppercase">Harga</th>
                            <th class="text-center py-3 px-6 text-xs font-semibold text-gray-600 uppercase">Stok</th>
                            <th class="text-right py-3 px-6 text-xs font-semibold text-gray-600 uppercase">Nilai</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($bukus as $buku)
                            @php $nilai = $buku->stok * $buku->harga; @endphp
                            <tr class="hover:bg-brand-light/30 transition-colors {{ $buku->stok <= $buku->stok_minimum ? 'bg-red-50/30' : '' }}">
                                <td class="py-3 px-6 text-sm font-mono text-brand-primary">{{ $buku->kode_buku }}</td>
                                <td class="py-3 px-6">
                                    <p class="font-semibold text-brand-darkest text-sm">{{ $buku->judul }}</p>
                                    <p class="text-xs text-gray-500">{{ $buku->pengarang }}</p>
                                </td>
                                <td class="py-3 px-6">
                                    <span class="px-2 py-1 rounded text-xs font-medium text-white" 
                                          style="background-color: {{ $buku->kategori->warna_label }}">
                                        {{ $buku->kategori->nama_kategori }}
                                    </span>
                                </td>
                                <td class="py-3 px-6 text-center">
                                    <span class="text-xs font-medium text-gray-600 capitalize">
                                        {{ str_replace('_', ' ', $buku->kondisi) }}
                                    </span>
                                </td>
                                <td class="py-3 px-6 text-right text-sm text-gray-600">{{ format_rupiah($buku->harga) }}</td>
                                <td class="py-3 px-6 text-center">
                                    @if($buku->stok <= $buku->stok_minimum)
                                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-red-100 text-red-700 font-bold text-sm">
                                            {{ $buku->stok }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-green-100 text-green-700 font-bold text-sm">
                                            {{ $buku->stok }}
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3 px-6 text-right font-display font-bold text-brand-darkest">{{ format_rupiah($nilai) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50 border-t-2 border-gray-200">
                        <tr>
                            <td colspan="6" class="py-4 px-6 text-right font-bold text-brand-darkest">TOTAL NILAI INVENTARIS</td>
                            <td class="py-4 px-6 text-right font-display text-xl font-bold text-green-600">{{ format_rupiah($nilaiInventaris) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        @else
            <div class="py-16 text-center">
                <div class="w-16 h-16 mx-auto rounded-full bg-gray-100 flex items-center justify-center mb-3">
                    <i class="fas fa-inbox text-2xl text-gray-400"></i>
                </div>
                <p class="text-sm text-gray-500">Tidak ada data buku yang sesuai dengan filter.</p>
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