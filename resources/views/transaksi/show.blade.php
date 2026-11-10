@extends('layouts.app')

@section('title', 'Detail Transaksi')
@section('page-title', 'Detail Transaksi')
@section('page-subtitle', 'Informasi lengkap transaksi {{ $transaksi->kode_transaksi }}')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    <!-- Back Button -->
    <a href="{{ route('transaksi.index') }}" 
       class="inline-flex items-center gap-2 text-sm text-forest-600 hover:text-forest-800 mb-4 transition-colors font-medium">
        <i class="fas fa-arrow-left"></i>
        <span>Kembali ke Daftar Transaksi</span>
    </a>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column - Info Transaksi -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Header Card -->
            <div class="card">
                <div class="flex items-start justify-between mb-6">
                    <div>
                        <div class="flex items-center gap-3 mb-2">
                            <span class="font-mono text-lg font-bold text-forest-600">{{ $transaksi->kode_transaksi }}</span>
                            @if($transaksi->status === 'selesai')
                                <span class="px-3 py-1.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">
                                    <i class="fas fa-check-circle mr-1"></i> Selesai
                                </span>
                            @else
                                <span class="px-3 py-1.5 rounded-full text-xs font-semibold bg-red-100 text-red-700">
                                    <i class="fas fa-times-circle mr-1"></i> Dibatalkan
                                </span>
                            @endif
                        </div>
                        <p class="text-sm text-forest-500">{{ format_tanggal_indo($transaksi->tanggal) }} • {{ $transaksi->created_at->format('H:i') }}</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('transaksi.nota', $transaksi) }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-forest-100 text-forest-700 rounded-xl font-semibold text-sm hover:bg-forest-200 transition-all">
                            <i class="fas fa-print text-sm"></i>
                            <span>Cetak Nota</span>
                        </a>
                        @if($transaksi->status === 'selesai')
                            <button onclick="document.getElementById('modalBatal').classList.remove('hidden')" 
                                   class="inline-flex items-center gap-2 px-4 py-2.5 bg-red-50 text-red-600 hover:bg-red-100 rounded-xl font-semibold text-sm transition-all">
                                <i class="fas fa-times text-sm"></i>
                                <span>Batalkan</span>
                            </button>
                        @endif
                    </div>
                </div>

                <!-- Info Grid -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="p-4 bg-forest-50 rounded-xl">
                        <p class="text-xs text-forest-500 uppercase tracking-wider mb-1">Kasir</p>
                        <p class="font-semibold text-forest-900">{{ $transaksi->kasir->name }}</p>
                    </div>
                    <div class="p-4 bg-forest-50 rounded-xl">
                        <p class="text-xs text-forest-500 uppercase tracking-wider mb-1">Pelanggan</p>
                        <p class="font-semibold text-forest-900">{{ $transaksi->pelanggan->nama ?? 'Umum' }}</p>
                    </div>
                    <div class="p-4 bg-forest-50 rounded-xl">
                        <p class="text-xs text-forest-500 uppercase tracking-wider mb-1">Metode Bayar</p>
                        <p class="font-semibold text-forest-900 capitalize">{{ $transaksi->metode_bayar }}</p>
                    </div>
                    <div class="p-4 bg-forest-50 rounded-xl">
                        <p class="text-xs text-forest-500 uppercase tracking-wider mb-1">Total Items</p>
                        <p class="font-semibold text-forest-900">{{ $transaksi->detail->count() }} item</p>
                    </div>
                </div>
            </div>

            <!-- Daftar Items -->
            <div class="card">
                <h3 class="font-display text-lg font-bold text-forest-900 pb-3 border-b border-forest-200 mb-4">
                    <i class="fas fa-list text-forest-500 mr-2"></i>
                    Daftar Item
                </h3>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-forest-50 border-b border-forest-200">
                                <th class="text-left py-3 px-4 text-xs font-semibold text-forest-700 uppercase">Item</th>
                                <th class="text-center py-3 px-4 text-xs font-semibold text-forest-700 uppercase">Harga</th>
                                <th class="text-center py-3 px-4 text-xs font-semibold text-forest-700 uppercase">Qty</th>
                                <th class="text-center py-3 px-4 text-xs font-semibold text-forest-700 uppercase">Diskon</th>
                                <th class="text-right py-3 px-4 text-xs font-semibold text-forest-700 uppercase">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-forest-100">
                            @foreach($transaksi->detail as $item)
                                <tr class="hover:bg-forest-50/50 transition-colors">
                                    <td class="py-3 px-4">
                                        <p class="font-semibold text-forest-900 text-sm">{{ $item->judul_snapshot }}</p>
                                        <p class="text-xs text-forest-500">{{ $item->kondisi_snapshot }}</p>
                                    </td>
                                    <td class="py-3 px-4 text-center text-sm text-forest-700">{{ format_rupiah($item->harga_satuan) }}</td>
                                    <td class="py-3 px-4 text-center">
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-forest-100 text-forest-700">
                                            {{ $item->jumlah }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 text-center text-sm text-forest-700">{{ format_rupiah($item->diskon_item) }}</td>
                                    <td class="py-3 px-4 text-right font-display font-bold text-forest-900">{{ format_rupiah($item->subtotal) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            @if($transaksi->alasan_batal)
                <div class="card bg-red-50 border-red-200">
                    <h3 class="font-display text-lg font-bold text-red-700 mb-2">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        Alasan Pembatalan
                    </h3>
                    <p class="text-sm text-red-600">{{ $transaksi->alasan_batal }}</p>
                </div>
            @endif
        </div>

        <!-- Right Column - Ringkasan Pembayaran -->
        <div class="space-y-6">
            <div class="card space-y-4">
                <h3 class="font-display text-lg font-bold text-forest-900 pb-3 border-b border-forest-200">
                    <i class="fas fa-calculator text-forest-500 mr-2"></i>
                    Ringkasan Pembayaran
                </h3>

                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-forest-600">Subtotal</span>
                        <span class="font-semibold text-forest-900">{{ format_rupiah($transaksi->total) }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-forest-600">Diskon</span>
                        <span class="font-semibold text-red-600">- {{ format_rupiah($transaksi->diskon) }}</span>
                    </div>
                    <div class="flex items-center justify-between pt-3 border-t border-forest-200">
                        <span class="font-display font-bold text-forest-900">TOTAL</span>
                        <span class="font-display text-2xl font-bold text-forest-600">{{ format_rupiah($transaksi->total_setelah_diskon) }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-forest-600">Dibayar</span>
                        <span class="font-semibold text-forest-900">{{ format_rupiah($transaksi->bayar) }}</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-emerald-50 rounded-xl border border-emerald-200">
                        <span class="text-sm font-semibold text-emerald-700">Kembalian</span>
                        <span class="font-display font-bold text-emerald-600">{{ format_rupiah($transaksi->kembalian) }}</span>
                    </div>
                </div>
            </div>

            @if($transaksi->catatan)
                <div class="card">
                    <h3 class="font-display text-lg font-bold text-forest-900 pb-3 border-b border-forest-200 mb-3">
                        <i class="fas fa-sticky-note text-forest-500 mr-2"></i>
                        Catatan
                    </h3>
                    <p class="text-sm text-forest-700">{{ $transaksi->catatan }}</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal Batal Transaksi -->
<div id="modalBatal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-6">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-12 h-12 rounded-full bg-red-100 text-red-600 flex items-center justify-center">
                <i class="fas fa-exclamation-triangle text-xl"></i>
            </div>
            <div>
                <h3 class="font-display text-lg font-bold text-forest-900">Batalkan Transaksi?</h3>
                <p class="text-sm text-forest-500">Stok akan dikembalikan otomatis</p>
            </div>
        </div>
        <form method="POST" action="{{ route('transaksi.batal', $transaksi) }}">
            @csrf
            <div class="mb-4">
                <label for="alasan_batal" class="block text-sm font-semibold text-forest-800 mb-2">Alasan Pembatalan <span class="text-red-500">*</span></label>
                <textarea name="alasan_batal" id="alasan_batal" rows="3" required
                         placeholder="Jelaskan alasan pembatalan..."
                         class="w-full px-4 py-3 bg-moonlight-50 border-2 border-forest-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 text-sm text-forest-900 placeholder-forest-400 resize-none"></textarea>
            </div>
            
            <div class="flex items-center justify-end gap-3">
                <button type="button" onclick="document.getElementById('modalBatal').classList.add('hidden')" 
                       class="inline-flex items-center gap-2 px-4 py-2.5 bg-forest-100 text-forest-700 rounded-xl font-semibold text-sm hover:bg-forest-200 transition-all">
                    <i class="fas fa-times text-sm"></i>
                    <span>Batal</span>
                </button>
                <button type="submit" 
                       class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2.5 px-4 rounded-xl transition-all inline-flex items-center gap-2">
                    <i class="fas fa-check text-sm"></i>
                    <span>Ya, Batalkan</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection