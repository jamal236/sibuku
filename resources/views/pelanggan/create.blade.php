@extends('layouts.app')

@section('title', 'Tambah Pelanggan')
@section('page-title', 'Tambah Pelanggan Baru')
@section('page-subtitle', 'Isi form di bawah untuk menambahkan data pelanggan')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Back Button -->
    <a href="{{ route('pelanggan.index') }}" 
       class="inline-flex items-center gap-2 text-sm text-forest-600 hover:text-forest-800 mb-4 transition-colors font-medium">
        <i class="fas fa-arrow-left"></i>
        <span>Kembali ke Daftar Pelanggan</span>
    </a>

    <form method="POST" action="{{ route('pelanggan.store') }}" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column - Main Info -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Informasi Dasar -->
                <div class="card space-y-5">
                    <h3 class="font-display text-lg font-bold text-forest-900 pb-3 border-b border-forest-200">
                        <i class="fas fa-user-plus text-forest-500 mr-2"></i>
                        Informasi Dasar
                    </h3>

                    <!-- Nama -->
                    <div>
                        <label for="nama" class="block text-sm font-semibold text-forest-800 mb-2">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-user text-forest-400"></i>
                            </div>
                            <input type="text" id="nama" name="nama" value="{{ old('nama') }}" required
                                  placeholder="Masukkan nama lengkap pelanggan"
                                  class="w-full pl-11 pr-4 py-3 bg-moonlight-50 border-2 border-forest-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-forest-300 focus:border-forest-400 text-sm text-forest-900 placeholder-forest-400">
                        </div>
                        @error('nama')
                            <p class="mt-2 text-xs text-red-500 flex items-center gap-1">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Telepon & Email -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="telepon" class="block text-sm font-semibold text-forest-800 mb-2">
                                Nomor Telepon <span class="text-forest-400 font-normal">(Opsional)</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-phone text-forest-400"></i>
                                </div>
                                <input type="text" id="telepon" name="telepon" value="{{ old('telepon') }}"
                                      placeholder="08xxxxxxxxxx"
                                      class="w-full pl-11 pr-4 py-3 bg-moonlight-50 border-2 border-forest-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-forest-300 focus:border-forest-400 text-sm text-forest-900 placeholder-forest-400">
                            </div>
                            @error('telepon')
                                <p class="mt-2 text-xs text-red-500 flex items-center gap-1">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-semibold text-forest-800 mb-2">
                                Email <span class="text-forest-400 font-normal">(Opsional)</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-envelope text-forest-400"></i>
                                </div>
                                <input type="email" id="email" name="email" value="{{ old('email') }}"
                                      placeholder="email@contoh.com"
                                      class="w-full pl-11 pr-4 py-3 bg-moonlight-50 border-2 border-forest-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-forest-300 focus:border-forest-400 text-sm text-forest-900 placeholder-forest-400">
                            </div>
                            @error('email')
                                <p class="mt-2 text-xs text-red-500 flex items-center gap-1">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                    <!-- Alamat -->
                    <div>
                        <label for="alamat" class="block text-sm font-semibold text-forest-800 mb-2">
                            Alamat <span class="text-forest-400 font-normal">(Opsional)</span>
                        </label>
                        <textarea id="alamat" name="alamat" rows="3"
                                  placeholder="Alamat lengkap pelanggan..."
                                  class="w-full px-4 py-3 bg-moonlight-50 border-2 border-forest-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-forest-300 focus:border-forest-400 text-sm text-forest-900 placeholder-forest-400 resize-none">{{ old('alamat') }}</textarea>
                    </div>

                    <!-- Catatan -->
                    <div>
                        <label for="catatan" class="block text-sm font-semibold text-forest-800 mb-2">
                            Catatan <span class="text-forest-400 font-normal">(Opsional)</span>
                        </label>
                        <textarea id="catatan" name="catatan" rows="2"
                                  placeholder="Misal: sering cari buku fisika, langganan genre horor..."
                                  class="w-full px-4 py-3 bg-moonlight-50 border-2 border-forest-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-forest-300 focus:border-forest-400 text-sm text-forest-900 placeholder-forest-400 resize-none">{{ old('catatan') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Right Column - Additional Info -->
            <div class="space-y-6">
                <!-- Kode Pelanggan -->
                <div class="card">
                    <h3 class="font-display text-lg font-bold text-forest-900 pb-3 border-b border-forest-200 mb-4">
                        <i class="fas fa-id-card text-forest-500 mr-2"></i>
                        Kode Pelanggan
                    </h3>
                    <div>
                        <label class="block text-sm font-semibold text-forest-800 mb-2">Kode Pelanggan</label>
                        <input type="text" value="{{ $kodePelanggan }}" disabled
                              class="w-full px-4 py-3 bg-forest-100 border border-forest-200 rounded-xl text-sm text-forest-600 font-mono text-center">
                        <p class="mt-1 text-xs text-forest-500 text-center">Kode akan digenerate otomatis</p>
                    </div>
                </div>

                <!-- Tanggal Lahir -->
                <div class="card">
                    <h3 class="font-display text-lg font-bold text-forest-900 pb-3 border-b border-forest-200 mb-4">
                        <i class="fas fa-calendar-alt text-forest-500 mr-2"></i>
                        Tanggal Lahir
                    </h3>
                    <div>
                        <label for="tanggal_lahir" class="block text-sm font-semibold text-forest-800 mb-2">
                            Tanggal Lahir <span class="text-forest-400 font-normal">(Opsional)</span>
                        </label>
                        <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                              class="w-full px-4 py-3 bg-moonlight-50 border-2 border-forest-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-forest-300 focus:border-forest-400 text-sm text-forest-900">
                    </div>
                </div>

                <!-- Info Card -->
                <div class="card bg-gradient-to-br from-forest-50 to-moonlight-50 border-forest-200">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-full bg-forest-100 text-forest-600 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-info-circle"></i>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-forest-900 mb-1">Informasi</p>
                            <p class="text-xs text-forest-600">Data pelanggan akan digunakan untuk transaksi dan notifikasi promo.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="card flex items-center justify-end gap-3">
            <a href="{{ route('pelanggan.index') }}" 
               class="inline-flex items-center gap-2 px-6 py-3 bg-forest-100 text-forest-700 rounded-xl font-semibold text-sm hover:bg-forest-200 transition-all">
                <i class="fas fa-times"></i>
                <span>Batal</span>
            </a>
            <button type="submit" 
                   class="inline-flex items-center gap-2 px-8 py-3 bg-gradient-to-br from-forest-500 to-forest-700 text-moonlight-50 rounded-xl font-semibold text-sm shadow-md hover:shadow-lg hover:from-forest-600 hover:to-forest-800 transition-all">
                <i class="fas fa-save"></i>
                <span>Simpan Pelanggan</span>
            </button>
        </div>
    </form>
</div>
@endsection