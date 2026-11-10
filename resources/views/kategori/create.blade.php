@extends('layouts.app')

@section('title', 'Tambah Kategori')
@section('page-title', 'Tambah Kategori Baru')
@section('page-subtitle', 'Isi form di bawah untuk menambahkan kategori buku baru')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    <!-- Back Button -->
    <a href="{{ route('kategori.index') }}" 
       class="inline-flex items-center gap-2 text-sm text-forest-600 hover:text-forest-800 mb-4 transition-colors font-medium">
        <i class="fas fa-arrow-left"></i>
        <span>Kembali ke Daftar Kategori</span>
    </a>

    <form method="POST" action="{{ route('kategori.store') }}" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column - Main Info -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Informasi Dasar -->
                <div class="card space-y-5">
                    <h3 class="font-display text-lg font-bold text-forest-900 pb-3 border-b border-forest-200">
                        <i class="fas fa-info-circle text-forest-500 mr-2"></i>
                        Informasi Dasar
                    </h3>

                    <!-- Nama Kategori -->
                    <div>
                        <label for="nama_kategori" class="block text-sm font-semibold text-forest-800 mb-2">
                            Nama Kategori <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-tag text-forest-400"></i>
                            </div>
                            <input type="text" id="nama_kategori" name="nama_kategori" 
                                   value="{{ old('nama_kategori') }}" required
                                   placeholder="Contoh: Novel, Buku Pelajaran, Komik"
                                   class="w-full pl-11 pr-4 py-3 bg-moonlight-50 border-2 border-forest-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-forest-300 focus:border-forest-400 text-sm text-forest-900 placeholder-forest-400">
                        </div>
                        @error('nama_kategori')
                            <p class="mt-2 text-xs text-red-500 flex items-center gap-1">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Deskripsi -->
                    <div>
                        <label for="deskripsi" class="block text-sm font-semibold text-forest-800 mb-2">
                            Deskripsi <span class="text-forest-400 font-normal">(Opsional)</span>
                        </label>
                        <textarea id="deskripsi" name="deskripsi" rows="3"
                                  placeholder="Deskripsi singkat tentang kategori ini..."
                                  class="w-full px-4 py-3 bg-moonlight-50 border-2 border-forest-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-forest-300 focus:border-forest-400 text-sm text-forest-900 placeholder-forest-400 resize-none">{{ old('deskripsi') }}</textarea>
                        <p class="mt-1 text-xs text-forest-500">Maksimum 255 karakter</p>
                        @error('deskripsi')
                            <p class="mt-2 text-xs text-red-500 flex items-center gap-1">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <!-- Warna & Tampilan -->
                <div class="card space-y-5">
                    <h3 class="font-display text-lg font-bold text-forest-900 pb-3 border-b border-forest-200">
                        <i class="fas fa-palette text-forest-500 mr-2"></i>
                        Warna & Tampilan
                    </h3>

                    <!-- Warna Label -->
                    <div>
                        <label class="block text-sm font-semibold text-forest-800 mb-3">
                            Warna Label <span class="text-red-500">*</span>
                        </label>
                        
                        <!-- Preset Colors -->
                        <div class="mb-4">
                            <p class="text-xs text-forest-600 mb-2 font-medium">Pilih warna preset:</p>
                            <div class="grid grid-cols-8 gap-2">
                                @php
                                    $presetColors = [
                                        '#4A6B3D' => 'Forest Green',
                                        '#8B4513' => 'Saddle Brown',
                                        '#DC143C' => 'Crimson',
                                        '#4169E1' => 'Royal Blue',
                                        '#FF8C00' => 'Dark Orange',
                                        '#800080' => 'Purple',
                                        '#008B8B' => 'Dark Cyan',
                                        '#FFD700' => 'Gold',
                                        '#FF69B4' => 'Hot Pink',
                                        '#2F4F4F' => 'Dark Slate',
                                        '#32CD32' => 'Lime Green',
                                        '#9370DB' => 'Medium Purple',
                                        '#FF4500' => 'Orange Red',
                                        '#1E90FF' => 'Dodger Blue',
                                        '#DCDCDC' => 'Gainsboro',
                                        '#696969' => 'Dim Gray',
                                    ];
                                @endphp
                                @foreach($presetColors as $color => $name)
                                    <button type="button" 
                                            onclick="selectPresetColor('{{ $color }}', '{{ $name }}')"
                                            class="preset-color w-full aspect-square rounded-lg border-2 border-forest-200 hover:border-forest-500 hover:scale-110 transition-all relative group"
                                            style="background-color: {{ $color }}"
                                            title="{{ $name }}">
                                        <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                            <i class="fas fa-check text-white text-xs drop-shadow-lg"></i>
                                        </div>
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        <!-- Custom Color -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="warna_label" class="block text-xs font-semibold text-forest-700 mb-2">
                                    Kode Warna Hex
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i class="fas fa-hashtag text-forest-400 text-sm"></i>
                                    </div>
                                    <input type="text" id="warna_label" name="warna_label" 
                                           value="{{ old('warna_label', '#4A6B3D') }}" required
                                           placeholder="#4A6B3D"
                                           class="w-full pl-11 pr-4 py-3 bg-moonlight-50 border-2 border-forest-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-forest-300 focus:border-forest-400 text-sm text-forest-900 font-mono uppercase">
                                </div>
                                @error('warna_label')
                                    <p class="mt-2 text-xs text-red-500 flex items-center gap-1">
                                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-forest-700 mb-2">
                                    Color Picker
                                </label>
                                <div class="relative">
                                    <input type="color" id="colorPicker" value="{{ old('warna_label', '#4A6B3D') }}"
                                           class="w-full h-[46px] rounded-xl border-2 border-forest-200 cursor-pointer hover:border-forest-400 transition-colors">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Urutan Tampil -->
                    <div>
                        <label for="urutan_tampil" class="block text-sm font-semibold text-forest-800 mb-2">
                            Urutan Tampil <span class="text-forest-400 font-normal">(Opsional)</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-sort-numeric-up text-forest-400"></i>
                            </div>
                            <input type="number" id="urutan_tampil" name="urutan_tampil" 
                                   value="{{ old('urutan_tampil', 99) }}" min="1" max="999"
                                   placeholder="99"
                                   class="w-full pl-11 pr-4 py-3 bg-moonlight-50 border-2 border-forest-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-forest-300 focus:border-forest-400 text-sm text-forest-900 placeholder-forest-400">
                        </div>
                        <p class="mt-1 text-xs text-forest-500">
                            <i class="fas fa-info-circle mr-1"></i>
                            Semakin kecil angkanya, semakin atas posisinya di daftar
                        </p>
                        @error('urutan_tampil')
                            <p class="mt-2 text-xs text-red-500 flex items-center gap-1">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Right Column - Preview & Settings -->
            <div class="space-y-6">
                <!-- Live Preview -->
                <div class="card space-y-5 sticky top-6">
                    <h3 class="font-display text-lg font-bold text-forest-900 pb-3 border-b border-forest-200">
                        <i class="fas fa-eye text-forest-500 mr-2"></i>
                        Preview Langsung
                    </h3>

                    <!-- Badge Preview -->
                    <div class="p-4 bg-gradient-to-br from-forest-50 to-moonlight-50 rounded-xl border border-forest-200">
                        <p class="text-xs font-semibold text-forest-600 uppercase tracking-wider mb-3">Badge Kategori</p>
                        <div class="flex items-center gap-3">
                            <span id="previewBadge" 
                                  class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-semibold text-white shadow-md transition-all duration-300"
                                  style="background-color: {{ old('warna_label', '#4A6B3D') }}">
                                <span class="w-2 h-2 rounded-full bg-white/50"></span>
                                <span id="previewText">{{ old('nama_kategori') ?: 'Nama Kategori' }}</span>
                            </span>
                        </div>
                    </div>

                    <!-- Book Card Preview -->
                    <div class="p-4 bg-gradient-to-br from-forest-50 to-moonlight-50 rounded-xl border border-forest-200">
                        <p class="text-xs font-semibold text-forest-600 uppercase tracking-wider mb-3">Di Card Buku</p>
                        <div class="bg-white rounded-xl p-3 shadow-sm border border-forest-100">
                            <div class="flex items-center gap-2 mb-2">
                                <span id="previewBadgeSmall" 
                                      class="px-2.5 py-1 rounded-md text-xs font-bold text-white shadow-sm transition-all duration-300"
                                      style="background-color: {{ old('warna_label', '#4A6B3D') }}">
                                    <span id="previewTextSmall">{{ old('nama_kategori') ?: 'Nama Kategori' }}</span>
                                </span>
                                <span class="text-xs text-forest-400 font-mono">BK001</span>
                            </div>
                            <h4 class="font-display font-bold text-forest-900 text-sm mb-1">Contoh Judul Buku</h4>
                            <p class="text-xs text-forest-500">Nama Pengarang</p>
                        </div>
                    </div>

                    <!-- Color Info -->
                    <div class="p-4 bg-forest-50 rounded-xl border border-forest-200">
                        <p class="text-xs font-semibold text-forest-700 mb-2">Informasi Warna</p>
                        <div class="space-y-2 text-xs">
                            <div class="flex items-center justify-between">
                                <span class="text-forest-600">Hex Code:</span>
                                <span id="colorInfoHex" class="font-mono font-bold text-forest-900">#4A6B3D</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-forest-600">Preview:</span>
                                <div id="colorInfoBox" class="w-6 h-6 rounded-md border border-forest-200 shadow-sm" 
                                     style="background-color: {{ old('warna_label', '#4A6B3D') }}"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Status Aktif -->
                <div class="card">
                    <div class="flex items-center gap-3 p-4 bg-forest-50 rounded-xl border border-forest-200">
                        <input type="checkbox" id="is_aktif" name="is_aktif" value="1" 
                               {{ old('is_aktif', true) ? 'checked' : '' }}
                               class="w-5 h-5 rounded border-forest-300 text-forest-600 focus:ring-forest-500 cursor-pointer">
                        <label for="is_aktif" class="flex-1 cursor-pointer">
                            <span class="block text-sm font-semibold text-forest-900">Kategori Aktif</span>
                            <span class="block text-xs text-forest-500">Kategori aktif akan ditampilkan di daftar buku</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="card flex items-center justify-end gap-3">
            <a href="{{ route('kategori.index') }}" 
               class="inline-flex items-center gap-2 px-6 py-3 bg-forest-100 text-forest-700 rounded-xl font-semibold text-sm hover:bg-forest-200 transition-all">
                <i class="fas fa-times"></i>
                <span>Batal</span>
            </a>
            <button type="submit" 
                   class="inline-flex items-center gap-2 px-8 py-3 bg-gradient-to-br from-forest-500 to-forest-700 text-moonlight-50 rounded-xl font-semibold text-sm shadow-md hover:shadow-lg hover:from-forest-600 hover:to-forest-800 transition-all">
                <i class="fas fa-save"></i>
                <span>Simpan Kategori</span>
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    // Elements
    const colorPicker = document.getElementById('colorPicker');
    const warnaInput = document.getElementById('warna_label');
    const previewBadge = document.getElementById('previewBadge');
    const previewBadgeSmall = document.getElementById('previewBadgeSmall');
    const previewText = document.getElementById('previewText');
    const previewTextSmall = document.getElementById('previewTextSmall');
    const namaInput = document.getElementById('nama_kategori');
    const colorInfoHex = document.getElementById('colorInfoHex');
    const colorInfoBox = document.getElementById('colorInfoBox');

    // Function to update all previews
    function updatePreview(color, text) {
        // Update badge previews
        previewBadge.style.backgroundColor = color;
        previewBadgeSmall.style.backgroundColor = color;
        
        // Update text
        previewText.textContent = text || 'Nama Kategori';
        previewTextSmall.textContent = text || 'Nama Kategori';
        
        // Update color info
        colorInfoHex.textContent = color.toUpperCase();
        colorInfoBox.style.backgroundColor = color;
    }

    // Function to select preset color
    function selectPresetColor(color, name) {
        warnaInput.value = color.toUpperCase();
        colorPicker.value = color;
        updatePreview(color, namaInput.value);
        
        // Visual feedback - highlight selected preset
        document.querySelectorAll('.preset-color').forEach(btn => {
            btn.classList.remove('ring-2', 'ring-forest-500', 'ring-offset-2');
        });
        event.target.classList.add('ring-2', 'ring-forest-500', 'ring-offset-2');
    }

    // Color picker event
    colorPicker.addEventListener('input', (e) => {
        const color = e.target.value.toUpperCase();
        warnaInput.value = color;
        updatePreview(color, namaInput.value);
    });

    // Hex input event
    warnaInput.addEventListener('input', (e) => {
        const value = e.target.value;
        if (/^#[0-9A-Fa-f]{6}$/.test(value)) {
            colorPicker.value = value;
            updatePreview(value, namaInput.value);
        }
    });

    // Name input event
    namaInput.addEventListener('input', (e) => {
        updatePreview(warnaInput.value, e.target.value);
    });

    // Initialize preview on page load
    document.addEventListener('DOMContentLoaded', () => {
        updatePreview(warnaInput.value, namaInput.value);
    });
</script>
@endpush
@endsection