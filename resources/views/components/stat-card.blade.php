{{--
    components/stat-card.blade.php

    Kartu statistik ringkas untuk dashboard (Bagian 7.4: "Dashboard
    Statistik Real-Time untuk Owner" dan dashboard admin/kasir).

    Penggunaan:
        @include('components.stat-card', [
            'icon'  => 'bi-cash-coin',
            'color' => 'success',
            'label' => 'Pendapatan Hari Ini',
            'value' => 'Rp ' . number_format($pendapatanHariIni, 0, ',', '.'),
        ])
--}}
<div class="col-sm-6 col-lg-3">
    <div class="card card-stat h-100">
        <div class="card-body d-flex align-items-center gap-3">
            <div class="stat-icon bg-{{ $color }}-subtle text-{{ $color }}">
                <i class="bi {{ $icon }}"></i>
            </div>
            <div>
                <div class="text-muted small">{{ $label }}</div>
                <div class="fs-5 fw-semibold">{{ $value }}</div>
            </div>
        </div>
    </div>
</div>
