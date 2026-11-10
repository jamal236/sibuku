@extends('layouts.app')

@section('title', 'Edit Kategori')
@section('page-title', 'Edit Kategori')
@section('page-subtitle', 'Perbarui informasi kategori buku')

@section('content')
<div class="max-w-3xl">
    <!-- Back Button -->
    <a href="{{ route('kategori.index') }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-brand-primary mb-6 transition-colors">
        <i class="fas fa-arrow-left"></i>
        <span>Kembali ke Daftar Kategori</span>
    </a>

    <form method="POST" action="{{ route('kategori.update', $kategori) }}" class="card space-y-6">
        @csrf
        @method('PUT')

        <!-- Nama Kategori -->
        <div>
            <label for="nama_kategori" class="block text-sm font-semibold text-brand-darkest mb-2">
                Nama Kategori <span class="text-red-500">*</span>
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <i class="fas fa-tag text-gray-400 text-sm"></i>
                </div>
                <input type="text" id="nama_kategori" name="nama_kategori" 
                       value="{{ old('nama_kategori', $kategori->nama_kategori) }}" required
                       placeholder="Contoh: Novel, Buku Pelajaran, Komik"
                       class="w-full pl-11 pr-4 py-3 bg-brand-light/30 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-transparent text-sm">
            </div>
            @error('nama_kategori')
                <p class="mt-2 text-xs text-red-500 flex items-center gap-1">
                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Deskripsi -->
        <div>
            <label for="deskripsi" class="block text-sm font-semibold text-brand-darkest mb-2">
                Deskripsi <span class="text-gray-400 font-normal">(Opsional)</span>
            </label>
            <textarea id="deskripsi" name="deskripsi" rows="3"
                      placeholder="Deskripsi singkat tentang kategori ini..."
                      class="w-full px-4 py-3 bg-brand-light/30 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-transparent text-sm resize-none">{{ old('deskripsi', $kategori->deskripsi) }}</textarea>
            @error('deskripsi')
                <p class="mt-2 text-xs text-red-500 flex items-center gap-1">
                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                </p>
            @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Warna Label -->
            <div>
                <label for="warna_label" class="block text-sm font-semibold text-brand-darkest mb-2">
                    Warna Label <span class="text-red-500">*</span>
                </label>
                <div class="flex gap-3">
                    <div class="relative flex-1">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-palette text-gray-400 text-sm"></i>
                        </div>
                        <input type="text" id="warna_label" name="warna_label" 
                               value="{{ old('warna_label', $kategori->warna_label) }}" required
                               placeholder="#235347"
                               class="w-full pl-11 pr-4 py-3 bg-brand-light/30 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-transparent text-sm font-mono">
                    </div>
                    <div class="relative">
                        <input type="color" id="colorPicker" value="{{ old('warna_label', $kategori->warna_label) }}"
                               class="w-14 h-12 rounded-xl border border-gray-200 cursor-pointer">
                    </div>
                </div>
                @error('warna_label')
                    <p class="mt-2 text-xs text-red-500 flex items-center gap-1">
                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Urutan Tampil -->
            <div>
                <label for="urutan_tampil" class="block text-sm font-semibold text-brand-darkest mb-2">
                    Urutan Tampil <span class="text-gray-400 font-normal">(Opsional)</span>
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fas fa-sort-numeric-up text-gray-400 text-sm"></i>
                    </div>
                    <input type="number" id="urutan_tampil" name="urutan_tampil" 
                           value="{{ old('urutan_tampil', $kategori->urutan_tampil) }}" min="1" max="999"
                           placeholder="99"
                           class="w-full pl-11 pr-4 py-3 bg-brand-light/30 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-transparent text-sm">
                </div>
                <p class="mt-1 text-xs text-gray-500">Semakin kecil angkanya, semakin atas posisinya</p>
                @error('urutan_tampil')
                    <p class="mt-2 text-xs text-red-500 flex items-center gap-1">
                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                    </p>
                @enderror
            </div>
        </div>

        <!-- Status Aktif -->
        <div class="flex items-center gap-3 p-4 bg-brand-light/30 rounded-xl border border-brand-light">
            <input type="checkbox" id="is_aktif" name="is_aktif" value="1" 
                   {{ old('is_aktif', $kategori->is_aktif) ? 'checked' : '' }}
                   class="w-5 h-5 rounded border-gray-300 text-brand-primary focus:ring-brand-primary cursor-pointer">
            <label for="is_aktif" class="flex-1 cursor-pointer">
                <span class="block text-sm font-semibold text-brand-darkest">Kategori Aktif</span>
                <span class="block text-xs text-gray-500">Kategori aktif akan ditampilkan di daftar buku</span>
            </label>
        </div>

        <!-- Preview Badge -->
        <div class="p-4 bg-gray-50 rounded-xl border border-gray-200">
            <p class="text-xs font-semibold text-gray-600 uppercase tracking-wider mb-3">Preview Badge</p>
            <div class="flex items-center gap-3">
                <span id="previewBadge" 
                      class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-semibold text-white shadow-sm"
                      style="background-color: {{ old('warna_label', $kategori->warna_label) }}">
                    <span class="w-2 h-2 rounded-full bg-white/50"></span>
                    <span id="previewText">{{ old('nama_kategori', $kategori->nama_kategori) }}</span>
                </span>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
            <a href="{{ route('kategori.index') }}" class="btn-secondary inline-flex items-center gap-2">
                <i class="fas fa-times text-sm"></i>
                <span>Batal</span>
            </a>
            <button type="submit" class="btn-primary inline-flex items-center gap-2">
                <i class="fas fa-save text-sm"></i>
                <span>Perbarui Kategori</span>
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    const colorPicker = document.getElementById('colorPicker');
    const warnaInput = document.getElementById('warna_label');
    const previewBadge = document.getElementById('previewBadge');
    const previewText = document.getElementById('previewText');
    const namaInput = document.getElementById('nama_kategori');

    colorPicker.addEventListener('input', (e) => {
        warnaInput.value = e.target.value.toUpperCase();
        previewBadge.style.backgroundColor = e.target.value;
    });

    warnaInput.addEventListener('input', (e) => {
        if (/^#[0-9A-Fa-f]{6}$/.test(e.target.value)) {
            colorPicker.value = e.target.value;
            previewBadge.style.backgroundColor = e.target.value;
        }
    });

    namaInput.addEventListener('input', (e) => {
        previewText.textContent = e.target.value || 'Nama Kategori';
    });
</script>
@endpush
@endsection