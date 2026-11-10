{{--
    components/alert.blade.php

    Komponen alert dismissible untuk flash messages (session('success'),
    session('error'), session('info')).

    Penggunaan:
        @includeWhen(session('success'), 'components.alert', [
            'type' => 'success', 'message' => session('success')
        ])
--}}
@php
    $icon = match ($type) {
        'success' => 'bi-check-circle',
        'danger'  => 'bi-x-circle',
        'warning' => 'bi-exclamation-triangle',
        default   => 'bi-info-circle',
    };
@endphp

<div class="alert alert-{{ $type }} alert-dismissible fade show d-flex align-items-start gap-2" role="alert">
    <i class="bi {{ $icon }} fs-5 mt-1"></i>
    <div class="flex-grow-1">{{ $message }}</div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
</div>
