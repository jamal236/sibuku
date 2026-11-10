{{-- resources/views/admin/buku/create.blade.php --}}
{{-- (Untuk edit.blade.php: ganti @section('title') & action form, tambahkan @method('PUT') --}}
@extends('layouts.app')

@section('title', 'Tambah Buku')
@section('breadcrumb', 'Master Data / Buku / Tambah')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Tambah Buku Baru</h1>
        <p class="page-subtitle">Isi data buku bekas / preloved</p>
    </div>
    <a href="{{ route('admin.buku.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
</div>

<form action="{{ route('admin.buku.store') }}" method="POST">
    @csrf

    <div class="row g-4">

        {{-- Kolom Kiri: Info Buku --}}
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header card-header-brown">
                    <i class="bi bi-book me-2"></i>Informasi Buku
                </div>
                <div class="card-body">

                    <div class="mb-3">
                        <label class="form-label">Judul Buku <span class="text-danger">*</span></label>
                        <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror"
                               value="{{ old('judul') }}" placeholder="Masukkan judul lengkap buku..." autofocus>
                        @error('judul')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Pengarang</label>
                            <input type="text" name="pengarang"
                                   class="form-control @error('pengarang') is-invalid @enderror"
                                   value="{{ old('pengarang') }}" placeholder="Nama pengarang...">
                            @error('pengarang')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">ISBN</label>
                            <input type="text" name="isbn"
                                   class="form-control @error('isbn') is-invalid @enderror"
                                   value="{{ old('isbn') }}" placeholder="978-602-xxx">
                            @error('isbn')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="row g-3 mt-1">
                        <div class="col-md-6">
                            <label class="form-label">Kategori <span class="text-danger">*</span></label>
                            @if($kategori->isEmpty())
                                <div class="alert alert-warning py-2" style="font-size:.82rem;">
                                    <i class="bi bi-exclamation-triangle me-1"></i>
                                    Belum ada kategori. <a href="{{ route('admin.kategori.create') }}">Tambah dulu</a>.
                                </div>
                            @else
                            <select name="kategori_id" class="form-select @error('kategori_id') is-invalid @enderror">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($kategori as $kat)
                                <option value="{{ $kat->id }}" {{ old('kategori_id') == $kat->id ? 'selected' : '' }}>
                                    {{ $kat->nama_kategori }}
                                </option>
                                @endforeach
                            </select>
                            @error('kategori_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            @endif
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Kondisi Fisik <span class="text-danger">*</span></label>
                            <select name="kondisi" class="form-select @error('kondisi') is-invalid @enderror"
                                    id="kondisiSelect">
                                <option value="">-- Pilih Kondisi --</option>
                                @foreach($kondisiOptions as $val => $label)
                                <option value="{{ $val }}" {{ old('kondisi') == $val ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                                @endforeach
                            </select>
                            @error('kondisi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    {{-- Preview badge kondisi --}}
                    <div id="kondisiPreview" class="mt-2" style="display:none;">
                        <span id="kondisiBadge" class="badge"></span>
                        <small class="text-muted ms-2" id="kondisiDesc"></small>
                    </div>

                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header card-header-pale">
                    <i class="bi bi-currency-dollar me-2"></i>Harga & Stok
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Harga Beli (Rp) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text" style="border-color:#D7CCC8;">Rp</span>
                                <input type="number" name="harga_beli"
                                       class="form-control @error('harga_beli') is-invalid @enderror"
                                       value="{{ old('harga_beli', 0) }}" min="0" step="500"
                                       id="hargaBeli">
                                @error('harga_beli')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-text">Harga buku dari supplier/donatur.</div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Harga Jual (Rp) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text" style="border-color:#D7CCC8;">Rp</span>
                                <input type="number" name="harga"
                                       class="form-control @error('harga') is-invalid @enderror"
                                       value="{{ old('harga', 0) }}" min="0" step="500"
                                       id="hargaJual">
                                @error('harga')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-text" id="marginInfo">—</div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Stok Awal <span class="text-danger">*</span></label>
                            <input type="number" name="stok"
                                   class="form-control @error('stok') is-invalid @enderror"
                                   value="{{ old('stok', 1) }}" min="0">
                            @error('stok')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <div class="form-text">Jumlah unit buku yang tersedia.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Kolom Kanan: Info Tambahan --}}
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header card-header-pale">
                    <i class="bi bi-info-circle me-2"></i>Info Tambahan
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Lokasi Rak</label>
                        <input type="text" name="rak_penyimpanan"
                               class="form-control @error('rak_penyimpanan') is-invalid @enderror"
                               value="{{ old('rak_penyimpanan') }}" placeholder="Contoh: Rak A-3, Baris 2">
                        @error('rak_penyimpanan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <div class="form-text">Lokasi fisik buku di rak toko.</div>
                    </div>
                </div>
            </div>

            {{-- Panduan Kondisi --}}
            <div class="card mt-3" style="border-left: 3px solid var(--amber);">
                <div class="card-body py-3">
                    <h6 class="mb-3" style="color:var(--brown); font-size:.85rem; font-weight:600;">
                        <i class="bi bi-lightbulb me-2 text-warning"></i>Panduan Kondisi
                    </h6>
                    <div class="d-flex flex-column gap-2" style="font-size:.8rem;">
                        <div>
                            <span class="badge badge-kondisi-sangat-baik me-1">Sangat Baik</span>
                            Halaman lengkap, tidak ada coretan, cover mulus
                        </div>
                        <div>
                            <span class="badge badge-kondisi-baik me-1">Baik</span>
                            Sedikit bekas lipatan, tidak ada sobekan, masih layak baca
                        </div>
                        <div>
                            <span class="badge badge-kondisi-cukup me-1">Cukup</span>
                            Ada coretan/stempel, cover lecek, isi masih lengkap
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tombol Aksi --}}
            <div class="card mt-3">
                <div class="card-body">
                    <button type="submit" class="btn btn-amber w-100 mb-2">
                        <i class="bi bi-save me-2"></i>Simpan Buku
                    </button>
                    <a href="{{ route('admin.buku.index') }}" class="btn btn-outline-secondary w-100">
                        <i class="bi bi-x me-2"></i>Batal
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
// Preview badge kondisi saat dipilih
const kondisiSelect = document.getElementById('kondisiSelect');
const kondisiPreview = document.getElementById('kondisiPreview');
const kondisiBadge = document.getElementById('kondisiBadge');
const kondisiDesc = document.getElementById('kondisiDesc');

const kondisiMap = {
    sangat_baik: { label: '✨ Sangat Baik', cls: 'badge-kondisi-sangat-baik', desc: 'Harga tertinggi — kondisi prima' },
    baik:        { label: '👍 Baik',        cls: 'badge-kondisi-baik',        desc: 'Kondisi umum buku bekas' },
    cukup:       { label: '📄 Cukup',       cls: 'badge-kondisi-cukup',       desc: 'Pertimbangkan diskon harga' },
};

kondisiSelect.addEventListener('change', function() {
    const val = this.value;
    if (kondisiMap[val]) {
        kondisiBadge.className = 'badge ' + kondisiMap[val].cls;
        kondisiBadge.textContent = kondisiMap[val].label;
        kondisiDesc.textContent = kondisiMap[val].desc;
        kondisiPreview.style.display = 'block';
    } else {
        kondisiPreview.style.display = 'none';
    }
});

// Hitung margin harga
const hargaBeli = document.getElementById('hargaBeli');
const hargaJual = document.getElementById('hargaJual');
const marginInfo = document.getElementById('marginInfo');

function updateMargin() {
    const beli = parseInt(hargaBeli.value) || 0;
    const jual = parseInt(hargaJual.value) || 0;
    const margin = jual - beli;
    if (beli > 0 && jual > 0) {
        const pct = ((margin / beli) * 100).toFixed(1);
        marginInfo.innerHTML = `Margin: <strong style="color:${margin >= 0 ? 'var(--brown)' : '#dc3545'}">
            Rp ${margin.toLocaleString('id-ID')} (${pct}%)</strong>`;
    } else {
        marginInfo.textContent = '—';
    }
}

hargaBeli.addEventListener('input', updateMargin);
hargaJual.addEventListener('input', updateMargin);
</script>
@endpush