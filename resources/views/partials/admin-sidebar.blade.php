<!-- Sidebar Overlay for Mobile -->
<div id="sidebar-overlay" class="fixed inset-0 bg-forest-900/50 backdrop-blur-sm z-40 hidden opacity-0 transition-opacity duration-300 lg:hidden" onclick="toggleSidebar()"></div>

<!-- Sidebar -->
<aside id="admin-sidebar" class="fixed top-0 left-0 h-screen w-72 bg-gradient-to-b from-forest-800 via-forest-700 to-forest-900 text-moonlight-50 shadow-2xl z-50 -translate-x-full lg:translate-x-0 transition-transform duration-300 flex flex-col">
    
    <!-- Logo Section - Fixed Height -->
    <div class="h-20 flex items-center px-6 border-b border-forest-600/50 bg-forest-900/30 flex-shrink-0">
        @php
            $logoPath = \App\Models\Pengaturan::get('toko_logo');
            $tokoNama = \App\Models\Pengaturan::get('toko_nama', 'SiBuku');
        @endphp
        
        @if($logoPath)
            <img src="{{ asset('storage/' . $logoPath) }}" alt="{{ $tokoNama }}" class="w-10 h-10 object-contain mr-3">
        @else
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-forest-400 to-forest-600 flex items-center justify-center shadow-lg mr-3">
                <i class="fas fa-book-open text-moonlight-50 text-lg"></i>
            </div>
        @endif
        
        <div class="flex-1 min-w-0">
            <h1 class="font-display text-xl font-bold truncate">{{ $tokoNama }}</h1>
            <p class="text-[10px] text-forest-300 uppercase tracking-widest truncate">BOOKSTORE POS</p>
        </div>
    </div>

    <!-- Navigation - Scrollable Area -->
    <nav class="flex-1 overflow-y-auto py-6 px-3 space-y-1 scrollbar-thin scrollbar-thumb-forest-600 scrollbar-track-transparent">
        
        <!-- Menu Utama -->
        <p class="px-3 mb-2 text-xs font-semibold text-forest-300 uppercase tracking-wider flex-shrink-0">Menu Utama</p>
        
        <a href="{{ route('dashboard') }}" 
           class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-300 {{ request()->routeIs('dashboard') ? 'bg-gradient-to-r from-forest-500 to-forest-600 text-moonlight-50 shadow-lg' : 'text-forest-200 hover:bg-forest-600/50 hover:text-moonlight-50' }}">
            <i class="fas fa-home w-5 text-center"></i>
            <span>Dashboard</span>
        </a>

        <!-- Master Data -->
        <p class="px-3 mt-6 mb-2 text-xs font-semibold text-forest-300 uppercase tracking-wider flex-shrink-0">Master Data</p>
        
        @canany(['buku.lihat', 'buku.tambah'])
            <a href="{{ route('buku.index') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-300 {{ request()->routeIs('buku.*') ? 'bg-gradient-to-r from-forest-500 to-forest-600 text-moonlight-50 shadow-lg' : 'text-forest-200 hover:bg-forest-600/50 hover:text-moonlight-50' }}">
                <i class="fas fa-book w-5 text-center"></i>
                <span>Data Buku</span>
            </a>
        @endcanany

        @can('kategori.kelola')
            <a href="{{ route('kategori.index') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-300 {{ request()->routeIs('kategori.*') ? 'bg-gradient-to-r from-forest-500 to-forest-600 text-moonlight-50 shadow-lg' : 'text-forest-200 hover:bg-forest-600/50 hover:text-moonlight-50' }}">
                <i class="fas fa-tags w-5 text-center"></i>
                <span>Kategori</span>
            </a>
        @endcan

        @canany(['pelanggan.lihat', 'pelanggan.tambah'])
            <a href="{{ route('pelanggan.index') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-300 {{ request()->routeIs('pelanggan.*') ? 'bg-gradient-to-r from-forest-500 to-forest-600 text-moonlight-50 shadow-lg' : 'text-forest-200 hover:bg-forest-600/50 hover:text-moonlight-50' }}">
                <i class="fas fa-users w-5 text-center"></i>
                <span>Pelanggan</span>
            </a>
        @endcanany

        @can('supplier.lihat')
            <a href="{{ route('supplier.index') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-300 {{ request()->routeIs('supplier.*') ? 'bg-gradient-to-r from-forest-500 to-forest-600 text-moonlight-50 shadow-lg' : 'text-forest-200 hover:bg-forest-600/50 hover:text-moonlight-50' }}">
                <i class="fas fa-truck w-5 text-center"></i>
                <span>Supplier</span>
            </a>
        @endcan

        <!-- Operasional -->
        <p class="px-3 mt-6 mb-2 text-xs font-semibold text-forest-300 uppercase tracking-wider flex-shrink-0">Operasional</p>
        
        @can('transaksi.proses')
            <a href="{{ route('transaksi.create') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-300 {{ request()->routeIs('transaksi.create') ? 'bg-gradient-to-r from-forest-500 to-forest-600 text-moonlight-50 shadow-lg' : 'text-forest-200 hover:bg-forest-600/50 hover:text-moonlight-50' }}">
                <i class="fas fa-plus-circle w-5 text-center"></i>
                <span>Transaksi Baru</span>
            </a>
        @endcan

        @canany(['transaksi.lihat-semua', 'transaksi.lihat-sendiri'])
            <a href="{{ route('transaksi.index') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-300 {{ request()->routeIs('transaksi.index') ? 'bg-gradient-to-r from-forest-500 to-forest-600 text-moonlight-50 shadow-lg' : 'text-forest-200 hover:bg-forest-600/50 hover:text-moonlight-50' }}">
                <i class="fas fa-cash-register w-5 text-center"></i>
                <span>Riwayat Transaksi</span>
            </a>
        @endcanany

        @canany(['stok.lihat', 'stok.catat-masuk'])
            <a href="{{ route('stok.index') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-300 {{ request()->routeIs('stok.*') ? 'bg-gradient-to-r from-forest-500 to-forest-600 text-moonlight-50 shadow-lg' : 'text-forest-200 hover:bg-forest-600/50 hover:text-moonlight-50' }}">
                <i class="fas fa-boxes-stacked w-5 text-center"></i>
                <span>Stok Masuk</span>
            </a>
        @endcanany

        <!-- Laporan -->
        @can('laporan.lihat')
            <p class="px-3 mt-6 mb-2 text-xs font-semibold text-forest-300 uppercase tracking-wider flex-shrink-0">Laporan</p>
            
            <a href="{{ route('laporan.index') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-300 {{ request()->routeIs('laporan.*') ? 'bg-gradient-to-r from-forest-500 to-forest-600 text-moonlight-50 shadow-lg' : 'text-forest-200 hover:bg-forest-600/50 hover:text-moonlight-50' }}">
                <i class="fas fa-chart-pie w-5 text-center"></i>
                <span>Laporan</span>
            </a>
        @endcan

        <!-- Sistem -->
        @can('pengaturan.kelola')
            <p class="px-3 mt-6 mb-2 text-xs font-semibold text-forest-300 uppercase tracking-wider flex-shrink-0">Sistem</p>
            
            <a href="{{ route('pengaturan.index') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-300 {{ request()->routeIs('pengaturan.*') ? 'bg-gradient-to-r from-forest-500 to-forest-600 text-moonlight-50 shadow-lg' : 'text-forest-200 hover:bg-forest-600/50 hover:text-moonlight-50' }}">
                <i class="fas fa-cog w-5 text-center"></i>
                <span>Pengaturan</span>
            </a>
        @endcan
    </nav>

    <!-- User Profile Bottom - Fixed Height -->
    <div class="p-4 border-t border-forest-600/50 bg-forest-900/30 flex-shrink-0">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-forest-400 to-forest-600 flex items-center justify-center font-bold text-sm shadow-lg flex-shrink-0">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="font-medium text-sm truncate">{{ auth()->user()->name }}</p>
                <p class="text-xs text-forest-300 truncate">{{ auth()->user()->roles->first()->name ?? 'User' }}</p>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-forest-300 hover:text-moonlight-50 transition-colors" title="Logout">
                    <i class="fas fa-sign-out-alt"></i>
                </button>
            </form>
        </div>
    </div>
</aside>

<style>
/* Custom Scrollbar for Sidebar */
.scrollbar-thin::-webkit-scrollbar {
    width: 6px;
}

.scrollbar-thin::-webkit-scrollbar-track {
    background: transparent;
}

.scrollbar-thin::-webkit-scrollbar-thumb {
    background: rgba(143, 168, 120, 0.5);
    border-radius: 10px;
}

.scrollbar-thin::-webkit-scrollbar-thumb:hover {
    background: rgba(143, 168, 120, 0.8);
}
</style>