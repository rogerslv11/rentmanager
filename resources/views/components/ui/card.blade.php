@props([
    'title' => null,
    'description' => null,
    'icon' => null,
    'padding' => true,
    'hover' => false,
])

@php
    $baseClasses = $hover ? 'card card-hover overflow-hidden' : 'card overflow-hidden';
@endphp

<div {{ $attributes->merge(['class' => $baseClasses]) }}>
    @if($title || $description || $icon || isset($actions))
        <div class="flex items-center justify-between px-5 py-4 border-b border-[#1F1F23]">
            <div class="flex items-center gap-3 min-w-0">
                @if($icon)
                    <div class="icon-box icon-box-md bg-gradient-to-br from-[#22C55E] to-[#15803D] text-[#052E16] flex-shrink-0">
                        <i data-lucide="{{ $icon }}" class="w-4 h-4"></i>
                    </div>
                @endif
                <div class="min-w-0">
                    @if($title)
                        <h3 class="text-sm font-semibold text-white truncate">{{ $title }}</h3>
                    @endif
                    @if($description)
                        <p class="text-xs text-[#71717A] mt-0.5 truncate">{{ $description }}</p>
                    @endif
                </div>
            </div>
            @if(isset($actions))
                <div class="flex items-center gap-2 flex-shrink-0 ml-3">{{ $actions }}</div>
            @endif
        </div>
    @endif
    <div class="{{ $padding ? 'p-5' : '' }}">
        {{ $slot }}
    </div>
</div>
