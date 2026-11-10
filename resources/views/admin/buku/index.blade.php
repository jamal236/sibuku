{{-- resources/views/admin/buku/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Daftar Buku')
@section('breadcrumb', 'Master Data / Buku')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title"><i class="bi bi-book me-2 text-amber" style="color:var(--amber)"></i>Daftar Buku</h1>
        <p class="page-subtitle">Kelola koleksi buku bekas toko</p>
    </div>
    @hasrole('admin')
    <a href="{{ route('admin.buku.create') }}" class="btn btn-amber">
        <i class="bi bi-plus-lg me-1"></i> Tambah Buku
    </a>
    @endhasrole
</div>

{{-- Filter & Pencarian --}}
<div class="card mb-4">
    <div class="card-body py-3">
        <form action="{{ route('admin.buku.index') }}" method="GET" class="row g-2 align-items-end">
            <div class="col-md-4">
                <label class="form-label">Cari Buku</label>
                <div class="input-group">
                    <span class="input-group-text" style="border-color:#D7CCC8;"><i class="bi bi-search"></i></span>
                    <input type="text" name="q" class="form-control" placeholder="Judul, pengarang, ISBN..."
                           value="{{ request('q') }}">
                </div>
            </div>
            <div class="col-md-3">
                <label class="form-label">Kategori</label>
                <select name="kategori_id" class="form-select">
                    <option value="">Semua Kategori</option>
                    @foreach($kategori as $kat)
                    <option value="{{ $kat->id }}" {{ request('kategori_id') == $kat->id ? 'selected' : '' }}>
                        {{ $kat->nama_kategori }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Kondisi</label>
                <select name="kondisi" class="form-select">
                    <option value="">Semua Kondisi</option>
                    <option value="sangat_baik" {{ request('kondisi') == 'sangat_baik' ? 'selected' : '' }}>Sangat Baik</option>
                    <option value="baik"        {{ request('kondisi') == 'baik'        ? 'selected' : '' }}>Baik</option>
                    <option value="cukup"       {{ request('kondisi') == 'cukup'       ? 'selected' : '' }}>Cukup</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Stok</label>
                <select name="stok" class="form-select">
                    <option value="">Semua</option>
                    <option value="ada"   {{ request('stok') == 'ada'   ? 'selected' : '' }}>Tersedia</option>
                    <option value="habis" {{ request('stok') == 'habis' ? 'selected' : '' }}>Habis</option>
                </select>
            </div>
            <div class="col-md-1">
                <button type="submit" class="btn btn-brown w-100"><i class="bi bi-funnel"></i></button>
            </div>
        </form>
    </div>
</div>

{{-- Tabel Buku --}}
<div class="card">
    <div class="card-header card-header-brown d-flex justify-content-between align-items-center">
        <span><i class="bi bi-table me-2"></i>Data Buku</span>
        <span class="badge bg-light text-dark" style="font-size:.78rem;">
            {{ $buku->total() }} buku ditemukan
        </span>
    </div>
    <div class="card-body p-0">
        @if($buku->isEmpty())
        <div class="text-center py-5">
            <div style="font-size:3rem; opacity:.3;">📚</div>
            <p class="text-muted mt-2">Belum ada buku. <a href="{{ route('admin.buku.create') }}">Tambah sekarang</a>.</p>
        </div>
        @else
        <div class="table-responsive">
            <table class="table table-brown mb-0">
                <thead>
                    <tr>
                        <th width="40">#</th>
                        <th>Judul & Pengarang</th>
                        <th>Kategori</th>
                        <th>Kondisi</th>
                        <th>Harga Jual</th>
                        <th>Stok</th>
                        <th>Rak</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($buku as $i => $b)
                    <tr>
                        <td class="text-muted" style="font-size:.78rem;">{{ $buku->firstItem() + $i }}</td>
                        <td>
                            <div style="font-weight:600; color:var(--brown-dark); font-size:.875rem;">
                                {{ $b->judul }}
                            </div>
                            @if($b->pengarang)
                            <div class="text-muted" style="font-size:.78rem;">{{ $b->pengarang }}</div>
                            @endif
                            @if($b->isbn)
                            <div class="text-muted" style="font-size:.72rem;">ISBN: {{ $b->isbn }}</div>
                            @endif
                        </td>
                        <td>
                            <span class="badge" style="background:var(--brown-pale); color:var(--brown);">
                                {{ $b->kategori->nama_kategori ?? '-' }}
                            </span>
                        </td>
                        <td>
                            @switch($b->kondisi)
                                @case('sangat_baik')
                                    <span class="badge badge-kondisi-sangat-baik">✨ Sangat Baik</span>
                                    @break
                                @case('baik')
                                    <span class="badge badge-kondisi-baik">👍 Baik</span>
                                    @break
                                @case('cukup')
                                    <span class="badge badge-kondisi-cukup">📄 Cukup</span>
                                    @break
                            @endswitch
                        </td>
                        <td style="font-weight:600; color:var(--brown-dark);">
                            Rp {{ number_format($b->harga, 0, ',', '.') }}
                        </td>
                        <td>
                            @if($b->stok > 0)
                                <span class="badge badge-stok-ada">
                                    <i class="bi bi-check-circle me-1"></i>{{ $b->stok }}
                                </span>
                            @else
                                <span class="badge badge-stok-habis">
                                    <i class="bi bi-x-circle me-1"></i>Habis
                                </span>
                            @endif
                        </td>
                        <td class="text-muted" style="font-size:.8rem;">{{ $b->rak_penyimpanan ?? '-' }}</td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.buku.show', $b) }}"
                                   class="btn btn-sm btn-outline-secondary" title="Detail">
                                    <i class="bi bi-eye"></i>
                                </a>
                                @hasrole('admin')
                                <a href="{{ route('admin.buku.edit', $b) }}"
                                   class="btn btn-sm btn-outline-brown" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.buku.destroy', $b) }}" method="POST"
                                      onsubmit="return confirm('Hapus buku ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                                @endhasrole
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if($buku->hasPages())
        <div class="card-footer bg-white border-top-0 pt-3">
            {{ $buku->withQueryString()->links('pagination::bootstrap-5') }}
        </div>
        @endif
        @endif
    </div>
</div>
@endsection