<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - SiBuku</title>
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Cormorant+Garamond:wght@500;600;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Tailwind Config untuk Tema Mystical Forest -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'forest-50': '#F0F4E8',
                        'forest-100': '#DDE5C9',
                        'forest-200': '#B8C9A0',
                        'forest-300': '#8FA878',
                        'forest-400': '#6B8F5A',
                        'forest-500': '#4A6B3D',
                        'forest-600': '#3D5A2F',
                        'forest-700': '#2D4A23',
                        'forest-800': '#1F3318',
                        'forest-900': '#0F1F0F',
                        'moonlight-50': '#FAF7E8',
                        'moonlight-100': '#F0EAC8',
                        'moonlight-200': '#E8D98A',
                        'moonlight-300': '#D4C87A',
                        'moonlight-400': '#B8A85A',
                        'moonlight-500': '#9A8B3D',
                        'emerald-50': '#E8F5E8',
                        'emerald-100': '#C8E0C8',
                        'emerald-200': '#8FBC8F',
                        'emerald-300': '#5A9A5A',
                        'emerald-400': '#3D7A3D',
                        'emerald-500': '#2D5A2D',
                    },
                    fontFamily: {
                        display: ['Cormorant Garamond', 'serif'],
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                },
            },
        }
    </script>

    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-display { font-family: 'Cormorant Garamond', serif; }
        
        body { background: #F0F4E8; }

        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #F0F4E8; }
        ::-webkit-scrollbar-thumb { background: linear-gradient(180deg, #8FA878 0%, #3D5A2F 100%); border-radius: 10px; }

        /* Sidebar Transition */
        #sidebar { transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .sidebar-text { transition: opacity 0.2s ease, width 0.2s ease; }
        
        /* Collapsed State */
        body.sidebar-collapsed #sidebar { width: 80px !important; }
        body.sidebar-collapsed .sidebar-text { opacity: 0; width: 0; overflow: hidden; }
        body.sidebar-collapsed .menu-label { display: none; }
        body.sidebar-collapsed .logo-text { display: none; }
        body.sidebar-collapsed .user-info { display: none; }
        
        /* Active Menu Item */
        .menu-item.active { background: rgba(143, 168, 120, 0.2); border-left: 3px solid #E8D98A; }
        .menu-item.active i { color: #E8D98A; }
        .menu-item.active span { color: #F0EAC8; font-weight: 600; }
    </style>
    @stack('styles')
</head>
<body class="antialiased flex h-screen overflow-hidden">

    <!-- Sidebar -->
    <aside id="sidebar" class="w-64 bg-forest-900 text-moonlight-100 flex flex-col h-full shadow-2xl relative z-20">
        <!-- Logo Area -->
        <div class="h-16 flex items-center justify-between px-6 border-b border-forest-700/50">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-moonlight-300 to-moonlight-500 flex items-center justify-center shadow-lg">
                    <i class="fas fa-book-open text-forest-900 text-sm"></i>
                </div>
                <span class="logo-text font-display text-xl font-bold text-moonlight-100 tracking-wide">SiBuku</span>
            </div>
            <!-- Toggle Button (Desktop) -->
            <button onclick="toggleSidebar()" class="hidden lg:block text-forest-300 hover:text-moonlight-200 transition-colors p-1 rounded hover:bg-forest-800">
                <i class="fas fa-bars text-lg"></i>
            </button>
        </div>

        <!-- Navigation Menu -->
        <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1">
            <!-- MENU UTAMA -->
            <p class="menu-label text-[10px] font-bold text-forest-400 uppercase tracking-wider px-3 mb-2">Menu Utama</p>
            <a href="{{ route('dashboard') }}" class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }} flex items-center gap-3 px-3 py-2.5 rounded-lg text-forest-200 hover:bg-forest-800 hover:text-moonlight-100 transition-all group">
                <i class="fas fa-home w-5 text-center text-forest-400 group-hover:text-moonlight-200 transition-colors"></i>
                <span class="sidebar-text text-sm">Dashboard</span>
            </a>

            <!-- MASTER DATA -->
            <p class="menu-label text-[10px] font-bold text-forest-400 uppercase tracking-wider px-3 mb-2 mt-4">Master Data</p>
            <a href="{{ route('buku.index') }}" class="menu-item {{ request()->routeIs('buku.*') ? 'active' : '' }} flex items-center gap-3 px-3 py-2.5 rounded-lg text-forest-200 hover:bg-forest-800 hover:text-moonlight-100 transition-all group">
                <i class="fas fa-book w-5 text-center text-forest-400 group-hover:text-moonlight-200 transition-colors"></i>
                <span class="sidebar-text text-sm">Data Buku</span>
            </a>
            <a href="{{ route('kategori.index') }}" class="menu-item {{ request()->routeIs('kategori.*') ? 'active' : '' }} flex items-center gap-3 px-3 py-2.5 rounded-lg text-forest-200 hover:bg-forest-800 hover:text-moonlight-100 transition-all group">
                <i class="fas fa-tags w-5 text-center text-forest-400 group-hover:text-moonlight-200 transition-colors"></i>
                <span class="sidebar-text text-sm">Kategori</span>
            </a>
            <a href="{{ route('pelanggan.index') }}" class="menu-item {{ request()->routeIs('pelanggan.*') ? 'active' : '' }} flex items-center gap-3 px-3 py-2.5 rounded-lg text-forest-200 hover:bg-forest-800 hover:text-moonlight-100 transition-all group">
                <i class="fas fa-users w-5 text-center text-forest-400 group-hover:text-moonlight-200 transition-colors"></i>
                <span class="sidebar-text text-sm">Pelanggan</span>
            </a>
            <a href="{{ route('supplier.index') }}" class="menu-item {{ request()->routeIs('supplier.*') ? 'active' : '' }} flex items-center gap-3 px-3 py-2.5 rounded-lg text-forest-200 hover:bg-forest-800 hover:text-moonlight-100 transition-all group">
                <i class="fas fa-truck w-5 text-center text-forest-400 group-hover:text-moonlight-200 transition-colors"></i>
                <span class="sidebar-text text-sm">Supplier</span>
            </a>

            <!-- OPERASIONAL -->
            <p class="menu-label text-[10px] font-bold text-forest-400 uppercase tracking-wider px-3 mb-2 mt-4">Operasional</p>
            <a href="{{ route('transaksi.create') }}" class="menu-item {{ request()->routeIs('transaksi.create') ? 'active' : '' }} flex items-center gap-3 px-3 py-2.5 rounded-lg text-forest-200 hover:bg-forest-800 hover:text-moonlight-100 transition-all group">
                <i class="fas fa-cash-register w-5 text-center text-forest-400 group-hover:text-moonlight-200 transition-colors"></i>
                <span class="sidebar-text text-sm">Transaksi Baru</span>
            </a>
            <a href="{{ route('transaksi.index') }}" class="menu-item {{ request()->routeIs('transaksi.index') ? 'active' : '' }} flex items-center gap-3 px-3 py-2.5 rounded-lg text-forest-200 hover:bg-forest-800 hover:text-moonlight-100 transition-all group">
                <i class="fas fa-history w-5 text-center text-forest-400 group-hover:text-moonlight-200 transition-colors"></i>
                <span class="sidebar-text text-sm">Riwayat Transaksi</span>
            </a>
            <a href="{{ route('stok.index') }}" class="menu-item {{ request()->routeIs('stok.*') ? 'active' : '' }} flex items-center gap-3 px-3 py-2.5 rounded-lg text-forest-200 hover:bg-forest-800 hover:text-moonlight-100 transition-all group">
                <i class="fas fa-boxes-stacked w-5 text-center text-forest-400 group-hover:text-moonlight-200 transition-colors"></i>
                <span class="sidebar-text text-sm">Stok Masuk</span>
            </a>

            <!-- LAPORAN -->
            <p class="menu-label text-[10px] font-bold text-forest-400 uppercase tracking-wider px-3 mb-2 mt-4">Laporan</p>
            <a href="{{ route('laporan.index') }}" class="menu-item {{ request()->routeIs('laporan.*') ? 'active' : '' }} flex items-center gap-3 px-3 py-2.5 rounded-lg text-forest-200 hover:bg-forest-800 hover:text-moonlight-100 transition-all group">
                <i class="fas fa-chart-pie w-5 text-center text-forest-400 group-hover:text-moonlight-200 transition-colors"></i>
                <span class="sidebar-text text-sm">Laporan</span>
            </a>

            <!-- SISTEM -->
            <p class="menu-label text-[10px] font-bold text-forest-400 uppercase tracking-wider px-3 mb-2 mt-4">Sistem</p>
            <a href="{{ route('pengaturan.index') }}" class="menu-item {{ request()->routeIs('pengaturan.*') ? 'active' : '' }} flex items-center gap-3 px-3 py-2.5 rounded-lg text-forest-200 hover:bg-forest-800 hover:text-moonlight-100 transition-all group">
                <i class="fas fa-cog w-5 text-center text-forest-400 group-hover:text-moonlight-200 transition-colors"></i>
                <span class="sidebar-text text-sm">Pengaturan</span>
            </a>
        </nav>

        <!-- User Profile Bottom -->
        <div class="p-4 border-t border-forest-700/50">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-full bg-gradient-to-br from-forest-500 to-forest-700 flex items-center justify-center text-moonlight-100 font-bold text-sm shadow-md">
                    {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
                </div>
                <div class="user-info flex-1 min-w-0">
                    <p class="text-sm font-semibold text-moonlight-100 truncate">{{ auth()->user()->name ?? 'Administrator' }}</p>
                    <p class="text-xs text-forest-400 truncate">{{ auth()->user()->role ?? 'Admin' }}</p>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="user-info">
                    @csrf
                    <button type="submit" class="text-forest-400 hover:text-red-400 transition-colors p-1">
                        <i class="fas fa-sign-out-alt"></i>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col h-full overflow-hidden relative">
        <!-- Topbar (Mobile Toggle & Page Title) -->
        <header class="h-16 bg-moonlight-50/80 backdrop-blur-md border-b border-forest-200 flex items-center justify-between px-6 shadow-sm z-10">
            <div class="flex items-center gap-4">
                <!-- Mobile Toggle -->
                <button onclick="toggleSidebar()" class="lg:hidden text-forest-600 hover:text-forest-900 p-2 rounded-lg hover:bg-forest-100 transition-colors">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                <div>
                    <h1 class="font-display text-xl font-bold text-forest-900">@yield('page-title', 'Dashboard')</h1>
                    <p class="text-xs text-forest-400 hidden sm:block">@yield('page-subtitle', 'Kelola inventori dan operasional toko buku bekas')</p>
                </div>
            </div>
            
            <!-- Topbar Right Actions -->
            <div class="flex items-center gap-3">
                <button class="relative p-2 text-forest-500 hover:text-forest-800 hover:bg-forest-100 rounded-lg transition-colors">
                    <i class="fas fa-bell text-lg"></i>
                    <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full"></span>
                </button>
            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-1 overflow-y-auto p-6 bg-forest-50">
            @yield('content')
        </main>
    </div>

    <!-- Overlay for Mobile -->
    <div id="sidebar-overlay" onclick="toggleSidebar()" class="fixed inset-0 bg-forest-900/50 backdrop-blur-sm z-10 hidden lg:hidden"></div>

    <script>
        function toggleSidebar() {
            const body = document.body;
            const overlay = document.getElementById('sidebar-overlay');
            const isMobile = window.innerWidth < 1024;
            
            if (isMobile) {
                // Mobile: Slide in/out
                const sidebar = document.getElementById('sidebar');
                if (sidebar.classList.contains('-translate-x-full')) {
                    sidebar.classList.remove('-translate-x-full');
                    overlay.classList.remove('hidden');
                } else {
                    sidebar.classList.add('-translate-x-full');
                    overlay.classList.add('hidden');
                }
            } else {
                // Desktop: Collapse/Expand
                body.classList.toggle('sidebar-collapsed');
            }
        }

        // Initialize mobile state
        if (window.innerWidth < 1024) {
            document.getElementById('sidebar').classList.add('-translate-x-full', 'fixed', 'lg:relative');
        }
    </script>
    @stack('scripts')
</body>
</html>