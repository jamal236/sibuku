<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Dashboard' }} — {{ config('app.name', 'SiBuku') }}</title>

    <!-- Bootstrap 5 (Bagian 2.1 rancangan arsitektur) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        :root {
            --sibuku-primary: #5b3a29;   /* coklat buku tua */
            --sibuku-accent: #c79a5b;    /* krem/kertas tua */
            --sibuku-sidebar-bg: #2f2118;
            --sibuku-sidebar-active: #5b3a29;
        }

        body {
            background-color: #f5f1ea; /* warna kertas */
            font-size: 0.95rem;
        }

        /* ---------------- Sidebar ---------------- */
        .sb-sidebar {
            min-height: 100vh;
            width: 250px;
            background-color: var(--sibuku-sidebar-bg);
            color: #f0e6d8;
            position: fixed;
            top: 0;
            left: 0;
            overflow-y: auto;
            z-index: 1030;
            transition: margin-left .2s ease-in-out;
        }

        .sb-sidebar .brand {
            font-weight: 700;
            font-size: 1.25rem;
            color: #fff;
            padding: 1rem 1.25rem;
            border-bottom: 1px solid rgba(255,255,255,.08);
            display: flex;
            align-items: center;
            gap: .5rem;
        }

        .sb-sidebar .nav-link {
            color: #d8c8b4;
            padding: .6rem 1.25rem;
            border-radius: 0;
            display: flex;
            align-items: center;
            gap: .6rem;
        }

        .sb-sidebar .nav-link i { font-size: 1.05rem; width: 1.25rem; text-align: center; }

        .sb-sidebar .nav-link:hover {
            background-color: rgba(255,255,255,.06);
            color: #fff;
        }

        .sb-sidebar .nav-link.active {
            background-color: var(--sibuku-sidebar-active);
            color: #fff;
            font-weight: 600;
        }

        .sb-sidebar .nav-section-title {
            text-transform: uppercase;
            font-size: .7rem;
            letter-spacing: .08em;
            color: #9c8a76;
            padding: 1rem 1.25rem .25rem;
        }

        /* ---------------- Content area ---------------- */
        .sb-content {
            margin-left: 250px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .sb-topbar {
            background: #fff;
            border-bottom: 1px solid #e5ddd0;
            padding: .65rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .sb-main {
            padding: 1.5rem;
            flex: 1;
        }

        .sb-role-badge {
            font-size: .7rem;
            text-transform: uppercase;
            letter-spacing: .05em;
        }

        /* Mobile: sidebar hidden by default */
        @media (max-width: 991.98px) {
            .sb-sidebar {
                margin-left: -250px;
            }
            .sb-sidebar.show {
                margin-left: 0;
            }
            .sb-content {
                margin-left: 0;
            }
        }

        .card-stat {
            border: none;
            border-radius: .75rem;
            box-shadow: 0 1px 3px rgba(0,0,0,.06);
        }

        .card-stat .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: .65rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
        }
    </style>

    @stack('styles')
</head>
<body>

    @php
        $user = auth()->user();
        $currentRoute = Route::currentRouteName();

        // Helper kecil untuk menentukan apakah sebuah grup menu sedang aktif
        $isActive = function (string|array $patterns) use ($currentRoute) {
            foreach ((array) $patterns as $pattern) {
                if (\Illuminate\Support\Str::is($pattern, $currentRoute)) {
                    return true;
                }
            }
            return false;
        };
    @endphp

    <!-- =================== SIDEBAR =================== -->
    <aside class="sb-sidebar" id="sbSidebar">
        <div class="brand">
            <i class="bi bi-book-half"></i>
            <span>SiBuku</span>
        </div>

        <ul class="nav flex-column py-2">

            <li class="nav-item">
                <a class="nav-link {{ $isActive('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            </li>

            {{-- ====================== TRANSAKSI ====================== --}}
            @if ($user->can('transaksi.proses') || $user->can('transaksi.lihat-semua') || $user->can('transaksi.lihat-sendiri'))
                <li class="nav-section-title">Transaksi</li>

                @can('transaksi.proses')
                    <li class="nav-item">
                        <a class="nav-link {{ $isActive('transaksi.kasir') ? 'active' : '' }}" href="{{ route('transaksi.kasir') }}">
                            <i class="bi bi-cash-coin"></i> Transaksi Baru
                        </a>
                    </li>
                @endcan

                @canany(['transaksi.lihat-sendiri', 'transaksi.lihat-semua'])
                    <li class="nav-item">
                        <a class="nav-link {{ $isActive(['transaksi.index', 'transaksi.show', 'transaksi.nota']) ? 'active' : '' }}" href="{{ route('transaksi.index') }}">
                            <i class="bi bi-receipt"></i>
                            {{ $user->can('transaksi.lihat-semua') ? 'Riwayat Transaksi' : 'Riwayat Penjualan Saya' }}
                        </a>
                    </li>
                @endcanany
            @endif

            {{-- ====================== MASTER DATA ====================== --}}
            @if ($user->can('buku.lihat') || $user->can('kategori.kelola') || $user->can('supplier.lihat'))
                <li class="nav-section-title">Master Data</li>

                @can('buku.lihat')
                    <li class="nav-item">
                        <a class="nav-link {{ $isActive('buku.*') ? 'active' : '' }}" href="{{ route('buku.index') }}">
                            <i class="bi bi-journal-bookmark"></i> Data Buku
                        </a>
                    </li>
                @endcan

                @can('kategori.kelola')
                    <li class="nav-item">
                        <a class="nav-link {{ $isActive('kategori.*') ? 'active' : '' }}" href="{{ route('kategori.index') }}">
                            <i class="bi bi-tags"></i> Kategori
                        </a>
                    </li>
                @endcan

                @can('supplier.lihat')
                    <li class="nav-item">
                        <a class="nav-link {{ $isActive('supplier.*') ? 'active' : '' }}" href="{{ route('supplier.index') }}">
                            <i class="bi bi-truck"></i> Supplier &amp; Donatur
                        </a>
                    </li>
                @endcan
            @endif

            {{-- ====================== STOK ====================== --}}
            @if ($user->can('stok.lihat') || $user->can('stok.catat-masuk'))
                <li class="nav-section-title">Stok</li>

                @can('stok.catat-masuk')
                    <li class="nav-item">
                        <a class="nav-link {{ $isActive('stok.masuk') ? 'active' : '' }}" href="{{ route('stok.masuk') }}">
                            <i class="bi bi-box-arrow-in-down"></i> Stok Masuk
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $isActive('stok.riwayat') ? 'active' : '' }}" href="{{ route('stok.riwayat') }}">
                            <i class="bi bi-clock-history"></i> Riwayat Stok Masuk
                        </a>
                    </li>
                @endcan

                @can('stok.lihat')
                    <li class="nav-item">
                        <a class="nav-link {{ $isActive('stok.rendah') ? 'active' : '' }}" href="{{ route('stok.rendah') }}">
                            <i class="bi bi-exclamation-triangle"></i> Stok Menipis
                        </a>
                    </li>
                @endcan
            @endif

            {{-- ====================== PELANGGAN ====================== --}}
            @can('pelanggan.lihat')
                <li class="nav-section-title">Pelanggan</li>
                <li class="nav-item">
                    <a class="nav-link {{ $isActive('pelanggan.*') ? 'active' : '' }}" href="{{ route('pelanggan.index') }}">
                        <i class="bi bi-people"></i> Data Pelanggan
                    </a>
                </li>
            @endcan

            {{-- ====================== LAPORAN ====================== --}}
            @if ($user->can('laporan.lihat') || $user->can('laporan.per-kasir'))
                <li class="nav-section-title">Laporan</li>

                @can('laporan.lihat')
                    <li class="nav-item">
                        <a class="nav-link {{ $isActive('laporan.penjualan') ? 'active' : '' }}" href="{{ route('laporan.penjualan') }}">
                            <i class="bi bi-graph-up"></i> Laporan Penjualan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $isActive('laporan.stok') ? 'active' : '' }}" href="{{ route('laporan.stok') }}">
                            <i class="bi bi-bar-chart-line"></i> Laporan Stok
                        </a>
                    </li>
                @endcan

                @can('laporan.per-kasir')
                    <li class="nav-item">
                        <a class="nav-link {{ $isActive('laporan.kasir') ? 'active' : '' }}" href="{{ route('laporan.kasir') }}">
                            <i class="bi bi-person-badge"></i> Performa Kasir
                        </a>
                    </li>
                @endcan
            @endif

            {{-- ====================== ADMINISTRASI ====================== --}}
            @if ($user->can('user.kelola') || $user->can('pengaturan.kelola'))
                <li class="nav-section-title">Administrasi</li>

                @can('user.kelola')
                    <li class="nav-item">
                        <a class="nav-link {{ $isActive('user.*') ? 'active' : '' }}" href="{{ route('user.index') }}">
                            <i class="bi bi-person-gear"></i> Manajemen User
                        </a>
                    </li>
                @endcan

                @can('pengaturan.kelola')
                    <li class="nav-item">
                        <a class="nav-link {{ $isActive('pengaturan.*') ? 'active' : '' }}" href="{{ route('pengaturan.toko') }}">
                            <i class="bi bi-gear"></i> Pengaturan Toko
                        </a>
                    </li>
                @endcan
            @endif

        </ul>
    </aside>

    <!-- =================== CONTENT =================== -->
    <div class="sb-content">

        <!-- Topbar -->
        <header class="sb-topbar">
            <button class="btn btn-sm btn-outline-secondary d-lg-none" type="button" onclick="document.getElementById('sbSidebar').classList.toggle('show')">
                <i class="bi bi-list"></i>
            </button>

            <h5 class="mb-0 d-none d-md-block">{{ $title ?? 'Dashboard' }}</h5>

            <div class="dropdown">
                <button class="btn btn-light d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown">
                    <i class="bi bi-person-circle fs-5"></i>
                    <span class="d-none d-sm-inline">
                        {{ $user->name }}
                        <span class="badge bg-secondary sb-role-badge ms-1">{{ $user->roles->first()?->name }}</span>
                    </span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="bi bi-person me-2"></i> Profil Saya</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="bi bi-box-arrow-right me-2"></i> Keluar
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </header>

        <!-- Flash messages -->
        <div class="sb-main">
            @includeWhen(session('success'), 'components.alert', ['type' => 'success', 'message' => session('success')])
            @includeWhen(session('error'), 'components.alert', ['type' => 'danger', 'message' => session('error')])
            @includeWhen(session('info'), 'components.alert', ['type' => 'info', 'message' => session('info')])

            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong><i class="bi bi-exclamation-circle me-1"></i> Terdapat kesalahan input:</strong>
                    <ul class="mb-0 mt-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{ $slot ?? '' }}
            @yield('content')
        </div>

        <footer class="text-center text-muted small py-3">
            SiBuku — Sistem Informasi Point of Sale Toko Buku Bekas &middot; {{ date('Y') }}
        </footer>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
