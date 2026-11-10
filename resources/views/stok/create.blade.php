@extends('layouts.app')

@section('title', 'Catat Stok Masuk')
@section('page-title', 'Catat Stok Masuk Baru')
@section('page-subtitle', 'Tambahkan stok buku dari supplier atau donatur')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Back Button -->
    <a href="{{ route('stok.index') }}" 
       class="inline-flex items-center gap-2 text-sm text-forest-600 hover:text-forest-800 mb-4 transition-colors font-medium">
        <i class="fas fa-arrow-left"></i>
        <span>Kembali ke Daftar Stok Masuk</span>
    </a>

    <form method="POST" action="{{ route('stok.store') }}" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column - Main Info -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Pilih Buku & Supplier -->
                <div class="card space-y-5">
                    <h3 class="font-display text-lg font-bold text-forest-900 pb-3 border-b border-forest-200">
                        <i class="fas fa-book-open text-forest-500 mr-2"></i>
                        Pilih Buku & Supplier
                    </h3>

                    <!-- Buku -->
                    <div>
                        <label for="buku_id" class="block text-sm font-semibold text-forest-800 mb-2">
                            Pilih Buku <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-book text-forest-400"></i>
                            </div>
                            <select id="buku_id" name="buku_id" required
                                   class="w-full pl-11 pr-4 py-3 bg-moonlight-50 border-2 border-forest-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-forest-300 focus:border-forest-400 text-sm text-forest-900">
                                <option value="">-- Pilih Buku --</option>
                                @foreach($bukus as $buku)
                                    <option value="{{ $buku->id }}" {{ old('buku_id') == $buku->id ? 'selected' : '' }}>
                                        {{ $buku->kode_buku }} - {{ $buku->judul }} (Stok: {{ $buku->stok }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('buku_id')
                            <p class="mt-2 text-xs text-red-500 flex items-center gap-1">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Supplier/Donatur -->
                    <div>
                        <label for="supplier_id" class="block text-sm font-semibold text-forest-800 mb-2">
                            Supplier / Donatur <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-truck text-forest-400"></i>
                            </div>
                            <select id="supplier_id" name="supplier_id" required
                                   class="w-full pl-11 pr-4 py-3 bg-moonlight-50 border-2 border-forest-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-forest-300 focus:border-forest-400 text-sm text-forest-900">
                                <option value="">-- Pilih Supplier/Donatur --</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}" 
                                           data-jenis="{{ $supplier->jenis }}"
                                           {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                        {{ $supplier->nama }} ({{ ucfirst($supplier->jenis) }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('supplier_id')
                            <p class="mt-2 text-xs text-red-500 flex items-center gap-1">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <!-- Jumlah & Harga -->
                <div class="card space-y-5">
                    <h3 class="font-display text-lg font-bold text-forest-900 pb-3 border-b border-forest-200">
                        <i class="fas fa-calculator text-forest-500 mr-2"></i>
                        Jumlah & Harga
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Jumlah -->
                        <div>
                            <label for="jumlah" class="block text-sm font-semibold text-forest-800 mb-2">
                                Jumlah Buku <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-hashtag text-forest-400"></i>
                                </div>
                                <input type="number" id="jumlah" name="jumlah" value="{{ old('jumlah', 1) }}" required min="1"
                                      class="w-full pl-11 pr-4 py-3 bg-moonlight-50 border-2 border-forest-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-forest-300 focus:border-forest-400 text-sm text-forest-900">
                            </div>
                            @error('jumlah')
                                <p class="mt-2 text-xs text-red-500 flex items-center gap-1">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Harga Beli -->
                        <div id="hargaBeliContainer">
                            <label for="harga_beli" class="block text-sm font-semibold text-forest-800 mb-2">
                                Harga Beli per Buku <span class="text-forest-400 font-normal">(Kosongkan jika donasi)</span>
                            </label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-forest-500 font-semibold">Rp</span>
                                <input type="number" id="harga_beli" name="harga_beli" value="{{ old('harga_beli') }}" min="0"
                                      placeholder="0"
                                      class="w-full pl-12 pr-4 py-3 bg-moonlight-50 border-2 border-forest-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-forest-300 focus:border-forest-400 text-sm text-forest-900">
                            </div>
                            @error('harga_beli')
                                <p class="mt-2 text-xs text-red-500 flex items-center gap-1">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Tanggal & Keterangan -->
                <div class="card space-y-5">
                    <h3 class="font-display text-lg font-bold text-forest-900 pb-3 border-b border-forest-200">
                        <i class="fas fa-calendar-alt text-forest-500 mr-2"></i>
                        Tanggal & Keterangan
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Tanggal -->
                        <div>
                            <label for="tanggal" class="block text-sm font-semibold text-forest-800 mb-2">
                                Tanggal Diterima <span class="text-red-500">*</span>
                            </label>
                            <input type="date" id="tanggal" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required
                                  class="w-full px-4 py-3 bg-moonlight-50 border-2 border-forest-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-forest-300 focus:border-forest-400 text-sm text-forest-900">
                            @error('tanggal')
                                <p class="mt-2 text-xs text-red-500 flex items-center gap-1">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Keterangan -->
                        <div>
                            <label for="keterangan" class="block text-sm font-semibold text-forest-800 mb-2">
                                Keterangan <span class="text-forest-400 font-normal">(Opsional)</span>
                            </label>
                            <input type="text" id="keterangan" name="keterangan" value="{{ old('keterangan') }}"
                                  placeholder="Catatan kondisi kiriman, dll..."
                                  class="w-full px-4 py-3 bg-moonlight-50 border-2 border-forest-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-forest-300 focus:border-forest-400 text-sm text-forest-900">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Preview -->
            <div class="space-y-6">
                <!-- Preview Total -->
                <div class="card bg-gradient-to-br from-forest-50 to-moonlight-50 border-forest-200 sticky top-6">
                    <h3 class="font-display text-lg font-bold text-forest-900 pb-3 border-b border-forest-200 mb-4">
                        <i class="fas fa-receipt text-forest-500 mr-2"></i>
                        Ringkasan
                    </h3>
                    
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-forest-600">Jumlah</span>
                            <span class="font-semibold text-forest-900" id="previewJumlah">1 buku</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-forest-600">Harga Satuan</span>
                            <span class="font-semibold text-forest-900" id="previewHarga">Rp 0</span>
                        </div>
                        <div class="flex items-center justify-between pt-3 border-t border-forest-200">
                            <span class="font-display font-bold text-forest-900">TOTAL</span>
                            <span class="font-display text-2xl font-bold text-forest-600" id="previewTotal">Rp 0</span>
                        </div>
                    </div>

                    <div class="mt-6 p-4 bg-forest-100 rounded-xl border border-forest-200">
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 rounded-full bg-forest-200 text-forest-600 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-info-circle"></i>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-forest-900 mb-1">Info</p>
                                <p class="text-xs text-forest-600">Stok akan otomatis bertambah setelah disimpan.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="card flex items-center justify-end gap-3">
            <a href="{{ route('stok.index') }}" 
               class="inline-flex items-center gap-2 px-6 py-3 bg-forest-100 text-forest-700 rounded-xl font-semibold text-sm hover:bg-forest-200 transition-all">
                <i class="fas fa-times"></i>
                <span>Batal</span>
            </a>
            <button type="submit" 
                   class="inline-flex items-center gap-2 px-8 py-3 bg-gradient-to-br from-forest-500 to-forest-700 text-moonlight-50 rounded-xl font-semibold text-sm shadow-md hover:shadow-lg hover:from-forest-600 hover:to-forest-800 transition-all">
                <i class="fas fa-save"></i>
                <span>Simpan Stok Masuk</span>
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
const jumlahInput = document.getElementById('jumlah');
const hargaBeliInput = document.getElementById('harga_beli');
const previewTotal = document.getElementById('previewTotal');
const previewJumlah = document.getElementById('previewJumlah');
const previewHarga = document.getElementById('previewHarga');
const supplierSelect = document.getElementById('supplier_id');
const hargaBeliContainer = document.getElementById('hargaBeliContainer');

function hitungTotal() {
    const jumlah = parseFloat(jumlahInput.value) || 0;
    const harga = parseFloat(hargaBeliInput.value) || 0;
    const total = jumlah * harga;
    
    previewJumlah.textContent = jumlah + ' buku';
    previewHarga.textContent = 'Rp ' + harga.toLocaleString('id-ID');
    previewTotal.textContent = 'Rp ' + total.toLocaleString('id-ID');
}

jumlahInput.addEventListener('input', hitungTotal);
hargaBeliInput.addEventListener('input', hitungTotal);

// Toggle harga beli jika supplier adalah donatur
supplierSelect.addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    const jenis = selectedOption.getAttribute('data-jenis');

    if (jenis === 'donatur') {
        hargaBeliContainer.classList.add('opacity-50', 'pointer-events-none');
        hargaBeliInput.value = '';
        hargaBeliInput.removeAttribute('required');
    } else {
        hargaBeliContainer.classList.remove('opacity-50', 'pointer-events-none');
    }
    hitungTotal();
});

// Trigger initial check
supplierSelect.dispatchEvent(new Event('change'));
</script>
@endpush
@endsection