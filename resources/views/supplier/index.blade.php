@extends('layouts.app')

@section('title', 'Data Supplier & Donatur')
@section('page-title', 'Data Supplier & Donatur')
@section('page-subtitle', 'Kelola pemasok buku dan donatur toko Anda')

@section('content')
<div class="space-y-6">
    <!-- Header Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-forest-500 to-forest-700 text-moonlight-50 flex items-center justify-center shadow-lg">
                <i class="fas fa-truck text-xl"></i>
            </div>
            <div>
                <h3 class="font-display text-lg font-bold text-forest-900">Daftar Supplier</h3>
                <p class="text-xs text-forest-500">Total {{ $suppliers->total() }} supplier/donatur</p>
            </div>
        </div>
        <a href="{{ route('supplier.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-br from-forest-500 to-forest-700 text-moonlight-50 rounded-xl font-semibold text-sm shadow-md hover:shadow-lg hover:from-forest-600 hover:to-forest-800 transition-all">
            <i class="fas fa-plus text-sm"></i>
            <span>Tambah Supplier</span>
        </a>
    </div>

    <!-- Search & Filter -->
    <div class="card">
        <form method="GET" action="{{ route('supplier.index') }}" class="flex flex-col md:flex-row gap-3">
            <div class="flex-1 relative">
                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-forest-400"></i>
                <input type="text" name="search" value="{{ request('search') }}" 
                      placeholder="Cari nama atau telepon..."
                      class="w-full pl-11 pr-4 py-2.5 bg-moonlight-50 border-2 border-forest-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-forest-300 focus:border-forest-400 text-sm text-forest-900 placeholder-forest-400">
            </div>
            <select name="jenis" onchange="this.form.submit()"
                   class="px-4 py-2.5 bg-moonlight-50 border-2 border-forest-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-forest-300 focus:border-forest-400 text-sm text-forest-900">
                <option value="">Semua Jenis</option>
                <option value="supplier" {{ request('jenis') === 'supplier' ? 'selected' : '' }}>Supplier</option>
                <option value="donatur" {{ request('jenis') === 'donatur' ? 'selected' : '' }}>Donatur</option>
            </select>
            @if(request()->anyFilled(['search', 'jenis']))
                <a href="{{ route('supplier.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-forest-100 text-forest-700 rounded-xl font-semibold text-sm hover:bg-forest-200 transition-colors">
                    <i class="fas fa-times text-sm"></i>
                    <span>Reset</span>
                </a>
            @endif
        </form>
    </div>

    <!-- Table -->
    <div class="card overflow-hidden p-0">
        @if($suppliers->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gradient-to-r from-forest-50 to-moonlight-50 border-b border-forest-200">
                            <th class="text-left py-4 px-6 text-xs font-semibold text-forest-700 uppercase tracking-wider">Kode</th>
                            <th class="text-left py-4 px-6 text-xs font-semibold text-forest-700 uppercase tracking-wider">Nama</th>
                            <th class="text-center py-4 px-6 text-xs font-semibold text-forest-700 uppercase tracking-wider">Jenis</th>
                            <th class="text-left py-4 px-6 text-xs font-semibold text-forest-700 uppercase tracking-wider">Kontak</th>
                            <th class="text-center py-4 px-6 text-xs font-semibold text-forest-700 uppercase tracking-wider">Status</th>
                            <th class="text-right py-4 px-6 text-xs font-semibold text-forest-700 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-forest-100">
                        @foreach($suppliers as $supplier)
                            <tr class="hover:bg-forest-50/50 transition-colors group">
                                <td class="py-4 px-6 text-sm font-mono text-forest-600 font-semibold">{{ $supplier->kode_supplier }}</td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full {{ $supplier->jenis === 'supplier' ? 'bg-gradient-to-br from-blue-400 to-blue-600' : 'bg-gradient-to-br from-purple-400 to-purple-600' }} text-moonlight-50 flex items-center justify-center font-bold text-sm shadow-md">
                                            <i class="fas {{ $supplier->jenis === 'supplier' ? 'fa-truck' : 'fa-hand-holding-heart' }} text-xs"></i>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-forest-900 text-sm">{{ $supplier->nama }}</p>
                                            @if($supplier->keterangan)
                                                <p class="text-xs text-forest-500 truncate max-w-[200px]" title="{{ $supplier->keterangan }}">{{ $supplier->keterangan }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-6 text-center">
                                    @if($supplier->jenis === 'supplier')
                                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-700">
                                            <i class="fas fa-truck text-xs"></i> Supplier
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-700">
                                            <i class="fas fa-hand-holding-heart text-xs"></i> Donatur
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-sm">
                                    @if($supplier->telepon)
                                        <p class="flex items-center gap-2 text-forest-700">
                                            <i class="fas fa-phone text-xs text-forest-400"></i> 
                                            {{ $supplier->telepon }}
                                        </p>
                                    @endif
                                    @if($supplier->email)
                                        <p class="flex items-center gap-2 mt-1 text-forest-600">
                                            <i class="fas fa-envelope text-xs text-forest-400"></i> 
                                            {{ $supplier->email }}
                                        </p>
                                    @endif
                                    @if(!$supplier->telepon && !$supplier->email)
                                        <span class="text-forest-400">-</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-center">
                                    @if($supplier->is_aktif)
                                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                            <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span> Nonaktif
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('supplier.edit', $supplier) }}" 
                                           class="w-9 h-9 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 hover:scale-110 flex items-center justify-center transition-all"
                                           title="Edit">
                                            <i class="fas fa-pen text-xs"></i>
                                        </a>
                                        <form method="POST" action="{{ route('supplier.destroy', $supplier) }}" 
                                              onsubmit="return confirm('Yakin ingin menghapus supplier ini?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="w-9 h-9 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 hover:scale-110 flex items-center justify-center transition-all"
                                                    title="Hapus">
                                                <i class="fas fa-trash text-xs"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-forest-200 bg-gradient-to-r from-forest-50 to-moonlight-50">
                {{ $suppliers->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="py-16 text-center">
                <div class="w-20 h-20 mx-auto rounded-full bg-forest-100 flex items-center justify-center mb-4">
                    <i class="fas fa-truck text-3xl text-forest-400"></i>
                </div>
                <h4 class="font-display text-lg font-bold text-forest-900 mb-2">Belum Ada Supplier</h4>
                <p class="text-sm text-forest-500 mb-6">Mulai dengan menambahkan supplier atau donatur pertama Anda</p>
                <a href="{{ route('supplier.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-br from-forest-500 to-forest-700 text-moonlight-50 rounded-xl font-semibold text-sm shadow-md hover:shadow-lg hover:from-forest-600 hover:to-forest-800 transition-all">
                    <i class="fas fa-plus text-sm"></i>
                    <span>Tambah Supplier</span>
                </a>
            </div>
        @endif
    </div>
</div>
@endsection