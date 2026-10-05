@props([
    'variant' => 'success',
    'icon' => null,
    'size' => 'md',
])

@php
    $classes = match ($variant) {
        'success' => 'badge-success',
        'warning' => 'badge-warning',
        'danger' => 'badge-danger',
        'info' => 'badge-info',
        'purple' => 'badge-purple',
        default => 'badge-neutral',
    };
    $defaultIcon = match ($variant) {
        'success' => 'check-circle-2',
        'warning' => 'alert-triangle',
        'danger' => 'x-circle',
        'info' => 'info',
        'purple' => 'sparkles',
        default => 'circle',
    };
    $sizeClasses = $size === 'sm' ? 'text-[10px] px-1.5 py-0.5' : '';
@endphp

<span {{ $attributes->merge(['class' => "badge {$classes} {$sizeClasses}"]) }}>
    @if($icon ?? $defaultIcon)
        <i data-lucide="{{ $icon ?? $defaultIcon }}" class="w-3 h-3"></i>
    @endif
    {{ $slot }}
</span>
