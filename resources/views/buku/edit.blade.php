@extends('layouts.app')

@section('title', 'Edit Buku')
@section('page-title', 'Edit Buku')
@section('page-subtitle', 'Ubah data buku yang tersimpan di inventaris')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    <!-- Back Button -->
    <a href="{{ route('buku.index') }}" 
       class="inline-flex items-center gap-2 text-sm text-forest-600 hover:text-forest-800 mb-4 transition-colors font-medium">
        <i class="fas fa-arrow-left"></i>
        <span>Kembali ke Daftar Buku</span>
    </a>

    <form method="POST" action="{{ route('buku.update', $buku) }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- ROW 1: Informasi Dasar + Kategori & Harga -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column (2/3) -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Informasi Dasar -->
                <div class="card space-y-5">
                    <h3 class="font-display text-lg font-bold text-forest-900 pb-3 border-b border-forest-200">
                        <i class="fas fa-info-circle text-forest-500 mr-2"></i>
                        Informasi Dasar
                    </h3>

                    <!-- Kode Buku (Auto) -->
                    <div>
                        <label class="block text-sm font-semibold text-forest-800 mb-2">Kode Buku</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-barcode text-forest-400"></i>
                            </div>
                            <input type="text" value="{{ $buku->kode_buku }}" disabled
                                  class="w-full pl-11 pr-4 py-3 bg-forest-100 border border-forest-200 rounded-xl text-sm text-forest-600 font-mono">
                        </div>
                        <p class="mt-1 text-xs text-forest-500">Kode buku tidak dapat diubah</p>
                    </div>

                    <!-- Judul -->
                    <div>
                        <label for="judul" class="block text-sm font-semibold text-forest-800 mb-2">
                            Judul Buku <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-book text-forest-400"></i>
                            </div>
                            <input type="text" id="judul" name="judul" value="{{ old('judul', $buku->judul) }}" required
                                  placeholder="Masukkan judul buku"
                                  class="w-full pl-11 pr-4 py-3 bg-moonlight-50 border-2 border-forest-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-forest-300 focus:border-forest-400 text-sm text-forest-900 placeholder-forest-400">
                        </div>
                        @error('judul')
                            <p class="mt-2 text-xs text-red-500 flex items-center gap-1">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Pengarang & Penerbit -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="pengarang" class="block text-sm font-semibold text-forest-800 mb-2">
                                Pengarang <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-user text-forest-400"></i>
                                </div>
                                <input type="text" id="pengarang" name="pengarang" value="{{ old('pengarang', $buku->pengarang) }}" required
                                      placeholder="Nama pengarang"
                                      class="w-full pl-11 pr-4 py-3 bg-moonlight-50 border-2 border-forest-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-forest-300 focus:border-forest-400 text-sm text-forest-900 placeholder-forest-400">
                            </div>
                            @error('pengarang')
                                <p class="mt-2 text-xs text-red-500 flex items-center gap-1">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>
                        <div>
                            <label for="penerbit" class="block text-sm font-semibold text-forest-800 mb-2">
                                Penerbit <span class="text-forest-400 font-normal">(Opsional)</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-building text-forest-400"></i>
                                </div>
                                <input type="text" id="penerbit" name="penerbit" value="{{ old('penerbit', $buku->penerbit) }}"
                                      placeholder="Nama penerbit"
                                      class="w-full pl-11 pr-4 py-3 bg-moonlight-50 border-2 border-forest-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-forest-300 focus:border-forest-400 text-sm text-forest-900 placeholder-forest-400">
                            </div>
                        </div>
                    </div>

                    <!-- Tahun & ISBN -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="tahun_terbit" class="block text-sm font-semibold text-forest-800 mb-2">
                                Tahun Terbit <span class="text-forest-400 font-normal">(Opsional)</span>
                            </label>
                            <input type="number" id="tahun_terbit" name="tahun_terbit" value="{{ old('tahun_terbit', $buku->tahun_terbit) }}" min="1900" max="{{ date('Y') }}"
                                  placeholder="2020"
                                  class="w-full px-4 py-3 bg-moonlight-50 border-2 border-forest-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-forest-300 focus:border-forest-400 text-sm text-forest-900 placeholder-forest-400">
                        </div>
                        <div>
                            <label for="isbn" class="block text-sm font-semibold text-forest-800 mb-2">
                                ISBN <span class="text-forest-400 font-normal">(Opsional)</span>
                            </label>
                            <input type="text" id="isbn" name="isbn" value="{{ old('isbn', $buku->isbn) }}"
                                  placeholder="978-602-xxx-xxx-x"
                                  class="w-full px-4 py-3 bg-moonlight-50 border-2 border-forest-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-forest-300 focus:border-forest-400 text-sm text-forest-900 placeholder-forest-400 font-mono">
                        </div>
                    </div>
                </div>

                <!-- Kondisi Buku -->
                <div class="card space-y-5">
                    <h3 class="font-display text-lg font-bold text-forest-900 pb-3 border-b border-forest-200">
                        <i class="fas fa-clipboard-check text-forest-500 mr-2"></i>
                        Kondisi Buku
                    </h3>

                    <!-- Pilihan Kondisi -->
                    <div>
                        <label class="block text-sm font-semibold text-forest-800 mb-3">
                            Kondisi <span class="text-red-500">*</span>
                        </label>
                        <div class="grid grid-cols-2 md:grid-cols-5 gap-3">
                            @php
                                $kondisiOptions = [
                                    'baru' => ['icon' => 'fa-sparkles', 'color' => 'emerald', 'label' => 'Baru'],
                                    'sangat_baik' => ['icon' => 'fa-star', 'color' => 'blue', 'label' => 'Sangat Baik'],
                                    'baik' => ['icon' => 'fa-check', 'color' => 'forest', 'label' => 'Baik'],
                                    'cukup' => ['icon' => 'fa-minus', 'color' => 'yellow', 'label' => 'Cukup'],
                                    'rusak_ringan' => ['icon' => 'fa-exclamation', 'color' => 'red', 'label' => 'Rusak Ringan'],
                                ];
                            @endphp
                            @foreach($kondisiOptions as $value => $option)
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="kondisi" value="{{ $value }}" 
                                          {{ old('kondisi', $buku->kondisi) === $value ? 'checked' : '' }}
                                          class="peer sr-only">
                                    <div class="p-4 rounded-xl border-2 border-forest-200 peer-checked:border-{{ $option['color'] }}-500 peer-checked:bg-{{ $option['color'] }}-50 hover:bg-forest-50 transition-all text-center">
                                        <i class="fas {{ $option['icon'] }} text-{{ $option['color'] }}-500 mb-2 text-xl"></i>
                                        <p class="text-xs font-semibold text-forest-700">{{ $option['label'] }}</p>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                        @error('kondisi')
                            <p class="mt-2 text-xs text-red-500 flex items-center gap-1">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Deskripsi Kondisi -->
                    <div>
                        <label for="deskripsi_kondisi" class="block text-sm font-semibold text-forest-800 mb-2">
                            Deskripsi Kondisi <span class="text-forest-400 font-normal">(Opsional)</span>
                        </label>
                        <textarea id="deskripsi_kondisi" name="deskripsi_kondisi" rows="3"
                                  placeholder="Contoh: Ada coretan pensil di halaman 5, sampul sedikit terlipat..."
                                  class="w-full px-4 py-3 bg-moonlight-50 border-2 border-forest-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-forest-300 focus:border-forest-400 text-sm text-forest-900 placeholder-forest-400 resize-none">{{ old('deskripsi_kondisi', $buku->deskripsi_kondisi) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Right Column (1/3) -->
            <div class="space-y-6">
                <!-- Kategori & Lokasi -->
                <div class="card space-y-5">
                    <h3 class="font-display text-lg font-bold text-forest-900 pb-3 border-b border-forest-200">
                        <i class="fas fa-folder text-forest-500 mr-2"></i>
                        Kategori & Lokasi
                    </h3>

                    <!-- Kategori -->
                    <div>
                        <label for="kategori_id" class="block text-sm font-semibold text-forest-800 mb-2">
                            Kategori <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-tag text-forest-400"></i>
                            </div>
                            <select id="kategori_id" name="kategori_id" required
                                   class="w-full pl-11 pr-4 py-3 bg-moonlight-50 border-2 border-forest-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-forest-300 focus:border-forest-400 text-sm text-forest-900">
                                <option value="">Pilih Kategori</option>
                                @foreach($kategoris as $kategori)
                                    <option value="{{ $kategori->id }}" {{ old('kategori_id', $buku->kategori_id) == $kategori->id ? 'selected' : '' }}>
                                        {{ $kategori->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('kategori_id')
                            <p class="mt-2 text-xs text-red-500 flex items-center gap-1">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Lokasi Rak -->
                    <div>
                        <label for="lokasi_rak" class="block text-sm font-semibold text-forest-800 mb-2">
                            Lokasi Rak <span class="text-forest-400 font-normal">(Opsional)</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-map-marker-alt text-forest-400"></i>
                            </div>
                            <input type="text" id="lokasi_rak" name="lokasi_rak" value="{{ old('lokasi_rak', $buku->lokasi_rak) }}"
                                  placeholder="Contoh: A1-05"
                                  class="w-full pl-11 pr-4 py-3 bg-moonlight-50 border-2 border-forest-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-forest-300 focus:border-forest-400 text-sm text-forest-900 placeholder-forest-400">
                        </div>
                    </div>
                </div>

                <!-- Harga & Stok -->
                <div class="card space-y-5">
                    <h3 class="font-display text-lg font-bold text-forest-900 pb-3 border-b border-forest-200">
                        <i class="fas fa-tags text-forest-500 mr-2"></i>
                        Harga & Stok
                    </h3>

                    <!-- Harga -->
                    <div>
                        <label for="harga" class="block text-sm font-semibold text-forest-800 mb-2">
                            Harga Jual <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-forest-500 font-semibold">Rp</span>
                            <input type="number" id="harga" name="harga" value="{{ old('harga', $buku->harga) }}" required min="0"
                                  placeholder="0"
                                  class="w-full pl-12 pr-4 py-3 bg-moonlight-50 border-2 border-forest-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-forest-300 focus:border-forest-400 text-sm text-forest-900 placeholder-forest-400">
                        </div>
                        @error('harga')
                            <p class="mt-2 text-xs text-red-500 flex items-center gap-1">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Stok -->
                    <div>
                        <label for="stok" class="block text-sm font-semibold text-forest-800 mb-2">
                            Stok <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-box text-forest-400"></i>
                            </div>
                            <input type="number" id="stok" name="stok" value="{{ old('stok', $buku->stok) }}" required min="0"
                                  placeholder="0"
                                  class="w-full pl-11 pr-4 py-3 bg-moonlight-50 border-2 border-forest-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-forest-300 focus:border-forest-400 text-sm text-forest-900 placeholder-forest-400">
                        </div>
                        @error('stok')
                            <p class="mt-2 text-xs text-red-500 flex items-center gap-1">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Stok Minimum -->
                    <div>
                        <label for="stok_minimum" class="block text-sm font-semibold text-forest-800 mb-2">
                            Stok Minimum <span class="text-red-500">*</span>
                        </label>
                        <input type="number" id="stok_minimum" name="stok_minimum" value="{{ old('stok_minimum', $buku->stok_minimum) }}" required min="1"
                              placeholder="1"
                              class="w-full px-4 py-3 bg-moonlight-50 border-2 border-forest-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-forest-300 focus:border-forest-400 text-sm text-forest-900 placeholder-forest-400">
                        <p class="mt-1 text-xs text-forest-500">Peringatan akan muncul jika stok di bawah angka ini</p>
                        @error('stok_minimum')
                            <p class="mt-2 text-xs text-red-500 flex items-center gap-1">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <!-- Status Aktif -->
                <div class="card">
                    <div class="flex items-center gap-3 p-4 bg-forest-50 rounded-xl border border-forest-200">
                        <input type="checkbox" id="is_aktif" name="is_aktif" value="1" 
                              {{ old('is_aktif', $buku->is_aktif) ? 'checked' : '' }}
                              class="w-5 h-5 rounded border-forest-300 text-forest-600 focus:ring-forest-500 cursor-pointer">
                        <label for="is_aktif" class="flex-1 cursor-pointer">
                            <span class="block text-sm font-semibold text-forest-900">Buku Aktif</span>
                            <span class="block text-xs text-forest-500">Buku aktif akan ditampilkan di daftar penjualan</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- ROW 2: Foto Sampul (Full Width) -->
        <div class="card space-y-5">
    <h3 class="font-display text-lg font-bold text-brand-darkest pb-3 border-b border-gray-100">
        <i class="fas fa-image text-brand-primary mr-2"></i>
        Foto Sampul
    </h3>

    <div>
        <label for="foto" class="block text-sm font-semibold text-brand-darkest mb-2">
            Upload Foto <span class="text-gray-400 font-normal">(Opsional)</span>
        </label>
        <div class="relative">
            <input type="file" id="foto" name="foto" accept="image/*"
                  class="hidden" onchange="previewImage(this)">
            <label for="foto" 
                  class="flex flex-col items-center justify-center w-full min-h-[200px] border-2 border-dashed border-gray-300 rounded-xl cursor-pointer hover:border-brand-primary hover:bg-brand-light/30 transition-all p-4">
                
                <div id="uploadPlaceholder" class="text-center {{ $buku->foto ? 'hidden' : '' }}">
                    <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2"></i>
                    <p class="text-sm text-gray-500">Klik untuk upload foto baru</p>
                    <p class="text-xs text-gray-400 mt-1">JPEG, PNG, JPG (Max 2MB)</p>
                </div>
                
                <img id="imagePreview" 
                    src="{{ $buku->foto ? asset('storage/' . $buku->foto) : '' }}" 
                    class="{{ $buku->foto ? '' : 'hidden' }} max-w-full max-h-80 object-contain rounded-xl">
            </label>
        </div>
        @error('foto')
            <p class="mt-2 text-xs text-red-500 flex items-center gap-1">
                <i class="fas fa-exclamation-circle"></i> {{ $message }}
            </p>
        @enderror
    </div>
</div>

        <!-- Action Buttons -->
        <div class="card flex items-center justify-end gap-3">
            <a href="{{ route('buku.index') }}" 
               class="inline-flex items-center gap-2 px-6 py-3 bg-forest-100 text-forest-700 rounded-xl font-semibold text-sm hover:bg-forest-200 transition-all">
                <i class="fas fa-times"></i>
                <span>Batal</span>
            </a>
            <button type="submit" 
                   class="inline-flex items-center gap-2 px-8 py-3 bg-gradient-to-br from-forest-500 to-forest-700 text-moonlight-50 rounded-xl font-semibold text-sm shadow-md hover:shadow-lg hover:from-forest-600 hover:to-forest-800 transition-all">
                <i class="fas fa-save"></i>
                <span>Update Buku</span>
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    const placeholder = document.getElementById('uploadPlaceholder');

    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.classList.remove('hidden');
            placeholder.classList.add('hidden');
        }
        reader.readAsDataURL(input.files[0]);
    }
}

function hapusFoto() {
    if (confirm('Yakin ingin menghapus foto ini? Foto akan dihapus saat Anda menyimpan perubahan.')) {
        const preview = document.getElementById('imagePreview');
        const placeholder = document.getElementById('uploadPlaceholder');
        const fileInput = document.getElementById('foto');
        
        preview.src = '';
        preview.classList.add('hidden');
        placeholder.classList.remove('hidden');
        
        // Clear file input
        fileInput.value = '';
        
        // Tambahkan hidden input untuk menandai foto dihapus
        const deleteInput = document.createElement('input');
        deleteInput.type = 'hidden';
        deleteInput.name = 'hapus_foto';
        deleteInput.value = '1';
        deleteInput.id = 'hapusFotoInput';
        
        const existingInput = document.getElementById('hapusFotoInput');
        if (!existingInput) {
            fileInput.parentElement.appendChild(deleteInput);
        }
    }
}
</script>
@endpush
@endsection