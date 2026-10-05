@props([
    'title' => null,
    'description' => null,
    'icon' => 'inbox',
    'padding' => 'py-16',
])

<div {{ $attributes->merge(['class' => "text-center {$padding}"]) }}>
    <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-br from-[#1A1A1F] to-[#0F0F12] border border-[#27272A] mb-5 shadow-inner">
        <i data-lucide="{{ $icon }}" class="w-7 h-7 text-[#52525B]"></i>
    </div>
    @if($title)
        <h3 class="text-base font-semibold text-white">{{ $title }}</h3>
    @endif
    @if($description)
        <p class="mt-1.5 text-sm text-[#71717A] max-w-sm mx-auto">{{ $description }}</p>
    @endif
    @if(isset($action))
        <div class="mt-5">{{ $action }}</div>
    @endif
</div>
