@extends('layouts.app')

@section('title', 'Data Pelanggan')
@section('page-title', 'Data Pelanggan')
@section('page-subtitle', 'Kelola data pelanggan toko Anda')

@section('content')
<div class="space-y-6">
    <!-- Header Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-forest-500 to-forest-700 text-moonlight-50 flex items-center justify-center shadow-lg">
                <i class="fas fa-users text-xl"></i>
            </div>
            <div>
                <h3 class="font-display text-lg font-bold text-forest-900">Daftar Pelanggan</h3>
                <p class="text-xs text-forest-500">Total {{ $pelanggans->total() }} pelanggan</p>
            </div>
        </div>
        <a href="{{ route('pelanggan.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-br from-forest-500 to-forest-700 text-moonlight-50 rounded-xl font-semibold text-sm shadow-md hover:shadow-lg hover:from-forest-600 hover:to-forest-800 transition-all">
            <i class="fas fa-plus text-sm"></i>
            <span>Tambah Pelanggan</span>
        </a>
    </div>

    <!-- Search & Filter -->
    <div class="card">
        <form method="GET" action="{{ route('pelanggan.index') }}" class="flex flex-col md:flex-row gap-3">
            <div class="flex-1 relative">
                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-forest-400"></i>
                <input type="text" name="search" value="{{ request('search') }}" 
                      placeholder="Cari nama, telepon, atau kode..."
                      class="w-full pl-11 pr-4 py-2.5 bg-moonlight-50 border-2 border-forest-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-forest-300 focus:border-forest-400 text-sm text-forest-900 placeholder-forest-400">
            </div>
            @if(request('search'))
                <a href="{{ route('pelanggan.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-forest-100 text-forest-700 rounded-xl font-semibold text-sm hover:bg-forest-200 transition-colors">
                    <i class="fas fa-times text-sm"></i>
                    <span>Reset</span>
                </a>
            @endif
        </form>
    </div>

    <!-- Table -->
    <div class="card overflow-hidden p-0">
        @if($pelanggans->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gradient-to-r from-forest-50 to-moonlight-50 border-b border-forest-200">
                            <th class="text-left py-4 px-6 text-xs font-semibold text-forest-700 uppercase tracking-wider">Kode</th>
                            <th class="text-left py-4 px-6 text-xs font-semibold text-forest-700 uppercase tracking-wider">Nama Pelanggan</th>
                            <th class="text-left py-4 px-6 text-xs font-semibold text-forest-700 uppercase tracking-wider">Kontak</th>
                            <th class="text-left py-4 px-6 text-xs font-semibold text-forest-700 uppercase tracking-wider">Alamat</th>
                            <th class="text-left py-4 px-6 text-xs font-semibold text-forest-700 uppercase tracking-wider">Tgl Lahir</th>
                            <th class="text-right py-4 px-6 text-xs font-semibold text-forest-700 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-forest-100">
                        @foreach($pelanggans as $pelanggan)
                            <tr class="hover:bg-forest-50/50 transition-colors group">
                                <td class="py-4 px-6 text-sm font-mono text-forest-600 font-semibold">{{ $pelanggan->kode_pelanggan }}</td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-forest-400 to-forest-600 text-moonlight-50 flex items-center justify-center font-bold text-sm shadow-md">
                                            {{ strtoupper(substr($pelanggan->nama, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-semibold text-forest-900 text-sm">{{ $pelanggan->nama }}</p>
                                            @if($pelanggan->catatan)
                                                <p class="text-xs text-forest-500 truncate max-w-[200px]" title="{{ $pelanggan->catatan }}">{{ $pelanggan->catatan }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-6 text-sm">
                                    @if($pelanggan->telepon)
                                        <p class="flex items-center gap-2 text-forest-700">
                                            <i class="fas fa-phone text-xs text-forest-400"></i> 
                                            {{ $pelanggan->telepon }}
                                        </p>
                                    @endif
                                    @if($pelanggan->email)
                                        <p class="flex items-center gap-2 mt-1 text-forest-600">
                                            <i class="fas fa-envelope text-xs text-forest-400"></i> 
                                            {{ $pelanggan->email }}
                                        </p>
                                    @endif
                                    @if(!$pelanggan->telepon && !$pelanggan->email)
                                        <span class="text-forest-400">-</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-sm text-forest-600 max-w-xs truncate">
                                    {{ $pelanggan->alamat ?? '-' }}
                                </td>
                                <td class="py-4 px-6 text-sm text-forest-600">
                                    {{ $pelanggan->tanggal_lahir ? format_tanggal($pelanggan->tanggal_lahir) : '-' }}
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('pelanggan.edit', $pelanggan) }}" 
                                           class="w-9 h-9 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 hover:scale-110 flex items-center justify-center transition-all"
                                           title="Edit">
                                            <i class="fas fa-pen text-xs"></i>
                                        </a>
                                        <form method="POST" action="{{ route('pelanggan.destroy', $pelanggan) }}" 
                                              onsubmit="return confirm('Yakin ingin menghapus pelanggan ini?')" class="inline">
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
                {{ $pelanggans->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="py-16 text-center">
                <div class="w-20 h-20 mx-auto rounded-full bg-forest-100 flex items-center justify-center mb-4">
                    <i class="fas fa-users text-3xl text-forest-400"></i>
                </div>
                <h4 class="font-display text-lg font-bold text-forest-900 mb-2">Belum Ada Pelanggan</h4>
                <p class="text-sm text-forest-500 mb-6">Mulai dengan menambahkan pelanggan pertama Anda</p>
                <a href="{{ route('pelanggan.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-br from-forest-500 to-forest-700 text-moonlight-50 rounded-xl font-semibold text-sm shadow-md hover:shadow-lg hover:from-forest-600 hover:to-forest-800 transition-all">
                    <i class="fas fa-plus text-sm"></i>
                    <span>Tambah Pelanggan</span>
                </a>
            </div>
        @endif
    </div>
</div>
@endsection