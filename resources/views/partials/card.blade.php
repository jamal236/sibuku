@props(['class' => '', 'hover' => true])
<div {{ $attributes->merge(['class' => "card {$hover ? 'card-hover' : ''} rounded-2xl p-6 {$class}"]) }}>
    {{ $slot }}
</div>