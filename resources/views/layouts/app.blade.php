<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SiBuku')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/sibuku-icon.png') }}">
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Cormorant+Garamond:wght@500;600;700&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    
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
        * {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            background: #F0F4E8;
        }

        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #F0F4E8;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, #8FA878 0%, #3D5A2F 100%);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(180deg, #6B8F5A 0%, #2D4A23 100%);
        }

        .card {
            background: rgba(250, 247, 232, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(184, 201, 160, 0.4);
            border-radius: 1rem;
            padding: 1.5rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .card:hover {
            box-shadow: 0 10px 30px rgba(31, 51, 24, 0.15);
            transform: translateY(-2px);
            border-color: rgba(143, 168, 120, 0.6);
        }

        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .card-hover:hover {
            box-shadow: 0 10px 30px rgba(31, 51, 24, 0.15);
            transform: translateY(-2px);
        }

        .font-display {
            font-family: 'Cormorant Garamond', serif;
        }

        #admin-sidebar {
            transition: transform 0.3s ease-in-out;
        }

        #main-content {
            transition: margin-left 0.3s ease-in-out;
        }

        .toggle-btn {
            transition: transform 0.3s ease;
        }

        .toggle-btn.rotate {
            transform: rotate(180deg);
        }

        /* Notification Dropdown Animation */
        #notificationDropdown {
            animation: slideDown 0.3s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Notification Item Hover */
        .notification-item:hover {
            background: linear-gradient(to right, rgba(74, 107, 61, 0.05), rgba(250, 247, 232, 0.5));
        }

        /* Scrollbar untuk notification list */
        .notification-list::-webkit-scrollbar {
            width: 6px;
        }

        .notification-list::-webkit-scrollbar-track {
            background: rgba(240, 244, 232, 0.5);
        }

        .notification-list::-webkit-scrollbar-thumb {
            background: rgba(143, 168, 120, 0.5);
            border-radius: 10px;
        }

        .notification-list::-webkit-scrollbar-thumb:hover {
            background: rgba(143, 168, 120, 0.8);
        }
    </style>

    <style type="text/tailwind">
        .page-container {
            @apply max-w-7xl mx-auto space-y-6;
        }

        .section-header {
            @apply flex items-center justify-between mb-6;
        }

        .section-title {
            @apply font-display text-2xl font-bold text-forest-900;
        }

        .form-group {
            @apply mb-4;
        }

        .form-label {
            @apply block text-sm font-semibold text-forest-700 mb-2;
        }

        .form-input {
            @apply w-full px-4 py-2.5 border-2 border-forest-200 rounded-xl 
                   bg-moonlight-50 text-forest-900 placeholder-forest-300
                   focus:border-forest-400 focus:ring-2 focus:ring-forest-200 
                   focus:outline-none transition-all;
        }

        .form-select {
            @apply w-full px-4 py-2.5 border-2 border-forest-200 rounded-xl 
                   bg-moonlight-50 text-forest-900
                   focus:border-forest-400 focus:ring-2 focus:ring-forest-200 
                   focus:outline-none transition-all;
        }

        .alert {
            @apply p-4 rounded-xl border-l-4;
        }

        .alert-success {
            @apply bg-emerald-50 border-emerald-400 text-emerald-700;
        }

        .alert-warning {
            @apply bg-moonlight-100 border-moonlight-400 text-moonlight-500;
        }

        .alert-danger {
            @apply bg-red-50 border-red-400 text-red-700;
        }

        .alert-info {
            @apply bg-forest-50 border-forest-400 text-forest-700;
        }

        .badge {
            @apply px-3 py-1 rounded-full text-xs font-bold;
        }

        .badge-success {
            @apply bg-emerald-100 text-emerald-700;
        }

        .badge-warning {
            @apply bg-moonlight-100 text-moonlight-500;
        }

        .badge-danger {
            @apply bg-red-100 text-red-700;
        }

        .badge-info {
            @apply bg-forest-100 text-forest-700;
        }

        .modal-overlay {
            @apply fixed inset-0 bg-forest-900/50 backdrop-blur-sm z-50 
                   flex items-center justify-center p-4;
        }

        .modal-content {
            @apply bg-moonlight-50 rounded-2xl shadow-2xl max-w-2xl w-full 
                   max-h-[90vh] overflow-y-auto;
        }

        .pagination {
            @apply flex items-center gap-2 mt-6;
        }

        .pagination-link {
            @apply px-4 py-2 rounded-xl border border-forest-200 
                   text-forest-600 hover:bg-forest-100 transition-colors;
        }

        .pagination-link.active {
            @apply bg-forest-500 text-moonlight-50 border-forest-500;
        }

        .empty-state {
            @apply text-center py-12;
        }

        .empty-state-icon {
            @apply w-20 h-20 mx-auto mb-4 rounded-full bg-forest-100 
                   flex items-center justify-center text-forest-400 text-3xl;
        }

        .empty-state-text {
            @apply text-forest-500 text-sm;
        }

        .spinner {
            @apply w-8 h-8 border-4 border-forest-200 border-t-forest-600 
                   rounded-full animate-spin;
        }

        .search-bar {
            @apply relative mb-6;
        }

        .search-input {
            @apply w-full pl-12 pr-4 py-3 border-2 border-forest-200 rounded-xl 
                   bg-moonlight-50 text-forest-900 placeholder-forest-300
                   focus:border-forest-400 focus:ring-2 focus:ring-forest-200 
                   focus:outline-none transition-all;
        }

        .search-icon {
            @apply absolute left-4 top-1/2 -translate-y-1/2 text-forest-400;
        }

        .filter-bar {
            @apply flex flex-wrap gap-3 mb-6 p-4 bg-forest-50/50 rounded-xl 
                   border border-forest-200;
        }

        .stats-card {
            @apply card card-hover rounded-2xl p-6;
        }

        .stats-card-icon {
            @apply w-14 h-14 rounded-2xl flex items-center justify-center shadow-lg;
        }

        .stats-card-label {
            @apply text-sm text-forest-400 font-medium;
        }

        .stats-card-value {
            @apply text-3xl font-display font-bold text-forest-900 mt-1;
        }

        .stats-card-sublabel {
            @apply text-xs text-forest-300 mt-2;
        }

        .action-group {
            @apply flex items-center gap-2;
        }

        .breadcrumb {
            @apply flex items-center gap-2 text-sm text-forest-500 mb-4;
        }

        .breadcrumb-link {
            @apply text-forest-600 hover:text-forest-800 transition-colors;
        }

        .breadcrumb-separator {
            @apply text-forest-300;
        }

        .tab-nav {
            @apply flex gap-2 border-b border-forest-200 mb-6;
        }

        .tab-link {
            @apply px-4 py-3 text-sm font-semibold text-forest-500 
                   border-b-2 border-transparent hover:text-forest-700 
                   hover:border-forest-300 transition-all;
        }

        .tab-link.active {
            @apply text-forest-700 border-forest-500;
        }

        .dropdown-menu {
            @apply absolute right-0 mt-2 w-48 bg-moonlight-50 rounded-xl 
                   shadow-lg border border-forest-200 py-2 z-50;
        }

        .dropdown-item {
            @apply px-4 py-2 text-sm text-forest-700 hover:bg-forest-100 
                   transition-colors cursor-pointer;
        }

        .tooltip {
            @apply relative;
        }

        .tooltip-text {
            @apply invisible absolute bottom-full left-1/2 -translate-x-1/2 
                   mb-2 px-3 py-1 text-xs text-moonlight-50 bg-forest-800 
                   rounded-lg whitespace-nowrap opacity-0 transition-opacity;
        }

        .tooltip:hover .tooltip-text {
            @apply visible opacity-100;
        }
    </style>

    @stack('styles')
</head>
<body class="antialiased">
    @include('partials.admin-sidebar')

    <div id="main-content" class="lg:ml-72 min-h-screen transition-all duration-300">
        <header class="bg-forest-50/80 backdrop-blur-md border-b border-forest-200 sticky top-0 z-30">
            <div class="flex items-center justify-between px-6 py-4">
                <div class="flex items-center gap-4">
                    <button onclick="toggleSidebar()" class="toggle-btn p-2 rounded-xl bg-forest-100 text-forest-700 hover:bg-forest-200 hover:text-forest-900 transition-colors shadow-sm">
                        <i class="fas fa-bars text-lg"></i>
                    </button>
                    
                    <div>
                        <h1 class="font-display text-2xl font-bold text-forest-900">@yield('page-title', 'Dashboard')</h1>
                        <p class="text-sm text-forest-500">@yield('page-subtitle', 'Selamat datang di SiBuku')</p>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <!-- Notification Bell -->
                    <div class="relative">
                        <button onclick="toggleNotifications()" class="relative p-2 rounded-xl bg-forest-100 text-forest-600 hover:bg-forest-200 transition-colors">
                            <i class="fas fa-bell text-lg"></i>
                            <span id="notificationBadge" class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-xs rounded-full flex items-center justify-center font-bold">3</span>
                        </button>
                        
                        <!-- Notification Dropdown -->
                        <div id="notificationDropdown" class="hidden absolute right-0 mt-2 w-96 bg-moonlight-50 rounded-2xl shadow-2xl border border-forest-200 z-50 overflow-hidden">
                            <!-- Header -->
                            <div class="flex items-center justify-between p-4 border-b border-forest-200 bg-gradient-to-r from-forest-50 to-moonlight-50">
                                <h3 class="font-display font-bold text-forest-900">Notifikasi</h3>
                                <button onclick="markAllRead()" class="text-xs text-forest-600 hover:text-forest-800 font-medium transition-colors">
                                    Tandai semua dibaca
                                </button>
                            </div>
                            
                            <!-- Notifications List -->
                            <div class="max-h-96 overflow-y-auto notification-list">
                                <!-- Notification 1: Stok Rendah -->
                                <a href="{{ route('buku.index') }}" class="notification-item flex items-start gap-3 p-4 transition-colors border-b border-forest-100">
                                    <div class="w-10 h-10 rounded-full bg-red-100 text-red-600 flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-exclamation-triangle"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-semibold text-forest-900 mb-1">Stok Buku Menipis</p>
                                        <p class="text-xs text-forest-600 mb-1">5 buku memiliki stok di bawah minimum</p>
                                        <p class="text-xs text-forest-400">2 jam yang lalu</p>
                                    </div>
                                    <div class="w-2 h-2 rounded-full bg-red-500 flex-shrink-0 mt-2"></div>
                                </a>

                                <!-- Notification 2: Transaksi Baru -->
                                <a href="{{ route('transaksi.index') }}" class="notification-item flex items-start gap-3 p-4 transition-colors border-b border-forest-100">
                                    <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-cash-register"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-semibold text-forest-900 mb-1">Transaksi Baru</p>
                                        <p class="text-xs text-forest-600 mb-1">Transaksi #TRX20260617002 senilai Rp 250.000</p>
                                        <p class="text-xs text-forest-400">5 jam yang lalu</p>
                                    </div>
                                    <div class="w-2 h-2 rounded-full bg-emerald-500 flex-shrink-0 mt-2"></div>
                                </a>

                                <!-- Notification 3: Stok Masuk -->
                                <a href="{{ route('stok.index') }}" class="notification-item flex items-start gap-3 p-4 transition-colors">
                                    <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-truck"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-semibold text-forest-900 mb-1">Stok Masuk Baru</p>
                                        <p class="text-xs text-forest-600 mb-1">10 eksemplar buku "Project Hail Mary" diterima</p>
                                        <p class="text-xs text-forest-400">1 hari yang lalu</p>
                                    </div>
                                    <div class="w-2 h-2 rounded-full bg-blue-500 flex-shrink-0 mt-2"></div>
                                </a>
                            </div>

                            <!-- Footer -->
                            <div class="p-3 border-t border-forest-200 bg-gradient-to-r from-forest-50 to-moonlight-50">
                                <a href="#" class="block text-center text-sm font-semibold text-forest-700 hover:text-forest-900 transition-colors">
                                    Lihat Semua Notifikasi <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="lg:hidden w-10 h-10 rounded-full bg-gradient-to-br from-forest-500 to-forest-700 text-moonlight-50 flex items-center justify-center font-bold shadow-md">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                </div>
            </div>
        </header>

        <main class="p-6">
            @yield('content')
        </main>

        <footer class="px-6 py-4 border-t border-forest-200 bg-forest-50/50">
            <div class="flex items-center justify-center gap-2 text-sm text-forest-500">
                <i class="fas fa-leaf text-forest-400"></i>
                <span>&copy; 2026 <strong class="text-forest-700">{{ \App\Models\Pengaturan::get('toko_nama', 'SiBuku') }}</strong>. All rights reserved.</span>
            </div>
        </footer>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('admin-sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            const mainContent = document.getElementById('main-content');
            
            if (sidebar.classList.contains('-translate-x-full')) {
                sidebar.classList.remove('-translate-x-full');
                sidebar.classList.add('translate-x-0');
                
                if (window.innerWidth < 1024) {
                    overlay.classList.remove('hidden');
                    setTimeout(() => {
                        overlay.classList.remove('opacity-0');
                    }, 10);
                }
            } else {
                sidebar.classList.remove('translate-x-0');
                sidebar.classList.add('-translate-x-full');
                
                overlay.classList.add('opacity-0');
                setTimeout(() => {
                    overlay.classList.add('hidden');
                }, 300);
            }
        }

        // Toggle Notifications Dropdown
        function toggleNotifications() {
            const dropdown = document.getElementById('notificationDropdown');
            dropdown.classList.toggle('hidden');
        }

        // Mark All as Read
        function markAllRead() {
            // Remove all unread indicators
            document.querySelectorAll('.notification-item .w-2.h-2').forEach(dot => {
                dot.classList.remove('bg-red-500', 'bg-emerald-500', 'bg-blue-500');
                dot.classList.add('bg-gray-300');
            });
            
            // Update badge count
            const badge = document.getElementById('notificationBadge');
            badge.textContent = '0';
            badge.classList.add('hidden');
            
            // Close dropdown
            document.getElementById('notificationDropdown').classList.add('hidden');
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const notificationContainer = event.target.closest('.relative');
            const dropdown = document.getElementById('notificationDropdown');
            
            if (!notificationContainer && !dropdown.classList.contains('hidden')) {
                dropdown.classList.add('hidden');
            }
        });

        window.addEventListener('resize', function() {
            if (window.innerWidth >= 1024) {
                const sidebar = document.getElementById('admin-sidebar');
                const overlay = document.getElementById('sidebar-overlay');
                
                sidebar.classList.remove('-translate-x-full');
                sidebar.classList.add('translate-x-0');
                
                overlay.classList.add('hidden');
                overlay.classList.add('opacity-0');
            } else {
                const sidebar = document.getElementById('admin-sidebar');
                sidebar.classList.remove('translate-x-0');
                sidebar.classList.add('-translate-x-full');
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            if (window.innerWidth >= 1024) {
                document.getElementById('admin-sidebar').classList.remove('-translate-x-full');
                document.getElementById('admin-sidebar').classList.add('translate-x-0');
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>