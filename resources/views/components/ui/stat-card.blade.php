@props([
    'label',
    'value',
    'icon' => null,
    'trend' => null,
    'trendDirection' => 'up',
    'color' => 'green',
    'href' => null,
])

@php
    $iconClasses = match ($color) {
        'green' => 'bg-gradient-to-br from-[#22C55E] to-[#15803D] text-[#052E16]',
        'blue' => 'bg-gradient-to-br from-[#3B82F6] to-[#1D4ED8] text-white',
        'purple' => 'bg-gradient-to-br from-[#A855F7] to-[#7E22CE] text-white',
        'yellow' => 'bg-gradient-to-br from-[#F59E0B] to-[#B45309] text-[#451A03]',
        'red' => 'bg-gradient-to-br from-[#F43F5E] to-[#BE123C] text-white',
        'cyan' => 'bg-gradient-to-br from-[#06B6D4] to-[#0E7490] text-white',
        'gray' => 'bg-[#27272A] text-[#A1A1AA]',
        default => 'bg-gradient-to-br from-[#22C55E] to-[#15803D] text-[#052E16]',
    };
    $trendClasses = match (true) {
        $trendDirection === 'up' => 'text-[#22C55E] bg-[rgba(34,197,94,0.08)] border-[rgba(34,197,94,0.18)]',
        $trendDirection === 'down' => 'text-[#F43F5E] bg-[rgba(244,63,94,0.08)] border-[rgba(244,63,94,0.18)]',
        default => 'text-[#A1A1AA] bg-[#1A1A1F] border-[#27272A]',
    };
    $trendIcon = match ($trendDirection) {
        'up' => 'trending-up',
        'down' => 'trending-down',
        default => 'minus',
    };
    $accentBar = match ($color) {
        'green' => 'from-[#22C55E] to-transparent',
        'blue' => 'from-[#3B82F6] to-transparent',
        'purple' => 'from-[#A855F7] to-transparent',
        'yellow' => 'from-[#F59E0B] to-transparent',
        'red' => 'from-[#F43F5E] to-transparent',
        'cyan' => 'from-[#06B6D4] to-transparent',
        default => 'from-[#22C55E] to-transparent',
    };
    $tag = $href ? 'a' : 'div';
@endphp

<{{ $tag }} @if($href) href="{{ $href }}" @endif {{ $attributes->merge(['class' => 'card card-hover relative overflow-hidden group']) }}>
    <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r {{ $accentBar }} opacity-50 group-hover:opacity-100 transition-opacity"></div>
    <div class="absolute -right-12 -top-12 w-32 h-32 bg-gradient-radial opacity-20 group-hover:opacity-30 transition-opacity pointer-events-none"
         style="background: radial-gradient(circle, currentColor 0%, transparent 70%);"></div>

    <div class="relative p-5">
        <div class="flex items-start justify-between gap-3 mb-3">
            <div class="flex-1 min-w-0">
                <p class="text-[11px] font-semibold text-[#71717A] uppercase tracking-wider">{{ $label }}</p>
            </div>
            @if($icon)
                <div class="icon-box icon-box-md {{ $iconClasses }}">
                    <i data-lucide="{{ $icon }}" class="w-4 h-4"></i>
                </div>
            @endif
        </div>

        <p class="text-2xl font-bold text-white tracking-tight">{{ $value }}</p>

        @if($trend)
            <div class="mt-3 flex items-center gap-2">
                <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded text-[11px] font-semibold border {{ $trendClasses }}">
                    <i data-lucide="{{ $trendIcon }}" class="w-3 h-3"></i>
                    {{ $trend }}
                </span>
                @if(isset($trendLabel))
                    <span class="text-[11px] text-[#71717A]">{{ $trendLabel }}</span>
                @else
                    <span class="text-[11px] text-[#71717A]">vs mês anterior</span>
                @endif
            </div>
        @endif
    </div>
</{{ $tag }}>
