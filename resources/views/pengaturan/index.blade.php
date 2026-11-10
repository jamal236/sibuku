@extends('layouts.app')

@section('title', 'Pengaturan Toko')
@section('page-title', 'Pengaturan Sistem')
@section('page-subtitle', 'Kelola identitas toko dan konfigurasi aplikasi')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    <form method="POST" action="{{ route('pengaturan.update') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column: Identitas Toko -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Informasi Toko -->
                <div class="card space-y-5">
                    <h3 class="font-display text-lg font-bold text-forest-900 pb-3 border-b border-forest-200">
                        <i class="fas fa-store text-forest-500 mr-2"></i>
                        Informasi Toko
                    </h3>

                    <!-- Nama Toko -->
                    <div>
                        <label for="toko_nama" class="block text-sm font-semibold text-forest-800 mb-2">
                            Nama Toko <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-store text-forest-400"></i>
                            </div>
                            <input type="text" id="toko_nama" name="toko_nama" 
                                   value="{{ $settings['toko_nama']->value ?? '' }}" required
                                   placeholder="Masukkan nama toko Anda"
                                   class="w-full pl-11 pr-4 py-3 bg-moonlight-50 border-2 border-forest-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-forest-300 focus:border-forest-400 text-sm text-forest-900 placeholder-forest-400">
                        </div>
                        @error('toko_nama')
                            <p class="mt-2 text-xs text-red-500 flex items-center gap-1">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Alamat Toko -->
                    <div>
                        <label for="toko_alamat" class="block text-sm font-semibold text-forest-800 mb-2">
                            Alamat Toko <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute top-3 left-0 pl-4 pointer-events-none">
                                <i class="fas fa-map-marker-alt text-forest-400"></i>
                            </div>
                            <textarea id="toko_alamat" name="toko_alamat" rows="2" required
                                      placeholder="Masukkan alamat lengkap toko"
                                      class="w-full pl-11 pr-4 py-3 bg-moonlight-50 border-2 border-forest-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-forest-300 focus:border-forest-400 text-sm text-forest-900 placeholder-forest-400 resize-none">{{ $settings['toko_alamat']->value ?? '' }}</textarea>
                        </div>
                        @error('toko_alamat')
                            <p class="mt-2 text-xs text-red-500 flex items-center gap-1">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Telepon & Stok Minimum -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="toko_telepon" class="block text-sm font-semibold text-forest-800 mb-2">
                                Nomor Telepon <span class="text-forest-400 font-normal">(Opsional)</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-phone text-forest-400"></i>
                                </div>
                                <input type="text" id="toko_telepon" name="toko_telepon" 
                                       value="{{ $settings['toko_telepon']->value ?? '' }}"
                                       placeholder="0231-xxxxxxx"
                                       class="w-full pl-11 pr-4 py-3 bg-moonlight-50 border-2 border-forest-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-forest-300 focus:border-forest-400 text-sm text-forest-900 placeholder-forest-400">
                            </div>
                            @error('toko_telepon')
                                <p class="mt-2 text-xs text-red-500 flex items-center gap-1">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div>
                            <label for="stok_minimum_default" class="block text-sm font-semibold text-forest-800 mb-2">
                                Batas Minimum Stok Default
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-boxes-stacked text-forest-400"></i>
                                </div>
                                <input type="number" id="stok_minimum_default" name="stok_minimum_default" 
                                       value="{{ $settings['stok_minimum_default']->value ?? '1' }}" min="1"
                                       placeholder="1"
                                       class="w-full pl-11 pr-4 py-3 bg-moonlight-50 border-2 border-forest-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-forest-300 focus:border-forest-400 text-sm text-forest-900 placeholder-forest-400">
                            </div>
                            <p class="mt-1 text-xs text-forest-500">
                                <i class="fas fa-info-circle mr-1"></i>
                                Digunakan saat menambah buku baru
                            </p>
                            @error('stok_minimum_default')
                                <p class="mt-2 text-xs text-red-500 flex items-center gap-1">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Pengaturan Nota -->
                <div class="card space-y-5">
                    <h3 class="font-display text-lg font-bold text-forest-900 pb-3 border-b border-forest-200">
                        <i class="fas fa-receipt text-forest-500 mr-2"></i>
                        Pengaturan Struk / Nota
                    </h3>

                    <!-- Pesan Nota -->
                    <div>
                        <label for="nota_pesan" class="block text-sm font-semibold text-forest-800 mb-2">
                            Pesan di Bagian Bawah Nota <span class="text-forest-400 font-normal">(Opsional)</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-comment-dots text-forest-400"></i>
                            </div>
                            <input type="text" id="nota_pesan" name="nota_pesan" 
                                   value="{{ $settings['nota_pesan']->value ?? '' }}"
                                   placeholder="Terima kasih telah berbelanja!"
                                   class="w-full pl-11 pr-4 py-3 bg-moonlight-50 border-2 border-forest-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-forest-300 focus:border-forest-400 text-sm text-forest-900 placeholder-forest-400">
                        </div>
                        <p class="mt-1 text-xs text-forest-500">
                            <i class="fas fa-info-circle mr-1"></i>
                            Pesan ini akan muncul di bagian bawah nota thermal
                        </p>
                        @error('nota_pesan')
                            <p class="mt-2 text-xs text-red-500 flex items-center gap-1">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Toggle Tampilkan Logo -->
                    <div class="flex items-center gap-3 p-4 bg-forest-50 rounded-xl border border-forest-200">
                        <input type="checkbox" id="nota_tampilkan_logo" name="nota_tampilkan_logo" value="1" 
                               {{ ($settings['nota_tampilkan_logo']->value ?? '1') == '1' ? 'checked' : '' }}
                               class="w-5 h-5 rounded border-forest-300 text-forest-600 focus:ring-forest-500 cursor-pointer">
                        <label for="nota_tampilkan_logo" class="flex-1 cursor-pointer">
                            <span class="block text-sm font-semibold text-forest-900">Tampilkan Logo di Nota</span>
                            <span class="block text-xs text-forest-500">Logo akan dicetak di bagian atas struk thermal</span>
                        </label>
                        <div class="w-10 h-10 rounded-lg bg-forest-100 text-forest-600 flex items-center justify-center">
                            <i class="fas fa-image"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Logo Toko -->
            <div class="space-y-6">
                <!-- Logo Preview -->
                <div class="card space-y-5 sticky top-6">
                    <h3 class="font-display text-lg font-bold text-forest-900 pb-3 border-b border-forest-200">
                        <i class="fas fa-image text-forest-500 mr-2"></i>
                        Logo Toko
                    </h3>

                    <div class="text-center">
                        <!-- Preview Area -->
                        <div class="w-48 h-48 mx-auto rounded-2xl bg-gradient-to-br from-forest-50 to-moonlight-50 border-2 border-dashed border-forest-300 flex items-center justify-center overflow-hidden mb-4 relative group hover:border-forest-500 transition-all">
                            @php
                                $logoPath = $settings['toko_logo']->value ?? null;
                            @endphp
                            @if($logoPath)
                                <img src="{{ asset('storage/' . $logoPath) }}" alt="Logo Toko" class="w-full h-full object-contain p-3" id="logoPreview">
                                <div class="absolute inset-0 bg-forest-900/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center rounded-2xl">
                                    <p class="text-moonlight-50 text-sm font-semibold">
                                        <i class="fas fa-sync-alt mr-1"></i> Ganti Logo
                                    </p>
                                </div>
                            @else
                                <div class="text-center text-forest-400" id="logoPlaceholder">
                                    <div class="w-16 h-16 mx-auto rounded-full bg-forest-100 flex items-center justify-center mb-3">
                                        <i class="fas fa-store text-2xl text-forest-500"></i>
                                    </div>
                                    <p class="text-sm font-semibold text-forest-700">Belum ada logo</p>
                                    <p class="text-xs text-forest-500 mt-1">Klik tombol di bawah untuk upload</p>
                                </div>
                                <img id="logoPreview" class="hidden w-full h-full object-contain p-3">
                            @endif
                        </div>

                        <!-- Upload Button -->
                        <label for="toko_logo" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-br from-forest-500 to-forest-700 text-moonlight-50 rounded-xl text-sm font-semibold cursor-pointer shadow-md hover:shadow-lg hover:from-forest-600 hover:to-forest-800 transition-all">
                            <i class="fas fa-upload"></i>
                            <span>Upload Logo</span>
                        </label>
                        <input type="file" id="toko_logo" name="toko_logo" accept="image/*" class="hidden" onchange="previewLogo(this)">
                        
                        <p class="text-xs text-forest-500 mt-3">
                            <i class="fas fa-info-circle mr-1"></i>
                            Format: PNG, JPG, SVG. Maksimal 2MB.
                        </p>
                    </div>

                    <!-- Info Card -->
                    <div class="p-4 bg-gradient-to-br from-forest-50 to-moonlight-50 rounded-xl border border-forest-200">
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 rounded-full bg-forest-100 text-forest-600 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-lightbulb"></i>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-forest-900 mb-1">Tips</p>
                                <p class="text-xs text-forest-600">Gunakan logo dengan latar belakang transparan (PNG) untuk hasil terbaik pada struk thermal.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Action Button -->
                    <button type="submit" class="w-full inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-br from-forest-500 to-forest-700 text-moonlight-50 rounded-xl font-semibold text-sm shadow-md hover:shadow-lg hover:from-forest-600 hover:to-forest-800 transition-all">
                        <i class="fas fa-save"></i>
                        <span>Simpan Perubahan</span>
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
function previewLogo(input) {
    const preview = document.getElementById('logoPreview');
    const placeholder = document.getElementById('logoPlaceholder');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.classList.remove('hidden');
            if(placeholder) placeholder.classList.add('hidden');
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
@endsection