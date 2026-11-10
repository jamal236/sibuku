@extends('layouts.app')

@section('title', 'Transaksi Baru (POS)')
@section('page-title', 'Point of Sale')
@section('page-subtitle', 'Buat transaksi penjualan baru')

@section('content')
<form method="POST" action="{{ route('transaksi.store') }}" id="formTransaksi">
    @csrf
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column - Pencarian & Keranjang -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Pencarian Buku -->
            <div class="card">
                <h3 class="font-display text-lg font-bold text-forest-900 mb-4">
                    <i class="fas fa-search text-forest-500 mr-2"></i>
                    Cari Buku
                </h3>
                <div class="relative">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-forest-400"></i>
                    <input type="text" id="searchBuku" 
                          placeholder="Ketik judul, kode, atau pengarang..."
                          class="w-full pl-11 pr-4 py-3 bg-moonlight-50 border-2 border-forest-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-forest-300 focus:border-forest-400 text-sm text-forest-900 placeholder-forest-400">
                </div>
                
                <!-- Hasil Pencarian -->
                <div id="hasilPencarian" class="mt-4 hidden">
                    <div class="max-h-96 overflow-y-auto space-y-2" id="listBuku">
                        <!-- Diisi oleh JavaScript -->
                    </div>
                </div>
            </div>

            <!-- Keranjang Belanja -->
            <div class="card">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-display text-lg font-bold text-forest-900">
                        <i class="fas fa-shopping-cart text-forest-500 mr-2"></i>
                        Keranjang Belanja
                    </h3>
                    <span class="text-sm text-forest-500 font-medium" id="jumlahItem">0 item</span>
                </div>

                <div id="keranjangKosong" class="py-12 text-center">
                    <div class="w-16 h-16 mx-auto rounded-full bg-forest-100 flex items-center justify-center mb-3">
                        <i class="fas fa-cart-plus text-2xl text-forest-400"></i>
                    </div>
                    <p class="text-sm text-forest-500">Keranjang masih kosong</p>
                    <p class="text-xs text-forest-400 mt-1">Cari dan tambahkan buku di atas</p>
                </div>

                <div id="keranjangIsi" class="hidden space-y-3">
                    <!-- Diisi oleh JavaScript -->
                </div>

                <!-- Input Items (hidden, untuk form submission) -->
                <div id="inputItems" class="hidden">
                    <!-- Diisi oleh JavaScript -->
                </div>
            </div>
        </div>

        <!-- Right Column - Ringkasan & Pembayaran -->
        <div class="space-y-6">
            <!-- Pilih Pelanggan -->
            <div class="card">
                <h3 class="font-display text-lg font-bold text-forest-900 mb-4">
                    <i class="fas fa-user text-forest-500 mr-2"></i>
                    Pelanggan
                </h3>
                <select name="pelanggan_id" id="pelanggan_id"
                        class="w-full px-4 py-3 bg-moonlight-50 border-2 border-forest-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-forest-300 focus:border-forest-400 text-sm text-forest-900">
                    <option value="">Pelanggan Umum (Tanpa Nama)</option>
                    @foreach($pelanggans as $pelanggan)
                        <option value="{{ $pelanggan->id }}">{{ $pelanggan->nama }} - {{ $pelanggan->telepon }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Ringkasan Pembayaran -->
            <div class="card space-y-4">
                <h3 class="font-display text-lg font-bold text-forest-900 pb-3 border-b border-forest-200">
                    <i class="fas fa-receipt text-forest-500 mr-2"></i>
                    Ringkasan Pembayaran
                </h3>

                <!-- Subtotal -->
                <div class="flex items-center justify-between">
                    <span class="text-sm text-forest-600">Subtotal</span>
                    <span class="font-semibold text-forest-900" id="subtotalDisplay">Rp 0</span>
                </div>

                <!-- Diskon -->
                <div class="flex items-center justify-between">
                    <span class="text-sm text-forest-600">Diskon</span>
                    <div class="flex items-center gap-2">
                        <span class="text-forest-500 text-sm">Rp</span>
                        <input type="number" name="diskon" id="diskon" value="0" min="0"
                              class="w-24 px-3 py-1.5 bg-moonlight-50 border-2 border-forest-200 rounded-lg text-right text-sm focus:outline-none focus:ring-2 focus:ring-forest-300 focus:border-forest-400">
                    </div>
                </div>

                <!-- Total -->
                <div class="flex items-center justify-between pt-3 border-t border-forest-200">
                    <span class="font-display font-bold text-forest-900">TOTAL</span>
                    <span class="font-display text-2xl font-bold text-forest-600" id="totalDisplay">Rp 0</span>
                </div>

                <!-- Metode Pembayaran -->
                <div>
                    <label class="block text-sm font-semibold text-forest-800 mb-2">Metode Pembayaran</label>
                    <div class="grid grid-cols-3 gap-2">
                        <label class="relative cursor-pointer">
                            <input type="radio" name="metode_bayar" value="tunai" checked class="peer sr-only">
                            <div class="p-3 rounded-xl border-2 border-forest-200 peer-checked:border-forest-500 peer-checked:bg-forest-50 hover:bg-forest-50 transition-all text-center">
                                <i class="fas fa-money-bill-wave text-forest-500 mb-1"></i>
                                <p class="text-xs font-semibold text-forest-700">Tunai</p>
                            </div>
                        </label>
                        <label class="relative cursor-pointer">
                            <input type="radio" name="metode_bayar" value="transfer" class="peer sr-only">
                            <div class="p-3 rounded-xl border-2 border-forest-200 peer-checked:border-forest-500 peer-checked:bg-forest-50 hover:bg-forest-50 transition-all text-center">
                                <i class="fas fa-university text-forest-500 mb-1"></i>
                                <p class="text-xs font-semibold text-forest-700">Transfer</p>
                            </div>
                        </label>
                        <label class="relative cursor-pointer">
                            <input type="radio" name="metode_bayar" value="qris" class="peer sr-only">
                            <div class="p-3 rounded-xl border-2 border-forest-200 peer-checked:border-forest-500 peer-checked:bg-forest-50 hover:bg-forest-50 transition-all text-center">
                                <i class="fas fa-qrcode text-forest-500 mb-1"></i>
                                <p class="text-xs font-semibold text-forest-700">QRIS</p>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Jumlah Bayar -->
                <div>
                    <label for="bayar" class="block text-sm font-semibold text-forest-800 mb-2">Jumlah Bayar</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-forest-500 font-semibold">Rp</span>
                        <input type="number" name="bayar" id="bayar" value="0" min="0" required
                              class="w-full pl-12 pr-4 py-3 bg-moonlight-50 border-2 border-forest-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-forest-300 focus:border-forest-400 text-sm font-display font-bold text-forest-900">
                    </div>
                </div>

                <!-- Kembalian -->
                <div class="p-4 bg-forest-50 rounded-xl border border-forest-200">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-semibold text-forest-800">Kembalian</span>
                        <span class="font-display text-xl font-bold text-emerald-600" id="kembalianDisplay">Rp 0</span>
                    </div>
                </div>

                <!-- Catatan -->
                <div>
                    <label for="catatan" class="block text-sm font-semibold text-forest-800 mb-2">Catatan (Opsional)</label>
                    <textarea name="catatan" id="catatan" rows="2"
                             placeholder="Catatan tambahan..."
                             class="w-full px-4 py-3 bg-moonlight-50 border-2 border-forest-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-forest-300 focus:border-forest-400 text-sm text-forest-900 placeholder-forest-400 resize-none"></textarea>
                </div>

                <!-- Tombol Bayar -->
                <button type="submit" id="btnBayar" disabled
                        class="w-full bg-gradient-to-r from-forest-500 to-forest-700 hover:from-forest-600 hover:to-forest-800 disabled:from-gray-300 disabled:to-gray-400 disabled:cursor-not-allowed text-moonlight-50 font-bold py-4 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl active:scale-[0.98] flex items-center justify-center gap-2">
                    <i class="fas fa-check-circle text-lg"></i>
                    <span class="text-lg">Proses Pembayaran</span>
                </button>
            </div>
        </div>
    </div>
</form>

@push('scripts')
<script>
let keranjang = [];
let searchTimeout;

// Pencarian Buku
const searchInput = document.getElementById('searchBuku');
const hasilPencarian = document.getElementById('hasilPencarian');
const listBuku = document.getElementById('listBuku');

searchInput.addEventListener('input', function(e) {
    clearTimeout(searchTimeout);
    const query = e.target.value.trim();
    
    if (query.length < 2) {
        hasilPencarian.classList.add('hidden');
        return;
    }

    searchTimeout = setTimeout(() => {
        fetch(`/api/cari-buku?q=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(data => {
                if (data.length === 0) {
                    listBuku.innerHTML = '<p class="text-center text-forest-500 py-4">Tidak ada buku ditemukan</p>';
                } else {
                    listBuku.innerHTML = data.map(buku => `
                        <div class="flex items-center gap-3 p-3 bg-forest-50 rounded-xl hover:bg-forest-100 cursor-pointer transition-colors" 
                             onclick="tambahKeKeranjang(${buku.id}, '${buku.judul.replace(/'/g, "\\'")}', ${buku.harga}, ${buku.stok}, '${buku.kondisi}')">
                            <div class="w-12 h-12 rounded-lg bg-white flex items-center justify-center overflow-hidden flex-shrink-0">
                                ${buku.foto ? `<img src="${buku.foto}" class="w-full h-full object-cover">` : '<i class="fas fa-book text-forest-400"></i>'}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-forest-900 text-sm truncate">${buku.judul}</p>
                                <p class="text-xs text-forest-500">${buku.pengarang} • ${buku.kategori}</p>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="text-xs font-bold text-forest-600">${formatRupiah(buku.harga)}</span>
                                    <span class="text-xs text-forest-400">• Stok: ${buku.stok}</span>
                                </div>
                            </div>
                            <div class="w-8 h-8 rounded-full bg-forest-500 text-moonlight-50 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-plus text-xs"></i>
                            </div>
                        </div>
                    `).join('');
                }
                hasilPencarian.classList.remove('hidden');
            });
    }, 300);
});

// Tambah ke Keranjang
function tambahKeKeranjang(bukuId, judul, harga, stok, kondisi) {
    const existingIndex = keranjang.findIndex(item => item.buku_id === bukuId);
    
    if (existingIndex >= 0) {
        if (keranjang[existingIndex].jumlah < stok) {
            keranjang[existingIndex].jumlah++;
        } else {
            alert('Stok tidak mencukupi!');
            return;
        }
    } else {
        keranjang.push({
            buku_id: bukuId,
            judul: judul,
            harga: harga,
            jumlah: 1,
            diskon: 0,
            stok: stok,
            kondisi: kondisi
        });
    }
    
    renderKeranjang();
    searchInput.value = '';
    hasilPencarian.classList.add('hidden');
}

// Render Keranjang
function renderKeranjang() {
    const keranjangKosong = document.getElementById('keranjangKosong');
    const keranjangIsi = document.getElementById('keranjangIsi');
    const inputItems = document.getElementById('inputItems');
    const jumlahItem = document.getElementById('jumlahItem');
    
    if (keranjang.length === 0) {
        keranjangKosong.classList.remove('hidden');
        keranjangIsi.classList.add('hidden');
        inputItems.classList.add('hidden');
        jumlahItem.textContent = '0 item';
    } else {
        keranjangKosong.classList.add('hidden');
        keranjangIsi.classList.remove('hidden');
        inputItems.classList.remove('hidden');
        jumlahItem.textContent = `${keranjang.length} item`;
        
        keranjangIsi.innerHTML = keranjang.map((item, index) => `
            <div class="p-3 bg-forest-50 rounded-xl border border-forest-200">
                <div class="flex items-start justify-between mb-2">
                    <div class="flex-1 min-w-0">
                        <p class="font-semibold text-forest-900 text-sm truncate">${item.judul}</p>
                        <p class="text-xs text-forest-500">${item.kondisi} • Stok: ${item.stok}</p>
                    </div>
                    <button type="button" onclick="hapusItem(${index})" 
                            class="w-7 h-7 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 flex items-center justify-center transition-colors flex-shrink-0 ml-2">
                        <i class="fas fa-times text-xs"></i>
                    </button>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <button type="button" onclick="ubahJumlah(${index}, -1)" 
                                class="w-7 h-7 rounded-lg bg-white border border-forest-200 hover:bg-forest-50 flex items-center justify-center transition-colors">
                            <i class="fas fa-minus text-xs"></i>
                        </button>
                        <input type="number" value="${item.jumlah}" min="1" max="${item.stok}" 
                               onchange="updateJumlah(${index}, this.value)"
                               class="w-12 text-center px-2 py-1 bg-white border border-forest-200 rounded-lg text-sm font-semibold">
                        <button type="button" onclick="ubahJumlah(${index}, 1)" 
                                class="w-7 h-7 rounded-lg bg-white border border-forest-200 hover:bg-forest-50 flex items-center justify-center transition-colors">
                            <i class="fas fa-plus text-xs"></i>
                        </button>
                    </div>
                    <div class="text-right">
                        <p class="font-display font-bold text-forest-600 text-sm">${formatRupiah(item.harga * item.jumlah)}</p>
                        <p class="text-xs text-forest-500">${formatRupiah(item.harga)} × ${item.jumlah}</p>
                    </div>
                </div>
            </div>
        `).join('');
        
        // Update input hidden untuk form submission
        inputItems.innerHTML = keranjang.map((item, index) => `
            <input type="hidden" name="items[${index}][buku_id]" value="${item.buku_id}">
            <input type="hidden" name="items[${index}][jumlah]" value="${item.jumlah}">
            <input type="hidden" name="items[${index}][harga]" value="${item.harga}">
            <input type="hidden" name="items[${index}][diskon]" value="${item.diskon}">
        `).join('');
    }
    
    hitungTotal();
}

// Hapus Item
function hapusItem(index) {
    keranjang.splice(index, 1);
    renderKeranjang();
}

// Ubah Jumlah
function ubahJumlah(index, perubahan) {
    const newItem = keranjang[index].jumlah + perubahan;
    if (newItem >= 1 && newItem <= keranjang[index].stok) {
        keranjang[index].jumlah = newItem;
        renderKeranjang();
    }
}

// Update Jumlah
function updateJumlah(index, value) {
    const jumlah = parseInt(value);
    if (jumlah >= 1 && jumlah <= keranjang[index].stok) {
        keranjang[index].jumlah = jumlah;
        renderKeranjang();
    }
}

// Hitung Total
function hitungTotal() {
    const subtotal = keranjang.reduce((sum, item) => sum + (item.harga * item.jumlah), 0);
    const diskon = parseFloat(document.getElementById('diskon').value) || 0;
    const total = subtotal - diskon;
    const bayar = parseFloat(document.getElementById('bayar').value) || 0;
    const kembalian = bayar - total;
    
    document.getElementById('subtotalDisplay').textContent = formatRupiah(subtotal);
    document.getElementById('totalDisplay').textContent = formatRupiah(total);
    document.getElementById('kembalianDisplay').textContent = formatRupiah(kembalian > 0 ? kembalian : 0);
    
    // Enable/disable tombol bayar
    const btnBayar = document.getElementById('btnBayar');
    btnBayar.disabled = keranjang.length === 0 || bayar < total;
}

// Format Rupiah
function formatRupiah(angka) {
    return 'Rp ' + angka.toLocaleString('id-ID');
}

// Event Listeners
document.getElementById('diskon').addEventListener('input', hitungTotal);
document.getElementById('bayar').addEventListener('input', hitungTotal);

// Submit validation
document.getElementById('formTransaksi').addEventListener('submit', function(e) {
    if (keranjang.length === 0) {
        e.preventDefault();
        alert('Keranjang masih kosong!');
    }
});
</script>
@endpush
@endsection