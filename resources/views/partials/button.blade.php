@props(['variant' => 'primary', 'size' => 'md'])
@php
    $variants = [
        'primary' => 'bg-gradient-to-br from-forest-500 to-forest-700 text-moonlight-50 hover:from-forest-600 hover:to-forest-800',
        'secondary' => 'bg-forest-100 text-forest-700 hover:bg-forest-200',
        'danger' => 'bg-red-500 text-white hover:bg-red-600',
        'success' => 'bg-emerald-400 text-moonlight-50 hover:bg-emerald-500',
    ];
    
    $sizes = [
        'sm' => 'px-3 py-1.5 text-sm',
        'md' => 'px-4 py-2 text-sm',
        'lg' => 'px-6 py-3 text-base',
    ];
@endphp

<button {{ $attributes->merge(['class' => "rounded-xl font-semibold transition-all shadow-md hover:shadow-lg {$variants[$variant]} {$sizes[$size]}"]) }}>
    {{ $slot }}
</button>